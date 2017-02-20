<?php
	use PHPUnit\Framework\TestCase;

	class ImageTeste extends TestCase {
		protected function setUp() {
			$this->Image = new Image();
			$this->folder = '.' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR;
			$this->URL_IMAGES_APP = 'http://localhost/B2WPHP/images/';
		}

		public function testShouldReturn1() {
			$expect = file_exists($this->folder . 'b737_1.jpg');

			$this->assertEquals($expect, $this->Image->imageAlreadySave($this->folder . 'b737_1.jpg'));
		}

		public function testShouldReturnNull() {
			$this->assertEquals(false, $this->Image->imageAlreadySave($this->folder . 'darwin.jpg'));
		}

		public function testShouldReturnImagesFromURL() {
			$expect = array('b737_5.jpg', 'b777_5.jpg', 'b737_3.jpg', 'b777_4.jpg', 'b777_3.jpg', 'b737_2.jpg', 'b777_2.jpg', 'b777_1.jpg', 'b737_4.jpg', 'b737_1.jpg');

			$this->assertEquals($expect, $this->Image->getImages());
		}

		public function testShouldGerenateCrops() {
			$expect = new stdClass();
			$expect->original = $this->URL_IMAGES_APP . 'b737_5.jpg';
			$expect->small = $this->URL_IMAGES_APP . 'b737_5_320x240.jpg';
			$expect->medium = $this->URL_IMAGES_APP . 'b737_5_384x288.jpg';
			$expect->large = $this->URL_IMAGES_APP . 'b737_5_640x480.jpg';

			$this->assertEquals($expect, $this->Image->cropImages('b737_5.jpg', $this->URL_IMAGES_APP . ''));
		}
	}
?>