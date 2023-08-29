let userName = document.getElementById('userName');
let password = document.getElementById('password');
let joinBtn = document.getElementById('join-btn');

var loginForm = document.querySelector('.form-container');
loginForm.addEventListener('submit', function (event) {
    event.preventDefault(); 
   
    var xhr = new XMLHttpRequest();
    xhr.open('POST', window.location.href, true);
    xhr.setRequestHeader("Content-Type", "application/json");
    let data = {
        userName: userName.value,
        password: password.value  
    }
    console.log(data);
    data = JSON.stringify(data);
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {

            var response = xhr.responseText;
            response = JSON.parse(response);
            console.log(response);
            // Handle the response
            if (response.error == false) {
                if(response.role == 1){
                    window.location.href=response.redirect;
                }
                else {
                    window.location.href = response.redirect;
                }
                console.log('Login successful');
             } else {
                 wrongUser(); // Handle login failure on the client side
                 console.log('Login failed');
             }
        }
    };
    xhr.send(data);
});


function wrongUser(){
    userName.style.outline='1px solid red';
    password.style.outline='1px solid red';
    document.getElementById('err-msg').style.visibility='visible';
}

joinBtn.addEventListener('click',function(){
    window.location.href = 'signup.php';
})