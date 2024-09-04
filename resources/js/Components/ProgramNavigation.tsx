import KampusMengajarLogo from '@/Images/kampus-mengajar.webp'
import MagangLogo from '@/Images/msib-logo.webp'
import PertukaranMahasiswaLogo from '@/Images/pmm.webp'
import { Button, Card, CardBody, Image, Link, Tab, Tabs } from "@nextui-org/react"

type TabType = {
  id: string;
  title: string;
  description: string;
  logo: string;
  buttonLinks: {
    label: string;
    url: string;
    color?: 'default' | 'primary' | 'secondary' | 'success' | 'warning' | 'danger';
    variant?: 'solid' | 'bordered' | 'light' | 'flat' | 'faded' | 'shadow' | 'ghost'
  }[]
  announcement?: string | JSX.Element;
  menu?: {
    label: string;
    submenu: {
      label: string;
      url: string;
    }[]
  }[]
}

const tabs: TabType[] = [
  {
    id: 'kampus-mengajar',
    title: 'Kampus Mengajar',
    description: 'Mari bersama tingkatkan mutu pendidikan dasar di seluruh Indonesia dengan aktif mengajar di sekolah-sekolah.',
    logo: KampusMengajarLogo,
    buttonLinks: [
      {
        label: 'Selengkapnya',
        url: '#',
        color: 'primary',
      }
    ],
    announcement: (
      <>
        <p>
          Pendaftaran:
        </p>
        <p>
          Telah ditutup pada 30 Agustus 2021
        </p>
      </>
    ),
    menu: [
      {
        label: 'Pendaftaran',
        submenu: [
          {
            label: 'Cara Mendaftar',
            url: '#'
          },
          {
            label: 'Syarat & Ketentuan',
            url: '#'
          }
        ]
      },
      {
        label: 'Seleksi dan Penerimaan',
        submenu: [
          {
            label: 'Proses Seleksi',
            url: '#'
          },
          {
            label: 'Pengerjaan Tes',
            url: '#'
          }
        ]
      },
      {
        label: 'Pelaksanaan Program',
        submenu: [
          {
            label: 'Pembekalan',
            url: '#'
          },
          {
            label: 'Pengisian Log Mingguan',
            url: '#'
          },
          {
            label: 'Laporan Akhir',
            url: '#'
          }
        ]
      }
    ]
  },
  {
    id: 'magang MSIB',
    title: 'Magang MSIB',
    description: 'Siap kerja? Mulai pengalamanmu sekarang.',
    logo: MagangLogo,
    buttonLinks: [
      {
        label: 'Daftar Sekarang',
        url: '#',
        color: 'primary',
      },
      {
        label: 'Selengkapnya',
        url: '#',
        color: 'default',
        variant: 'bordered'
      },
    ],
    menu: [
      {
        label: 'Pendaftaran',
        submenu: [
          {
            label: 'Cara Mendaftar',
            url: '#'
          },
          {
            label: 'Syarat & Ketentuan',
            url: '#'
          }
        ]
      },
      {
        label: 'Seleksi dan Penerimaan',
        submenu: [
          {
            label: 'Cara Menerima Tawaran',
            url: '#'
          },
          {
            label: 'Cara Melihat Status Pendaftaran',
            url: '#'
          }
        ]
      },
      {
        label: 'Pelaksanaan Program',
        submenu: [
          {
            label: 'Pengisian Logboook dan Laporan Aktif',
            url: '#'
          },
          {
            label: 'Pengisian Laporan Akhir',
            url: '#'
          }
        ]
      }
    ]
  },
  {
    id: 'studi-independen',
    title: 'Studi Independen Bersertifikat',
    description: 'Jalankan proyek penelitian dengan studi kasus nyata dari para pelaku industri ternama.',
    logo: MagangLogo,
    buttonLinks: [
      {
        label: 'Cari Kelas Studi Independen',
        url: '#',
        color: 'primary',
      },
      {
        label: 'Selengkapnya',
        url: '#',
        color: 'default',
        variant: 'bordered'
      },
    ],
    menu: [
      {
        label: 'Pendaftaran',
        submenu: [
          {
            label: 'Cara Mendaftar',
            url: '#'
          },
          {
            label: 'Syarat & Ketentuan',
            url: '#'
          }
        ]
      },
      {
        label: 'Seleksi dan Penerimaan',
        submenu: [
          {
            label: 'Cara Menerima Tawaran',
            url: '#'
          },
          {
            label: 'Cara Melihat Status Pendaftaran',
            url: '#'
          }
        ]
      },
      {
        label: 'Pelaksanaan Program',
        submenu: [
          {
            label: 'Pengisian Logboook dan Laporan Aktif',
            url: '#'
          },
          {
            label: 'Laporan Akhir',
            url: '#'
          }
        ]
      }
    ]
  },
  {
    id: 'pertukaran-mahasiswa',
    title: 'Pertukaran Mahasiswa Merdeka',
    description: 'Program pertukaran dengan universitas lain dari seluruh Indonesia yang bertujuan untuk memperkaya khazanah budayamu.',
    logo: PertukaranMahasiswaLogo,
    buttonLinks: [
      {
        label: 'Selengkapnya',
        url: '#',
        color: 'primary',
      }
    ],
    menu: [
      {
        label: 'Pendaftaran',
        submenu: [
          {
            label: 'Cara Mendaftar',
            url: '#'
          },
          {
            label: 'Syarat & Ketentuan',
            url: '#'
          }
        ]
      },
      {
        label: 'Seleksi dan Penerimaan',
        submenu: [
          {
            label: 'Skema Umum Program',
            url: '#'
          },
          {
            label: 'Proses Seleksi',
            url: '#'
          }
        ]
      },
      {
        label: 'Pelaksanaan Program',
        submenu: [
          {
            label: 'Pengisian Laporan Bulanan',
            url: '#'
          },
          {
            label: 'Peraturan Program MBKM',
            url: '#'
          }
        ]
      }
    ]
  }
]

