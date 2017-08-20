import './helpers';
import Login from './class.login';

$(document).ready(() => {

    let login = new Login();

    document.querySelector('.login-register').addEventListener('click', function(e){
        e.preventDefault();
        document.querySelector('.register__inner').classList.add('visible');
        document.querySelector('.login__inner').classList.remove('visible');
    });

    document.querySelector('.login-login').addEventListener('click', function(e){
        e.preventDefault();
        document.querySelector('.register__inner').classList.remove('visible');
        document.querySelector('.login__inner').classList.add('visible');
    });

    document.querySelector('.login-button').addEventListener('click', function(e){
        e.preventDefault();
        login.login();
    });

    document.querySelector('.register-button').addEventListener('click', function(e){
        e.preventDefault();
        login.register();
    });
});
