<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\kategori;

class kategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     * @return \Iluminate\Http\response
     */


    public function index()
    {
        return view('kategori.index');
    }
    //Fungsi ini bertugas untuk menampilkan halaman index dari kategori. Ketika URL yang sesuai diakses, 
    //fungsi ini akan memanggil dan merender tampilan kategori/index untuk ditampilkan kepada pengguna.

    public function data()  //Fungsi ini bertugas untuk menyiapkan data yang akan ditampilkan di tabel dalam bentuk yang kompatibel dengan Datatables.
        {
           $kategori = kategori::orderBy('id_kategori', 'desc')->get(); //Kode ini mengambil data dari model kategori menggunakan metode orderBy. Data diurutkan berdasarkan kolom id_kategori secara desc (descending, urutan menurun).
                                                                        //Metode get() digunakan untuk mengambil semua data yang cocok dengan kriteria tersebut dalam bentuk koleksi.

           return datatables()  //adalah fungsi yang digunakan untuk memproses data sehingga bisa digunakan oleh Datatables.
           ->of($kategori)  //menunjukkan bahwa data yang diproses oleh Datatables adalah data dari model kategori yang sebelumnya diambil dari database.
           ->addIndexColumn()   //Fungsi ini menambahkan kolom indeks secara otomatis pada tabel. Ini sering digunakan untuk menampilkan nomor urut pada baris pertama setiap data dalam tabel Datatables.
           ->addColumn('aksi', function ($kategori) {
               return '
               <div class="btn-group">  
                   <button onclick="editForm(`'. route('kategori.update', $kategori->id_kategori) .'`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-pencil"></i></button>  
                   <button onclick="deleteData(`'. route('kategori.destroy', $kategori->id_kategori) .'`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
               </div>
               ';
               //Tombol ini menjalankan fungsi JavaScript editForm()
               //Tombol ini menjalankan fungsi JavaScript deleteData()
           })
           ->rawColumns(['aksi'])
           ->make(true);
           //Fungsi data() ini bertanggung jawab untuk mengambil data kategori dari database, memformatnya agar kompatibel dengan Datatables, 
           //dan menambahkan kolom aksi dengan tombol untuk mengedit dan menghapus setiap entri kategori. 
           //Data ini kemudian dikembalikan dalam format JSON agar dapat ditampilkan secara dinamis di tabel frontend yang menggunakan Datatables.
        }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     * 
     * @param \Iluminate\Http\Request
     * @return \Iluminate\Http\Response
     * 
     */
    public function store(Request $request) // fungsi store yang digunakan untuk menyimpan data kategori ke dalam database menggunakan Laravel
    {
        $kategori = new kategori(); //Baris ini membuat objek baru dari model kategori.
        $kategori->nama_kategori = $request->nama_kategori; //Mengisi nama kategori dari data yang diterima.
        $kategori->save();  //digunakan untuk menyimpan objek $kategori ke dalam database.

       return response()->json('Data berhasil disimpan', 200); 
    }

    /**
     * Display the specified resource.
     */
    public function show($id)   //Fungsi show ini digunakan untuk menampilkan data kategori berdasarkan ID yang diterima.
    {
        $kategori = Kategori::find($id);    //Fungsi ini menerima satu parameter, yaitu $id, yang merupakan ID kategori yang ingin ditampilkan.
                                            //Metode find() akan mengembalikan objek Kategori yang sesuai dengan ID tersebut, atau null jika tidak ditemukan.
        return response()->json($kategori); //Fungsi ini mencari data kategori berdasarkan ID yang diterima, lalu mengembalikan hasilnya dalam bentuk JSON.
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)    //Request $request: Berisi data baru yang dikirim pengguna untuk memperbarui kategori.
    {                                                       //string $id: ID dari kategori yang ingin diperbarui.
        $kategori = Kategori::find($id);    //Fungsi ini mencari data kategori di database berdasarkan ID
        $kategori->nama_kategori = $request->nama_kategori; // Mengambil data baru dari request (yaitu nama_kategori) dan mengisi properti nama_kategori dari objek $kategori yang sudah ditemukan.
        $kategori->update();

        return response()->json('Data berhasil disimpan', 200);
    }

   /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id) //Fungsi menerima satu parameter, yaitu ID kategori yang ingin dihapus.
    {
        try {
            $kategori = Kategori::findOrFail($id);
            $kategori->delete();
        } catch (\Exception $e) {
            return response()->json(['message' => 'Tidak dapat menghapus data'], 500);
        }
    }   //Operator -> digunakan dalam PHP untuk:
   // Mengakses properti (variabel) dari sebuah objek.
   // Memanggil metode (fungsi) dari sebuah objek.
}
