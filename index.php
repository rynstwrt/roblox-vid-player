<?php

	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

	$video = $_GET['video'];
	$fps = $_GET['fps'];
	$width = $_GET['width'];
	$height = $_GET['height'];
	
	function deleteLocalFiles()
	{
		$lastimages = glob("[0-9]*.{jpg,png,mp4,flv,mkv,webm}", GLOB_BRACE);
		foreach ($lastimages as $bimages)
		{
			unlink($bimages);
		}
	}

	function getRGB($imgname)
	{
		$img = imagecreatefrompng($imgname);
		$colorvals = array();
		for($x = 0; $x < imagesx($img); $x++)
		{
			for ($y = 0; $y < imagesy($img); $y++)
			{
				$color = imagecolorat($img, $x, $y);
				$r = ($color >> 16) & 0xFF;
				$g = ($color >> 8) & 0xFF;
				$b = $color & 0xFF;
				array_push($colorvals, array($r, $g, $b));
			}
		}
		return $colorvals;
	}

	$video = $GLOBALS['video'];
	$fps = $GLOBALS['fps'];
	$width = $GLOBALS['width'];
	$height = $GLOBALS['height'];
		
	deleteLocalFiles();

	//download video
	$file = getcwd() . "/video.mp4";
	$outputfiles = getcwd() . "/%d.png";
	file_put_contents($file, fopen($video, 'r'));
	
	//convert video to image sequence
	$cmd = sprintf("ffmpeg -i " . $file . " -vf scale=%dx%d,fps=%d", $width, $height, $fps);
	$cmdfull = $cmd . ' ' . $outputfiles;
	exec($cmdfull);

	$images = glob(getcwd() . "/[0-9]*.png");
	natsort($images);

	foreach ($images as $image)
	{
		$colarray = getRGB($image);
		echo json_encode($colarray);
	}

	deleteLocalFiles();

?>