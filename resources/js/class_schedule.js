import moment from "moment/moment";

// import moment from 'moment';
const saveBtn = document.querySelector('#save_schedule');
const BASE_PATH = document.querySelector('meta[name="base-path"]').getAttribute('content');
const classroomId = document.querySelector('#classroom_id').value;
const tableRows = document.querySelectorAll('[data-tableNumber] tbody tr');
const classSchedules = {};
let classSchedulesArray = [];

let subjects = {
    reset: {}, current: {}
};
let teacher_hours = {
    reset: {}, current: {}
};

if (saveBtn) {
    saveBtn.addEventListener('click', handleSubmit);
}

function saveSchedulesArrayToLocal() {
    const classSchedule = JSON.parse(localStorage.getItem('unsaved.class_schedules'));
    const classScheduleArray = [];

    for(let classroom in classSchedule) {
        for(let schedule in classSchedule[classroom]) {
            classScheduleArray.push(classSchedule[classroom][schedule]);
        }
    }

    localStorage.setItem('unsaved.class_schedules_array', JSON.stringify(classScheduleArray));
}

// Save to laravel session via fetch
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

}

// Submit
function handleSubmit() {
    localStorage.clear();
    fetch(BASE_PATH + '/admin/schedules/classes/save')
    .then(res => console.log(res));
}

// Get subjects on load
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
            subjects['reset'][subject.id] = {
                sp: subject.sp_frequency,
                dp: subject.dp_frequency,
            };
            subjects['current'][subject.id] = {
                sp: subject.sp_frequency,
                dp: subject.dp_frequency,
            };
        });
    });
}

