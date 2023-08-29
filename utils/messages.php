
<?php
function getMessageForSellerCreation($username,$password){
    $messageForNewSeller = 'You Officially Becomes a Seller at Steam Your Username: '.$username.' and password is: '.$password;
    return $messageForNewSeller;
}

function emailVerificationMessage($url,$activation_code){
    $message = 'Please verify your email address '.$url. '/auth/validateEmail.php?code='.$activation_code;
    return $message;
}

function getForgetPasswordMessage($url,$activation_code){
    $message = 'Click on the link to change the password'.$url.'/forget.php?code='.$activation_code;
    return $message;
}
?>