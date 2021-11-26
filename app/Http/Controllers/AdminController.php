<?php

namespace App\Http\Controllers;

use App\Models\Disposisi;
use App\Models\Jabatan;
use App\Models\Karyawan;
use App\Models\Status;
use App\Models\SuratMasuk;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
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
         $jumlah = SuratMasuk::get('no_surat')->count();
            $belum = SuratMasuk::get('status_disposisi')->where('status_disposisi', 'Belum disposisi')->count();
            $diterima = SuratMasuk::get('status_disposisi')->where('status_disposisi', 'Diterima')->count();
            $diarsipkan = SuratMasuk::join('disposisi', 'disposisi.no_agenda', 'm_surat_masuk.no_agenda')->distinct()->where('id_status', '5')->get('m_surat_masuk.no_agenda')->count();
        $masuk = SuratMasuk::orderBy('created_at', 'asc')->get();
        // dd($masuk);
        return view('admin/index', compact('masuk', 'jumlah', 'belum', 'diterima', 'diarsipkan', 'jabatan'));
    }
    public function arsip()
    {
        $jabatan = Karyawan::join('m_jabatan', 'm_jabatan.id_jabatan', 'karyawan.id_jabatan')
            ->where('id_user', auth()->user()->id_user)
            ->first()->jabatan;
        $user = auth()->user()->id_user;
        $tu = auth()->user()->level == 'tata_usaha';
        $cek_karyawan = Karyawan::where('id_user', $user)->first();
        $karyawan = $cek_karyawan->nip;
        $admin = auth()->user()->level == 'admin';
        $kepsek = auth()->user()->level == 'kepala_sekolah';
        $disposisi = auth()->user()->level == 'disposisi';

        //admin tu
        if ($admin or $tu) {
            $jumlah = SuratMasuk::get('no_surat')->count();
            $belum = SuratMasuk::get('status_disposisi')->where('status_disposisi', 'Belum disposisi')->count();
            $diterima = SuratMasuk::get('status_disposisi')->where('status_disposisi', 'Diterima')->count();
            $diarsipkan = SuratMasuk::join('disposisi', 'disposisi.no_agenda', 'm_surat_masuk.no_agenda')->distinct()->where('id_status', '5')->get('m_surat_masuk.no_agenda')->count();
            $sm = SuratMasuk::join('disposisi', 'disposisi.no_agenda', 'm_surat_masuk.no_agenda')->distinct()->where('id_status', '5')->get([
                'm_surat_masuk.no_agenda', 'm_surat_masuk.no_surat', 'm_surat_masuk.dari', 'm_surat_masuk.kepada',
                'm_surat_masuk.perihal', 'm_surat_masuk.perihal', 'm_surat_masuk.lampiran', 'm_surat_masuk.tanggal_surat', 'm_surat_masuk.jenis_surat'
            ]);
        }
        //kepsek
        elseif ($kepsek) {
            $jumlah = SuratMasuk::where('status_disposisi', '!=', 'Belum disposisi')->get('no_agenda')->count();
            $belum = SuratMasuk::where('status_disposisi', 'Dikirim')->orWhere('status_disposisi', 'Diproses')->get('status_disposisi')->count();
            $diterima = SuratMasuk::get('status_disposisi')->where('status_disposisi', 'Diterima')->count();
            $diarsipkan = SuratMasuk::join('disposisi', 'disposisi.no_agenda', 'm_surat_masuk.no_agenda')->distinct()->where('id_status', '5')->get('m_surat_masuk.no_agenda')->count();
            $sm = SuratMasuk::join('disposisi', 'disposisi.no_agenda', 'm_surat_masuk.no_agenda')->distinct()->where('id_status', '5')->get([
                'm_surat_masuk.no_agenda', 'm_surat_masuk.no_surat', 'm_surat_masuk.dari', 'm_surat_masuk.kepada',
                'm_surat_masuk.perihal', 'm_surat_masuk.perihal', 'm_surat_masuk.lampiran', 'm_surat_masuk.tanggal_surat', 'm_surat_masuk.jenis_surat'
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
                ->where('status_disposisi', 'Dikonfirmasi')
                ->distinct()
                ->get('no_surat')->count();
            $sm = SuratMasuk::join('disposisi', 'disposisi.no_agenda', '=', 'm_surat_masuk.no_agenda')
                ->join('karyawan', 'karyawan.nip', 'disposisi.nip')
                ->where('karyawan.id_user', auth()->user()->id_user)
                ->Where('status_disposisi', '=', 'Dikonfirmasi')
                ->distinct()->get([
                    'm_surat_masuk.no_agenda', 'm_surat_masuk.no_surat', 'm_surat_masuk.dari', 'm_surat_masuk.kepada',
                    'm_surat_masuk.perihal', 'm_surat_masuk.perihal', 'm_surat_masuk.lampiran', 'm_surat_masuk.tanggal_surat', 'm_surat_masuk.jenis_surat'
                ]);
        }

        return view('arsip', compact('sm', 'jumlah', 'belum', 'diterima', 'diarsipkan', 'jabatan'));
    }
    // public function arsip_detail($id)
    // {
    //     $sm = SuratMasuk::where('created_at', 'like', '%' . $id . '%')
    //         ->where('status_disposisi', '!=', 'Belum disposisi')->get();
    //     $tgl = $id;
    //     return view('arsip_detail', compact('sm', 'tgl'));
    // }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $jabatan = Karyawan::join('m_jabatan', 'm_jabatan.id_jabatan', 'karyawan.id_jabatan')
            ->where('id_user', auth()->user()->id_user)->first()->jabatan;
        $jumlah = SuratMasuk::get('no_surat')->count();
        $belum = SuratMasuk::get('status_disposisi')->where('status_disposisi', 'Belum disposisi')->count();
        $diterima = SuratMasuk::get('status_disposisi')->where('status_disposisi', 'Diterima')->count();
        $diarsipkan = SuratMasuk::join('disposisi', 'disposisi.no_agenda', 'm_surat_masuk.no_agenda')->distinct()->where('id_status', '5')->get('m_surat_masuk.no_agenda')->count();
        $show = SuratMasuk::where('no_agenda', $id)
            ->where('status_disposisi', '!=', 'Belum disposisi')->first();
        return view('admin.detail', compact('show', 'jumlah', 'belum', 'diterima', 'diarsipkan', 'jabatan'));
    }
    public function create()
    {
        $jabatan = Karyawan::join('m_jabatan', 'm_jabatan.id_jabatan', 'karyawan.id_jabatan')
            ->where('id_user', auth()->user()->id_user)->first()->jabatan;
        $nip = Jabatan::join('karyawan', 'karyawan.id_jabatan', '=', 'm_jabatan.id_jabatan')->where('jabatan', '=', 'Kepala Sekolah')->get(['karyawan.*', 'm_jabatan.jabatan']);
        $stat = Status::where('status', 'Diproses')->get('m_status.*');
        return view('admin/create', compact('nip', 'stat', 'jabatan'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'no_surat' => ['required', 'unique:m_surat_masuk'],
            'no_agenda' => ['required', 'unique:m_surat_masuk'],
            'dari' => ['required'],
            'kepada' => ['required'],
            'perihal' => ['required'],
            'lampiran' => ['required'],
            'tanggal_surat' => ['required'],
            'jenis_surat' => ['required'],
        ], [
            'no_surat.required' => 'Nomor Surat harap di isi',
            'no_surat.unique' => 'Nomor Surat harap di isi',
            'no_agenda.required' => 'Nomor Agenda harap di isi',
            'no_agenda.unique' => 'Nomor Agenda sudah ada',
            'dari.required' => 'harap di isi',
            'kepada.required' => 'harap di isi',
            'perihal.required' => 'harap di isi',
            'lampiran.required' => 'Lampiran harap di isi',
            'tanggal_surat.required' => 'Tanggal surat harap di isi',
            'jenis_surat.required' => 'Tanggal surat harap di isi',


        ]);
        if ($validator->fails()) {
            return redirect('create')
                ->withErrors($validator)
                ->withInput();
        }
        $nm = $request->lampiran;
        $namaFile = time() . rand(100, 9999) . "." . $nm->getClientOriginalExtension();

        $sm = [
            'no_surat' => $request->no_surat,
            'no_agenda' => $request->no_agenda,
            'dari' => $request->dari,
            'kepada' => $request->kepada,
            'perihal' => $request->perihal,
            'lampiran' => $namaFile,
            'tanggal_surat' => $request->tanggal_surat,
            'jenis_surat' => $request->jenis_surat,
        ];
        SuratMasuk::create($sm);
        $disp = [
            'no_agenda' => $request->no_agenda,
            'nip' => $request->nip,
            'id_status' => $request->id_status,
            'keterangan' => 'Surat Masuk'

        ];
        Disposisi::create($disp);
        $nm->move(public_path() . '/img', $namaFile);
        return redirect('surat_masuk')->with('success', 'Item created successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $jabatan = Karyawan::join('m_jabatan', 'm_jabatan.id_jabatan', 'karyawan.id_jabatan')
            ->where('id_user', auth()->user()->id_user)->first()->jabatan;
        $sm = SuratMasuk::find($id);
        if ($sm == "") {
            abort(404);
        } else
            // dd($sm);
            return view('admin/edit', compact('sm', 'jabatan'));
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
        // dd($request->all());
        $masuk = SuratMasuk::find($id);
        // dd($masuk);
        if ($request->file('lampiran') == "") {
            $masuk->update([
                'no_surat' => $request->no_surat,
                'dari' => $request->dari,
                'kepada' => $request->kepada,
                'perihal' => $request->perihal,
                'tanggal_surat' => $request->tanggal_surat,
                'jenis_surat' => $request->jenis_surat,
            ]);
        } else {
            // hapus old lampiran
            unlink('img/' . $masuk->lampiran);
            $nm = $request->lampiran;
            $namaFile = time() . rand(100, 9999) . "." . $nm->getClientOriginalExtension();
            $masuk->update([
                'no_surat' => $request->no_surat,
                'dari' => $request->dari,
                'kepada' => $request->kepada,
                'perihal' => $request->perihal,
                'lampiran' => $namaFile,
                'tanggal_surat' => $request->tanggal_surat,
                'jenis_surat' => $request->jenis_surat,
            ]);
            $nm->move('img/', $namaFile);
        }
        return redirect('surat_masuk')->with('success', 'surat berhasil di edit');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $masuk = SuratMasuk::find($id);
        unlink('img/' . $masuk->lampiran);
        $masuk->delete();
        return redirect('surat_masuk')->with('success', 'Surat berhasil dihapus');
    }
    public function track($id)
    {
        $jabatan = Karyawan::join('m_jabatan', 'm_jabatan.id_jabatan', 'karyawan.id_jabatan')
            ->where('id_user', auth()->user()->id_user)->first()->jabatan;
        $track = disposisi::join('m_surat_masuk', 'm_surat_masuk.no_agenda', '=', 'disposisi.no_agenda')
            ->join('m_status', 'm_status.id_status', '=', 'disposisi.id_status')
            ->where('m_surat_masuk.no_agenda', $id)
            ->orderBY('created_at', 'desc')->get(['disposisi.*', 'm_status.*']);
        $admin = auth()->user()->level == 'admin';
        $tu = auth()->user()->level == 'tata_usaha';
        $kepsek = auth()->user()->level == 'kepala_sekolah';

        if ($admin or $tu) {
           $jumlah = SuratMasuk::get('no_surat')->count();
            $belum = SuratMasuk::get('status_disposisi')->where('status_disposisi', 'Belum disposisi')->count();
            $diterima = SuratMasuk::get('status_disposisi')->where('status_disposisi', 'Diterima')->count();
            $diarsipkan = SuratMasuk::join('disposisi', 'disposisi.no_agenda', 'm_surat_masuk.no_agenda')->distinct()->where('id_status', '5')->get('m_surat_masuk.no_agenda')->count();
        }
        //kepsek
        elseif ($kepsek) {
            $jumlah = SuratMasuk::where('status_disposisi', '!=', 'Belum disposisi')->get('no_agenda')->count();
            $belum = SuratMasuk::where('status_disposisi', 'Dikirim')->orWhere('status_disposisi', 'Diproses')->get('status_disposisi')->count();
            $diterima = SuratMasuk::get('status_disposisi')->where('status_disposisi', 'Diterima')->count();
            $diarsipkan = SuratMasuk::join('disposisi', 'disposisi.no_agenda', 'm_surat_masuk.no_agenda')->distinct()->where('id_status', '5')->get('m_surat_masuk.no_agenda')->count();
        } else {
            $jumlah = SuratMasuk::join('disposisi', 'disposisi.no_agenda', 'm_surat_masuk.no_agenda')
                ->join('karyawan', 'karyawan.nip', 'disposisi.nip')
                ->where('status_disposisi', 'Diterima')
                ->orWhere('status_disposisi', 'Disetujui')
                ->orWhere('status_disposisi', 'Diarsipkan')
                ->orWhere('status_disposisi', 'Dikonfirmasi')
                ->where('karyawan.id_user', auth()->user()->id_user)->distinct()
                ->get('no_surat')->count();
            $belum = SuratMasuk::join('disposisi', 'disposisi.no_agenda', 'm_surat_masuk.no_agenda')
                ->join('karyawan', 'karyawan.nip', 'disposisi.nip')
                ->where('status_disposisi', '=', 'Disetujui')
                ->where('karyawan.id_user', auth()->user()->id_user)
                ->distinct()
                ->get('no_surat')->count();
            $diterima = SuratMasuk::join('disposisi', 'disposisi.no_agenda', 'm_surat_masuk.no_agenda')
                ->join('karyawan', 'karyawan.nip', 'disposisi.nip')
                ->where('status_disposisi', '!=', 'Dikirim')
                ->where('karyawan.id_user', auth()->user()->id_user)
                ->where('status_disposisi', 'Diterima')
                ->distinct()
                ->get('no_surat')->count();
            $diarsipkan = SuratMasuk::join('disposisi', 'disposisi.no_agenda', 'm_surat_masuk.no_agenda')
                ->join('karyawan', 'karyawan.nip', 'disposisi.nip')
                ->where('status_disposisi', '!=', 'Dikirim')
                ->where('karyawan.id_user', auth()->user()->id_user)
                ->Where('status_disposisi', 'Dikonfirmasi')
                ->distinct()
                ->get('no_surat')->count();
        }
        return view('track', compact('track', 'jabatan', 'jumlah', 'belum', 'diterima', 'diarsipkan'));
    }
    public function dashboard()
    {
        dd(auth()->user());
        $jabatan = Karyawan::join('m_jabatan', 'm_jabatan.id_jabatan', 'karyawan.id_jabatan')
            ->where('id_user', auth()->user()->id_user)->first()->jabatan;
        if (auth()->user()->level == 'admin' or auth()->user()->level == 'tata_usaha') {
            $lihat = SuratMasuk::where('status_disposisi', '!=', 'Belum disposisi')->get();
            return view('dashboard', compact('lihat', 'jabatan'));
        } elseif (auth()->user()->level == 'kepala_sekolah') {
            $lihat = SuratMasuk::where('status_disposisi', '!=', 'Belum disposisi')->get();
            return view('dashboard', compact('lihat', 'jabatan'));
        } elseif (auth()->user()->level == 'disposisi') {
            $id_user = auth()->user()->id_user;
            $lihat = SuratMasuk::join('disposisi', 'disposisi.no_agenda', 'm_surat_masuk.no_agenda')
                ->join('karyawan', 'karyawan.nip', 'disposisi.nip')
                ->where('id_user', $id_user)->distinct()
                ->where('status_disposisi', '!=', 'Diproses')
                ->where('status_disposisi', '!=', 'Dikirim')->distinct()
                ->get(['m_surat_masuk.no_agenda', 'm_surat_masuk.status_disposisi']);
            return view('dashboard', compact('lihat', 'jabatan'));
            // $lihat = SuratMasuk::where('status_disposisi', '!=', 'Belum disposisi')->get();
            // return view('admin/dashboard', compact('lihat'));
        }
    }

    public function download($id)
    {
        $img = "./img/$id";
        return response()->download($img);
    }
}
