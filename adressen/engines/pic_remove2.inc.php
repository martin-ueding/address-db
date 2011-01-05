<?PHP
if (!empty($_GET['id'])) {
		unlink('_mugshots/per'.$_GET['id'].'.jpg');

		$msgs[] = _('The picture was removed.');
		$mode = 'person_display';
}
?>
