@include('layouts.main.header')
@include('layouts.sidebar.siswa')

<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">{{ $title }}</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">{{ $title }}</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">

      <div class="row">
        <div class="col-12">

          <div class="card">
            <div class="card-header">
              <h3 class="card-title"><i class="fas fa-book-reader"></i> {{ $title }}</h3>
            </div>

            <div class="card-body">
              {{-- Filter Tahun Ajaran --}}
              <div class="callout callout-info">
                <form action="{{ route('nilai.siswa.filter') }}" method="GET">
                  <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Tahun Ajaran</label>
                    <div class="col-sm-10">
                      <select class="form-control select2" name="tahun_pelajaran_id" style="width: 100%;" required onchange="this.form.submit();">
                        <option value="">-- Pilih Tahun Ajaran --</option>
                        @foreach($data_tapel as $tapel)
                        <option value="{{ $tapel->id }}"
                          {{ (old('tahun_pelajaran_id', $tahun_pelajaran_id) == $tapel->id) ? 'selected' : '' }}>
                          {{ $tapel->tahun_pelajaran }} {{ $tapel->semester == 1 ? 'Ganjil' : 'Genap' }}
                        </option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                </form>
              </div>

              {{-- Jika tahun ajaran sudah dipilih --}}
              @if($tahun_pelajaran_id)

                @if($anggota_kelas)
                  <div class="callout callout-info">
                    <div class="form-group row">
                      <div class="col-sm-3">Nama Lengkap</div>
                      <div class="col-sm-9">: {{ $siswa->nama_lengkap }}</div>
                    </div>
                    <div class="form-group row">
                      <div class="col-sm-3">Nomor Induk / NISN</div>
                      <div class="col-sm-9">: {{ $siswa->nis }} / {{ $siswa->nisn }}</div>
                    </div>
                    <div class="form-group row">
                      <div class="col-sm-3">Kelas</div>
                      <div class="col-sm-9">: {{ $anggota_kelas->kelas->nama_kelas ?? '-' }}</div>
                    </div>
                  </div>

                  <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                      <thead class="bg-info">
                        <tr>
                          <th rowspan="2" class="text-center" style="width: 5%;">No</th>
                          <th rowspan="2" class="text-center" style="width: 28%;">Mata Pelajaran</th>
                          <th rowspan="2" class="text-center" style="width: 7%;">KKM</th>
                          <th colspan="2" class="text-center" style="width: 15%;">Pengetahuan</th>
                          <th colspan="2" class="text-center" style="width: 15%;">Keterampilan</th>
                          <th colspan="2" class="text-center" style="width: 15%;">Sikap Spiritual</th>
                          <th colspan="2" class="text-center" style="width: 15%;">Sikap Sosial</th>
                        </tr>
                        <tr>
                          <th class="text-center" style="width: 7%;">Nilai</th>
                          <th class="text-center" style="width: 8%;">Predikat</th>
                          <th class="text-center" style="width: 7%;">Nilai</th>
                          <th class="text-center" style="width: 8%;">Predikat</th>
                          <th class="text-center" style="width: 7%;">Nilai</th>
                          <th class="text-center" style="width: 8%;">Predikat</th>
                          <th class="text-center" style="width: 7%;">Nilai</th>
                          <th class="text-center" style="width: 8%;">Predikat</th>
                        </tr>
                      </thead>
                      <tbody>
                        @php $no = 1; @endphp
                        @foreach($data_pembelajaran->sortBy('mapel.nama_mapel') as $pembelajaran)
                          <tr>
                            <td class="text-center">{{ $no++ }}</td>
                            <td>{{ $pembelajaran->mapel->nama_mapel }}</td>

                            @if($pembelajaran->nilai)
                              <td class="text-center">{{ $pembelajaran->nilai->kkm }}</td>
                              <td class="text-center">{{ $pembelajaran->nilai->nilai_pengetahuan }}</td>
                              <td class="text-center">{{ $pembelajaran->nilai->predikat_pengetahuan }}</td>
                              <td class="text-center">{{ $pembelajaran->nilai->nilai_keterampilan }}</td>
                              <td class="text-center">{{ $pembelajaran->nilai->predikat_keterampilan }}</td>
                              <td class="text-center">{{ $pembelajaran->nilai->nilai_spiritual }}</td>
                              <td class="text-center">
                                @if($pembelajaran->nilai->nilai_spiritual == 4) Sangat Baik
                                @elseif($pembelajaran->nilai->nilai_spiritual == 3) Baik
                                @elseif($pembelajaran->nilai->nilai_spiritual == 2) Cukup
                                @elseif($pembelajaran->nilai->nilai_spiritual == 1) Kurang
                                @else -
                                @endif
                              </td>
                              <td class="text-center">{{ $pembelajaran->nilai->nilai_sosial }}</td>
                              <td class="text-center">
                                @if($pembelajaran->nilai->nilai_sosial == 4) Sangat Baik
                                @elseif($pembelajaran->nilai->nilai_sosial == 3) Baik
                                @elseif($pembelajaran->nilai->nilai_sosial == 2) Cukup
                                @elseif($pembelajaran->nilai->nilai_sosial == 1) Kurang
                                @else -
                                @endif
                              </td>
                            @else
                              <td class="text-center">-</td>
                              <td class="text-center">-</td>
                              <td class="text-center">-</td>
                              <td class="text-center">-</td>
                              <td class="text-center">-</td>
                              <td class="text-center">-</td>
                              <td class="text-center">-</td>
                              <td class="text-center">-</td>
                              <td class="text-center">-</td>
                            @endif
                          </tr>
                          @endforeach
                      </tbody>
                    </table>
                  </div>

                @else
                  <div class="alert alert-warning text-center">
                    Anda belum terdaftar di kelas untuk Tahun Ajaran ini.
                  </div>
                @endif

              @else
                <div class="alert alert-info text-center">
                  Silakan pilih Tahun Ajaran terlebih dahulu untuk menampilkan data nilai.
                </div>
              @endif

            </div>
          </div>

        </div>
      </div>

    </div>
  </section>
</div>

@include('layouts.main.footer')
