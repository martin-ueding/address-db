<?php
# Copyright © 2012 Martin Ueding <dev@martin-ueding.de>

require_once('component/PictureResize.php');

class PictureController {
	public static function pic_remove() {
		if (!empty($id)) {
			printf(_('Do you really want to remove the picture for %s?'), '<em>'.$person_loop['vorname'].' '.$person_loop['nachname'].'</em>');
			echo '<br />';
			echo '<br />';
			echo '<a href="index.php?mode=pic_remove2&id='.$id.'">'._('Yes, delete picture!').'</a>';
			echo '<br />';
			echo '<br />';
			echo '<a href="index.php?mode=person_display&id='.$_GET['id'].'">'._('cancel').'</a>';
		}
	}

	public static function pic_remove2() {
		if (!empty($_GET['id'])) {
			unlink('_mugshots/per'.$_GET['id'].'.jpg');

			$msgs[] = _('The picture was removed.');
			$mode = 'person_display';
		}
	}

	public static function pic_upload() {
?>
<h1><?php echo _('picture upload'); ?></h1>

<?php echo _('only JPEG'); ?>

<form enctype="multipart/form-data" action="index.php?mode=pic_upload1&fertig=ja" method="post">
<input type="file" name="file">
<input type="submit" value="<?php echo _('upload'); ?>">
<?php
		echo '<input type="hidden" name="id" value="'.$_GET['id'].'" />';
?>
</form>
<?php
	}

	public static function pic_upload1() {
		if (isset($_GET['fertig']) && $_GET['fertig'] == 'ja') {
			$tempname = $_FILES['file']['tmp_name'];
			$name = $_FILES['file']['name'];

			$type = $_FILES['file']['type'];
			$size = $_FILES['file']['size'];

			$pic = new PictureResize($tempname);
			try {
				$pic->resize('_mugshots/per'.$id.'.jpg');
				$msgs[] = _('The picture was added.');
			}
			catch (NoGDException $e) {
				$msgs[] = $e->getMessage();
			}

			$mode = 'person_display';
		}
	}
}
?>
