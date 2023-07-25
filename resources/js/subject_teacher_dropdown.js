const BASE_PATH = document.querySelector('meta[name="base-path"]').getAttribute('content');
const labels = document.querySelectorAll('.subject_select_dropdown_label');
const selectSubjects = document.querySelectorAll('input[name="select_subjects[]"]');
const selectionBodies = document.querySelectorAll('.subject_select_dropdown_body, .teacher_select_dropdown_body');

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

        // empty teacher dropdown
        const td = item.closest('td');
        const teacherDropdown = td.querySelector('.teacher_select_dropdown_body');
        const selectedTeacher = td.querySelector('.teacher_select_dropdown_label .selectedOption');
        selectedTeacher.textContent = 'Select Teacher';
        teacherDropdown.innerText = "";


        //fetch( na kukuha ng teachers ng pinili na subject)
        fetch(BASE_PATH + `/api/teachers_by_subject/${id}`, {
            headers: {
                'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
              },
              method: 'POST',
        })
        .then(res => res.json())
        .then(data => {
            data.payload.forEach(teacher => {
                const mainContainer = Object.assign(document.createElement('div'), {
                    className: 'teacher whitespace-nowrap bg-project-primary text-white hover:bg-project-gray-dark'
                });

                mainContainer.dataset.id = teacher.id;
                mainContainer.dataset.content = `${teacher.honorific} ${teacher.first_name} ${teacher.middle_name ?? ''} ${teacher.last_name}`;
                mainContainer.dataset.subjectteacherid = teacher.subject_teacher_id;
                mainContainer.dataset.honorific = teacher.honorific;
                mainContainer.dataset.firstname = teacher.first_name;
                mainContainer.dataset.lastname = teacher.last_name;

                const teacherName = Object.assign(document.createElement('p'), {
                    innerText: `${teacher.honorific} ${teacher.first_name} ${teacher.middle_name ?? ''} ${teacher.last_name}`
                })

                mainContainer.append(teacherName);
                teacherDropdown.append(mainContainer);
                teacherDropdown.id = teacher.id;
                td.dataset.subjectteacherid = teacher.subject_teacher_id;
            })
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
            closeAllSubjectSelections();
            teacherSelectionBody.ariaExpanded = true;
            const previousTeacherId = teacherSelection.querySelector('.selectedOption').id;
            const teacherSelectDropdown = teacherSelection.closest('.teacher-select-dropdown');
            teacherSelectDropdown.dataset.previousteacherid = previousTeacherId;
        }
    });
});

const teacherItems = document.querySelectorAll('.teacher-select-dropdown .teacher');

document.addEventListener('click', (e) => {
    const target = e.target;
    if(target.classList.contains('teacher') || target.closest('.teacher')) {
        
        closeAllSubjectSelections();
    }
})

// teacherItems.forEach(teacherItem => {
//     teacherItem.addEventListener('click', () => {
//         const teacherContent = teacherItem.dataset.content;
//         const teacherDropdown = teacherItem.closest('.teacher-select-dropdown');
//         const selectedTeacher = teacherDropdown.querySelector('.selectedOption');

//         console.log('Teacher Content', teacherContent);

//         selectedTeacher.textContent = teacherContent;
//     });
// });


