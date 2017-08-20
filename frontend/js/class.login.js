import Popup from './Popup';

export default class Login{
    login(){
        let name = document.querySelector('#input-username').value;
        let pass = document.querySelector('#input-password').value;

        let request = new XMLHttpRequest();
        request.open('POST', '#', true);
        request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
        request.send('login_name=' + name + '&login_pw=' + pass);
        request.onload = function () {
            if (request.responseText.search('login-page') == -1) {
                window.location.reload(true);
            } else {
                $('.login-error').removeClass('hidden').html(`You can't login with these credentials.`);
            }
        }
    }

    register(){
        let name = document.querySelector('#register-name').value;
        let nick = document.querySelector('#register-username').value;
        let pass = document.querySelector('#register-password').value;
        let pass2 = document.querySelector('#register-password2').value;

        $('.input.error').removeClass('error');

        let validation = this.validateRegister({name, nick, pass, pass2});

        if(validation.result){
            $('.register-error').addClass('hidden').html('');
            this.resolveRegister({name, nick, pass, pass2});
        }else{
            $('.register-error').removeClass('hidden').html(validation.error);
        }
    }

    clearRegisterForm(){
        $('.register__inner .input').val('');
    }

    resolveRegister(data){
        $.ajax({
            type: 'PUT',
            url: `/api/users` ,
            data: JSON.stringify({
                columns: ['id', 'nickname', 'password', 'fullname'],
                values: {id: 'NULL', nickname: data.nick, fullname: data.name, password: data.pass}
            }),
            success: (data) => {
                if(data.status === 'success') {
                    this.clearRegisterForm();
                }
                Popup.init({
                    header: data.header,
                    content: data.message,
                    simple: true
                });
            },
            contentType: "application/json",
            dataType: 'json'
        });
    }

    validateRegister(data){
        let name = this.validateInput('name', {text: data.name});
        let nick = this.validateInput('nick', {text: data.nick});
        let pass = this.validateInput('pass', {pass: data.pass, pass2: data.pass2});
        return {result: (name.result && nick.result && pass.result), error: (name.error + nick.error + pass.error)};
    }

    validateInput(type, data){

        let result, error = '', patt;

        switch (type){
            case 'name':
                patt = /.{6,64}/g;
                result = patt.test(data.text);
                if(!result){
                    error += `<div>Name length is not between 6 and 64 characters</div>`;
                    $('#register-name').addClass('error');
                }
                break;
            case 'nick':
                patt = /.{4,64}/g;
                result = patt.test(data.text);
                if(!result){
                    error += `<div>Nick length is not between 4 and 64 characters</div>`;
                    $('#register-username').addClass('error');
                }
                break;
            case 'pass':
                patt = /.{8,64}/g;
                result = (patt.test(data.pass) && data.pass == data.pass2);
                if(!result){
                    if(!(data.pass.match(/.{8,64}/g))){
                        error += `<div>Password length is not between 8 and 64 characters</div>`;
                        $('#register-password').addClass('error');
                    }
                    if(!(data.pass == data.pass2)){
                        error += `<div>Password and confirm password don't match</div>`;
                        $('#register-password2').addClass('error');
                    }
                }

                break;
        }

        return {result, error};
    }
}
