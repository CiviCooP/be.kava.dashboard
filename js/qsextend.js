/* Quick Search Extension JS */

CRM.$(function ($) {

    var $apb = $('<li><label class="crm-quickSearchField"><input type="radio" data-tablename="cc" value="kava_custom_apb" name="quickSearchField"> APB-nummer</label></li>');
    var $barcode = $('<li><label class="crm-quickSearchField"><input type="radio" data-tablename="cc" value="kava_custom_barcode" name="quickSearchField"> Barcode</label></li>');

    $('#civicrm-menu').ready(function () {
        // Add custom APB and barcode fields to the lookup dropdown
        var $ul = $('#civicrm-menu').find('#crm-qsearch ul');
        $ul.append($apb);
        $ul.append($barcode);

        // TODO The code above doesn't work.
        // TODO Rebuilding the entire menu sort of works, but this breaks submenus and is inefficient.
        // TODO Is there another way to add menu items without having to override navigation.js.tpl?
        // $('#civicrm-menu').menuBar({arrowSrc: CRM.config.resourceBase + 'packages/jquery/css/images/arrow.png'});
    });
});