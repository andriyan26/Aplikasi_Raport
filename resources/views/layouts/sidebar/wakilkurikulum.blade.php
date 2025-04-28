<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="{{ route('dashboard') }}" class="brand-link">
    <img src="/assets/images/logo/logo-smk.jpeg" alt="Logo" class="brand-image img-circle">
    <span class="brand-text font-weight-light">Aplikasi Raport Digital</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
          <a href="{{ route('dashboard') }}" class="nav-link">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              Dashboard
            </p>
          </a>
        </li>

        @if(Session::get('kurikulum') == '2013')

        <!-- Kurikulum 2013 -->
        <li class="nav-item">
          <a href="{{ route('wakurstatusnilaiguru.index') }}" class="nav-link">
            <i class="nav-icon fas fa-check-circle"></i>
            <p>
              Cek Status Penilaian
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('wakurhasilnilai.index') }}" class="nav-link">
            <i class="nav-icon fas fa-check-square"></i>
            <p>
              Hasil Pengelolaan Nilai
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('wakurprosesdeskripsisikap.index') }}" class="nav-link">
            <i class="nav-icon fas fa-file-alt"></i>
            <p>
              Proses Deskripsi Sikap
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('k13validasi.index') }}" class="nav-link">
            <i class="nav-icon fas fa-check-square"></i>
            <p>
              Validasi Data
            </p>
          </a>
        </li>

        <!-- End Kurikulum 2013 -->

        @elseif(Session::get('kurikulum') == '2006')

        <!-- Kurikulum 2006 -->
        <li class="nav-header">SETTING RAPORT KTSP 2006</li>
        
        <li class="nav-item">
          <a href="{{ route('mapping.index') }}" class="nav-link">
            <i class="nav-icon fas fa-list-ol"></i>
            <p>
              Mapping Mapel
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('kkm.index') }}" class="nav-link">
            <i class="nav-icon fas fa-greater-than-equal"></i>
            <p>
              KKM Mapel
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('interval.index') }}" class="nav-link">
            <i class="nav-icon fas fa-columns"></i>
            <p>
              Interval Predikat
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('validasi.index') }}" class="nav-link">
            <i class="nav-icon fas fa-check-square"></i>
            <p>
              Validasi Data
            </p>
          </a>
        </li>

        <li class="nav-header">HASIL RAPORT KTSP 2006</li>
        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-list-ol"></i>
            <p>
              Hasil Penilaian
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview bg-secondary">
            <li class="nav-item">
              <a href="{{ route('adminktspstatuspenilaian.index') }}" class="nav-link">
                <i class="fas fa-check-circle nav-icon"></i>
                <p>Status Penilaian</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('adminktsppengelolaannilai.index') }}" class="nav-link">
                <i class="fas fa-check-square nav-icon"></i>
                <p>Hasil Pengelolaan Nilai</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('adminktspnilairaport.index') }}" class="nav-link">
                <i class="fas fa-clipboard-check nav-icon"></i>
                <p>Nilai Raport Semester</p>
              </a>
            </li>
          </ul>
        </li>

        <!-- End Kurikulum 2006 -->

        @endif

        <li class="nav-item bg-danger mt-2">
          <a href="{{ route('logout') }}" class="nav-link" id="logoutBtn">
            <i class="nav-icon fas fa-sign-out-alt"></i>
            <p>Keluar / Logout</p>
          </a>

        <!-- Tambahkan SweetAlert2 -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            document.getElementById("logoutBtn").addEventListener("click", function(event) {
                event.preventDefault(); // Mencegah logout langsung

                Swal.fire({
                    title: "Anda yakin ingin keluar?",
                    text: "Semua sesi akan berakhir dan Anda harus login kembali.",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Ya, Keluar",
                    cancelButtonText: "Batal"
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "{{ route('logout') }}";
                    }
                });
            });
        </script>

          </a>
        </li>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>