const ProgramNavigation = () => {
  return (
    <section id="program-navigation"
      className="flex w-full flex-col p-3"
    >
      <Tabs aria-label="Dynamic tabs" items={tabs} classNames={{
        base: 'mx-auto w-full',
        tabList: 'overflow-x-scroll mx-auto',
      }}>
        {(item) => (
          <Tab key={item.id} title={item.title}>
            <Card>
              <CardBody className="flex flex-col gap-3 lg:flex-row lg:p-10">
                <div className='lg:w-96 flex flex-col'>
                  <div>
                    <Image width={'auto'} height={50} src={item.logo} alt={item.title} className="bg-white p-1" />
                    <h3>{item.description}</h3>
                  </div>
                  <div>
                    <p className='text-gray-500'>
                      {item.announcement}
                    </p>
                    <div className="flex gap-3">
                      {
                        item.buttonLinks.map((buttonLink, index) => (
                          <a key={index} href={buttonLink.url}>
                            <Button color={buttonLink.color} variant={buttonLink.variant}>
                              {buttonLink.label}
                            </Button>
                          </a>
                        ))
                      }
                    </div>
                  </div>
                </div>
                <div className="py-3 divide-y lg:divide-y-0 flex flex-col gap-3 lg:flex-row">
                  {
                    item.menu?.map((menu, index) => (
                      <div key={index} className="grid grid-cols-1 divide-slate-400/25 gap-3 pt-3">
                        <h4 className="text-gray-400">{menu.label}</h4>
                        {
                          menu.submenu.map((submenu, index) => (
                            <Link key={index} href={submenu.url}>
                              {submenu.label}
                            </Link>
                          ))
                        }
                      </div>
                    ))
                  }
                </div>
              </CardBody>
            </Card>
          </Tab>
        )}
      </Tabs>
    </section>
  )
}

export default ProgramNavigation
