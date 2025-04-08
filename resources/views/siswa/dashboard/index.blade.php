@extends('layouts-siswa.layout')
@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8 col-12">
                    @foreach ($akademik as $item_a)
                        <div class="col-12 col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h2 class="text-center font-weight-bold">{{ $item_a->mapel }}</h2>
                                </div>
                                <div class="card-body">
                                    <a href="{{ route('siswa.detail', ['params' => $item_a->uuid_mapel]) }}"
                                        class="btn btn-success btn-sm">Lihat Detail</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="col-md-4 col-12">
                    <style>
                        .announcement-card {
                            margin-bottom: 20px;
                        }
                    </style>
                    <div class="">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h2>Forum Pengumuman</h2>
                        </div>

                        <!-- Pengumuman 1 -->
                        @forelse ($forum as $item_f)
                            <div class="card announcement-card">
                                <div class="card-header bg-info">
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
                </div>
            </div>
        </div>
    </div>
@endsection
