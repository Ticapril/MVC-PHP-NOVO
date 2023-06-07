<?php 

namespace App\Http; 
use \Closure;
use \Exception;
use \ReflectionFunction;

class Router{
    /**
     * URL completa do projeto(raiz)
     * @var string
     */
    private $url = '';

    /**
     * Prefixo de todas as rotas
     * @var string
     */
    private $prefix = '';

    /**
     * Indice de rotas
     * @var array
     */
    private $routes = [];


    /**
     * Instancia de Request
     * @var Request
     */
    private $request;

    /**
     * Método responsável por iniciar a classe
     * @param string $url
     * 
     */
    public function __construct($url){
        $this->request = new Request();
        $this->url = $url;
        $this->setPrefix();
    }
    /**
     * Método responsável por definir o prefixo da rotas
     * 
     */
    private function setPrefix(){
        //INFORMAÇÕES DA URL ATUAL
        $parseUrl = parse_url($this->url);
        // echo '<pre>';
        // print_r($parseUrl);
        // echo '</pre>';
        // die;
       
        //DEFINE O PREFIXO
        $this->prefix = $parseUrl['path'] ?? '';
    }

    /**
     * Método responsável por adicionar uma rota na classe
     * @param string $method
     * @param string $route
     * @param array $params
     */
    private function addRoute($method, $route, $params = []){
 
       //VALIDAÇÃO DOS PARÂMETROS
       foreach ($params as $key => $value) {
        if($value instanceof Closure){
            $params['controller'] = $value;
            unset($params[$key]);
            continue;
        }
       }
        //VARIAVEIS DA ROTA
       $params['variables'] = [];

        //PADRÃO DE VALIDAÇÃO DAS VARIAVEIS DAS ROTAS
        $patternVariable = '/{(.*?)}/'; // qualquer string entre colchetes
        if(preg_match_all($patternVariable,$route,$matches)) {
                $route = preg_replace($patternVariable, '(.*?)', $route); // troca todas as ocorrencias com colchetes
                $params['variables'] = $matches[1]; // e armazeno nos params['variables'] meu array de valores
        }
       //PADRÃO DE VALIDAÇÃO DA URL
       $patternRoute = '/^'.str_replace('/', '\/', $route).'$/';
       //ADICIONA A ROTA DENTRO DA CLASSE
       $this->routes[$patternRoute][$method] = $params;
    }
    /**
     * Método responsável por definir Uma rota de GET
     * @param string $route
     * @param array $params
     */
    public function get($route, $params = []){
        return $this->addRoute('GET',$route, $params);
    }
    
    /**
     * Método responsável por definir Uma rota de POST
     * @param string $route
     * @param array $params
     */
    public function post($route, $params = []){
        return $this->addRoute('POST',$route, $params);
    }
    /**
     * Método responsável por definir ma rota de PUT
     * @param string $route
     * @param array $params
    */
    public function put($route, $params = []){
        return $this->addRoute('PUT',$route, $params);
    }
    /**
     * Método responsável por definir ma rota de DELETE
     * @param string $route
     * @param array $params
    */
    public function delete($route, $params = []){
        return $this->addRoute('DELETE',$route, $params);
    }
    /**
     * Método responsável por retornar a URI desconsiderando o prefixo 
     * @return string
    */
    private function getUri(){
        //URI DA REQUEST
        $uri = $this->request->getUri();
        //FATIA A URI COM O PREFIXO
        $xUri = strlen($this->prefix) ? explode($this->prefix, $uri) : [$uri];
        //RETORNA A URI SEM PREFIXO
        return end($xUri);
    }
    /**
     * Método responsável por retornar os dados da rota atual
     * @return array
     * 
    */
    private function getRoute(){
        //URI
        $uri = $this->getUri();
      
        //METHOD
        $httpMethod = $this->request->getHttpMethod();
     
        //VALIDA AS ROTAS
        foreach ($this->routes as $patternRoute => $methods) {
            // echo '<pre>';
            // print_r($this->routes);
            // echo '<br>';
            // die;
            //VERIFICA SE A URI BATE COM O PADRÃO /^\/$/ = QUALQUER STRING QUE SEJA IGUAL A ISSO -> /
            if(preg_match($patternRoute,$uri, $matches)){
                // echo '<pre>';
                // print_r($patternRoute);
                // echo '<br>';
                // print_r($uri);
                // echo '<br>';
                // print_r($matches);
                // echo '</pre>';
                // die;
                //VERIFICA O MÉTODO
                if(isset($methods[$httpMethod])){
                    //REMOVE A PRIMEIRA POSIÇÃO
                    unset($matches[0]);

                    // Variaveis processadas
                    $keys = $methods[$httpMethod]['variables']; // armazeno o array variables em keys
                    $methods[$httpMethod]['variables'] = array_combine($keys,$matches); // o valor de keys passou a ser a chave de $matches
                    $methods[$httpMethod]['variables']['request'] = $this->request;
                
                    //RETORNO DOS PARÂMETROS DA ROTA
                    return $methods[$httpMethod];
                }
                //MÉTODO NÃO PERMITIDO
                throw new Exception("Método não permitido", 405);
            }
        }
        //URL NÃO ENCONTRADA
        throw new Exception("URL não encontrada", 404);
    }
    /**
     * Método responsável por executar a rota atual
     * @return Response
    */
    public function run(){
        try {
            //OBTEM A ROTA ATUAL
            $route = $this->getRoute();
           
            //VERIFICA O CONTROLADOR
            if(!isset($route['controller'])){
                throw new Exception("Url não pode ser processada", 500);
            }
            //Argumentos da função
            $args = [];
            //reflextion 
            $reflection = new ReflectionFunction($route['controller']);
            foreach ($reflection->getParameters() as $parameter) {
                $name = $parameter->getName();
                $args[$name] = $route['variables'][$name] ?? '';
            }
        
            //RETORNA A EXECUÇÃO DA FUNÇÃO
            return call_user_func_array($route['controller'], $args);
            // throw new Exception("Página não encontrada", 404);
        } catch (Exception $exception) {
            return new Response($exception->getCode(),$exception->getMessage());
        }
    }
}