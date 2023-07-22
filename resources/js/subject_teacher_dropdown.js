const BASE_PATH = document.querySelector('meta[name="base-path"]').getAttribute('content');
const labels = document.querySelectorAll('.subject_select_dropdown_label');
const selectSubjects = document.querySelectorAll('input[name="select_subjects[]"]');
const selectionBodies = document.querySelectorAll('.subject_select_dropdown_body');

function closeAllSubjectSelections() {
    selectionBodies.forEach(selectionBody => {
        selectionBody.ariaExpanded = false;
    })
}

labels.forEach(selection => {
    selection.addEventListener('click', () => {
        const selectionBody = selection.closest('div').querySelector('.subject_select_dropdown_body');
        
        if (selectionBody.ariaExpanded == 'true') {
            selectionBody.ariaExpanded = false;
        } else {
            closeAllSubjectSelections();
            selectionBody.ariaExpanded = true;
        }
    });
});

const subjectItems = document.querySelectorAll('.subject-select-dropdown .subject');

subjectItems.forEach(item => {
    item.addEventListener('click', () => {
        const content = item.dataset.content;
        const id = item.dataset.id;
        const dropdown = item.closest('.subject-select-dropdown');
        const selectedSubject = dropdown.querySelector('.selectedOption');

        console.log('Content', content)
        console.log('selectedSubject Content');

        selectedSubject.textContent = content;
        dropdown.id = id;

        //fetch( na kukuha ng teachers ng pinili na subject)
        fetch(BASE_PATH + `/api/teachers_by_subject/${id}`, {
            headers: {
                'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
              },
              method: 'POST',
        })
        .then(res => res.json())
        .then(data => {
            console.log(data);
        });

        closeAllSubjectSelections();
    });
});

const teacherLabels = document.querySelectorAll('.teacher_select_dropdown_label');

teacherLabels.forEach(teacherSelection => {
    teacherSelection.addEventListener('click', () => {
        const teacherSelectionBody = teacherSelection.closest('div').querySelector('.teacher_select_dropdown_body');

        if (teacherSelectionBody.ariaExpanded == 'true') {
            teacherSelectionBody.ariaExpanded = false;
        } else {
            teacherSelectionBody.ariaExpanded = true;
        }
    });
});

const teacherItems = document.querySelectorAll('.teacher-select-dropdown .teacher');

teacherItems.forEach(teacherItem => {
    teacherItem.addEventListener('click', () => {
        const teacherContent = teacherItem.dataset.content;
        const teacherDropdown = teacherItem.closest('.teacher-select-dropdown');
        const selectedTeacher = teacherDropdown.querySelector('.selectedOption');

        console.log('Teacher Content', teacherContent);

        selectedTeacher.textContent = teacherContent;
    });
});

