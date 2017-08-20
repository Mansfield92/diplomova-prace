export default class Filter{
    constructor(input, items){
        this.input = input;
        this.items = items;

        this.handleKey();
    }

    handleKey(){
        $(this.input).on('keyup', () => {
            this.filterItems(($(this.input).val()).toString().toLowerCase());
        })
    }

    filterItems(value){
        $(this.items).each(function(){
            let text = $(this).data('search').toString().toLowerCase();
            if(text.indexOf(value) !== -1){
                $(this).show();
            }else{
                $(this).hide();
            }
        });
    }
}

