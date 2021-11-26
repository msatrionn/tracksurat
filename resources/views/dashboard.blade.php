@extends('layouts.home')
@section('content')
<div class="card keterangan">
</div>
<div class="tabel" style="width:100%;">
    <div class="list-group">
        <br>
        <table id="table" class="table table-default" style="width:100%; ">
            @include('../notifikasi')
            <thead>
                <div class="judul" style="width:100%;text-align:center">
                    <h4>
                        {{-- <b>Dashboard {{ $jabatan }}</b> --}}
                        Notifikasi
                        <tr>
                            <td></td>
                        </tr>
                    </h4>
                </div>
            </thead>
            @if (auth()->user()->level=='admin' or auth()->user()->level=='tata_usaha')
            <tbody>
                @foreach ($lihat as $item)
                @if ($item->status_disposisi=='Diterima')
                <tr class="alert alert-success">
                    <td>Surat dengan <i><b>no agenda.{{ $item->no_agenda }}</b></i> sudah terdisposisi sesuai tujuan<i style="float:right;color:rgba(29,100,200,1);cursor:pointer;"><a href="{{ route('detail',$item->no_agenda) }}" style="text-decoration:none;">lihat</a></i> </td>
                </tr>
                @elseif($item->status_disposisi=='Persetujuan')
                <tr class="alert alert-warning">
                    <td>Surat dengan <i><b>no agenda.{{ $item->no_agenda }}</b></i> meminta {{ $item->status_disposisi }} dari kepala sekolah<i style="float:right;color:rgba(29,100,200,1);cursor:pointer;"><a href="{{ route('detail',$item->no_agenda) }}" style="text-decoration:none;">lihat</a></i></td>

                </tr>
                @elseif($item->status_disposisi=='Diarsipkan')
                <tr class="alert alert-success">
                    <td>Surat dengan <i><b>no agenda.{{ $item->no_agenda }}</b></i> {{ $item->status_disposisi }}<i style="float:right;color:rgba(29,100,200,1);cursor:pointer;"><a href="{{ route('detail',$item->no_agenda) }}" style="text-decoration:none;">lihat</a></i></td>

                </tr>
                @elseif($item->status_disposisi=='Dikonfirmasi')
                <tr class="alert alert-danger">
                    <td>Surat dengan <i><b>no agenda.{{ $item->no_agenda }}</b></i>Surat yang diarsipkan sudah {{ $item->status_disposisi }}<i style="float:right;color:rgba(29,100,200,1);cursor:pointer;"><a href="{{ route('detail',$item->no_agenda) }}" style="text-decoration:none;">lihat</a></i></td>

                </tr>

                @elseif($item->status_disposisi=='Disetujui')
                <tr class="alert alert-primary">
                    <td>Surat dengan <i><b>no agenda.{{ $item->no_agenda }}</b></i> telah {{ $item->status_disposisi }} oleh kepala sekolah<i style="float:right;color:rgba(29,100,200,1);cursor:pointer;"><a href="{{ route('detail',$item->no_agenda) }}" style="text-decoration:none;">lihat</a></i></td>

                </tr>
                @elseif($item->status_disposisi=='Diproses')
                <tr class="alert alert-primary">
                    <td>Surat dengan <i><b>no agenda.{{ $item->no_agenda }}</b></i> sedang {{ $item->status_disposisi }} oleh kepala sekolah<i style="float:right;color:rgba(29,100,200,1);cursor:pointer;"><a href="{{ route('detail',$item->no_agenda) }}" style="text-decoration:none;">lihat</a></i></td>

                </tr>
                @elseif($item->status_disposisi=='Dikirim')
                <tr class="alert alert-primary">
                    <td>Surat dengan <i><b>no agenda.{{ $item->no_agenda }}</b></i> telah {{ $item->status_disposisi }} kepada kepala sekolah<i style="float:right;color:rgba(29,100,200,1);cursor:pointer"><a href="{{ route('detail',$item->no_agenda) }}" style="text-decoration:none;">lihat</a></i></td>

                </tr>
                @endif
                @endforeach
            </tbody>

            @elseif (auth()->user()->level=='kepala_sekolah')
            <tbody>
                @foreach ($lihat as $item)
                @if ($item->status_disposisi=='Diterima')
                <tr class="alert alert-success">
                    <td>Surat dengan <i><b>no agenda.{{ $item->no_agenda }}</b></i> sudah terdisposisi sesuai tujuan<i style="float:right;color:rgba(29,100,200,1);cursor:pointer;"><a href="{{ route('detail_kepsek',$item->no_agenda) }}" style="text-decoration:none;">lihat</a></i> </td>
                </tr>
                @elseif($item->status_disposisi=='Persetujuan')
                <tr class="alert alert-warning">
                    <td>Surat dengan <i><b>no agenda.{{ $item->no_agenda }}</b></i> meminta {{ $item->status_disposisi }} dari kepala sekolah<i style="float:right;color:rgba(29,100,200,1);cursor:pointer;"><a href="{{ route('detail_kepsek',$item->no_agenda) }}" style="text-decoration:none;">lihat</a></i></td>

                </tr>
                @elseif($item->status_disposisi=='Diarsipkan')
                <tr class="alert alert-success">
                    <td>Surat dengan <i><b>no agenda.{{ $item->no_agenda }}</b></i> {{ $item->status_disposisi }}<i style="float:right;color:rgba(29,100,200,1);cursor:pointer;"><a href="{{ route('detail_kepsek',$item->no_agenda) }}" style="text-decoration:none;">lihat</a></i></td>

                </tr>
                @elseif($item->status_disposisi=='Dikonfirmasi')
                <tr class="alert alert-danger">
                    <td>Surat dengan <i><b>no agenda.{{ $item->no_agenda }}</b></i> Surat yang diarsipkan sudah {{ $item->status_disposisi }}<i style="float:right;color:rgba(29,100,200,1);cursor:pointer;"><a href="{{ route('detail_kepsek',$item->no_agenda) }}" style="text-decoration:none;">lihat</a></i></td>
                </tr>

                @elseif($item->status_disposisi=='Disetujui')
                <tr class="alert alert-primary">
                    <td>Surat dengan <i><b>no agenda.{{ $item->no_agenda }}</b></i> telah {{ $item->status_disposisi }} oleh kepala sekolah<i style="float:right;color:rgba(29,100,200,1);cursor:pointer;"><a href="{{ route('detail_kepsek',$item->no_agenda) }}" style="text-decoration:none;">lihat</a></i></td>

                </tr>
                @elseif($item->status_disposisi=='Diproses')
                <tr class="alert alert-primary">
                    <td>Surat dengan <i><b>no agenda.{{ $item->no_agenda }}</b></i> sedang {{ $item->status_disposisi }} oleh kepala sekolah<i style="float:right;color:rgba(29,100,200,1);cursor:pointer;"><a href="{{ route('detail_kepsek',$item->no_agenda) }}" style="text-decoration:none;">lihat</a></i></td>

                </tr>
                @elseif($item->status_disposisi=='Dikirim')
                <tr class="alert alert-primary">
                    <td>Surat dengan <i><b>no agenda.{{ $item->no_agenda }}</b></i> telah {{ $item->status_disposisi }} kepada kepala sekolah<i style="float:right;color:rgba(29,100,200,1);cursor:pointer"><a href="{{ route('detail_kepsek',$item->no_agenda) }}" style="text-decoration:none;">lihat</a></i></td>

                </tr>
                @endif
                @endforeach
            </tbody>

            @elseif (auth()->user()->level=='disposisi')
            <tbody>
                @foreach ($lihat as $item)
                @if ($item->status_disposisi=='Diterima')
                <tr class="alert alert-success">
                    <td>Surat dengan <i><b>no agenda.{{ $item->no_agenda }}</b></i> sudah terdisposisi sesuai tujuan<i style="float:right;color:rgba(29,100,200,1);cursor:pointer;"><a href="{{ route('detail_waka',$item->no_agenda) }}" style="text-decoration:none;">lihat</a></i> </td>
                </tr>
                @elseif($item->status_disposisi=='Persetujuan')
                <tr class="alert alert-warning">
                    <td>Surat dengan <i><b>no agenda.{{ $item->no_agenda }}</b></i> meminta {{ $item->status_disposisi }} dari kepala sekolah<i style="float:right;color:rgba(29,100,200,1);cursor:pointer;"><a href="{{ route('detail_waka',$item->no_agenda) }}" style="text-decoration:none;">lihat</a></i></td>

                </tr>
                @elseif($item->status_disposisi=='Diarsipkan')
                <tr class="alert alert-danger">
                    <td>Surat dengan <i><b>no agenda.{{ $item->no_agenda }}</b></i> {{ $item->status_disposisi }}<i style="float:right;color:rgba(29,100,200,1);cursor:pointer;"><a href="{{ route('detail_waka',$item->no_agenda) }}" style="text-decoration:none;">lihat</a></i></td>

                </tr>
                @elseif($item->status_disposisi=='Dikonfirmasi')
                <tr class="alert alert-success">
                    <td>Surat dengan <i><b>no agenda.{{ $item->no_agenda }}</b></i> Surat yang diarsipkan sudah {{ $item->status_disposisi }}<i style="float:right;color:rgba(29,100,200,1);cursor:pointer;"><a href="{{ route('detail_waka',$item->no_agenda) }}" style="text-decoration:none;">lihat</a></i></td>
                </tr>

                @elseif($item->status_disposisi=='Disetujui')
                <tr class="alert alert-primary">
                    <td>Surat dengan <i><b>no agenda.{{ $item->no_agenda }}</b></i> telah {{ $item->status_disposisi }} oleh kepala sekolah<i style="float:right;color:rgba(29,100,200,1);cursor:pointer;"><a href="{{ route('detail_waka',$item->no_agenda) }}" style="text-decoration:none;">lihat</a></i></td>

                </tr>
                @elseif($item->status_disposisi=='Diproses')
                <tr class="alert alert-primary">
                    <td>Surat dengan <i><b>no agenda.{{ $item->no_agenda }}</b></i> sedang {{ $item->status_disposisi }} oleh kepala sekolah<i style="float:right;color:rgba(29,100,200,1);cursor:pointer;"><a href="{{ route('detail_waka',$item->no_agenda) }}" style="text-decoration:none;">lihat</a></i></td>

                </tr>
                @elseif($item->status_disposisi=='Dikirim')
                <tr class="alert alert-primary">
                    <td>Surat dengan <i><b>no agenda.{{ $item->no_agenda }}</b></i> telah {{ $item->status_disposisi }} kepada kepala sekolah<i style="float:right;color:rgba(29,100,200,1);cursor:pointer"><a href="{{ route('detail_waka',$item->no_agenda) }}" style="text-decoration:none;">lihat</a></i></td>

                </tr>
                @endif
                @endforeach
            </tbody>

            @endif
        </table>

    </div>


</div>

@endsection
