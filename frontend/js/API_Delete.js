import Popup from './Popup';
import Infobar from './Infobar';

export default class API_Delete{
    static init(options){
        API_Delete.options = options.data;

        Popup.init({
            simple: true,
            header: API_Delete.options.popupHeader,
            content: API_Delete.options.popupContent,
            button: API_Delete.options.popupButton
        });

        $('body').on('click', '.popup .button--confirm', () => {
            API_Delete.resolve();
        })
    }

    static resolve(){
        $.ajax({
            method: 'DELETE',
            url: `/api/${API_Delete.options.api}` ,
            data: JSON.stringify({id: API_Delete.options.deleteId}),
            success: (data) => {
                if(data.status === 'fail'){
                    Popup.close();
                    Infobar.add({status: 'fail', header: data.header, content: data.message});
                }else{
                    let href = window.location.href;
                    href = href.substring(0, href.lastIndexOf('/'));
                    window.location.href = href;
                }
            },
            contentType: "application/json",
            dataType: 'json'
        });
    }
}
