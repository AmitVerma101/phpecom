<?php

class ProductController {
    private $db;
    private $ProductModel;

    public function __construct($db,$ProductModel){
        $this->db = $db;
        $this->ProductModel = $ProductModel;
    }
   
    public function fetchInitialProducts($pagination){
        $result = $this->ProductModel->fetchInitialProducts($pagination);
        $resultArray = [];
        while($row = pg_fetch_assoc($result)){
            $arr = $row;
            $resultArray[] = $arr;
        }
        return $resultArray;
    }

}
?>