// Get teacher hours on load
async function getTeacherHours() {

    if(localStorage.getItem('unsaved.teacher_hours')) {
        const teachers = JSON.parse(localStorage.getItem('unsaved.teacher_hours'));
        for(let key in teachers.current) {
            teacher_hours.reset[`${key}`] = {
                max_hours: teachers.current[key].max_hours,
                regular_load: teachers.current[key].regular_load,
            }

            teacher_hours.current[`${key}`] = {
                max_hours: teachers.current[key].max_hours,
                regular_load: teachers.current[key].regular_load,
            }
        }
        return;
    }


    await fetch(`${BASE_PATH}/api/teacher_hours`, {
        headers: {
            'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        },
        method: "POST",
    })
    .then(res => res.json())
    .then(data => {
        data.payload.forEach(teacher => {

            teacher_hours.reset[`${teacher.id}`] = {
                max_hours: teacher.max_hours,
                regular_load: teacher.regular_load,
            }

            teacher_hours.current[`${teacher.id}`] = {
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

            if(!localStorage.getItem('unsaved.class_schedules')){
                classSchedulesArray = data.payload;

                if(!(schedule.classroom_id in classSchedules)) {
                    classSchedules[schedule.classroom_id] = {};
                }
                
                classSchedules[schedule.classroom_id][`${schedule.timetable}_${schedule.period_slot}_${schedule.day_id}`] = schedule;
            }

            if(!localStorage.getItem('unsaved.teacher_hours')){
                if (schedule.teacher_id in teacher_hours.current) {
                    const timeStart = moment(schedule.time_start, "HH:mm");
                    const timeEnd = moment(schedule.time_end, "HH:mm");
    
                    computeTeacherHours(schedule.teacher_id , timeStart, timeEnd, 'subtract');
                }
            }
        });


    });
}

function deepCopy(obj) {
    return JSON.parse(JSON.stringify(obj));
}

function resetSubjects() {
    subjects.current = deepCopy(subjects.reset)
}

function initialCountSpDp() {
    resetSubjects();
    
    const tableRows = document.querySelectorAll('[data-tableNumber] tbody tr');

    tableRows.forEach((row, rowindex) => {
        const cols = row.querySelectorAll('td');
        cols.forEach((col, colindex) => {
            if (colindex != 0 && !col.hasAttribute('data-marker')) {
                let type = 'sp';
                const prevRowColumns = tableRows[rowindex - 1]?.querySelectorAll('td');
                const nextRowColumns = tableRows[rowindex + 1]?.querySelectorAll('td');
                const subjectId = col.dataset.subjectid;

                if (prevRowColumns) {
                    const prevId = prevRowColumns[colindex].dataset.subjectid;
                    const hasMarker = prevRowColumns[colindex].hasAttribute('data-marker');

                    if (subjectId == prevId && !hasMarker) {
                        prevRowColumns[colindex].dataset.marker = 'dp'
                        type = 'dp';
                    }
                }

                if (nextRowColumns) {
                    const nextId = nextRowColumns[colindex].dataset.subjectid;
                    if (subjectId == nextId) {
                        nextRowColumns[colindex].dataset.marker = 'dp'
                        type = 'dp';
                    }
                }
                
                if (subjectId in subjects.current) {
                    computeSpDp(subjectId, type, 'subtract');
                }
            }

            checkConflicts(col)
        });
    
    });

    document.querySelectorAll('.subject[data-subjecttypeid="1"]').forEach(subject => {
        subject.querySelector('.sp').innerText = 'SP: ' + subjects.current[subject.dataset.id]['sp']
        subject.querySelector('.dp').innerText = 'DP: ' + subjects.current[subject.dataset.id]['dp']
    })

    document.querySelectorAll('[data-marker]').forEach(cell => {
        cell.removeAttribute('data-marker');
    });
}

function computeSpDp(subjectId, type, operation) {
    switch (operation) {
        case 'add': subjects.current[subjectId][type] += 1; break;
        case 'subtract': subjects.current[subjectId][type] -= 1; break;
    }

    return subjects.current[subjectId][type];
}

const subjectItems2 = document.querySelectorAll('.subject-select-dropdown .subject');

// Select subject
subjectItems2.forEach(item => {
    item.addEventListener('click', () => {
        const currentCell = item.closest('td');
        currentCell.dataset.subjectid = item.dataset.id;
        currentCell.dataset.defaultsubjectid = item.dataset.defaultsubjectid;
        currentCell.dataset.subjectname = item.dataset.content;
        currentCell.dataset.subjecttypeid = item.dataset.subjecttypeid;

        currentCell.dataset.subjectteacherid = item.dataset.subjectteacherid;
        currentCell.dataset.teacherid = '';
        currentCell.dataset.honorific = '';
        currentCell.dataset.firstname = '';
        currentCell.dataset.lastname = '';

        const changeSubject = JSON.parse(localStorage.getItem('unsaved.class_schedules'));

        const row = currentCell.dataset.periodslot;
        const col = currentCell.dataset.dayid;
        const timetable = currentCell.dataset.timetable;
        
        changeSubject[classroomId][`${timetable}_${row}_${col}`].default_subject_id = item.dataset.defaultsubjectid;
        changeSubject[classroomId][`${timetable}_${row}_${col}`].first_name = null;
        changeSubject[classroomId][`${timetable}_${row}_${col}`].last_name = null;
        changeSubject[classroomId][`${timetable}_${row}_${col}`].honorific = null;
        changeSubject[classroomId][`${timetable}_${row}_${col}`].subjectid = item.dataset.id;
        changeSubject[classroomId][`${timetable}_${row}_${col}`].subject_name = item.dataset.content;
        changeSubject[classroomId][`${timetable}_${row}_${col}`].subject_teacher_id = item.dataset.subjectteacherid;

        localStorage.setItem('unsaved.class_schedules', JSON.stringify(changeSubject));
        initialCountSpDp();
        saveToServerSession();
        saveSchedulesArrayToLocal();

        checkConflicts(currentCell);

    });
});

function computeTeacherHours(teacherId, timeStart, timeEnd, operation) {
    const time_start = moment(timeStart, "HH:mm");
    const time_end = moment(timeEnd, "HH:mm");

    const period_duration = moment.duration(time_end.diff(time_start)).asHours();

    if (teacherId) {
        switch (operation) {
            case 'add': teacher_hours.current[teacherId]['regular_load'] += period_duration; break;
            case 'subtract': teacher_hours.current[teacherId]['regular_load'] -= period_duration; break;
        }
    }
}

// Select teacher
document.addEventListener('click', (e) => {
    const target = e.target;
    if (target.classList.contains('teacher') || target.closest('.teacher')) {
        const teacherItem = target.closest('.teacher') ?? target;

        const teacherDropdown = teacherItem.closest('.teacher-select-dropdown');
        const td = teacherItem.closest('td');

        const time_start = td.dataset.timestart;
        const time_end = td.dataset.timeend;
        const teacher_id = teacherItem.dataset.id;
        const previous_teacher_id = teacherDropdown.dataset.previousteacherid;

        const teacherContent = teacherItem.dataset.content;
        const selectedTeacher = teacherDropdown.querySelector('.selectedOption');

        selectedTeacher.textContent = teacherContent;
        selectedTeacher.id = teacher_id;

        computeTeacherHours(teacher_id, time_start, time_end, 'subtract');
        computeTeacherHours(previous_teacher_id, time_start, time_end, 'add');
        
        td.dataset.subjectteacherid = teacherItem.dataset.subjectteacherid;
        td.dataset.teacherid = teacherItem.dataset.id;
        td.dataset.honorific = teacherItem.dataset.honorific;
        td.dataset.firstname = teacherItem.dataset.firstname;
        td.dataset.lastname = teacherItem.dataset.lastname;
        
        const changeSubject = JSON.parse(localStorage.getItem('unsaved.class_schedules'));
        
        const row = td.dataset.periodslot;
        const col = td.dataset.dayid;
        const timetable = td.dataset.timetable;
        
        changeSubject[classroomId][`${timetable}_${row}_${col}`].first_name = teacherItem.dataset.firstname;
        changeSubject[classroomId][`${timetable}_${row}_${col}`].last_name = teacherItem.dataset.lastname;
        changeSubject[classroomId][`${timetable}_${row}_${col}`].honorific = teacherItem.dataset.honorific;
        changeSubject[classroomId][`${timetable}_${row}_${col}`].subject_teacher_id = teacherItem.dataset.subjectteacherid;
        changeSubject[classroomId][`${timetable}_${row}_${col}`].teacher_id = teacherItem.dataset.id;

        saveToServerSession();
        localStorage.setItem('unsaved.teacher_hours', JSON.stringify(teacher_hours));
        localStorage.setItem('unsaved.class_schedules', JSON.stringify(changeSubject));
        saveSchedulesArrayToLocal();
        checkConflicts(td);
    }
})

function checkConflicts(cellData) {
    const schedules = JSON.parse(localStorage.getItem('unsaved.class_schedules_array'));

    const filteredSchedules = schedules.filter(schedule => {
        const cellDataTimeStart = moment(cellData.dataset.timestart, 'hh:mm');
        const scheduleTimeStart = moment(schedule.time_start, 'hh:mm');
        const cellDataTimeEnd = moment(cellData.dataset.timeend, 'hh:mm');
        const scheduleTimeEnd = moment(schedule.time_end, 'hh:mm');

        return (
            cellData.dataset.dayid == schedule.day_id &&
            (
                (cellDataTimeStart.isAfter(scheduleTimeStart) && cellDataTimeStart.isBefore(scheduleTimeStart)) ||
                (cellDataTimeEnd.isAfter(scheduleTimeStart) && cellDataTimeEnd.isBefore(scheduleTimeEnd)) ||
                (cellDataTimeStart.isBefore(scheduleTimeStart) && cellDataTimeEnd.isAfter(scheduleTimeEnd)) ||
                cellDataTimeStart.isSame(scheduleTimeStart) ||
                cellDataTimeEnd.isSame(scheduleTimeEnd)
            ) &&
            cellData.dataset.teacherid == schedule.teacher_id
        )
    })

    if(filteredSchedules.length > 1) {
        cellData.children[0].classList.add('bg-red-50');
    }else {
        cellData.children[0].classList.remove('bg-red-50');
        
    }

}

window.addEventListener('load', async () => {
    if (saveBtn && document.querySelectorAll('table').length) {
        // Always take note of the order!!!

        await getSubjectsByGradeLevel(classroomId);
        await getTeacherHours();
        await getClassSchedules();

        if(!localStorage.getItem('unsaved.class_schedules')) {
            localStorage.setItem('unsaved.class_schedules', JSON.stringify(classSchedules));
            localStorage.setItem('unsaved.class_schedules_array', JSON.stringify(classSchedulesArray));
        }

        initialCountSpDp();

        localStorage.setItem('unsaved.teacher_hours', JSON.stringify(teacher_hours));
        
        // sa dulo lagi dapat to
        saveToServerSession();

        console.log(subjects.current)
    }
})



