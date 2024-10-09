@extends('layouts.master')

@section('title')
    Daftar Produk
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Daftar Produk</li>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="box">
            <div class="box-header with-border">
                <div class="">
                    <button onclick="addForm('{{ route('produk.store') }}')" class="btn btn-success btn-xs btn-flat"><i class="fa fa-plus-circle"></i> Tambah</button>
                    <button onclick="deleteSelected('{{ route('produk.delete_selected') }}')" class="btn btn-danger btn-xs btn-flat"><i class="fa fa-trash"></i> Hapus</button>
                    <button onclick="cetakBarcode('{{ route('produk.cetak_barcode') }}')" class="btn btn-info btn-xs btn-flat"><i class="fa fa-barcode"></i> Cetak Barcode</button>
                </div>
            </div>
            <div class="box-body table-responsive">
                <form action="" method="post" class="form-produk">
                    @csrf
                    <table class="table table-stiped table-bordered">
                        <thead>
                            <th width="5%">
                                <input type="checkbox" name="select_all" id="select_all">
                            </th>
                            <th width="5%">No</th>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>Kategori</th>
                            <th>Merk</th>
                            <th>Harga Beli</th>
                            <th>Harga Jual</th>
                            <th>Diskon</th>
                            <th>Stok</th>
                            <th>Keterangan</th>
                            <th width="15%"><i class="fa fa-cog"></i></th>
                        </thead>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>

