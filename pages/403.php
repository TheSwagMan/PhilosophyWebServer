<?php http_response_code(403);?>
<p id="error">Access forbidden <?php if(isset($_POST['oldurl'])){echo(" to ".$_POST['oldurl']);} ?> ! You don't have the required authorizations to access this page !</p>
