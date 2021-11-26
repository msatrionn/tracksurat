<?php

namespace App\Http\Controllers;

use App\Models\Disposisi;
use Illuminate\Http\Request;
use App\Models\SuratMasuk;
use App\Models\Karyawan;
use App\Models\Status;


class WakaController extends Controller
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
        $user = auth()->user()->id_user;
        $admin = auth()->user()->level == 'admin';
        $tu = auth()->user()->level == 'tata_usaha';
        $cek_karyawan = Karyawan::where('id_user', $user)->first();
        $karyawan = $cek_karyawan->nip;
        //Info
        $diarsipkan = SuratMasuk::get('status_disposisi')->where('status_disposisi', 'Diarsipkan')->count();
        if ($admin) {
            $jumlah = SuratMasuk::join('disposisi', 'disposisi.no_agenda', 'm_surat_masuk.no_agenda')
                ->where('status_disposisi', 'Diterima')
                ->orWhere('status_disposisi', 'Disetujui')
                ->orWhere('status_disposisi', 'Diarsipkan')
                ->distinct()
                ->get('no_surat')->count();
            $belum = SuratMasuk::join('disposisi', 'disposisi.no_agenda', 'm_surat_masuk.no_agenda')
                ->where('status_disposisi', 'Disetujui')
                ->where('status_disposisi', 'Diarsipkan')
                ->distinct()
                ->get('no_surat')->count();
            $diterima = SuratMasuk::join('disposisi', 'disposisi.no_agenda', 'm_surat_masuk.no_agenda')
                ->where('status_disposisi', 'Diterima')
                ->orWhere('status_disposisi', 'Disetujui')
                ->distinct()
                ->get('no_surat')->count();
            $diarsipkan = SuratMasuk::join('disposisi', 'disposisi.no_agenda', 'm_surat_masuk.no_agenda')
                ->where('status_disposisi', 'Diarsipkan')
                ->orWhere('status_disposisi', 'Dikonfirmasi')
                ->distinct()
                ->get('no_surat')->count();
            $waka = SuratMasuk::join('disposisi', 'disposisi.no_agenda', 'm_surat_masuk.no_agenda')
                ->where('status_disposisi', 'Diterima')
                ->orWhere('status_disposisi', 'Disetujui')
                ->orWhere('status_disposisi', 'Diarsipkan')
                ->distinct()
                ->get([
                    'm_surat_masuk.no_agenda', 'm_surat_masuk.no_surat', 'm_surat_masuk.dari', 'm_surat_masuk.kepada',
                    'm_surat_masuk.lampiran', 'm_surat_masuk.tanggal_surat', 'm_surat_masuk.jenis_surat', 'm_surat_masuk.status_disposisi', 'm_surat_masuk.perihal'
                ]);
        } else {
            $jumlah = SuratMasuk::join('disposisi', 'disposisi.no_agenda', 'm_surat_masuk.no_agenda')
                ->join('karyawan', 'karyawan.nip', 'disposisi.nip')
                ->where('status_disposisi', '!=', 'Belum disposisi')
                ->where('status_disposisi', '!=', 'Diproses')
                ->where('status_disposisi', '!=', 'Dikirim')
                ->where('karyawan.id_user', $user)->distinct()
                ->get('no_surat')->count();
            $belum = SuratMasuk::join('disposisi', 'disposisi.no_agenda', 'm_surat_masuk.no_agenda')
                ->join('karyawan', 'karyawan.nip', 'disposisi.nip')
                ->where('status_disposisi', '=', 'Disetujui')
                ->where('karyawan.id_user', $user)
                ->distinct()
                ->get('no_surat')->count();
            $diterima = SuratMasuk::join('disposisi', 'disposisi.no_agenda', 'm_surat_masuk.no_agenda')
                ->join('karyawan', 'karyawan.nip', 'disposisi.nip')
                ->where('status_disposisi', '!=', 'Dikirim')
                ->where('karyawan.id_user', $user)
                ->where('status_disposisi', 'Diterima')
                ->distinct()
                ->get('no_surat')->count();
            $diarsipkan = SuratMasuk::join('disposisi', 'disposisi.no_agenda', 'm_surat_masuk.no_agenda')
                ->join('karyawan', 'karyawan.nip', 'disposisi.nip')
                ->where('status_disposisi', '!=', 'Dikirim')
                ->where('karyawan.id_user', $user)
                ->Where('status_disposisi', 'Dikonfirmasi')
                ->distinct()
                ->get('no_surat')->count();
            $waka = SuratMasuk::join('disposisi', 'disposisi.no_agenda', 'm_surat_masuk.no_agenda')
                ->where('nip', $karyawan)
                ->where('status_disposisi', '!=', 'Belum disposisi')
                ->where('status_disposisi', '!=', 'Diproses')
                ->where('status_disposisi', '!=', 'Dikirim')
                ->distinct()
                ->get([
                    'm_surat_masuk.no_agenda', 'm_surat_masuk.no_surat', 'm_surat_masuk.dari', 'm_surat_masuk.kepada',
                    'm_surat_masuk.lampiran', 'm_surat_masuk.tanggal_surat', 'm_surat_masuk.jenis_surat', 'm_surat_masuk.status_disposisi', 'm_surat_masuk.perihal', 'disposisi.keterangan'
                ]);
        }
        // dd($karyawan);
        return view('waka/index', compact('waka', 'jumlah', 'belum', 'diterima', 'diarsipkan', 'jabatan'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        $terima = $request->status == 'diterima';
        $arsipkan = $request->status == 'diarsipkan';
        $no_agenda = SuratMasuk::find($id);
        $no = $no_agenda->no_agenda;
        $user = auth()->user()->id_user;
        $kepada = Karyawan::join('m_jabatan', 'm_jabatan.id_jabatan', '=', 'karyawan.id_jabatan')->where('karyawan.id_user', $user)->first()->jabatan;
        $masuk = SuratMasuk::find($id);
        if ($terima) {
            Disposisi::create(
                [
                    'no_agenda' => $no,
                    'id_status' => 6,
                    'keterangan' => "Surat Telah diterima oleh $kepada",

                ]
            );
            $masuk->update(['status_disposisi' => 'Diterima']);
        } elseif ($arsipkan) {
            Disposisi::create(
                [
                    'no_agenda' => $no,
                    'id_status' => 5,
                    'keterangan' => "Surat Telah diterima dan diarsipkan oleh $kepada",

                ]
            );
            $masuk->update(['status_disposisi' => 'Dikonfirmasi']);
        }
        return redirect('surat_masuk_waka')->with('success', "Surat Telah Dikonfirmasi");
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
        $user = auth()->user()->id_user;
        $cek_karyawan = Karyawan::where('id_user', $user)->first();
        $karyawan = $cek_karyawan->nip;
        $jumlah = SuratMasuk::join('disposisi', 'disposisi.no_agenda', 'm_surat_masuk.no_agenda')
            ->join('karyawan', 'karyawan.nip', 'disposisi.nip')
            ->where('status_disposisi', '!=', 'Belum disposisi')
            ->where('status_disposisi', '!=', 'Diproses')
            ->where('status_disposisi', '!=', 'Dikirim')
            ->where('karyawan.id_user', $user)->distinct()
            ->get('no_surat')->count();
        $belum = SuratMasuk::join('disposisi', 'disposisi.no_agenda', 'm_surat_masuk.no_agenda')
            ->join('karyawan', 'karyawan.nip', 'disposisi.nip')
            ->where('status_disposisi', '=', 'Disetujui')
            ->where('karyawan.id_user', $user)
            ->distinct()
            ->get('no_surat')->count();
        $diterima = SuratMasuk::join('disposisi', 'disposisi.no_agenda', 'm_surat_masuk.no_agenda')
            ->join('karyawan', 'karyawan.nip', 'disposisi.nip')
            ->where('status_disposisi', '!=', 'Dikirim')
            ->where('karyawan.id_user', $user)
            ->where('status_disposisi', 'Diterima')
            ->distinct()
            ->get('no_surat')->count();
        $diarsipkan = SuratMasuk::join('disposisi', 'disposisi.no_agenda', 'm_surat_masuk.no_agenda')
                ->join('karyawan', 'karyawan.nip', 'disposisi.nip')
                ->where('status_disposisi', '!=', 'Dikirim')
                ->where('karyawan.id_user', $user)
                ->Where('status_disposisi', 'Dikonfirmasi')
                ->distinct()
                ->get('no_surat')->count();
        $show = SuratMasuk::join('disposisi', 'disposisi.no_agenda', 'm_surat_masuk.no_agenda')
            ->where('nip', $karyawan)
            ->where('m_surat_masuk.no_agenda', $id)
            ->where('status_disposisi', '!=', 'Belum disposisi')
            ->where('status_disposisi', '!=', 'Diproses')
            ->where('status_disposisi', '!=', 'Dikirim')
            ->distinct()
            ->get(['m_surat_masuk.no_agenda', 'm_surat_masuk.no_surat', 'm_surat_masuk.dari', 'm_surat_masuk.kepada', 'm_surat_masuk.lampiran', 'm_surat_masuk.tanggal_surat', 'm_surat_masuk.jenis_surat', 'm_surat_masuk.status_disposisi', 'm_surat_masuk.perihal', 'disposisi.keterangan'])
            ->first();

        return view('waka.detail_waka', compact('show', 'jumlah', 'belum', 'diterima', 'diarsipkan', 'jabatan'));
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
}
