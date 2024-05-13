@php
  $items = [
      // [
      //     'label' => 'Dashbord',
      //     'url' => route('permission.index'),
      //     'icon_class' => 'bi bi-box',
      // ],
      [
          'label' => 'Manajemen Pengguna',
          'url' => route('permission.index'),
          'icon_class' => 'bi bi-box',
      ],
      [
          'label' => '(staff)Magang Bersertifikat',
          'url' => route('permission.index'),
          'icon_class' => 'bi bi-box',
      ],
      [
          'label' => '(staff)Kampus Mengajar',
          'url' => route('permission.index'),
          'icon_class' => 'bi bi-box',
      ],
      [
          'label' => '(staff)Pertukaran Mahasiswa',
          'url' => route('permission.index'),
          'icon_class' => 'bi bi-box',
      ],
      [
          'label' => '(staff)Dosen Pembimbing Lapangan',
          'url' => route('permission.index'),
          'icon_class' => 'bi bi-box',
      ],
      [
          'label' => '(staff)Mitra',
          'url' => route('permission.index'),
          'icon_class' => 'bi bi-box',
      ],
      [
          'label' => '(staff)Penempatan',
          'url' => route('permission.index'),
          'icon_class' => 'bi bi-box',
      ],
      [
          'label' => 'settings',
          'url' => route('permission.index'),
          'icon_class' => 'bi bi-box',
      ],
      [
          'label' => '(peserta)Pendaftaran',
          'url' => route('permission.index'),
          'icon_class' => 'bi bi-box',
      ],
      [
          'label' => '(peserta)Isi Laporan',
          'url' => route('permission.index'),
          'icon_class' => 'bi bi-box',
      ],
      [
          'label' => '(peserta)Pertukaran Mahasiswa',
          'url' => route('permission.index'),
          'icon_class' => 'bi bi-box',
      ],
      [
          'label' => '(peserta)Dosen Pembimbing Lapangan',
          'url' => route('permission.index'),
          'icon_class' => 'bi bi-box',
      ],
      [
          'label' => '(peserta)Mitra',
          'url' => route('permission.index'),
          'icon_class' => 'bi bi-box',
      ],
      [
          'label' => 'Add Product',
          'url' => route('permission.index'),
          'icon_class' => 'bi bi-box',
      ],
      [
          'label' => 'logout',
          'url' => route('permission.index'),
          'icon_class' => 'bi bi-box',
      ],
  ];
@endphp

<!-- Sidebar wrapper start -->
<nav id="sidebar" class="sidebar-wrapper">

  <!-- Sidebar profile starts -->
  {{-- <div class="shop-profile">
    <p class="mb-1 fw-bold text-primary">Walmart</p>
    <p class="m-0">Los Angeles, California</p>
  </div> --}}
  <!-- Sidebar profile ends -->

  <!-- Sidebar menu starts -->
  <div class="sidebarMenuScroll">
    <ul class="sidebar-menu">
      <li class="active current-page">
        <a href="/dashboard">
          <i class="bi bi-box"></i>
          <span class="menu-text">Dashboard</span>
        </a>
      </li>
      @foreach ($items as $item)
        <li>
          <a href="{{ $item['url'] }}">
            <i class="{{ $item['icon_class'] }}"></i>
            <span class="menu-text">{{ $item['label'] }}</span>
          </a>
        </li>
      @endforeach
      {{-- <li class="treeview">
          <a href="#!">
            <i class="bi bi-stickies"></i>
            <span class="menu-text">Components</span>
          </a>
          <ul class="treeview-menu">
            <li>
              <a href="accordions.html">Accordions</a>
            </li>
            <li>
              <a href="alerts.html">Alerts</a>
            </li>
            <li>
              <a href="buttons.html">Buttons</a>
            </li>
            <li>
              <a href="badges.html">Badges</a>
            </li>
            <li>
              <a href="carousel.html">Carousel</a>
            </li>
            <li>
              <a href="list-items.html">List Items</a>
            </li>
            <li>
              <a href="progress.html">Progress Bars</a>
            </li>
            <li>
              <a href="popovers.html">Popovers</a>
            </li>
            <li>
              <a href="tooltips.html">Tooltips</a>
            </li>
          </ul>
        </li> --}}

    </ul>
  </div>
  <!-- Sidebar menu ends -->

</nav>
<!-- Sidebar wrapper end -->
