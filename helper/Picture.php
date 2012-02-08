<?php
# Copyright © 2012 Martin Ueding <dev@martin-ueding.de>

require_once('NoGDException.php');

class Picture {
	public $max_width = 300;

	public function __construct($filename) {
		$this->filename = $filename;

		$picture_info = getimagesize($this->filename);

		$this->width = $picture_info[0];
		$this->height = $picture_info[1];
	}

	public function resize($destination) {
		if (!$this->needs_resize()) {
			copy($this->filename, $destination);
			return;
		}

		if (!function_exists('imagecreatefromjpeg')) {
			throw new NoGDException(
				_('No function imagecreatefromjpeg. You need to have GD support to resize images.')
			);
		}
		$orignal = imagecreatefromjpeg($this->filename);
		$resized = imagecreatetruecolor($this->new_width(), $this->new_height());

		# Resize the image.
		imagecopyresampled($resized, $orignal, 0, 0, 0, 0, $this->new_width(),
			$this->new_height(), $this->width, $this->height);


		# Free up memory.
		imagedestroy($orignal);

		# Save the picture to its destination.
		imagejpeg($resized, $destination, 75);

		# Free up memory.
		imagedestroy($resized);

		# Delete the original.
		unlink($this->filename);
	}

	private function new_width() {
		if ($this->resize()) {
			return $this->max_width;
		}
		else {
			return $this->width;
		}
	}

	private function new_height() {
		if ($this->needs_resize()) {
			return $this->height * $this->max_width / $this->width;
		}
		else {
			return $this->height;
		}
	}

	private function needs_resize() {
		return $this->width > $this->max_width;
	}
}
?>
