const saveBtn = document.querySelector('#save_schedule');
const BASE_PATH = document.querySelector('meta[name="base-path"]').getAttribute('content');
const classroomId = document.querySelector('#classroom_id').value;
const tableRows = document.querySelectorAll('[data-tableNumber] tbody tr');
const subjects = {};
const teacher_hours = {};

if(saveBtn) {
    saveBtn.addEventListener('click', handleSubmit);
}

function handleSubmit() {
    const schedule = [];

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

async function getSubjectsByGradeLevel(classroom_id) {
    await fetch(`${BASE_PATH}/api/subjects/${classroom_id}`, {
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
    });
    
}

async function getTeacherHours() {
    await fetch(`${BASE_PATH}/api/teacher_hours`, {
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

async function getClassSchedules() {
    await fetch(`${BASE_PATH}/api/schedules`, {
        headers: {
            'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        },
        method: "POST",
    })
    .then(res => res.json())
    .then(data => {

        data.payload.forEach(schedule => {

            if(schedule.teacher_id in teacher_hours) {

                // install mo moment using npm 
                // pa kuha nung difference nung time_start at time_end
                // teacher hours - yung difference ni TS and TE
                // pa convert to hours yung sagot?
                // pa console log ty
            }

        })

    });
}



function initialCountSpDp() {
    tableRows.forEach((row, rowindex) => {
        const cols = row.querySelectorAll('td');
        cols.forEach((col, colindex) => {
            if (colindex != 0) {
                const subjectId = col.querySelector('.subject-select-dropdown .selectedOption').id;
                if(subjects[subjectId]) {
                    computeSpDp(subjectId, 'sp', 'subtract');
                }
            }
        })
    })
}

function computeSpDp(subjectId, type, operation) {
    switch(operation) {
        case 'add' : subjects[subjectId][type] += 1; break;
        case 'subtract' : subjects[subjectId][type] -= 1; break;
    }
}

const subjectItems2 = document.querySelectorAll('.subject-select-dropdown .subject');

subjectItems2.forEach(item => {
    item.addEventListener('click', () => {
        computeSpDp(item.dataset.id, 'sp', 'subtract');
    });
});

window.addEventListener('load', async () => {
    if(saveBtn) {
        await getSubjectsByGradeLevel(classroomId);
        await getTeacherHours();
        await getClassSchedules();
    
        initialCountSpDp();

        console.log(teacher_hours);
    }
})

