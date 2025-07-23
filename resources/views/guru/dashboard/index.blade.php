@extends('layouts.layout')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Dashboard</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">{{ $module }}</a></li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Small boxes (Stat box) -->
                <div class="row">
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ $tahun_ajaran->tahun }}</h3>

                                <p>Tahun Ajaran</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-calendar"></i>
                            </div>
                        </div>
                    </div>
                    <!-- ./col -->
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3>{{ $siswa }}<sup style="font-size: 20px">Siswa</sup></h3>

                                <p>Total Siswa</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-users"></i>
                            </div>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $mapel->mapel }}</h3>

                                <p>Mata Pelajaran</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-book"></i>
                            </div>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3>{{ $akademik->first()->kelas }}</h3>

                                <p>Kelas</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-university"></i>
                            </div>
                        </div>
                    </div>
                    <!-- ./col -->
                </div>
                <!-- /.row -->

                <style>
                    .announcement-card {
                        margin-bottom: 20px;
                    }

                    .card-header {
                        background-color: #007bff;
                        color: white;
                    }

                    .card-footer {
                        background-color: #f8f9fa;
                    }
                </style>

                <div class="container mt-5">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2>Forum Pengumuman</h2>
                    </div>

                    <!-- Pengumuman 1 -->
                    @forelse ($forum as $item_f)
                        <div class="card announcement-card">
                            <div class="card-header">
                                {{ $item_f->judul }}
                            </div>
                            <div class="card-body">
                                <p class="card-text">
                                    {{ $item_f->isi_forum }}
                                </p>
                            </div>
                            <div class="card-footer text-muted">
                                Diposting oleh Admin • {{ $item_f->created_at->diffForHumans() }}
                            </div>
                        </div>
                    @empty
                        <div class="alert alert-info">
                            Tidak ada pengumuman saat ini.
                        </div>
                    @endforelse

                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
@endsection
