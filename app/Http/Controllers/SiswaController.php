<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use Illuminate\Support\Facades\Storage;


class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $siswa = Siswa::latest()->paginate(5);

        return view ('siswa.index', compact('siswa'));
    }

    /**
     * create
     *
     * @return void
     */
    public function create()
    {
        return view('siswa.create');
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
            'nama'   => 'required',
            'kelas'   => 'required',
        ]);


        //create siswa
        siswa::create([
            'nama'   => $request->nama,
            'kelas'   => $request->kelas,
        ]);

        //redirect to index
        return redirect()->route('siswa.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    //**
     //* edit
     //*
     //* @param  mixed $siswa
     //* @return void
     //*/
    public function edit(siswa $siswa)
    {
        return view('siswa.edit', compact('siswa'));
    }

     /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $siswa
     * @return void
     */
    public function update(Request $request, siswa $siswa)
    {
        //validate form
        $this->validate($request, [ 
            'nama'     => 'required',
            'kelas'   => 'required',

        ]);

        $siswa->update([
            'nama'=>$request->input('nama'),
            'kelas'=>$request->input('kelas'),
        ]);

        //redirect to index
        return redirect()->route('siswa.index')->with(['success' => 'Data Berhasil Diubah!']);
    }

    public function destroy(Siswa $siswa)
    {
        $siswa->delete();
        //redirect to index
        return redirect()->route('siswa.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }
}
