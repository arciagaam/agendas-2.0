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
                //TESTING LANG KASI ALA YUNG TEACHER ID SA TEACHER HOURS PA
                const time_start = moment(schedule.time_start, "HH:mm");
                const time_end = moment(schedule.time_end, "HH:mm");

                const period_duration = moment.duration(time_end.diff(time_start)).asHours(); //time_end - time_start

                const result = teacher_hours[1]['regular_load'] - period_duration;

                console.log(result);
                if (schedule.teacher_id in teacher_hours) {

                    // install mo moment using npm --DONE
                    // pa kuha nung difference nung time_start at time_end --DONE
                    // teacher hours - yung difference ni TS and TE --DONE
                    // pa convert to hours yung sagot? --DONE
                    // pa console log ty --DONE

                    const time_start = moment(schedule.time_start, "HH:mm");
                    const time_end = moment(schedule.time_end, "HH:mm");

                    const period_duration = moment.duration(time_end.diff(time_start)).asHours(); //time_end - time_start

                    teacher_hours = teacher_hours[schedule.teacher_id]['regular_load'] - period_duration;

                    const result = teacher_hours[schedule.teacher_id]['regular_load'] - period_duration;

                    // console.log(result);


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
                if (subjects[subjectId]) {
                    computeSpDp(subjectId, 'sp', 'subtract');
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

const subjectItems2 = document.querySelectorAll('.subject-select-dropdown .subject');

subjectItems2.forEach(item => {
    item.addEventListener('click', () => {
        computeSpDp(item.dataset.id, 'sp', 'subtract');
    });
});

function computeTeacherHours(teacherId, timeStart, timeEnd, operation) {

    const time_start = moment(timeStart, "HH:mm");
    const time_end = moment(timeEnd, "HH:mm");

    const period_duration = moment.duration(time_end.diff(time_start)).asHours(); //time_end - time_start

    const result = teacher_hours[teacherId]['regular_load'] - period_duration;

    switch (operation) {
        case 'add': teacher_hours = teacher_hours[teacherId]['regular_load'] + period_duration; break;
        case 'subtract': teacher_hours = teacher_hours[teacherId]['regular_load'] - period_duration; break;
    }
}

document.addEventListener('click', (e) => {
    const target = e.target;
    if(target.classList.contains('teacher') || target.closest('.teacher')) {
        const teacherItem = target.closest('.teacher') ?? target;
        
        const time_start = teacherItem.closest('td').dataset.timestart;
        const time_end = teacherItem.closest('td').dataset.timeend;
        const teacher_id = teacherItem.dataset.id;
        const previous_teacher_id = teacherItem.closest('.teacher-select-dropdown').dataset.previousteacherid;

        const teacherContent = teacherItem.dataset.content;
        const teacherId = teacherItem.dataset.id;
        const teacherDropdown = teacherItem.closest('.teacher-select-dropdown');
        const selectedTeacher = teacherDropdown.querySelector('.selectedOption');

        selectedTeacher.textContent = teacherContent;
        selectedTeacher.id = teacherId;

        computeTeacherHours(teacher_id, time_start, time_end, 'subtract');
        computeTeacherHours(previous_teacher_id, time_start, time_end, 'add');
    }
})

window.addEventListener('load', async () => {
    if (saveBtn) {
        await getSubjectsByGradeLevel(classroomId);
        await getTeacherHours();
        await getClassSchedules();

        initialCountSpDp();

        console.log(teacher_hours);
    }
})

