@extends('layouts.auth')
@section('landing_page')
<div class="login-box">

  <!-- /.login-logo -->
  <div class="login-box-body">
  <div class="login-logo">
    <a href="{{ url ('/') }}"><b>Admin</b>LTE</a>
  </div>
    <form action="{{ route('landing_page') }}" method="post">
       
    </form>

  </div>
  <!-- /.login-box-body -->
</div>

@endsection
<!-- /.login-box -->