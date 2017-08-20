export default class Tabs{
    static init(){
        $('.tabs__nav').on('click', '.tabs__nav__item:not(.active0)',  function () {
            $('.tabs__nav__item.active').removeClass('active');
            $('.tab.active').removeClass('active');

            let id = $(this).data('toggle');

            $(`#${id}`).addClass('active');
            $(this).addClass('active');
        })
    }
}
