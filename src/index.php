<?php
/**
 * Created by PhpStorm.
 * User: vittorio
 * Date: 19/03/18
 * Time: 18:31
 */

echo "<h1>It works!</h1><pre>";

$db = new PDO('pgsql:dbname=database;host=db;port=5432;user=root;password=supersafepassword');

$result = $db->query("SELECT * FROM users");

print_r($result->fetch());