@extends('layouts.master')

@section('title')
    pengaturan
@endsection

@section('breadcumb')
    @parent
    <li class="active">Pengaturan</li>
@endsection

@section('content')
    <div class="row">
<div class="col-lg-12">
    <div class="box">
        <form action="{{ route('setting.update') }}" method="post" class="form-setting" data-toggle="validator" enctype="multipart/form-data">
            @csrf
            <div class="box-body">
                <div class="alert alert-info alert-dismissible" style="display: none;">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <i class="icon fa fa-check"></i>Perubahan Berhasil Disimpan
                </div>
                <div class="form-group row">
                    <label for="nama_perusahaan" class="col-lg-2 col-lg-offset-1 control-label">Nama Perusahaan</label>
                    <div class="col-lg-6">
                        <input type="text" name="nama_perusahaan"  class="form-control" id="nama_perusahaan" required autofocus>
                        <span class="help-block with-errors"></span>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="telepon" class="col-lg-2 col-lg-offset-1 control-label">Telepon</label>
                    <div class="col-lg-6">
                        <input type="number" name="telepon"  class="form-control" id="telepon" required>
                        <span class="help-block with-errors"></span>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="email" class="col-lg-2 col-lg-offset-1 control-label">Email</label>
                    <div class="col-lg-6">
                        <input type="text" name="email"  class="form-control" id="email" required>
                        <span class="help-block with-errors"></span>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="instagram" class="col-lg-2 col-lg-offset-1 control-label">Instagram</label>
                    <div class="col-lg-6">
                        <input type="text" name="instagram"  class="form-control" id="instagram" required>
                        <span class="help-block with-errors"></span>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="youtube" class="col-lg-2 col-lg-offset-1 control-label">Youtube</label>
                    <div class="col-lg-6">
                        <input type="text" name="youtube"  class="form-control" id="youtube" required>
                        <span class="help-block with-errors"></span>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="facebook" class="col-lg-2 col-lg-offset-1 control-label">Facebook</label>
                    <div class="col-lg-6">
                        <input type="text" name="facebook"  class="form-control" id="facebook" required>
                        <span class="help-block with-errors"></span>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="twiter" class="col-lg-2 col-lg-offset-1 control-label">Twitter</label>
                    <div class="col-lg-6">
                        <input type="text" name="twiter"  class="form-control" id="twiter" required>
                        <span class="help-block with-errors"></span>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="alamat" class="col-lg-2 col-lg-offset-1 control-label">Alamat</label>
                    <div class="col-lg-6">
                      <textarea name="alamat" id="alamat" class="form-control" rows="3"></textarea>
                        <span class="help-block with-errors"></span>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="path_logo" class="col-lg-2 col-lg-offset-1 control-label">Logo Perusahaan</label>
                    <div class="col-lg-4">
                        <input type="file" name="path_logo"  class="form-control" id="path_logo"
                        onchange="preview('.tampil-logo', this.files[0])">
                        <span class="help-block with-errors"></span>
                        <br>
                        <div class="tampil-logo"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="tipe_nota" class="col-lg-2 col-lg-offset-1 control-label">Tipe Nota</label>
                    <div class="col-lg-6">
                     <select name="tipe_nota" class="form-controler" id="tipe_nota" required>
                        <option value="1">Nota Kecil</option>
                        <option value="2">Nota Besar</option>
                     </select>
                        <span class="help-block with-errors"></span>
                    </div>
                </div>
            </div>
            <div class="box-footer text-right">
                <button class="btn btn-sm btn-flat btn-success"><i class="fa fa-save"></i> Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
    </div>
@endsection

@push('scripts')
    <script>
         $(function () {
        showData();

        $('.form-setting').validator().on('submit', function (e) {
            if (! e.preventDefault()) {
                $.ajax({
                    url: $('.form-setting').attr('action'),
                    type: $('.form-setting').attr('method'),
                    data: new FormData($('.form-setting')[0]),
                    async: false,
                    processData: false,
                    contentType: false
                })
                .done(response => {
                    showData();
                    $('.alert').fadeIn();

                    setTimeout(() => {
                        $('.alert').fadeOut();
                    }, 3000);
                })
                .fail(errors => {
                    alert('Tidak dapat menyimpan data');
                    return;
                });
            }
        });

        function showData(){
            $.get('{{ route('setting.show') }}')
            .done(response => {
                $('[name=nama_perusahaan]').val(response.nama_perusahaan);
                $('[name=telepon]').val(response.telepon);
                $('[name=email]').val(response.email);
                $('[name=instagram]').val(response.instagram);
                $('[name=youtube]').val(response.youtube);
                $('[name=facebook]').val(response.youtube);
                $('[name=twiter]').val(response.twiter);
                $('[name=alamat]').val(response.alamat);
                $('[name=tipe_nota]').val(response.tipe_nota);
                $('[title]').text(response.nama_perusahaan + ' | pengaturan');
                $('.logo-lg').text(response.nama_perusahaan);
                    
              
                $('.tampil-logo').html(`<img src="{{ url('/') }}${response.path_logo}" width="200">`);
                $('[rel=icon]').attr('href', `{{ url('/') }}/${response.path_logo}`);
                
            })
            .fail(errors => {
                alert('Tidak dapat menampilkan data');
                return;
            })
        }
    });
    </script>
@endpush