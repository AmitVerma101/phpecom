
let loginBtn = document.getElementById('submit-login');
let userName = document.getElementById('userName');
let password = document.getElementById('password');

loginBtn.addEventListener('click',function(){
    let userValue = userName.value.trim();
    let pass = password.value.trim();
    if(userValue=='' || pass==''){
        return ;
    }
    let data ={"userName":userValue,"password":pass};
    var xhr = new XMLHttpRequest();
    xhr.open('POST', window.location.href, true);
    xhr.setRequestHeader("Content-Type", "application/json");
   
    console.log(data);
    data = JSON.stringify(data);
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {

            var response = xhr.responseText;
            response = JSON.parse(response);
            console.log(response);
            // Handle the response
            if (response.msg === 'Login successfully') {
                window.location.href="http://localhost/myEcom/sellerPage.php";
                console.log('Login successful');
             } else {
                 wrongUser(); // Handle login failure on the client side
                 console.log('Login failed');
             }
        }
    };
    xhr.send(data);
    loginBtn.setAttribute("disabled","true");
    loginBtn.classList.remove('submit');
    loginBtn.classList.add('submitted');
    loginBtn.innerHTML = `<div class="circle-animation dim-circle"></div>`
})



function wrongUser(){
    userName.style.outline='1px solid red';
    password.style.outline='1px solid red';
    document.getElementById('err-msg').style.visibility='visible';
}

