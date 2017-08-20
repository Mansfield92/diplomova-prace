import './helpers';
import Popup from './Popup';
import Filter from './Filter';
import Password from './Password';
import Tabs from './Tabs';
import select2 from 'select2';
import API_Post from './API_Post';
import API_Put from './API_Put';
import API_Delete from './API_Delete';
import Preview from './Preview';


/* HMR */
// if (module.hot) module.hot.accept();

$(document).ready(() => {
    // Popup.init();

    let $body = $('body');


    if($body.is('.body-testapi')){
        Preview.init();
    }

    if($('.content__filter').length > 0){
        let filter = new Filter('.content__filter', '.filter');
    }

    $('.navbar-expand-toggle').on('click', () => {
        $('.sidebar').toggleClass('active');
        $('.navbar-expand-toggle').toggleClass('active');
    });

    $('select').select2({
        dropdownParent: $('.content__wrapper'),
    });

    $('.logout').on('click', () => {
        logout();
    });

    $('.profile-toggle').on('click', () => {
        $('.profile').toggleClass('active');
    });

    $body.on('click', '.button--post', function(){
        API_Post.init({url: $(this).data('api'), id: $(this).data('id'),  postID: $(this).data('post-id')});
    });

    $body.on('click', '.button--put', function(){
        API_Put.init({url: $(this).data('api')});
    });

    $body.on('click', '.button--delete', function(){
        API_Delete.init({data: ($(this).data())});
    });

    $('.popup-form').on('click', function () {
        let elem = $(this);
        let api = elem.data('api');
        let type = elem.data('type');

        $.ajax({
            type: 'POST',
            url: `/api/${api}-forms` ,
            data: JSON.stringify({form: type }),
            success: (data) => {
                Popup.init({
                    header: data.header,
                    table: api,
                    content: data.content,
                    button: data.button
                })
            },
            contentType: "application/json",
            dataType: 'json'
        });
    });

    Tabs.init();
    Password.init();

   warn('ready');
});

function logout() {
    $.post('#', {logout: true}, function (data) {
        F5();
    });
}
function F5() {
    window.location.reload(true);
}
