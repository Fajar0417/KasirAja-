@extends('layouts.master')  
<!-- tampilan ini mewarisi struktur dan elemen dari layout tersebut. -->

@section('title')
    Daftar Kategori
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Daftar Kategori</li>
@endsection

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
<!-- Ini biasanya berisi form untuk menambah atau mengedit kategori, dan akan ditampilkan dalam modal. -->
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    let table;

    $(function () {
        table = $('.table').DataTable({
            responsive: true,       //Menjadikan tabel responsif, sehingga tampilan tabel akan menyesuaikan dengan ukuran layar.
            processing: true,       //Menampilkan indikator pemrosesan saat data sedang dimuat.
            serverSide: true,       // DataTables akan meminta data dari server untuk setiap operasi, seperti pencarian, pengurutan, dan paginasi.
            autoWidth: false,       //Mengatur lebar kolom tabel agar tidak otomatis menyesuaikan dengan kontennya.
            ajax: {
                url: '{{ route('kategori.data') }}',        //menggunakan route Laravel untuk mendapatkan data kategori. ia akan mengirim permintaan ke URL yang diberikan.
            },
            columns: [
                {data: 'DT_RowIndex', searchable: false, sortable: false},
                {data: 'nama_kategori'},
                {data: 'aksi', searchable: false, sortable: false},
            ]
        });

        $('#modal-form').validator().on('submit', function (e) {        // Validator: Ini biasanya digunakan untuk memastikan bahwa data yang dimasukkan memenuhi syarat tertentu sebelum pengiriman.
            if (! e.preventDefault()) {
                $.post($('#modal-form form').attr('action'), $('#modal-form form').serialize())
                    .done((response) => {
                        $('#modal-form').modal('hide');
                        table.ajax.reload();
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: 'Kategori berhasil disimpan!',
                        });
                    })
                    .fail((errors) => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: 'Tidak dapat menyimpan Kategori.',
                        });
                    });
            }
        });
    });

    function addForm(url) {
        $('#modal-form').modal('show');     // Menampilkan modal dengan ID modal-form.
        $('#modal-form .modal-title').text('Tambah Kategori');  //Mengubah judul modal menjadi "Tambah Kategori".

        $('#modal-form form')[0].reset();       //Mengatur ulang semua input dalam form, sehingga semua field menjadi kosong.
        $('#modal-form form').attr('action', url);      //Menetapkan URL tujuan untuk pengiriman form berdasarkan parameter url yang diberikan.
        $('#modal-form [name=_method]').val('post');       //Menetapkan metode HTTP sebagai post, 
        $('#modal-form [name=nama_kategori]').focus();      //Mengatur fokus pada field input nama_kategori, sehingga pengguna dapat langsung mulai mengetik.
    }

    function editForm(url) {
        $('#modal-form').modal('show');     //Menampilkan modal untuk edit.
        $('#modal-form .modal-title').text('Edit Kategori');        //Mengubah judul modal menjadi "Edit Kategori".

        $('#modal-form form')[0].reset();       //Mengatur ulang semua input dalam form.
        $('#modal-form form').attr('action', url);      //Menetapkan URL tujuan untuk pengiriman form.
        $('#modal-form [name=_method]').val('put');     //Menetapkan metode HTTP sebagai put, yang menunjukkan bahwa ini adalah permintaan untuk mengupdate data.
        $('#modal-form [name=nama_kategori]').focus();

        $.get(url)
            .done((response) => {
                $('#modal-form [name=nama_kategori]').val(response.nama_kategori);
                
            })
            .fail((errors) => {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: 'Tidak dapat menampilkan data.',
                });
            });
    }

    function deleteData(url) {
        if (confirm('Yakin ingin menghapus data terpilih?')) {
            $.post(url, {
                    '_token': $('[name=csrf-token]').attr('content'),   //Mengirim permintaan POST ke URL untuk menghapus kategori.
                    '_method': 'delete'
                })
                .done((response) => {
                    table.ajax.reload();
                    Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: 'Kategori berhasil dihapus!',
                        });
                })
                .fail((errors) => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: 'kategori tidak dapat dihapus karena kategori telah dipakai',
                        });
                    });
        }
    }
</script>
@endpush