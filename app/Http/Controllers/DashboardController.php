<?php

namespace App\Http\Controllers;

// use App\Models\member;
use App\Models\produk;
use App\Models\kategori;
use App\Models\Supplier;
use App\Models\Pembelian;
use App\Models\Penjualan;
use App\Models\Pengeluaran;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Illuminate\Http\Request;
use PDF;

class DashboardController extends Controller
{
    public function index()
    {

        $kategori = kategori::count();
        $produk   = produk::count();
        $supplier = Supplier::count();
        // $member   = member::count();

        $tanggal_awal_asli = date('Y-m-01');
        $tanggal_akhir_asli = date('Y-m-d');

        $tanggal_awal = $tanggal_awal_asli;
        $tanggal_akhir= $tanggal_akhir_asli;

        $data_tanggal = array();
        $data_pendapatan= array();
        $totalRevenue = 0;

        while (strtotime($tanggal_awal) <= strtotime($tanggal_akhir)) {
            $data_tanggal [] =(int) substr($tanggal_awal, 8, 2) ;
         

            $total_penjualan = Penjualan::where('created_at', 'LIKE', "%$tanggal_awal%")->sum('bayar');
            $total_pembelian = Pembelian::where('created_at', 'LIKE', "%$tanggal_awal%")->sum('bayar');
            $total_pengeluaran = Pengeluaran::where('created_at', 'LIKE', "%$tanggal_awal%")->sum('nominal');

            $pendapatan = $total_penjualan - $total_pembelian - $total_pengeluaran;
            $data_pendapatan []= $pendapatan;

            $totalRevenue += $pendapatan;

            $tanggal_awal = date('Y-m-d', strtotime("+1 day", strtotime($tanggal_awal)));
        }

        if (auth()->user()->level==1) {
           return view('admin.dashboard', compact('kategori','produk','supplier', 'tanggal_awal_asli', 'tanggal_akhir_asli','data_tanggal','data_pendapatan', 'totalRevenue'));
        } else {
            return view('kasir.dashboard', compact('produk'));
        }
    }

//     public function exportPDF()
// {
//     // Fetch data for the revenue graph
//     $tanggal_awal_asli = date('Y-m-01');
//     $tanggal_akhir_asli = date('Y-m-d');
    
//     $tanggal_awal = $tanggal_awal_asli;
//     $tanggal_akhir = $tanggal_akhir_asli;

//     $data_tanggal = [];
//     $data_pendapatan = [];

//     while (strtotime($tanggal_awal) <= strtotime($tanggal_akhir)) {
//         $data_tanggal[] = (int) substr($tanggal_awal, 8, 2);

//         $total_penjualan = Penjualan::where('created_at', 'LIKE', "%$tanggal_awal%")->sum('bayar');
//         $total_pembelian = Pembelian::where('created_at', 'LIKE', "%$tanggal_awal%")->sum('bayar');
//         $total_pengeluaran = Pengeluaran::where('created_at', 'LIKE', "%$tanggal_awal%")->sum('nominal');

//         $pendapatan = $total_penjualan - $total_pembelian - $total_pengeluaran;
//         $data_pendapatan[] = $pendapatan;

//         $tanggal_awal = date('Y-m-d', strtotime("+1 day", strtotime($tanggal_awal)));
//     }

//     // Load the view for the PDF with the necessary data
//     $pdf = FacadePdf::loadView('admin.pdf', compact('data_tanggal', 'data_pendapatan'));
    
//     // Return the PDF as a download
//     return $pdf->stream('Data Pendapatan.pdf');
// }

}
