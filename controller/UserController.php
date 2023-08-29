<?php

class UserController {
    private $db;
    private $userModel;

    public function __construct($db,$userModel){
        $this->db = $db;
        $this->userModel = $userModel;
    }
    public function validateUser($username,$password){
        $result = $this->userModel->checkLogin($username,$password);
       
        if(pg_num_rows($result)>0){ 
            $row = pg_fetch_assoc($result);
            if($row['usertype'] == 'admin'){
                return ['flag'=>'1','isAdmin'=>'1'];
            }
            else if($row['usertype'] == 'user'){
                if($row['isactive'] == true){
                    return ['flag'=>'1','isAdmin'=>'0','isActive'=>true];
                }
                else {
                    return ['flag'=>'0','isAdmin'=>'0','isActive'=>false];
                }
                
            }
            else {
                return ['flag'=> '0','isAdmin'=>'0'];
            }
            
        }else {
            return ['flag'=>'0','isAdmin'=>'0'];
        }
    }
   
    public function registerUser($obj){
        $obj['activation_code'] = generate_activation_code();
        $obj['activation_expiry'] = generate_activation_expiry();
        $result = $this->userModel->registerUser($obj);
         if($result['status'] == true){
            $url = APP_URL;
            $message = emailVerificationMessage($url,$obj['activation_code']);
            $subject = 'Verify Email Address';
            $emailResult = sendMail($obj['email'],$message,$subject);
            if($emailResult == true){
                return ['status'=>true,'code'=>200,'msg'=>'Email Sent Successfully'];
            }
            else {
                return ['status'=>false,'code'=>303,'msg'=>'Error sending mail'];
            }
         }
         return $result;
    }
    public function validateEmail($activation_code){
        $result = $this->userModel->validateEmail($activation_code);
        return $result;
        

    }
    
   
    public function fetchProducts(){
        $result = $this->userModel->fetchProducts();
        $resultArray = [];
        while($row = pg_fetch_assoc($result)){
            $arr = array('productId'=>$row['productid'],'title'=>$row['title'],'dateofrelease'=>$row['dateofrelease'],'status'=>$row['status'],'userreview'=>$row['userreview'],'img'=>$row['img'],'active'=>$row['active']);
            $resultArray[] = $arr;
        }
        return $resultArray;
    }
    public function updatePassword($password,$username){
        $result = $this->userModel->updatePassword($password,$username);
        if($result !== false){
            return ['status'=>true,'code'=>200];
        }
        else {
            return ['status'=>false,'code'=>500];
        }
    }

    public function forgetEmailVerification($email){
        $result = forgetEmailVerification($email);
        if($result !== false){
            if(pg_num_rows($result) == 0){
                return ['status'=>false,'code'=>203,msg=>'No user with this email id exists'];
            }
            else {
                $activation_code = generate_activation_code();
                $activation_expiry = generate_activation_expiry();
                $result = updateVerificationCode($email,$activation_code,$activation_expiry);
                if($result !== false){
                    $url =APP_URL;
                    $message = getForgetPasswordMessage($url,$activation_code);
                    $subject = 'Click on link below to change password';
                    $result = sendMail($email,$message,$subject);
                    if($result == true){
                        return ['status'=>true,'code'=>200,'msg'=>'An Email has been sent to your email'];

                    }
                    else {
                        return ['status'=>false,'code'=>203,'msg'=>'Error Sending mail'];
                    }

                }
                else {
                    return ['status'=>false,'code'=>203,'msg'=>'Error generation code'];
                }

            }
        }
        else {
            return ['status'=>false,'code'=>401,'msg'=>'An Error Occurs'];
        }
    }
   
   
}
?>