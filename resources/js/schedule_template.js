const tableContainers = document.querySelector('#table_container');
const table = document.querySelector('table');
const submitBtn = document.querySelector('#submit_schedule_template');
const timetableSelections = document.querySelectorAll('select[name="timetable_selection[]"]');

document.addEventListener('click', (e) => {
    const target = e.target;

    if(target.tagName.toLowerCase() == 'button') {
        if(target.classList.contains('add-row')) {
            const rowIndex = target.closest('tr').rowIndex; 
            const cloned = table.querySelectorAll('tr')[rowIndex].cloneNode(true);
            table.querySelector('tbody').append(cloned);
        }

        if(target.classList.contains('remove-row')) {
            const rowIndex = target.closest('tr').rowIndex;
            table.querySelectorAll('tr')[rowIndex].remove();
        }
    }
});

// CHANGE TIMETABLE
timetableSelections.forEach(timetableSelection => {
    timetableSelection.addEventListener('change', () => {
        const table = timetableSelection.closest('table');
        const colIndex = timetableSelection.closest('th').ariaColIndex;
        const tableRows = table.querySelectorAll('tr');
        const columnData = [];

        tableRows.forEach((row, index) => {
            const rowItem = row.querySelector(`td[aria-colindex="${colIndex}"`) ?? row.querySelector(`th[aria-colindex="${colIndex}"`);
            rowItem.remove();
            columnData.push(rowItem);
        });

        if (table.querySelectorAll('tbody [aria-colindex]').length == 0) {
            table.remove();
        }

        if(timetableSelection.value == 'new') {
            const clonedTable = table.cloneNode(true);
            const clonedRows = clonedTable.querySelectorAll('tr'); 
            clonedTable.querySelectorAll('[aria-colindex]').forEach(cell => cell.remove()); 

            clonedRows.forEach((row, index) => {
                const rowEnd = row.querySelector('th:last-child') ?? row.querySelector('td:last-child');
                row.insertBefore(columnData[index], rowEnd);
            });

            tableContainers.append(clonedTable);
            
        } else {
            const selectedTable = document.querySelector(`table[data-tableNumber="${timetableSelection.value}"]`);

            selectedTable.querySelectorAll('tr').forEach((tr, trIndex) => {
                const columns = tr.querySelectorAll('[aria-colindex]');

                for(let columnIndex = 0; columnIndex < columns.length; columnIndex++) {

                    if(columnData[0].ariaColIndex > columns[columnIndex].ariaColIndex && columnIndex != columns.length-1) {
                        continue;
                    }
                    
                    if(columnData[0].ariaColIndex < columns[columnIndex].ariaColIndex) {
                        tr.insertBefore(columnData[trIndex] ?? columnData[1].cloneNode(true), columns[columnIndex]);
                        break;
                    }

                    if(columnIndex == columns.length-1) {
                        tr.insertBefore(columnData[trIndex] ?? columnData[1].cloneNode(true), columns[columnIndex].nextSibling);
                        break;
                    }
    
                }
            });

        }

        checkTimetables();
    })
})


function checkTimetables() {
    const timetables = document.querySelectorAll('[data-tableNumber]');
    timetables.forEach((timetable, index) => {
        timetable.dataset.tablenumber = index+1;
    });

    timetableSelections.forEach(select => {
        select.innerText='';
        for(let i = 0; i < timetables.length; i++) {
            const option = Object.assign(document.createElement('option'), {
                value: i+1,
                innerText: `Timetable ${i+1}`,
                
            });
            option.selected = select.closest('table').dataset.tablenumber == i+1 ? true : false;
            select.append(option);
        }
        
        if(timetables.length <= 4) {
            const option = Object.assign(document.createElement('option'), {
                value: 'new',
                innerText: `New Timetable`
            });
            select.append(option);
        }

    });
}

submitBtn.addEventListener('click', handleSubmit);

const DAYS = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

function handleSubmit() {
    const schedule = [];
    const tableRows = table.querySelectorAll('tbody tr');

    tableRows.forEach((row, rowindex) => {
        row.querySelectorAll('td').forEach((col, colindex) => {
            if(colindex != 0) {
                const rowData = {
                    time_start: row.children[0].querySelector('input[name="time_start[]"]').value,
                    time_end : row.children[0].querySelector('input[name="time_end[]"]').value,
                    day_id : colindex,
                    period_slot : rowindex+1,
                }
                schedule.push(rowData);
            }
        })
    
    })
    
    console.log(schedule);

}
