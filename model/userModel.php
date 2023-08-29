<?php

class userModel{
    private $db;
    public function __construct($db){
        $this->db = $db;
    }
    public function checkLogin($username,$password){
        // $query  = 'select * from users where username = $1 and password = $2 and isActive = true';
        // $result = pg_query_params($this->db,$query,array($username,$password));
        // if($result != false){
        //     return $result;
        // }
        # changing this to get safe from sql injection
        $query = 'select * from users where username = $1 and password = $2 and isActive = true';
        #preparing the query;
        $stmt = pg_prepare($this->db,'my_query',$query);
        #executing the query;
        $result = pg_execute($this->db,'my_query',array($username,$password));
        if($result !== false){
            return $result;
        }
      
    }
    public function registerUser($obj){
        
            $query = 'select * from users where email = $1';
            $result = pg_query_params($this->db,$query,array($obj['email']));
            if($result !== false){
                if(pg_num_rows($result) === 0){
                    $query = 'insert into users (name,username,email,password,activation_code,activation_expiry) values($1,$2,$3,$4,$5,$6)';
                    $result = pg_query_params($this->db,$query,array($obj['name'],$obj['userName'],$obj['email'],$obj['password'],$obj['activation_code'],$obj['activation_expiry']));
                    if($result !== false){
                        return ['status'=>true,'msg'=>'signup successful'];
                    }
                    else {
                        return ['status'=>false,'code'=>400,'msg'=>'Error while inserting'];
                    }
                   
                }
            }
            else {
                return ['status'=>false,'code'=>402,'msg'=>'Email Already Exists'];
            }
    }
    public function validateEmail($activation_code){
        $query = 'select * from users where activation_code = $1';
        $result = pg_query_params($this->db,$query,array($activation_code));
        if($result !== false){
            if(pg_num_rows($result) === 1){
               $row = pg_fetch_assoc($result);
                    
                        $query = 'update users set isActive = true where email = $1';
                        $result = pg_query_params($this->db,$query,array($row['email']));
                        if($result !== false){
                                return true;
                            
                        }
                    

               }
            }
            return false;
        }

    public function updatePassword($password,$username){
        $query = 'update users set password = $1 where username = $2';
        $result = pg_query_params($this->db,$query,array($password,$username));
        return $result;
    }
    public function forgetEmailVerification($email){
        $query = 'select email from users where email = $1';
        $result = pg_query_params($this->db,$query,array($email));
        return $result;
    }
    public function updateVerificationCode($email,$activation_code,$activation_expiry){
        $query = 'update users set activation_code = $1 and activation_expiry = $2 where email = $3';
        $result = pg_query_params($this->db,$query,array($activation_code,$activation_expiry,$email));
        return $result;
    }
    
    
}

?>