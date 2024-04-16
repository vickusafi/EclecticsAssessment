<?php

namespace app\models\loans;

use Yii;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\data\ActiveDataProvider;

//models 
use app\models\User;


class Loans extends ActiveRecord
{
    public $interest_rate;

    public function rules()
    {
        return [
            ['loan_type_id', 'required', 'message' => 'Please Select a loan type', 'on' => 'add'],
            ['loan_type_id', 'filter', 'filter' => 'trim', 'on' => 'add'],
            ['loan_type_id', 'integer', 'on' => 'add'],
            ['loan_type_id', 'exist', 'targetClass' => 'app\models\loans\LoanTypes', 'targetAttribute' => ['loan_type_id' => 'id'], 'message' => 'Selected loan type Doesnt Exist', 'on' => 'add'],

            // //update rules  
            ['amount', 'required', 'message' => 'Please provide a loan amount', 'on' => 'add'],
            ['amount', 'filter', 'filter' => 'trim', 'on' => 'add'],
            ['amount', 'filter', 'filter' => function ($value) {
                return str_replace('  ', ' ', $value);
            }, 'skipOnArray' => true, 'on' => 'add'],


            //search rules
            ['user_id', 'string', 'skipOnEmpty' => true, 'on' => 'search'],
            // ['full_name', 'string', 'skipOnEmpty' => true, 'on' => 'search'],
            // ['mobile_number', 'string', 'skipOnEmpty' => true, 'on' => 'search'],
            // ['call_extension', 'string', 'skipOnEmpty' => true, 'on' => 'search'],
            // ['supervisor_email', 'string', 'skipOnEmpty' => true, 'on' => 'search'],
            // ['dept_email', 'string', 'skipOnEmpty' => true, 'on' => 'search'],
            // ['status', 'string', 'skipOnEmpty' => true, 'on' => 'search'],
            // ['status', 'in', 'range' => ['active', 'suspended'], 'skipOnEmpty' => true, 'on' => 'search'],



        ];
    }
    public static function tableName()
    {
        return 'loan_application';
    }

    //relations with other models 
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getLoanType()
    {
        return $this->hasOne(LoanTypes::className(), ['id' => 'loan_type_id']);
    }




    public function search()
    {
        //we can add conditions here in the query for the list
        $query = Loans::find()->joinWith('user')->joinWith('loanType')->where(['user_id' => Yii::$app->user->identity->id]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]],
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        // grid filtering conditions
        $query->andFilterWhere([
            'departments.status' => $this->status,
        ]);
        // grid filtering conditions
        return $dataProvider;
    }


    //add department 
    public function applyForLoan()
    {
        $model = new Loans();
        $model->user_id = Yii::$app->user->identity->id;
        $model->loan_type_id = $this->loan_type_id;
        $model->amount = $this->amount;
        if ($model->save()) {
            return true;
        }
        return false;
    }

    //calculate total loan to be paid assuming interest compounds every month
    public function calculateTotalLoanAmountToBePaid($loaned_amount, $annual_interest_rate)
    {
        $monthly_interest_rate = $annual_interest_rate / 100 / 12;

        // Calculate total amount after one year with compound interest
        $total_amount = $loaned_amount * pow(1 + $monthly_interest_rate, 12);

        return $total_amount;
    }


    //check loan limit based on savings
    public function checkLoanLimitWithSavings($desiredLoanAmount, $loanLimitMultiplier = 3)
    {
        $savings = 100000;
        $income = 50000;
        $existingLiabilities = 20000;
        $loanLimit = $income * $loanLimitMultiplier;
        $totalLiabilities = $existingLiabilities + $desiredLoanAmount;

        $availableFunds = $income - $totalLiabilities + $savings;

        if ($desiredLoanAmount > $availableFunds) {
            return false;
        }

        if ($totalLiabilities > $loanLimit) {
            return false;
        }

        return true;
    }


    //total laon per user 
    public function getTotalLoansForAuser()
    {
        $query = Yii::$app->db->createCommand("
                                  SELECT
                                      SUM(amount) as amount_loaned
                                   FROM
                                        loan_application
                                  WHERE
                                      status = 1
                                    AND 
                                        user_id = :user_id
                            
                   ")->bindValue(':user_id', Yii::$app->user->identity->id)->queryAll();
        if (!empty($query)) {
            return $query[0]['amount_loaned'];
        }
        return "0.00";
    }
}
