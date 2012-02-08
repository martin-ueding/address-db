<?php /* Copyright © 2011 Martin Ueding <dev@martin-ueding.de> */ ?>
<h1><?php echo _('picture upload'); ?></h1>

<?php echo _('only JPEG'); ?>

<form enctype="multipart/form-data" action="index.php?mode=pic_upload1&fertig=ja" method="post">
<input type="file" name="file">
<input type="submit" value="<?php echo _('upload'); ?>">
<?php
echo '<input type="hidden" name="id" value="'.$_GET['id'].'" />';
?>
</form>

