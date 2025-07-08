<?php
namespace App\Helpers;


class Grafik{

    public static function get_grafik ($data) {

        $count = [];
        $resultArr = [];

        foreach ($data as $key => $value) {
            $count[(int)$key] = count($value);
        }

        $month = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

        for ($i = 1; $i <= 12; $i++) {
            if (!empty($count[$i])) {
                $resultArr[$month[$i - 1]] = $count[$i];
            } else {
                $resultArr[$month[$i - 1]] = 0;
            }
        }

        return $resultArr;
    }



}