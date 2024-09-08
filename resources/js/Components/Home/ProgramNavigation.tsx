import KampusMengajarLogo from '@/Images/kampus-mengajar.webp'
import MagangLogo from '@/Images/msib-logo.webp'
import PertukaranMahasiswaLogo from '@/Images/pmm.webp'
import { Button, Card, CardBody, Dropdown, DropdownItem, DropdownMenu, DropdownTrigger, Image, Link, Tab, Tabs } from "@nextui-org/react"
import { useState } from 'react'
import { useMediaQuery } from 'usehooks-ts'

// Definisikan TabType untuk menjaga konsistensi tipe data
type TabType = {
  id: string;
  title: string;
  description: string;
  logo: string;
  buttonLinks: {
    label: string;
    url: string;
    color?: 'default' | 'primary' | 'secondary' | 'success' | 'warning' | 'danger';
    variant?: 'solid' | 'bordered' | 'light' | 'flat' | 'faded' | 'shadow' | 'ghost';
  }[];
  announcement?: string | JSX.Element;
  menu?: {
    label: string;
    submenu: {
      label: string;
      url: string;
    }[];
  }[];
};

type Props = {
  data: TypeProgram[]; // Pastikan TypeProgram memiliki name dan description
};

const ProgramNavigation = (props: Props) => {
  // Data statis untuk logo dan id
  const staticTabs: Omit<TabType, 'title' | 'description'>[] = [
    {
      id: 'kampus-mengajar',
      logo: KampusMengajarLogo,
      buttonLinks: [
        { label: 'Selengkapnya', url: '#', color: 'primary' },
      ],
      menu: [
        {
          label: 'Pendaftaran',
          submenu: [
            { label: 'Cara Mendaftar', url: '#' },
            { label: 'Syarat & Ketentuan', url: '#' },
          ],
        },
      ],
    },
    {
      id: 'magang-msib',
      logo: MagangLogo,
      buttonLinks: [
        { label: 'Selengkapnya', url: '#', color: 'primary' },
      ],
      menu: [
        {
          label: 'Pendaftaran',
          submenu: [
            { label: 'Cara Mendaftar', url: '#' },
            { label: 'Syarat & Ketentuan', url: '#' },
          ],
        },
      ],
    },
    {
      id: 'studi-independen',
      logo: MagangLogo,
      buttonLinks: [
        { label: 'Selengkapnya', url: '#', color: 'primary' },
      ],
      menu: [
        {
          label: 'Pendaftaran',
          submenu: [
            { label: 'Cara Mendaftar', url: '#' },
            { label: 'Syarat & Ketentuan', url: '#' },
          ],
        },
      ],
    },
    {
      id: 'pertukaran-mahasiswa',
      logo: PertukaranMahasiswaLogo,
      buttonLinks: [
        { label: 'Selengkapnya', url: '#', color: 'primary' },
      ],
      menu: [
        {
          label: 'Pendaftaran',
          submenu: [
            { label: 'Cara Mendaftar', url: '#' },
            { label: 'Syarat & Ketentuan', url: '#' },
          ],
        },
      ],
    },
  ]

  // Cek jika props.data ada dan panjangnya sesuai dengan staticTabs
  if (!props.data || props.data.length === 0) {
    return <p>Loading data...</p> // Bisa diganti dengan spinner atau loader lainnya

  }

  // Map the static data with the dynamic titles and descriptions from props
  const tabs: TabType[] = staticTabs.slice(0, props.data.length).map((tab, index) => ({
    ...tab,
    title: props.data[index]?.name || 'Default Title',
    description: props.data[index]?.description || 'Default Description',
  }))

  return (
    <section id="program-navigation" className="flex w-full flex-col p-3 max-w-screen-xl mx-auto">
      <Tabs
        aria-label="Dynamic tabs"
        items={tabs}
        classNames={{
          base: 'mx-auto w-full',
          tabList: 'overflow-x-scroll mx-auto',
        }}

      >
        {(item) => (
          <Tab key={item.id} title={item.title}>
            <Card>
              <CardBody className="flex flex-col gap-3 lg:flex-row lg:p-10">
                <div className='lg:w-96 flex flex-col gap-3'>
                  <div>
                    <Image
                      width="auto"
                      height={50}
                      src={item.logo}
                      alt={item.title}
                      className="bg-white p-1"
                    />
                    <h3>{item.description}</h3> {/* Dynamic description */}
                  </div>

                  <div className='flex flex-col gap-3'>
                    {
                      item.announcement ? (
                        <div className='text-gray-500'>
                          {item.announcement}
                        </div>
                      ) : <></>
                    }

                    <div className="flex gap-3">
                      {item.buttonLinks.map((buttonLink, index) => (
                        <a key={index} href={buttonLink.url}>
                          <Button color={buttonLink.color} variant={buttonLink.variant || 'solid'}>
                            {buttonLink.label}
                          </Button>
                        </a>
                      ))}
                    </div>
                  </div>
                </div>

                <div className="py-3 divide-y lg:divide-y-0 flex flex-col gap-3 lg:flex-row lg:py-0 ">
                  {
                    item.menu?.map((menu, index) => (
                      <div key={index} className="flex flex-col divide-slate-400/25 gap-3 pt-3">
                        <h4 className="font-bold">{menu.label}</h4>
                        {
                          menu.submenu.map((submenu, index) => (
                            <Link key={index} href={submenu.url} className='text-blue-500 dark:text-primary' underline='always'>
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
