<?php

/**
 * Created by PhpStorm.
 * User: Samuel
 * Date: 28/01/2017
 * Time: 11:51
 */
class Transform
{
    public function dateBr($date){
        return date('d/m/Y',strtotime($date));
    }
    public function dateHourBr($date){
        return date('d/m/y H:i:s',strtotime($date));
    }
    public function TextUpper($text){
        return trim(mb_strtoupper($text,'UTF-8'));
    }
    public function doubleInReal($value){
        return number_format($value,2,",",".");
    }
    function td($val, $id= ''){
        return print '<td id="'.$id.'">'.$val.'</td>';
    }
    function percent($total,$part){
        return round(($part * 100) / $total , 3);
    }

    function clearString($string){
        return preg_replace(array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/","/(Ç)/","/(ç)/"),explode(" ","a A e E i I o O u U n N C c"),$string);
    }
}