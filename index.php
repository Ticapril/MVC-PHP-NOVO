<?php 

require __DIR__ .'/vendor/autoload.php';

use \App\Http\Response;
use \App\Http\Router;
use \App\Utils\View;
use \App\Controller\Pages\Home;

define('URL', 'http://localhost/projeto3');


// DEFINE O VALOR PADRÃO DAS VARIAVEIS
View::init([
    'URL' => URL
]);


//INICIA O ROUTER
$objRouter = new Router(URL);

//INCLUI AS ROTAS DE PÁGINAS
include __DIR__ .'/routes/pages.php';

//IMPRIME O RESPONSE DA ROTA
$objRouter->run()
          ->sendResponse();