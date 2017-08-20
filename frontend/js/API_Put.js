export default class API_Put{
    static init(options){
        API_Put.columns = [];
        API_Put.values = {};
        API_Put.url = options.url;

        let items = $('.put-value').length;
        let index = 0;

        $('.put-value').each(function () {
            let elem = $(this);
            let custom = elem.data('custom') || false;
            let action = elem.data('action') || false;

            switch (custom){
                case 'select':
                    break
                default:
                    API_Put.columns.push(elem.data('column'));
                    if(elem.hasClass('radio')){
                        API_Put.values[elem.data('column')] = $(`input[name=${elem.attr('name')}]:checked`).val();
                    }else if(elem.hasClass('checkbox')){
                        API_Put.values[elem.data('column')] = ($(`input[name=${elem.attr('name')}]:checked`).val() == 'on' ? '1' : '0');
                    }else if(elem.hasClass('custom-select')){
                        API_Put.values[elem.data('column')] = $('.custom-select').select2('val');
                    }else{
                        API_Put.values[elem.data('column')] = elem.val();
                    }
                    break;
            }

            if(++index == items){
                API_Put.resolve();
            }
        })
    }

    static resolve(){
        $.ajax({
            method: 'PUT',
            url: `/api/${API_Put.url}` ,
            data: JSON.stringify({values: API_Put.values, columns: API_Put.columns}),
            success: (data) => {
                console.warn(data);
                window.location.href = window.location.href + '/' + data.id;
            },
            contentType: "application/json",
            dataType: 'json'
        });
    }
}
