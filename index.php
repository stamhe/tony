<?php
header("Content-type: text/html; charset=utf-8");
$start = microtime(true);
//define("APP_PATH", dirname(__FILE__));
define("APP_PATH", __DIR__);
require_once APP_PATH . '/const.php';
require_once APP_PATH . '/DriverPdo.class.php';

try {
    $db = DriverPdo::getInstance();
    $sql = sprintf("SELECT * FROM `%smembers` ORDER BY `uid` ASC LIMIT 10", PRIMARY_DBPREFIX);
    $rows = $db->fetchAll($sql);
    echo '<pre>';
    print_r($rows);
} catch (Exception $e) {
    echo $e->getMessage();
    exit;
}



