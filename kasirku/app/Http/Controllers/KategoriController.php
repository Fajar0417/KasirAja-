<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('kategori.index');
    }

    public function data()
    {
        $kategori = Kategori::orderBy('id_kategori', 'desc')->get();    //Mengambil semua data kategori dari tabel kategori, diurutkan berdasarkan id_kategori dalam urutan menurun (dari yang terbaru ke yang terlama).

        return datatables()
            ->of($kategori)
            ->addIndexColumn()      //Menambahkan kolom indeks ke DataTables, yang biasanya digunakan untuk menampilkan nomor urut baris secara otomatis.
            ->addColumn('aksi', function ($kategori) {  //Menambahkan kolom baru bernama 'aksi'.  Fungsi ini menerima parameter $kategori, yang merupakan objek kategori
                return '
                <div class="btn-group">
                    <button onclick="editForm(`'. route('kategori.update', $kategori->id_kategori) .'`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-pencil"></i></button>
                    <button onclick="deleteData(`'. route('kategori.destroy', $kategori->id_kategori) .'`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
                </div>
                ';
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }
    //Fungsi index() bertugas menampilkan halaman kategori, sementara fungsi data() mengatur pengambilan dan pemformatan data kategori untuk ditampilkan dalam DataTable. Fungsi data() mengimplementasikan fitur seperti pengurutan, penambahan kolom aksi untuk edit dan hapus, serta mengembalikan data dalam format yang dapat digunakan oleh DataTables. Jika ada yang ingin ditanyakan lebih lanjut, silakan beri tahu!

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
    public function store(Request $request) //untuk menyimpan data kategori. Parameter $request adalah instance dari Request, yang berisi data yang dikirimkan dari form.
    {
        $kategori = new Kategori();
        $kategori->nama_kategori = $request->nama_kategori; //Mengambil data nama_kategori dari request yang dikirimkan (dari form).
        $kategori->save();

        return response()->json('Data berhasil disimpan', 200);
    }
    //Fungsi store ini menangani logika untuk menyimpan data kategori baru. Ia membuat instance kategori baru, mengisi data yang diterima dari request, menyimpannya ke dalam database, dan akhirnya mengembalikan respons JSON untuk memberi tahu klien bahwa data telah berhasil disimpan. Jika ada yang ingin ditanyakan lebih lanjut, silakan beri tahu!


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $kategori = Kategori::find($id);    //Metode find digunakan untuk mencari entri dalam tabel kategori berdasarkan ID yang diberikan.

        return response()->json($kategori);
    }

    //Fungsi show ini menangani logika untuk mengambil dan menampilkan data kategori berdasarkan ID yang diberikan. Fungsi ini mencari kategori di database dan mengembalikan hasilnya dalam format JSON. Jika kategori ditemukan, data kategori akan dikembalikan; jika tidak, respons JSON akan mengandung null. Jika ada yang ingin ditanyakan lebih lanjut, silakan beri tahu!
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
        $kategori = Kategori::find($id);
        $kategori->nama_kategori = $request->nama_kategori;
        $kategori->update();

        return response()->json('Data berhasil disimpan', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $kategori = Kategori::find($id);
        $kategori->delete();

        return response(null, 204);
    }
}