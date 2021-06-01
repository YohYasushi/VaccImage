<?php 
class GetAge {

  public $birthday;

    public static function ageCalc(string $birthday): int {
      $birthdayint = intval(str_replace("-", "", $birthday));
      return floor((date("Ymd") - $birthdayint)/10000);

  }
}

//年齢計算のクラス定義。法令には則っていない。
//結局、使っていない。
