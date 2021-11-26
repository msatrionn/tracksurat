@extends('layouts.home')
@section('content')
<div class="judul" style="width:100%;text-align:center">
    <h4>
        <b>Tabel sudah disposisi</b>
    </h4>
</div>

@include('../layouts/headcontent')
<div class="tabel" style="width:100%;">
    <table id="table" class="table table-default" style="width:100%; ">
        <div class="inner-table" style="padding-top:30px">
            <div class="form-group searchInput">
                <label for="filterbox">Search:</label>
                <input type="search" class="form-control" id="filterbox" placeholder="Cari">
            </div>
        </div>
        <thead>
            <tr class="table-primary">
                <th style="padding:10px">No</th>
                <th>Tanggal</th>
                <th>No Surat Masuk</th>
                <th>No Agenda</th>
                <th>Tujuan Disposisi</th>
                <th>Status Disposisi</th>
                <th>Lampiran</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($disposisi as $item)

            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->tanggal_surat }}</td>
                <td>{{ $item->no_surat }}</td>
                <td>{{ $item->no_agenda }}</td>
                <td>{{ $item->jabatan }}</td>
                <td>{{ $item->status_disposisi }}</td>
                <td><a href="{{ route('download',$item->no_agenda) }}" class="btn btn-danger"><i class="fa fa-download"></i> Download</a></td>
                <td><a href="{{ route('track',$item->no_agenda) }}" class="btn btn-primary"><i class="fa fa-eye"></i>Lihat</a></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection
