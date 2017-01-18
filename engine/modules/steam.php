<?php
if(!isset($Functions)){
    die("Error! 404");
}
require $_SERVER['DOCUMENT_ROOT'].'/engine/openid.php';

if($Functions->isLogged()){
    if(isset($_GET['logout'])){
        session_destroy();
    }
    $Functions->redirect();
}else{
    try{
        $openid = new LightOpenID('http://'.$Functions->config['site_name']);
        if(!$openid->mode) {
            if(isset($_GET['login'])){
                $openid->identity = 'http://steamcommunity.com/openid';
                $Functions->redirect($openid->authUrl());
            }else{
                $Functions->redirect();
            }
        }elseif($openid->mode == 'cancel'){
            $Functions->redirect();
        }else{
            if($openid->validate()) {
                $id = $openid->identity;
                $ptn = "/^http:\/\/steamcommunity\.com\/openid\/id\/(7[0-9]{15,25}+)$/";
                preg_match($ptn, $id, $matches);
                $_SESSION['steamid'] = $matches[1]; 
                $_SESSION['auth'] = true; 
                $_SESSION['lang'] = 'ru';
                $json_object = file_get_contents("http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=".$Functions->config['steamapi']."&steamids=".$matches[1]);
				if($json_object == false){
					die($Functions->getIndex("steam_fail"));
				}else{
					$json_decoded = json_decode($json_object);
					$player = $json_decoded->response->players[0];
					$_SESSION['name'] = $player->personaname;
					$_SESSION['steamid'] = $player->steamid;
					$_SESSION['avatarfull'] = $player->avatarfull;
					if(!empty($player)){
						$getPlayer = $Functions->db->query("SELECT * FROM users WHERE steamid = '".$player->steamid."'");
						if($getPlayer->num_rows == 0){
							$Functions->db->query("INSERT INTO `users`(`steamid`, `name`, `avatar`, `money`, `created`, `status`) VALUES ('".$player->steamid."', '".$player->personaname."', '".$player->avatarfull."', '0', '".time()."', '1')");
						}else{
                            $Functions->db->query("UPDATE users SET name = '".$Functions->getString($player->personaname)."', avatar = '".$player->avatarfull."' WHERE steamid = '".$player->steamid."'");
							$_SESSION['name'] = $player->personaname;
							$_SESSION['steamid'] = $player->steamid;
							$_SESSION['avatarfull'] = $player->avatarfull;
						}
						$Functions->redirect();
					}else{
						die($Functions->getIndex("steam_fail"));
					}
				}
            }else{
                $Functions->redirect();
            }
        }
    }catch(ErrorException $e){
        echo $e->getMessage();
    }
}

?>