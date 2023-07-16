const BASE_PATH = document.querySelector('meta[name="base-path"]').getAttribute('content');
const inputList = document.querySelectorAll('.search-teacher');
const buttonList = document.querySelectorAll('.edit-assignment-btn');
const teacherContainerList = document.querySelectorAll('.teachers-container');
const selectedTeachersContainerList = document.querySelectorAll('.selected-teachers');
let timeout;
let teachersArray = [];


buttonList.forEach(function (button, index) {
  button.addEventListener('click', function () {
    var input = inputList[index];
    input.disabled = !input.disabled;
    const selectedTeachers = selectedTeachersContainerList[index].querySelectorAll('.delete-button');
    selectedTeachers.forEach(teacher => {
      if (teacher.classList.contains('hidden') && !input.disabled) {
        teacher.classList.remove('hidden');
      } else {
        teacher.classList.add('hidden');
      }
    });
  });
});

function createSearchContent(textContent) {
  return Object.assign(document.createElement('p'), {
    className: 'flex w-full text-sm text-gray-500',
    textContent: textContent
  });
}

inputList.forEach((input, index) => {
  const searchContentContainer = createSearchContent('Searching...');
  input.addEventListener('input', (e) => {

    teacherContainerList[index].innerText = '';
    teacherContainerList[index].append(searchContentContainer);

    clearTimeout(timeout);

    timeout = setTimeout(() => {
      fetchTeachers(e.target.value, input.id, index);
    }, 500);
  });

  input.addEventListener('focus', () => {
    teacherContainerList[index].innerText = '';
    teacherContainerList[index].append(searchContentContainer);
    teacherContainerList[index].ariaHidden = false;

    if (input.value != '') return;
    fetchTeachers(input.value, input.id, index);
  });

  input.addEventListener('blur', () => {
    teacherContainerList[index].ariaHidden = true;
    clearTimeout(timeout);
  });

  fetchSubjectTeachers(selectedTeachersContainerList[index].id, index);
});

function fetchTeachers(searchQuery, id, index) {
  teachersArray = [];

  const selectedTeachers = selectedTeachersContainerList[index].querySelectorAll('input[type="hidden"]');
  selectedTeachers.forEach(teacher => {
    teachersArray.push(teacher.value);
  });

  // console.log(selectedTeachersContainerList[index]);

  const form = new FormData();
  form.append('teachers', JSON.stringify(teachersArray));
  form.append('subject_id', id);

  console.log(form);
  fetch(BASE_PATH + `/api/teacher_assignment/?search=${searchQuery}`, {
    headers: {
      'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
    },
    method: 'POST',
    body: form
  })
    .then(res => res.json())
    .then(data => {
      teacherContainerList[index].innerText = '';

      if (data.payload) {
        data.payload.forEach(teacher => {
          const searchItemContainer = Object.assign(document.createElement('div'), {
            className: 'flex w-full'
          });

          const searchItem = Object.assign(document.createElement('p'), {
            className: 'text-sm w-full cursor-pointer',
            innerText: `${teacher.honorific} ${teacher.first_name} ${teacher.last_name}`,
            onmousedown: () => { handleSelectTeacher(teacher, index) }
          });

          searchItem.dataset.id = teacher.id;

          searchItemContainer.append(searchItem);
          teacherContainerList[index].append(searchItemContainer);

        });

      }

      if (data.message) {
        const searchContentContainer = createSearchContent('No results found');
        teacherContainerList[index].append(searchContentContainer);
      }
    });


}

function handleSelectTeacher(teacher, index) {
  inputList[index].value = "";
  const listItemContainer = Object.assign(document.createElement('div'), {
    className: 'whitespace-nowrap'
  });

  const listItem = Object.assign(document.createElement('div'), {
    className: 'flex px-3 text-sm w-full gap-3',
    innerText: `${teacher.honorific} ${teacher.first_name} ${teacher.last_name}`
  });

  const input = Object.assign(document.createElement('input'), {
    type: 'hidden',
    name: 'teachers[]',
    id: `teacher-${teachersArray.length - 1}`,
    value: teacher.teacher_id
  });

  const deleteButton = Object.assign(document.createElement('button'), {
    className: 'delete-button',
    innerText: 'x',
    onclick: () => { handleDeleteTeacher(listItemContainer, index); }
  });

  listItemContainer.append(listItem);
  listItem.append(deleteButton);
  listItemContainer.append(input);
  selectedTeachersContainerList[index].insertBefore(listItemContainer, inputList[index]);

  const form = new FormData();
  form.append('teacher_id', teacher.teacher_id);
  form.append('subject_id', selectedTeachersContainerList[index].id);

  fetch(BASE_PATH + '/api/create_subject_teacher', {
    headers: {
      'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
    },
    method: 'POST',
    body: form
  })
    .then(res => res.json())
    .then(data => {
      console.log(data.message);
    });
}

function handleDeleteTeacher(container, index) {
  const input = container.querySelector('input[type="hidden"]');
  const teacherId = input.value;
  const subjectId = selectedTeachersContainerList[index].id;


  const form = new FormData();
  form.append('teacher_id', teacherId);
  form.append('subject_id', subjectId);

  fetch(BASE_PATH + '/api/delete_subject_teacher', {
    headers: {
      'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
    },
    method: 'POST',
    body: form
  })
    .then(res => res.json())
    .then(data => {
      console.log(data.message);
    });
  container.remove();
}

function displayTeacher(teacher, index) {
  inputList[index].value = "";
  const listItemContainer = Object.assign(document.createElement('div'), {
    className: 'whitespace-nowrap'
  });

  const listItem = Object.assign(document.createElement('div'), {
    className: 'flex px-3 text-sm w-full gap-3',
    innerText: `${teacher.honorific} ${teacher.first_name} ${teacher.last_name}`
  });

  const input = Object.assign(document.createElement('input'), {
    type: 'hidden',
    name: 'teachers[]',
    id: `teacher-${teachersArray.length - 1}`,
    value: teacher.teacher_id
  });

  const deleteButton = Object.assign(document.createElement('button'), {
    className: 'delete-button hidden',
    innerText: 'x',
    onclick: () => { handleDeleteTeacher(listItemContainer, index); }
  });

  listItemContainer.append(listItem);
  listItem.append(deleteButton);
  listItemContainer.append(input);
  selectedTeachersContainerList[index].insertBefore(listItemContainer, inputList[index]);
} 

function fetchSubjectTeachers(id, index) {
  const form = new FormData();
  form.append('id', id);

  fetch(BASE_PATH + `/api/subject_teachers/${id}`, {
    headers: {
      'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
    },
    method: 'POST',
    body: form
  })
    .then(res => res.json())
    .then(data => {
      if (data.payload) {
        data.payload.forEach(teacher => {
          displayTeacher(teacher, index);
        });
      }
    });
}


