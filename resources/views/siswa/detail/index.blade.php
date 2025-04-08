@extends('layouts-siswa.layout')
@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h2 class="font-weight-bold">Misi Gramifikasi</h2>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Misi</th>
                                        <th>Medali</th>
                                        <th style="width: 40px">Skor</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($soal_gramifikasi as $item_s)
                                        <tr>
                                            <td>{{ $item_s->misi }}</td>
                                            <td>
                                                @if ($item_s->lencana)
                                                    <img src="{{ asset('public/icon/' . $item_s->lencana->icon) }}"
                                                        alt="" class="img-fluid" style="width: 50px; height: 50px;">
                                                @else
                                                    Belum ada lencana
                                                @endif
                                            </td>
                                            <td>
                                                @if ($item_s->skor == 0)
                                                    <a href="{{ route('siswa.soalgramifikasi', ['params' => $item_s->uuid_misi]) }}"
                                                        class="btn btn-info btn-sm">Mulai Kerjakan</a>
                                                @else
                                                    <span class="badge bg-danger">{{ $item_s->skor }}</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3">Belum ada misi</td>
                                        </tr>
                                    @endforelse

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h2 class="font-weight-bold">Pembelajaran</h2>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Kategori</th>
                                        <th>Progres</th>
                                        <th style="width: 40px">Skor</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($soal_pembelajaran as $item_p)
                                        <tr>
                                            <td>{{ $item_p->kategori }}</td>
                                            <td>
                                                <div class="progress progress-xs">
                                                    <div class="progress-bar progress-bar-danger"
                                                        style="width: {{ $item_p->skor }}%"></div>
                                                </div>
                                            </td>
                                            <td>
                                                @if ($item_p->skor == 0)
                                                    <a href="{{ route('siswa.soalpembelajaran', ['params' => $item_p->uuid_kategori]) }}"
                                                        class="btn btn-info btn-sm">Mulai Kerjakan</a>
                                                @else
                                                    <span class="badge bg-danger">{{ $item_p->skor }}</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3">Belum ada kategori</td>
                                        </tr>
                                    @endforelse

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
