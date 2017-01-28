<?php
	try{
		$db = getDb($CONFIG["dbname_global_chat"]);
	}catch(Exception $e){
			die('Error : '.$e->getMessage());
	}
	if(isset($_POST["order"])&&!empty($_POST["order"])){
			$order=sqlXSSSafe($_POST["order"]);
			if($order=="date"){
					$response = $db->query("SELECT * FROM posts ORDER BY ID");
			}else if($order=="like"){
					$response = $db->query("SELECT * FROM posts ORDER BY post_liked DESC");
			}else{
				die("This order is not valid...");
			}
	}else{
		$response = $db->query("SELECT * FROM posts");
	}

	$user_pseudo="";
	while($data=$response->fetch()){
		$user_pseudo=$data['post_user_username'];
		$user_realname="Deleted account";
		$udb= getDb($CONFIG["dbname_accounts"]);
		$resp=$udb->query("SELECT * FROM users WHERE username='$user_pseudo'");
		if($resp->rowCount()==1){
			$user_realname=$resp->fetch()["realname"];
		}
		$resp->closeCursor();
		if($data['post_deleted']==0){
			$content_message=$data['post_content'];
			if($data['post_edited']==1){
				$content_message=$data['post_edited_content'];
			}
			if(isset($_POST["TIMESTAMP"])&&!empty($_POST["TIMESTAMP"])){
				if($data['post_timestamp']>=$_POST["TIMESTAMP"]){
					echo(forumEntryFormat($is_logged,$user_pseudo==$current_username,$user_realname,$content_message,$data['ID'],$data['post_liked']));
				}
			}else{
				echo(forumEntryFormat($is_logged,$user_pseudo==$current_username,$user_realname,$content_message,$data['ID'],$data['post_liked']));
			}
		}
	}
	$response->closeCursor();
?>
