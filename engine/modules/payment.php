<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once("$root/engine/functions.php");

if(!in_array($Functions->getIP(), array('136.243.38.147', '136.243.38.149', '136.243.38.150', '136.243.38.151', '136.243.38.189'))){
    $Functions->db->query("INSERT INTO `pay`(`error`, `user`, `amount`, `payment_id`) VALUES ('Ip nneatbilst', '1', '1', '0')");
  die("Ip nneatbilst");
}

$sign = md5($Functions->config['merchant_id'].':'.$_POST['AMOUNT'].':'.$Functions->config['merchant_secret_2'].':'.$_POST['MERCHANT_ORDER_ID']);
if($sign != $_POST['SIGN']){
    $Functions->db->query("INSERT INTO `pay`(`error`, `user`, `amount`, `payment_id`) VALUES ('Signi neatbilst', '1', '1', '0')");
  die("Signi neatbilst");
}

$payment = $Functions->db->query("SELECT * FROM payments WHERE id = '".(int)$_POST['MERCHANT_ORDER_ID']."'");
if($payment->num_rows == 0){
    die("Neatrada bd");
}else{
    $payment = $payment->fetch_object();
    if($payment->status != 0){
        die("Status nav 0");
    }else{
        if($payment->amount != $_POST['AMOUNT']){
            die("Summa neatbilst");
        }else{
            $Functions->db->query("UPDATE payments SET status = '1' WHERE id = '".$payment->id."'");
            $user = $Functions->db->query("SELECT * FROM users WHERE steamid = '".$payment->user."'")->fetch_object();
            $Functions->giveMoney($user->steamid, $payment->amount);
            echo 'success';
        }
    }
}

?>
