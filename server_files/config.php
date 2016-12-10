<?php
    $CONFIG["dbname_urlredirect"] = "urlredirect";
    $CONFIG["dbname_accounts"] = "accounts";
    $CONFIG["dbname_global_chat"] = "forum";
    $CONFIG["dbname_kitchen"] = "kitchen";
    $CONFIG["db_user"] = "root";
    $CONFIG["db_pass"] = "thomas";
    $CONFIG["db_host"] = "localhost";
    $CONFIG["fname_updir"]=$_SERVER['DOCUMENT_ROOT']."/uploads/";
    $CONFIG["int_maxupsize"]=10000000;
    $CONFIG["cookie_time_minutes"] = "10";
    $CONFIG["reg_username"] = "^[0-9a-zA-Z\-\$\.&\_]{5,20}$";
    $CONFIG["reg_realname"] = "^[a-zA-Z]{1}[a-zA-Z \-]{5,40}$";
    $CONFIG["reg_password"] = $CONFIG["reg_username"];
?>
