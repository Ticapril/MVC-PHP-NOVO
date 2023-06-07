<?php

use \App\Http\Response;
use \App\Controller\Pages;

//ROTA HOME
$objRouter->get('/', [
    function(){
        return new Response(200, Pages\Home::getHome());
    }
]);
//ROTA Sobre
$objRouter->get('/sobre', [
    function(){
        return new Response(200, Pages\About::getAbout());
    }
]);
//ROTA Teste
$objRouter->get('/teste', [
    function(){
        return new Response(200, Pages\Teste::getTeste());
    }
]);
//ROTA DINÂMICA
$objRouter->get('/pagina/{idPage}/{action}', [
    function($idPage, $action){
        return new Response(200, "Página: $idPage - $action");
    }
]);

