# B2WPHP

O teste foi desenvolvido usando o PHP 5.6.25. 

No arquivo index.php altere o valor da constante "URL_IMAGES_APP" para o endereço da pasta de imagens no servidor.

No arquivo tests/ImageTest.php altere o valor da variavel "$this->URL_IMAGES_APP" para o endereço da pasta de imagens no servidor.

É necessário instalar o driver do MongoDB para PHP (http://php.net/manual/en/mongodb.installation.php) e o PHPUnit (https://phpunit.de/getting-started.html) para rodar os testes .

Para rodar os testes use o comando "phpunit --bootstrap classes/Image.php tests".
