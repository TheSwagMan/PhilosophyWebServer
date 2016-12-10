<?php
    header("Content-type: text/css");

    $blue0 = "#CEF";
    $blue1 = "#BDF";
    $blue2 = "#9BF";
    $blue3 = "#8AF";
    $blue4 = "#026";
    $green0 = "#CFC";
    $green1 = "#AFA";
    $green2 = "#8F8";
    $green3 = "#5C5";
    $green4 = "#161";
    $orange0 = "#FEC";
    $orange1 = "#FC9";
    $orange2 = "#FA7";
    $orange3 = "#E95";
    $orange4 = "#951";
    $black = "#000";
    $white = "#FFF";
?>

body{
    font-family: 'Droid Sans', sans-serif;
    background-color: <?php echo($blue1); ?>;
    color: #000000;
    font-size: 150%;
}
#forum_div{
    position: relative;
}
.forum_user{
    display: inline-block;
    width: 15%;
    margin-right: 1%;
    padding-right: 1%;
    text-align: center;
}

.forum_post{
    display: inline-block;
}
.forum_entry{
    position: relative;
    margin: 2px;
    background-color: <?php echo($green2); ?>;
    border: 5px solid <?php echo($green3); ?>;
    border-radius: 10px;
}
.forum_entry .forum_user{
    background-color: <?php echo($green3); ?>;
}
.forum_entry_me{
    position: relative;
    margin: 2px;
    background-color: <?php echo($orange2); ?>;
    border: 5px solid <?php echo($orange3); ?>;
    border-radius: 10px;
}
.forum_entry_me .forum_user{
    background-color: <?php echo($orange3); ?>;
}
#title_menu_bar{
    position: static;
    top: 0;
    left: 0;
    height: auto;
    width: 100%;
    background-color: <?php echo($blue2); ?>;
	
}
#title_menu_bar h1{
    font-family: 'Raleway', sans-serif;
    margin: 0;
    padding: 0;
    font-size: 300%;
    text-align: center;
}
#title_menu_bar ul{
    list-style-type: none;
    margin: 0;
    padding: 0;
    overflow: hidden;
    background-color: <?php echo($blue3); ?>;
}
#title_menu_bar ul li{
    float: left;
}
#title_menu_bar ul .page a{
    display: block;
    color: <?php echo($blue0); ?>;
    text-align: center;
    padding: 14px 16px;
    text-decoration: none;
}
#title_menu_bar ul .page a:hover {
    color: <?php echo($blue3); ?>;
    background-color: <?php echo($blue0); ?>;
}
#title_menu_bar ul .account a{
    display: block;
    color: <?php echo($green2); ?>;
    text-align: center;
    padding: 14px 16px;
    text-decoration: none;
}
#title_menu_bar ul .account a:hover {
    color: <?php echo($green3); ?>;
    background-color: <?php echo($green0); ?>;
}
#title_menu_bar ul .special a{
    display: block;
    color: <?php echo($orange2); ?>;
    text-align: center;
    padding: 14px 16px;
    text-decoration: none;
}
#title_menu_bar ul .special a:hover {
    color: <?php echo($orange3); ?>;
    background-color: <?php echo($orange0); ?>;
}

#user_info{
    position: fixed;
    background-color: <?php echo(hex2rgba($blue4,0.3)); ?>;
    color: <?php echo($blue0);?>;
    right: 0;
    top: 0;
    padding: 1%;
    text-align: center;
}