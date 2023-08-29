const submitBtn = document.getElementById('submit-btn-signup');
const emailInput = document.getElementById('email');
const nameInput = document.getElementById('name');
const userNameInput = document.getElementById('userName');
const password1Input = document.getElementById('password1');
const password2Input = document.getElementById('password2');
const tosCheck = document.getElementById('tos-checkbox');
const errMsg = document.getElementById('err-msg');
const tosCheckDiv = document.getElementById('tos-container');
let timeOut = null;

let formArray = [
    emailInput,nameInput,userNameInput,password1Input,password2Input
]

submitBtn.addEventListener('click',function(){
    console.log('inside submit')
    let email = emailInput.value.trim();
    let name = nameInput.value.trim();
    let userName = userNameInput.value.trim();
    let password1 = password1Input.value.trim();
    let password2 = password2Input.value.trim();
    if(email == "" || name == "" || userName == "" || password1 == ""|| password2 == ""){
        errThrough("Please enter all the fields",1);
    }
    else if(password1 != password2){
        errThrough("password are not matching",2);
    }else if(!(tosCheck.checked)){
        errThrough("Please accept term of conditions.",3);
    }else{
        console.log('else called');
        let data = {
            name,
            userName,
            password: password1,
            email
        }
        var xhr = new XMLHttpRequest();
        xhr.open('POST',window.location.href, true);
        xhr.setRequestHeader("Content-Type", "application/json");

        data = JSON.stringify(data);
           
        xhr.onreadystatechange = function () {
            submitBtn.setAttribute("disabled","true");
            submitBtn.classList.remove('submit');
            submitBtn.classList.add('submitted');
            submitBtn.innerHTML = `<div class="circle-animation dim-circle"></div>`
            if (xhr.readyState === 4 && xhr.status === 200) {
                console.log(xhr);
                var response = xhr.responseText;
                response = JSON.parse(response);
                console.log('consoling response')
                console.log(response);
                let code = response.code;
                console.log('code',code);
                submitBtn.classList.remove('submitted');
                submitBtn.classList.add('submit');
                submitBtn.innerHTML = `Submit`;
                submitBtn.removeAttribute("disabled");
                switch(code){
                    case 200:{
                        errThrough("Account Create Please Varify your email. Redirecting to login page",0);
                        break;
                    }
                    case 401:{
                        errThrough("UserName already Taken",4);
                        break;
                    }
                    case 402:{
                        errThrough("Email already In Use",4);
                        break;
                    }
                    case 303:{
                        errThrough("Email cant be sent",5);
                    }
                    case 400:{
                        errThrough('something went wrong',4);
                    }
                }
            
           
            }
            else {
                console.log('heree');
            }
        };
        xhr.send(data);
        
    }
})

function errThrough(error,cond){
    errMsg.style.visibility='visible';
    switch(cond){
        case 0:{
            errMsg.innerText = error;
            submitBtn.classList.remove('submit');
            submitBtn.classList.add('submitted');
            submitBtn.innerHTML = `<div class="circle-animation dim-circle"></div>`
            submitBtn.setAttribute("disabled",'true');
            setTimeout(function(){
                window.location.href = 'login.php';
            },3000);
            break;
        }
        case 1:{
            errMsg.innerText = error;
            formArray.forEach((element)=>{
                element.classList.add("err-msg-container");
            })
            break;
        }
        case 2:{
            errMsg.innerText = error;
            password1Input.classList.add('err-msg-container');
            password2Input.classList.add('err-msg-container');
            break;
        }
        case 3:{
            errMsg.innerText = error;
            tosCheckDiv.classList.add('err-msg-container');
        }
        case 4:{
            errMsg.innerText = error;
            break;
        }
        case 5:{
            errMsg.innerText = error;
            break;
        }
    }

    timeOut= setTimeout(clearError,6000);
}

function clearError(){
    formArray.forEach((element)=>{
        element.classList.remove('err-msg-container');
    })
    errMsg.style.visibility = 'hidden';
    tosCheckDiv.classList.remove('err-msg-container');
}
