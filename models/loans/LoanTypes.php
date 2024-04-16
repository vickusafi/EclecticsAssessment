<?php

namespace app\models\loans;

use Yii;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\data\ActiveDataProvider;

//models 
use app\models\User;


class LoanTypes extends ActiveRecord
{

    public function rules()
    {
        return [];
    }
    public static function tableName()
    {
        return 'loan_types';
    }

    //get loan types 
    public function getLoanTypes()
    {
        $query = Yii::$app->db->createCommand("
                                  SELECT
                                      id,
                                      name
                                   FROM
                                      loan_types
                                  WHERE
                                      status = 1
                   ")->queryAll();
        if (!empty($query)) {
            return $query;
        }
        return [];
    }
}
