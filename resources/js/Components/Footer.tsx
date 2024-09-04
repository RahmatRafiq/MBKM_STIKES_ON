import { Divider } from "@nextui-org/react"
import ThemeToggle from "./ThemeToggle"

const Footer = () => {
  return (
    <footer className="px-3">
      <Divider/>
      <div className="flex justify-center p-3 items-center flex-col-reverse gap-3">
        <span>&copy; 2021. All rights reserved.</span>
        <ThemeToggle />
      </div>
    </footer>
  )
}

export default Footer
