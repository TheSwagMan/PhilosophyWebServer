<?php
$error_message = "";
if (isset($_POST["user_realname"]) && isset($_POST["user_username"]) && isset($_POST["user_password"]) && isset($_POST["user_confirmpassword"])) {
    // Transforming user entry
    $user_realname = sqlXSSSafe($_POST["user_realname"]);
    $user_username = sqlXSSSafe($_POST["user_username"]);
    $user_password = sqlXSSSafe($_POST["user_password"]);
    $user_confirmpassword = sqlXSSSafe($_POST["user_confirmpassword"]);
    if ($user_realname != "" && $user_username != "" && $user_password != "" && $user_confirmpassword != "") {
        if (preg_match("/" . $CONFIG["reg_username"] . "/", $user_username) && preg_match("/" . $CONFIG["reg_realname"] . "/", $user_realname)&&preg_match("/" . $CONFIG["reg_password"] . "/", $user_password)) {
            if ($user_confirmpassword == $user_password) {
                try {
                    $db = getDb($CONFIG["dbname_accounts"]);
                } catch (Exception $e) {
                    die($e->getMessage());
                }
                $response = $db->query("SELECT * FROM users WHERE username='$user_username'");
                if ($response->rowCount() <= 0) {
                    // New account is created
                    $db->query("INSERT INTO `users` (`realname`, `username`, `password`) VALUES ('$user_realname', '$user_username', '$user_password')");
                    connectUser($user_username);
                } else {
                    $error_message .= "The username is already in use !<br/>";
                }
                $response->closeCursor();
            } else {
                $error_message .= "The passwords doesn't match !<br/>";
            }
        } else {
            $error_message .= "Invalid entries !<br/>";
        }
    } else {
        $error_message .= "Please fill all the entries !<br/>";
    }
}
?>
<form class="account_form" method="post">
    <input type="text" placeholder="Realname..." pattern="<?php echo($CONFIG["reg_realname"]); ?>" name="user_realname" required title="Correct name please !(<?php echo($CONFIG["reg_realname"]); ?>)"/><br/>
    <input type="text" placeholder="Username..." pattern="<?php echo($CONFIG["reg_username"]); ?>" name="user_username" required title="Correct username please ! (<?php echo($CONFIG["reg_username"]); ?>)"/><br/>
    <input type="password" placeholder="Password..." name="user_password" required/><br/>
    <input type="password" placeholder="Confirm..." name="user_confirmpassword" required/><br/>
    <input type="submit" value="Login"/>
</form>