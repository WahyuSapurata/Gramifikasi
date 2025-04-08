@extends('layouts-siswa.layout')
@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h2 class="font-weight-bold">Soal dari kategori {{ $kategori->kategori }}</h2>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('siswa.pembelajaran-answer') }}" method="POST">
                                @csrf
                                <ol type="1">
                                    @php $previousSoal = null; @endphp

                                    @foreach ($soal as $s)
                                        @if ($s->soal !== $previousSoal)
                                            <li>
                                                {{-- Tampilkan pertanyaan --}}
                                                <div class="fw-bold mb-2">{{ $s->soal }}</div>

                                                {{-- Tampilkan pilihan jawaban (A, B, C...) --}}
                                                <ol type="A" class="d-grid gap-3 mt-3">
                                                    @foreach ($s->jawaban as $option)
                                                        <li>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio"
                                                                    name="soal[{{ $s->uuid }}][jawaban]"
                                                                    id="jawaban_{{ $s->uuid }}_{{ $loop->index }}"
                                                                    value="{{ $option }}"
                                                                    @if (old('soal.' . $s->uuid . '.jawaban') == $option) checked @endif>

                                                                <label class="form-check-label"
                                                                    for="jawaban_{{ $s->uuid }}_{{ $loop->index }}">
                                                                    {{ $option }}
                                                                </label>
                                                            </div>
                                                        </li>
                                                    @endforeach
                                                </ol>
                                            </li>
                                            @php $previousSoal = $s->soal; @endphp
                                        @endif
                                    @endforeach
                                </ol>
                                <div class="d-flex justify-content-center mt-10">
                                    <button class="btn btn-primary" id="button">Submit Jawaban</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
