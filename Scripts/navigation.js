// document.querySelectorAll('.menu-item').forEach(item => {
//     item.addEventListener('click', function() {
//         this.querySelector('.submenu').style.display = 'block';
//     });
// });
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.menu-item').forEach(item => {
        item.addEventListener('click', function(event) {
            let submenu = this.querySelector('.submenu');
            // Schaltet die Anzeige des Submenüs um
            submenu.style.display = submenu.style.display === 'block' ? 'none' : 'block';
            event.stopPropagation();
        });
    });

    // Klick außerhalb des Menüs schließt das Submenü
    document.addEventListener('click', function() {
        document.querySelectorAll('.submenu').forEach(submenu => {
            submenu.style.display = 'none';
        });
    });

    // Hier fügen Sie den neuen Teil für die Upload-Nachricht hinzu
    const uploadForm = document.getElementById('picture_Upload_Form');
    if (uploadForm) {
        uploadForm.addEventListener('submit', function() {
            const uploadMessage = document.getElementById('uploadMessage');
            if (uploadMessage) {
                uploadMessage.style.display = 'block';
            }
        });
    }
});


