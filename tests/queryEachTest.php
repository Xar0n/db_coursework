<?php
require __DIR__ . '/../autoload.php';
use App\DB;

$db = new DB();
$sql = 'SELECT * FROM ' . 'articles';
foreach ($db->queryEach($sql, [], '\App\Models\Article') as $item) {
    debug($item);
}