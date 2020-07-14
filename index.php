<?php
$getdata = $_REQUEST;
if (empty($getdata)) $getdata = $_POST ? $_POST : $_GET;
if (empty($getdata['sn']) || empty($getdata['code'])) {
    header("content-Type: text/html; charset=utf-8");
    echo '快递100查询';
    return;
}
error_reporting("E_ALL");
ini_set("display_errors", 1);
header("content-Type: application/json; charset=utf-8");
require_once("include/function.php");
require_once("include/Kuaidi100.class.php");
$postdata = array_map('htmlspecialchars', $getdata);
$key = getenv('KEY');
if (empty($postdata['sn']) || empty($postdata['code'] || empty($postdata['key'])))
    $result = array('status' => 0, 'info' => '参数错误');
else if (strlen($key) && $postdata['key'] != $key) {
    $result = array('status' => 0, 'info' => 'key错误');
} else {
    $kd = new Kuaidi100();
    $result = $kd->search($postdata);
}
ajaxReturn($result);
