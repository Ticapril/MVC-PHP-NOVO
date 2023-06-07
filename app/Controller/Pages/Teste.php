<?php 


//Gerenciar as requisições que vão chegar na home
//receberá uma ação de consulta executa o model para obter os dados necessários para exibir para o usuário e depois passar esses dados para view ser retornada para o usuário

namespace App\Controller\Pages;

use \App\Utils\View;
use \App\Models\Entity\Organization;

class Teste extends Page {
   
    /**
     * Método responsável por retornar o conteúdo (view) da nossa home
     * @return string
     */
    public static function getTeste(){
        $objOrganization = new Organization();
        $content =  View::render('pages/teste', [
            'name' => $objOrganization->name,
            'description' => $objOrganization->description,
            'site' => $objOrganization->site
        ]);
        //RETORNA A VIEW RENDERIZADA
        return parent::getPage('Sobre > Gabriel', $content);
    }
}
