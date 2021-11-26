@extends('layouts.home')
@section('content')
{{-- @include('../layouts/headcontent') --}}

<div class="tabel" style="width:100%;">
    <table id="table" class="table table-default" style="width:100%; ">
        <h2>Tanggal {{ $tgl }}</h2>
        <thead>
            <tr>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    @foreach ($sm as $item)
                    <div class="card" style="display:inline-flex;justify-content:space-between;width:200px;min-height:230px">
                        <div class="gambar-arsip">
                            <img src="{{url('img/pdf.png') }}" alt="" width="60px">
                            <span>{{ $item->no_surat }}</span>
                            <span> {{ $item->perihal }}</span>
                            <a href="" style="position:absolute;margin:0 auto;bottom:10px;left:0.1%;width:99%" class="btn btn-danger">Download</a>
                        </div>
                        <div class="lampiran">
                        </div>
                    </div>
                    @endforeach
                </td>
            </tr>
        </tbody>
    </table>
</div>

@endsection
