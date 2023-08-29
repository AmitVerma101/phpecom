<?php
 
class AdminController {
    private $db;
    private $AdminModel;

    public function __construct($db,$AdminModel){
        $this->db = $db;
        $this->AdminModel = $AdminModel;
    }
    public function getAllSellers(){
        $result = $this->AdminModel->getAllSellers();
        return $result;
    }
   public function addNewSeller($email){
    $result = $this->AdminModel->addNewSeller($email);
    if($result['status'] == 200){
        #send mail
        $email = $result['data']['email'];
        $message = getMessageForSellerCreation($result['data']['username'],$result['data']['password']);
        $subject = 'New Seller Account confirmed';
        $mailResult = sendMailWithAttatchment($email,$message,$subject);
        if($mailResult == true){
            return ['status'=>200];
        }
        else {
            return $result;
        }

    }
    else {
        return $result;
    }
   }
   public function deleteSeller($username){
        $result = $this->AdminModel->deleteSeller($username);
        return $result;
   }
   public function deleteProduct($productid){
    $result = $this->AdminModel->deleteProduct($productid);
    return $result;
   }
}
?>