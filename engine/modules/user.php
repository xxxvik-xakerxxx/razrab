<?php
if(!isset($Functions)){
    die("Error! 404");
}
$user = $Functions->getUser();
if(!$user && empty($_GET['id'])) die($Functions->getIndex("404"));

if(!empty($_GET['id'])){
    $getUser = $Functions->getUser($_GET['id']);
    if(!$getUser || $getUser->steamid == $user->steamid){
        header("Location: /user");
    }else{
        $itemsBlock = '';
		$items = $Functions->db->query("SELECT * FROM `drops` WHERE user = '".$getUser->steamid."' ORDER BY id DESC LIMIT 25");
		$casesopened = 0;
		while($drop = $items->fetch_object()){
			$casesopened++;
			$item = $Functions->db->query("SELECT * FROM `items` WHERE id = '".$drop->itemid."'")->fetch_object();
			$case = $Functions->db->query("SELECT `picture`,`name` FROM `cases` WHERE name = '".$drop->casename."'")->fetch_object();
			if($drop->status == 0){
				$status = '<span class="status-alarm" title="Статус еще не выбран!"></span>';
			}
        if($drop->status == 1){
				$status = '<span class="status-compleate" title="Передан боту"><i class="fa fa-check"></i></span>';
			}elseif($drop->status == 2){
				$status = '<span class="status-money" title="Продан за '.$drop->price.' руб.">&#8399;</span>';
			}elseif($drop->status == 3){
				$status = '<span class="status-compleate" title="Отправлен пользователю"><i class="fa fa-check"></i></span>';
			}elseif($drop->status == 4){
				$status = '<span class="status-alarm" title="'.$drop->message.'"><i class="fa fa-times"></i></span>';
		}elseif($drop->status == 5){
      $status = '<span class="status-alarm2" title="'.$drop->message.'"><i class="fa fa-refresh" aria-hidden="true"></i></span>';
  }
			$itemsBlock .= '<span class="item-incase '.$item->type.'" target="_blank" style="text-decoration: none;">
									<div class="status">
										<span class="status-text">'.$drop->price.'p.</span>
										'.$status.'
									</div>
									<div class="picture">
										<img class="picture-item" src="'.$item->image.'/110fx82f" alt="Дроп">
										<a href="/case/'.$case->name.'"><img class="picture-case" src="/template/img/'.$case->picture.'"></a>
									</div>
									<div class="descr">
										<strong>'.$item->weapon.'</strong>
										<span>'.$item->name.'</span>
									</div>
								</span>';
		}
		$itemsBlock .= '';

		if($items->num_rows == 0){
			$itemsBlock = 'Вы еще не открывали кейсы...';
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
		echo $Functions->getIndex("otheruser", [
			'from' => ['{inventory}', '{user_avatar}', '{user_name}', '{user_steam}', '{casesopened}', '{total_case}', '{total_users}', '{online_people}'],
			'to' => [$itemsBlock, $getUser->avatar, strip_tags($getUser->name), $getUser->steamid, $casesopened, $totalcase, $totaluser, sizeof(file($base))]
		]);
    }
}else{
    $itemsBlock = '';
    $items = $Functions->db->query("SELECT * FROM drops WHERE user = '".$user->steamid."' ORDER BY id DESC LIMIT 25");
	$casesopened = 0;
    while($drop = $items->fetch_object()){
		$casesopened++;
        $item = $Functions->db->query("SELECT * FROM items WHERE id = '".$drop->itemid."'")->fetch_object();
		$case = $Functions->db->query("SELECT `picture`,`name` FROM cases WHERE name = '".$drop->casename."'")->fetch_object();
		$status = '';
        if($drop->status == 0){
            $status = '<a href="/api?action=sellItem&item_id='.$drop->id.'" class="status-money" title="Продать за '.$drop->price.' руб.">&#8399;</a> <a href="/api?action=sendItem&item_id='.$drop->id.'" class="status-selled" title="Вывести"><i class="fa fa-shopping-cart"></i></a>';
        }
        if($drop->status == 1){
				$status = '<span class="status-compleate" title="Передан боту"><i class="fa fa-check"></i></span>';
			}elseif($drop->status == 2){
				$status = '<span class="status-money" title="Продан за '.$drop->price.' руб.">&#8399;</span>';
			}elseif($drop->status == 3){
				$status = '<span class="status-compleate" title="Отправлен пользователю"><i class="fa fa-check"></i></span>';
			}elseif($drop->status == 4){
				$status = '<span class="status-alarm" title="'.$drop->message.'"><i class="fa fa-times"></i></span>';
		}elseif($drop->status == 5){
      $status = '<a href="/api?action=sendItem2&item_id='.$drop->id.'" class="status-alarm2" title="'.$drop->message.'"><i class="fa fa-refresh" aria-hidden="true"></i></a>';
  }
        $itemsBlock .= '<span class="item-incase '.$item->type.'" target="_blank" style="text-decoration: none;">
								<div class="status">
									<span class="status-text">'.$drop->price.'p.</span>
									'.$status.'
								</div>
								<div class="picture">
									<img class="picture-item" src="'.$item->image.'/360fx360f" alt="Дроп">
									<a href="/case/'.$case->name.'"><img class="picture-case" src="/template/img/'.$case->picture.'"></a>
									</div>
								<div class="descr">
									<strong>'.$item->weapon.'</strong>
									<span>'.$item->name.'</span>
								</div>
							</span>';
    }
    $itemsBlock .= '';

    if($items->num_rows == 0){
        $itemsBlock = 'Вы еще не открывали кейсы...';
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
    echo $Functions->getIndex("user", [
        'from' => ['{trade_link}', '{inventory}', '{user_avatar}', '{user_name}', '{user_steam}', '{casesopened}', '{total_case}', '{total_users}', '{online_people}'],
        'to' => [$user->tradelink, $itemsBlock, $user->avatar, strip_tags($user->name), $user->steamid, $casesopened, $totalcase, $totaluser, sizeof(file($base))]
    ]);
}

?>
