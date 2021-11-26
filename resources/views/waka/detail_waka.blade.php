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
    @include('../notifikasi')
    <table id="table" class="table table-default" style="width:100%; ">
        <div class="inner-table">
            <div class="form-group searchInput" style="margin-top:10px">
                <label for="filterbox">Search:</label>
                <input type="search" class="form-control" id="filterbox" placeholder="Cari">
            </div>
        </div>
        @include('../notifikasi')
        <thead>
            <tr class="table-primary">
                <th>No Agenda</th>
                <th>No Surat Masuk</th>
                <th>Dari</th>
                <th>Kepada</th>
                <th>Perihal</th>
                <th>Lampiran</th>
                <th>Tanggal</th>
                <th>Jenis</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $show->no_agenda }}</td>
                <td>{{ $show->no_surat }}</td>
                <td>{{ $show->dari }}</td>
                <td>{{ $show->kepada }}</td>
                <td>{{ $show->perihal }}</td>
                <td><a href="{{ route('download', $show->lampiran) }}" class="btn btn-danger" style="display:flex;align-shows:center"><i class="fa fa-download">Download</a></td>
                <td>{{ $show->tanggal_surat }}</td>
                <td>{{ $show->jenis_surat }}</td>
                <td class="disposisi">
                    @if ($show->status_disposisi=="Disetujui" && auth()->user()->level=='disposisi')
                    <form action="{{ route('save_waka',$show->no_agenda) }}" method="post">
                        @csrf
                        <input type="hidden" name="status" value="diterima">
                        <button type="submit" class="btn btn-success" onClick="return confirm(`{{ $show->keterangan }}`)"><i class="fa fa-check"></i>Konfirmasi</button>
                    </form>
                    @elseif ($show->status_disposisi=="Diarsipkan" && auth()->user()->level=='disposisi')
                    <form action="{{ route('save_waka',$show->no_agenda) }}" method="post">
                        <input type="hidden" name="status" value="diarsipkan">
                        @csrf
                        <button type="submit" class="btn btn-danger" onClick="return confirm(`{{ $show->keterangan }}`)" style="display:flex;align-shows:center"><i class="fa fa-archive"></i>Diarsipkan</button>
                    </form>
                    @else
                    <a href="{{ route('track',$show->no_agenda) }}" class="btn btn-primary"><i class="fa fa-eye"></i>Lihat</a>
                    @endif
                </td>
            </tr>
        </tbody>
    </table>
</div>

@endsection
