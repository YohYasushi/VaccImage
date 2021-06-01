<?php require dirname(__FILE__) . '/files/header.php';?>
<?php require_once dirname(__FILE__) . '/files/mariadbconnect.php';?>
<?php require_once dirname(__FILE__) . '/files/funcCountMember.php'; ?>
<?php require_once dirname(__FILE__) . '/files/funcCountVial.php'; ?>



<h1>インフルエンザワクチンの状況</h1>
<input type="button" value="画面更新" onClick="location.reload()">

<h2>バイアル数経過</h2>
<table>
<tr><th>日付</th><th>大人</th><th>小人</th><th>破棄バイアル</th><th>破棄バイアルで接種可能な大人</th><th>破棄分を含めた合計バイアル</th><th>合計バイアル数累積</th></tr>

<?php

$startDate = '2021-05-01';
$goalDate = '2021-06-30';   //【！修正箇所！】ここでカウント期間開始日と終了日つまり期間の指定をする(期間外のバイアル、接種者はいっさいカウントされません。)

$db = getDb();
$sql = "SELECT * FROM CountInfluenza WHERE ( vaccdate >= '$startDate' AND vaccdate <= '$goalDate' ) ORDER BY vaccdate ASC; ";  
    //【！修正箇所！】ここで引用するViewを指定してください。インフル: CountInfluenza、ファイザー: CountPFECOVID19、モデルナ: CountMRNACOVID19、アストラゼネカ: CountAZNCOVID19
$stt = $db->prepare($sql);
$stt->execute();

//ここで接種日と合計使用バイアルのテーブルと配列を作成する
foreach($stt as $row) {   
//【！修正箇所！】ここでrとnの設定
$r = 2; //ratio インフルなら投与量が大人:子供=2:1 なので r=2 です。
$n = 2; //1バイアルで接種可能な大人の人数　インフルは2人なのでn=2です。
//インフルエンザは1バイアルから大人2人、小人4人、で計算しております。関数をよくみてワクチン種によって変更を。

echo '<tr>';
echo '<td>', htmlspecialchars($row['vaccdate']) , '</td>'; //日付
echo '<td>', htmlspecialchars($row['sum(AdCount)']), '</td>'; //大人
$sumAd += $row['sum(AdCount)'];
echo '<td>', htmlspecialchars($row['sum(CdCount)']), '</td>'; //小人
$sumCd += $row['sum(CdCount)'];

$PrsnVial = ($r * $row['sum(AdCount)'] + $row['sum(CdCount)']) / ($r * $n) ; //人数からの直接の必要バイアル数計算

$sumVial += $PrsnVial ;
echo '<td>', CountVial($row['sum(AdCount)'], $row['sum(CdCount)'], $r, $n) -  $PrsnVial, '</td>'; //破棄するバイアル
$sumDisp += (CountVial($row['sum(AdCount)'], $row['sum(CdCount)'], $r, $n) -  $PrsnVial) ;
echo '<td>', CountMember($row['sum(AdCount)'], $row['sum(CdCount)'], $r, $n), '</td>'; //破棄バイアルで接種可能な大人
$sumPrsn += CountMember($row['sum(AdCount)'], $row['sum(CdCount)'], $r, $n);
echo '<td>', CountVial($row['sum(AdCount)'], $row['sum(CdCount)'], $r, $n), '</td>'; //破棄分含めた合計バイアル
$sumTotalVial +=  CountVial($row['sum(AdCount)'], $row['sum(CdCount)'], $r, $n); 
echo '<td>', $sumTotalVial, '</td>'; //合計バイアル数累積
echo '</tr>';

$arrayA[htmlspecialchars($row['vaccdate'])] = CountVial($row['sum(AdCount)'], $row['sum(CdCount)'], $r, $n);//接種日付とバイアル数の連想配列の作成
}
echo '<tr>';
echo '<td>', '合計' , '</td>';
echo '<td>', $sumAd , '</td>';
echo '<td>', $sumCd , '</td>';
echo '<td>', $sumDisp , '</td>';
echo '<td>', $sumPrsn , '</td>';
echo '<td>', $sumTotalVial , '</td>'; //合計を出力。
echo '</tr>';

//unset($sumAd, $sumCd, $sumVial, $sumDisp, $sumPrsn, $sumTotalVial);

?>
</table>

<?php
//期間の範囲の日付の配列を作る。
$count =  (strtotime($goalDate) - strtotime($startDate))/86400;  //日差を算出し代入

for ($i = 0; $i <= $count; $i++){
    $arrayDates[] = date('Y-m-d', strtotime($startDate) + 86400 * $i);
}

//上記配列の日付が逐一接種がある日かどうか判断し、使用したバイアルと合わせた相関配列を作る
for ($i = 0; $i <= $count; $i++){

if($arrayA[$arrayDates[$i]] == NULL){
    $arrayDateVial[$arrayDates[$i]] = 0;  //接種のない日の使用バイアル数は0
}
else{
    $arrayDateVial[$arrayDates[$i]] = $arrayA[$arrayDates[$i]];  //接種日は使用バイアル数を入力
}
}

