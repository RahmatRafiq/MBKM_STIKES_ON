import Footer from "@/Components/Footer"
import Navbar from "@/Components/Navbar"

type Props = {
  children: React.ReactNode;
  className?: string;
}

const Guest = ({ children, className }: Props) => {
  className = className || 'container mx-auto px-4 min-h-svh'

  return (
    <>
      <Navbar />
      <main className={className}>
        {children}
      </main>
      <Footer />
    </>
  )
}

export default Guest
