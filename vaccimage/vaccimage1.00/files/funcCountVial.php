<?php

//破棄するバイアルを考慮した合計必要バイアル数を計算するｗ

function CountVial(float $NA, float $NC, float $r, float $n): string
{

$totalVial = bcdiv(bcadd(bcmul($r, $NA, 3), $NC), bcmul ($r, $n, 3) , 3);

$residueVial = bcsub($totalVial , intval($totalVial), 3);

if (bccomp($residueVial, 0, 3) === 0 )
{ 
    $answer = intval($totalVial);
}
else
{
    $answer = intval($totalVial) + 1.000;
}
  return $answer;
}


//小数点以下3桁目までの根拠はない。