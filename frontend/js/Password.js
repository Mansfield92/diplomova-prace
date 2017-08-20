import Popup from './Popup';

export default class Password{
    static init(){
        Password.handlers();
    }

    static handlers(){
        $('.button--password').on('click', function () {
            Popup.init({
                header: `Password change`,
                content: `<div class="popup__form__row">
                    <input id="register-password" placeholder="Password" type="password" class="input" value=""/>
                    <input id="register-password2" placeholder="Confirm password" type="password" class="input" value=""/>
                </div>
                <div class="popup__form__row"><div class="content__row--error hidden register-error"></div></div>`,
                button: `<div class="button button--confirm button-change-password">Confirm</div>`
            });
        });

        $('body').on('click', '.button-change-password', function () {

           let pass1 = $('#register-password').val();
           let pass2 = $('#register-password2').val();

           let error = "Passwords are not the same.";

           if(pass1 == pass2){
               if(pass1.length > 7){
                   Password.resolveChange({pass: pass1});
                   Popup.dispose();
               }else{
                   error = "Password is too short. Minimal length is 8 characters.";
                   $('.register-error').removeClass('hidden').html(error);
               }
           }else{
               $('.register-error').removeClass('hidden').html(error);
           }
        });
    }

    static resolveChange(data){
        $.ajax({
            type: 'POST',
            url: `/api/users` ,
            data: JSON.stringify({postID: $('.button--password').data('id'), values: {"password": data.pass}, columns: ["password"]}),
            success: (data) => {
                Popup.dispose();
                Popup.init({
                    simple: true,
                    header: `Password change result`,
                    content: data.message + ' You will be logged off now.'
                });

                setTimeout(() => {
                    window.location.reload(true);
                }, 2000);
            },
            contentType: "application/json",
            dataType: 'json'
        });
    }

}
