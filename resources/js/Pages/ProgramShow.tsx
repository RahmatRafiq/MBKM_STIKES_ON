import Footer from "@/Components/Footer"
import ProgramShowSection from "@/Components/Program/ProgramShowSection"
import Lowongan from "@/types/lowongan"
import { Link, router, usePage } from "@inertiajs/react"
import { Button } from "@nextui-org/react"
import axios from "axios"
import { useEffect, useState } from "react"
import { MdArrowBack } from "react-icons/md"
import Swal from "sweetalert2"
import 'sweetalert2/dist/sweetalert2.min.css'

type PageProps = {
  data: Lowongan
}

const ProgramShow = (props: PageProps) => {
  const preventBack = () => {
    if (location.pathname.startsWith("/program")) {
      // history.replaceState(null, document.title, location.pathname)
      router.visit('/program')
    }
  }

  useEffect(() => {
    // prevent back action
    window.addEventListener("popstate", preventBack, false)

    return () => {
      window.removeEventListener("popstate", preventBack, false)
    }
  }, [])

  return (
    <>
      <nav className="shadow-md shadow-foreground-500 p-3 sticky top-0 bg-background z-10">
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
      <main className="flex flex-col gap-3 p-3">
        <ProgramShowSection />
      </main>

      <Footer />
    </>
  )
}

export default ProgramShow
