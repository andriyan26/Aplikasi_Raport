@include('layouts.main.header')
@include('layouts.sidebar.admin')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">{{$title}}</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">{{$title}}</li>
          </ol>
        </div>
      </div>
    </div>
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">

          <div class="card">
            <div class="card-header">
              <h3 class="card-title"><i class="fas fa-user-friends"></i> {{$title}}</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool btn-sm" data-toggle="modal" data-target="#modal-tambah">
                  <i class="fas fa-plus"></i>
                </button>
                <a href="{{ route('user.export') }}" class="btn btn-tool btn-sm">
                  <i class="fas fa-download"></i>
                </a>
              </div>
            </div>

            <!-- Modal Tambah -->
            <div class="modal fade" id="modal-tambah">
              <div class="modal-dialog modal-lg">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">Tambah {{$title}} Admin </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <form action="{{ route('user.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                      <div class="form-group row">
                        <label for="nama_lengkap" class="col-sm-3 col-form-label">Nama Lengkap</label>
                        <div class="col-sm-9">
                          <input type="text" name="nama_lengkap" class="form-control" required>
                        </div>
                      </div>

                      <div class="form-group row">
                        <label for="username" class="col-sm-3 col-form-label">Username</label>
                        <div class="col-sm-9">
                          <input type="text" name="username" class="form-control" required>
                        </div>
                      </div>

                      <div class="form-group row">
                        <label for="password" class="col-sm-3 col-form-label">Password</label>
                        <div class="col-sm-9">
                          <input type="password" name="password" class="form-control" required>
                        </div>
                      </div>

                      <div class="form-group row">
                        <label for="role" class="col-sm-3 col-form-label">Role</label>
                        <div class="col-sm-9">
                          <select name="role" class="form-control" id="roleSelect" required>
                            <option value="">-- Role -- </option>
                            <option value="1">Administrator</option>
                          </select>
                        </div>
                      </div>


                      <div class="form-group row">
                        <label for="jenis_kelamin" class="col-sm-3 col-form-label">Jenis Kelamin</label>
                        <div class="col-sm-9">
                          <select name="jenis_kelamin" class="form-control" id="jenis_kelamin" required>
                            <option value="">-- Pilih Jenis Kelamin --</option>
                            <option value="L">Laki-Laki</option>
                            <option value="P">Perempuan</option>
                          </select>
                        </div>
                      </div>

                      <div class="form-group row">
                        <label for="tanggal_lahir" class="col-sm-3 col-form-label">Tanggal Lahir</label>
                        <div class="col-sm-9">
                          <input type="date" name="tanggal_lahir" class="form-control" id="tanggal_lahir" required>
                        </div>
                      </div>

                      <div class="form-group row">
                        <label for="email" class="col-sm-3 col-form-label">Email</label>
                        <div class="col-sm-9">
                          <input type="email" name="email" class="form-control" id="email" value="{{ old('email') }}" required>
                        </div>
                      </div>

                      <div class="form-group row">
                        <label for="nomor_hp" class="col-sm-3 col-form-label">Nomor Handphone</label>
                        <div class="col-sm-9">
                          <input type="text" name="nomor_hp" class="form-control" id="nomor_hp" value="{{ old('nomor_hp') }}" required placeholder="Contoh: 081234567890">
                        </div>
                      </div>

                      <div class="form-group row">
                        <label for="status" class="col-sm-3 col-form-label">Status Akun</label>
                        <div class="col-sm-9 pt-1">
                          <label class="radio-inline mr-3">
                            <input type="radio" name="status" value="1" required> Aktif
                          </label>
                          <label class="radio-inline mr-3">
                            <input type="radio" name="status" value="0" required> Non Aktif
                          </label>
                        </div>
                      </div>
                    </div>
                    <div class="modal-footer justify-content-end">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                      <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <!-- End Modal Tambah -->

            <div class="card-body">
              <div class="table-responsive">
                <table id="example1" class="table table-striped table-valign-middle table-hover">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Nama Lengkap</th>
                      <th>Username</th>
                      <th>Level</th>
                      <th>Status Akun</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    @php $no = 1; @endphp
                    @foreach($data_user as $user)
                    <tr>
                      <td>{{ $no++ }}</td>
                      <td>
                        @switch($user->role)
                          @case(1)
                            {{ optional($user->admin)->nama_lengkap }}
                            @break
                          @case(2)
                            {{ optional($user->guru)->nama_lengkap }}
                            @break
                          @case(3)
                            {{ optional($user->siswa)->nama_lengkap }}
                            @break
                          @case(4)
                            {{ optional($user->kepala_sekolah)->nama_lengkap }}
                            @break
                          @case(5)
                            {{ optional($user->wakilkurikulum)->nama_lengkap }}
                            @break
                          @default
                            -
                        @endswitch
                      </td>
                      <td>{{ $user->username }}</td>
                      <td>
                        @switch($user->role)
                          @case(1)
                            Administrator
                            @break
                          @case(2)
                            Guru
                            @break
                          @case(3)
                            Siswa
                            @break
                          @case(4)
                            Kepala Sekolah
                            @break
                          @case(5)
                            Wakil Kurikulum
                            @break
                          @default
                            Tidak Diketahui
                        @endswitch
                      </td>
                      <td>
                        @if($user->status)
                          <span class="badge bg-success">Aktif</span>
                        @else
                          <span class="badge bg-danger">Non Aktif</span>
                        @endif
                      </td>
                      <td>
                        <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modal-edit{{ $user->id }}">
                          <i class="fas fa-pencil-alt"></i> Edit
                        </button>
                      </td>
                    </tr>

                    <!-- Modal Edit -->
                    <div class="modal fade" id="modal-edit{{ $user->id }}">
                      <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title">Edit {{$title}}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <form action="{{ route('user.update', $user->id) }}" method="POST">
                            @method('PATCH')
                            @csrf
                            <div class="modal-body">
                              <div class="form-group row">
                                <label for="nama_lengkap" class="col-sm-3 col-form-label">Nama Lengkap</label>
                                <div class="col-sm-9">
                                  @switch($user->role)
                                    @case(1)
                                      <input type="text" class="form-control" value="{{ optional($user->admin)->nama_lengkap }}" readonly>
                                      @break
                                    @case(2)
                                      <input type="text" class="form-control" value="{{ optional($user->guru)->nama_lengkap }}" readonly>
                                      @break
                                    @case(3)
                                      <input type="text" class="form-control" value="{{ optional($user->siswa)->nama_lengkap }}" readonly>
                                      @break
                                    @case(4)
                                      <input type="text" class="form-control" value="{{ optional($user->kepala_sekolah)->nama_lengkap }}" readonly>
                                      @break
                                    @case(5)
                                      <input type="text" class="form-control" value="{{ optional($user->wakilkurikulum)->nama_lengkap }}" readonly>
                                      @break
                                    @default
                                      <input type="text" class="form-control" value="-" readonly>
                                  @endswitch
                                </div>
                              </div>

                              <div class="form-group row">
                                <label for="username" class="col-sm-3 col-form-label">Username</label>
                                <div class="col-sm-9">
                                  <input type="text" class="form-control" value="{{ $user->username }}" readonly>
                                </div>
                              </div>

                              <div class="form-group row">
                                <label for="password" class="col-sm-3 col-form-label">Password</label>
                                <div class="col-sm-9">
                                  <input type="password" class="form-control" name="password" placeholder="Password Baru">
                                </div>
                              </div>

                              <div class="form-group row">
                                <label for="status" class="col-sm-3 col-form-label">Status Akun</label>
                                <div class="col-sm-9 pt-1">
                                  <label class="radio-inline mr-3">
                                    <input type="radio" name="status" value="1" {{ $user->status ? 'checked' : '' }} required> Aktif
                                  </label>
                                  <label class="radio-inline mr-3">
                                    <input type="radio" name="status" value="0" {{ !$user->status ? 'checked' : '' }} required> Non Aktif
                                  </label>
                                </div>
                              </div>
                            </div>
                            <div class="modal-footer justify-content-end">
                              <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                              <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                    <!-- End Modal Edit -->

                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <!-- /.card -->

        </div>
      </div>
      <!-- /.row -->
    </div>
    <!--/. container-fluid -->
  </section>
  <!-- /.content -->

</div>
<!-- /.content-wrapper -->

@include('layouts.main.footer')
