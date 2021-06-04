<?php require dirname(__FILE__) . '/files/header.php';?>



<h1>バイアル数修正・入荷登録</h1>

<form action="ptCountRegistry.php" method="post" target="_blank">

<table>

<tr>
<td>修正日付</td>
<td><input type="date" name="shuseidate"></td>
</tr>

<tr>
<td>ワクチン種別</td>
<td><select name="shuseitype">
<option value="インフルエンザ">インフルエンザ</option>
<option value="ファイザーコロナ">ファイザーコロナ</option>
<option value="モデルナコロナ">モデルナコロナ</option>
</select></td>
</tr>

<tr>
<td>内容</td>
<td><select name="shuseievent">
<option value="入荷">入荷</option>
<option value="数合わせ">数合わせ</option>
<option value="払い出し">払い出し</option>
</select></td>
</tr>




<tr>
<td>修正バイアル数</td>
<td><input type="number" name="shuseicount"></td>
</tr>

<tr>
<td>メモ</td>
<td><textarea name="shuseimemo" rows="3" cols="30"></textarea></td>
</tr>



<tr>
<td></td>
<td><input type="submit" value="送信"><input type="reset" value="クリア"></td>
</tr>

</table>
</form>

<div class="annotation">入荷予定も入力してください。バイアルが減るときはマイナスで入力してください。</div>


<?php require dirname(__FILE__) . '/files/footer.php';?>