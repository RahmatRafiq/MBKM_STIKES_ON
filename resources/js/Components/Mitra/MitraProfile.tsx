import { Card, Button, Skeleton, Image } from "@nextui-org/react"
import { Link } from "@inertiajs/react"
import { MdArrowBack } from "react-icons/md"
import { useEffect } from "react"
import Footer from "@/Components/Footer"
import { Mitra } from "@/types/lowongan"

type MitraProfileProps = {
  mitra: Mitra;
};

const MitraProfile = ({ mitra }: MitraProfileProps) => {
  const preventBack = () => {
    if (location.pathname.startsWith("/mitra")) {
      route('/mitra') // Mengarahkan ke halaman daftar mitra
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
      <main className="flex flex-col gap-5 p-5">
        {/* Informasi Profil Mitra */}
        <Card className="p-5">
          {mitra.image_url ? (
            <Image
              src={mitra.image_url}
              alt={mitra.name}
              className="rounded-full mx-auto"
              width={200}
              height={200}
            />
          ) : (
            <Skeleton className="h-[200px] w-[200px] rounded-full mx-auto" />
          )}
          
          <h1 className="text-2xl font-bold text-center mt-5">{mitra.name}</h1>
          <p className="text-center text-gray-500">{mitra.type}</p>
          <p><strong>Email:</strong> {mitra.email}</p>
          <p><strong>Telepon:</strong> {mitra.phone}</p>
          <p><strong>Website:</strong> <a href={mitra.website} target="_blank" rel="noopener noreferrer">{mitra.website}</a></p>
          <p>{mitra.description}</p>
        </Card>

        {/* Informasi Tambahan */}
        <Card className="p-5">
          <h3 className="text-lg font-semibold">Alamat</h3>
          <p>{mitra.address}</p>

          <h3 className="text-lg font-semibold mt-5">Program Lain</h3>
          {mitra.others && mitra.others.length > 0 ? (
            mitra.others.map((lowongan, index) => (
              <p key={index}>- {lowongan.name}: {lowongan.description}</p>
            ))
          ) : (
            <p>Belum ada program lain.</p>
          )}
        </Card>
      </main>

      {/* Footer */}
      <Footer />
    </>
  )
}

export default MitraProfile
