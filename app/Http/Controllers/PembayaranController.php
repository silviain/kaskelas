<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PembayaranController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        $pembayaran = Pembayaran::with('siswa')
        ->select('id_siswa', DB::raw('MAX(id) as id'), DB::raw('MAX(tgl_bayar) as tgl_bayar_last'), DB::raw('SUM(jumlah_bayar) as total_bayar'))
        ->groupBy('id_siswa')
        ->orderByDesc('tgl_bayar_last')
        ->paginate(5);

    return view('pembayaran.index', compact('pembayaran'));
    }


    public function history($id_siswa)
    {
        $pembayaran = Pembayaran::where('id_siswa', $id_siswa)->paginate(5);
        return view('pembayaran.history', compact('pembayaran'));
    }



       /**
     * create
     *
     * @return void
     */
    public function create()
    {
        $siswa = Siswa::all();
        return view('pembayaran.create', compact('siswa'));
    }

    /**
     * store
     *
     * @param Request $request
     * @return void
     */
    public function store(Request $request)
    {
        //validate form
        $this->validate($request, [

            'id_siswa'   => 'required',
            'tgl_bayar'   => 'required',
            'jumlah_bayar'   => 'required',
        ]);
        Pembayaran::create([
            'id_siswa'   => $request->input('id_siswa'),
            'tgl_bayar'   => $request->input('tgl_bayar'),
            'jumlah_bayar'   => $request->input('jumlah_bayar'),
        ]);

        //redirect to index
        return redirect()->route('pembayaran.index')->with(['success' => 'Pembayaran Berhasil Disimpan!']);

    }


    /**
     * edit
     *
     * @param  mixed $pembayaran
     * @return void
     */
    public function edit(Pembayaran $pembayaran)
    {
        $data= siswa::all();
        $bayar= pembayaran::all();
        return view('pembayaran.edit', compact('pembayaran', 'data', 'bayar'));
    }

     /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $post
     * @return void
     */
    public function update(Request $request, Pembayaran $pembayaran)
    {
        //validate form
        $this->validate($request, [

            'id_siswa'     => 'required',
            'tgl_bayar'   => 'required',
            'jumlah_bayar'   => 'required',

        ]);
        $pembayaran->update([
            'id_siswa' => $request->input('id_siswa'),
            'tgl_bayar' => $request->input('tgl_bayar'),
            'jumlah_bayar' => $request->input('jumlah_bayar'),
        ]);

        //redirect to index
        return redirect()->route('siswa.index')->with(['success' => 'Berhasil melakukan update']);
    }

    public function destroy(Pembayaran $pembayaran)
    {
        $pembayaran->delete();
        //redirect to index
        return redirect()->route('pembayaran.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }
}