@includeIf('produk.form')
@endsection

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@push('scripts')
<script>
    let table;

    $(function () {
        table = $('.table').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            autoWidth: false,
            ajax: {
                url: '{{ route('produk.data') }}',
            },
            columns: [
                {data: 'select_all', searchable: false, sortable: false},
                {data: 'DT_RowIndex', searchable: false, sortable: false},
                {data: 'kode_produk'},
                {data: 'nama_produk'},
                {data: 'nama_kategori'},
                {data: 'merk'},
                {data: 'harga_beli'},
                {data: 'harga_jual'},
                {data: 'diskon'},
                {data: 'stok'},
                {data: 'keterangan'},
                {data: 'aksi', searchable: false, sortable: false},
            ]
        });

        $('#modal-form').validator().on('submit', function (e) {
            if (! e.preventDefault()) {
                $.post($('#modal-form form').attr('action'), $('#modal-form form').serialize())
                .done((response) => {
                        $('#modal-form').modal('hide');
                        table.ajax.reload();
                        Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Produk berhasil disimpan',
                        confirmButtonText: 'Oke'
                    });
                    })
                    .fail((errors) => {
                        Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Tidak dapat menyimpan produk!',
                        confirmButtonText: 'Oke'
                    });
                    });
            }
        });

        $('[name=select_all]').on('click', function () {
            $(':checkbox').prop('checked', this.checked);
        });
        // untuk mengatur status semua checkbox (kotak centang) di halaman web sekaligus saat sebuah checkbox yang bernama select_all diklik.

       // Fungsi untuk memformat input dengan pemisah ribuan (titik)
        function formatCurrency(value) {
        return value    //Bagian ini menghapus semua karakter yang bukan angka dari value. Jadi, input akan diubah hanya menjadi angka.
            .replace(/\D/g, '') // Hanya angka
            .replace(/\B(?=(\d{3})+(?!\d))/g, "."); // Tambahkan titik sebagai pemisah ribuan
        };  //berfungsi untuk memformat nilai numerik menjadi format mata uang dengan pemisah ribuan berupa titik.

        
        $('#modal-form').on('keyup', '[name=harga_beli], [name=harga_jual]', function () {  //// Event keyup untuk otomatis memformat saat mengetik
            let value = $(this).val();
            $(this).val(formatCurrency(value)); // Format nilai saat mengetik
        });
        //Misalnya, jika pengguna mengetik 1000000 di salah satu field (harga_beli atau harga_jual), 
        //fungsi formatCurrency akan memformat input tersebut menjadi 1.000.000 secara otomatis saat pengguna melepas tombol pada keyboard.


        // Event submit untuk memastikan titik dihapus sebelum data dikirim ke server
        $('#modal-form').on('submit', function() {
            $('[name=harga_beli], [name=harga_jual]').each(function() {
                let value = $(this).val().replace(/\./g, '');       // metode yang digunakan untuk menghapus semua titik (.) dari nilai tersebut.
                $(this).val(value);     // Set nilai tanpa titik
            });                         //Jika pengguna memasukkan 1.000.000 ke dalam field harga_beli, saat disubmit, nilai yang dikirimkan akan menjadi 1000000.
        });

    });
        


    function addForm(url) {
        $('#modal-form').modal('show'); // untuk menampilkan modal (jendela pop-up)
        $('#modal-form .modal-title').text('Tambah Produk');

        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);      //menentukan ke mana data form akan dikirim saat form disubmit.
        $('#modal-form [name=_method]').val('post');
        $('#modal-form [name=nama_produk]').focus();
    }       //ini digunakan untuk mengatur tampilan dan isi dari sebuah modal form yang digunakan untuk menambah produk.

    function editForm(url) {
        $('#modal-form').modal('show'); // untuk menampilkan modal (jendela pop-up)
        $('#modal-form .modal-title').text('Edit Produk');

        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form [name=_method]').val('put');
        $('#modal-form [name=nama_produk]').focus();

        $.get(url)  //untuk mendapatkan data produk yang ingin diedit.
            .done((response) => {
                $('#modal-form [name=nama_produk]').val(response.nama_produk);  //memungkinkan pengguna untuk melihat dan mengedit informasi produk yang ada.
                $('#modal-form [name=id_kategori]').val(response.id_kategori);
                $('#modal-form [name=merk]').val(response.merk);
                $('#modal-form [name=harga_beli]').val(response.harga_beli);
                $('#modal-form [name=harga_jual]').val(response.harga_jual);
                $('#modal-form [name=diskon]').val(response.diskon);
                $('#modal-form [name=stok]').val(response.stok);
            })
            .fail((errors) => {
                alert('Tidak dapat menampilkan data');
                return;
            });
    }

    function deleteData(url) {
    Swal.fire({
        title: 'Yakin ingin menghapus produk?',
        text: "Data produk yang dihapus tidak dapat dipulihkan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
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
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: 'Produk dihapus',
                    confirmButtonText: 'Oke'
                });
            })
            .fail((errors) => {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: 'Tidak dapat menghapus produk!',
                    confirmButtonText: 'Oke'
                });
            });
        }
    });
}


    function deleteSelected(url) {
    if ($('input:checked').length >= 1) {
        Swal.fire({
            title: 'Yakin ingin menghapus produk yang dipilih?',
            text: "Data produk yang dihapus tidak dapat dipulihkan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.post(url, $('.form-produk').serialize())
                    .done((response) => {
                        table.ajax.reload();
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'Produk dihapus',
                            confirmButtonText: 'OK'
                        });
                    })
                    .fail((errors) => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: 'Tidak dapat menghapus produk!',
                            confirmButtonText: 'OK'
                        });
                    });
            }
        });
    } else {
        Swal.fire({
            icon: 'warning',
            title: 'Pilih data yang akan dihapus',
            text: 'Tidak ada data yang dipilih untuk dihapus',
            confirmButtonText: 'OK'
        });
    }
}


    function cetakBarcode(url) {
        if ($('input:checked').length < 1) {
            alert('Pilih data yang akan dicetak');
            return;
        } else if ($('input:checked').length < 3) {
            alert('Pilih minimal 3 data untuk dicetak');
            return;
        } else {
            $('.form-produk')
                .attr('target', '_blank')
                .attr('action', url)
                .submit();
        }
    }
</script>
@endpush