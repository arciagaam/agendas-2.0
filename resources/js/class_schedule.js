const saveBtn = document.querySelector('#save_schedule');
const BASE_PATH = document.querySelector('meta[name="base-path"]').getAttribute('content');
const classroomId = document.querySelector('#classroom_id').value;
const subjects = {};
const teacher_hours = {};

saveBtn.addEventListener('click', handleSubmit);

function handleSubmit() {
    const schedule = [];

    const tables = document.querySelectorAll('table');
    const tableRows = document.querySelectorAll('[data-tableNumber] tbody tr');

    tableRows.forEach((row, rowindex) => {
        const cols = row.querySelectorAll('td');
        cols.forEach((col, colindex) => {
            if (colindex != 0) {
                const rowData = {
                    classroom_id: classroomId,
                    timetable: col.closest('table').dataset.tablenumber,
                    subject_teacher_id: col.dataset.subjectteacherid ?? null,
                    day_id: col.ariaColIndex,
                    period_slot: rowindex + 1,
                }
                schedule.push(rowData);
            }
        })
    })

    const form = new FormData;
    form.append('schedules', JSON.stringify(schedule));

    fetch(`${BASE_PATH}/api/schedule/store`, {
        headers: {
            'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        },
        method: "POST",
        body: form,
    })
        .then(res => console.log(res));
}

function getSubjectsByGradeLevel(classroom_id) {
    fetch(`${BASE_PATH}/api/subjects/${classroom_id}`, {
        headers: {
            'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        },
        method: "POST",
    })
        .then(res => res.json())
        .then(data => {

            data.payload.forEach(subject => {
                subjects[subject.id] = {
                    sp: subject.sp_frequency,
                    dp: subject.dp_frequency,
                };
            });
            console.log(subjects);
        });
}

function getTeacherHours() {
    fetch(`${BASE_PATH}/api/teacher_hours`, {
        headers: {
            'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        },
        method: "POST",
    })
        .then(res => res.json())
        .then(data => {

            data.payload.forEach(teacher => {
                teacher_hours[`${teacher.id}`] = {
                    max_hours: teacher.max_hours,
                    regular_load: teacher.regular_load,
                }
            });
        });
}

const subjectItems2 = document.querySelectorAll('.subject-select-dropdown .subject');

subjectItems2.forEach(item => {
    item.addEventListener('click', () => {
        subjects[item.dataset.id]["sp"] -= 1;
        console.log(subjects);
    });
});

getSubjectsByGradeLevel(classroomId);
getTeacherHours();

