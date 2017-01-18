<?php
require_once("./engine/functions.php");

$moduleGet = $_GET['module'];

if(!isset($moduleGet)){
    $user = $Functions->getUser();
    echo '<script type="text/javascript">
    function checkDrop(case2){
      setTimeout( function(){
        $.ajax({
        url: "/api",
        type: "post",
        data: {action: "checkCase", case1: case2},
        dataType: "json",
        success: function(rdata){
          if("true" == rdata.result){

          }else{

          }
        }
      });
        }  , 10000 );
    }
          </script>';
    $rarity = $Functions->db->query("SELECT * FROM cases WHERE class='rarity' ORDER BY id");
    while($case = $rarity->fetch_object()){
      echo '<script type="text/javascript">

      checkDrop("'.$case->name.'");
            </script>';
	$Visible = $case->visible == 1 ? "" : "disable";
        $casesRarity .= '
						<a href="/case/'.$case->name.'" class="randbox '.$case->name.' '.$Visible.'">
							<i class="box" style="background-image: url(/template/img/'.$case->picture.');"></i>

							<span>'.$case->title.'</span>
							<strong>'.$case->price.' P</strong>
							<span class="view">подробнее</span>
						</a>
						';
    }

    $newyear = $Functions->db->query("SELECT * FROM cases WHERE class='newyear' ORDER BY id");
    while($case = $newyear->fetch_object()){
      echo '<script type="text/javascript">

      checkDrop("'.$case->name.'");
            </script>';
	$Visible = $case->visible == 1 ? "" : "disable";
        $casesNewyear .= '
						<a href="/case/'.$case->name.'" class="randbox '.$case->name.' '.$Visible.'">
							<i class="box" style="background-image: url(/template/img/'.$case->picture.'),url(/template/img/bgmask.png);"></i>
							<span>'.$case->title.'</span>
							<strong>'.$case->price.' P</strong>
							<span class="view">Подробнее</span>
						</a>
						';

    }
    $random = $Functions->db->query("SELECT * FROM cases WHERE class='random' ORDER BY id");
    while($case = $random->fetch_object()){
      echo '<script type="text/javascript">

      checkDrop("'.$case->name.'");
            </script>';
	$Visible = $case->visible == 1 ? "" : "disable";
        $casesRandom .= '
						<a href="/case/'.$case->name.'" class="randbox '.$case->name.' '.$Visible.'"">
							<i class="box" style="background-image: url(/template/img/'.$case->picture.'),url(/template/img/bgmask.png);"></i>
							<span>'.$case->title.'</span>
							<strong>'.$case->price.' P</strong>
							<span class="view">Подробнее</span>
						</a>
						';

    }
    $cases = $Functions->db->query("SELECT * FROM cases WHERE class='casee' ORDER BY id");
    while($case = $cases->fetch_object()){
      echo '<script type="text/javascript">

      checkDrop("'.$case->name.'");
            </script>';
	$Visible = $case->visible == 1 ? "" : "disable";
        $casesRand .= '
						<a href="/case/'.$case->name.'" class="case '.$Visible.'"">
							<i class="box" style="background-image: url(/template/img/'.$case->picture.'),url(/template/img/bgmask.png);"></i>
							<span>'.$case->title.'</span>
							<strong>'.$case->price.' P</strong>
						</a>
						';

    }

    $col = $Functions->db->query("SELECT * FROM cases WHERE class='col' ORDER BY id");
    while($case = $col->fetch_object()){
      echo '<script type="text/javascript">
      checkDrop("'.$case->name.'");
            </script>';
  $Visible = $case->visible == 1 ? "" : "disable";
        $colra .= '
            <a href="/case/'.$case->name.'" class="case '.$Visible.'"">
              <i class="box" style="background-image: url(/template/img/'.$case->picture.'),url(/template/img/bgmask.png);"></i>
              <span>'.$case->title.'</span>
              <strong>'.$case->price.' P</strong>
            </a>
            ';

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
//выделяем уникальный идентификатор сессии
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

    echo $Functions->getIndex("index", array(
        'from' => ['{user_avatar}', '{user_name}', '{caserarity}', '{newyear}', '{casesrandom}','{caseses}' , '{colections}', '{total_case}', '{total_users}', '{online_people}'],
        'to' => [str_replace("_full.jpg", "_medium.jpg", $user->avatar), $user->personaname, $casesRarity, $casesNewyear, $casesRandom, $casesRand, $colra  , $totalcase, $totaluser, sizeof(file($base))]
    ));
}else{
    $module = "./engine/modules/".$moduleGet.".php";
    if(is_file($module)){
        require_once($module);
    }else{
        echo $Functions->getIndex("404", array(
        'from' => ['{total_case}', '{total_users}', '{online_people}'],
        'to' => [$totalcase, $totaluser, sizeof(file($base))]
        ));
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
     $CurrentTime = time();
     $LastTime = time() - 600;
     $base = "session.txt";

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
}

?>
