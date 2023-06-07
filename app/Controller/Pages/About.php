<?php 
//Gerenciar as requisições que vão chegar na home
//receberá uma ação de consulta executa o model para obter os dados necessários para exibir para o usuário e depois passar esses dados para view ser retornada para o usuário
namespace App\Controller\Pages;

use \App\Utils\View;
use \App\Models\Entity\Organization;

class About extends Page {
    /**
     * Método responsável por retornar o conteúdo (view) da nossa home
     * @return string
     */
    public static function getAbout(){
        $objectOrganization = new Organization(); //executa a model cria uma instancia da model [Organization, Produto, Aluno, ObjetoQualquer]
        $content            = View::render('pages/about',[
            'name' => $objectOrganization->name,
            'description' => $objectOrganization->description,
            'site' => $objectOrganization->site
        ]);// $content recebe o conteudo renderizado da view
        //RETORNA A VIEW RENDERIZADA
        return parent::getPage('Sobre > Gabriel', $content);
    }
}
