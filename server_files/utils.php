<?php

function redirect($url) {
    ?>
        <form id="redirForm" action="<?php echo($url); ?>" method="post">
        <input type="hidden" name="oldurl" value="<?php echo($_SERVER['REQUEST_URI']); ?>">
        </form>
        <script type="text/javascript">
            document.getElementById('redirForm').submit();
        </script>
    <?php
}

function sqlXSSSafe($input) {
    return htmlspecialchars(str_replace("'", "", $input));
}

function deleteAccount($username) {
    global $CONFIG;
    $db = getDb($CONFIG["dbname_accounts"]);
    $db->query("DELETE FROM `users` WHERE `username`='$username'");
}

function cookieTime() {
    global $CONFIG;
    return date('Y-m-d H:i:s', strtotime("+" . $CONFIG['cookie_time_minutes'] . " min"));
}

function removeCookie($cookiename) {
    setcookie($cookiename, null, -1);
}

function getDb($dbname) {
    global $CONFIG;
    return new PDO("mysql:host=" . $CONFIG["db_host"] . ";dbname=" . $dbname . ";charset=utf8", $CONFIG["db_user"], $CONFIG["db_pass"]);
}

function clearSession($hash) {
    global $CONFIG;
    $db = getDb($CONFIG["dbname_kitchen"]);
    $db->query("DELETE FROM `session_cookies` WHERE `session_hash`='$hash'");
    removeCookie("SessionID");
}

function getRandomHash() {
    return sha1(time() . openssl_random_pseudo_bytes(20));
}

function connectUser($username) {
    global $CONFIG;
    include $_SERVER['DOCUMENT_ROOT'] . "/server_files/config.php";
    try {
        $db = getDb($CONFIG["dbname_kitchen"]);
    } catch (Exception $e) {
        die($e->getMessage());
    }
    $db->query("DELETE FROM session_cookies WHERE username='$username'");
    $session_random_hash = getRandomHash();
    $valid_until = cookieTime();
    $db->query("INSERT INTO `session_cookies` (`username`, `session_hash`, `valid_until`) VALUES ('$username', '$session_random_hash', '$valid_until')");
    setcookie("SessionID", $session_random_hash, strtotime($valid_until));
    redirect("/");
}

?>