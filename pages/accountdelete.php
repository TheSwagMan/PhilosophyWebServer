<?php
    if(isset($_POST['sure'])){
        deleteAccount($current_username);
        header("Location: /");
    }else{
        ?>
<form method="post">
    Are you sure you want to delete account ?<br>
    <input name="sure" type="hidden"/>
    <input type="submit" value="Yes, i'm sure !"/>
</form>
        <?php
    }
?>