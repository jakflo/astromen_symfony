$(function() {
    $('#show_add_astroman_form').click(function() {
        $(this).addClass('hidden');
        hideAll();
        unmarkTableCells();
        $('#new_astroman_form').removeClass('hidden');
    });
    $('#add_cancel').click(function() {
        $('#new_astroman_form, #show_add_astroman_form').removeClass('hidden');
        $('#new_astroman_form').addClass('hidden');
    });
    
    $('.astro_edit').click(function() {
        var stuff = editDeleteClicked(this); 
        var id = stuff.id;
        var trDom = stuff.trDom;        
        $('#edited_astroman_name').text(getAstromanName(trDom));
        $('#astroman_edit_form').removeClass('hidden');
        $(trDom).addClass('marked_edit');
        $('#edit_id').val(id);
        $('#astroman_edit_form').find('input').removeAttr('size');        
        $(trDom).find('td').each(function(k, v) {
            var tdName = $(v).attr('data-name');
            var formCell = $('#' + tdName);
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
        });        
    });
    
    $('.astro_delete').click(function() {
        var stuff = editDeleteClicked(this); 
        var id = stuff.id;
        var trDom = stuff.trDom;
        $('#deleted_astroman_name').text(getAstromanName(trDom));
        $('#delete_id').val(id);
        $(trDom).addClass('marked_delete');
        $('#astroman_delete_confirm_form').removeClass('hidden');        
    });
    
    $('#edit_cancel, #delete_cancel').click(function() {
        unmarkTableCells();
        hideAll();
    });
    
    if ($('#edit_form_validation_failed_id').text() != 0) {
        var id = $('#edit_form_validation_failed_id').text();
        var stuff = editDeleteClicked($('button.astro_edit[data-id="' + id + '"]'));
        var trDom = stuff.trDom;        
        $('#edited_astroman_name').text(getAstromanName(trDom));
        $('#astroman_edit_form').removeClass('hidden');
        $(trDom).addClass('marked_edit');
        $('#edit_id').val(id);        
    }
    
    function editDeleteClicked(dom) {
        var id = $(dom).attr('data-id');
        var trDom = $('tr.astroRow[data-id="' + id + '"]');
        unmarkTableCells();
        hideAll();
        $('#show_add_astroman_form').removeClass('hidden');
        return {id: id, trDom: trDom};        
    }
    
    function czDateToEnDate(cz_date) {
        var cz_date_array = cz_date.replace(' ', '').split('.');
        var date = new Date(cz_date_array[2], cz_date_array[1] - 1, cz_date_array[0], 5, 0, 0);
        return date.toISOString().split('T')[0];
    }
    
    function getAstromanName(trDom) {
        return $(trDom).find('td[data-name="edit_fName"]').text() + ' ' + $(trDom).find('td[data-name="edit_lName"]').text();
    }
    
    function unmarkTableCells() {
        $('#astromen_table tr').removeClass('marked_edit').removeClass('marked_delete');
    }
    
    function hideAll() {
        $('.form_wrap').removeClass('hidden').addClass('hidden');
    }
});

