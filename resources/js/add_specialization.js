const searchInput = document.querySelector('#search_specialization');
const specializationsContainer = document.querySelector('#specializations_container');
const selectedSpecializationsContainer = document.querySelector('#selected_specializations');
const BASE_PATH = document.querySelector('meta[name="base-path"]').getAttribute('content');
let timeout;
let specializationArray = [];

function createSearchContent(textContent) {
    return Object.assign(document.createElement('p'), {
        className: 'flex w-full text-sm text-gray-500',
        textContent: textContent
    });
}

searchInput.addEventListener('input', (e) => {
    const searchContentContainer = createSearchContent('Searching...');

    specializationsContainer.innerText = '';
    specializationsContainer.append(searchContentContainer);

    clearTimeout(timeout);

    timeout = setTimeout(() => {
        fetchSpecializations(e.target.value)
    }, 500);
});

searchInput.addEventListener('focus', () => {
    const searchContentContainer = createSearchContent('Searching...');

    specializationsContainer.innerText = '';
    specializationsContainer.append(searchContentContainer);
    specializationsContainer.ariaHidden = false;

    if (searchInput.value != '') return;
    fetchSpecializations(searchInput.value);
});

searchInput.addEventListener('blur', () => {
    specializationsContainer.ariaHidden = true;
    clearTimeout(timeout);
});

function fetchSpecializations(searchQuery) {
    specializationArray = [];

    const selectedSpecializations = selectedSpecializationsContainer.querySelectorAll('input[type="hidden"]');
    selectedSpecializations.forEach(specialization => {
        specializationArray.push(specialization.value);
    });

    const form = new FormData();
    form.append('specializations', JSON.stringify(specializationArray));

    fetch(BASE_PATH + `/api/specializations/?search=${searchQuery}`, {
        headers: {
            'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        },
        method: 'POST',
        body: form
    })
    .then(res => res.json())
    .then(data => {
        specializationsContainer.innerText = '';

        if (data.payload) {
            data.payload.forEach(specialization => {
                const searchItemContainer = Object.assign(document.createElement('div'), {
                    className: 'flex w-full'
                });

                const searchItem = Object.assign(document.createElement('p'), {
                    className: 'text-sm w-full cursor-pointer',
                    innerText: specialization.name,
                    onmousedown: () => {handleSelectSpecialization(specialization)}
                });

                searchItem.dataset.id = specialization.id;

                searchItemContainer.append(searchItem);
                specializationsContainer.append(searchItemContainer);
            });
        }

        if (data.message) {
            const searchContentContainer = createSearchContent('No results found');
            specializationsContainer.append(searchContentContainer);
        }
    });
}

function handleSelectSpecialization(specialization) {
    searchInput.value = "";
    const capsuleContainer = Object.assign(document.createElement('div'), {
        className: 'whitespace-nowrap'
    });

    const capsule = Object.assign(document.createElement('div'), {
        className: 'flex ring-1 ring-blue-400 px-3 text-xs rounded-full text-blue-400 w-full',
        innerText: specialization.name
    });

    const input = Object.assign(document.createElement('input'), {
        type: 'hidden',
        name: 'specializations[]',
        id: `specialization-${specializationArray.length-1}`,
        value: specialization.id
    });

    capsuleContainer.append(capsule);
    capsuleContainer.append(input);
    selectedSpecializationsContainer.insertBefore(capsuleContainer,searchInput);
}

function fetchTeacherSpecializations(id) {
    const form = new FormData();
    form.append('id', JSON.stringify(id));

    fetch(BASE_PATH + `/api/teacher_specializations/${id}`, {
        headers: {
            'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        },
        method: 'POST',
        body: form
    })
    .then(res => res.json())
    .then(data => {
        if (data.payload) {
            data.payload.forEach(specialization => {
                // console.log(specialization);
                handleSelectSpecialization(specialization);
            });
        }
    });
}

if (teacher_id) {
    fetchTeacherSpecializations(teacher_id);
}