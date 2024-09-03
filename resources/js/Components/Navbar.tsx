import {Navbar as NavbarBase, NavbarBrand, NavbarContent, NavbarItem, Link, Button} from "@nextui-org/react"
import { route } from "ziggy-js"

const Menu = [
  {
    label: 'Beranda',
    url: route('home'),
  },
  {
    label: 'Program',
    url: route('program.index'),
  },
  {
    label: 'Butuh Bantuan?',
    url: route('help.index'),
  }
]

const Navbar = () => {
  return (
    <NavbarBase shouldHideOnScroll>
      <NavbarBrand>
        <Link href="#">
          <img src="/assets/images/mbkm.png" alt={import.meta.env.VITE_APP_NAME} className="h-10" />
        </Link>
      </NavbarBrand>
      <NavbarContent className="hidden sm:flex gap-4" justify="center">
        {
          Menu.map((item, index) => (
            <NavbarItem key={index}>
              <Link href={item.url}>{item.label}</Link>
            </NavbarItem>
          ))
        }
      </NavbarContent>
      <NavbarContent justify="end">
        <NavbarItem className="hidden lg:flex">
          <Link href="#">Login</Link>
        </NavbarItem>
        <NavbarItem>
          <Button as={Link} color="primary" href="#" variant="flat">
            Login
          </Button>
        </NavbarItem>
      </NavbarContent>
    </NavbarBase>
  )
}

export default Navbar
