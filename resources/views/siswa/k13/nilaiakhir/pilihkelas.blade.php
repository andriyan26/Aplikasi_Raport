@include('layouts.main.header')
@include('layouts.sidebar.siswa')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">{{$title}}</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item "><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">{{$title}}</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <!-- ./row -->
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title"><i class="fas fa-check-circle"></i> {{$title}}</h3>
            </div>

            <div class="card-body">
                <div class="callout callout-info">
                    <form action="{{ route('nilai.siswa.filter') }}" method="GET">
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Tahun Ajaran</label>
                        <div class="col-sm-10">
                        <select class="form-control select2" name="tahun_pelajaran_id" style="width: 100%;" required onchange="this.form.submit();">
                            <option value="">-- Pilih Tahun Ajaran --</option>
                            <?php $no = 0; ?>
                            @foreach($data_tapel as $tapel)
                            <?php $no++; ?>
                            <option value="{{ $tapel->id }}" {{ request('tahun_pelajaran_id') == $tapel->id || ($no == 1 && !request('tahun_pelajaran_id')) ? 'selected' : '' }}>
                            {{ $tapel->tahun_pelajaran }} {{ $tapel->semester == 1 ? 'Ganjil' : 'Genap' }}
                            </option>
                            @endforeach
                        </select>
                        </div>
                    </div>
                    </form>
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