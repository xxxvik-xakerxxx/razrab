<?php
if(!isset($Functions)){
    die("Error! 404");
}
$user = $Functions->getUser();

$top_three = ['count' => 0, 'text2' => []];
$sql = $Functions->db->query('SELECT * FROM `users` ORDER BY profit DESC LIMIT 3');
while($fetch = $sql->fetch_object()){
	$top_three['count']++;
	$cases = $Functions->db->query('SELECT COUNT(`id`) FROM `drops` WHERE user = "'.$fetch->steamid.'"')->fetch_row()[0];
	$top_three['text2'][] .= '<div class="lucky">
					<div class="top'.$top_three['count'].'"></div>
					<a href="/user/'.$fetch->steamid.'"><img src="'.$fetch->avatar.'" alt="">
					<div class="name">'.$fetch->name.'</div></a>
					<div class="col lcol"><strong>'.$cases.'</strong> кейсов</div>
					<div class="col rcol"><strong>'.$fetch->profit.' P</strong> профит</div>
				</div>';		
}
$top_three['text'] = $top_three['text2'][1].$top_three['text2'][0].$top_three['text2'][2];

$top_last = ['count' => 3, 'text' => ''];
$sql = $Functions->db->query('SELECT * FROM `users` ORDER BY profit DESC LIMIT 3, 15');
while($fetch = $sql->fetch_object()){
	$top_last['count']++;
	$cases = $Functions->db->query('SELECT COUNT(`id`) FROM `drops` WHERE user = "'.$fetch->steamid.'"')->fetch_row()[0];
	$top_last['text'] .= '<div class="top-list-row">
					<div>'.$top_last['count'].'</div>
					<div style="background-image:url('.$fetch->avatar.')"><a style="color:#e5bf3d" href="/user/'.$fetch->steamid.'">'.$fetch->name.'</a></div>
					<div>'.$cases.'</div><div>'.$fetch->profit.'</div>
				</div>';
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
echo $Functions->getIndex("top", [
    'from' => ['{top_three}', '{top_last}', '{total_case}', '{total_users}', '{online_people}'],
    'to' => [$top_three['text'], $top_last['text'], $totalcase, $totaluser, sizeof(file($base))]
]);

?>