<?php
if (isset($_FILES['doc'])) {
    $updir = $CONFIG["fname_updir"];
    $tfilename = basename($_FILES['doc']['name']);
    $fsize = filesize($_FILES['doc']['tmp_name']);
    $extensions = array('.png', '.gif', '.jpg', '.jpeg');
    $extension = strrchr($_FILES['doc']['name'], '.');
    if (in_array($extension, $extensions)) {
        if ($fsize <= $CONFIG["int_maxupsize"]) {
            // everythings fine -> uploading...
            $tfilename = strtr($tfilename, 'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ', 'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
            $filename = preg_replace('/([^.a-z0-9]+)/i', '-', $tfilename);
            if (move_uploaded_file($_FILES['doc']['tmp_name'])) {
                echo('Success !'.$updir . $filename);
            } else {
                echo('Unknown error !');
            }
        } else {
            $error_message .= 'This file is too big...';
        }
    } else {
        $error_message .= 'This file type is not allowed...';
    }
}
?>
<form enctype="multipart/form-data" method="post">
    <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo($CONFIG["int_maxupsize"]); ?>" />
    Upload : <input name="doc" type="file" />
    <input type="submit" value="Envoyer le fichier" />
</form>
