@include('layouts.main.header')
@include('layouts.sidebar.walikelas')

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
              <h3 class="card-title"><i class="fas fa-table"></i> {{$title}}</h3>
              <div class="card-tools">
                <a href="{{ route('leger.export') }}" class="btn btn-tool btn-sm" onclick="return confirm('Download {{$title}} ?')">
                  <i class="fas fa-download"></i>
                </a>
              </div>
            </div>

            <div class="mt-2 text-muted" style="font-size: 14px; margin-left: 15px;">
                <strong>Keterangan :</strong> <br>
                Pen = Nilai Pengetahuan <br> Ket = Nilai Keterampilan <br> KKM = 70 (Untuk Setiap Pelajaran)
            </div>

            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered table-striped">
                <thead class="bg-info">
                <tr>
                      <th rowspan="2" class="text-center" style="width: 50px;">No</th>
                      <th rowspan="2" class="text-center" style="width: 50px;">NIS</th>
                      <th rowspan="2" class="text-center">Nama Siswa</th>
                      <th rowspan="2" class="text-center" style="width: 50px;">Kelas</th>

                      @foreach($data_mapel_kelompok_a->sortBy('pembelajaran.mapel.k13_mapping_mapel.nomor_urut') as $mapel_kelompok_a)
                      <th colspan="2" class="text-center">{{$mapel_kelompok_a->pembelajaran->mapel->nama_mapel}}</th>
                      @endforeach

                      @foreach($data_mapel_kelompok_b->sortBy('pembelajaran.mapel.k13_mapping_mapel.nomor_urut') as $mapel_kelompok_b)
                      <th colspan="2" class="text-center">{{$mapel_kelompok_b->pembelajaran->mapel->nama_mapel}}</th>
                      @endforeach

                      <th class="text-center">Jumlah Nilai</th>
                      <th class="text-center">Predikat</th>
                      <th class="text-center">Peringkat</th>
                      <th colspan="3" class="text-center">Kehadiran</th>
                      <th colspan="2" class="text-center">Ekstrakulikuler</th>
                    </tr>
                    <tr>
                      @foreach($data_mapel_kelompok_a->sortBy('pembelajaran.mapel.k13_mapping_mapel.nomor_urut') as $mapel_kelompok_a)
                      <th class="text-center">Pen</th>
                      <th class="text-center">Ket</th>
                      @endforeach

                      @foreach($data_mapel_kelompok_b->sortBy('pembelajaran.mapel.k13_mapping_mapel.nomor_urut') as $mapel_kelompok_b)
                      <th class="text-center">Pen</th>
                      <th class="text-center">Ket</th>
                      @endforeach

                      <th class="text-center">Total</th>
                      <th class="text-center">A/B/C/D</th>
                      <th class="text-center">Ke-</th>

                      <th class="text-center">S</th>
                      <th class="text-center">I</th>
                      <th class="text-center">A</th>
                    
                      <th class="text-center">Hasil</th>
                    </tr>
                  </thead>

                  <tbody>
                    <?php $no = 0; ?>
                    @foreach($data_anggota_kelas->sortBy('siswa.nama_lengkap') as $anggota_kelas)
                    <?php $no++; ?>
                    <tr>
                      <td class="text-center">{{$no}}</td>
                      <td class="text-center">{{$anggota_kelas->siswa->nis}}</td>
                      <td>{{$anggota_kelas->siswa->nama_lengkap}}</td>
                      <td class="text-center">{{$anggota_kelas->kelas->nama_kelas}}</td>

                      @php
                        $jumlah_nilai = 0;
                      @endphp

                      @foreach($anggota_kelas->data_nilai_kelompok_a->sortBy('pembelajaran.mapel.k13_mapping_mapel.nomor_urut') as $nilai_kelompok_a)
                      <td class="text-center">{{$nilai_kelompok_a->nilai_pengetahuan}}</td>
                      <td class="text-center">{{$nilai_kelompok_a->nilai_keterampilan}}</td>
                      @php
                        $jumlah_nilai += $nilai_kelompok_a->nilai_pengetahuan + $nilai_kelompok_a->nilai_keterampilan;
                      @endphp
                      @endforeach

                      @foreach($anggota_kelas->data_nilai_kelompok_b->sortBy('pembelajaran.mapel.k13_mapping_mapel.nomor_urut') as $nilai_kelompok_b)
                      <td class="text-center">{{$nilai_kelompok_b->nilai_pengetahuan}}</td>
                      <td class="text-center">{{$nilai_kelompok_b->nilai_keterampilan}}</td>
                      @php
                        $jumlah_nilai += $nilai_kelompok_b->nilai_pengetahuan + $nilai_kelompok_b->nilai_keterampilan;
                      @endphp
                      @endforeach

                      <td class="text-center">{{ $jumlah_nilai }}</td>

                      {{-- Predikat --}}
                      @if($jumlah_nilai >= 80)
                        <td class="text-center">A</td>
                      @elseif($jumlah_nilai >= 70)
                        <td class="text-center">B</td>
                      @elseif($jumlah_nilai >= 60)
                        <td class="text-center">C</td>
                      @else
                        <td class="text-center">D</td>
                      @endif

                      {{-- Peringkat --}}
                      @php
                        $peringkat = $data_anggota_kelas->sortByDesc(function($item) {
                          return $item->data_nilai_kelompok_a->sum('nilai_pengetahuan') + $item->data_nilai_kelompok_a->sum('nilai_keterampilan') + 
                                $item->data_nilai_kelompok_b->sum('nilai_pengetahuan') + $item->data_nilai_kelompok_b->sum('nilai_keterampilan');
                        });
                        $peringkat_index = $peringkat->search(function ($item) use ($anggota_kelas) {
                          return $item->id == $anggota_kelas->id;
                        });
                      @endphp
                      <td class="text-center">{{ $peringkat_index + 1 }}</td>

                      {{-- Kehadiran --}}
                      @if(!is_null($anggota_kelas->kehadiran_siswa))
                      <td class="text-center">{{$anggota_kelas->kehadiran_siswa->sakit}}</td>
                      <td class="text-center">{{$anggota_kelas->kehadiran_siswa->izin}}</td>
                      <td class="text-center">{{$anggota_kelas->kehadiran_siswa->tanpa_keterangan}}</td>
                      @else
                      <td class="text-center">-</td>
                      <td class="text-center">-</td>
                      <td class="text-center">-</td>
                      @endif

                      {{-- Dropdown dan tempat nilai di dalam <td> --}}
                      <td colspan="{{ $count_ekstrakulikuler }}" class="text-center">
                        <div class="d-flex justify-content-center align-items-center">
                          <select id="ekskul-select-{{ $anggota_kelas->id }}"
                                  class="form-control form-control-sm d-inline-block w-auto"
                                  onchange="tampilkanNilaiEkskul(this, {{ $anggota_kelas->id }})">
                            <option value="">-- Pilih Ekskul --</option>
                            @foreach($data_ekstrakulikuler->sortBy('id') as $ekskul)
                              <option value="{{ $ekskul->nama_ekstrakulikuler }}">{{ $ekskul->nama_ekstrakulikuler }}</option>
                            @endforeach
                          </select>
                          <div id="nilai-ekskul-{{ $anggota_kelas->id }}" class="ms-2 px-2 py-1 border rounded bg-light" style="min-width: 120px;">-</div>
                        </div>
                      </td>


                      {{-- Data JS untuk tiap anggota kelas --}}
                      <script>
                        window.dataNilaiEkskul = window.dataNilaiEkskul || {};
                        window.dataNilaiEkskul[{{ $anggota_kelas->id }}] = @json($anggota_kelas->data_nilai_ekstrakulikuler->mapWithKeys(function($nilai) {
                          return [$nilai->nama_ekskul => ['nilai' => $nilai->nilai]];
                        }));
                      </script>


                    </tr>
                    @endforeach
                  </tbody>

                </table>
              </div>
              <!-- /.table-responsive -->
            </div>
            <!-- /.card-body -->
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

