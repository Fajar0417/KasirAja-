@extends('layouts.master')

@section('title')
    Dashboard
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Dashboard</li>
    
@endsection

@section('content')
     <!-- Small boxes (Stat box) -->
     <div class="row">
        <div class="col-lg-12">
            <div class="box">
                <div  class="box-body text-center">
                    <h1>Selamat Datang Di DIFFY</h1>
                    <h2>Anda login sebagai KASIR</h2>
                    <br><br>
                    <a href="{{ route('transaksi.baru') }}" class="btn btn-success btn-lg">Transkasi Baru</a>
                    <br><br><br>
                </div>
            </div>
        </div>
  </div>

  <div class="row">
        <div class="col-lg-12">
            <div class="box">
                <div class="box-header with-border">
                </div>
                <div class="box-body table-responsive">
                    <form action="" method="post" class="form-produk">
                        @csrf
                        <table class="table table-stiped table-bordered">
                            <thead>
                                <th width="5%">No</th>
                                <th>Kode</th>
                                <th>Nama</th>
                                <th>Kategori</th>
                                <th>Merk</th>
                                <th>Stok</th>
                                <th>Keterangan</th>
                            </thead>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
      <!-- /.row (main row) -->
@endsection
@push('scripts')
<script src="{{ asset('admin-lte/bower_components/chart.js/Chart.js') }}"></script>
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
            {data: 'DT_RowIndex', searchable: false, sortable: false},
            {data: 'kode_produk'},
            {data: 'nama_produk'},
            {data: 'nama_kategori'},
            {data: 'merk'},
            {data: 'stok'},
            {data: 'keterangan'},
        ]
    });

    $('#modal-form').validator().on('submit', function (e) {
        if (! e.preventDefault()) {
            $.post($('#modal-form form').attr('action'), $('#modal-form form').serialize())
                .done((response) => {
                    $('#modal-form').modal('hide');
                    table.ajax.reload();
                })
                .fail((errors) => {
                    alert('Tidak dapat menyimpan data');
                    return;
                });
        }
    });

});

    </script>
@endpush