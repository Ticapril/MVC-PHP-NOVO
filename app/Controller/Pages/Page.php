<?php 


//Gerenciar as requisições que vão chegar na home
//receberá uma ação de consulta executa o model para obter os dados necessários para exibir para o usuário e depois passar esses dados para view ser retornada para o usuário

namespace App\Controller\Pages;

use \App\Utils\View;

class Page {
    /**
     * Método responsável por renderizar o header da página
     * @return string 
     */
    private static function getHeader(){
        return View::render('pages/header');
    }

     /**
     * Método responsável por renderizar o footer da página
     * @return string 
     */
    private static function getFooter(){
        return View::render('pages/footer');
    }



    /**
     * Método responsável por retornar o conteúdo da nossa página genérica
     * @return string
     */
    public static function getPage($title, $content){
        return View::render('pages/page', [
            'title' => $title,
            'header' => self::getHeader(),
            'content' => $content,
            'footer' => self::getFooter(),
        ]);
    }
}
