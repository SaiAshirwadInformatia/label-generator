require('./bootstrap');

import Alpine from 'alpinejs';
import Swal from 'sweetalert2';

window.Alpine = Alpine;
window.Swal = Swal;

Alpine.start();
Livewire.on('showSuccess', message => Swal.fire({
    title: 'Success!',
    text: message,
    icon: 'success',
    confirmButtonText: 'Ok',
    timer: 2000
}));

Livewire.on('showError', message => Swal.fire({
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
Livewire.on('openLink', openLink);
