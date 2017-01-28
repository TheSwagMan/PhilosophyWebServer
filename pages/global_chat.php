<?php
    echo "<script>";
    require $_SERVER['DOCUMENT_ROOT'] . "/server_files/forum_refresh.js";
    echo "</script>";
    ?>
    <div id="order_select">
      <input id="order" type="hidden" value="date"/>
      <div onclick="orderByDate()">Date</div>
      <div onclick="orderByLike()">Like</div>
    </div>
    <div id='forum_div'></div>
    <?php
    // NEW MESSAGE PART
    if($is_logged){
        ?>
        <input type="text" name="post_content" id="post_content" onkeyup="(function(e){if(e.keyCode==13){document.getElementById('send_button').click()}})(event);"/>
        <button id="send_button" onclick="sendMessage()">Post !</button>
        <?php //event.preventDefault();
    }else{
        ?>
        <p class="info">You must be logged in to post a message !</p>
        <?php
    }
?>
