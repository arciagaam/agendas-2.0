const BASE_PATH = document.querySelector('meta[name="base-path"]').getAttribute('content');
const inputList = document.querySelectorAll('.search-teacher');
const buttonList = document.querySelectorAll('.edit-assignment-btn');
const teacherContainerList = document.querySelectorAll('.teachers-container');
const selectedTeachersContainerList = document.querySelectorAll('.selected-teachers');
let timeout;
let teachersArray = [];

console.log(buttonList);
buttonList.forEach(function (button, index) {
  button.addEventListener('click', function () {
    var input = inputList[index];
    var noTeacher = selectedTeachersContainerList[index].querySelector(".no-teacher");
    var selectedTeacher = selectedTeachersContainerList[index].querySelector(".selected-teacher");
    input.disabled = !input.disabled;

    if (input.classList.contains('hidden')) {
      input.classList.remove('hidden');
    } else if (selectedTeachersContainerList[index].childElementCount >= 2 && selectedTeacher) {
      console.log('meron');
      input.classList.add("hidden");
    }

    if (selectedTeachersContainerList[index].childElementCount <= 2 && !selectedTeacher) {
      console.log(!input.classList.contains('hidden'));
      console.log(!noTeacher);
      if (!noTeacher) {
        console.log('add no teacher div')
        input.classList.add('hidden');
        const listItemContainer = Object.assign(document.createElement('div'), {
          className: 'no-teacher whitespace-nowrap'
        });
  
        const listItem = Object.assign(document.createElement('div'), {
          className: 'flex px-3 text-sm w-full gap-3',
          innerText: 'No teacher/s assigned.'
        });
  
        listItemContainer.append(listItem);
        selectedTeachersContainerList[index].append(listItemContainer);
      } else {  
        console.log('remove no teacher div');      
        input.classList.remove('hidden');
        noTeacher.remove();
      }
    }

    const selectedTeachers = selectedTeachersContainerList[index].querySelectorAll('.delete-button');
    selectedTeachers.forEach(teacher => {
      if (teacher.classList.contains('hidden') && !input.classList.contains('hidden')) {
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

  var observer = new MutationObserver((mutationList) => {
  var noTeacher = selectedTeachersContainerList[index].querySelector(".no-teacher");
  var selectedTeachers = selectedTeachersContainerList[index].querySelector(".selected-teacher");
    if (selectedTeachersContainerList[index].childElementCount > 1 && selectedTeachers) {
      input.classList.add("hidden");

      if (noTeacher) {
        noTeacher.remove();
      }
    }

    observer.disconnect();

  });

  observer.observe(selectedTeachersContainerList[index], { childList: true });

  
  if (selectedTeachersContainerList[index].childElementCount <= 2) {
    input.classList.add('hidden');
        const listItemContainer = Object.assign(document.createElement('div'), {
          className: 'no-teacher whitespace-nowrap'
        });
  
        const listItem = Object.assign(document.createElement('div'), {
          className: 'flex px-3 text-sm w-full gap-3',
          innerText: 'No teacher/s assigned.'
        });
  
        listItemContainer.append(listItem);
        selectedTeachersContainerList[index].append(listItemContainer);
  }

});

function fetchTeachers(searchQuery, id, index) {
  teachersArray = [];

  const selectedTeachers = selectedTeachersContainerList[index].querySelectorAll('input[type="hidden"]');
  selectedTeachers.forEach(teacher => {
    teachersArray.push(teacher.value);
  });

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
    className: 'selected-teacher whitespace-nowrap'
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
    className: 'selected-teacher whitespace-nowrap'
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


