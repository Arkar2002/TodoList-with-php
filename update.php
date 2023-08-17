<?php

require_once "db_connection.php";

$db = new DB();

$db->update($_POST);
