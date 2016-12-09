
<?php
    try{
        $db = getDb($CONFIG["dbname_global_chat"]);
    }catch(Exception $e){
            die('Error : '.$e->getMessage());
    }
    if($is_logged&&isset($_POST["post_content"])&&!empty($_POST["post_content"])){
        $post_content=htmlspecialchars(str_replace("'", "",$_POST["post_content"]));
        $db->query("INSERT INTO `posts` (`post_user_username`,`post_content`) VALUES ('$current_username', '$post_content');");
    }
    $response = $db->query("SELECT * FROM posts");
    echo("<div id='forum_div'>");
    $user_pseudo="";
    while($data=$response->fetch()){
        $user_pseudo=$data['post_user_username'];
        $user_realname="Deleted account";
        $udb= getDb($CONFIG["dbname_accounts"]);
        $resp=$udb->query("SELECT * FROM `users` WHERE `username`='$user_pseudo'");
        if($resp->rowCount()==1){
            $user_realname=$resp->fetch()["realname"];
        }
        $resp->closeCursor();
        $entry_type="";
        if($user_pseudo==$current_username){
            $entry_type="_me";
        }
        echo("<div class='forum_entry".$entry_type."'><div class='forum_user'>".$user_realname."</div><div class='forum_post'>".$data["post_content"]."</div></div>");
    }
    echo("</div>");
    $response->closeCursor();
    if($is_logged){
?>
<form method="post">
	<input type="text" name="post_content">
        <input type="submit" value="Post !">
</form>
<?php }else{ ?>
<p class="info">You must be logged in to post a message !</p>
<?php } ?>
