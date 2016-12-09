<?php
    include $_SERVER['DOCUMENT_ROOT']."/server_files/config.php";
    include $_SERVER['DOCUMENT_ROOT']."/server_files/utils.php";
    
    $global_message="";
    $pagetitle="";
    $SQLSAFE=str_replace("'", "",$_GET['page']);
    $pageid=str_replace("/", "",str_replace(".html", "",$SQLSAFE));
    try{
        $db = getDb($CONFIG["dbname_urlredirect"]);
    }catch(Exception $e){
        die($e->getMessage());
    }
    $response = $db->query("SELECT title,filepath FROM pages WHERE page='$pageid'");
    if($response->rowCount()==1){
        $data=$response->fetch();
        $pagepath="/pages/".$data["filepath"];
        $pagetitle=$data["title"];
        http_response_code(200);
    }else{
		header("Location: /404.html");
    }
    
    $response->closeCursor();
    // Check if the user is logged in
    $is_logged=false;
    $current_username="";
    if(isset($_COOKIE["SessionID"])){
		
        try{
            $db = getDb($CONFIG["dbname_kitchen"]);
        }catch(Exception $e){
            die($e->getMessage());
        }
        
        $cookie_session_hash=$_COOKIE["SessionID"];
        $response = $db->query("SELECT * FROM `session_cookies` WHERE `session_hash`='$cookie_session_hash'");
        if($response->rowCount()==1){
            $data=$response->fetch();
            if(new DateTime()<=new DateTime($data["valid_until"])){
                $temp_username=$data["username"];
                
                $udb= getDb($CONFIG["dbname_accounts"]);
                $resp=$udb->query("SELECT * FROM `users` WHERE `username`='$temp_username'");
                
                if($resp->rowCount()==1){
                    $is_logged=true;
                    $current_username=$temp_username;
                    setcookie("SessionID", $cookie_session_hash, strtotime(cookieTime()));
                }else{
                    $db->query("DELETE FROM `session_cookies` WHERE `session_hash`='$cookie_session_hash'");
                }
            }
        }
        
        $response->closeCursor();
        if(!$is_logged){
            // Delete potential entries
            clearSession($cookie_session_hash);
        }
    }
?>
<!DOCTYPE html>
<html>
<head>
<?php require $_SERVER['DOCUMENT_ROOT']."/server_files/default_header.php"; ?>
<title><?php echo($pagetitle); ?></title>
</head>
<body>
<?php require $_SERVER['DOCUMENT_ROOT']."/server_files/default_body.php"; ?>
<?php if(is_file($_SERVER['DOCUMENT_ROOT'].$pagepath)){require $_SERVER['DOCUMENT_ROOT'].$pagepath;}else{require '/pages/404.php';}?>
</body>
</html>
