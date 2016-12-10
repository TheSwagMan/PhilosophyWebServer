<?php
    include $_SERVER['DOCUMENT_ROOT'] . "/server_files/config.php";
    include $_SERVER['DOCUMENT_ROOT'] . "/server_files/utils.php";
    $global_message = "";
    $SQLSAFE = str_replace("'", "", $_GET['page']);
    $pageid = str_replace("/", "", $SQLSAFE);
    $db = getDb($CONFIG["dbname_urlredirect"]);
    $response = $db->query("SELECT * FROM pages WHERE page='$pageid'");
    if ($response->rowCount() == 1) {
        $data = $response->fetch();
        $pagelevel = $data["required_level"];
        $pagepath = "/pages/" . $data["filepath"];
        $pagetitle = $data["title"];
        $doctype=$data["type"];
        http_response_code(200);
    } else {
        redirect("/404.html");
    }

    $response->closeCursor();
    // Check if the user is logged in
    $is_logged = false;
    $current_username = "";
    $current_realname = "";
    $cookie_session_hash = "";
    if (isset($_COOKIE["SessionID"])) {
        try {
            $db = getDb($CONFIG["dbname_kitchen"]);
        } catch (Exception $e) {
            die($e->getMessage());
        }

        $cookie_session_hash = $_COOKIE["SessionID"];
        $response = $db->query("SELECT * FROM `session_cookies` WHERE `session_hash`='$cookie_session_hash'");
        if ($response->rowCount() == 1) {
            $data = $response->fetch();
            if (new DateTime() <= new DateTime($data["valid_until"])) {
                $temp_username = $data["username"];

                $udb = getDb($CONFIG["dbname_accounts"]);
                $resp = $udb->query("SELECT * FROM `users` WHERE `username`='$temp_username'");

                if ($resp->rowCount() == 1) {
                    $data2=$resp->fetch();
                    $is_logged = true;
                    $current_username = $temp_username;
                    $current_realname = $data2["realname"];
                    $userlevel = $data2["level"];
                    setcookie("SessionID", $cookie_session_hash, strtotime(cookieTime()));
                } else {
                    redirect("/logout.html");
                }
            }
        }
    }
    $response->closeCursor();
    if ($is_logged) {
        if ($pagelevel > $userlevel) {
            redirect("/403.html");
        }
    } else {
        clearSession($cookie_session_hash);
        if ($pagelevel > 0) {
            redirect("/403.html");
        }
    }
    if($doctype=="html"){
?>
<!DOCTYPE html>
<html>
    <head>
        <?php require $_SERVER['DOCUMENT_ROOT'] . "/server_files/default_header.php"; ?>
        <title><?php echo($pagetitle); ?></title>
    </head>
    <body>
        <?php require $_SERVER['DOCUMENT_ROOT'] . "/server_files/default_body.php"; ?>
        <?php if (is_file($_SERVER['DOCUMENT_ROOT'] . $pagepath)) {
            require $_SERVER['DOCUMENT_ROOT'] . $pagepath;
        } else {
            require '/pages/404.php';
        } ?>
        <p id="error_message"><?php echo($error_message); ?></p>
    </body>
</html>
<?php }else{
    require $_SERVER['DOCUMENT_ROOT'] . $pagepath;
} ?>
