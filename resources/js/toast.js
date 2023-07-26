const toast = document.querySelector('#toast');
const closeToastButton = document.querySelector('#close-toast-btn');

if (closeToastButton) {
    closeToastButton.addEventListener('click', () => {
        const closeParent = closeToastButton.parentNode;
        closeParent.parentNode.classList.toggle('hidden');
    });
}

// removes the toast element from the DOM
if (toast) {
    toast.addEventListener('animationend', () => {
        toast.remove();
    });
}