@extends('layouts.auth')
@section('login')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> 
      <section class="">
        <!-- Jumbotron -->
        <div class="px-5 py-5 px-md-5 text-center text-lg-start" style="background-color: hsl(0, 0%, 100%)">
          <div class="container py-10">
            <div class="row gx-lg-5 align-items-center">
              <div class="col-lg-6 mb-5 mb-lg-0">
                {{-- <div class="d-flex justify-content-center">
                          <img src="{{ url($setting->path_logo) }}" width="250px" height="250px" class="rounded float-start"  >
                      </div> --}}
                        <h1 class="my-5 display-3 fw-bold ls-tight">
                          Selamat Datang <br />
                            <span class="text-primary">DI DIFFY.com</span>
                        </h1>
                        <p style="color: hsl(0, 0%, 0%)">
                          Point Of Sales adalah website kasir yang digunakan untuk mempermudah transaksi
                          penjualan yang dibutuhkan bagi Toko Swalayan maupun Sekolah Pencetak Wirausaha (SPW)
                        </p>
              </div>



                          <!-- <div class="login-logo">
                            <a href="{{ url ('/') }}"><b>Admin</b>LTE</a>
                          </div> -->
                        
                                    <div class="col-lg-6 mb-5 mb-lg-0">
                                      <div class="card">
                                        <div class="card-body py-5 px-md-5">
                                          <form action="{{ route('login') }}" method="post">
                                            <div class="d-flex justify-content-center">
                                              <img src="{{ url($setting->path_logo) }}" width="150px" height="150px" class="rounded float-start"  >
                                            </div>
                                            @csrf
                                                <div class="form-group has-feedback @error('email') has-error @enderror mb-4">
                                                  <input type="email" name="email" class="form-control" placeholder="Email" required value="{{ old('email')}}" autofocus>
                                                  <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                                                  @error('email')
                                                  <span class="help-block">{{ $message }}</span>
                                                  @enderror
                                                </div>

                                                <div class="form-group has-feedback @error('password') has-error @enderror mb-4">
                                                  <input type="password" name="password" class="form-control" placeholder="Password" required >
                                                  <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                                                  @error('password')
                                                  <span class="help-block">{{ $message }}</span>
                                                  @enderror
                                                </div>

                                                <div class="row">
                                                  <div class="col-xs-8">
                                                    <div class="checkbox icheck">
                                                      <label>
                                                        <input type="checkbox"> Remember Me
                                                      </label>
                                                    </div>
                                                  </div>
                                                </div>
                                          
                                                <div class="d-grid gap-4 d-md-flex justify-content-md-end">
                                                  <button type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-block mb-4 " >
                                                  Login
                                                  </button>
                                                </div>
                                              
                                          
                                          </form>
                                        </div>
                                      </div>
                                    </div>  
                      <!-- /.login-box-body -->
            </div>
          </div>
        </div>
      </section>


        <!-- Section: Design Block -->
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
@endsection
<!-- /.login-box -->