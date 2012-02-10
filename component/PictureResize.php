<?php
# Copyright © 2012 Martin Ueding <dev@martin-ueding.de>

require_once('NoGDException.php');

/**
 * A picture resize and copy job.
 */
class PictureResize {
	/**
	 * Maximum width of the new image.
	 *
	 * @var integer
	 */
	public $max_width = 300;

	/**
	 * Starts with the given files.
	 *
	 * Its properties are checked and stored internally.
	 *
	 * @param string $filename Image file to use.
	 */
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
				_(
					sprintf(
						'No function imagecreatefromjpeg. You need to have GD support to resize images. Try uploading a picture with at most %d pixels width.',
						$this->max_width
					)
				)
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

	/**
	 * Calculate the new width of the image.
	 *
	 * @return integer New width.
	 */
	private function new_width() {
		if ($this->needs_resize()) {
			return $this->max_width;
		}
		else {
			return $this->width;
		}
	}

	/**
	 * Calculate the new height of the image.
	 *
	 * @return integer New height.
	 */
	private function new_height() {
		if ($this->needs_resize()) {
			return $this->height * $this->max_width / $this->width;
		}
		else {
			return $this->height;
		}
	}

	/**
	 * Checks whether the image needs to be resized.
	 *
	 * @return boolean Whether needs resize.
	 */
	private function needs_resize() {
		return $this->width > $this->max_width;
	}
}
?>
