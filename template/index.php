<?php
# Copyright © 2012 Martin Ueding <dev@martin-ueding.de>

/**
 * Main layout.
 */
?>
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
		<meta charset="ISO-8859-1"  />

		<link rel="stylesheet" type="text/css" href="css/main.css">

		<script src="js/jquery.min.js"></script>
		<script src="js/message_box.js"></script>
		<script src="js/search.js"></script>
		<script src="js/selectSwitch.js.php"></script>
		<script src="js/switch.js"></script>

		<link rel="shortcut icon" type="image/x-icon" href="gfx/favicon.ico" />

		<title><?php echo $page_title; ?></title>
	</head>
	<body class="<?php echo $body_class; ?>">
		<div id="wrapper">
			<?php echo $header; ?>
			<div id="content">
				<?php echo $messages; ?>
				<?php echo $content; ?>
			</div>
		</div>
		<div id="version">
			<nobr>
				<span class="graytext">
					<?php echo _('version'); ?>
				</span>
				<?php echo $version_string; ?>
			</nobr>
		</div>
	</body>
</html>

