export default class Preview{
    static init(){
        Preview.handlers();
    }

    static handlers(){
        $('.test-api').on('click', function () {
            let api = $(this).data('api');
            let id = $(this).data('id') || false;
            let $output = $('.json-output');
            let data;

            if(id){
                switch (api){
                    case 'get_category':
                        data = {token: 'abgloprt', language: 'cs', category: id};
                        break;
                }
            }else{
                data = {token: 'abgloprt', language: 'cs'}
            }

            $.ajax({
                type: 'GET',
                url: `/mobileAPI/${api}.php` ,
                data: data,
                success: (data) => {
                    // alert(data);
                    $output.html(`<pre>${Preview.syntaxHighlight(data)}</pre>`);
                    // console.log(data);
                },
                contentType: "application/json",
                dataType: 'json'
            });

        })
    }

    static syntaxHighlight(json) {
        if (typeof json != 'string') {
            json = JSON.stringify(json, undefined, 2);
        }
        json = json.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
        return json.replace(/("(\\u[a-zA-Z0-9]{4}|\\[^u]|[^\\"])*"(\s*:)?|\b(true|false|null)\b|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?)/g, function (match) {
            var cls = 'number';
            if (/^"/.test(match)) {
                if (/:$/.test(match)) {
                    cls = 'key';
                } else {
                    cls = 'string';
                }
            } else if (/true|false/.test(match)) {
                cls = 'boolean';
            } else if (/null/.test(match)) {
                cls = 'null';
            }
            return '<span class="' + cls + '">' + match + '</span>';
        });
    }
}
