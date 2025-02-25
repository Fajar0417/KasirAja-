<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Penjualan;
use App\Models\PenjualanDetail;
use App\Models\Produk;
use App\Models\Setting;
use Illuminate\Http\Request;

class PenjualanDetailController extends Controller
{
    public function index()
    {
        $produk = Produk::orderBy('nama_produk')->get();
        // $member = Member::orderBy('nama')->get();
        $diskon = Setting::first()->diskon ?? 0;

        // Cek apakah ada transaksi yang sedang berjalan
        if ($id_penjualan = session('id_penjualan')) {
            $penjualan = Penjualan::find($id_penjualan);
            // $memberSelected = $penjualan->member ?? new Member();

            return view('penjualan_detail.index', compact('produk', 'diskon', 'id_penjualan', 'penjualan'));
        } else {
            if (auth()->user()->level == 1) {
                return redirect()->route('transaksi.baru');
            } else {
                return redirect()->route('home');
            }
        }
    }


    public function data($id)
    {
        $detail = PenjualanDetail::with('produk')
            ->where('id_penjualan', $id) // Pastikan menggunakan 'id_penjualan'
            ->get();

        $data = array();
        $total = 0;
        $total_item = 0;

        foreach ($detail as $item) {
            $row = array();
            $row['kode_produk'] = '<span class="label label-success">' . $item->produk['kode_produk'] . '</span>';
            $row['nama_produk'] = $item->produk['nama_produk'];
            $row['harga_jual'] = 'Rp. ' . format_uang($item->harga_jual);
            $row['jumlah'] = '<input type="number" class="form-control input-sm quantity" data-id="' . $item->id_penjualan_detail . '" value="' . $item->jumlah . '">';
            $row['diskon'] = $item->diskon . '%'; // Pastikan ada kolom 'diskon' di tabel 'penjualan_details'
            $row['stok'] = '<span class="stok">'.$item->produk->stok.'</span>';
            $row['subtotal'] = 'Rp. ' . format_uang($item->subtotal);
            $row['aksi'] = '<div class="btn-group">
                                <button onclick="deleteData(`' . route('transaksi.destroy', $item->id_penjualan_detail) . '`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
                            </div>';
            $data[] = $row;

            $total += ($item->harga_jual - ($item->harga_jual * $item->diskon / 100 )) * $item->jumlah;
            $total_item += $item->jumlah;
        }

        $data[] = [
            'kode_produk' => '
                <div class="total hide">' . $total . '</div>
                <div class="total_item hide">' . $total_item . '</div>',
            'nama_produk' => '',
            'harga_jual' => '',
            'jumlah' => '',
            'diskon' => '',
            'stok' => '',
            'subtotal' => '',
            'aksi' => '',
        ];

        return datatables()
            ->of($data)
            ->addIndexColumn()
            ->rawColumns(['aksi', 'kode_produk', 'jumlah','stok'])
            ->make(true);
    }

    public function store(Request $request)
    {

        $produk = Produk::where('kode_produk', $request->kode_produk)->first();
        if (!$produk) {
            return response()->json('Data gagal disimpan', 400);
        }

        if ($produk->stok < $request->jumlah) {
            return response()->json(['message' => 'Stok produk tidak mencukupi!'], 400);  // Kode 400 untuk error
        }

        $penjualanId = $request->id_penjualan ?? session('id_penjualan');
        if (!$penjualanId) {
         return response()->json(['message' => 'ID Penjualan tidak ditemukan'], 400);
        }
        
        // Cek apakah produk sudah ada dalam detail penjualan
        $detail = PenjualanDetail::where('id_penjualan', $penjualanId)  //id_penjualan: ID penjualan yang sedang aktif (biasanya digunakan untuk mengidentifikasi transaksi penjualan saat ini).
                    ->where('id_produk', $produk->id_produk)
                    ->first();  //akan mengembalikan satu baris data jika ada data yang sesuai dengan kriteria pencarian. Jika tidak ada, maka nilainya null.
    
        if ($detail) {
            // Jika produk sudah ada, perbarui jumlah dan subtotal
            $detail->jumlah += 1;
            $detail->subtotal = ($detail->harga_jual - ($detail->harga_jual * $detail->diskon / 100)) * $detail->jumlah;
            //Subtotal diperbarui: ($detail->harga_jual - ($detail->harga_jual * $detail->diskon / 100)) * $detail->jumlah; menghitung subtotal produk dengan memperhitungkan diskon.
            $detail->save();
        } else {    //jika $detail null, berarti produk tersebut belum ada dalam daftar penjualan, sehingga sistem akan membuat entri baru:
            // Jika produk belum ada, buat detail baru
        $detail = new PenjualanDetail();
        $detail->id_penjualan = $request->id_penjualan; // Pastikan ini id_penjualan
        $detail->id_produk = $produk->id_produk;
        $detail->harga_jual = $produk->harga_jual;
        $detail->diskon = $produk->diskon; // Mengambil diskon dari model Produk
        $detail->jumlah = 1;  
        $detail->subtotal = ($produk->harga_jual - ($produk->harga_jual * $produk->diskon / 100)) * $detail->jumlah;
        $detail->save();
        }
        return response()->json('Data berhasil disimpan', 200);
    }
    //Mendeteksi apakah produk yang dimasukkan pengguna sudah ada di detail penjualan.
    //Jika produk sudah ada, jumlahnya akan diperbarui, dan subtotal dihitung ulang.
    //Jika produk belum ada, sistem akan membuat entri baru di detail penjualan dengan jumlah awal 1 dan subtotal berdasarkan harga dan diskon produk.


    public function update(Request $request, $id)
    {
        $detail = PenjualanDetail::find($id);
        $detail->jumlah = $request->jumlah;
        $detail->subtotal = $detail->harga_jual * $request->jumlah;
        $detail->update();
    }


    public function destroy($id)
    {
        $detail = PenjualanDetail::find($id);
        $detail->delete();

        return response(null, 204);
    }


    public function loadform($diskon = 0, $total, $diterima)
    {
        $id_penjualan = session('id_penjualan'); // Ambil ID penjualan dari session
        $detailPenjualan = PenjualanDetail::where('id_penjualan', $id_penjualan)->get();
    
        
        $totalDiskon = 0;
        
        foreach ($detailPenjualan as $item) {
            // Hitung diskon per item
            $diskonItem = ($item->diskon / 100) * $item->harga_jual * $item->jumlah;
            $totalDiskon += $diskonItem; // Tambahkan ke total diskon
        }
        
        $bayar = $total - ($diskon / 100 * $total);
        $kembali = ($diterima != 0) ? $diterima - $bayar : 0;

        $data = [
            'totalrp' => format_uang($total),
            'diskonrp' => format_uang($totalDiskon),
            'bayar' => $bayar,
            'bayarrp' => format_uang($bayar),
            'terbilang' => ucwords(terbilang($bayar) . ' Rupiah'),
            'kembalirp' => format_uang($kembali),
            'kembali_terbilang'=> ucwords(terbilang($kembali). 'Rupiah'),
        ];

        return response()->json($data);
    }


    public function checkStok($id_produk, $jumlah)
    {
        $produk = Produk::find($id_produk);

        if ($produk->stok < $jumlah) {
            return response()->json([
                'status' => 'error',
                'message' => 'Jumlah yang diminta melebihi stok yang tersedia!',
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Stok tersedia!',
        ]);
    }

}
