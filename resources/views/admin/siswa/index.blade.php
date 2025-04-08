@extends('layouts.layout')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>{{ $module }}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Data Master</a></li>
                            <li class="breadcrumb-item active">{{ $module }}</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <div>
                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                        data-target="#exampleModal"><i class="fas fa-plus-square"></i>
                                        <span class="ml-1">Tambah Data</span></button>

                                    <!-- Modal -->
                                    <div class="modal fade" id="exampleModal" tabindex="-1"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Tambah Data</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">

                                                    <form class="form-submit">
                                                        @csrf

                                                        <div class="mb-3">
                                                            <input type="text" class="form-control" name="nama"
                                                                placeholder="Nama">
                                                            <span class="error invalid-feedback nama_error"></span>
                                                        </div>

                                                        <div class="mb-3">
                                                            <input type="text" class="form-control" name="username"
                                                                placeholder="Username">
                                                            <span class="error invalid-feedback username_error"></span>
                                                        </div>

                                                        <div class="input-group mb-3">
                                                            <input type="password" class="form-control" id="password"
                                                                name="password" placeholder="Password"
                                                                autocomplete="current-password">
                                                            <span class="error invalid-feedback password_error"></span>
                                                            <div class="input-group-append">
                                                                <div class="input-group-text" role="button" tabindex="0"
                                                                    onclick="togglePassword()"
                                                                    aria-label="Toggle Password Visibility">
                                                                    <i class="fas fa-eye" id="toggle-icon"></i>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Close</button>
                                                            <button type="button"
                                                                data-url="{{ route('admin.add-data-siswa') }}"
                                                                class="btn btn-primary submit-form">Save</button>
                                                        </div>
                                                    </form>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Lengkap</th>
                                            <th>NIS/NISN</th>
                                            <th>Jenis Kelamin</th>
                                            <th>Tempat Lahir</th>
                                            <th>Tanggal Lahir</th>
                                            <th>Alamat Lengkap</th>
                                            <th>Nomor Telephon</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($dataSiswa as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item->nama }}</td>
                                                <td>{{ $item->nis_nisn ? $item->nis_nisn : '-' }}</td>
                                                <td>{{ $item->jenis_kelamin ? $item->jenis_kelamin : '-' }}</td>
                                                <td>{{ $item->tempat_lahir ? $item->tempat_lahir : '-' }}</td>
                                                <td>{{ $item->tanggal_lahir ? $item->tanggal_lahir : '-' }}</td>
                                                <td>{{ $item->alamat ? $item->alamat : '-' }}</td>
                                                <td>{{ $item->nomor ? $item->nomor : '-' }}</td>
                                                <td>
                                                    <!-- Tombol untuk membuka modal -->
                                                    <button class="btn btn-info btn-sm" data-toggle="modal"
                                                        data-target="#exampleModal{{ $item->uuid }}">
                                                        <i class="fas fa-edit"></i>
                                                    </button>

                                                    <!-- Modal -->
                                                    <div class="modal fade" id="exampleModal{{ $item->uuid }}"
                                                        tabindex="-1"
                                                        aria-labelledby="exampleModalLabel{{ $item->uuid }}"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title"
                                                                        id="exampleModalLabel{{ $item->uuid }}">
                                                                        Edit Data Siswa
                                                                    </h5>
                                                                    <button type="button" class="close"
                                                                        data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form class="form-submit">
                                                                        @csrf
                                                                        <div class="mb-3">
                                                                            <input type="text" class="form-control"
                                                                                name="nis_nisn"
                                                                                placeholder="Masukkan NIS/NISN"
                                                                                value="{{ $item->nis_nisn }}">
                                                                            <span
                                                                                class="error invalid-feedback nis_nisn_error"></span>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label>Jenis Kelamin</label>
                                                                            <div class="form-group clearfix">
                                                                                <div class="icheck-primary d-inline">
                                                                                    <input type="radio"
                                                                                        id="radioPrimary1{{ $item->uuid }}"
                                                                                        name="jenis_kelamin"
                                                                                        value="laki - laki"
                                                                                        {{ $item->jenis_kelamin == 'laki - laki' ? 'checked' : '' }}>
                                                                                    <label
                                                                                        for="radioPrimary1{{ $item->uuid }}"
                                                                                        class="font-weight-normal">Laki
                                                                                        - Laki</label>
                                                                                </div>
                                                                                <div class="icheck-primary d-inline ml-2">
                                                                                    <input type="radio"
                                                                                        id="radioPrimary2{{ $item->uuid }}"
                                                                                        name="jenis_kelamin"
                                                                                        value="perempuan"
                                                                                        {{ $item->jenis_kelamin == 'perempuan' ? 'checked' : '' }}>
                                                                                    <label
                                                                                        for="radioPrimary2{{ $item->uuid }}"
                                                                                        class="font-weight-normal">Perempuan</label>
                                                                                </div>
                                                                            </div>
                                                                            <span
                                                                                class="error invalid-feedback jenis_kelamin_error"></span>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <input type="text" class="form-control"
                                                                                name="tempat_lahir"
                                                                                placeholder="Masukkan Tempat Lahir"
                                                                                value="{{ $item->tempat_lahir }}">
                                                                            <span
                                                                                class="error invalid-feedback tempat_lahir_error"></span>
                                                                        </div>
                                                                        <div class="form-group mb-3">
                                                                            <label for="tanggal_lahir">Tanggal
                                                                                Lahir</label>
                                                                            <div class="input-group date datetimepicker"
                                                                                id="reservationdate{{ $item->id }}"
                                                                                data-target-input="nearest">
                                                                                <input type="text"
                                                                                    class="form-control datetimepicker-input"
                                                                                    name="tanggal_lahir"
                                                                                    value="{{ $item->tanggal_lahir }}"
                                                                                    data-target="#reservationdate{{ $item->id }}"
                                                                                    placeholder="dd-mm-yyyy" />
                                                                                <div class="input-group-append"
                                                                                    data-target="#reservationdate{{ $item->id }}"
                                                                                    data-toggle="datetimepicker">
                                                                                    <span class="input-group-text"><i
                                                                                            class="fa fa-calendar"></i></span>
                                                                                </div>
                                                                                <span
                                                                                    class="error invalid-feedback tanggal_lahir_error"></span>
                                                                            </div>
                                                                        </div>

                                                                        <div class="mb-3">
                                                                            <input type="text" class="form-control"
                                                                                name="alamat"
                                                                                placeholder="Masukkan Alamat"
                                                                                value="{{ $item->alamat }}">
                                                                            <span
                                                                                class="error invalid-feedback alamat_error"></span>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <input type="text" class="form-control"
                                                                                name="nomor"
                                                                                placeholder="Masukkan Nomor Hanphone"
                                                                                value="{{ $item->nomor }}">
                                                                            <span
                                                                                class="error invalid-feedback nomor_error"></span>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button"
                                                                                class="btn btn-secondary"
                                                                                data-dismiss="modal">Close</button>
                                                                            <button type="button"
                                                                                data-url="{{ route('admin.edit-data-siswa', ['params' => $item->uuid]) }}"
                                                                                class="btn btn-primary submit-form">Save</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Tombol hapus -->
                                                    <button class="btn btn-danger btn-sm button-delete"
                                                        data-url="{{ route('admin.deleted-data-siswa', ['params' => $item->uuid]) }}">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@section('script')
    <script>
        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });

        $(document).ready(function() {
            $(".submit-form").click(function(e) {
                e.preventDefault(); // Mencegah reload halaman

                $.ajaxSetup({
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    },
                });

                var url = $(this).data('url'); // Ambil URL dari tombol
                var form = $(this).closest('.form-submit'); // Cari form yang sesuai
                var formData = new FormData(form[0]); // Gunakan FormData untuk mengirim data

                $.ajax({
                    type: "POST",
                    url: url, // URL endpoint Laravel
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        // Hapus semua pesan error sebelumnya
                        $(".error.invalid-feedback").html("");
                        $(".is-invalid").removeClass("is-invalid");

                        if (response.success) {
                            Swal.fire({
                                text: response.message,
                                icon: "success",
                                showConfirmButton: false,
                                timer: 1500,
                            }).then(() => {
                                location.reload(); // Reload halaman setelah alert
                            });
                        } else {
                            Swal.fire({
                                title: response.message,
                                text: response.data,
                                icon: "warning",
                                showConfirmButton: false,
                                timer: 1500,
                            });
                        }
                    },
                    error: function(xhr) {
                        // Hapus semua pesan error sebelumnya
                        $(".error.invalid-feedback").html("");
                        $(".is-invalid").removeClass("is-invalid");

                        // Tampilkan pesan error sesuai dengan validasi backend
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            $.each(xhr.responseJSON.errors, function(key, value) {
                                let inputField = form.find(`[name="${key}"]`);
                                let errorElement = inputField.next('.invalid-feedback');

                                // Tambahkan pesan error
                                errorElement.html(value);
                                inputField.addClass('is-invalid');
                            });
                        }
                    }
                });
            });
        });

        $(document).on('click', '.button-delete', function(e) {
            e.preventDefault();
            let token = $("meta[name='csrf-token']").attr("content");
            var url = $(this).data('url');
            Swal.fire({
                title: `Apakah anda yakin akan menghapus data tersebut ?`,
                text: "Anda tidak akan dapat mengembalikan ini!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya, hapus itu!",
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        type: "DELETE",
                        data: {
                            _token: token,
                        },
                        success: function() {
                            Swal.fire({
                                title: "Menghapus!",
                                text: "Data Anda telah dihapus.",
                                icon: "success",
                                showConfirmButton: false,
                                timer: 1500
                            }).then(() => {
                                location.reload(); // Reload halaman setelah alert
                            });
                        },
                    });
                }
            });
        })

        // Fungsi untuk toggle visibility password
        function togglePassword() {
            const passwordField = $("#password");
            const toggleIcon = $("#toggle-icon");

            if (passwordField.attr("type") === "password") {
                passwordField.attr("type", "text");
                toggleIcon.removeClass("fa-eye").addClass("fa-eye-slash");
            } else {
                passwordField.attr("type", "password");
                toggleIcon.removeClass("fa-eye-slash").addClass("fa-eye");
            }
        }

        //Date picker
        $('.datetimepicker').datetimepicker({
            format: 'DD MM YYYY',
            locale: 'id',
            icons: {
                time: 'far fa-clock',
                date: 'fa fa-calendar',
                up: 'fa fa-arrow-up',
                down: 'fa fa-arrow-down',
                previous: 'fa fa-chevron-left',
                next: 'fa fa-chevron-right',
                today: 'fa fa-calendar-check',
                clear: 'fa fa-trash-alt',
                close: 'fa fa-times'
            }
        });

        //Date and time picker
        $('#reservationdatetime').datetimepicker({
            icons: {
                time: 'far fa-clock'
            }
        });
    </script>
@endsection
