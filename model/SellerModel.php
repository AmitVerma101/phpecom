<?php
include 'utils/CustomException.php';
class SellerModel{
    private $db;
    public function __construct($db){
        $this->db = $db;
    }
   public function getOrders($username){
        $query = "select e4.* from orders e3 inner join (select e1.title,e1.img,e1.description,e2.* from product e1 inner join order_details e2 on e1.productid = e2.productid and e1.sellerid = (select id from users where username = $1))e4 on e3.orderid = e4.orderid and e4.order_status = 'pending' and e4.payment_status = 'paid'";
        $result = pg_query_params($this->db,$query,array($username));
        if($result !== false){
            return $result;
        }
   }
   public function fetchSellerProducts($username){
    $query = 'select * from product where sellerid = (select id from users where username = $1) and active = true ';
    $result = pg_query_params($this->db,$query,array($username));
    if($result !== false){
        $resultArray = [];
        while($row = pg_fetch_assoc($result)){
            $priceResultArray = [];
            $query = 'select old_price,time_of_change from price_history where productid = $1  order by time_of_change desc';
            $priceResult = pg_query_params($this->db,$query,array($row['productid']));
            if($result !== false){
                while($pricerow = pg_fetch_assoc($priceResult)){
                    $priceResultArray[] = [$pricerow['old_price'],date("Y-m-d",strtotime($pricerow['time_of_change']))];
                }
            }
            $row['oldprices'] = $priceResultArray;
            $arr = $row;
            $resultArray[] = $arr;
        }
        return $resultArray;
        return $result;
    }
}

public function getProductDetails($id){
    $query = 'select * from product where productid = $1';
    $result = pg_query_params($this->db,$query,array((int)$id));
    if($result !== false){
        return $result;
    }
}

public function updateSellerProduct($username,$usertype,$data){
    if($data['img']!=""){
        $query = 'update product set title = $1,description = $2,quantity = $3,price = $4,img = $5 where productid = $6 returning *';
        $result = pg_query_params($this->db,$query,array($data['title'],$data['description'],$data['quantity'],$data['price'],$data['img'],$data['productid']));
    }
    else {
        $query = 'update product set title = $1,description = $2,quantity = $3,price = $4 where productid = $5 returning *';
        $result = pg_query_params($this->db,$query,array($data['title'],$data['description'],$data['quantity'],$data['price'],$data['productid']));
    }
    if($result !==false){
        $row = pg_fetch_assoc($result);
        return $row;
    }
    return [];
}

public function updateProduct($username,$usertype,$stripeData){
       
    $query = 'update product set stripe_product_id = $1,stripe_price_id = $2 where productid = $3';
    $result = pg_query_params($this->db,$query,array($stripeData['product_id'],$stripeData['price_id'],$stripeData['productid']));
    if($result !== false){
        return true;
    }
    return false;

}

public function addProduct($username,$usertype,$data){
    $query = "select id from users where username = $1 and usertype = 'seller'";
    $result = pg_query_params($this->db,$query,array($username));
    if($result !== false){
        $row = pg_fetch_assoc($result);
        $query = 'insert into product (title,dateofrelease,status,userreview,img,active,quantity,price,description,sellerid) values($1,$2,$3,$4,$5,$6,$7,$8,$9,$10) returning *';
        $result = pg_query_params($this->db,$query,array($data['title'],date('Y-m-d'),'positive',1,$data['img'],true,$data['quantity'],$data['price'],$data['description'],$row['id']));
        if($result !== false){
            return ['flag'=>true,'productid'=>pg_fetch_assoc($result)['productid']];
        }
    }
   return false;
}
public function deleteProduct($productid){
    $query = 'update product set active = false where productid = $1';
    $result = pg_query_params($this->db,$query,array($productid));
    return $result;
}
public function acceptOrder($orderid,$productid,$keyArray){
    pg_query($this->db,'BEGIN');
    try {
        $query = 'update order_details set order_status = $1 where orderid = $2 and productid = $3 returning *';
        $result = pg_query_params($this->db,$query,array('resolve',$orderid,$productid));
        if($result !== false){
            foreach($keyArray as $key){
                $query = 'insert into gamekeys values($1,$2,$3)';
                $gameKeyResult = pg_query_params($this->db,$query,array($orderid,$productid,$key)); 
                if($gameKeyResult === false){
                    throw new CustomException('Failed to execute query'.pg_last_error($this->db));
                }
            }
        pg_query($this->db,'COMMIT');
            return true;
        }
        else {
            throw new CustomException('Failed to execute query'.pg_last_error($this->db));
        }
    }
    catch(Exception $e){
        ob_end_clean();
        pg_query($this->db,'ROLLBACK');
        return false;
    }
   
    
}
public function rejectOrder($orderid,$productid){
    #starting transaction
    pg_query($this->db,'BEGIN');
    try {
        $query ='update order_details set order_status = $1 where orderid = $2 and productid = $3 returning *';
        $result = pg_query_params($this->db,$query,array('reject',$orderid,$productid));
        if($result !== false){
            #adding the products
            while($row = pg_fetch_assoc($result)){
                $query = 'update product set quantity = quantity+$1 where productid = $2';
                $result = pg_query_params($this->db,$query,array($row['quantity'],$row['productid']));
                if($result !== false){
                    pg_query($this->db,'COMMIT');
                    return true;

                }
                else {
                throw new CustomException('Failed to execute query'.preg_last_error($this->db));
                }
            }
        }
        else {
            throw new CustomException('Failed to execute query'.preg_last_error($this->db));
        }
    }
    catch(Exception $e){
        ob_end_clean();
        pg_query($this->db,'ROLLBACK');
        return false;
    }
}


} 

?>