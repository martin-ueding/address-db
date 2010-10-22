<?PHP 
if ($_GET['fertig'] == 'ja') {
	$tempname = $_FILES['file']['tmp_name']; 
	$name = $_FILES['file']['name'];	

	$type = $_FILES['file']['type']; 
	$size = $_FILES['file']['size']; 


	if($size > "2000000") { 
		$err[] = "Die Datei, die du hochladen willst, ist zu gro&szlig;!<br>Maximale Dateigrosse betr&auml;gt 2 MB!";
	} 

	if(empty($err)) { 
		if ($_GET['fertig'] == 'ja') {
			$bilddaten = getimagesize($tempname);

			if ($bilddaten[0] <= 300) {
				copy($tempname, 'bilder/per'.$_POST['id'].'.jpg');
				header('location:personenanzeige.php?time='.time().'&id='.$_POST['id']);
			}
			else {
				copy($tempname, 'bilder/temp'.$_POST['id'].'.jpg');
				header('location:bild_hochladen2.php?id='.$_POST['id']);
			}
		}
	}
		
	else { 
		foreach($err as $error)
		echo "$error<br>";
	} 
}
		
?>


	<h1>Dateiupload</h1>

	Nur .JPG!

	<form enctype="multipart/form-data" action="index.php?mode=pic_upload1&fertig=ja" method="post"> 
	<input type="file" name="file">
	<input type="submit" value="Hochladen">
	<?PHP
	echo '<input type="hidden" name="id" value="'.$_GET['id'].'" />';
	?>
	</form>

