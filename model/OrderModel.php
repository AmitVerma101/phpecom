<?php
class OrderModel{
    private $db;
    public function __construct($db){
        $this->db = $db;
    }
   public function placeOrder($username){
    #place order 
        $query = 'select e1.price,e1.stripe_price_id,e2.* from product e1 inner join(select * from Cart where quantity > 0 and username = $1)e2 on e1.productid = e2.productid';
        $result = pg_query_params($this->db,$query,array($username));
        
        $finalArr = [];
      
        if($result !== false){
            $noofrows = pg_num_rows($result);
            if($noofrows> 0){
                 # create a new order id if the cart contains some item
                 $query = 'insert into orders (username,order_status,payment_status) values($1,$2,$3) returning *';
                 $result1 = pg_query_params($this->db,$query,array($username,'pending','pending'));
                 
                 if($result1 !== false){
                    #calculating the overall price of the cart
                   
                    $i = 0;
                    $orderrow = pg_fetch_assoc($result1);
                    # add all the order items into the order details table
                    while($i<$noofrows){
                       
                        $row = pg_fetch_assoc($result);
                        $row['orderid'] = $orderrow['orderid'];
                        $finalArr[] = $row;
                        $price = ($row['quantity']*$row['price']);
                        $query = 'insert into order_details (orderid,productid,quantity,total_price) values($1,$2,$3,$4)';
                        $result2 = pg_query_params($this->db,$query,array($orderrow['orderid'],$row['productid'],$row['quantity'],$price));
                        $i++;
                    }
                    #updating the overall price of the order
                    // $query = 'update orders set price = $1 where orderid = $2';
                    // $result = pg_query_params($this->db,$query,array($price,$orderrow['orderid']));
                    // if($result !== false){
                        #deleting entry from cart
                        // $query = 'delete from cart where quantity > 0 and username = $1';
                        // $result = pg_query_params($this->db,$query,array($username));
                        // if($result !== false){
                            $finalArr[0]['flag'] = true;
                            return $finalArr;
                        // }
                    // }
                 }
            }
           
        }
        $finalArr[0]['flag'] = false;
        return $finalArr;
 }
    #fetch all the placed orders

    public function fetchUserOrders($username){
       
        $query = 'select e3.img,e3.title,e4.* from product e3 inner join (select e1.* from order_details e1 inner join orders e2 on e1.orderid = e2.orderid and e2.username = $1)e4 on e3.productid = e4.productid';
        $result = pg_query_params($this->db,$query,array($username));
        $resultArray = [];
        if($result !== false){
            if(pg_num_rows($result) > 0){
               
                while($row = pg_fetch_assoc($result)){
                    $keysArray = [];
                    $keysQuery = 'select * from gamekeys where orderid = $1 and productid = $2';
                    $keysQueryResult = pg_query_params($this->db,$keysQuery,array($row['orderid'],$row['productid']));
                    if($keysQueryResult !== false){
                        while($keyRow = pg_fetch_assoc($keysQueryResult)){
                            $keysArray[] = $keyRow['game_key'];
                        }
                    }
                    $row['game_key'] = $keysArray;
                    $resultArray[] = $row;
                   
                }
                return $resultArray;
            }
            else {
                return $resultArray;
            }
        }
        return $resultArray;

    } 
    public function confirmPaymentStatus($orderid){
        $query = 'update order_details set payment_status = $1 where orderid = $2';
        $result = pg_query_params($this->db,$query,array('paid',$orderid));
        if($result !== false){
            return true;
        }
        return false;
    }
  
}  
?>