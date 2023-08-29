let order = document.getElementById('buy-btn');
let blurDiv;
let loadingDiv;

function increaseQuantity(id){
    let element = document.getElementById(id);
    let request = new XMLHttpRequest;
    request.open("GET",`/product/buyProduct/${element.id}`);
    request.send();
    request.addEventListener('load',function(){
        if(request.status == 201 ){
            updatePrice();
            let quantitySpan = element.getElementsByClassName('item-quantity')[0];
            quantitySpan.innerText = parseInt(quantitySpan.innerText) + 1;
        }
        if(request.status == 204){
            alert('Out of stocks');
        }
    })
}

function decreaseQuantity(id){
    let element = document.getElementById(id);
    let request = new XMLHttpRequest;
    request.open("GET",`/myCart/removeProduct/${element.id}`);
    request.send();
    request.addEventListener('load',function(){
        if(request.status == 201 ){
            let quantitySpan = element.getElementsByClassName('item-quantity')[0];
            quantitySpan.innerText = parseInt(quantitySpan.innerText) - 1;
            updatePrice();
        }
        if(request.status == 204){
            
        }
    })
}

function orderBtn(){
    console.log("order button");
    console.log('button is called');
    let xhr = new XMLHttpRequest();
    xhr.open('POST', 'checkout.php', true);
    xhr.setRequestHeader("Content-Type", "application/json");
    let dataToSend = {
       type:'placeOrder'
    }
    console.log(dataToSend);
    dataToSend = JSON.stringify(dataToSend);
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {

            var request = xhr.responseText;
           request = JSON.parse(request);
            console.log(request);

            
            switch(request.status){
                case '303':{
                    window.history.pushState("", "", "/");
                    window.location.replace(request.response);
                    break;
                }
                case '202':{
                    alert("No Product In The Cart");
                    blurDiv.remove();
                    loadingDiv.remove();
                    break;
                }
                default :{
                    blurDiv.remove();
                    loadingDiv.remove();
                    break;
                }
          
        }
    }
}
    xhr.send(dataToSend);

    blurDiv = document.createElement('div');
    loadingDiv = document.createElement('div');
    blurDiv.setAttribute('class','blur-back');
    loadingDiv.setAttribute('class','blur-loading-div');
    document.body.appendChild(blurDiv);
    document.body.appendChild(loadingDiv);
}
order.addEventListener('click',orderBtn);

function deleteFromCart(id){
    let element = document.getElementById(id);
    let xhr = new XMLHttpRequest();
    xhr.open('POST', 'CartRequests.php', true);
    xhr.setRequestHeader("Content-Type", "application/json");
    let dataToSend = {
       type:'removeFromCart',
       productId: element.id
    }
    console.log(dataToSend);
    dataToSend = JSON.stringify(dataToSend);
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {

            var request = xhr.responseText;
           request = JSON.parse(request);
            console.log(request);

            
            if(request.status == 201 ){
                element.remove();
                // updatePrice();
            }
            if(request.status == 404){
                alert('Server Time Out');
            }
          
        }
    };
    xhr.send(dataToSend);
    
}


function updatePrice(){
    let Price = document.getElementById('price-p');
    let request = new XMLHttpRequest;
    request.open('GET','/myCart/getPrice');
    request.send();
    request.addEventListener('load',function(){
        Price.innerHTML = `₹ ${request.response}`
    })
}