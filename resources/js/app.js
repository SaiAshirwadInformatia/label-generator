import './bootstrap';


import Swal from 'sweetalert2';

window.Swal = Swal;
window.addEventListener('DOMContentLoaded', () => {
    setTimeout(() => {
        window.Livewire.on('showSuccess', message => Swal.fire({
            title: 'Success!',
            text: message,
            icon: 'success',
            confirmButtonText: 'Ok',
            timer: 2000
        }));

        window.Livewire.on('showError', message => Swal.fire({
            title: 'Error!',
            text: message,
            icon: 'error',
            confirmButtonText: 'Ok',
            timer: 3000
        }));

        window.instance = null;
        var openLink = function (link) {
            if (window.instance == null || window.instance.location !== undefined) {
                window.instance = window.open(link);
            } else {
                window.instance.location = link;
            }
        };
        window.Livewire.on('openLink', openLink);
    }, 500)
});
