<?php
# Copyright © 2012 Martin Ueding <dev@martin-ueding.de>

require_once('component/PictureResize.php');
require_once('component/Template.php');
require_once('controller/Controller.php');

class PictureController extends Controller {
	public function delete() {
		if (!isset($_GET['id'])) {
		}

		$id = $_GET['id'];

		if (isset($_GET['sure'])) {
			unlink('_mugshots/per'.$_GET['id'].'.jpg');

			$_SESSION['messages'][] = _('The picture was removed.');

			$_SESSION['history']->go_back();
		}
		else {
			$template = new Template('picture_delete');
			$template->set('id', $id);

			$erg = Person::select_person_alles($id);
			$person_loop = mysql_fetch_assoc($erg);
			$template->set('person_loop', $person_loop);
			return $template->html();
		}
	}

	public function edit() {
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

			$_SESSION['history']->go_back();
		}
		else {
			$template = new Template('picture_edit');
			$template->set('id', $id);
			return $template->html();
		}
	}
}
?>
