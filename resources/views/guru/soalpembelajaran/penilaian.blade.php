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
                            <li class="breadcrumb-item"><a href="#">Data Pembelaran</a></li>
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
                            <form action="{{ route('guru.penilaian-pembelajaran') }}" method="GET">
                                <div class="card-body">
                                    <div class="mb-2">
                                        <label for="tahun_ajaran" class="form-label">Tahun Ajaran Akademik</label>
                                        <input type="text" class="form-control" readonly
                                            value="{{ $tahun_ajaran->tahun . ' ' . $tahun_ajaran->semester }}">
                                        <input type="hidden" id="uuid_akademik" name="uuid_akademik"
                                            value="{{ $akademik->uuid }}">
                                    </div>
                                    <div class="mb-2">
                                        <label for="" class="form-label">Kelas</label>
                                        <input type="text" class="form-control" readonly value="{{ $akademik->kelas }}">
                                    </div>
                                    <div class="mb-2">
                                        <label for="uuid_kategori" class="form-label">Misi</label>
                                        <select name="uuid_kategori" id="uuid_kategori" class="form-control">
                                            <option value="">-- pilih --</option>
                                            @foreach ($kategori as $k)
                                                <option value="{{ $k->uuid }}"
                                                    {{ request('uuid_kategori') == $k->uuid ? 'selected' : '' }}>
                                                    {{ $k->kategori }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-2">
                                        <button class="btn btn-success">Cari Data</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="card">
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Siswa</th>
                                            <th>Skor</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($data_akademik as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item->siswa }}</td>
                                                <td class="text-right">{{ $item->skor }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3">Belum ada data</td>
                                            </tr>
                                        @endforelse
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
    </script>
@endsection
