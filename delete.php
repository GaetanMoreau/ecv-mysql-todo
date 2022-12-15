<?php

require_once('./components/connect.php');

$sql = "DELETE FROM todo WHERE id = ?";
$stmt = $db->prepare($sql);

$stmt->bindValue(1, $_GET['id']);
$stmt->execute();

header("location:index.php");
