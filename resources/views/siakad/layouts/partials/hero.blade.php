<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
            <div class="flex-grow-1">
                <h1 class="h3 fw-bold mb-2">
                    {{ Request::routeIs('profil_pengguna.edit', 'profil_pengguna.chpassword', 'periode.index', 'kelas.index', 'mapel.index', 'pengajaran.index', 'penjadwalan.index', 'data_siswa.index', 'rekapitulasi.index', 'ekstrakuliuler.index', ) ? $sub_sub_judul : $sub_judul }}
                </h1>
                <h2 class="fs-base lh-base fw-medium text-muted mb-0">
                    {!! $text_singkat !!}
                </h2>
            </div>
            <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-alt">
                    <li class="breadcrumb-item">
                        <a class="link-fx" href="javascript:void(0)">{{ $judul }}</a>
                    </li>
                    <li class="breadcrumb-item" aria-current="page">
                        {{ $sub_judul }}
                    </li>
                    {!! Request::routeIs('profil_pengguna.edit', 'profil_pengguna.chpassword', 'periode.index', 'kelas.index', 'mapel.index', 'pengajaran.index', 'penjadwalan.index', 'data_siswa.index', 'rekapitulasi.index', 'ekstrakuliuler.index', ) ? '<li class="breadcrumb-item" aria-current="page">' . $sub_sub_judul . '</li>' : '' !!}
                </ol>
            </nav>
        </div>
    </div>
</div>
