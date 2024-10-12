<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Kasir Aja!</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
    </head>
    <body>
      <!-- Responsive navbar-->
      <nav class="navbar bg-white">
        <div class="container">
          <a class="navbar-brand" href="#">
            <img src="#" alt="‎     ‎" width="60" height="60">
          </a>
        </div>
      </nav>
        <!-- Header-->
        <header  class="bg-dark py-5">
            <div class="container px-5">
                <div class="row gx-5 justify-content-left">
                    <div class="col-lg-6">
                        <div class="text-center my-5">
                            <h1 class="display-5 fw-bolder text-white mb-2">Sistem Point Of Sales(POS)</h1>
                            <p class="lead text-white-50 mb-4 ">Point Of Sales adalah website kasir  yang digunakan untuk mempermudah transaksi penjualan yang dibutuhkan bagi Toko Swalayan maupun Sekolah Pencetak Wirausaha (SPW) </p>
                            <div class="d-grid gap-3 d-sm-flex justify-content-sm-center">
                                <a class="btn btn-primary btn-lg px-4 me-sm-3" href="login">Login</a>
                                <a class="btn btn-outline-light btn-lg px-4" href="#!">Login sebagai Pelanggan</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="text-center my-5">
                            <img src="{{ asset('images/kasir bro.jpg') }}" class="img-thumbnail" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- Pricing section-->
        <section class="bg-light py-5 border-bottom">
            {{-- <div class="container px-5 my-5">
                <div class="text-center mb-5">
                    <h2 class="fw-bolder">{{ $setting->nama_perusahaan  }}</h2>
                    <p class="lead mb-0">{{ $setting->nama_perusahaan  }} adalah sistem informasi Point Of Sales(POS)yang berbasis website yang dirancang untuk mempermudah kebutuhan pelaku bisnis dakam transaksi jual beli.
                        Temukan produk yang kalian nginkan disini!</p>
                </div>
                <div class="col-lg-6">
                    <div class="text-center my-5">
                        <img src="{{ asset('images/bro ini kasir.png') }}" class="img-thumbnail" alt="">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="text-right mb-5">
                        <h2 class="fw-bolder">{{ $setting->nama_perusahaan  }}</h2>
                        <p class="lead mb-0"> sistem informasi Point Of Sales(POS)yang berbasis website yang dirancang untuk mempermudah kebutuhan pelaku bisnis dakam transaksi jual beli.
                            Temukan produk yang kalian nginkan disini!</p>
                    </div>
                
            </div> --}}
            <div class="container px-5">
                <div class="text-center mb-5">
                    <h2 class="fw-bolder">Profil Toko</h2>
                    <p class="lead mb-0">Sistem informasi Point Of Sales (POS)yang berbasis website yang dirancang untuk mempermudah kebutuhan pelaku bisnis dakam transaksi jual beli.
                        Temukan produk yang kalian inginkan disini!</p>
                </div>
                <div class="row gx-5 justify-content-left">
                    <div class="col-lg-6">
                        <div class="text-center my-5">
                            <img src="{{ asset('images/kasir bro.jpg') }}" class="img-thumbnail" alt="">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="text-right mb-5">
                            <h2 class="fw-bolder">Tentang Toko</h2>
                            <p class="lead mb-0">
                                <table class="table table-borderless">
                                    <tr>
                                        <td>Nama Toko</td>
                                        <td>Kasir Aja!</td>                             
                                    </tr>
                                    <tr>
                                        <td>Alamat Toko</td>
                                        <td>JL Talagasari, No. 35, Kawalimukti,Kec.Kawali,Kab.Ciamis,Jawa Barat 46253</td>                              
                                 </tr>
                                </table>
                                <h4>Kami menyediakan berbagai kebutuhan seperti makanan,minuman,bahan pangan dan kebutuhan lainnya.</h4>
                                <p>Jam operasional</p>
                                <p>09.00-20.00 WIB</p>                             
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        <!-- Testimonials section-->
        <section class="py-5 border-bottom">
            <div class="container px-5 my-5 px-5">
                <div class="text-center mb-5">
                    <h2 class="fw-bolder">Profil pegawai</h2>
                </div>
                <div class="row gx-5 justify-content-center">
                <!-- Pricing card free-->
                <div class="col-lg-4">
                    <div class="card mb-5 mb-xl-0">
                        <div class="card-body p-5">
                            <div class="d-flex justify-content-center">
                                <img src="images/miyat abadi.jpeg" width="250px" height="335px" class="rounded float-start"  >
                            </div>
                            <ul class="list-unstyled mb-4">
                                <li class="mb-2 text-center mu-3">
                                    <i class="bi bi-x"></i>
                                    <strong> Yayat Hidayat Tulloh </strong>
                                </li>
                                <li class="text-center">
                                    <i class="bi bi-x"></i>
                                    Pegawai
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- Pricing card free-->
                <div class="col-lg-4">
                    <div class="card mb-5 mb-xl-0">
                        <div class="card-body p-5">
                            <div class="d-flex justify-content-center">
                                <img src="images/fajar.jpeg" width="250px" height="335px" class="rounded float-start"  >
                            </div>
                            <ul class="list-unstyled mb-4">
                                <li class="mb-2 text-center mu-3">
                                    <i class="bi bi-x"></i>
                                    <strong> Fajar Ferdiansyah</strong>
                                </li>
                                <li class="text-center">
                                    <i class="bi bi-x"></i>
                                    Manajer
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- Pricing card free-->
                <div class="col-lg-4">
                    <div class="card mb-5 mb-xl-0">
                        <div class="card-body p-5">
                            <div class="d-flex justify-content-center">
                                <img src="images/faiz.jpeg" width="250px" height="335px" class="rounded float-start"  >
                            </div>
                            <ul class="list-unstyled mb-4">
                                <li class="mb-2 text-center mu-3">
                                    <i class="bi bi-x"></i>
                                    <strong> Faiz Al Zhafir </strong>
                                </li>
                                <li class="text-center">
                                    <i class="bi bi-x"></i>
                                    Pegawai
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- Pricing card free-->
                <div class="col-lg-4">
                    <div class="card mb-5 mb-xl-0">
                        <div class="card-body p-5">
                            <div class="d-flex justify-content-center">
                                <img src="images/ilalika.jpeg" width="250px" height="335px" class="rounded float-start"  >
                            </div>
                            <ul class="list-unstyled mb-4">
                                <li class="mb-2 text-center mu-3">
                                    <i class="bi bi-x"></i>
                                    <strong> Ilallika Haikal Hikayat </strong>
                                </li>
                                <li class="text-center">
                                    <i class="bi bi-x"></i>
                                    Pegawai
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- Pricing card free-->
                <div class="col-lg-4">
                    <div class="card mb-5 mb-xl-0">
                        <div class="card-body p-5">
                            <div class="d-flex justify-content-center">
                                <img src="images/dikri.jpeg" width="250px" height="335px" class="rounded float-start"  >
                            </div>
                            <ul class="list-unstyled mb-4">
                                <li class="mb-2 text-center mu-3">
                                    <i class="bi bi-x"></i>
                                    <strong> Dickri Bambang Kurniawan</strong>
                                </li>
                                <li class="text-center">
                                    <i class="bi bi-x"></i>
                                    Pegawai
                                </li>
                            </ul>
                        </div>
                    </div>
                </div> 
            </div>
        </section>
        <!-- Footer-->
        <footer class="py-5 bg-dark">
            <div class="container px-5"><p class="m-0 text-center text-white">Copyright &copy; Your Website 2023</p></div>
        </footer>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
        <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
        <!-- * *                               SB Forms JS                               * *-->
        <!-- * * Activate your form at https://startbootstrap.com/solution/contact-forms * *-->
        <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
        <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
    </body>
</html>
