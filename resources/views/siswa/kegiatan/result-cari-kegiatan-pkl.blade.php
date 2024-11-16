<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
    <meta name="theme-color" content="#000000">
    <title>Mobilekit Mobile UI Kit</title>
    <meta name="description" content="Mobilekit HTML Mobile UI Kit">
    <meta name="keywords" content="bootstrap 4, mobile template, cordova, phonegap, mobile, html" />
    
    <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}" sizes="32x32">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/img/icon/192x192.png') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="manifest" href="__manifest.json">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
</head>

<body>

<!-- Loader (Spinner) -->
<div id="loader">
    <div class="spinner-border text-primary" role="status"></div>
</div>

<!-- Back Button -->
<div class="row">
    <div class="card shadow-sm mb-3 col-12">
        <div class="card-body d-flex align-items-center">
            <a href="{{ route('siswa.dashboard') }}">
                <i class="bi bi-arrow-left me-3 text-primary" style="font-size: 1.5rem;"></i>
            </a>
            <p class="mb-0 fw-bold">Kembali</p>
        </div>
    </div>

    <!-- Year Selection Form -->
    <form action="{{ route('cari.kegiatan.siswa') }}" method="post">
        @csrf
        <div class="row mb-3 justify-content-center p-2">
            <div class="col-12 col-md-4 col-lg-4">
                <div class="card">
                    <div class="card-body">
                            <div class="d-flex">
                                    <select name="tgl_kegiatan" class="form-select" aria-label="Pilih Bulan">
                                        @if ($bulan_masuk <= $bulan_keluar)
                                        <option disabled selected>---- Pilih Bulan ----</option>
                                        <option value="semua">Semua Bulan</option>
                                        @for ($bulan = $bulan_masuk; $bulan <= $bulan_keluar; $bulan++)
                                            <option value="{{ $bulan }}">{{ \Carbon\Carbon::createFromFormat('m', $bulan)->format('F') }}</option>
                                        @endfor
                                        @else
                                            <p>Invalid month range</p>
                                        @endif
                                    
                                    </select>
                                
                                <button type="submit" class="btn btn-primary ms-2"><i class="bi bi-search"></i></button>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

<!-- Display Cards for Available Data -->
@if ($bulanTahun->isEmpty())
    <!-- Jika tidak ada data bulan, tampilkan card untuk bulan saat ini -->
    <div class="col-4 col-md-4 col-lg-2 padding-card">
        <div class="card harian-card" onclick="showModal('{{ $fullDate }}')">
            <div class="card-body">
                <p class="card-center" id="modalMonthYear">{{ $fullDate }}</p>
            </div>
        </div>
    </div>
@else
    @foreach ($bulanTahun as $bulanTahunSiswa)
        <div class="col-md-12 col-lg-4 padding-card">
            <div class="card harian-card fs-5" onclick="showModal('{{ $bulanTahunSiswa }}')">
                <div class="card-body">
                    <p class="card-center" id="modalMonthYear">{{ $bulanTahunSiswa }}</p>
                </div>
            </div>
        </div>
    @endforeach
@endif

</div>

<!-- Modal -->
<div class="modal fade" id="harianModal" tabindex="-1" aria-labelledby="harianModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail kegiatan untuk {{ $bulanTahun[0] ?? \Carbon\Carbon::now()->format('F Y') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @foreach ($KegiatanPkl as $key => $tanggal)
                <form action="{{ route('create.kegiatan.siswa') }}" method="post">
                    @csrf
                    <input type="hidden" name="tgl_kegiatan" id="month_year" value="{{ $tanggal }}">
                    <input type="hidden" name="nis" value="{{ session('nis') }}">
            
                    <div id="dynamicInputs">
                        <div class="card mb-3">
                            <div class="card-body">
                                {{-- <p id="currentDateParagraph" class="fw-bold">{{ \Carbon\Carbon::parse($key)->format('D, j F Y') }}</p> --}}
                                <p id="currentDateParagraph" class="fw-bold">
                                    {{ \Carbon\Carbon::parse($key)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
                                </p>
                                
                                <!-- Activity description input -->
                                <div class="d-flex mb-2">
                                    <input type="text" name="deskripsi_kegiatan" placeholder="Apa Aktivitas Kamu Hari Ini ?" class="form-control mb-2">
                                    <button type="submit" class="btn btn-success ms-2">Submit</button>
                                </div>
            
                                <div class="progress mb-4">
                                    <div id="progressBar" class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%;"></div>
                                </div>
        
                                @foreach ($KegiatanPkl[$key] as $activity)
                                <div class="d-flex justify-content-between mb-2">

                                    <form action="{{ route('checkbox.kegiatan.siswa') }}" method="post" class="checkbox-form">
                                        @csrf
                                        <div class="form-check">
                                            <!-- Ensure ID is unique by appending $activity->kegiatanID -->
                                            <input class="form-check-input" name="kegiatanID" @if ($activity->status_kegiatan == "diterima") checked disabled @endif value="{{ $activity->kegiatanID }}" onchange="submitFormInsideModal()" type="checkbox" 
                                            id="flexCheckDefault">
                                            <label class="form-check-label text-capitalize text-dark fw-bold @if ($activity->status_kegiatan == "diterima") text-decoration-line-through @endif" for="flexCheckDefault{{ $activity->kegiatanID }}">
                                                {{ $activity->deskripsi_kegiatan }}
                                            </label>
                                        </div>
                                    </form>

                                    <form action="{{ route('hapus.kegiatan.siswa') }}" method="post">
                                        @csrf
                                        <input type="hidden" name="kegiatanID" value="{{ $activity->kegiatanID }}">
                                        <button type="submit" class="btn-close" aria-label="Close"></button>
                                    </form>
                                </div>
                                @endforeach

                            </div>
                        </div>
                    </div>
                </form>
            @endforeach
            
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- External JS Libraries -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('assets/js/lib/jquery-3.4.1.min.js') }}"></script>
<script src="{{ asset('assets/js/lib/popper.min.js') }}"></script>
<script src="{{ asset('assets/js/lib/bootstrap.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
<script src="{{ asset('assets/js/plugins/owl-carousel/owl.carousel.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/jquery-circle-progress/circle-progress.min.js') }}"></script>
<script src="https://cdn.amcharts.com/lib/4/core.js"></script>
<script src="https://cdn.amcharts.com/lib/4/charts.js"></script>
<script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script>
<script src="{{ asset('assets/js/base.js') }}"></script>

<!-- Custom JS -->
<script>
    // Function to open modal and dynamically update month and year
    function showModal(bulanTahun) {
        const modal = new bootstrap.Modal(document.getElementById('harianModal'));
        document.getElementById('month_year').value = bulanTahun;
        document.getElementById('modalMonthYear').innerText = bulanTahun; // Update modal text dynamically
        modal.show();
    }

    // Submit form inside modal when a checkbox is clicked
    function submitFormInsideModal() {
        const form = event.target.closest('form'); // Find the form that contains the checkbox
        form.submit(); // Submit the form
    }
    @if (session('success'))
    var myModal = new bootstrap.Modal(document.getElementById('harianModal'), {
          keyboard: false
      });
      myModal.show();
  @endif
</script>

</body>
</html>