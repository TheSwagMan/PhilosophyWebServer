<?php
if(isset($_POST["message_id"])&&!empty($_POST["message_id"])){
	try{
		$db = getDb($CONFIG["dbname_global_chat"]);
	}catch(Exception $e){
		die('Error : '.$e->getMessage());
	}
	$id=sqlXSSSafe($_POST["message_id"]);
	$db->query("UPDATE posts SET post_liked=post_liked+1 WHERE ID='$id' AND NOT post_user_username='$current_username';");
}
?>
