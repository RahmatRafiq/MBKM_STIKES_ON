@if ($selectedLowongan)
    <div class="card mb-3">
        <div class="card-body">
            <div class="d-flex">
                <img src="{{ $selectedLowongan->mitra->getFirstMediaUrl('images') }}" id="mitraImage"
                    class="rounded-circle me-3 img-4x" alt="Mitra Image" style="width: 60px; height: 60px;" />
                <div class="flex-grow-1">
                    <p id="lowonganCreate" class="float-end text-info mb-1">{{ $selectedLowongan->created_at->diffForHumans() }}</p>
                    <h6 id="mitraName" class="fw-bold mb-2">{{ $selectedLowongan->mitra->name }}</h6>
                    <h6 id="mitraName" class="fw-bold mb-2">{{ $selectedLowongan->name }}</h6>
                    <p><i class="bi bi-file-text fs-5 mb-2"></i> Deskripsi: <span id="lowonganDescription">{{ $selectedLowongan->description }}</span></p>
                    <div class="d-flex justify-content-between align-items-center mt-2">
                        <form action="{{ route('peserta.registrasi') }}" method="POST" class="me-2">
                            @csrf
                            <input type="hidden" name="peserta_id"
                                value="{{ auth()->user()->peserta->id }}">
                            <input type="hidden" name="lowongan_id" value="{{ $selectedLowongan->id }}">
                            <input type="hidden" name="nama_peserta" value="{{ auth()->user()->nama }}">
                            <input type="hidden" name="nama_lowongan" value="{{ $selectedLowongan->name }}">
                            <button type="submit" class="btn btn-primary">Daftar</button>
                        </form>
                        <!-- Share Button -->
                        <button id="shareButton" class="btn btn-outline-primary">Share</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- Slider Gambar -->
    @if ($selectedLowongan->mitra->getMedia('images')->isNotEmpty())
    <div id="carouselExampleIndicators" class="carousel slide mb-3" data-bs-ride="carousel">
        <div class="carousel-indicators">
            @foreach ($selectedLowongan->mitra->getMedia('images') as $index => $image)
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="{{ $index }}"
                @if ($index==0) class="active" aria-current="true" @endif
                aria-label="Slide {{ $index + 1 }}"></button>
            @endforeach
        </div>
        <div class="carousel-inner">
            @foreach ($selectedLowongan->mitra->getMedia('images') as $index => $image)
            <div class="carousel-item @if ($index == 0) active @endif">
                <div class="carousel-image-placeholder" data-src="{{ $image->getUrl() }}" style="width: 100%; height: 400px; background: #f0f0f0;"></div>
            </div>
            @endforeach
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
            data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
            data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
    @endif
    <div class="card mb-3">
        <div class="card-header">
            <h5 class="card-title">About</h5>
        </div>
        <div class="card-body">
            <h6 id="mitraLocation" class="d-flex align-items-center mb-3">
                <i class="bi bi-house fs-2 me-2"></i> Lokasi:
                <span class="ms-2">{{ $selectedLowongan->location }}</span>
            </h6>
            <h6 class="d-flex align-items-center mb-3">
                <i class="bi bi-building fs-2 me-2"></i> Mitra:
                <span id="mitraWorks" class="text-primary ms-2">{{ $selectedLowongan->mitra->name }}</span>
            </h6>
            <h6 class="d-flex align-items-center mb-3">
                <i class="bi bi-globe-americas fs-2 me-2"></i> Website:
                <span id="mitraWebsite" class="text-primary ms-2"><a href="{{ $selectedLowongan->mitra->website }}" target="_blank">{{ $selectedLowongan->mitra->website }}</a></span>
            </h6>
            <p id="mitraDescription">{{ $selectedLowongan->mitra->description }}</p>
        </div>
    </div>
    <script>
        $('#shareButton').on('click', function () {
            let lowonganId = '{{ $selectedLowongan->id }}';
            let currentUrl = `${window.location.origin}/peserta/registrasi?lowongan_id=${lowonganId}`;

            // Check if the Web Share API is supported
            if (navigator.share) {
                navigator.share({
                    title: 'Bagikan Lowongan',
                    text: `Ayo lihat lowongan ini: {{ $selectedLowongan->name }}`,
                    url: currentUrl
                }).then(() => {
                    console.log('Berhasil dibagikan');
                }).catch((error) => {
                    console.error('Gagal membagikan', error);
                });
            } else {
                // Fallback for browsers that do not support the Web Share API
                prompt('Salin dan bagikan link ini:', currentUrl);
            }
        });
    </script>
@endif
