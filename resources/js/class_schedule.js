const saveBtn = document.querySelector('#save_schedule');
const BASE_PATH = document.querySelector('meta[name="base-path"]').getAttribute('content');
const classroomId = document.querySelector('#classroom_id').value;

saveBtn.addEventListener('click', handleSubmit);

function handleSubmit() {
    const schedule = [];

    const tables = document.querySelectorAll('table');
    const tableRows = document.querySelectorAll('[data-tableNumber] tbody tr');

    tableRows.forEach((row, rowindex) => {
        const cols = row.querySelectorAll('td');
        cols.forEach((col, colindex) => {
            if(colindex != 0) {
                const rowData = {
                    classroom_id: classroomId,
                    timetable: col.closest('table').dataset.tablenumber,
                    subject_teacher_id: col.dataset.subjectteacherid ?? null,
                    day_id : col.ariaColIndex,
                    period_slot : rowindex+1,
                }
                schedule.push(rowData);
            }
        })
    })
    
    const form = new FormData;
    form.append('schedules', JSON.stringify(schedule));

    fetch(`${BASE_PATH}/api/schedule/store`, {
        headers:{
            'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        },
        method: "POST",
        body: form,
    })
    .then(res => console.log(res));
}

function getSubjectsByGradeLevel (classroom_id) {
    fetch(`${BASE_PATH}/api/subjects/${classroom_id}`, {
        headers:{
            'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        },
        method: "POST",
    })
    .then(res => res.json())
    .then(data => {
        const subjects = [];
        data.payload.forEach(subject => {
            const subjectSpDp = {
                [subject.id] :  {
                    sp: subject.sp_frequency,
                    dp: subject.dp_frequency,
                },
            };

            subjects.push(subjectSpDp);
        });
        console.log(subjects);
    });
}

getSubjectsByGradeLevel(classroomId);

