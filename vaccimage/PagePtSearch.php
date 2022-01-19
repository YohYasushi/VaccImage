<?php require dirname(__FILE__) . '/files/header.php';?>
<?php require_once dirname(__FILE__) . '/files/mariadbconnect.php';?>
<?php require_once dirname(__FILE__) . '/files/funcUtils.php';?>
<h1>患者検索</h1>

<form action="subPtSearch.php" method="post" target="_blank">

<table>
<tr>
<td>ID</td>
<td><input type="text" name="ptid"></td>
</tr>

<tr>
<td>苗字</td>
<td><input type="text" name="last_name"></td>
</tr>

<tr>
<td>名前</td> 
<td><input type="text" name="first_name"></td>
</tr>


<tr>
<td>種別</td>
<td>
<select name="ptype_symbol">
<option value=""></option>

<?php
funcListMake('SELECT * FROM persontypes;', 'ptype_symbol', 'ptype_name' );
?>
</select>
</td>
</tr>

<tr>
<td>所属部署</td>
<td><select name="dpts_symbol">
<option value=""></option>

<?php
funcListMake('SELECT * FROM departments;', 'dpts_symbol', 'dpts_name');
?>
</select>
</td>
</tr>

<tr>
<td></td>
<td><input type="submit" value="送信"><input type="reset" value="クリア"></td>
</tr>

</table>
</form>

<div class="annotation">全出力はできません。</div>



<?php require dirname(__FILE__) . '/files/footer.php';?>


