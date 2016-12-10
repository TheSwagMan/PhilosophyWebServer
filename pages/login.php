<?php
    $error_message="";
    try{
            $db = getDb($CONFIG["dbname_accounts"]);
    }catch(Exception $e){
            die($e->getMessage());
    }
    if(isset($_POST["user_username"])&&isset($_POST["user_password"])){
        // Transforming user entry
        $user_username=sqlXSSSafe($_POST["user_username"]);
        $user_password=sqlXSSSafe($_POST["user_password"]);
        // Checking user existance and password
        $response=$db->query("SELECT * FROM users WHERE username='$user_username' AND password='$user_password'");
        if($response->rowCount()==1){
            // Start session
            connectUser($user_username);
        }else{
            // Login failed
            $error_message.="The username and/or password is incorrect !";
        }
        $response->closeCursor();
    }
	
?>
<form method="post">
    <input type="text" placeholder="Username..." name="user_username"/><br>
    <input type="password" placeholder="Password..." name="user_password"/><br>
    <input type="submit" value="Login">
</form>
