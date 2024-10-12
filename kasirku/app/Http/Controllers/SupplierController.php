<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Models\Setting;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('supplier.index');
    }

    public function data()
    {
        $supplier = Supplier::orderBy('kode_supplier')->get();

        return datatables()
            ->of($supplier)
            ->addIndexColumn()
            ->addColumn('select_all', function ($produk) {
                return '
                    <input type="checkbox" name="id_supplier[]" value="'. $produk->id_supplier .'">
                ';
            })
            ->addColumn('kode_supplier', function ($supplier) {
                return '<span class="label label-success">'. $supplier->kode_supplier .'<span>';
            })
            ->addColumn('aksi', function ($supplier) {
                return '
                <div class="btn-group">
                    <button type="button" onclick="editForm(`'. route('supplier.update', $supplier->id_supplier) .'`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-pencil"></i></button>
                    <button type="button" onclick="deleteData(`'. route('supplier.destroy', $supplier->id_supplier) .'`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
                </div>
                ';
            })
            ->rawColumns(['aksi', 'select_all', 'kode_supplier'])
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
        $supplier = Supplier::latest()->first() ?? new Supplier();
        $kode_supplier = (int) $supplier->kode_supplier +1;

        $supplier = new Supplier();
        $supplier->kode_supplier = tambah_nol_didepan($kode_supplier, 5);
        $supplier->nama = $request->nama;
        $supplier->telepon = $request->telepon;
        $supplier->alamat = $request->alamat;
        $supplier->save();

        return response()->json('Data berhasil disimpan', 200);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $supplier = Supplier::find($id);

        return response()->json($supplier);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
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
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $supplier = Supplier::find($id)->update($request->all());

        return response()->json('Data berhasil disimpan', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $supplier = Supplier::find($id);
        $supplier->delete();

        return response(null, 204);
    }

    // public function cetakMember(Request $request)
    // {
    //     $datamember = collect(array());
    //     foreach ($request->id_member as $id) {
    //         $member = Member::find($id);
    //         $datamember[] = $member;
    //     }

    //     $datamember = $datamember->chunk(2);
    //     $setting    = Setting::first();

    //     $no  = 1;
    //     $pdf = PDF::loadView('member.cetak', compact('datamember', 'no', 'setting'));
    //     $pdf->setPaper(array(0, 0, 566.93, 850.39), 'potrait');
    //     return $pdf->stream('member.pdf');
    // }
}