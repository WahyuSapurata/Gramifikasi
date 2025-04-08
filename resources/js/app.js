import './bootstrap';

import Swal from 'sweetalert2';
import bsCustomFileInput from 'bs-custom-file-input'

// Tambahkan Swal ke global scope agar dapat diakses di file Blade.
window.Swal = Swal;
window.bsCustomFileInput = bsCustomFileInput;
