import moment from "moment/moment";

// import moment from 'moment';
const saveBtn = document.querySelector('#save_schedule');
const BASE_PATH = document.querySelector('meta[name="base-path"]').getAttribute('content');
const classroomId = document.querySelector('#classroom_id').value;
const tableRows = document.querySelectorAll('[data-tableNumber] tbody tr');
const subjects = {};
const teacher_hours = {};

if (saveBtn) {
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
                if (schedule.teacher_id in teacher_hours) {

                    // install mo moment using npm --DONE
                    // pa kuha nung difference nung time_start at time_end --DONE
                    // teacher hours - yung difference ni TS and TE --DONE
                    // pa convert to hours yung sagot? --DONE
                    // pa console log ty --DONE
                    // const regular_load = teacher_hours[schedule.teacher_id]['regular_load'];

                    const time_start = moment(schedule.time_start, "HH:mm");
                    const time_end = moment(schedule.time_end, "HH:mm");

                    const period_duration = moment.duration(time_end.diff(time_start)).asHours(); //time_end - time_start

                    const result = teacher_hours[schedule.teacher_id]['regular_load'] - period_duration;

                    console.log(result);

                    console.log(period_duration);

                }

            })

        });
}


function initialCountSpDp() {
    tableRows.forEach((row, rowindex) => {
        const cols = row.querySelectorAll('td');
        cols.forEach((col, colindex) => {
            if (colindex != 0) {
                let type = 'sp';
                const prevRowColumns = tableRows[rowindex - 1]?.querySelectorAll('td');
                const nextRowColumns = tableRows[rowindex + 1]?.querySelectorAll('td');
                const subjectId = col.querySelector('.subject-select-dropdown .selectedOption').id;

                if (prevRowColumns) {
                    const prevId = prevRowColumns[colindex].querySelector('.subject-select-dropdown .selectedOption').id;

                    if (subjectId == prevId) {
                        type = 'dp';
                    }
                }

                if (nextRowColumns) {
                    const nextId = nextRowColumns[colindex].querySelector('.subject-select-dropdown .selectedOption').id;

                    if (subjectId == nextId) {
                        type = 'dp';
                    }
                }

                if (subjects[subjectId]) {
                    computeSpDp(subjectId, type, 'subtract');
                }
            }
        })
    })
}

function computeSpDp(subjectId, type, operation) {
    switch (operation) {
        case 'add': subjects[subjectId][type] += 1; break;
        case 'subtract': subjects[subjectId][type] -= 1; break;
    }
}

function saveCurrentScheduleToLocalStorage() {
    const schedule = [];
    const tableRows = document.querySelectorAll('[data-tableNumber] tbody tr');

    tableRows.forEach((row, rowindex) => {
        const cols = row.querySelectorAll('td');
        cols.forEach((col, colindex) => {
            if (colindex != 0) {
                const rowData = {
                    classroom_id: classroomId,
                    timetable: col.closest('table').dataset.tablenumber,
                    subject_teacher_id: col.dataset.subjectteacherid ?? null,
                    subject_id: col.querySelector('.subject-select-dropdown .selectedOption').id,
                    teacher_id: col.querySelector('.teacher-select-dropdown .selectedOption').id,
                    day_id: col.ariaColIndex,
                    period_slot: rowindex + 1,
                }

                schedule.push(rowData);
            }
        })
    })

    localStorage.setItem(document.querySelector('#classroom_id').value, JSON.stringify(schedule));
}

const subjectItems2 = document.querySelectorAll('.subject-select-dropdown .subject');

subjectItems2.forEach(item => {
    item.addEventListener('click', () => {
        computeSpDp(item.dataset.id, 'sp', 'subtract');
        saveCurrentScheduleToLocalStorage();
        console.log(JSON.parse(localStorage.getItem(document.querySelector('#classroom_id').value)))
    });
});


window.addEventListener('load', async () => {
    if (saveBtn) {
        await getSubjectsByGradeLevel(classroomId);
        await getTeacherHours();
        await getClassSchedules();
        initialCountSpDp();

        // sa dulo lagi dapat to
        saveCurrentScheduleToLocalStorage();
    }
})

