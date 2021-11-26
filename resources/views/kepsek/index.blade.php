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
            <tr class="table-primary">
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
            @foreach ($kepsek as $item)
            <tr>
                <td>{{ $item->no_agenda }}</td>
                <td>{{ $item->no_surat }}</td>
                <td>{{ $item->dari }}</td>
                <td>{{ $item->kepada }}</td>
                <td>{{ $item->perihal }}</td>
                <td><a href="{{ route('download', $item->lampiran) }}" target="__blank" style="display:flex;align-items:center; line-height:3px;" class="btn btn-danger"><i style="margin: 0 2px" class="fa fa-download"></i>Download</a></td>
                <td>{{ $item->tanggal_surat }}</td>
                <td>{{ $item->jenis_surat }}</td>
                <td class="disposisi">
                    @if ($item->status_disposisi=="Dikirim" && auth()->user()->level=='kepala_sekolah')
                    <form action="{{ route('disposisi_kepsek',$item->no_agenda) }}" method="post">
                        @csrf @method('post')
                        <input type="hidden" value="{{ $item->no_agenda }}" name="no_agenda">
                        <input type="hidden" value="{{ $item->nip }}" name="nip">
                        <input type="hidden" value="Surat telah diterima dan sedang diproses oleh kepala sekolah" name="keterangan">
                        <input type="hidden" value="4" name="id_status">
                        <button type="submit" class="btn btn-success" style="display:flex;align-items:center; line-height:3px;" onClick="return confirm('Konfirmasi?')"> <i style="margin: 0 2px" class="fa fa-check"></i> Konfirmasi</button>
                    </form>
                    @elseif($item->status_disposisi=="Diproses")

                    <button style="display:flex;align-items:center; line-height:3px;" type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalForm">
                        <i style="margin: 0 2px" class="fa fa-send"></i> Disposisi
                    </button>
                    <!-- Modal -->
                    <div class="modal fade" id="modalForm" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Input Disposisi</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('persetujuan', $item->no_agenda) }}" method="post">
                                        @csrf @method('post')
                                        <div class="mb-3">
                                            <input type="hidden" value="{{ $item->no_agenda }}" class="form-control" name="no_agenda" />
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Persetujuan disposisi</label>
                                            <input type="hidden" value="{{ $item->nip }}" class="form-control" name="nip">
                                            <select name="id_status" id="" class="form-select">
                                                <option value="3">Setuju</option>
                                                <option value="5">Arsipkan</option>
                                            </select>

                                            <label class="form-label">Kepada</label>
                                            <select name="nip" id="" class="form-select">
                                                @foreach ($kepada as $item)
                                                <option value="{{ $item->nip }}">{{ $item->jabatan }}</option>
                                                @endforeach
                                            </select>

                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Keterangan</label>
                                            <input type="text" name="keterangan" class="form-control">
                                        </div>
                                        <div class="modal-footer d-block">
                                            <button type="submit" class="btn btn-warning float-end" onClick="return confirm('Anda Yakin Ingin Mengirim Disposisi?')"><i style="margin: 0 2px" class="fa fa-send"></i> Kirim</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @else
                    <a href="{{ route('track',$item->no_agenda) }}" class="btn btn-primary" style="display:flex;align-items:center; line-height:3px;"><i style="margin: 0 2px" class="fa fa-eye"></i>Lihat</a>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection
