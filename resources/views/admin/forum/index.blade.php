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
                            <li class="breadcrumb-item"><a href="#">Data Forum</a></li>
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
                                                            <input type="text" class="form-control" name="judul"
                                                                placeholder="Forum">
                                                            <span class="error invalid-feedback judul_error"></span>
                                                        </div>

                                                        <div class="mb-3">
                                                            <textarea name="isi_forum" class="form-control" id="" cols="30" rows="10" placeholder="Isi forum"></textarea>
                                                            <span class="error invalid-feedback isi_forum_error"></span>
                                                        </div>

                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Close</button>
                                                            <button type="button"
                                                                data-url="{{ route('admin.add-data-forum') }}"
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
                                            <th>Judul Forum</th>
                                            <th>Isi Forum</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item->judul }}</td>
                                                <td>{{ $item->isi_forum }}</td>
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
                                                                        Edit Data Forum
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
                                                                                name="judul" placeholder="Judul forum"
                                                                                value="{{ $item->judul }}">
                                                                            <span
                                                                                class="error invalid-feedback judul_error"></span>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <textarea name="isi_forum" value="{{ $item->isi_forum }}" class="form-control" id="" cols="30"
                                                                                rows="10" placeholder="Isi forum">{{ $item->isi_forum }}</textarea>
                                                                            <span
                                                                                class="error invalid-feedback isi_forum_error"></span>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button"
                                                                                class="btn btn-secondary"
                                                                                data-dismiss="modal">Close</button>
                                                                            <button type="button"
                                                                                data-url="{{ route('admin.edit-data-forum', ['params' => $item->uuid]) }}"
                                                                                class="btn btn-primary submit-form">Save</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Tombol hapus -->
                                                    <button class="btn btn-danger btn-sm button-delete"
                                                        data-url="{{ route('admin.deleted-data-forum', ['params' => $item->uuid]) }}">
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
    </script>
@endsection
