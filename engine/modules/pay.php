<?php
if(!isset($Functions)){
    die("Error! 404");
}

$user = $Functions->getUser();
$amount = $_POST['money'];

if((int)$amount < 1){
    $amount = 99;
}

$Functions->db->query("INSERT INTO `payments`(`amount`, `user`, `time`, `status`) VALUES ('".(int)$amount."', '".$user->steamid."', '".time()."', '0')");

$orderID = $Functions->db->insert_id;

$sign = md5($Functions->config['merchant_id'].':'.$amount.':'.$Functions->config['merchant_secret_1'].':'.$orderID);

$url = 'http://www.free-kassa.ru/merchant/cash.php?m='.$Functions->config['merchant_id'].'&oa='.$amount.'&o='.$orderID.'&s='.$sign.'&lang=ru';

$Functions->redirect($url);

?>
