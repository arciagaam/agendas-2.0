const dropdownLabels = document.querySelectorAll('.schedule_dropdown_label');

const selectionLabels = document.querySelectorAll('.subject_selection_dropdown_label');

const selectSubjects = document.querySelectorAll('.subject_data'); 

const selectedSectionsContainer = document.querySelector('#selected_sections_container');

dropdownLabels.forEach(label => {
    label.addEventListener('click', () => {
        const dropdownBody = label.closest('div').querySelector('.schedule_dropdown_body');
        if(dropdownBody.ariaExpanded == 'true') {
            dropdownBody.ariaExpanded = false;
        }else{
            dropdownBody.ariaExpanded = true;
        }
    });
})
    

selectionLabels.forEach(selection => {
    selection.addEventListener('click', () => {
        const selectionBody = selection.closest('div').querySelector('.subject_selection_dropdown_body');
        
        if(selectionBody.ariaExpanded == 'true') {
            selectionBody.ariaExpanded = false;
        }else{
            selectionBody.ariaExpanded = true;
        }
        
    });
});

selectSubjects.forEach(selectSubject => {
    selectSubject.addEventListener('click', () => {
        const mainContainer = selectSubject.closest('.schedule_dropdown_container');
        const label = mainContainer.querySelector('.section_dropdown_label_display');

        mainContainer.dataset.type = selectSubject.dataset.type;
        mainContainer.dataset.id = selectSubject.dataset.id
        label.innerText = selectSubject.innerText;

        const td = mainContainer.closest('td');
        const teacherDropdown = td.querySelector('.teachers_dropdown');

        if(selectSubject.dataset.type == 'academic') {
            teacherDropdown.classList.remove('hidden');
        } else {
            teacherDropdown.classList.add('hidden');
        }

    })
})
