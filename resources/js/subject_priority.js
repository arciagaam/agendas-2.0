const is_priority = document.querySelector('#is_priority');
const priority_time = document.querySelector('#priority_time_div');
const priority_day = document.querySelector('#priority_day_div');

is_priority.addEventListener('change', () => {
    if (is_priority.value == '1') {
        priority_day.classList.remove('hidden');
        priority_time.classList.remove('hidden');
    } else {
        priority_day.classList.add('hidden');
        priority_time.classList.add('hidden');
    }
});
