$(function() {
    
    // ukaze a skryje form pridani noveho astronauta
    $('#show_add_astroman_form_button').click(function() {
        $(this).addClass('hidden');
        hideAll();
        unmarkTableCells();
        $('#new_astroman_form_wrap').removeClass('hidden');
    });
    $('#astroman_add_form_cancel').click(function() {
        $('#new_astroman_form_wrap, #show_add_astroman_form_button').removeClass('hidden');
        $('#new_astroman_form_wrap').addClass('hidden');
    });
    
    // zobrazi formular k editaci astronauta, do hodnot formu nakopituje hodnoty z radku tabulky daneho astronauta
    $('.astro_edit').click(function() {
        var stuff = getIdAndTableRowDomFromClickedButton(this); 
        var id = stuff.id;
        var trDom = stuff.trDom;        
        $('#edited_astroman_name').text(getAstromanName(trDom));
        $('#astroman_edit_form_wrap').removeClass('hidden');
        $(trDom).addClass('marked_edit');
        $('#astroman_edit_form_id').val(id);
        $('#astroman_edit_form').find('input').removeAttr('size');        
        $(trDom).find('td').each(function(k, v) {
            var tdName = $(v).attr('data-name');
            if (tdName) {
                var formCell = $('#' + tdName.replace('edit_', 'astroman_edit_form_'));
                if ($(formCell).length > 0) {
                    var data = $(v).text();
                    var dataLen = data.length;
                    var dataName = $(v).attr('data-name');
                    if (dataLen > 18) {
                        $(formCell).attr('size', dataLen + 2);
                    }
                    if (dataName === 'edit_dob') {
                        data = czDateToEnDate(data);
                    }

                    $(formCell).val(data);
                }
            }
        });        
    });
    
    //zobrazi form k potvrzeni smazani astronauta
    $('.astro_delete').click(function() {
        var stuff = getIdAndTableRowDomFromClickedButton(this); 
        var id = stuff.id;
        var trDom = stuff.trDom;
        $('#deleted_astroman_name').text(getAstromanName(trDom));
        $('#astroman_delete_form_id').val(id);
        $(trDom).addClass('marked_delete');
        $('#astroman_delete_confirm_form_wrap').removeClass('hidden');        
    });
    
    // pri kliknuti na zrusit skryje formulare a odznaci radek v tabulce
    $('#astroman_edit_form_cancel, #astroman_delete_form_cancel').click(function() {
        unmarkTableCells();
        hideAll();
    });
    
    // selze-li validace pri editaci, zobrazi editacní formular a oznaci polozku v tabulce
    if ($('#edit_form_validation_failed_id').text() != 0) {
        var id = $('#edit_form_validation_failed_id').text();
        var stuff = getIdAndTableRowDomFromClickedButton($('button.astro_edit[data-id="' + id + '"]'));
        var trDom = stuff.trDom;        
        $('#edited_astroman_name').text(getAstromanName(trDom));
        $('#astroman_edit_form_wrap').removeClass('hidden');
        $(trDom).addClass('marked_edit');
        $('#astroman_edit_form_id').val(id);        
    }
    
    /**
     * pri klinuti na editovat, ci smazat vycte z tlacitka atribut data-id, vrati ono id a dom na radek v tabulce
     * @param {Dom} dom element kliknuteho tlacitka edit, ci smazat
     * @returns {id: string, trDom: Dom}
     */
    function getIdAndTableRowDomFromClickedButton(dom) {
        var id = $(dom).attr('data-id');
        var trDom = $('tr.astroRow[data-id="' + id + '"]');
        unmarkTableCells();
        hideAll();
        $('#show_add_astroman_form_button').removeClass('hidden');
        return {id: id, trDom: trDom};        
    }
    
    function czDateToEnDate(czDate) {
        var czDateArray = czDate.replace(' ', '').split('.');
        var date = new Date(czDateArray[2], czDateArray[1] - 1, czDateArray[0], 5, 0, 0);
        return date.toISOString().split('T')[0];
    }
    
    function getAstromanName(trDom) {
        return $(trDom).find('td[data-name="edit_fName"]').text() + ' ' + $(trDom).find('td[data-name="edit_lName"]').text();
    }
    
    function unmarkTableCells() {
        $('#astromen_table tr').removeClass('marked_edit').removeClass('marked_delete');
    }
    
    // schova vsechny formulare
    function hideAll() {
        $('.form_wrap').removeClass('hidden').addClass('hidden');
    }
});

