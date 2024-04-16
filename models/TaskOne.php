<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * TaskOne is the model behind the contact form.
 */
class TaskOne extends Model
{



    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [];
    }


    /* 
    get triplesum
    input : an array of integers and target sum
    output : sum of the combination
    combinations
    First loop from  0 to n-3 first loop 
    second loop $first + 1 to  n-2 second loop
    third loop from  $second + 1 to  n-1 third loop
    */
    public function tripletsSum($arr, $target_Sum)
    {
        $n = count($arr);
        $result = [];
        // Iterate over each possible combination of triplets
        for ($first = 0; $first < $n - 2; $first++) {
            for ($second = $first + 1; $second < $n - 1; $second++) {
                for ($third = $second + 1; $third < $n; $third++) {
                    // Check if the sum of the triplet equals the target sum
                    $sum = $arr[$first] + $arr[$second] + $arr[$third];
                    if ($sum === $target_Sum) {
                        // Found a triplet that sums up to the target sum
                        $result[] = [$arr[$first], $arr[$second], $arr[$third]];
                    }
                }
            }
        }
        return $result;
    }
}
