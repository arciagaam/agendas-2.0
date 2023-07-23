
const subToggles = document.querySelectorAll('.toggle-button');
const mainToggles = document.querySelectorAll('.main-toggle');

subToggles.forEach((subToggle) => {
    subToggle.addEventListener('change', function() {
        const toggleLabel = this.nextElementSibling;
        const subToggleContainer = this.closest('.submodule');
        const mainToggle = subToggleContainer.parentNode.querySelector('.main-toggle');
        const allSubTogglesChecked = Array.from(subToggles).every((subToggle) => subToggle.checked);

        // updateMainToggleState(mainToggle, subToggleContainer);

        toggleLabel.classList.toggle('bg-gray-300');
        toggleLabel.classList.toggle('bg-green-500');
        subToggle.classList.toggle('ml-0.5');
        subToggle.classList.toggle('ml-[18px]');
        subToggle.toggleAttribute('checked');

        if (!allSubTogglesChecked) {
            mainToggle.nextElementSibling.classList.toggle('bg-gray-300');
            mainToggle.nextElementSibling.classList.toggle('bg-green-500');
            mainToggle.classList.toggle('ml-0.5');
            mainToggle.classList.toggle('ml-[18px]');
            mainToggle.toggleAttribute('checked');
        } else {

        }

    });
});

mainToggles.forEach((mainToggle) => {
    mainToggle.addEventListener('change', function() {
        const subTogglesContainer = this.closest('.perm-items').nextElementSibling;

        if (subTogglesContainer) {
            mainToggle.nextElementSibling.classList.toggle('bg-gray-300');
            mainToggle.nextElementSibling.classList.toggle('bg-green-500');
            mainToggle.classList.toggle('ml-0.5');
            mainToggle.classList.toggle('ml-[18px]');
            mainToggle.toggleAttribute('checked');

            const subToggles = subTogglesContainer.querySelectorAll('.toggle-button');
            const allSubTogglesChecked = Array.from(subToggles).every((subToggle) => subToggle.checked);
            console.log(mainToggle.checked);
            if (!mainToggle.checked) {
                subToggles.forEach((subToggle) => {
                    if (subToggle.checked) { 
                        const subToggleLabel = subToggle.nextElementSibling;
                        subToggleLabel.classList.toggle('bg-gray-300');
                        subToggleLabel.classList.toggle('bg-green-500');
                        subToggle.classList.toggle('ml-0.5');
                        subToggle.classList.toggle('ml-[18px]');
                        subToggle.toggleAttribute('checked');
                    }
                });
            } else {
                subToggles.forEach((subToggle) => {
                    if (!subToggle.checked) {
                        const subToggleLabel = subToggle.nextElementSibling;
                        subToggleLabel.classList.toggle('bg-gray-300');
                        subToggleLabel.classList.toggle('bg-green-500');
                        subToggle.classList.toggle('ml-0.5');
                        subToggle.classList.toggle('ml-[18px]');
                        subToggle.toggleAttribute('checked');
                    }
                });
            }
            
        } else {
            mainToggle.nextElementSibling.classList.toggle('bg-gray-300');
            mainToggle.nextElementSibling.classList.toggle('bg-green-500');
            mainToggle.classList.toggle('ml-0.5');
            mainToggle.classList.toggle('ml-[18px]');
            mainToggle.toggleAttribute('checked');
        }
    });
});

function updateMainToggleState(mainToggle, subtogglesContainer) {
    const subToggles = subtogglesContainer.querySelectorAll('.toggle-button');
    const allSubTogglesChecked = Array.from(subToggles).every((subToggle) => subToggle.checked);

    // if (!allSubTogglesChecked && mainToggle.checked) {
    //     mainToggle.nextElementSibling.classList.add('bg-gray-300');
    //     mainToggle.nextElementSibling.classList.remove('bg-green-500');
    //     mainToggle.classList.add('ml-0.5');
    //     mainToggle.classList.remove('ml-[18px]');
    //     mainToggle.removeAttribute('checked');
    // } else if (allSubTogglesChecked && !mainToggle.checked) {
    //     mainToggle.nextElementSibling.classList.remove('bg-gray-300');
    //     mainToggle.nextElementSibling.classList.add('bg-green-500');
    //     mainToggle.classList.remove('ml-0.5');
    //     mainToggle.classList.add('ml-[18px]');
    //     mainToggle.setAttribute('checked','');
    // }
}