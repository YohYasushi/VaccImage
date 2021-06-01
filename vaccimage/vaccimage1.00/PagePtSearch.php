<?php require dirname(__FILE__) . '/files/header.php';?>


<h1>患者検索</h1>

<form action="ptSearch.php" method="post" target="_blank">

<table>
<tr>
<td>ID</td>
<td><input type="number" name="ptid_s"></td>
</tr>

<tr>
<td>苗字</td>
<td><input type="text" name="last_name_s"></td>
</tr>

<tr>
<td>名前</td>
<td><input type="text" name="first_name_s"></td>
</tr>

<tr>
<td>誕生日</td>
<td><input type="date" name="birthday_s"></td>
</tr>

<tr>
<td>種別・所属部署</td>
<td><select name="department_s">

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
<td></td>
<td><input type="submit" value="検索"><input type="reset" value="クリア"></td>
</tr>


</table>
</form>

<div class="annotation">すべて空欄にしたら全患者の検索が可能ですが、サーバーへの負担が増えますので控えてください。</div>

<?php require dirname(__FILE__) . '/files/footer.php';?>