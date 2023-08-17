<?php

require_once "db_connection.php";

$db = new DB();

$db->destory($_GET["id"]);
