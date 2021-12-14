<?php require dirname(__FILE__) . '/files/header.php';?>


<h1>接種オーダー検索画面</h1>

<form action="ptOrderSearch.php" method="post" target="_blank">
<table>
<tr>
<td>検索開始日付</td>
<td><input type="date" name="vaccdateA_os"></td>
</tr>
<tr>
<td>検索終了日付</td>
<td><input type="date" name="vaccdateB_os"></td>
</tr>

<tr>
<td>ワクチン大人</td>
<td><select name="vaccadlt_os">
<option value=""></option>
<option value="インフル大人">インフル大人</option>
<option value="ファイザー大人">ファイザー大人</option>
<option value="モデルナ大人">モデルナ大人</option>
</optgroup>
</select></td>
</tr>
<tr>
<td>ワクチン小人</td>
<td><select name="vaccchld_os">
<option value=""></option>
<option value="インフル小人">インフル小人</option>
<option value="ファイザー小人">ファイザー小人</option>
<option value="モデルナ小人">モデルナ小人</option>
</optgroup>
</select></td>
</tr>

<tr>
<td>接種状況</td>
<td><select name="vaccevent_os">
<option value=""></option>
<option value="接種済">接種済</option>
<option value="未接種・予約">未接種・予約</option>
</select></td>
</tr>

<tr>
<td>ID</td>
<td><input type="number" name="ptid_os"></td>
</tr>

<tr>
<td>苗字</td>
<td><input type="text" name="last_name_os"></td>
</tr>

<tr>
<td>名前</td>
<td><input type="text" name="first_name_os"></td>
</tr>

<tr>
<td>種別・所属部署</td>
<td><select name="department_os">

<optgroup label="患者(職員家族含)">
<option value=""></option>
<option value="外来患者">外来患者</option>
<option value="入院患者">入院患者</option>
<option value="職員家族">職員家族</option>
</optgroup>
<optgroup label="職員">
<option value="外来・救急">外来・救急</option>
<option value="病棟">病棟</option>
<option value="医局">医局</option>
<option value="医事課">医事課</option>
</optgroup>

</select></td>
</tr>

<tr>
<td>メモ</td>
<td><input type="text" name="memo_os"></td>
</tr>

<tr>
<td></td>
<td><input type="submit" value="検索"><input type="reset" value="クリア"></td>
</tr>



</table>

</form>


<div class="annotation">1日だけ検索の場合は同日を入力してください。</div>
<div class="annotation">すべて空欄にしたら全接種歴の検索が可能ですが、サーバーへの負担が増えますので控えてください。</div>



<?php require dirname(__FILE__) . '/files/footer.php';?>