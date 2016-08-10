<?php

$pdo = new PDO("sqlite:".__DIR__.'EssentialSQL.db');
$res = $pdo->query("SELECT name FROM sqlite_master WHERE type='table' "
                       . 'UNION ALL SELECT name FROM sqlite_temp_master '
                       . "WHERE type='table' ORDER BY name;");

print_R($res->fetchAll());
