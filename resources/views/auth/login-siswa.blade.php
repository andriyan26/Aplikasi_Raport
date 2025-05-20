@include('layouts.auth.header')

<body class="hold-transition login-page">
  <div class="login-box">
    <div class="login-logo">
      <img src="/assets/images/logo/logo-smk.jpeg" alt="Logo" class="brand-image img-circle"
        style="width: 80px; height: auto; display: block; margin: 20px auto 0;">
      <p class="login-box-msg">Aplikasi <b>Raport</b> Digital</p>
      <p class="login-box-msg" style="font-size: 20px;">Login Siswa - SMK Al-Hidayah Ciputat</p>
    </div>

    <div class="card">
      <div class="card-body login-card-body">
        <p class="login-box-msg" style="font-size: 22px; font-weight: bold;">LOGIN SISWA</p>

        @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form method="post" action="{{ route('login.siswa') }}">
          @csrf
          <div class="input-group mb-3">
            <input type="text" name="username" class="form-control" placeholder="Username" required>
            <div class="input-group-append">
              <div class="input-group-text"><span class="fas fa-user"></span></div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" name="password" class="form-control" placeholder="NIS" required>
            <div class="input-group-append">
              <div class="input-group-text"><span class="fas fa-key"></span></div>
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-12">
              <button type="submit" class="btn btn-success btn-block">Login Sebagai Siswa</button>
            </div>
          </div>
        </form>
        <a href="{{ route('login') }}" class="text-center d-block mt-3">Kembali ke Login Admin</a>
      </div>
    </div>
  </div>

  @include('layouts.auth.footer')
