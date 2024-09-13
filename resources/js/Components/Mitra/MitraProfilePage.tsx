import { FaGlobe, FaPhone } from "react-icons/fa"
import { MdArrowBack, MdOutlineEmail } from "react-icons/md"
import { Button, Card, CardBody, Skeleton, Spacer, Accordion, AccordionItem, Listbox, ListboxItem, Avatar } from "@nextui-org/react"
import { Link } from "@inertiajs/react"
import { useEffect, useState } from "react"
import Footer from "@/Components/Footer"
import { Mitra } from "@/types/lowongan"
import Lowongan from "@/types/lowongan"

type Props = {
  mitra: Mitra;
};

const MitraProfilePage = ({ mitra }: Props) => {
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

  const [currentIndex, setCurrentIndex] = useState(0)

  const handlePrevious = () => {
    setCurrentIndex((prevIndex) => {
      const imageLength = mitra.image_url?.length || 0
      return prevIndex === 0 ? imageLength - 1 : prevIndex - 1
    })
  }

  const handleNext = () => {
    setCurrentIndex((prevIndex) => {
      const imageLength = mitra.image_url?.length || 0
      return prevIndex === imageLength - 1 ? 0 : prevIndex + 1
    })
  }

  return (
    <>
      {/* Navigasi dengan Tombol Back */}
      <nav className="shadow-md p-3 sticky top-0 bg-background z-10">
        <Button
          id="back"
          as={Link}
          href="/program"
          variant="light"
          className="aspect-square p-0 min-w-0"
        >
          <MdArrowBack size={24} />
        </Button>
      </nav>

      {/* Tampilan Utama Profil Mitra */}
      <div className="container mx-auto p-5">
        {/* Carousel Gambar */}
        <div className="flex justify-center relative">
          {Array.isArray(mitra.image_url) && mitra.image_url.length > 0 ? (
            <div className="relative w-full max-w-3xl overflow-hidden rounded-lg shadow-md">
              <div className="flex transition-transform ease-in-out duration-500" style={{ transform: `translateX(-${currentIndex * 100}%)` }}>
                {mitra.image_url.map((imageUrl: string, index: number) => (
                  <div key={index} className="min-w-full">
                    <img
                      src={imageUrl}
                      alt={`Mitra image ${index}`}
                      className="w-full h-64 object-cover rounded-lg transition-transform duration-500 hover:scale-105"
                    />
                  </div>
                ))}
              </div>

              {/* Tombol Previous dan Next */}
              <button
                className="absolute top-1/2 left-4 transform -translate-y-1/2 bg-gray-800 bg-opacity-70 text-white p-2 rounded-full hover:bg-gray-900 transition"
                onClick={handlePrevious}
              >
                &#10094;
              </button>
              <button
                className="absolute top-1/2 right-4 transform -translate-y-1/2 bg-gray-800 bg-opacity-70 text-white p-2 rounded-full hover:bg-gray-900 transition"
                onClick={handleNext}
              >
                &#10095;
              </button>
            </div>
          ) : (
            <Skeleton className="h-[200px] w-[200px] rounded-full mx-auto" />
          )}
        </div>

        {/* Detail Informasi Mitra */}
        <Card className="mb-5 mt-5">
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
            <h3 className="text-2x font-bossa font-black">Alamat</h3>
            <p>{mitra.address}</p>
          </CardBody>
        </Card>

        {/* Daftar Lowongan */}
        <Card>
          <CardBody>
            <Accordion selectionMode="multiple" defaultExpandedKeys={['lowongan']}>
              <AccordionItem
                key="lowongan"
                title={<h3 className="text-2x font-bossa font-black">Lowongan yang Tersedia</h3>}
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
                          <span className="font-bold">{lowongan.name}</span>
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

export default MitraProfilePage
