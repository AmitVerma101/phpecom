<style>
    .container{
        background-image: linear-gradient(to left, #3f4854,#444b56);
        display: flex;
        flex-direction: column;
        box-sizing: border-box;
        padding: 5px;
        color: #9fa3a8;
        box-sizing: border-box;
        max-height: 110px;
        font-size: 1.7vw;
        box-shadow: 0px 0px 6px rgba(16, 16, 16, 0.665);
        border-radius: 4px;
        cursor: pointer;
    }
    .img-container{
        box-sizing: border-box;
        width: 22%;
        height: 100%;
    }
    .img{
        box-sizing: border-box;
        display: block;
        width: 100%;
        aspect-ratio: 12/6;
    }
    .text-container{
        padding: 4px;
    }
    .title{
        font-family: malvo-font-thin;
        font-weight: 300;
        color: white;
    }
    .tag{
        background-color: #545c66;
        box-sizing: border-box;
        padding: 2px;
        font-size: 1.6vw;
        border-radius: 4px;
    }
    .text-container{
        display: flex;
        flex-direction: column;
        justify-content: space-around;
    }
    .container-hover:hover{
        transform: scale(1.1);
        background-image: linear-gradient(to top,#32353b, #3b3e45);
    }
    .Positive{
        color: rgb(15, 192, 15);
    }
    .Mixed{
        color: yellow;
    }
    .Bad{
        color: red;
    }

    .onPressed{
        z-index: 400;
        top: 50%;
        left: 50%;
        transform: translate(-50%,-50%);
        position: fixed;
        margin: auto auto;
        overflow-y: scroll;
        background-image: linear-gradient(to top,#32353b, #3b3e45);
        max-width: 700px;
        width: 90%;
        height: 700px;
        max-height: 500px;
    }

    @media only screen and (min-width: 908px) {
        .container{
            font-size: 15px;
        }
        .tag{
            font-size: 15px;
        }
        .svg-window{
            width: 12px;
        }
    }

    .buyButton{
        background-image: linear-gradient(to right,rgb(96, 212, 107) 50%,rgb(79, 197, 91));
        display: flex;
        justify-content: center;
        gap: 30px;
        cursor: pointer;
    }

    .buyButton:hover{
        background-image: linear-gradient(to right,rgb(128, 233, 138) 50%,rgb(112, 221, 123));
    }

    .buyButton:active{
    
        background-image: linear-gradient(to right,rgb(96, 212, 107) 50%,rgb(79, 197, 91));
        outline: 2px solid rgb(96, 212, 107) ;
    }
    @media only screen and (max-width: 500px) {
        .container-hover:hover{
            transform: scale(1);
        }
    }
</style>
<?php 
    $productid = $item['productid'];
    $title = $item['title'];
    $img = $item['img'];
    $status = $item['status'];
    $userreview = $item['userreview'];
    $dateofrelease = $item['dateofrelease'];
    $description = $item['description'];
    $price = $item['price'];
   echo "<div class=\"container  container-hover\" id=\"$productid\" onclick=\"showDetails( '$productid' )\">
            <div style=\"display: flex;height: fit-content;\">
                <div class=\"img-container\">
                    <img class=\"img\" src=\"image/product/$img\" alt=\"\">
                </div>
                <div class=\"text-container\">
                    <h3 class=\"title\">$title</h3>
                
                    <div style=\"display: flex; align-items: flex-end;gap: 3px\">
                        <div>$dateofrelease</div>
                        <div>
                            <svg class=\"svg-window\" version=\"1.1\" xmlns=\"http://www.w3.org/2000/svg\" x=\"0px\" y=\"0px\" class=\"SVGIcon_Button SVGIcon_WindowsLogo\" width=\"100%\" height=\"100%\" viewBox=\"0 0 128 128\" enable-background=\"new 0 0 128 128\"><rect fill=\"#FFFFFF\" width=\"60.834\" height=\"60.835\"></rect><rect x=\"67.165\" fill=\"#FFFFFF\" width=\"60.835\" height=\"60.835\"></rect><rect y=\"67.164\" fill=\"#FFFFFF\" width=\"60.834\" height=\"60.836\"></rect><rect x=\"67.165\" y=\"67.164\" fill=\"#FFFFFF\" width=\"60.835\" height=\"60.836\"></rect></svg>
                        </div>
                    </div>
                    <div><span class='$status'> $status  </span><span>| $userreview User Reviews</span></div>
                </div>
                <div class=\"price\">
                <p>
                  $price <?php if($price == 0){
                    echo'Free';
               } 
                else{
                    echo  '₹ '.$price;
                }?>
                </p>
            </div>
            
            </div>
            <div class=\"about-game\" style=\"display: none;overflow: hidden;\">
                <p  >$description</p>
            </div>
        </div>"
?>

<script >


function showDetails(element){
    
    //GET number of product present in cart here element is id
    let request = new XMLHttpRequest;
    let quantitySpan = document.createElement('span');
    
    quantitySpan.classList.add('quantitySpan');
    quantitySpan.innerText = 0;
    
    // request.open("GET",`/product/getProductValue/${element}`);
    // request.send();
    // request.addEventListener('load',function(){
    //     quantitySpan.innerText = request.response;
    // })
    let xhr = new XMLHttpRequest();
    xhr.open('POST', 'CartRequests.php', true);
    xhr.setRequestHeader("Content-Type", "application/json");
    let dataToSend = {
       type:'getQuantity',
       productId: element
    }
    console.log(dataToSend);
    dataToSend = JSON.stringify(dataToSend);
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {

            var response = xhr.responseText;
            // response = JSON.parse(response);
            console.log(response);
            quantitySpan.innerText = response;
            // Handle the response
            // if (response.msg === 'Login successfully') {
            //     window.location.href="http://localhost/myEcom/products.php";
            //     console.log('Login successful');
            //  } else {
            //      wrongUser(); // Handle login failure on the client side
            //      console.log('Login failed');
            //  }
        }
    };
    xhr.send(dataToSend);
    
    
    let blur = document.createElement('div');
    blur.classList.add('blur-back');
    document.body.appendChild(blur);
    element = document.getElementById(element);
    previousData = element.innerHTML;
    
    element.classList.add('onPressed');
    element.classList.remove('container-hover');

    element.removeAttribute('onclick');

    blur.setAttribute('onclick',`removeDetails('${element.id}')`);
    document.body.style.overflow= "hidden";
    let img = element.getElementsByClassName('img-container')[0];
    let data = element.getElementsByClassName('text-container')[0];
    img.style.width = '70%';
    let aboutGame = element.getElementsByClassName('about-game')[0];
    aboutGame.style.display = 'initial'
    let button = document.createElement('buttton');
    button.innerText = "Add To Cart";
    button.classList.add('submit-btn')
    button.classList.add('buyButton');
    button.setAttribute('onmousedown','event.preventDefault()');
    button.appendChild(quantitySpan);
    button.addEventListener('click',function(evt){
        evt.stopPropagation();
        buy(element,quantitySpan);
    });
    
    // Error msg 
    let errMsg = document.createElement('p');
    errMsg.id = 'err-msg'
    errMsg.innerText = "This Is Dummy Text";
    element.appendChild(errMsg);
    element.appendChild(button);
}

function buy(element,quantitySpan){
    
    let xhr = new XMLHttpRequest();
    xhr.open('POST', 'CartRequests.php', true);
    xhr.setRequestHeader("Content-Type", "application/json");
    let dataToSend = {
       type:'incrementCount',
       productId: element.id
    }
    console.log(dataToSend);
    dataToSend = JSON.stringify(dataToSend);
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {

            var request = xhr.responseText;
            request = JSON.parse(request);
            console.log(request);

            
            if(request.code == 201 ){
            quantitySpan.innerText = parseInt(quantitySpan.innerText) + 1;
            }
            if(request.code == 204){
                showErr('Out of stocks');
                // alert('Out of stocks');
            }
            if(request.code == 401){
                showErr(request.msg);
            }
          
        }
    };
    xhr.send(dataToSend);
   
}

function removeDetails(element){
    element = document.getElementById(element);
    element.classList.add('container-hover');
    element.classList.remove('onPressed');
    element.setAttribute('onclick',`showDetails('${element.id}')`)
    let blur = document.getElementsByClassName('blur-back')[0];
    blur.remove();
    document.body.style.overflow = "initial";
    element.innerHTML = previousData;
}

function showErr(err){
    let errMsg = document.getElementById('err-msg');
    errMsg.style.visibility = 'visible';
    errMsg.innerText = err;
}
</script>