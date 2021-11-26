@extends('layouts.home') @section('content')
<form action="{{ url('update_masuk', $sm->no_agenda) }}" method="post" enctype="multipart/form-data">
    @csrf @method('put')
    <div class="form-group">
        <label for="no_surat">No Surat</label>
        <input id="no_surat" type="text" class="form-control @error('no_surat') is-invalid @enderror" value="{{ $sm->no_surat }}" name="no_surat" maxlength="20">

        @error('no_surat')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
    <div class="form-group">
        <label for="dari">Dari</label>
        <input id="dari" type="text" class="form-control @error('dari') is-invalid @enderror" value="{{ $sm->dari }}" name="dari" maxlength="50">
        @error('dari')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror

    </div>

    <div class="form-group">
        <label for="kepada">Kepada</label>
        <input id="kepada" type="text" class="form-control @error('kepada') is-invalid @enderror" value="{{ $sm->kepada }}" name="kepada" maxlength="50">
        @error('kepada')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror

    </div>

    <div class="form-group">
        <label for="perihal">Perihal</label>
        <input id="perihal" type="text" class="form-control @error('perihal') is-invalid @enderror" value="{{ $sm->perihal }}" name="perihal">
        @error('perihal')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror

    </div>
    <div class="form-group">
        <label for="Lampiran">Lampiran</label>
        <input id="Lampiran" type="file" class="form-control @error('lampiran') is-invalid @enderror" name="lampiran">
        @error('lampiran')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
    <div class="form-group">
        <label for="tanggal_surat">Tanggal Surat</label>
        <input id="tanggal_surat" type="date" class="form-control  @error('jenis_surat') is-invalid @enderror" value="{{ $sm->tanggal_surat }}" name="tanggal_surat">
        @error('tanggal_surat')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>

    <div class="form-group">
        <label for="jenis_surat">Jenis</label>
        <select name="jenis_surat" id="jenis_surat" class="form-control @error('jenis_surat') is-invalid @enderror" value="{{ $sm->jenis_surat}}">
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

    <button type="submit" class="btn btn-success">Edit</button>
</form>
@endsection
