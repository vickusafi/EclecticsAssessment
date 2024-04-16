<?php

namespace app\models\loans;

use Yii;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\data\ActiveDataProvider;

//models 
use app\models\User;


class LoanPayment extends ActiveRecord
{

    public function rules()
    {
        return [];
    }
    public static function tableName()
    {
        return 'loan_payment';
    }

    //get loan types 
    public function getTotalLoanPaid($loan_id)
    {
        $query = Yii::$app->db->createCommand("
                                  SELECT
                                      SUM(amount_paid) as amount_paid
                                   FROM
                                        loan_payment
                                  WHERE
                                      status = 1
                                    AND 
                                        user_id = :user_id
                                    AND 
                                        loan_id =:loan_id
                   ")->bindValue(':user_id', Yii::$app->user->identity->id)->bindValue(':loan_id', $loan_id)->queryAll();
        if (!empty($query)) {
            return $query[0]['amount_paid'];
        }
        return "0.00";
    }

    //get loan balance 
    public function loanBalance($loan_id)
    {
        $model = Loans::find()->where(['id' => $loan_id])->limit(1)->one();
        if (!empty($model)) {
            //get total paid 
            $total_paid = self::getTotalLoanPaid($model->id);

            //calculate the actual balance
            $balance = $model->amount - $total_paid;
            return $balance;
        }
    }
}
