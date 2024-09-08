import { usePage } from "@inertiajs/react"
import { Button, Dropdown, DropdownItem, DropdownMenu, DropdownTrigger, Link, Navbar as NavbarBase, NavbarBrand, NavbarContent, NavbarItem, NavbarMenu, NavbarMenuItem, NavbarMenuToggle, User } from "@nextui-org/react"
import { route } from "ziggy-js"
import { Link as InertiaLink } from "@inertiajs/react"

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
  const page = usePage()
  const pageProps = page.props

  return (
    <NavbarBase
      shouldHideOnScroll
      classNames={{
        item: [
          'data-[active="true"]:font-bold',
          'data-[active="true"]:border-b-2',
        ]
      }}
    >
      <NavbarBrand>
        <Link href="#">
          <img src="/assets/images/mbkm.png" alt={import.meta.env.VITE_APP_NAME} className="h-10" />
        </Link>
      </NavbarBrand>
      <NavbarContent className="hidden sm:flex gap-4" justify="center">
        {
          menuItems.map((item, index) => (
            <NavbarItem key={index}
              isActive={page.url === new URL(item.url).pathname}
            >
              <Link
                href={item.url}
                className="text-foreground"
                as={InertiaLink}
              >{item.label}</Link>
            </NavbarItem>
          ))
        }
      </NavbarContent>
      <NavbarContent justify="end" className="hidden sm:flex">
        <NavbarItem>
          {
            pageProps.auth.user ? (
              <Dropdown>
                <DropdownTrigger>
                  <User
                    classNames={{
                      base: 'cursor-pointer'
                    }}
                    name={pageProps.auth.user.name}
                    description={pageProps.auth.user.email}
                  />
                </DropdownTrigger>
                <DropdownMenu variant="faded" aria-label="Dropdown menu with description">
                  <DropdownItem
                    key="kegiatan"
                    href={route('dashboard')} // TODO: Change this to the correct route
                  >
                    Kegiatanku
                  </DropdownItem>
                </DropdownMenu>
              </Dropdown>
            ) : (
              <Button as={Link} color="default" href={route('login')} variant="bordered" className="border-foreground dark:border-foreground">
            Login
              </Button>
            )
          }
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
                index === menuItems.length - 1 ? "secondary" : "foreground"
              }
              className="w-full"
              href="#"
              size="lg"
            >
              {item.label}
            </Link>
          </NavbarMenuItem>
        ))}
        {
          pageProps.auth.user ? (
            <NavbarMenuItem>
              <Link
                color="foreground"
                className="w-full"
                href={route('dashboard')}
                size="lg"
              >
                Kegiatanku
              </Link>
            </NavbarMenuItem>
          ) : (
            <NavbarMenuItem>
              <Button
                as={Link}
                color="default"
                href={route('login')}
                variant="bordered"
                className="border-foreground dark:border-foreground"
              >
                Login
              </Button>
            </NavbarMenuItem>
          )
        }
      </NavbarMenu>
    </NavbarBase>
  )
}

export default Navbar
