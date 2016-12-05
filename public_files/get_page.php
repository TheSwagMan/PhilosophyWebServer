<?php
	$SQLSAFE=str_replace("'", "",$_GET['page']);
	$pageid=str_replace("/", "",str_replace(".html", "",$SQLSAFE));
	try{
		$db = new PDO('mysql:host=localhost;dbname=urlredirect;charset=utf8', 'root', 'thomas');
	}catch(Exception $e){
		die('Error : '.$e->getMessage());
	}
	$reponse = $db->query("SELECT title,filepath FROM pages WHERE page='$pageid'");
	$pagepath="";
	$pagetitle="404 Error !";
	if($data=$reponse->fetch()){
		$pagepath="/pages/".$data["filepath"];
		$pagetitle=$data["title"];
		header("Status : 200 OK",null,200);
	}
	$reponse->closeCursor();
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