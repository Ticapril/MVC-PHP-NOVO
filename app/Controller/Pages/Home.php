<?php 


//Gerenciar as requisições que vão chegar na home
//receberá uma ação de consulta executa o model para obter os dados necessários para exibir para o usuário e depois passar esses dados para view ser retornada para o usuário

namespace App\Controller\Pages;

use \App\Utils\View;
use \App\Models\Entity\Organization;

class Home extends Page {
   
    /**
     * Método responsável por retornar o conteúdo (view) da nossa home
     * @return string
     */
    public static function getHome(){
        $objOrganization = new Organization();
        // echo '<pre>';
        // print_r($objOrganization);
        // echo '</pre>';
        // die; 
        $content =  View::render('pages/home', [
            'name' => $objOrganization->name,
            'description' => $objOrganization->description,
            'site' => $objOrganization->site
        ]);
        //RETORNA A VIEW RENDERIZADA
        return parent::getPage('Gabriel Home', $content);
    }
}
