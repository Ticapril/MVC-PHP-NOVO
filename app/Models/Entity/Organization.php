<?php 

namespace App\Models\Entity;

class Organization {
    /**
     * ID da organização
     * @var integer
     */
    public $id = 1;
    /**
     * Nome da Organização
     * @var string
     */
    public $name = 'Gabriel Olivera';
      /**
     * site da Organização
     * @var string
     */
    public $site = 'https://siteExemplo.com.br';

      /**
     * Descrição da Organização
     * @var string
     */
    public $description = 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Vel libero dicta, iure aspernatur laborum ab omnis nobis cupiditate inventore reprehenderit excepturi aliquam nihil dolor aliquid. Sed, tempore? Numquam, non veritatis?';
}