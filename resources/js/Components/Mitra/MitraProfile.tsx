import { FaGlobe, FaMapMarkerAlt, FaPhone, FaRegClock } from "react-icons/fa"
import { MdArrowBack, MdOutlineEmail, MdShare } from "react-icons/md"
import { Button, Card, CardBody, Image, Skeleton, Spacer, Listbox, ListboxItem, Accordion, AccordionItem, Divider, Avatar } from "@nextui-org/react"
import { Link } from "@inertiajs/react"
import { useEffect } from "react"
import Footer from "@/Components/Footer"
import { Mitra } from "@/types/lowongan"
import Lowongan from "@/types/lowongan"

type Props = {
  mitra: Mitra;
};

const MitraProfile = ({ mitra }: Props) => {
  const preventBack = () => {
    if (location.pathname.startsWith("/mitra")) {
      route("/mitra")
    }
  }

  useEffect(() => {
    window.addEventListener("popstate", preventBack, false)
    return () => {
      window.removeEventListener("popstate", preventBack, false)
    }
  }, [])

  return (
    <>
      {/* Navigasi dengan Tombol Back */}
      <nav className="shadow-md shadow-foreground-500 p-3 sticky top-0 bg-background z-10">
        <Button
          id="back"
          as={Link}
          href="/mitra"
          variant="light"
          className="aspect-square p-0 min-w-0"
        >
          <MdArrowBack size={24} />
        </Button>
      </nav>

      {/* Tampilan Utama Profil Mitra */}
      <div className="container mx-auto p-5">
        <div className="flex justify-center">
          {mitra.image_url ? (
            <Image
              isBlurred
              width={240}
              src={mitra.image_url}
              alt={mitra.name}
              className="m-5"
              fallbackSrc="https://via.placeholder.com/200x200"
            />
          ) : (
            <Skeleton className="h-[200px] w-[200px] rounded-full mx-auto" />
          )}
        </div>

        <Card className="mb-5">
          <CardBody>
            <h1 className="text-2xl font-bossa font-black text-center">{mitra.name}</h1>
            <p className="text-center text-foreground-500">{mitra.type}</p>
            <Spacer y={2} />
            <ul className="flex flex-col gap-3 text-center">
              <li className="flex justify-center items-center gap-3">
                <MdOutlineEmail size={16} /> {mitra.email}
              </li>
              <li className="flex justify-center items-center gap-3">
                <FaPhone size={16} /> {mitra.phone}
              </li>
              <li className="flex justify-center items-center gap-3">
                <FaGlobe size={16} />
                <a
                  href={mitra.website}
                  target="_blank"
                  rel="noopener noreferrer"
                  className="text-blue-500 underline"
                >
                  {mitra.website?.replace(/(^\w+:|^)\/\//, "")}
                </a>
              </li>
            </ul>
          </CardBody>
        </Card>

        {/* Informasi Tambahan */}
        <Card className="mb-5">
          <CardBody>
            <h3 className="text-lg font-semibold text-primary">Alamat</h3>
            <p>{mitra.address}</p>
          </CardBody>
        </Card>

        {/* Daftar Lowongan */}
        <Card>
          <CardBody>
            <Accordion selectionMode="multiple" defaultExpandedKeys={['programs']}>
              <AccordionItem
                key="lowongan"
                title={<h3 className="text-lg font-semibold text-primary">Lowongan yang Tersedia</h3>}
              >
                <Listbox
                  items={mitra.lowongan}
                  emptyContent="Tidak ada lowongan yang tersedia saat ini."
                  aria-label="Lowongan Tersedia"
                >
                  {(lowongan: Lowongan) => (
                    <ListboxItem key={lowongan.id ?? 'default-key'}>
                      <div className="flex gap-3 items-center">
                        <Avatar
                          src={mitra.image_url}
                          alt={mitra.name}
                          showFallback
                        />
                        <div className="flex flex-col">
                          <span className="font-bold text-primary">{lowongan.name}</span>
                          <span className="text-foreground-500">{lowongan.location}</span>
                          <span className="text-foreground-500">Durasi: {lowongan.month_duration} bulan</span>
                          <span className="text-foreground-500">
                            {lowongan.is_open === "1" ? "Lowongan Masih Dibuka" : "Lowongan Ditutup"}
                          </span>
                        </div>  
                      </div>
                    </ListboxItem>
                  )}
                </Listbox>
              </AccordionItem>
            </Accordion>
           
          </CardBody>
        </Card>
      </div>

      {/* Footer */}
      <Footer />
    </>
  )
}

export default MitraProfile
