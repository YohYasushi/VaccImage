<?php
//破棄するバイアルで接種可能な大人の人数

function CountMember(float $NA, float $NC, float $r, float $n): string
{
$x = bcadd(   bcmul($r, $NA, 5), $NC, 3);
$y = bcmul($n, $r, 3); 
$z = bcmod($x, $y ,3);
return  bcdiv(bcmod(bcsub($y, $z, 3), $y, 3), $r, 1); //ここだけ下一桁にしてまるめている自動的に
  }