<script>
  // Data nilai ekskul dalam bentuk JS
  const dataNilaiEkskul = @json($data_anggota_kelas->mapWithKeys(function($anggota) {
    return [
      $anggota->id => $anggota->data_nilai_ekstrakulikuler->mapWithKeys(function($nilai) {
        return [
          $nilai->nama_ekskul => ['nilai' => $nilai->nilai]
        ];
      })
    ];
  }));

  function tampilkanNilaiEkskul(selectElement, anggotaId) {
    const namaEkskul = selectElement.value;
    const container = document.getElementById('nilai-ekskul-' + anggotaId);
    const nilaiData = dataNilaiEkskul[anggotaId]?.[namaEkskul];

    if (nilaiData) {
      const teks = ['-', 'Kurang', 'Cukup', 'Baik', 'Sangat Baik'];
      container.innerText = teks[nilaiData.nilai] ?? '-';
    } else {
      container.innerText = '-';
    }
  }

  // Ketika halaman dimuat, otomatis tampilkan nilai ekskul pertama
  document.addEventListener('DOMContentLoaded', function() {
    @foreach($data_anggota_kelas as $anggota)
      const selectEkskul{{ $anggota->id }} = document.getElementById('ekskul-select-{{ $anggota->id }}');
      if (selectEkskul{{ $anggota->id }}.options.length > 1) {
        selectEkskul{{ $anggota->id }}.selectedIndex = 1; // Pilih ekskul pertama
        tampilkanNilaiEkskul(selectEkskul{{ $anggota->id }}, {{ $anggota->id }});
      }
    @endforeach
  });
</script>
