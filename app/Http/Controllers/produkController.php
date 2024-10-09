<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use App\Models\Produk;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
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
        $kategori = Kategori::all()->pluck('nama_kategori', 'id_kategori');
        //Kategori::all(): Memanggil model Kategori untuk mengambil semua data dari tabel kategori di basis data.
        //Menggunakan metode pluck() untuk mengambil kolom nama_kategori dan id_kategori
        return view('produk.index', compact('kategori'));
        //Fungsi compact() digunakan untuk mengubah variabel $kategori menjadi array yang dapat diteruskan ke tampilan.
    }

    public function data()
    {
        $produk = Produk::leftJoin('kategori', 'kategori.id_kategori', 'produk.id_kategori')    //Menggunakan leftJoin untuk menggabungkan tabel produk dengan tabel kategori berdasarkan ID kategori.
            ->select('produk.*', 'nama_kategori')       // Memilih semua kolom dari tabel produk dan kolom nama_kategori dari tabel kategori.
            ->get();
    
        return datatables()
            ->of($produk)
            ->addIndexColumn()
            ->addColumn('select_all', function ($produk) {
                return '
                    <input type="checkbox" name="id_produk[]" value="'. $produk->id_produk .'">
                ';
            })
            ->addColumn('kode_produk', function ($produk) {
                return '<span class="label label-success">'. $produk->kode_produk .'</span>';
            })
            ->addColumn('harga_beli', function ($produk) {
                // Format angka dengan pemisah ribuan
                return number_format($produk->harga_beli, 0, ',', '.');
            })
            ->addColumn('harga_jual', function ($produk) {
                // Format angka dengan pemisah ribuan
                return number_format($produk->harga_jual, 0, ',', '.');
            })
            ->addColumn('stok', function ($produk) {
                return format_uang($produk->stok); // Gunakan helper format_uang jika sudah ada
            })
            ->addColumn('keterangan', function ($produk) {
                if ($produk->stok > 50) {
                    return '<span class="label label-primary">Stok Banyak</span>'; // Blue for "Stok Banyak"
                } elseif ($produk->stok > 20) {
                    return '<span class="label label-success">Stok Cukup</span>'; // Green for "Stok Cukup"
                } elseif ($produk->stok > 0) {
                    return '<span class="label label-warning">Stok Menipis</span>'; // Yellow for "Stok Menipis"
                } else {
                    return '<span class="label label-danger">Stok Habis</span>'; // Red for "Stok Habis"
                }
            })
            ->addColumn('aksi', function ($produk) {
                return '
                <div class="btn-group">
                    <button type="button" onclick="editForm(`'. route('produk.update', $produk->id_produk) .'`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-pencil"></i></button>
                    <button type="button" onclick="deleteData(`'. route('produk.destroy', $produk->id_produk) .'`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
                </div>
                ';
            })
            ->rawColumns(['aksi', 'kode_produk', 'select_all', 'keterangan'])
            ->make(true);
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
    public function store(Request $request)
    {
        // Hilangkan titik pada harga_beli dan harga_jual sebelum disimpan
        $request->merge([
            'harga_beli' => str_replace('.', '', $request->harga_beli), //str_replace('.', '', $request->harga_beli): Menghilangkan semua titik dari string harga beli.
            'harga_jual' => str_replace('.', '', $request->harga_jual), //  Ini biasanya dilakukan untuk mengubah format harga dari yang memiliki pemisah ribuan (misalnya, "1.500") menjadi format yang bisa diterima oleh basis data (misalnya, "1500").
        ]);
    
        $produk = Produk::latest()->first() ?? new Produk();    //Mengambil produk terakhir yang ditambahkan ke basis data berdasarkan ID produk yang tertinggi. Jika tidak ada produk, akan membuat objek Produk baru (in case tabel produk masih kosong).
        $request['kode_produk'] = 'P' . tambah_nol_didepan((int)$produk->id_produk + 1, 6);
            //(int)$produk->id_produk + 1: Menambah 1 pada ID produk terakhir untuk menghasilkan ID baru. contoh 000001, 000002 dan seterusnya
        $produk = Produk::create($request->all());
    
        return response()->json('Data berhasil disimpan', 200);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)   //untuk mencari dan mengambil data produk berdasarkan ID yang diberikan.
    {
        $produk = Produk::find($id);

        return response()->json($produk);
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
    // Hilangkan titik pada harga_beli dan harga_jual sebelum disimpan
    $request->merge([
        'harga_beli' => str_replace('.', '', $request->harga_beli),
        'harga_jual' => str_replace('.', '', $request->harga_jual),
    ]);

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
        $pdf = FacadePdf::loadView('produk.barcode', compact('dataproduk', 'no'));
        $pdf->setPaper('a4', 'potrait');
        return $pdf->stream('produk.pdf');
    }
}