<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use App\Models\Produk;
use PDF;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kategori = Kategori::all()->pluck('nama_kategori', 'id_kategori'); //Tujuan: Mengambil semua data dari tabel Kategori dan memformatnya menjadi koleksi dengan kunci dan nilai tertentu.

        return view('produk.index', compact('kategori'));       // Menggunakan fungsi compact() untuk mengirimkan variabel $kategori ke tampilan. 
                                                                //Ini berarti di dalam tampilan produk.index, Anda bisa menggunakan variabel $kategori untuk mengakses data kategori yang telah diambil.
    }

    public function data()
    {
        $produk = Produk::leftJoin('kategori', 'kategori.id_kategori', 'produk.id_kategori')        //Ini berarti akan mengambil semua data dari tabel produk dan mencocokkan dengan data di tabel kategori berdasarkan kolom id_kategori. Jika tidak ada kecocokan, data dari tabel kategori akan bernilai null.
            ->select('produk.*', 'nama_kategori')       //Memilih semua kolom dari tabel produk (produk.*) serta kolom nama_kategori dari tabel kategori
            // ->orderBy('kode_produk', 'asc')
            ->get();

        return datatables() //datatables(): Ini adalah metode dari plugin Yajra DataTables untuk Laravel yang memudahkan integrasi dengan DataTables.
            ->of($produk)       //Menginformasikan bahwa data yang akan diolah adalah data produk yang telah diambil sebelumnya.
            ->addIndexColumn()  //Menambahkan kolom indeks secara otomatis yang menunjukkan nomor urut baris.
            ->addColumn('select_all', function ($produk) {      //Menambahkan kolom checkbox dengan nama id_produk[].
                return '
                    <input type="checkbox" name="id_produk[]" value="'. $produk->id_produk .'">     
                ';
            })
            ->addColumn('kode_produk', function ($produk) {     //Menambahkan kolom yang menampilkan kode_produk
                return '<span class="label label-success">'. $produk->kode_produk .'</span>';
            })
            ->addColumn('harga_beli', function ($produk) {      //Menambahkan kolom yang menampilkan harga beli produk
                return format_uang($produk->harga_beli);
            })
            ->addColumn('harga_jual', function ($produk) {      //Menambahkan kolom yang menampilkan harga jual produk
                return format_uang($produk->harga_jual);
            })
            ->addColumn('stok', function ($produk) {            //Menambahkan kolom yang menampilkan stok produk
                return format_uang($produk->stok);
            })
            ->addColumn('aksi', function ($produk) {
                return '
                <div class="btn-group">
                    <button type="button" onclick="editForm(`'. route('produk.update', $produk->id_produk) .'`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-pencil"></i></button>
                    <button type="button" onclick="deleteData(`'. route('produk.destroy', $produk->id_produk) .'`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
                </div>
                ';
            })
            ->rawColumns(['aksi', 'kode_produk', 'select_all'])
            ->make(true);
    }
    //Fungsi data() ini bertujuan untuk mengambil data produk dari database, mengolahnya dengan menambahkan kolom kustom untuk keperluan tampilan, dan mengembalikannya dalam format yang bisa dipahami oleh DataTables. 
    //Ini memungkinkan pengguna untuk melihat daftar produk dengan informasi lengkap dan melakukan tindakan seperti mengedit atau menghapus produk dengan mudah.

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
    public function store(Request $request)
    {
        $produk = Produk::latest()->first() ?? new Produk();
        $request['kode_produk'] = 'P'. tambah_nol_didepan((int)$produk->id_produk +1, 6);

        $produk = Produk::create($request->all());

        return response()->json('Data berhasil disimpan', 200);
    }
    //Fungsi store() ini bertujuan untuk:

    //Mengambil data produk terbaru dari database untuk menentukan kode_produk selanjutnya.
    //Menghasilkan kode_produk dengan format yang diinginkan.
    //Menyimpan data produk baru ke dalam tabel produk.
    //Mengembalikan respons yang menginformasikan bahwa data berhasil disimpan.
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $produk = Produk::find($id);

        return response()->json($produk);
    }
    //Fungsi show() ini bertujuan untuk:

    //Mengambil data produk dari database berdasarkan ID yang diberikan.
    //Mengembalikan data produk tersebut dalam format JSON, sehingga dapat 
    //digunakan di sisi klien (misalnya, untuk ditampilkan dalam antarmuka 
    //pengguna atau untuk digunakan dalam aplikasi frontend).

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
        $produk = Produk::find($id);
        $produk->update($request->all());

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
        $produk = Produk::find($id);
        $produk->delete();

        return response(null, 204);
    }

    public function deleteSelected(Request $request)
    {
        foreach ($request->id_produk as $id) {
            $produk = Produk::find($id);
            $produk->delete();
        }

        return response(null, 204);
    }

    public function cetakBarcode(Request $request)
    {
        $dataproduk = array();
        foreach ($request->id_produk as $id) {
            $produk = Produk::find($id);
            $dataproduk[] = $produk;
        }

        $no  = 1;
        $pdf = PDF::loadView('produk.barcode', compact('dataproduk', 'no'));
        $pdf->setPaper('a4', 'potrait');
        return $pdf->stream('produk.pdf');
    }
}