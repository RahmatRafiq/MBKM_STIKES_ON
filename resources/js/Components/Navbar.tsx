import {Navbar as NavbarBase, NavbarBrand, NavbarContent, NavbarItem, Link, Button} from "@nextui-org/react";

const Menu = [
  {
    label: 'Beranda',
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
        <NavbarItem>
          <Link color="foreground" href="#">
                        Features
          </Link>
        </NavbarItem>
        <NavbarItem isActive>
          <Link href="#" aria-current="page">
                        Customers
          </Link>
        </NavbarItem>
        <NavbarItem>
          <Link color="foreground" href="#">
                        Integrations
          </Link>
        </NavbarItem>
      </NavbarContent>
      <NavbarContent justify="end">
        <NavbarItem className="hidden lg:flex">
          <Link href="#">Login</Link>
        </NavbarItem>
        <NavbarItem>
          <Button as={Link} color="primary" href="#" variant="flat">
                        Sign Up
          </Button>
        </NavbarItem>
      </NavbarContent>
    </NavbarBase>
  );
}

export default Navbar;
