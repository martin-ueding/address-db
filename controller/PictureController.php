<?php
# Copyright © 2012 Martin Ueding <dev@martin-ueding.de>

require_once('component/PictureResize.php');
require_once('controller/Controller.php');

class PictureController extends Controller {
	public static function pic_remove() {
		if (!empty($id)) {
			printf(_('Do you really want to remove the picture for %s?'), '<em>'.$person_loop['vorname'].' '.$person_loop['nachname'].'</em>');
			echo '<br />';
			echo '<br />';
			echo '<a href="index.php?mode=pic_remove2&id='.$id.'">'._('Yes, delete picture!').'</a>';
			echo '<br />';
			echo '<br />';
			echo '<a href="?mode=Person::view&id='.$_GET['id'].'">'._('cancel').'</a>';
		}
	}

	public static function pic_remove2() {
		if (!empty($_GET['id'])) {
			unlink('_mugshots/per'.$_GET['id'].'.jpg');

			$_SESSION['messages'][] = _('The picture was removed.');
			$mode = 'person_display';
		}
	}

	public static function edit() {
		if (!isset($_GET['id'])) {
		}

		$id = $_GET['id'];

		if (isset($_FILES['file'])) {
			$tempname = $_FILES['file']['tmp_name'];
			$name = $_FILES['file']['name'];

			$type = $_FILES['file']['type'];
			$size = $_FILES['file']['size'];

			$pic = new PictureResize($tempname);
			try {
				$pic->resize('_mugshots/per'.$id.'.jpg');
				$_SESSION['messages'][] = _('The picture was added.');
			}
			catch (NoGDException $e) {
				$_SESSION['messages'][] = $e->getMessage();
			}

			return Controller::call('Person::view');
		}
		else {
			$template = new Template('picture_edit');
			$template->set('id', $id);
			return $template->html();
		}
	}
}
?>
