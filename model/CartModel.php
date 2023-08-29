<?php
include 'utils/CustomException.php';
class CartModel{
    private $db;
    public function __construct($db){
        $this->db = $db;
    }
   public function getQuantity($productId,$username){
    #create an entry in cart if not exists
        try{
            $query = 'insert into cart (username,productid) values($1,$2)'; 
           $result = pg_query_params($this->db,$query,array($username,$productId));
          
            if($result === false){
                throw new CustomException('Cart already created for the product');
            }
            $query = 'select * from cart where username = $1 and productid = $2';
            $result = pg_query_params($this->db,$query,array($username,$productId));
            return $result;
        }
        catch(Exception $e){
            // ob_end_clean();
            // echo $e;
            $query = 'select * from cart where username = $1 and productid = $2';
            $result = pg_query_params($this->db,$query,array($username,$productId));
            return $result;
            // $query = 'select * from cart where username = $1 and productid = $2';
            // $result = pg_query_params($this->db,$query,array($username,$productId));
        }
    

   }
   public function addItemToCount($productId,$username){

        #creating a transaction
        #starting a transaction
        pg_query($this->db, "BEGIN");

        try {
            $query = 'update product set quantity = quantity-1 where productid = '.$productId.'and quantity > 0 returning *';
            $result = pg_query($this->db,$query);
            if($result !== false){
                if(pg_num_rows($result)>0){
                    $query = 'update cart set quantity = quantity+1 where productId = $1 and username = $2';
                    $result = pg_query_params($this->db,$query,array($productId,$username));
                    if($result !== false){
                        pg_query($this->db,'COMMIT');  
                        return ['status'=>true,'code'=>201,'msg'=>'successful'];
                    }
                    else {
                        throw new CustomException('Failed to execute query'.pg_last_error($this->db));
                    }
                     
                }
                return ['status'=>false,'code'=>204,'msg'=>'Out of Stocks'];
            }
            else {
                throw new CustomException('Failed to execute query'.pg_last_error($this->db));
            }

        }
        catch(Exception $e){
            // ob_end_clean(); 
            pg_query($this->db,'ROLLBACK');
            return ['status'=>false,'code'=>401,'msg'=>'Some Error Occurs'];    
        }
        
   }
   public function fetchCartProducts($username){
    try {
        $query = 'select * from fetchCartProduct where quantity>0 and username = $1';
        $result = pg_query_params($this->db,$query,array($username));
        #view create_cart_product_view
        // $query ='select create_cart_product_view($1)';
        // $result = pg_query_params($this->db,$query,array("$username"));
        if($result !== false){
            return $result;
        }
        else {
            throw new CustomException('Failed to execute query'.pg_last_error($this->db));
        }
        
    }catch(Exception $e){
        // ob_end_clean();
        return false;
    }
      
       
   }
   public function removeItemFromCart($productId,$username){
    #starting a transaction
    pg_query($this->db,'BEGIN');
    try {
        $query = 'delete from cart where productid = $1 and username = $2 returning *';
        $result = pg_query_params($this->db,$query,array($productId,$username));
        if($result !== false){
            if(pg_num_rows($result) == 1){
                $row = pg_fetch_assoc($result);
                $quantity = $row['quantity'];
                $query = 'update product set quantity = quantity+ $1 where productid = $2';
                $result = pg_query_params($this->db,$query,array($quantity,$productId));
                if($result !== false){
                    pg_query($this->db,'COMMIT');
                    return true;
                }
                else {
                    throw new CustomException('Failed to execute query'.pg_last_error($this->db));
                }
            }
        }
        else {
            throw new CustomException('Failed to execute query'.pg_last_error($this->db));
        }

    }catch(Exception $e){
        // ob_end_clean();
        pg_query($this->db,'ROLLBACK');
        return false;
    }
   
   }
   public function emptyCart($username){
    $query = 'update cart set quantity = 0 where username = $1';
    $result = pg_query_params($this->db,$query,array($username));
    if($result !== false){
        $query = 'select email from users where username = $1';
        $result = pg_query_params($this->db,$query,array($username));
        if($result !== false){
            $row = pg_fetch_assoc($result);
            return ['status'=>true,'email'=>$row['email']];
        }
    }
    return ['status'=>false];
   }
}

?>