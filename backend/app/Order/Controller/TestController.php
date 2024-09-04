<?php

namespace App\Order\Controller;

use App\Http\Controllers\Controller;


class TestController extends Controller
{

    /**
     * 反转32位整数
     * @param $num
     * @return float|int
     */
    public function test1($num = -2147483641)
    {
        $max   = 2147483647;
        $min   = -2147483648;
        $gewei = $max % 10;

        $fuhao = $num < 0 ? -1 : 1;
        $res   = 0;
        $num   = abs($num);

        while ($num != 0) {
            $pop = $num % 10;
            $num = (int)($num / 10);


            if ($res > (int)($max / 10) || ($res == (int)($min / 10) && $pop > $gewei)) {
                return 0;
            }

            $res = $res * 10 + $pop;
        }

        $res = $fuhao * $res;

        if ($res < $min || $res > $max) {
            return 0;
        }

        return $res;
    }

    /**
     * 找出和为指定数字的下标
     * @return array
     */
    public function test2()
    {
        $nums   = [2, 4, 4, 3];
        $target = 6;


        $map = [];
        foreach ($nums as $index => $num) {
            $complement = $target - $num;
            if (isset($map[$complement])) {
                return [$map[$complement], $index];
            }

            $map[$num] = $index;
        }

        return [];
    }

    public function test3()
    {
        $s   = "   -115579378e25";
        $s = trim($s);

        if(empty($s)){
            return 0;
        }

        if($s[0] == '-'){
            $sgin = -1;
            $s = substr($s,1);
        }else if($s[0] == '+'){
            $sgin = 1;
            $s = substr($s,1);
        }else{
            $sgin  = 1;
        }

        if(!is_numeric($s[0])){
            return 0;
        }

        $strlen = strlen($s);

        $strRes = '';
        for($i=0;$i<$strlen;$i++){
            if(is_numeric($s[$i])){
                $strRes.=$s[$i];
            }else{
                break;
            }
        }

        $s = intval($strRes) * $sgin;
        if($s>2147483647){
            return 2147483647;
        }else if($s < -2147483648){
            return -2147483648;
        }
        return $s;
    }
}
