export default class Infobar{
    static removeAll(){
        $('.infobar').remove();
    }
    static add(options) {
        options = {status: 'success',...options};

        let element = $(`<div class="infobar infobar--${options.status}">
          <div class="infobar__inner">
            <div class="infobar__close"></div>`
            + (options.header ? `<div class="infobar__header">${options.header}</div>` : ``) +
            `<div class="infobar__content">${options.content}</div>
          </div>
        </div>`);

        element.insertBefore('.button--confirm');
        element.on('click', '.infobar__close', function(){
            Infobar.remove(element, 10);
        });

        if(options.dispose){
            Infobar.remove(element, options.dispose);
        }
    }
    static remove(elem, time){
        setTimeout(() => {
            elem.fadeOut(500, function(){
                $(this).remove();
            });
        },time);
    }
}

