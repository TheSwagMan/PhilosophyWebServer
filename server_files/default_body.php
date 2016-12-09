<!-- Title an menu bar -->
<div id="title_menu_bar">
	<h1><?php echo($pagetitle); ?></h1>
        <div id="user_info"><?php if($is_logged){echo($current_username);} ?></div>
	<ul>
		<li class="page"><a href="/home.html">Home</a></li>
		<li class="page"><a href="/tallker.html">Global Chat</a></li>
		<li class="page"><a href="/about.html">About</a></li>
                <?php if(!$is_logged){ ?>
		<li class="account"><a href="/login.html">Login</a></li>
		<li class="account"><a href="/register.html">Register</a></li>
                <?php }else{ ?>
                <li class="account"><a href="/home.html">My Account</a></li>
		<li class="special"><a href="/disconnect.html">Disconnect</a></li>
		<li class="special"><a href="/phpmyadmin/">PhpMyAdmin</a></li>
                <?php } ?>
	</ul>
</div>
<div class="global_message"><?php echo($global_message); ?></div>
