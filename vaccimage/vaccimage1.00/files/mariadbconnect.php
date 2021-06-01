
<?php
function getDb() {
  $dsn = 'mysql:dbname=vaccimage; host=localhost; charset=utf8';
  $usr = 'root';
  $passwd = '';

    $db = new PDO($dsn, $usr, $passwd);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
  return $db;
}

//あえてパスワードをかましていないので要注意