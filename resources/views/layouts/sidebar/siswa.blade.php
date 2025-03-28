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
        <li class="nav-item">
          <a href="{{ route('ekstra.index') }}" class="nav-link">
            <i class="nav-icon fas fa-book-reader"></i>
            <p>
              Ekstrakulikuler
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('presensi.index') }}" class="nav-link">
            <i class="nav-icon fas fa-user-check"></i>
            <p>
              Rekap Kehadiran
            </p>
          </a>
        </li>

        @if(Session::get('kurikulum') == '2013')

        <!-- Kurikulum 2013 -->

        <li class="nav-item">
          <a href="{{ route('nilaiakhir.index') }}" class="nav-link">
            <i class="nav-icon fas fa-table"></i>
            <p>
              Nilai Akhir Semester
            </p>
          </a>
        </li>

        <!-- End Kurikulum 2013 -->

        @elseif(Session::get('kurikulum') == '2006')

        <!-- Kurikulum 2006 -->
        <li class="nav-item">
          <a href="{{ route('nilaisemester.index') }}" class="nav-link">
            <i class="nav-icon fas fa-table"></i>
            <p>
              Nilai Akhir Semester
            </p>
          </a>
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