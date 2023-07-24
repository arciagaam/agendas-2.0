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

            //localStorage 
            if (localStorage) {
                localStorage.setItem(`unsaved.teacher_hours`, JSON.stringify(teacher_hours));
            }

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

                    const time_start = moment(schedule.time_start, "HH:mm");
                    const time_end = moment(schedule.time_end, "HH:mm");

                    const period_duration = moment.duration(time_end.diff(time_start)).asHours(); //time_end - time_start

                    teacher_hours[schedule.teacher_id]['regular_load'] -= period_duration;

                    teacher_hours[schedule.teacher_id]['regular_load'] -= period_duration;

                    if (localStorage) {
                        localStorage.setItem(`unsaved.teacher_hours`, JSON.stringify(teacher_hours));
                    }


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

                if (subjectId in subjects) {
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

async function saveToServerSession() {
    const schedule = [];
    const tableRows = document.querySelectorAll('[data-tableNumber] tbody tr');

    tableRows.forEach((row, rowindex) => {
        const cols = row.querySelectorAll('td');
        cols.forEach((col, colindex) => {
            if (colindex != 0) {

                const rowData = {
                    classroom_id: classroomId,
                    subject_teacher_id: col.dataset.subjectteacherid ?? null,
                    // school_year_id: col.dataset.schoolyearid,
                    timetable: col.dataset.timetable,
                    day_id: col.dataset.dayid,
                    period_slot: col.dataset.periodslot,
                    time_start: col.dataset.timestart,
                    time_end: col.dataset.timeend,
                    subject_id: col.dataset.subjectid,
                    subject_name: col.dataset.subjectname,
                    default_subject_id: col.dataset.defaultsubjectid,
                    subject_type_id: col.dataset.subjecttypeid,
                    teacher_id: col.dataset.teacherid,
                    honorific: col.dataset.honorific,
                    first_name: col.dataset.firstname,
                    last_name: col.dataset.lastname,
                }

                schedule.push(rowData);
            }
        })
    })

    const form = new FormData();
    form.append('schedule', JSON.stringify(schedule));

    await fetch(BASE_PATH + '/admin/schedules/classes/store-session', {
        headers: {
            'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        },
        method: "POST",
        body: form
    });

    //localStorage 
    if (localStorage) {
        localStorage.setItem(`unsaved.schedule.${classroomId}`, JSON.stringify(schedule));
    }
    console.log(schedule);
    console.log('saved session');
}

const subjectItems2 = document.querySelectorAll('.subject-select-dropdown .subject');

subjectItems2.forEach(item => {
    item.addEventListener('click', () => {

        if (item.dataset.id in subjects) {
            computeSpDp(item.dataset.id, 'sp', 'subtract');
        }

        const td = item.closest('td');
        td.dataset.subjectid = item.dataset.id;
        td.dataset.defaultsubjectid = item.dataset.defaultsubjectid;
        td.dataset.subjectname = item.dataset.content;
        td.dataset.subjecttypeid = item.dataset.subjecttypeid;

        td.dataset.subjectteacherid = item.dataset.subjectteacherid;
        td.dataset.teacherid = '';
        td.dataset.honorific = '';
        td.dataset.firstname = '';
        td.dataset.lastname = '';

        saveToServerSession();
    });
});

function computeTeacherHours(teacherId, timeStart, timeEnd, operation) {

    const time_start = moment(timeStart, "HH:mm");
    const time_end = moment(timeEnd, "HH:mm");

    const period_duration = moment.duration(time_end.diff(time_start)).asHours(); //time_end - time_start

    const unsaved_teacher_hours = JSON.parse(localStorage.getItem(`unsaved.teacher_hours`));
    console.log(unsaved_teacher_hours, 'before');

    if (teacherId) {
        switch (operation) {
            case 'add': unsaved_teacher_hours[teacherId]['regular_load'] += period_duration; break;
            case 'subtract': unsaved_teacher_hours[teacherId]['regular_load'] -= period_duration; break;
        }
    }

    console.log(unsaved_teacher_hours, 'after');

    const updatedTeacherHours = JSON.stringify(unsaved_teacher_hours);

    localStorage.setItem(`unsaved.teacher_hours`, updatedTeacherHours);
}

document.addEventListener('click', (e) => {
    const target = e.target;
    if (target.classList.contains('teacher') || target.closest('.teacher')) {
        const teacherItem = target.closest('.teacher') ?? target;

        const teacherDropdown = teacherItem.closest('.teacher-select-dropdown');

        const time_start = teacherItem.closest('td').dataset.timestart;
        const time_end = teacherItem.closest('td').dataset.timeend;
        const teacher_id = teacherItem.dataset.id;
        const previous_teacher_id = teacherDropdown.dataset.previousteacherid;

        const teacherContent = teacherItem.dataset.content;
        const selectedTeacher = teacherDropdown.querySelector('.selectedOption');

        selectedTeacher.textContent = teacherContent;
        selectedTeacher.id = teacher_id;

        computeTeacherHours(teacher_id, time_start, time_end, 'subtract');
        computeTeacherHours(previous_teacher_id, time_start, time_end, 'add');
        const td = teacherItem.closest('td');
        td.dataset.subjectteacherid = teacherItem.dataset.subjectteacherid;
        td.dataset.teacherid = teacherItem.dataset.id;
        td.dataset.honorific = teacherItem.dataset.honorific;
        td.dataset.firstname = teacherItem.dataset.firstname;
        td.dataset.lastname = teacherItem.dataset.lastname;

        saveToServerSession();
        
        const test = JSON.parse(localStorage.getItem(`unsaved.teacher_hours`));
        console.log(test);
    }
})

window.addEventListener('load', async () => {
    if (saveBtn) {

        await getSubjectsByGradeLevel(classroomId);
        await getTeacherHours();
        await getClassSchedules();
        initialCountSpDp();

        // sa dulo lagi dapat to
        saveToServerSession();
    }
})

