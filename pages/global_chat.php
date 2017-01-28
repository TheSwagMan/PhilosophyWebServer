<?php
    echo "<script>";
    require $_SERVER['DOCUMENT_ROOT'] . "/server_files/forum_refresh.js";
    echo "</script>";
    ?>
    <div id='forum_div'></div>
    <?php
    // NEW MESSAGE PART
    if($is_logged){
        ?>
        <form method="post" action="/send_message.html" onsubmit="setTimeout(function(){document.getElementById('post_content').value=''},500);" target="hidden_iframe_send" >
        	<input type="text" name="post_content" id="post_content"/>
            <input type="submit" value="Post !"/>
        </form>
        <?php
    }else{
        ?>
        <p class="info">You must be logged in to post a message !</p>
        <?php
    }
?>
