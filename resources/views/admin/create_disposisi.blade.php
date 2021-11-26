@extends('layouts.home') @section('content')
<form action="{{ url('save_disposisi',$no_agenda->no_agenda) }}" method="post" enctype="multipart/form-data">
    @csrf
    <h3>Kirim Disposisi</h3>
    No Surat {{$no_agenda->no_surat}}
    <div class="form-group">
        <input id="no_agenda" type="hidden" class="form-control" name="no_agenda" value="{{ $no_agenda->no_agenda }}">
    </div>
    <input type="hidden" name="id_status" value="2">
    <div class="form-group">
        <label for="nip">Disposisikan kepada</label>
        <select name="nip" id="jenis_surat" class="form-control">
            @foreach ($kepada as $item)
            <option value="{{ $item->nip }}">{{ $item->jabatan }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label for="keterangan">Keterangan</label>
        <input id="keterangan" type="text" class="form-control" name="keterangan">
    </div>
    <br>
    <button type="submit" class="btn btn-success">Disposisikan</button>
</form>
@endsection
