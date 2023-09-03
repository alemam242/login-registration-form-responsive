<?php
$data = "12345678";

$data = password_hash($data, PASSWORD_BCRYPT);

$pass = password_hash($data, PASSWORD_BCRYPT);

echo $data . "\n" . $pass . "\n";
