const label = document.querySelector('#section_dropdown_label');
const dropdownBody = document.querySelector('#section_dropdown_body');

const selectionLabels = document.querySelectorAll('.selection_dropdown_label');

const selectSections = document.querySelectorAll('input[name="select_sections[]"]'); 

const selectedSectionsContainer = document.querySelector('#selected_sections_container');

label.addEventListener('click', () => {
    if(dropdownBody.ariaExpanded == 'true') {
        dropdownBody.ariaExpanded = false;
    }else{
        dropdownBody.ariaExpanded = true;
    }
});

selectionLabels.forEach(selection => {
    selection.addEventListener('click', () => {
        const selectionBody = selection.closest('div').querySelector('.selection_dropdown_body');

        if(selectionBody.ariaExpanded == 'true') {
            selectionBody.ariaExpanded = false;
        }else{
            selectionBody.ariaExpanded = true;
        }
    });
});


selectSections.forEach(select => {
    select.addEventListener('change', () => {
        if(select.checked) {
            const test = Object.assign(document.createElement('p'), {
                innerText:select.dataset.section,
                id:select.value,
            })
            selectedSectionsContainer.append(test);
        }else {
            document.getElementById(select.value).remove();
        }

    }); 
});