<?php
	require_once('./classes/ImageResize.php');

	class Image {
		public $folder = '.' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR;

		// Verifica se a imagem existe e retorna TRUE ou FALSE
		public function imageAlreadySave($image) {
			return file_exists($image);
		}

		// Pegar as imagens da URL, salva na pasta imagens e me retorna um array com o nome das imagens
		public function getImages() {
			$json =  file_get_contents('http://54.152.221.29/images.json');
			$obj = json_decode($json);

			foreach ($obj->images as $image) {
				$name = explode('/', $image->url);
				$name = $name[4];

				if (file_put_contents($this->folder . $name, file_get_contents($image->url))) {
					$images[] = $name;
				}
			}

			return $images;
		}

		// Gera os crops das imagens nos tamanhos small, medium, large e me retorna um objeto os endereços dos crops mais endereço da imagem original
		public function cropImages($image, $url) {
			$file = explode('.', $image);
			$name = $file[0];
			$extension = $file[1];

			$final = new stdClass();

			$final->original = $this->folder . $image;
			$final->small = $this->folder . $name . '_320x240' . '.' . $extension;
			$final->medium = $this->folder . $name . '_384x288' . '.' . $extension;
			$final->large = $this->folder . $name . '_640x480' . '.' . $extension;

			if (!$this->imageAlreadySave($final->small)) {
				$small = new \Eventviva\ImageResize($this->folder . $image);
				$small->resize(320, 240);
				$small->save($final->small);
			}

			if (!$this->imageAlreadySave($final->medium)) {
				$medium = new \Eventviva\ImageResize($this->folder . $image);
				$medium->resize(384, 288);
				$medium->save($final->medium);
			}

			if (!$this->imageAlreadySave($final->large)) {
				$large = new \Eventviva\ImageResize($this->folder . $image);
				$large->resize(640, 480);
				$large->save($final->large);
			}

			$final->original = str_replace($this->folder, $url, $final->original);
			$final->small = str_replace($this->folder, $url, $final->small);
			$final->medium = str_replace($this->folder, $url, $final->medium);
			$final->large = str_replace($this->folder, $url, $final->large);

			return $final;
		}

		// Verifica se a imagem já está cadastrada no banco, caso não esteja a salva
		public function saveImageIntoDB($images, $db) {
			$document = $db->findOne(array('original' => $images->original));

			if (!$document) {
				$db->insert($images);
			}
		}

		// Pegar todas as imagens salvas no banco de dados
		public function getImagesFromDB($db) {
			$images = $db->find([], ['_id' => false]);

			return $images;
		}
	}
?>