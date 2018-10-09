<?php

	$video = $_GET['video'];
	$fps = $_GET['fps'];
	$width = $_GET['width'];
	$height = $_GET['height'];
	
	function deleteLocalFiles() {
		$lastimages = glob("[0-9]*.{jpg,png,mp4,flv,mkv,webm}", GLOB_BRACE);
		foreach ($lastimages as $bimages) {
			unlink($bimages);
		}
	}

	function start() {
		$video = $GLOBALS['video'];
		$fps = $GLOBALS['fps'];
		$width = $GLOBALS['width'];
		$height = $GLOBALS['height'];

		if ($video) {
			if (strpos($video, ".mp4") !== false or strpos($video, ".webm") !== false or strpos($video, ".ogv") !== false or strpos($video, ".gif") !== false or strpos($video, ".flv") !== false) {
				deleteLocalFiles();
				function getRGB($imgname) {
					$img = ImageCreateFromPng($imgname);
					$colorvals = array();
					for($x = 0; $x < imagesx($img); $x++) {
						for ($y = 0; $y < imagesy($img); $y++) {
							$color = imagecolorat($img, $x, $y);
							$r = ($color >> 16) & 0xFF;
							$g = ($color >> 8) & 0xFF;
							$b = $color & 0xFF;
							array_push($colorvals, $r.' '.$g.' '.$b);
						}
					}
					return $colorvals;
				}

				file_put_contents("video.mp4", fopen($video, 'r'));
				echo("YEEEET")
				deleteLocalFiles();

			} else {
				echo "\"".$video."\" Is not one of the accepted video types!";
			}
		} else {
			echo "Missing arguments!";
		}
	}
	start();

?>