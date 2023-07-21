const labels = document.querySelectorAll('.subject_select_dropdown_label');
const selectSubjects = document.querySelectorAll('input[name="select_subjects[]"]');


labels.forEach(selection => {
    selection.addEventListener('click', () => {
        const selectionBody = selection.closest('div').querySelector('.subject_select_dropdown_body');

        if (selectionBody.ariaExpanded == 'true') {
            selectionBody.ariaExpanded = false;
        } else {
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

