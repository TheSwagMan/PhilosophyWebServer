<?php
	try{
		$db = new PDO('mysql:host=localhost;dbname=forum;charset=utf8', 'root', 'thomas');
	}catch(Exception $e){
		die('Error : '.$e->getMessage());
	}
	if(isset($_POST["post_content"])&&isset($_POST["post_member"])){
		$post_member=str_replace("'", "",$_POST["post_member"]);
		$post_content=str_replace("'", "",$_POST["post_content"]);
		$db->query("INSERT INTO `posts` (`post_user`, `post_content`) VALUES ('$post_member', '$post_content');");
	}
	$reponse = $db->query("SELECT * FROM posts");
	echo("<div id='forum_div'>");
	while($data=$reponse->fetch()){
		echo("<div class='forum_entry'><div class='forum_user'>".$data["post_user"]."</div><div class='forum_post'>".$data["post_content"]."</div></div>");
	}
	echo("</div>");
	$reponse->closeCursor();
?>
<form method="post">
	<input type="text" name="post_member">
	<input type="text" name="post_content">
	<input type="submit">
</form>