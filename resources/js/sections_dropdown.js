const labels = document.querySelectorAll('.section_dropdown_label');

const selectionLabels = document.querySelectorAll('.selection_dropdown_label');

const selectSections = document.querySelectorAll('input[name="select_sections[]"]'); 

const selectedSectionsContainer = document.querySelector('#selected_sections_container');

const sectionCount = document.querySelector('#section_count');

labels.forEach(label => {
    label.addEventListener('click', () => {
        const dropdownBody = label.closest('div').querySelector('.section_dropdown_body');
        console.log(dropdownBody);
        if(dropdownBody.ariaExpanded == 'true') {
            dropdownBody.ariaExpanded = false;
        }else{
            dropdownBody.ariaExpanded = true;
        }
    });
})
    

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
            
            if(document.getElementById('empty_text')) {
                document.getElementById('empty_text').remove();
            }
            const test = Object.assign(document.createElement('p'), {
                innerText:select.dataset.section,
                id:select.value,
                classList: 'bg-white ring-1 ring-project-gray-default px-2 py-1 rounded-lg text-sm',
            })
            selectedSectionsContainer.append(test);
            Object.assign (sectionCount ,{
                innerText: selectedSectionsContainer.childElementCount,
                classList: 'font-normal text-project-accent',
            }) 
        }else {
            document.getElementById(select.value).remove();
            sectionCount.innerText = selectedSectionsContainer.childElementCount;
            if(selectedSectionsContainer.childElementCount < 1) {
                const emptyText = Object.assign(document.createElement('p'), {
                    innerText: 'No selected sections yet.',
                    id: 'empty_text',
                    classList: 'pl-2 text-amber-500 text-sm',
                })
                selectedSectionsContainer.append(emptyText);
                Object.assign (sectionCount ,{
                    innerText: selectedSectionsContainer.childElementCount-1,
                    classList: 'font-normal text-amber-500',
                })
            }
        }
    }); 
});

selectedSectionsContainer.addEventListener('change', () => {
    if(selectedSectionsContainer.childElementCount > 1) {
        console.log('more than one selected section');
        document.getElementById('empty_text').remove();
    }
});