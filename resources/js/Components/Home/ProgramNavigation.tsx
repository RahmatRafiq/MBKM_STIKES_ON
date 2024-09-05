import React, { useEffect, useState } from 'react';
import axios from 'axios';
import KampusMengajarLogo from '@/Images/kampus-mengajar.webp';
import MagangLogo from '@/Images/msib-logo.webp';
import PertukaranMahasiswaLogo from '@/Images/pmm.webp';
import { Button, Card, CardBody, Image, Link, Tab, Tabs } from "@nextui-org/react";

// Type definition for program data
type TabType = {
  id: number;
  name: string;
  description: string;
  logo: string;
  buttonLinks: {
    label: string;
    url: string;
    color?: 'default' | 'primary' | 'secondary' | 'success' | 'warning' | 'danger';
    variant?: 'solid' | 'bordered' | 'light' | 'flat' | 'faded' | 'shadow' | 'ghost';
  }[];
  menu?: {
    label: string;
    submenu: {
      label: string;
      url: string;
    }[];
  }[];
}

const ProgramNavigation = () => {
  const [programs, setPrograms] = useState<TabType[]>([]);

  useEffect(() => {
    // Fetch data from backend
    axios.get('/api/programs')
      .then(response => {
        // Transform data fetched from API to match the component's requirements
        const fetchedPrograms = response.data.map((program: any) => ({
          id: program.id,
          name: program.name,
          description: program.description,
          logo: selectLogo(program.name),  // Use static images based on the name
          buttonLinks: [
            {
              label: 'Selengkapnya',
              url: '#',
              color: 'primary',
            },
          ],
          // Example static data for demonstration
          menu: [
            {
              label: 'Pendaftaran',
              submenu: [
                {
                  label: 'Cara Mendaftar',
                  url: '#',
                },
                {
                  label: 'Syarat & Ketentuan',
                  url: '#',
                },
              ],
            },
            {
              label: 'Seleksi dan Penerimaan',
              submenu: [
                {
                  label: 'Proses Seleksi',
                  url: '#',
                },
                {
                  label: 'Pengerjaan Tes',
                  url: '#',
                },
              ],
            },
          ],
        }));
        setPrograms(fetchedPrograms);
      })
      .catch(error => {
        console.error('Error fetching data:', error);
      });
  }, []);

  // Function to select static logos based on the program name
  const selectLogo = (name: string) => {
    switch (name) {
      case 'Kampus Mengajar':
        return KampusMengajarLogo;
      case 'Magang Merdeka':
        return MagangLogo;
      case 'Pertukaran Mahasiswa':
        return PertukaranMahasiswaLogo;
      default:
        return ''; // Default logo or placeholder if no match is found
    }
  };

  return (
    <section id="program-navigation" className="flex w-full flex-col p-3 max-w-screen-xl mx-auto">
      <Tabs aria-label="Dynamic tabs" items={programs} classNames={{
        base: 'mx-auto w-full',
        tabList: 'overflow-x-scroll mx-auto',
      }}>
        {(item) => (
          <Tab key={item.id} title={item.name}>
            <Card>
              <CardBody className="flex flex-col gap-3 lg:flex-row lg:p-10">
                <div className='lg:w-96 flex flex-col'>
                  <div>
                    <Image width={'auto'} height={50} src={item.logo} alt={item.name} className="bg-white p-1" />
                    <h3>{item.description}</h3>
                  </div>
                  <div>
                    <div className="flex gap-3">
                      {item.buttonLinks.map((buttonLink, index) => (
                        <a key={index} href={buttonLink.url}>
                          <Button color={buttonLink.color} variant={buttonLink.variant}>
                            {buttonLink.label}
                          </Button>
                        </a>
                      ))}
                    </div>
                  </div>
                </div>
                <div className="py-3 divide-y lg:divide-y-0 flex flex-col gap-3 lg:flex-row lg:py-0">
                  {item.menu?.map((menu, index) => (
                    <div key={index} className="flex flex-col divide-slate-400/25 gap-3 pt-3">
                      <h4 className="text-gray-400">{menu.label}</h4>
                      {menu.submenu.map((submenu, index) => (
                        <Link key={index} href={submenu.url}>
                          {submenu.label}
                        </Link>
                      ))}
                    </div>
                  ))}
                </div>
              </CardBody>
            </Card>
          </Tab>
        )}
      </Tabs>
    </section>
  );
};

export default ProgramNavigation;
