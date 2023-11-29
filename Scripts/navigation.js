document.querySelectorAll('.menu-item').forEach(item => {
    item.addEventListener('click', function() {
        this.querySelector('.submenu').style.display = 'block';
    });
});
