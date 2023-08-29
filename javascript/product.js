const showMore = document.getElementById('show-more');
const itemList = document.getElementById('item-container');
let errMsg;





showMore.addEventListener('click',function(){
    
    var xhr = new XMLHttpRequest();
    xhr.open('POST', window.location.href, true);
    xhr.setRequestHeader("Content-Type", "application/json");
   
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {

            var response = xhr.responseText;
            showMore.insertAdjacentHTML("beforebegin",response);
            // console.log(response);
            // Handle the response
          
        }
    };
    xhr.send();
})

