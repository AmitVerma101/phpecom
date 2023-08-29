<?php
class ProductModel{
    private $db;
    public function __construct($db){
        $this->db = $db;
    }
    public function fetchInitialProducts($pagination){
        $pagination = 5*$pagination;
        $query = 'select * from product where active = true order by productid offset $1 LIMIT 5';
        $result = pg_query_params($this->db,$query,array($pagination));
        if($result !== false){
            return $result;
        }
    }
    
} 

?>


