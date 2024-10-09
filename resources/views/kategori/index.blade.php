@extends('layouts.master')

@section('title')
    Daftar Kategori
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Daftar Kategori</li> 
@endsection
<!-- Breadcrumb adalah jejak navigasi yang menunjukkan posisi pengguna dalam hierarki situs, seperti: Home > Kategori > Daftar Kategori. -->
@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="box">
            <div class="box-header with-border">
                <button onclick="addForm('{{ route('kategori.store') }}')" class="btn btn-success btn-xs btn-flat"><i class="fa fa-plus-circle"></i> Tambah</button>
            </div>
            <div class="box-body table-responsive">
                <table class="table table-stiped table-bordered">
                    <thead>
                        <th width="5%">No</th>
                        <th>Kategori</th>
                        <th width="15%"><i class="fa fa-cog"></i></th>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    
</div>

@includeIf('kategori.form')
<!-- menyertakan atau menampilkan konten dari file tampilan (view) lain ke dalam tampilan yang sedang dikerjakan -->
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    let table;

    $(function () {     //memastikan bahwa semua elemen di dalam halaman sudah tersedia sebelum mencoba menginisialisasi DataTable.
        table = $('.table').DataTable({
            responsive: true,   //Mengatur DataTable untuk responsif, yang berarti tampilan tabel akan menyesuaikan dengan ukuran layar perangkat yang berbeda.
            processing: true,   // Menampilkan indikator pemrosesan (loading) ketika DataTable sedang mengambil data dari server.
            serverSide: true,
            autoWidth: false,
            ajax: {     //Mengonfigurasi pengambilan data menggunakan AJAX
                url: '{{ route('kategori.data') }}',    //Menentukan URL dari mana DataTable akan mengambil data.
            },
            columns: [      //Menentukan kolom-kolom yang akan ditampilkan dalam DataTable
                {data: 'DT_RowIndex', searchable: false, sortable: false},
                {data: 'nama_kategori'},
                {data: 'aksi', searchable: false, sortable: false},
            ]
        });
        //Kesimpulan
        // Kode ini menangani pengiriman form dalam modal untuk menambah atau mengedit kategori.
        // Ketika form disubmit, validasi dilakukan terlebih dahulu. Jika valid, data akan dikirim ke server menggunakan AJAX.
        // Jika pengiriman berhasil, modal akan ditutup, tabel akan diperbarui, dan pengguna akan menerima notifikasi sukses. Jika gagal, pengguna akan menerima notifikasi kesalahan. Kode ini meningkatkan pengalaman pengguna dengan memberikan umpan balik langsung berdasarkan hasil operasi yang dilakukan.

        $('#modal-form').validator().on('submit', function (e) {
            if (! e.preventDefault()) {
                $.post($('#modal-form form').attr('action'), $('#modal-form form').serialize())
                    //$.post(...): Menggunakan metode POST AJAX untuk mengirim data form ke server.
                    //$('#modal-form form').attr('action'): Mengambil URL dari atribut action pada form di dalam modal. URL ini biasanya adalah endpoint untuk menyimpan data (seperti kategori.store).
                    //$('#modal-form form').serialize(): Mengambil semua data dari form dan mengubahnya menjadi format URL-encoded string untuk pengiriman.
                    .done((response) => {
                        $('#modal-form').modal('hide');
                        table.ajax.reload();
                        Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'kategori berhasil disimpan',
                        confirmButtonText: 'OK'
                    });
                    })
                    .fail((errors) => {
                        Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Tidak dapat menyimpan data',
                        confirmButtonText: 'OK'
                    });
                    });
            }
        }); // untuk menangani form pengiriman data tanpa perlu memuat ulang halaman.

    });

    function addForm(url) { //menyimpan alamat tujuan (URL) untuk mengirim data form.
        $('#modal-form').modal('show'); //untuk menampilkan modal dengan ID modal-form di halaman
        $('#modal-form .modal-title').text('Tambah Kategori');

        $('#modal-form form')[0].reset();   //untuk mereset atau mengosongkan semua input
        $('#modal-form form').attr('action', url);
        $('#modal-form [name=_method]').val('post');
        $('#modal-form [name=nama_kategori]').focus();
        //fungsi ini mempersiapkan modal untuk menambahkan kategori baru, dengan melakukan pengaturan pada form
    }
    
    function editForm(url) {
        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text('Edit Kategori');

        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form [name=_method]').val('put');
        $('#modal-form [name=nama_kategori]').focus();

        $.get(url)
            .done((response) => {
                $('#modal-form [name=nama_kategori]').val(response.nama_kategori);
            })
            .fail((errors) => {
                alert('Tidak dapat menampilkan data');
                return;
            }); // berfungsi untuk menampilkan nama kategori yang akan dihapus
    }

    function deleteData(url) {
        Swal.fire({
            title: 'Yakin ingin menghapus data terpilih?',
            text: "Data yang dihapus tidak dapat dipulihkan!",
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
                        text: 'Kategori berhasil dihapus',
                        confirmButtonText: 'OK'
                    });
                })
                .fail((errors) => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Tidak dapat menghapus kategori karena kategori sedang digunakan!',
                        confirmButtonText: 'OK'
                    });
                });
            }
        });
    }

</script>
@endpush