<?php 

namespace App\Utils;


class View {
    /**
     * Variáveis padrões da View
     * @var array
     */
    private static $vars = [];
    /**
     * Método responsável por definir os dados iniciais da classe
     * @param array $vars
     * 
     */
    public static function init($vars = []){
        // self::$vars = $vars;
        $this->vars = $vars;
    }
    /** Método responsável por retornar o conteúdo de uma view
     * @param string $view
     * @return string
     */
    private static function getContentView($view) {
        $file = __DIR__.'/../../assets/view/'.$view.'.html';
        return file_exists($file) ? file_get_contents($file) : '';
    }

    /** Método responsável por retornar o conteúdo renderizado de uma view
     * @param string $view
     * @param array $vars (strings/numerics)
     * @return string
     */
    public static function render($view, $vars = []) {
        //CONTEUDO DA VIEW
        $contentView = self::getContentView($view);
      
        //MERGE DE VARIAVEIS DA VIEW
        $vars = array_merge(self::$vars,$vars);
      
        //CHAVES DO ARRAY DE VARIAVEIS
        $keys = array_keys($vars); // armazena as chaves
       
        $keys = array_map(function($item) {
            return '{{'.$item.'}}';
        }, $keys); // cria um array keys array( [0] => '{{name}}', [1] => '{{description}}', [2] => 
        //RETORNA O CONTEÚDO RENDERIZADO
        return str_replace($keys, array_values($vars), $contentView); // substitui as chaves {{name}} pelo seu respectivo valor passado pra view
        //sempre O que trocar?, quem trocar, onde trocar?
    }
}