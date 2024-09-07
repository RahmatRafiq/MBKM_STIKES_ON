import { Card, CardBody, Image, Divider } from "@nextui-org/react"
import { usePage } from "@inertiajs/react"
import ThemeToggle from "./ThemeToggle"

const Footer = () => {
  const footer = usePage().props.footer as {
    contact_email: string;
    contact_phone: string;
    contact_address: string;
  }
  const currentYear = new Date().getFullYear()

  if (!footer) {
    return null
  }

  return (
    <footer className="bg-white dark:bg-black text-black dark:text-white py-10 px-5">
      <Divider className="my-6 bg-gray-600 dark:bg-gray-500" />

      <Card
        isBlurred
        className="border-none bg-background/60 dark:bg-default-100/50 max-w-screen-xl mx-auto"
        shadow="sm"
      >
        <CardBody>
          <div className="grid grid-cols-6 md:grid-cols-12 gap-6 md:gap-4 items-center justify-center">
            <div className="relative col-span-6 md:col-span-4">
              <Image
                alt="Logo MBKM"
                className="object-contain"
                height={200}
                width= "100%"
                shadow="md"
                src="/assets/images/mbkm.png" // Path ke gambar logo MBKM
              />
            </div>
            <div className="flex flex-col col-span-6 md:col-span-8">
              <div className="flex justify-between items-start">
                <div className="flex flex-col gap-0">
                  <h3 className="font-semibold text-foreground/90 uppercase tracking-wide text-sm text-indigo-500 dark:text-indigo-300">
                  Program Kampus Merdeka STIKES Gunung Sari
                  </h3>
                  <p className="text-lg font-medium mt-2 text-black dark:text-white">
                    Email: <a href={`mailto:${footer.contact_email}`} className="text-blue-400 dark:text-blue-300 hover:underline">{footer.contact_email}</a>
                  </p>
                  <p className="mt-2 text-gray-500 dark:text-gray-400">
                    Telepon: <a href={`tel:${footer.contact_phone}`} className="text-blue-400 dark:text-blue-300 hover:underline">{footer.contact_phone}</a>
                  </p>
                  <p className="mt-2 text-gray-500 dark:text-gray-400">
                    Alamat: {footer.contact_address}
                  </p>
                </div>
              </div>
            </div>
          </div>
        </CardBody>
      </Card>
      <div className="flex justify-between items-center flex-col-reverse sm:flex-row text-center text-sm mt-5 px-8 space-x-4">
        <span className="text-gray-500 dark:text-gray-400">&copy; {currentYear} STIKES Gunung Sari</span>
        <div className="mt-3 sm:mt-0">
          <ThemeToggle />
        </div>
      </div>
    </footer>
  )
}
export default Footer
