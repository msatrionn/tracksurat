@extends('layouts.home') @section('content')
<form action="{{ route('tambah') }}" method="post" enctype="multipart/form-data">
    @csrf
    *Semua harus diisi dengan lengkap
    <span style="float:right;">
    </span>
    </div>
    <div class="form-group">
        <label for="no_agenda">No Agenda</label>
        <input id="no_agenda" type="number" class="form-control @error('no_agenda') is-invalid @enderror" value="{{ old('no_agenda') }}" name="no_agenda" maxlength="10">
        @error('no_agenda')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror

    </div>
    <div class="form-group">
        <label for="no_surat">No Surat</label>
        <input id="no_surat" type="text" class="form-control @error('no_surat') is-invalid @enderror" value="{{ old('no_surat') }}" name="no_surat" maxlength="20">

        @error('no_surat')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror

        <div class="form-group">
            <label for="dari">Dari</label>
            <input id="dari" type="text" class="form-control @error('dari') is-invalid @enderror" value="{{ old('dari') }}" name="dari" maxlength="100">
            @error('dari')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror

        </div>

        <div class="form-group">
            <label for="kepada">Kepada</label>
            <input id="kepada" type="text" class="form-control @error('kepada') is-invalid @enderror" value="{{ old('kepada') }}" name="kepada" maxlength="100">
            @error('kepada')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror

        </div>

        <div class="form-group">
            <label for="perihal">Perihal</label>
            <input id="perihal" type="text" class="form-control @error('perihal') is-invalid @enderror" value="{{ old('perihal') }}" name="perihal">
            @error('perihal')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror

        </div>
        <div class="form-group">
            <label for="Lampiran">Lampiran</label>
            <input id="Lampiran" type="file" class="form-control @error('lampiran') is-invalid @enderror" value="{{ old('lampiran') }}" name="lampiran">
            @error('lampiran')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        <div class="form-group">
            <label for="tanggal_surat">Tanggal Surat</label>
            <input id="tanggal_surat" type="date" class="form-control @error('tanggal_surat') is-invalid @enderror" value=" {{ old('tanggal_surat') }}" name="tanggal_surat">

            @error('tanggal_surat')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        <div class="form-group">
            <input type="hidden" name="id_status" id="status" value="1">
        </div>

        <div class="form-group">
            <label for="jenis_surat">Jenis</label>
            <select name="jenis_surat" id="jenis_surat" class="form-control @error('jenis_surat') is-invalid @enderror" value="{{ old('jenis_surat') }}">
                <option value="Segera">Segera</option>
                <option value="Sangat Segera">Sangat Segera</option>
                <option value="Biasa">Biasa</option>
                <option value="Bukan Rahasia">Bukan Rahasia</option>
                <option value="Rahasia">Rahasia</option>
            </select>
            @error('jenis_surat')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror

        </div>
        <br>
        <button type="submit" class="btn btn-success">Tambah</button>
</form>
@endsection
