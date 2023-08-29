<?php
class AdminModel{
    private $db;
    public function __construct($db){
        $this->db = $db;
    }
    public function getAllSellers(){
        #fetching all sellers from the db
        $query = "select * from users where usertype = 'seller' and isActive = true";
        $sellers = pg_query($this->db,$query);
        $finalArr = [];
        if($sellers !== false){
            if(pg_num_rows($sellers)>0){
                
                while($singleSeller = pg_fetch_assoc($sellers)){
                    $sellerProducts = [];
                    $fetchProductsQuery = 'select * from product where active = true and sellerid = $1';
                    $products = pg_query_params($this->db,$fetchProductsQuery,array($singleSeller['id']));
                    if($products !== false){
                            
                            $singleSellerProduct = [];
                            while($product = pg_fetch_assoc($products)){
                                $query = 'select old_price,time_of_change from price_history where productid = $1 order by time_of_change desc';
                                $result = pg_query_params($this->db,$query,array($product['productid']));
                                $arr = [];
                                if($result !== false){
                                    while($row = pg_fetch_assoc($result)){
                                        $arr[] = [$row['old_price'],date("Y-m-d",strtotime($row['time_of_change']))];
                                        // $arr[] = $row['time_of_change'];
                                    }
                                }
                                $product['oldprices'] = $arr;
                                $singleSellerProduct[] = $product; 
                            }
                            $sellerProducts[] = ['sellerid'=>$singleSeller['username'],'products'=>$singleSellerProduct];
                            $finalArr[] = $sellerProducts;

                        
                    }

                }

            }
        }
        return $finalArr;
    }
    public function addNewSeller($email) {
        $query = 'select * from users where email = $1';
        $usersWithSameEmail = pg_query_params($this->db,$query,array($email));
        if($usersWithSameEmail !== false){
            if(pg_num_rows($usersWithSameEmail)>0){
                return ['status'=>409];
            }
            else {
                $hash = bin2hex(random_bytes(5));
                $username = 'susername'.$hash;
                $name = 'sname'.$hash;
                $password = 'spassword'.$hash;
                $insertUserQuery = 'insert into users (username,password,name,usertype,email,isActive) values($1,$2,$3,$4,$5,true) returning *';
                $insertUserResult = pg_query_params($this->db,$insertUserQuery,array($username,$password,$name,'seller',$email));
                if($insertUserResult !== false){
                    return ['status'=>200,'data'=>pg_fetch_assoc($insertUserResult)];
                }

            }
        }
        return ['status'=>400];
    }
    public function deleteSeller($username){
        $deleteSellerQuery = 'update users set isActive = false where username = $1';
        $deleteSellerQueryResult = pg_query_params($this->db,$deleteSellerQuery,array($username));
        if($deleteSellerQueryResult !== false){
            #delete all the products also
            $deleteProductsQuery = 'update product set active = false where sellerid = (select id from users where username = $1 and usertype = $2)';
            $deleteProductQueryResult = pg_query_params($this->db,$deleteProductsQuery,array($username,'seller'));
            if($deleteProductQueryResult !== false){
                return ['status'=>200];
            }
            else {
                return ['status'=>400];
            }
           
        }
        else{
            return ['status'=>400];
        }
    }
    public function deleteProduct($productid){
        $deleteProductQuery = 'update product set active = false where productid = $1';
        $deleteProductQueryResult = pg_query_params($this->db,$deleteProductQuery,array($productid));
        if($deleteProductQueryResult !== false){
            return ['status'=>200];
        }
        else {
            return ['status'=>400];
        }

    }
} 

?>