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
                        className: 'teacher whitespace-nowrap bg-project-primary-600 text-white hover:bg-project-gray-dark'
                    });

                    mainContainer.dataset.id = teacher.id;
                    mainContainer.dataset.content = `${teacher.honorific} ${teacher.first_name} ${teacher.middle_name ?? ''} ${teacher.last_name}`;
                    mainContainer.dataset.subjectteacherid = teacher.subject_teacher_id;
                    mainContainer.dataset.honorific = teacher.honorific;
                    mainContainer.dataset.firstname = teacher.first_name;
                    mainContainer.dataset.lastname = teacher.last_name;

                    const pContainer = Object.assign(document.createElement('div'), {
                        className: 'flex flex-col p-3'
                    });

                    const teacherName = Object.assign(document.createElement('p'), {
                        className: 'whitespace-nowrap',
                        innerText: `${teacher.honorific} ${teacher.first_name} ${teacher.middle_name ?? ''} ${teacher.last_name}`
                    });

                    const maxHours = Object.assign(document.createElement('p'), {
                        className: 'max-hours text-xs',
                        innerText: 'Available for this day: ' + teacher_hours.current[teacher.dataset.id]['max_hours']
                    });

                    const regularLoad = Object.assign(document.createElement('p'), {
                        className: 'max-hours text-xs',
                        innerText: 'Regular load: ' + teacher_hours.current[teacher.dataset.id]['regular_load']
                    });

                    mainContainer.append(pContainer);
                    pContainer.append(teacherName);
                    pContainer.append(maxHours);
                    pContainer.append(regularLoad);
                    teacherDropdown.append(mainContainer);
                    teacherDropdown.id = teacher.id;
                    td.dataset.subjectteacherid = teacher.subject_teacher_id;


                    // document.querySelectorAll('.teacher').forEach(teacher => {
                    //     console.log(teacher);
                    //     teacher.querySelector('.max-hours').innerText = 'Available for this day: ' + teacher_hours.current[teacher.dataset.id]['max_hours'];
                    //     teacher.querySelector('.regular-load').innerText = 'Regular load: ' + teacher_hours.current[teacher.dataset.id]['regular_load'];
                    // })

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
    if (target.classList.contains('teacher') || target.closest('.teacher')) {
        closeAllSubjectSelections();
    }
})



