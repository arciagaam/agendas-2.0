const toggleLabel = document.querySelector('.toggle-label');
const switchButtons = document.querySelectorAll('.toggle-button');
const mainToggles = document.querySelectorAll('.main-toggle');


switchButtons.forEach((switchButton) => {
    switchButton.addEventListener('change', function() {
        const toggleLabel = this.nextElementSibling;

        if (this.checked) {
            toggleLabel.classList.remove('bg-gray-300');
            toggleLabel.classList.add('bg-green-500');
            switchButton.classList.toggle('ml-0.5');
            switchButton.classList.toggle('ml-[18px]');
            switchButton.setAttribute('checked', '');
        } else {
            toggleLabel.classList.remove('bg-green-500');
            toggleLabel.classList.add('bg-gray-300');
            switchButton.classList.toggle('ml-0.5');
            switchButton.classList.toggle('ml-[18px]');
            switchButton.removeAttribute('checked');
        }
    });
});

mainToggles.forEach((mainToggle) => {
    mainToggle.addEventListener('change', function() {
        const toggleComponent = mainToggle.parentNode;
        const toggleContainer = toggleComponent.parentNode;
    
        if (toggleContainer.nextElementSibling) {
            const subToggleContainer = toggleContainer.nextElementSibling;
            const subToggles = subToggleContainer.querySelectorAll('.toggle-button');
            
            subToggles.forEach((subToggle) => {
                const subToggleLabels = this.nextElementSibling;
                
                if (this.checked) {
                    console.log(subToggleLabels);
                    toggleLabel.classList.add('bg-gray-300');
                    toggleLabel.classList.remove('bg-green-500');
                    subToggle.classList.toggle('ml-0.5');
                    subToggle.classList.toggle('ml-[18px]');
                    subToggle.removeAttribute('checked');
                }
            });
        }
    });
});