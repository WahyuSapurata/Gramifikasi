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
                            <form action="{{ route('admin.data-akademik') }}" method="GET">
                                <div class="card-body">
                                    <div class="mb-2">
                                        <label for="tahun_ajaran" class="form-label">Tahun Ajaran Akademik</label>
                                        <input type="text" class="form-control" readonly
                                            value="{{ $tahun_ajaran->tahun . ' ' . $tahun_ajaran->semester }}">
                                        <input type="hidden" id="uuid_tahun" name="uuid_tahun"
                                            value="{{ $tahun_ajaran->uuid }}">
                                    </div>
                                    <div class="mb-2">
                                        <label for="uuid_mapel" class="form-label">Mata Pelajaran</label>
                                        <select name="uuid_mapel" id="uuid_mapel" class="form-control">
                                            <option value="">-- pilih --</option>
                                            @foreach ($mapel as $m)
                                                <option value="{{ $m->uuid }}"
                                                    {{ request('uuid_mapel') == $m->uuid ? 'selected' : '' }}>
                                                    {{ $m->mapel }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-2">
                                        <label for="uuid_guru" class="form-label">Guru</label>
                                        <select name="uuid_guru" id="uuid_guru" class="form-control">
                                            <option value="">-- pilih --</option>
                                            @foreach ($guru as $g)
                                                <option value="{{ $g->uuid }}"
                                                    {{ request('uuid_guru') == $g->uuid ? 'selected' : '' }}>
                                                    {{ $g->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-2">
                                        <label for="kelas" class="form-label">Kelas</label>
                                        <input type="text" name="kelas" id="kelas" class="form-control"
                                            value="{{ request('kelas') }}">
                                    </div>
                                    <div class="mb-2">
                                        <button class="btn btn-success">Cari Data</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <div>
                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                        data-target="#exampleModal"
                                        @if (request()->hasAny(['uuid_mapel', 'uuid_guru', 'kelas'])) @if (!empty(request('uuid_mapel')) || !empty(request('uuid_guru')) || !empty(request('kelas')))
                                            enabled
                                        @else
                                            disabled @endif
                                    @else disabled @endif>
                                        <i class="fas fa-plus-square"></i>
                                        <span class="ml-1">Tambah Data</span>
                                    </button>

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
                                                            <select name="uuid_siswa" id="uuid_siswa" class="form-control">
                                                                <option value="">-- pilih --</option>
                                                                @foreach ($siswa as $s)
                                                                    <option value="{{ $s->uuid }}">
                                                                        {{ $s->nama }}</option>
                                                                @endforeach
                                                            </select>
                                                            <span class="error invalid-feedback uuid_siswa_error"></span>
                                                        </div>

                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Close</button>
                                                            <button type="button"
                                                                data-url="{{ route('admin.add-data-akademik') }}"
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
                                            <th>Nama Siswa</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item->siswa }}</td>
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
                                                                        Edit Data Mata Pelajaran
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
                                                                            <select name="uuid_siswa" id="uuid_siswa"
                                                                                class="form-control">
                                                                                <option value="">-- pilih --</option>
                                                                                @foreach ($siswa as $s)
                                                                                    <option value="{{ $s->uuid }}"
                                                                                        {{ $item->uuid_siswa == $s->uuid ? 'selected' : '' }}>
                                                                                        {{ $s->nama }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                            <span
                                                                                class="error invalid-feedback uuid_siswa_error"></span>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button"
                                                                                class="btn btn-secondary"
                                                                                data-dismiss="modal">Close</button>
                                                                            <button type="button"
                                                                                data-url="{{ route('admin.edit-data-akademik', ['params' => $item->uuid]) }}"
                                                                                class="btn btn-primary submit-form">Save</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Tombol hapus -->
                                                    <button class="btn btn-danger btn-sm button-delete"
                                                        data-url="{{ route('admin.deleted-data-akademik', ['params' => $item->uuid]) }}">
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
                "buttons": false
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

                formData.append('tahun_ajaran', $('#tahun_ajaran').val())
                formData.append('uuid_mapel', $('#uuid_mapel').val())
                formData.append('uuid_guru', $('#uuid_guru').val())
                formData.append('semester', $('#semester').val())
                formData.append('kelas', $('#kelas').val())
                formData.append('uuid_tahun', $('#uuid_tahun').val())

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
