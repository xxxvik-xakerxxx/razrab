<?php
if(!isset($Functions)){
    die("Error! 404");
}
if(!empty($_REQUEST['MERCHANT_ORDER_ID'])){
    $Functions->redirect('/error');
}
    $items = $Functions->db->query("SELECT * FROM `drops`");
		$totalcase = 0;
		while($drop = $items->fetch_object()){
			$totalcase++;}

	  $sqr = $Functions->db->query("SELECT * FROM `users`");
	  $totaluser = 0;
	  while($row = $sqr->fetch_object()){
	  $totaluser++;}

    session_start();
    $id = session_id();

if ($id!="") {
 //текущее время
 $CurrentTime = time();
 //через какое время сессии удаляются
 $LastTime = time() - 60;
 //файл, в котором храним идентификаторы и время
 $base = "base.dat";

     $file = file($base);
     $k = 0;
     for ($i = 0; $i < sizeof($file); $i++) {
      $line = explode("|", $file[$i]);
       if ($line[1] > $LastTime) {
       $ResFile[$k] = $file[$i];
       $k++;
      }
     }

     for ($i = 0; $i<sizeof($ResFile); $i++) {
      $line = explode("|", $ResFile[$i]);
      if ($line[0]==$id) {
          $line[1] = trim($CurrentTime)."\n";
          $is_sid_in_file = 1;
      }
      $line = implode("|", $line); $ResFile[$i] = $line;
     }

     $fp = fopen($base, "w");
     for ($i = 0; $i<sizeof($ResFile); $i++) { fputs($fp, $ResFile[$i]); }
     fclose($fp);

     if (!$is_sid_in_file) {
      $fp = fopen($base, "a-");
      $line = $id."|".$CurrentTime."\n";
      fputs($fp, $line);
      fclose($fp);
     }
    }
echo $Functions->getIndex("payment_message", ['from' => ['{message}', '{total_case}', '{total_users}', '{online_people}'], 'to' => ['<div class="alert bg-danger" role="alert" style="margin-top: 10px;"><span class="glyphicon glyphicon-exclamation-sign"><center><b></span><body><p style="font-size:22px">Ошибка во время оплаты</body></div></b></center>', $totalcase, $totaluser, sizeof(file($base))]]);

?>