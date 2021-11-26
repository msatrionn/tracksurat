<?php

namespace App\Http\Controllers;

use App\Models\disposisi;
use App\Models\Karyawan;
use App\Models\SuratMasuk;
use App\Models\Status;
use Illuminate\Http\Request;

class KepsekController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jabatan = Karyawan::join('m_jabatan', 'm_jabatan.id_jabatan', 'karyawan.id_jabatan')
            ->where('id_user', auth()->user()->id_user)->first()->jabatan;
        $jumlah = SuratMasuk::where('status_disposisi', '!=', 'Belum disposisi')->get('no_agenda')->count();
        $belum = SuratMasuk::where('status_disposisi', 'Dikirim')->orWhere('status_disposisi', 'Diproses')->get('status_disposisi')->count();
        $diterima = SuratMasuk::get('status_disposisi')->where('status_disposisi', 'Diterima')->count();
        $diarsipkan = SuratMasuk::where('status_disposisi', 'Dikonfirmasi')
            ->orWhere('status_disposisi', 'Diarsipkan')->get('no_surat')->count();
        $kepsek = SuratMasuk::where('status_disposisi', '!=', 'Belum disposisi')->get();
        $kepada = Karyawan::join('m_jabatan', 'm_jabatan.id_jabatan', 'karyawan.id_jabatan')
            ->where('jabatan', '!=', 'admin')
            ->where('jabatan', '!=', 'tata usaha')
            ->where('jabatan', '!=', 'kepala sekolah')
            ->get();
        return view('kepsek/index', compact('kepsek', 'jumlah', 'belum', 'diterima', 'diarsipkan', 'kepada', 'jabatan'));
        // dd($kepsek);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        // $no_surat = SuratMasuk::find($id);
        // $status = Status::all();
        // $kepada = Karyawan::join('m_jabatan', 'm_jabatan.id_jabatan', '=', 'karyawan.id_jabatan')->get();

        // return view('kepsek/disposisi_kepsek', compact('no_surat', 'status', 'kepada'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        $sm = SuratMasuk::find($id);
        $disposisi = Disposisi::where('no_agenda', $id)->first();
        $nip = $disposisi->nip;
        $no_agenda = $disposisi->no_agenda;
        $sm->update([
            'status_disposisi' => 'Diproses'
        ]);
        $disposisi->create([
            'no_agenda' => $request->no_agenda,
            'id_status' => $request->id_status,
            'nip' => $nip,
            'keterangan' => $request->keterangan,

        ]);
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $jabatan = Karyawan::join('m_jabatan', 'm_jabatan.id_jabatan', 'karyawan.id_jabatan')
            ->where('id_user', auth()->user()->id_user)->first()->jabatan;
        $jumlah = SuratMasuk::where('status_disposisi', '!=', 'Belum disposisi')->get('no_agenda')->count();
        $belum = SuratMasuk::where('status_disposisi', 'Dikirim')->orWhere('status_disposisi', 'Diproses')->get('status_disposisi')->count();
        $diterima = SuratMasuk::get('status_disposisi')->where('status_disposisi', 'Diterima')->count();
        $diarsipkan = SuratMasuk::where('status_disposisi', 'Dikonfirmasi')
            ->orWhere('status_disposisi', 'Diarsipkan')->get('no_surat')->count();
        $kepada = Karyawan::join('m_jabatan', 'm_jabatan.id_jabatan', 'karyawan.id_jabatan')
            ->where('jabatan', '!=', 'admin')
            ->where('jabatan', '!=', 'tata usaha')
            ->where('jabatan', '!=', 'kepala sekolah')
            ->get();
        $show = SuratMasuk::find($id);
        return view('kepsek.detail_kepsek', compact('show', 'kepada', 'jumlah', 'belum', 'diterima', 'diarsipkan', 'jabatan'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function persetujuan(Request $request, $id)
    {
        $sm = SuratMasuk::find($id);
        $cek_stat = Status::where('id_status', $request->id_status)->first();
        $stat = $cek_stat->status;
        $disposisi = Disposisi::where('no_agenda', $id)->first();
        $karyawan = Karyawan::join('m_jabatan', 'm_jabatan.id_jabatan', 'karyawan.id_jabatan')
            ->where('nip', $request->nip)
            ->first()->jabatan;
        $sm->update([
            'status_disposisi' => $stat
        ]);
        $disposisi->create([
            'no_agenda' => $request->no_agenda,
            'id_status' => $request->id_status,
            'nip' => $request->nip,
            'keterangan' => "kepada $karyawan : $request->keterangan",
        ]);
        return back()->with('success', "Surat berhasil disposisi");
    }
}
