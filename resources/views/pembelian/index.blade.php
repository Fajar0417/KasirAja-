@extends('layouts.master')

@section('title')
    Daftar Pembelian
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Daftar Pembelian</li>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="box">
            <div class="box-header with-border">
                <button onclick="addForm()" class="btn btn-success btn-xs btn-flat"><i class="fa fa-plus-circle"></i> Transaksi Baru</button>
                <!-- Fungsi ini biasanya berisi logika untuk melakukan suatu tindakan, seperti menampilkan form baru, menambahkan transaksi baru, atau melakukan sesuatu yang relevan dengan aplikasi. -->
                @empty(! session('id_pembelian'))
                <a href="{{ route('pembelian_detail.index') }}" class="btn btn-info btn-xs btn-flat"><i class="fa fa-pencil"></i> Transaksi Aktif</a>
                @endempty
            </div>
            <div class="box-body table-responsive">
                <table class="table table-stiped table-bordered table-pembelian">
                    <thead>
                        <th width="5%">No</th>
                        <th>Tanggal</th>
                        <th>Supplier</th>
                        <th>Total Item</th>
                        <th>Total Harga</th>
                        <th>Diskon</th>
                        <th>Total Bayar</th>
                        <th width="15%"><i class="fa fa-cog"></i></th>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

@includeIf('pembelian.supplier')
@includeIf('pembelian.detail')
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    let table, table1;

    $(function () {
        table = $('.table-pembelian').DataTable({
            processing: true,   //Menampilkan indikator pemrosesan (loading)
            autoWidth: false,   //Menonaktifkan penyesuaian otomatis lebar kolom. 
            ajax: {
                url: '{{ route('pembelian.data') }}',   //Ini adalah URL endpoint yang akan dipanggil untuk mengambil data. {{ route('pembelian.data') }} adalah sintaks Laravel yang menghasilkan URL untuk route yang ditentukan.
            },
            columns: [  //Mendefinisikan kolom-kolom yang akan ditampilkan di tabel.
                {data: 'DT_RowIndex', searchable: false, sortable: false},  //Menampilkan indeks baris
                {data: 'tanggal'},
                {data: 'supplier'},
                {data: 'total_item'},
                {data: 'total_harga'},
                {data: 'diskon'},
                {data: 'bayar'},
                {data: 'aksi', searchable: false, sortable: false},
            ]
        });

        $('.table-supplier').DataTable();   //Dihapus juga tidak apa- apa
        table1 = $('.table-detail').DataTable({
            processing: true,
            bSort: false,
            dom: 'Brt',
            columns: [
                {data: 'DT_RowIndex', searchable: false, sortable: false},
                {data: 'kode_produk'},
                {data: 'nama_produk'},
                {data: 'harga_beli'},
                {data: 'jumlah'},
                {data: 'subtotal'},
            ]
        })
    });

    function addForm() {
        $('#modal-supplier').modal('show');
    }

    function showDetail(url) {
        $('#modal-detail').modal('show');

        table1.ajax.url(url);
        table1.ajax.reload();
    }

    function deleteData(url) {
    Swal.fire({
        title: 'Yakin ingin menghapus data terpilih?',
        text: "Data yang dihapus tidak bisa dipulihkan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Hapus',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            $.post(url, {
                '_token': $('[name=csrf-token]').attr('content'),
                '_method': 'delete'
            })
            .done((response) => {
                table.ajax.reload();
                Swal.fire('Terhapus!', 'Data berhasil dihapus.', 'success');
            })
            .fail((errors) => {
                Swal.fire('Gagal!', 'Tidak dapat menghapus data.', 'error');
            });
        }
    });
}

</script>
@endpush