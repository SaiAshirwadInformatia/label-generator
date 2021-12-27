require('./bootstrap');

import Alpine from 'alpinejs';
import Swal from 'sweetalert2';

window.Alpine = Alpine;

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
}))

Livewire.on('openLink', link => window.open(link));
