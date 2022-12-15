<?php

require_once('./components/connect.php');

$sql = "DELETE FROM todo";
$stmt = $db->prepare($sql);

$stmt->execute();

header("location:index.php");
