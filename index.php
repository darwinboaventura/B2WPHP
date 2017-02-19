<?php
	require_once('./classes/Image.php');

	// Consts Application
	define('URL_IMAGES_APP', 'http://localhost/b2w/images/');

	// MongoDB Connection
	$connection = new MongoClient();
	$db = $connection->b2w->images;

	// Class images
	$images = new Image();

	foreach ($images->getImages() as $image) {
		$crops = $images->cropImages($image, URL_IMAGES_APP);

		$images->saveImageIntoDB($crops, $db);
	}

	$imgsFromDB = $images->getImagesFromDB($db);

	foreach ($imgsFromDB as $img) {
		$json[] = $img;
	}

	print_r(json_encode($json));
?>