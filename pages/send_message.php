<?php
	if(isset($_POST["post_content"])&&!empty($_POST["post_content"])){
		try{
		    $db = getDb($CONFIG["dbname_global_chat"]);
		}catch(Exception $e){
		        die('Error : '.$e->getMessage());
		}
        $post_content=sqlXSSSafe($_POST["post_content"]);
        $db->query("INSERT INTO posts (post_user_username,post_content) VALUES ('$current_username', '$post_content');");
    }
?>