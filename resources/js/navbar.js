const navbar = document.querySelector('#side_nav');
const chevron = document.querySelector("#nav-chevron");

const accordions = document.querySelectorAll('.nav_accordion');

let isOpen = false;

chevron.addEventListener('click', () => {
    navbar.classList.toggle('max-w-full');
    chevron.classList.toggle('rotate-180');
    isOpen = !isOpen;

    if(accordions) {
        accordions.forEach(accordion => {
            const content = accordion.querySelector('.accordion_content');
            
            if(isOpen) {
                content.classList.add('pl-5')
            } else {
                content.classList.remove('pl-5')
            };
 
        })
    }
})

if(accordions) {
    accordions.forEach(accordion => {
        accordion.addEventListener('click', () => {
            const content = accordion.querySelector('.accordion_content');

            if(isOpen) {
                content.classList.add('pl-5')
            } else {
                content.classList.remove('pl-5')
            };
            
            content.classList.toggle('max-h-[50rem]');
            content.classList.toggle('mt-3');
        })
    })
}
