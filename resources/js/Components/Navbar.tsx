import {Navbar as NavbarBase, NavbarBrand, NavbarContent, NavbarItem, Link, Button, NavbarMenuToggle, NavbarMenu, NavbarMenuItem} from "@nextui-org/react"
import { useState } from "react"
import { route } from "ziggy-js"

const menuItems = [
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
  // const [isMenuOpen, setIsMenuOpen] = useState(false)

  return (
    <NavbarBase shouldHideOnScroll>
      <NavbarBrand>
        <Link href="#">
          <img src="/assets/images/mbkm.png" alt={import.meta.env.VITE_APP_NAME} className="h-10" />
        </Link>
      </NavbarBrand>
      <NavbarContent className="hidden sm:flex gap-4" justify="center">
        {
          menuItems.map((item, index) => (
            <NavbarItem key={index}>
              <Link href={item.url}>{item.label}</Link>
            </NavbarItem>
          ))
        }
      </NavbarContent>
      <NavbarContent justify="end" className="hidden sm:flex">
        <NavbarItem className="hidden lg:flex">
          <Link href="#">Login</Link>
        </NavbarItem>
        <NavbarItem>
          <Button as={Link} color="primary" href="#" variant="flat">
            Login
          </Button>
        </NavbarItem>
      </NavbarContent>

      <NavbarMenuToggle
        className="sm:hidden"
      />
      <NavbarMenu>
        {menuItems.map((item, index) => (
          <NavbarMenuItem key={`${item}-${index}`}>
            <Link
              color={
                index === 2 ? "primary" : index === menuItems.length - 1 ? "danger" : "foreground"
              }
              className="w-full"
              href="#"
              size="lg"
            >
              {item.label}
            </Link>
          </NavbarMenuItem>
        ))}
        <NavbarMenuItem>
          <Button
            className="w-full"
            color="primary"
            variant="flat"
            size="lg"
            as={Link}
            href={route('login')}
          >
                Login
          </Button>
        </NavbarMenuItem>
      </NavbarMenu>
    </NavbarBase>
  )
}

export default Navbar
