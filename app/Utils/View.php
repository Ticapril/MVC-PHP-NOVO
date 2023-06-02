<?php 

namespace App\Utils;


class View {
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
        //CHAVES DO ARRAY DE VARIAVEIS
        $keys = array_keys($vars);
        $keys = array_map(function($item) {
            return '{{'.$item.'}}';
        }, $keys);
        //RETORNA O CONTEÚDO RENDERIZADO
        // echo '<pre>';
        // print_r ($keys);
        // echo '</pre>';
        // echo '<hr>';
        // echo '<pre>';
        // print_r(array_values($vars));
        // echo '</pre>';
        // echo '<hr>';
        // echo '<pre>';
        // echo($contentView);
        // echo '</pre>';
        // die;
        return str_replace($keys, array_values($vars), $contentView);
    }
}