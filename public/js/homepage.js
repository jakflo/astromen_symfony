document.addEventListener('DOMContentLoaded', () => {

    const showAddButton = document.getElementById('show_add_astroman_form_button');
    const newAstroFormWrap = document.getElementById('new_astroman_form_wrap');
    const editFormWrap = document.getElementById('astroman_edit_form_wrap');
    const deleteConfirmFormWrap = document.getElementById('astroman_delete_confirm_form_wrap');
    const editFormCancel = document.getElementById('astroman_edit_form_cancel');
    const deleteFormCancel = document.getElementById('astroman_delete_form_cancel');

    // Zobrazi formular pro pridani astronauta
    showAddButton?.addEventListener('click', () => {
        showAddButton.classList.add('hidden');
        hideAllForms();
        unmarkTableCells();
        newAstroFormWrap.classList.remove('hidden');
    });

    // Zrusi pridavani astronauta
    document.getElementById('astroman_add_form_cancel')?.addEventListener('click', () => {
        newAstroFormWrap.classList.add('hidden');
        showAddButton.classList.remove('hidden');
    });

    // Editace astronauta
    document.querySelectorAll('.astro_edit').forEach(btn => {
        btn.addEventListener('click', () => {
            const { id, trDom } = getIdAndTableRowDomFromClickedButton(btn);
            resetView();
            document.getElementById('edited_astroman_name').textContent = getAstromanFullName(trDom);
            editFormWrap.classList.remove('hidden');
            trDom.classList.add('marked_edit');
            document.getElementById('astroman_edit_form_id').value = id;

            const form = document.getElementById('astroman_edit_form');
            form.querySelectorAll('input').forEach(input => input.removeAttribute('size'));

            // do poli formu nakopiruje data astronauta z prislusneho radku tabulky
            trDom.querySelectorAll('td').forEach(td => {
                const tdName = td.dataset.name;
                if (tdName) {
                    const formCell = document.getElementById(tdName.replace('edit_', 'astroman_edit_form_'));
                    if (formCell) {
                        let data = td.textContent.trim();
                        if (data.length > 18) formCell.setAttribute('size', data.length + 2);
                        if (tdName === 'edit_dob') data = czDateToEnDate(data);
                        formCell.value = data;
                    }
                }
            });
        });
    });

    // Smazani astronauta – potvrzovaci formular
    document.querySelectorAll('.astro_delete').forEach(btn => {
        btn.addEventListener('click', () => {
            const { id, trDom } = getIdAndTableRowDomFromClickedButton(btn);
            resetView();
            document.getElementById('deleted_astroman_name').textContent = getAstromanFullName(trDom);
            document.getElementById('astroman_delete_form_id').value = id;
            trDom.classList.add('marked_delete');
            deleteConfirmFormWrap.classList.remove('hidden');
        });
    });

    // Zrusi akce editace nebo mazani
    [editFormCancel, deleteFormCancel].forEach(btn => {
        btn?.addEventListener('click', () => {
            unmarkTableCells();
            hideAllForms();
        });
    });

    // Pokud selhala validace při editaci, zobrazi formular znovu a oznaci polozku v tabulce
    const failedIdEl = document.getElementById('edit_form_validation_failed_id');
    if (failedIdEl && failedIdEl.textContent.trim() !== '0') {
        const id = failedIdEl.textContent.trim();
        const editButton = document.querySelector(`button.astro_edit[data-id="${id}"]`);
        if (editButton) {
            const { trDom } = getIdAndTableRowDomFromClickedButton(editButton);
            resetView();
            document.getElementById('edited_astroman_name').textContent = getAstromanFullName(trDom);
            editFormWrap.classList.remove('hidden');
            trDom.classList.add('marked_edit');
            document.getElementById('astroman_edit_form_id').value = id;
        }
    }

    // Pomocné funkce
    
    /**
     * pri klinuti na editovat, ci smazat vycte z tlacitka atribut data-id, vrati ono id a dom na radek v tabulce
     * @param {Dom} dom element kliknuteho tlacitka edit, ci smazat
     * @returns {id: string, trDom: Dom}
     */
    function getIdAndTableRowDomFromClickedButton(dom) {
        const id = dom.dataset.id;
        const trDom = document.querySelector(`tr.astroRow[data-id="${id}"]`);
        return { id, trDom };
    }

    function czDateToEnDate(czDate) {
        const [day, month, year] = czDate.replace(/\s/g, '').split('.');
        const date = new Date(year, month - 1, day, 5, 0, 0);
        return date.toISOString().split('T')[0];
    }

    function getAstromanFullName(trDom) {
        const firstName = trDom.querySelector('td[data-name="edit_fName"]')?.textContent.trim() || '';
        const lastName = trDom.querySelector('td[data-name="edit_lName"]')?.textContent.trim() || '';
        return `${firstName} ${lastName}`.trim();
    }

    function unmarkTableCells() {
        document.querySelectorAll('#astromen_table tr').forEach(tr => {
            tr.classList.remove('marked_edit', 'marked_delete');
        });
    }

    function hideAllForms() {
        document.querySelectorAll('.form_wrap').forEach(f => f.classList.add('hidden'));
    }
    
    function resetView() {
        unmarkTableCells();
        hideAllForms();
        showAddButton.classList.remove('hidden');
    }

});
