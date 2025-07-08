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
                            {{-- <form action="{{ route('guru.penilaian-gramifikasi') }}" method="GET">
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
                                        <label for="uuid_misi" class="form-label">Misi</label>
                                        <select name="uuid_misi" id="uuid_misi" class="form-control">
                                            <option value="">-- pilih --</option>
                                            @foreach ($misi as $m)
                                                <option value="{{ $m->uuid }}"
                                                    {{ request('uuid_misi') == $m->uuid ? 'selected' : '' }}>
                                                    {{ $m->misi }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-2">
                                        <button class="btn btn-success">Cari Data</button>
                                    </div>
                                </div>
                            </form> --}}
                        </div>
                        <div class="card">
                            <!-- /.card-header -->
                            <div class="card-header">
                                <div>
                                    @php
                                        use Carbon\Carbon;
                                        use App\Models\TahunAjaran;
                                        use App\Models\Akademik;
                                        use App\Models\Absen;

                                        $tahunAjaran = TahunAjaran::where('status', true)->first();
                                        $akademik = null;
                                        $sudahAbsen = false;

                                        if ($tahunAjaran) {
                                            $akademik = Akademik::where('uuid_tahun', $tahunAjaran->uuid)
                                                ->where('uuid_guru', auth()->user()->uuid)
                                                ->first();

                                            if ($akademik) {
                                                $sudahAbsen = Absen::where('uuid_akademik', $akademik->uuid)
                                                    ->whereDate('tanggal', Carbon::today())
                                                    ->exists();
                                            }
                                        }
                                    @endphp

                                    <a href="{{ $sudahAbsen ? '#' : route('guru.add-absen') }}"
                                        class="btn btn-primary {{ $sudahAbsen ? 'disabled' : '' }}">
                                        <i class="fas fa-plus-square"></i>
                                        <span class="ml-1">
                                            {{ $sudahAbsen ? 'Telah Melakukan Absensi Hari Ini' : 'Lakukan Absensi' }}
                                        </span>
                                    </a>

                                </div>
                            </div>
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Siswa</th>
                                            <th>Kehadiran</th>
                                            <th>Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($data as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item->siswa }}</td>
                                                <td>{{ $item->status }}</td>
                                                <td>{{ $item->keterangan ? $item->keterangan : '-' }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4">Belum ada data absen hari ini</td>
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
