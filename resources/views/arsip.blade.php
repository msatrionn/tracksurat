@extends('layouts.home')
@section('content')
<div class="judul" style="width:100%;text-align:center">
    <h4>
        <b>Tabel surat ditolak/diarsipkan</b>
    </h4>
</div>

@include('../layouts/headcontent')

<div class="tabel" style="width:100%;">
    <table id="table" class="table table-default" style="width:100%; ">
        <div class="inner-table">
            <div class="form-group searchInput">
                <label for="filterbox">Search:</label>
                <input type="search" class="form-control" id="filterbox" placeholder="Cari">
            </div>
        </div>
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
            </tr>
        </thead>
        <tbody>
            @foreach ($sm as $item)
            <tr>
                <td>{{ $item->no_agenda }}</td>
                <td>{{ $item->no_surat }}</td>
                <td>{{ $item->dari }}</td>
                <td>{{ $item->kepada }}</td>
                <td> {{ $item->perihal}}</td>
                <td class=" lamp"><a href="{{ route('download', $item->lampiran) }}" class="btn btn-danger"><i class="fa fa-download"></i>Download</a></td>
                <td>{{ $item->tanggal_surat }}</td>
                <td>{{ $item->jenis_surat }}</td>
                <td class="disposisi">
                    <a href="{{ route('track',$item->no_agenda) }}" class="btn btn-primary"><i class="fa fa-eye"></i>Lihat</a>
                </td>
            </tr>
            @endforeach
        </tbody>

    </table>
</div>

@endsection
