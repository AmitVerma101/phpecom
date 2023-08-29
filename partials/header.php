
<?php 
    require_once 'config/env.php';
    $url = APP_URL;
    if(isset($_SESSION['user_type'])){
        if($_SESSION['user_type'] == 'user'){
            $url = $url."/products.php";
        }else if($_SESSION['user_type'] == 'seller'){
            $url = $url."/sellerPage.php";
        }else{
            $url = $url."/adminDashboard.php";
        }
    }
   
if(isset($_SESSION['username'])){
    $username = $_SESSION['username'];
}
?>
<header class="flex-row js-bt ai-cn">
    <nav class="nav">
        <div>
        <?php  echo "<a href=\"$url\"><img class=\"logo\" src=\"image/login/logo_steam.svg\"></a>"?>
        </div>
        <?php if( !isset($_SESSION['user_type']) ) { 
        
         echo  '<div class="nav-btn-cluster">
            <button id="seller-login-btn" class="btn nav-collapse-btn">Seller Login</button>
            <button id="login-btn" class="btn">Login</button>
            <button id="hamburger-btn" onclick="navDivOpen()">
                <div id="hamburger-inside">
                    <div class="upper-line div-line"></div>
                    <div class="middle-line div-line"></div>
                    <div class="bottom-line div-line"></div>
                </div>
            </button>
        </div>';
        }
        
         else if($_SESSION['user_type'] === 'admin'){ 
           echo "<div class=\"flex-row nav-btn-cluster\">
                <button onclick=\"window.location.href='adminDashboard.php'\" class=\"btn nav-collapse-btn\">AdminDashBoard</button>
               
                <button id=\"logout-btn\" class=\"btn\">Logout</button>
                <button id=\"hamburger-btn\" onclick=\"navDivOpen()\">
                    <div id=\"hamburger-inside\">
                        <div class=\"upper-line div-line\"></div>
                        <div class=\"middle-line div-line\"></div>
                        <div class=\"bottom-line div-line\"></div>
                    </div>
                </button>
            </div>";
        }
        
         else if($_SESSION['user_type'] === 'seller'){ 
          echo  "<div class=\"flex-row nav-btn-cluster\">
                <p style=\"margin-right: 20px;\" id=\"user-nav\" class=\"dark-text\">$username</p>
                <button onclick=\"window.location.href = 'sellerPage.php'\" class=\"btn nav-collapse-btn\">SellerDashboard</button>
                <button onclick=\"window.location.href = 'sellerOrder.php'\" class=\"btn nav-collapse-btn\">Order</button>
                <button id=\"logout-btn\" class=\"btn\">Logout</button>
                <button onclick=\"window.location.href = 'changePassword.php'\" class=\"btn nav-collapse-btn\">ChangePassword</button>
                <button id=\"hamburger-btn\" onclick=\"navDivOpen()\">
                    <div id=\"hamburger-inside\">
                        <div class=\"upper-line div-line\"></div>
                        <div class=\"middle-line div-line\"></div>
                        <div class=\"bottom-line div-line\"></div>
                    </div>
                </button>
            </div>";
        }
            
        else{
           echo "<div class=\"flex-row nav-btn-cluster\">
                <p style=\"margin-right: 20px;\" id=\"user-nav\" class=\"dark-text\">$username</p>
                <button onclick=\"window.location.href = 'changePassword.php'\" class=\"btn nav-collapse-btn\">ChangePassword</button>
                <button onclick=\"window.location.href='products.php'\" class=\"btn nav-collapse-btn\">Product</button>
                <button onclick=\"window.location.href='cart.php'\" class=\"btn nav-collapse-btn\">Cart</button>
                <button onclick=\"window.location.href = 'order.php'\" class=\"btn nav-collapse-btn\">Order</button>
                <button id=\"logout-btn\" class=\"btn\">Logout</button>
                <button id=\"hamburger-btn\" onclick=\"navDivOpen()\">
                    <div id=\"hamburger-inside\">
                        <div class=\"upper-line div-line\"></div>
                        <div class=\"middle-line div-line\"></div>
                        <div class=\"bottom-line div-line\"></div>
                    </div>
                </button>
            </div>";
        }
        ?>
        </nav>
</header>
<div id="nav-expand-div"></div>
    
<script>

var loginBtn = document.getElementById('login-btn');
var logoutBtn = document.getElementById('logout-btn');
var sellerLoginBtn = document.getElementById('seller-login-btn');

if(logoutBtn==null){
    loginBtn.addEventListener('click',loginFun);
    sellerLoginBtn.addEventListener('click',sellerFun);
}else{
    logoutBtn.addEventListener('click',logoutFun);
}

function sellerFun(){
    window.location.href = 'sellerLogin.php';
}

function loginFun(){
    window.location.href = "login.php";
}

function signupFun(){
    window.location.href = "signup.php";
}

function navDivOpen(){
    let openDiv = document.getElementById('nav-expand-div');

    let innerDiv = document.createElement('div');
    innerDiv.setAttribute('id','div-inside-nav-expand');
    
    openDiv.style.width = "75%";
    let blurDiv = document.createElement('div');
    blurDiv.classList.add('blur-back');
    document.body.appendChild(blurDiv);
    let allOption = document.getElementsByClassName('nav-collapse-btn');
    allOption = Array.from(allOption);
    let closeBtn = document.createElement('button');
    closeBtn.setAttribute('id','hamburger-close-btn');
    closeBtn.innerHTML = '<div id="hamburger-inside"><div class="right-cross div-line"></div><div class="left-cross div-line"></div></div>';
    
    openDiv.appendChild(closeBtn);

    openDiv.appendChild(innerDiv);

    let i = 0;

    allOption.forEach((element)=>{
        innerDiv.appendChild(element);
        element.classList.remove('nav-collapse-btn');
    })
    
    closeBtn.addEventListener('click',navDivClose);

}

function navDivClose(){
    let openDiv = document.getElementById('nav-expand-div');
    let innerDiv = document.getElementById('div-inside-nav-expand');
    let allOption = innerDiv.children;
    allOption = Array.from(allOption);
    let headerDiv = document.getElementsByClassName('nav-btn-cluster')[0];


    let i = 0;

    allOption.forEach((element)=>{
        headerDiv.appendChild(element);
        element.classList.add('nav-collapse-btn');
    })

    innerDiv.remove();
    openDiv.style.width = '0%'
    document.getElementsByClassName('blur-back')[0].remove();
}

function logoutFun(){
    window.location.href = "logout.php";
}
</script>