<?PHP
if (!empty($_GET['id'])) {
		unlink('_mugshots/per'.$_GET['id'].'.jpg');

		$msgs[] = _('Das Bild wurde gel&ouml;scht.');
		$mode = 'person_display';
}
?>
