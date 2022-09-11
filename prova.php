<?php
ob_start();
require_once('./controller/db_connect.php');

use crudframework\Db_control;
$dbc = new Db_control();
$id=$dbc->unique_id();

var_dump($id);
