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
            @foreach ($waka as $item)
            <tr>
                <td>{{ $item->no_agenda }}</td>
                <td>{{ $item->no_surat }}</td>
                <td>{{ $item->dari }}</td>
                <td>{{ $item->kepada }}</td>
                <td>{{ $item->perihal }}</td>
                <td class="disposisi"><a href="{{ route('download', $item->lampiran) }}" class="btn btn-danger" style="display:flex;align-items:center"><i class="fa fa-download"></i>Download</a></td>
                <td>{{ $item->tanggal_surat }}</td>
                <td>{{ $item->jenis_surat }}</td>
                <td class="disposisi">
                    @if ($item->status_disposisi=="Disetujui" && auth()->user()->level=='disposisi')
                    <form action="{{ route('save_waka',$item->no_agenda) }}" method="post">
                        @csrf
                        <input type="hidden" name="status" value="diterima">
                        <button type="submit" class="btn btn-success" onClick="return confirm(`{{ $item->keterangan }}`)"><i class="fa fa-check"></i>Konfirmasi</button>
                    </form>
                    @elseif ($item->status_disposisi=="Diarsipkan" && auth()->user()->level=='disposisi')
                    <form action="{{ route('save_waka',$item->no_agenda) }}" method="post">
                        <input type="hidden" name="status" value="diarsipkan">
                        @csrf
                        <button type="submit" class="btn btn-danger" onClick="return confirm(`{{ $item->keterangan }}`)" style="display:flex;align-items:center"><i class="fa fa-archive"></i>Diarsipkan</button>
                    </form>
                    @else
                    <a href="{{ route('track',$item->no_agenda) }}" class="btn btn-primary"><i class="fa fa-eye"></i>Lihat</a>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
