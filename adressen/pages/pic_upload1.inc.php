<h1><?PHP echo _('picture upload'); ?></h1>

<?PHP echo _('only JPEG'); ?>

<form enctype="multipart/form-data" action="index.php?mode=pic_upload1&fertig=ja" method="post"> 
<input type="file" name="file">
<input type="submit" value="Hochladen">
<?PHP
echo '<input type="hidden" name="id" value="'.$_GET['id'].'" />';
?>
</form>

