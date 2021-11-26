<?php

namespace App\Http\Controllers;

use App\Models\Disposisi;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use App\Models\SuratMasuk;
use App\Models\Status;
use Carbon\Carbon;
use DateTime;

class DisposisiController extends Controller
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
        if (auth()->user()->level == 'admin' or auth()->user()->level == 'tata_usaha') {
             $jumlah = SuratMasuk::get('no_surat')->count();
            $belum = SuratMasuk::get('status_disposisi')->where('status_disposisi', 'Belum disposisi')->count();
            $diterima = SuratMasuk::get('status_disposisi')->where('status_disposisi', 'Diterima')->count();
            $diarsipkan = SuratMasuk::join('disposisi', 'disposisi.no_agenda', 'm_surat_masuk.no_agenda')->distinct()->where('id_status', '5')->get('m_surat_masuk.no_agenda')->count();
            $disposisi = Disposisi::join('m_surat_masuk', 'm_surat_masuk.no_agenda', '=', 'disposisi.no_agenda')
                ->join('karyawan', 'karyawan.nip', 'disposisi.nip')
                ->join('m_jabatan', 'm_jabatan.id_jabatan', 'karyawan.id_jabatan')
                ->distinct()
                ->where('status_disposisi', '!=', 'Belum disposisi')
                ->where('id_status', '!=', 5)
                ->orderBy('tanggal_surat', 'asc')
                ->get([
                    'm_surat_masuk.no_surat', 'm_surat_masuk.no_agenda', 'm_surat_masuk.dari', 'm_surat_masuk.kepada',
                    'm_surat_masuk.perihal', 'm_surat_masuk.lampiran', 'm_surat_masuk.tanggal_surat', 'm_surat_masuk.jenis_surat',
                    'm_surat_masuk.status_disposisi', 'm_jabatan.jabatan'
                ]);
        } elseif (auth()->user()->level == 'kepala_sekolah') {
            $jumlah = SuratMasuk::where('status_disposisi', '!=', 'Belum disposisi')->get('no_agenda')->count();
            $belum = SuratMasuk::where('status_disposisi', 'Dikirim')->orWhere('status_disposisi', 'Diproses')->get('status_disposisi')->count();
            $diterima = SuratMasuk::get('status_disposisi')->where('status_disposisi', 'Diterima')->count();
            $diarsipkan = SuratMasuk::join('disposisi', 'disposisi.no_agenda', 'm_surat_masuk.no_agenda')->distinct()->where('id_status', '5')->get('m_surat_masuk.no_agenda')->count();
            $disposisi = Disposisi::join('m_surat_masuk', 'm_surat_masuk.no_agenda', '=', 'disposisi.no_agenda')
                ->join('karyawan', 'karyawan.nip', 'disposisi.nip')
                ->join('m_jabatan', 'm_jabatan.id_jabatan', 'karyawan.id_jabatan')
                ->distinct()
                ->where('status_disposisi', '!=', 'Belum disposisi')
                ->where('id_status', '!=', 5)
                ->orderBy('tanggal_surat', 'asc')
                ->get([
                    'm_surat_masuk.no_surat', 'm_surat_masuk.no_agenda', 'm_surat_masuk.dari', 'm_surat_masuk.kepada',
                    'm_surat_masuk.perihal', 'm_surat_masuk.lampiran',
                    'm_surat_masuk.status_disposisi', 'm_surat_masuk.tanggal_surat', 'm_surat_masuk.jenis_surat', 'm_jabatan.jabatan'
                ]);
        } elseif (auth()->user()->level == 'disposisi') {
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
            $disposisi = Disposisi::join('m_surat_masuk', 'm_surat_masuk.no_agenda', '=', 'disposisi.no_agenda')
                ->join('karyawan', 'karyawan.nip', 'disposisi.nip')
                ->join('m_status', 'm_status.id_status', 'disposisi.id_status')
                ->distinct()->join('m_jabatan', 'm_jabatan.id_jabatan', 'karyawan.id_jabatan')
                ->orderBy('tanggal_surat', 'asc')
                ->where('karyawan.id_user', auth()->user()->id_user)
                ->where('status_disposisi', '=', 'Diterima')
                ->get([
                    'm_surat_masuk.no_surat', 'm_surat_masuk.no_agenda', 'm_surat_masuk.dari', 'm_surat_masuk.kepada',
                    'm_surat_masuk.perihal', 'm_surat_masuk.lampiran', 'm_surat_masuk.tanggal_surat',
                    'm_surat_masuk.status_disposisi', 'm_surat_masuk.jenis_surat', 'm_jabatan.jabatan'
                ]);
        }
        return view('admin.disposisi', compact('disposisi', 'jumlah', 'belum', 'diterima', 'diarsipkan', 'jabatan'));
        // dd($disposisi);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $no_agenda = SuratMasuk::find($id);
        if ($no_agenda->status_disposisi == 'Belum disposisi') {
            $status = Status::all();
            $kepada = Karyawan::join('m_jabatan', 'm_jabatan.id_jabatan', '=', 'karyawan.id_jabatan')
                ->where('jabatan', '!=', 'admin')
                ->Where('jabatan', '!=', 'tata usaha')
                ->Where('jabatan', '!=', 'kepala sekolah')
                ->get();

            return view('admin/create_disposisi', compact('no_agenda', 'status', 'kepada'));
        } else {
            return redirect('surat_masuk');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {

        // dd($request->nip);
        Disposisi::create($request->all());
        $masuk = SuratMasuk::find($id);
        $masuk->update([
            'status_disposisi' => 'Dikirim',
        ]);
        $disp = Disposisi::where('no_agenda', $id)->get();
        // dd($disp);
        foreach ($disp as $key => $value) {

            $value->update([
                'nip' => $request->nip
            ]);
        }
        return redirect('surat_masuk')->with('success', 'Surat berhasil dikirim kepada kepala sekolah untuk didisposisikan');
    }
    // public function kirim(Request $request, $id)
    // {
    //     Disposisi::create($request->all());
    //     $masuk = SuratMasuk::find($id);
    //     $masuk->update([
    //         'status_disposisi' => 'Dikirim',
    //     ]);
    //     $disp = Disposisi::where('no_agenda', $id)->get();
    //     // dd($disp);
    //     foreach ($disp as $key => $value) {
    //         $value->update([
    //             'nip' => null
    //         ]);
    //     }
    //     return redirect('surat_masuk');
    // }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        // $disposisi = Disposisi::join('m_surat_masuk', 'm_surat_masuk.no_surat', 'disposisi.no_surat')->where('disposisi.no_surat', $id)->get('disposisi.no_surat');
        // dd($ambil);
        $disposisi = Disposisi::join('karyawan', 'karyawan.nip', 'disposisi.nip')->join('m_status', 'm_status.id_status', 'disposisi.id_status')->join('m_jabatan', 'm_jabatan.id_jabatan', 'karyawan.id_jabatan')->where('no_surat', $id)->get();
        $karyawan = Karyawan::join('m_jabatan', 'm_jabatan.id_jabatan', 'karyawan.id_jabatan')->get();

        // $disposisi = Dis::find($id);
        // dd($disposisi);

        return view('disposisi/edit_disposisi', compact('disposisi', 'karyawan'));
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
        $updates = Disposisi::find($id);
        // dd($request->all());
        $updates->update($request->all());
        return redirect('disposisi');
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
