<?php 

namespace App\Http; 

class Request {
    /**
     * Método HTTP DA requisição
     * @var string
     */
    private $httpMethod;
    /**
     * URI da página
     * @var string
     */
    private $uri;
    /**
     * Parâmetros da URL ($_GET)
     * @var array
     */
    private $queryParams = [];

    /**
     * Variáveis recebidos no POST da página ($_POST)
     * @var array
     */
    private $postVars = [];

    /**
     * Cabeçalho da requisição
     * @var array
     */
    private $headers = [];

    public function __construct(){
        $this->queryParams = $_GET ?? [];
        $this->postVars = $_POST ?? [];
        $this->headers = getallheaders();
        $this->httpMethod = $_SERVER['REQUEST_METHOD'] ?? '';
        $this->uri = $_SERVER['REQUEST_URI'] ?? '';       
    }
    /**
     * Método responsável por retornar o método http da requisição
     * @return string
     */
    public function getHttpMethod(){
        return $this->httpMethod;
    }
     /**
     * Método responsável por retornar a uri da requisição
     * @return string
     */
    public function getUri(){
        return $this->uri;
    }
     /**
     * Método responsável por retornar os parametros da URL
     * @return array
     */
    public function getQueryParams(){
        return $this->headers;
    }
     /**
     * Método responsável por retornar as variaveis Post da requisição
     * @return array
     */
    public function getPostVars(){
        return $this->postVars;
    }
      /**
     * Método responsável por retornar os headers da requisição
     * @return array
     */
    public function getHeaders(){
        return $this->headers;
    }
}