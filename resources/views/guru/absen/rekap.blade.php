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
                            <li class="breadcrumb-item"><a href="#">Data Absen</a></li>
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
                            <div class="card-body">
                                <div class="mb-2">
                                    <label for="tahun_ajaran" class="form-label">Tahun Ajaran Akademik</label>
                                    <input type="text" class="form-control" readonly
                                        value="{{ $tahun_ajaran->tahun . ' ' . $tahun_ajaran->semester }}">
                                </div>
                                {{-- <div class="mb-2">
                                    <label for="" class="form-label">Kelas</label>
                                    <input type="text" class="form-control" readonly value="{{ $akademik->kelas }}">
                                </div> --}}
                                {{-- <div class="mb-2">
                                        <label for="uuid_misi" class="form-label">Filter </label>
                                        <select name="uuid_misi" id="uuid_misi" class="form-control">
                                            <option value="">-- pilih --</option>
                                            @foreach ($misi as $m)
                                                <option value="{{ $m->uuid }}"
                                                    {{ request('uuid_misi') == $m->uuid ? 'selected' : '' }}>
                                                    {{ $m->misi }}</option>
                                            @endforeach
                                        </select>
                                    </div> --}}
                                {{-- <div class="mb-2">
                                        <button class="btn btn-success">Cari Data</button>
                                    </div> --}}
                            </div>
                        </div>
                        <div class="card">
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th rowspan="2">No</th>
                                            <th rowspan="2">Nama Siswa</th>
                                            <th colspan="4" class="text-center">Kehadiran</th>
                                        </tr>
                                        <tr>
                                            <th>Hadir</th>
                                            <th>Izin</th>
                                            <th>Sakit</th>
                                            <th>Alfa</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($akademiks as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item->siswa }}</td>
                                                <td>{{ $item->total_hadir }}</td>
                                                <td>{{ $item->total_izin }}</td>
                                                <td>{{ $item->total_sakit }}</td>
                                                <td>{{ $item->total_alfa }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6">Belum ada data</td>
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
