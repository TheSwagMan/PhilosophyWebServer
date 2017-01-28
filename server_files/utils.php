<?php
function hex2rgba($color, $opacity) {
    $color = substr($color, 1);
    if (strlen($color) == 6) {
        $hex = array($color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5]);
    } elseif (strlen($color) == 3) {
        $hex = array($color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2]);
    }
    $rgb = array_map('hexdec', $hex);
    $output = 'rgba(' . implode(",", $rgb) . ',' . $opacity . ')';
    return $output;
}

function redirect($url) {
    ?>
    <form id="redirForm" action="<?php echo($url); ?>" method="post">
        <input type="hidden" name="oldurl" value="<?php echo($_SERVER['REQUEST_URI']); ?>">
    </form>
    <script type="text/javascript">
        document.getElementById('redirForm').submit();
    </script>
    <?php
    die();
}

function sqlXSSSafe($input) {
    return htmlentities($input,ENT_QUOTES);
}

function deleteAccount($username) {
    global $CONFIG;
    $db = getDb($CONFIG["dbname_accounts"]);
    $db->query("DELETE FROM users WHERE username='$username'");
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
    $db->query("DELETE FROM session_cookies WHERE session_hash='$hash'");
    removeCookie("SessionID");
}

function getRandomHash() {
    return sha1(time() . openssl_random_pseudo_bytes(20));
}

function connectUser($username) {
    global $CONFIG;
    try {
        $db = getDb($CONFIG["dbname_kitchen"]);
    } catch (Exception $e) {
        die($e->getMessage());
    }
    $db->query("DELETE FROM session_cookies WHERE username='$username'");
    $session_random_hash = getRandomHash();
    $valid_until = cookieTime();
    $db->query("INSERT INTO session_cookies (username, session_hash, valid_until) VALUES ('$username', '$session_random_hash', '$valid_until')");
    setcookie("SessionID", $session_random_hash, strtotime($valid_until));
    redirect("/");
}
function forumEntryFormat($is_logged,$is_yours,$name,$message,$id,$likes){
    $pre="";
    $is_button=false;
    if($is_logged){
        $is_button=true;
        if($is_yours){
            $pre="_me";
        }
    }
    $buttons="";
    if($is_button){
      $buttons="<div class='buttons'>";
      if($is_yours){

        $buttons=$buttons."<button class='delete'onclick='deleteMessage(".$id.")'>Delete</button><button class='edit' onclick='editMessage(".$id.")'>Edit</button>";
      }
      $buttons=$buttons."<button class='like' onclick='likeMessage(".$id.")'>Like (".$likes.")</button>";
      $buttons=$buttons."</div>";
    }
    return "<div class='forum_entry".$pre."'><div class='forum_user'>".$name."</div><div class='forum_post'>".$message."</div>".$buttons."</div>";
}
function checkRealname($str){
    return (5<=strlen($str))&&(strlen($str)<=40)&&($str[0]!==" ");
}
function checkUsername($str){
    return (4<=strlen($str))&&(strlen($str)<=32)&&(strpos($str, " ")===false);
}
function checkPassword($str){
    return (4<=strlen($str))&&(strlen($str)<=32)&&(strpos($str, " ")===false);
}
?>
