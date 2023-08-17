<?php

require_once "db_connection.php";

$db = new DB();

$db->done($_GET);
