export default class Popup{
    static init(options){

        Popup.options = {button: '', ...options};

        if(options.simple){
            Popup.options.button = options.button ? `<div class="button button--confirm">${options.button}</div>` : '';
            Popup.options.content = `<div class="popup__form__row"><div class="popup__form__headline">${options.content}</div></div>`;
        }

        let element =
        `<div class="popup__overlay active">
            <div class="popup">
                <div class="popup__inner">
                    <div class="popup__close"></div>
                    <div class="popup__headline">${Popup.options.header}</div>
                    <div class="popup__content">
                        <div class="popup__form">${Popup.options.content}</div>
                    </div>
                    <div class="popup__controls">
                        ${Popup.options.button}
                        <div class="button button--cancel">Close</div>
                    </div>
                </div>
            </div>
        </div>`;

        $('body').append(element);

        if($('select').length > 0){
            $('select').select2({
                dropdownParent: $('.popup__overlay'),
                placeholder: 'Select an option'
            }).on('change', () => {
                if(Popup.options.table === 'categories'){
                    let category = parseInt($('select').select2('val'));
                    let text = $('select').select2('data')[0];
                    text = text.text;

                    let type = text.substring(text.lastIndexOf("(")+1,text.lastIndexOf(")"));
                    if(category === 0){
                        $('.category-type').removeClass('hidden');
                    }else{
                        $('.category-type').addClass('hidden');
                        $(`input[value="${type}"]`).not(':checked').prop("checked", true);
                    }
                }
            });
        }

        Popup.initHandlers();

        return true;
    }

    static initHandlers(){
        $('.popup__overlay').off('click').on('click', '.popup__close, .button--cancel', () => {
            Popup.close();
        });

        $('.popup__overlay').on('click', (e) => {
            if($(e.target).hasClass('popup__overlay')){
                Popup.close();
            }
        })
    }

    static close(){
        $('.popup__overlay').removeClass('active');
        Popup.dispose();
    }

    static open(){
        $('.popup__overlay').addClass('active');
    }

    static dispose(){
        $('.popup__overlay').remove();
    }
}
