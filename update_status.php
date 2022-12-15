<?php

require_once('./components/connect.php');

$status = ($_GET['done'] + 1)%2;
$sql = "UPDATE todo SET done = ? WHERE id = ?";
$stmt = $db->prepare($sql);

$stmt->bindValue(1, $status);
$stmt->bindValue(2, $_GET['id']);
$stmt->execute();

header("location:index.php");
