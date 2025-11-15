document.addEventListener('DOMContentLoaded', function () {
    const deleteButtons = document.querySelectorAll('.openDeleteModal');
    const deleteForm = document.getElementById('deleteClientForm');

    deleteButtons.forEach(button => {
        button.addEventListener('click', function () {
            const url = this.getAttribute('data-url');
            deleteForm.setAttribute('action', url);
        });
    });
});


let parentMenu = document.querySelectorAll('.parent-menu > a');

parentMenu.forEach(e => {
    e.addEventListener('click', function () {
        e.querySelector(':scope > i').classList.toggle('active');
        e.nextElementSibling.classList.toggle('active')
    })
})