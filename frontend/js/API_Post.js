import Infobar from './Infobar';

export default class API_Post{
    static init(options){
        API_Post.columns = [];
        API_Post.values = {};
        API_Post.url = options.url;
        API_Post.postID = options.postID;
        API_Post.id = options.id;

        let items = $('.post-value').length;
        let index = 0;

        $('.post-value').each(function () {
            let elem = $(this);
            let custom = elem.data('custom') || false;

            switch (custom){
                case 'category_product':
                    API_Post.values['category_product'] = $('select').select2('val');
                    break
                case 'problem_category':
                    API_Post.values['problem_category'] = $('select').select2('val');
                    break
                case 'problem_translations':
                    if(!API_Post.values['translations']){
                        API_Post.values['translations'] = {};
                    }
                    API_Post.values['translations'][elem.data('lang')] = {name: elem.find('input:first').val(), description: elem.find('textarea').val()};
                    break
                default:
                    API_Post.columns.push(elem.data('column'));
                    if(elem.hasClass('radio')){
                        API_Post.values[elem.data('column')] = $(`input[name=${elem.attr('name')}]:checked`).val();
                    }else if(elem.hasClass('checkbox')){
                        API_Post.values[elem.data('column')] = ($(`input[name=${elem.attr('name')}]:checked`).val() == 'on' ? '1' : '0');
                    }else if(elem.hasClass('custom-select')){
                        API_Post.values[elem.data('column')] = $('.custom-select').select2('val');
                    }else{
                        API_Post.values[elem.data('column')] = elem.val();
                    }
                    break;
            }

            if(++index == items){
                API_Post.resolve();
            }
        })
    }

    static resolve(){
        $.ajax({
            type: 'POST',
            url: `/api/${API_Post.url}` ,
            data: JSON.stringify({id: API_Post.id, postID: API_Post.postID, values: API_Post.values, columns: API_Post.columns}),
            success: (data) => {
                Infobar.removeAll();

                if(data.status === 'fail'){
                    Infobar.add({status: 'fail', header: data.header, content: data.message})
                }else{
                    Infobar.add({status: 'success', header: data.header, content: data.message, dispose: 5000})
                }
            },
            contentType: "application/json",
            dataType: 'json'
        });
    }
}
