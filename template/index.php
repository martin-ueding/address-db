<?php
# Copyright © 2012 Martin Ueding <dev@martin-ueding.de>

/**
 * Main layout.
 */
?>
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta charset="utf-8"  />

		<link rel="stylesheet" type="text/css" href="css/main.css">

		<script src="js/jquery.min.js"></script>
		<script src="js/message_box.js"></script>
		<script src="js/search.js"></script>
		<script src="js/select_switch.js"></script>
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

