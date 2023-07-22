const saveBtn = document.querySelector('#save_schedule');
const BASE_PATH = document.querySelector('meta[name="base-path"]').getAttribute('content');

saveBtn.addEventListener('click', handleSubmit);

function handleSubmit() {
    const classroomId = document.querySelector('#classroom_id').value;
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
