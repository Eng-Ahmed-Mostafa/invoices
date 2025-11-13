let parentMenu = document.querySelectorAll('.parent-menu > a');

parentMenu.forEach(e => {
    e.addEventListener('click',function() {
        e.querySelector(':scope > i').classList.toggle('active');
        e.nextElementSibling.classList.toggle('active')
    })
})