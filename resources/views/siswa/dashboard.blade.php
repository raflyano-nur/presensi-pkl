@extends('layouts.siswa.main')
@section('content')
<style>
    .list-kegiatan  {
    list-style: none;
    padding: 0;
    margin: 0;
}

.list-kegiatan  li {
    border-bottom: 1px solid #ccc; /* Garis horizontal */
    padding: 5px;
}

.item {
    display: flex;
    align-items: center;
}

.left {
    width: 40%; /* Atur lebar sesuai kebutuhan */
}

.right {
    width: 100%; /* Mengisi penuh */
}

.ine {
    display: flex;
    flex-direction: column;
}

.presencetab {
    padding-bottom: 5rem;
}

</style>
<div class="section" id="presence-section">
    <div class="todaypresence">
        <div class="row">
            <div class="col-6">
                <a href="/internship-presensi">
                <div class="card gradasigreen">
                    <div class="card-body">
                        <div class="presencecontent">
                            <div class="iconpresence">
                                <ion-icon name="camera"></ion-icon>
                            </div>
                            <div class="presencedetail">
                                    <h4 class="presencetitle">Masuk</h4>
                                    <span>07:00</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-6">
                <a href="/internship-presensi">
                <div class="card gradasired">
                    <div class="card-body">
                        <div class="presencecontent">
                            <div class="iconpresence">
                                <ion-icon name="camera"></ion-icon>
                            </div>
                            <div class="presencedetail">
                                    <h4 class="presencetitle">Pulang</h4>
                                    <span>12:00</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <div class="presencetab">
        <div class="tab-pane" id="profile" role="tabpanel">
            <div class="row mb-2 d-flex justify-content-center">
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="rekappresencetitle text-center mt-1">Kegiatan Harian</h4>
                        </div>
                    </div>
                </div>
            </div>
            <ul class="list-kegiatan listview image-listview">
                @if ($KegiatanPkl && $KegiatanPkl->count() > 0)
                    @foreach ($KegiatanPkl as $DataKegiatan)
                        @php
                            $tgl_kegiatan = \Carbon\Carbon::parse($DataKegiatan->tgl_kegiatan)->format('d F Y');
                            $waktu = \Carbon\Carbon::parse($DataKegiatan->created_at)->format('H:i:s');
                        @endphp
                        <li>
                            <div class="item right">
                                <div class="in">
                                    <div>{{ $DataKegiatan->deskripsi_kegiatan }}</div>
                                    <div class="ine">
                                        <span class="text-muted">{{ $tgl_kegiatan }}</span>
                                        <span class="text-muted">{{ $waktu }}</span>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endforeach
                @else
                    <li>
                        <div class="item right">
                            <div class="in">
                                <div class="p-2">Tidak ada kegiatan hari ini</div>
                            </div>
                        </div>
                    </li>
                @endif
            </ul>
        </div>
    </div>
    
    {{-- <div class="rekappresence"> --}}
        {{-- <div id="chartdiv"></div> --}}
        <!-- <div class="row">
            <div class="col-6">
                <div class="card">
                    <div class="card-body">
                        <div class="presencecontent">
                            <div class="iconpresence primary">
                                <ion-icon name="log-in"></ion-icon>
                            </div>
                            <div class="presencedetail">
                                <h4 class="rekappresencetitle">Hadir</h4>
                                <span class="rekappresencedetail">0 Hari</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card">
                    <div class="card-body">
                        <div class="presencecontent">
                            <div class="iconpresence green">
                                <ion-icon name="document-text"></ion-icon>
                            </div>
                            <div class="presencedetail">
                                <h4 class="rekappresencetitle">Izin</h4>
                                <span class="rekappresencedetail">0 Hari</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-1">
            <div class="col-6">
                <div class="card">
                    <div class="card-body">
                        <div class="presencecontent">
                            <div class="iconpresence warning">
                                <ion-icon name="sad"></ion-icon>
                            </div>
                            <div class="presencedetail">
                                <h4 class="rekappresencetitle">Sakit</h4>
                                <span class="rekappresencedetail">0 Hari</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card">
                    <div class="card-body">
                        <div class="presencecontent">
                            <div class="iconpresence danger">
                                <ion-icon name="alarm"></ion-icon>
                            </div>
                            <div class="presencedetail">
                                <h4 class="rekappresencetitle">Terlambat</h4>
                                <span class="rekappresencedetail">0 Hari</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
    {{-- </div> --}}
    {{-- <div class="presencetab mt-2">
        <div class="tab-pane fade show active" id="pilled" role="tabpanel">
            <ul class="nav nav-tabs style1" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#home" role="tab">
                        Bulan Ini
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#profile" role="tab">
                        Leaderboard
                    </a>
                </li>
            </ul>
        </div>
        <div class="tab-content mt-2" style="margin-bottom:100px;">
            <div class="tab-pane fade show active" id="home" role="tabpanel">
                <ul class="listview image-listview">
                    <li>
                        <div class="item">
                            <div class="icon-box bg-primary">
                                <ion-icon name="image-outline" role="img" class="md hydrated"
                                    aria-label="image outline"></ion-icon>
                            </div>
                            <div class="in">
                                <div>Photos</div>
                                <span class="badge badge-danger">10</span>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="item">
                            <div class="icon-box bg-secondary">
                                <ion-icon name="videocam-outline" role="img" class="md hydrated"
                                    aria-label="videocam outline"></ion-icon>
                            </div>
                            <div class="in">
                                <div>Videos</div>
                                <span class="text-muted">None</span>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="item">
                            <div class="icon-box bg-danger">
                                <ion-icon name="musical-notes-outline" role="img" class="md hydrated"
                                    aria-label="musical notes outline"></ion-icon>
                            </div>
                            <div class="in">
                                <div>Music</div>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="item">
                            <div class="icon-box bg-danger">
                                <ion-icon name="musical-notes-outline" role="img" class="md hydrated"
                                    aria-label="musical notes outline"></ion-icon>
                            </div>
                            <div class="in">
                                <div>Music</div>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="item">
                            <div class="icon-box bg-danger">
                                <ion-icon name="musical-notes-outline" role="img" class="md hydrated"
                                    aria-label="musical notes outline"></ion-icon>
                            </div>
                            <div class="in">
                                <div>Music</div>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="item">
                            <div class="icon-box bg-danger">
                                <ion-icon name="musical-notes-outline" role="img" class="md hydrated"
                                    aria-label="musical notes outline"></ion-icon>
                            </div>
                            <div class="in">
                                <div>Music</div>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="item">
                            <div class="icon-box bg-danger">
                                <ion-icon name="musical-notes-outline" role="img" class="md hydrated"
                                    aria-label="musical notes outline"></ion-icon>
                            </div>
                            <div class="in">
                                <div>Music</div>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="item">
                            <div class="icon-box bg-danger">
                                <ion-icon name="musical-notes-outline" role="img" class="md hydrated"
                                    aria-label="musical notes outline"></ion-icon>
                            </div>
                            <div class="in">
                                <div>Music</div>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="item">
                            <div class="icon-box bg-danger">
                                <ion-icon name="musical-notes-outline" role="img" class="md hydrated"
                                    aria-label="musical notes outline"></ion-icon>
                            </div>
                            <div class="in">
                                <div>Music</div>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="item">
                            <div class="icon-box bg-danger">
                                <ion-icon name="musical-notes-outline" role="img" class="md hydrated"
                                    aria-label="musical notes outline"></ion-icon>
                            </div>
                            <div class="in">
                                <div>Music</div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="tab-pane fade" id="profile" role="tabpanel">
                <ul class="listview image-listview">
                    <li>
                        <div class="item">
                            <img src="assets/img/sample/avatar/avatar1.jpg" alt="image" class="image">
                            <div class="in">
                                <div>Edward Lindgren</div>
                                <span class="text-muted">Designer</span>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="item">
                            <img src="assets/img/sample/avatar/avatar1.jpg" alt="image" class="image">
                            <div class="in">
                                <div>Emelda Scandroot</div>
                                <span class="badge badge-primary">3</span>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="item">
                            <img src="assets/img/sample/avatar/avatar1.jpg" alt="image" class="image">
                            <div class="in">
                                <div>Henry Bove</div>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="item">
                            <img src="assets/img/sample/avatar/avatar1.jpg" alt="image" class="image">
                            <div class="in">
                                <div>Henry Bove</div>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="item">
                            <img src="assets/img/sample/avatar/avatar1.jpg" alt="image" class="image">
                            <div class="in">
                                <div>Henry Bove</div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>

        </div>
    </div> --}}
</div>
@endsection