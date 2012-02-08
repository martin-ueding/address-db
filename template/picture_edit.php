<h1><?php echo _('picture upload'); ?></h1>

<?php echo _('only JPEG'); ?>

<form enctype="multipart/form-data" action="index.php?mode=Picture::edit&id=<?php echo $id; ?>" method="post">
<input type="file" name="file">
<input type="submit" value="<?php echo _('upload'); ?>">
</form>