//さらにこの配列の累積の配列を作る
//接種イベントがない日でも累積使用バイアル数を知ることができるようになった。

for ($i = 0; $i <= $count; $i++){
    $arraySumDateVial[$arrayDates[$i]] = array_sum(array_slice($arrayDateVial, 0, ((strtotime($arrayDates[$i]) - strtotime($startDate))/86400)+1));
}


?>

<h2>バイアル入荷・払い出し経過(未来日含む)</h2>
<table>
<tr><th>修正日付</th><th>種別</th><th>修正バイアル数</th><th>入荷・払い出しの累積</th><th>メモ</th></tr>

<?php
//バイアル入荷・払い出しを表に出力する。
$db = getDb();
$sql = "SELECT * FROM CountInfluenzaV WHERE ( shuseidate >= '$startDate' AND shuseidate <= '$goalDate')  ORDER BY shuseidate ASC;"; 
//【！修正箇所！】ここで引用するViewを指定してください。インフル: CountInfluenzaV、ファイザー: CountPFECOVID19V、モデルナ: CountMRNACOVID19V、アストラゼネカ: CountAZNCOVID19V
$stt = $db->prepare($sql);
$stt->execute();
foreach($stt as $row)  {  

    echo '<tr>';
    echo '<td>', htmlspecialchars($row['shuseidate']) , '</td>';
    echo '<td>', htmlspecialchars($row['shuseievent']), '</td>';
    echo '<td>', htmlspecialchars($row['shuseicount']), '</td>';
    $sumShusei += htmlspecialchars($row['shuseicount']);
    echo '<td>', $sumShusei, '</td>'; //累積
    echo '<td>', htmlspecialchars($row['shuseimemo']), '</td>';
    echo '</tr>';
    $arrayB[htmlspecialchars($row['shuseidate'])] = htmlspecialchars($row['shuseicount']);//日付とバイアル入荷数の連想配列の作成

  }
echo '<td>', '合計' , '</td>';
echo '<td>', '' , '</td>';
echo '<td>', $sumShusei, '</td>';

?>
</table>


<?php
//1日に複数回の入荷・払い出しイベントがあることを考慮し、新たなDB($arrayB)をSQL上で作成する
//それの累計から、日付配列に基づいた累積を求める。

$db = getDb();
$sql = "SELECT shuseidate, sum(shuseicount) FROM CountInfluenzaV WHERE ( shuseidate >= '$startDate' and shuseidate <= '$goalDate') GROUP BY shuseidate ORDER BY shuseidate ASC;";
//【！修正箇所！】ここで引用するViewを指定してください。インフル: CountInfluenzaV、ファイザー: CountPFECOVID19V、モデルナ: CountMRNACOVID19V、アストラゼネカ: CountAZNCOVID19V
$stt = $db->prepare($sql);
$stt->execute();
foreach($stt as $row)  {  

   $arrayB[htmlspecialchars($row['shuseidate'])] = htmlspecialchars($row['sum(shuseicount)']);//日付と各日付ごとのバイアル入荷数の連想配列の作成(1日複数回イベントを計算したもの)

}


//上記配列の日付が逐一、入荷・払い出しイベントがある日かどうか判断し、使用したバイアルと合わせた相関配列を作る
for ($i = 0; $i <= $count; $i++){
if($arrayB[$arrayDates[$i]] == NULL){
    $arrayDateShusei[$arrayDates[$i]] = 0;  //接種のない日の使用バイアル数は0
}
else{
    $arrayDateShusei[$arrayDates[$i]] = $arrayB[$arrayDates[$i]];  //接種日は使用バイアル数を入力
}
}

//さらにこの配列の累積の配列を作る
//接種イベントがない日でも累積使用バイアル数を知ることができるようになった。

for ($i = 0; $i <= $count; $i++){
    $arraySumDateShusei[$arrayDates[$i]] = array_sum(array_slice($arrayDateShusei, 0, ((strtotime($arrayDates[$i]) - strtotime($startDate))/86400)+1));
}

?>


<h2>まとめ</h2>
<table>
<tr><th>日付</th><th>破棄分を含めた合計バイアル累積</th><th>入荷数・累積</th><th>余るバイアル数(マイナスは不足のこと！)</th></tr>
<?php

echo '<div class="annotation">', 'バイアル数の集計は',  htmlspecialchars($startDate), 'から', htmlspecialchars($goalDate) ,'でカウントしております。', '</div>';

//必要バイアル数と入荷数の比較のテーブル    
for ($i = 0; $i <= $count; $i++){

    echo '<tr>';
    echo '<td>', htmlspecialchars($arrayDates[$i]), '</td>';
    echo '<td>', htmlspecialchars($arraySumDateVial[$arrayDates[$i]]), '</td>';
    echo '<td>', htmlspecialchars($arraySumDateShusei[$arrayDates[$i]]), '</td>';
    echo '<td>', htmlspecialchars($arraySumDateShusei[$arrayDates[$i]]) - htmlspecialchars($arraySumDateVial[$arrayDates[$i]]), '</td>';
    echo '</tr>';
}    


?>
</table>

<?php require dirname(__FILE__) . '/files/footer.php';?>
