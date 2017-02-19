<?php
	use PHPUnit\Framework\TestCase;

	class ImageTeste extends TestCase {
		protected function setUp() {
			$this->Image = new Image();
		}

		public function testShouldReturn1() {
			$this->assertEquals(1, $this->Image->imageAlreadySave('./images/b737_1.jpg'));
		}

		public function testShouldReturnNull() {
			$this->assertEquals(false, $this->Image->imageAlreadySave('./images/darwin.jpg'));
		}

		public function testShouldReturnImagesFromURL() {
			$expect = array('b737_5.jpg', 'b777_5.jpg', 'b737_3.jpg', 'b777_4.jpg', 'b777_3.jpg', 'b737_2.jpg', 'b777_2.jpg', 'b777_1.jpg', 'b737_4.jpg', 'b737_1.jpg');

			$this->assertEquals($expect, $this->Image->getImages());
		}

		public function testShouldGerenateCrops() {
			$expect = new stdClass();
			$expect->original = 'http://localhost/b2w/images/b737_5.jpg';
			$expect->small = 'http://localhost/b2w/images/b737_5_320x240.jpg';
			$expect->medium = 'http://localhost/b2w/images/b737_5_384x288.jpg';
			$expect->large = 'http://localhost/b2w/images/b737_5_640x480.jpg';

			$this->assertEquals($expect, $this->Image->cropImages('b737_5.jpg', 'http://localhost/b2w/images/'));
		}
	}
?>