<?php
	require_once('./classes/ImageResize.php');

	class Image {
		public function imageAlreadySave($image) {
			return file_exists($image);
		}

		public function getImages() {
			$json =  file_get_contents('http://54.152.221.29/images.json');
			$obj = json_decode($json);

			foreach ($obj->images as $image) {
				$name = explode('/', $image->url);
				$name = $name[4];

				if (file_put_contents('./images/' . $name, file_get_contents($image->url))) {
					$images[] = $name;
				}
			}

			return $images;
		}

		public function cropImages($image, $url) {
			$file = explode('.', $image);
			$name = $file[0];
			$extension = $file[1];

			$final = new stdClass();

			$final->original = './images/' . $image;
			$final->small = './images/' . $name . '_320x240' . '.' . $extension;
			$final->medium = './images/' . $name . '_384x288' . '.' . $extension;
			$final->large = './images/' . $name . '_640x480' . '.' . $extension;

			if (!$this->imageAlreadySave($final->small)) {
				$small = new \Eventviva\ImageResize('./images/' . $image);
				$small->resize(320, 240);
				$small->save($final->small);
			}

			if (!$this->imageAlreadySave($final->medium)) {
				$medium = new \Eventviva\ImageResize('./images/' . $image);
				$medium->resize(384, 288);
				$medium->save($final->medium);
			}

			if (!$this->imageAlreadySave($final->large)) {
				$large = new \Eventviva\ImageResize('./images/' . $image);
				$large->resize(640, 480);
				$large->save($final->large);
			}

			$final->original = str_replace('./images/', $url, $final->original);
			$final->small = str_replace('./images/', $url, $final->small);
			$final->medium = str_replace('./images/', $url, $final->medium);
			$final->large = str_replace('./images/', $url, $final->large);

			return $final;
		}

		public function saveImageIntoDB($images, $db) {
			$document = $db->findOne(array('original' => $images->original));

			if (!$document) {
				$db->insert($images);
			}
		}

		public function getImagesFromDB($db) {
			$images = $db->find([], ['_id' => false]);

			return $images;
		}
	}
?>