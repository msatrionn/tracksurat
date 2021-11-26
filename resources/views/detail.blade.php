@extends('layouts.home')
@section('content')
<div class="judul" style="width:100%;text-align:center">
    <h4>
        <b>Tabel surat masuk</b>
    </h4>
</div>
@include('../layouts/headcontent')
<div class="tabel" style="width:100%;">
    <br>
    <table id="table" class="table table-default" style="width:100%; ">
        <div class="inner-table">
            <div class="form-group searchInput">
                <label for="filterbox">Search:</label>
                <input type="search" class="form-control" id="filterbox" placeholder="Cari">
            </div>
        </div>
        @include('../notifikasi')
        <thead>
            <tr class="table-primary" style="text-align:center">
                <th>No Agenda</th>
                <th>No Surat Masuk</th>
                <th>Dari</th>
                <th>Kepada</th>
                <th>Perihal</th>
                <th>Lampiran</th>
                <th>Tanggal</th>
                <th>Jenis</th>
                <th>Disposisi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $show->no_agenda }}</td>
                <td>{{ $show->no_surat }}</td>
                <td>{{ $show->dari }}</td>
                <td>{{ $show->kepada }}</td>
                <td> {{ $show->perihal}}</td>
                <td class="disposisi"><a href="{{ route('download', $show->lampiran) }}" class="btn btn-danger"><i class="fa fa-download"></i>Download</a></td>
                <td>{{ $show->tanggal_surat }}</td>
                <td>{{ $show->jenis_surat }}</td>
                <td class="disposisi">
                    @if ($show->status_disposisi=="Belum disposisi")
                    <form action="{{ route('kirim',$show->no_agenda) }}" method="post">
                        @csrf
                        <input id="no_agenda" type="hidden" class="form-control" name="no_agenda" value="{{ $show->no_agenda }}">
                        <input type="hidden" name="id_status" value="2">
                        <input id="keterangan" type="hidden" class="form-control" name="keterangan" value="Surat dikirim ke kepala sekolah untuk meminta persetujuan">
                        <button type="submit" class="btn btn-success"><i class="fa fa-send"></i>Disposisikan</button>
                    </form>
                    @else
                    <a href="{{ route('track',$show->no_agenda) }}" class="btn btn-primary"><i class="fa fa-eye"></i>Lihat</a>
                    @endif
                </td>
                <td class="aksi">
                    <a href="{{ route('edit_masuk',$show->no_agenda) }}" class="btn btn-warning"><i class="fa fa-edit"></i>Edit</a>
                    <form action="{{ route('hapus_masuk',$show->no_agenda) }}" method="POST">
                        @method('delete')
                        @csrf
                        <button class="btn btn-danger " type="submit" onClick="return confirm('Anda Yakin Ingin Menghapus?')"><i class="fa fa-trash"></i>hapus</button>
                    </form>
                </td>

            </tr>
        </tbody>
    </table>
</div>

@endsection
