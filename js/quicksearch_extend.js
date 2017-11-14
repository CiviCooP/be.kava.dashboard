/* KAVA Quick Search Extension JS */

CRM.$(function ($) {

    // An ugly way to add new options to the quicksearch JS menu
    var $contactIdMenuItem = $('#root-menu-div .crm-quickSearchField').eq(1).closest('li');

    var $apb = $('<li><div class="menu-item"><label class="crm-quickSearchField"><input type="radio" data-tablename="cc" value="kava_custom_apb" name="quickSearchField"> APB-nummer</label></div></li>');
    var $barcode = $('<li><div class="menu-item"><label class="crm-quickSearchField"><input type="radio" data-tablename="cc" value="kava_custom_barcode" name="quickSearchField"> Barcode</label></div></li>');

    $apb.insertAfter($contactIdMenuItem);
    $barcode.insertAfter($contactIdMenuItem);

    // Add hover effect on mouseover
    $apb.add($barcode).mouseover(function (ev) {
        $(this).addClass('active');
    }).mouseout(function (ev) {
        $(this).removeClass('active');
    });

    // Prevent form submission if one of our options is selected: advanced search does not recognize these params
    $('#id_search_block').submit(function (ev) {
        if (['kava_custom_apb', 'kava_custom_barcode'].indexOf($('input[name=quickSearchField]:checked').val()) > -1) {
            ev.preventDefault();
        }
    });
});