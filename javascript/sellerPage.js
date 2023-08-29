var strWindowFeatures = "location=yes,height=700,width=1080,scrollbars=yes,status=yes";
function newProductPage(id){
    window.open('http://localhost/myEcom'+`/newProductPage.php?id=${id}`,'_blank',strWindowFeatures);
}

function updateProduct(id){
    window.open("http://localhost/myEcom"+`/updateProductPage.php?id=${id}`,'_blank',strWindowFeatures)
}


function deleteProduct(id){
    var xhr = new XMLHttpRequest();
    xhr.open('POST', window.location.href, true);
    xhr.setRequestHeader("Content-Type", "application/json");
   let data = {
    'productid': id
   }
   data = JSON.stringify(data);
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {

            var response = xhr.responseText;
            response = JSON.parse(data);
            console.log(response);
            switch(response.code){
                case 200:{
                    window.location.reload();
                }
            }
           
            // Handle the response
          
        }
    };
    xhr.send(data);
    var callback=(request)=>{
        switch(request.status){
            case 200:{
                window.location.reload();
            }
        }
    }
    createRequest('POST',window.location.href,id.toString(),callback);
}

function createRequest(method,dest,data,callback){
    let request = new XMLHttpRequest;
    request.open(method,dest);
    request.setRequestHeader('Content-Type','text/plain');
    request.send(data);
    request.addEventListener('load',function(){
        callback(request);
    })
}
