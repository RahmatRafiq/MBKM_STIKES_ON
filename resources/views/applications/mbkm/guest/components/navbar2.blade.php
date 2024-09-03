<nav>
  <div role="tablist" class="tabs tabs-bordered flex flex-wrap items-center justify-center">
    <a role="tab" class="tab whitespace-nowrap tab-active" tab-target="tab-1">Kampus Mengajar</a>
    <a role="tab" class="tab whitespace-nowrap" tab-target="tab-2">Studi Independen</a>
    <a role="tab" class="tab whitespace-nowrap" tab-target="tab-3">Pertukaran Mahasiswa</a>
    <a role="tab" class="tab whitespace-nowrap" tab-target="tab-4">Program Lain</a>
  </div>

  <div class="p-3 max-w-screen-sm mx-auto">
    <div role="tabpanel" class="tab-content grid md:grid-cols-[300px_1fr_1fr_1fr]" id="tab-1">
      <div>
        <h2 class="text-xl font-bold">Kampus Mengajar MSIB</h2>
        <p>
          Bantu peningkatan kualitas pendidikan dasar dengan terlibat langsung
          pada proses pengajaran di sekolah-sekolah yang berlokasi
          di seluruh indonesia.
        </p>
      </div>
    </div>
    <div role="tabpanel" class="tab-content md:grid-cols-[300px_1fr_1fr_1fr]" id="tab-2">
      <div>
        <h2 class="text-xl font-bold">Studi Independen Bersertifikat</h2>
        <p>
          Jalankan proyek penelitian dengan studi kasus nyata dari para pelaku industri ternama.
        </p>
      </div>
    </div>
    <div role="tabpanel" class="tab-content md:grid-cols-[300px_1fr_1fr_1fr]" id="tab-3">
      <div>
        <h2 class="text-xl font-bold">Pertukaran Mahasiswa Merdeka</h2>
        <p>
          Program pertukaran dengan universitas lain dari seluruh Indonesia yang bertujuan untuk
          memperkaya khazanah budayamu.
        </p>
      </div>
    </div>
    <div role="tabpanel" class="tab-content md:grid-cols-[300px_1fr_1fr_1fr]" id="tab-4">
      <div>
        <h2 class="text-xl font-bold">Program dan Kegiatan Lainnya</h2>
        <p>
          Program dan kegiatan lainnya yang diselenggarakan oleh MSIB.
        </p>
      </div>
    </div>
  </div>
</nav>

<script>
  const tabs = document.querySelectorAll('.tabs .tab');
  const tabContents = document.querySelectorAll('.tab-content');

  tabs.forEach((tab) => {
    tab.addEventListener('click', () => {
      const target = tab.getAttribute('tab-target');
      tabs.forEach((tab) => tab.classList.remove('tab-active'));
      tab.classList.add('tab-active');
      tabContents.forEach((tabContent) => {
        tabContent.classList.remove('grid');
        tabContent.classList.add('hidden');
        if (tabContent.id === target) {
          tabContent.classList.remove('hidden');
          tabContent.classList.add('grid');
        }
      });
    });
  });
</script>
