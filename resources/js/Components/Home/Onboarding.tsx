import { onboarding } from "@/Typewritings/Onboarding"
import { Button } from "@nextui-org/react"
import BackgroundImage from "@/Images/onboarding.webp"
import { Link as InertiaLink, usePage } from "@inertiajs/react" // Import InertiaLink dan usePage untuk cek login
import { route } from "ziggy-js" // Menggunakan route dari Ziggy

const title = onboarding.title
const description = onboarding.description

const Onboarding = () => {
  const { props } = usePage() // Mengambil props untuk cek apakah user sudah login
  const isAuthenticated = props.auth.user !== null // Cek apakah user sudah login

  return (
    <section id="onboarding" className="relative">
      <div className="flex flex-col max-w-screen-md mx-auto p-3 sm:py-32 gap-3">
        <div className="max-w-screen-sm text-white">
          <h2 className="font-bossa text-2xl font-bold sm:text-5xl">
            {title}
          </h2>
          <p>{description}</p>
        </div>

        <div className="flex flex-col sm:flex-row gap-3">
          {/* Tombol Telusuri Program menggunakan InertiaLink */}
          <InertiaLink href={route('program.index')}>
            <Button color="primary">
              Telusuri Program
            </Button>
          </InertiaLink>

          {/* Tombol Daftar Sekarang mengarahkan ke halaman Kegiatanku jika sudah login, jika belum login ke halaman Login */}
          <InertiaLink href={isAuthenticated ? route('dashboard') : route('login')}>
            <Button color="default">
              Daftar Sekarang
            </Button>
          </InertiaLink>
        </div>
      </div>

      <img
        src={BackgroundImage}
        alt={title}
        className="h-full w-full object-cover object-bottom absolute -z-50 brightness-50 top-0 left-0"
      />
    </section>
  )
}

export default Onboarding
