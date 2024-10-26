import { usePage } from "@inertiajs/react"
import {
  Button,
  Dropdown,
  DropdownItem,
  DropdownMenu,
  DropdownTrigger,
  Link,
  Navbar as NavbarBase,
  NavbarBrand,
  NavbarContent,
  NavbarItem,
  NavbarMenu,
  NavbarMenuItem,
  NavbarMenuToggle,
  User,
} from "@nextui-org/react"
import { route } from "ziggy-js" // Menggunakan Ziggy untuk route
import { Link as InertiaLink } from "@inertiajs/react" // Menggunakan InertiaLink untuk navigasi tanpa reload

const menuItems = [
  {
    label: "Beranda",
    url: route("home"),
  },
  {
    label: "Program",
    url: route("program.index"), // Menu Program ke halaman Program
  },
  {
    label: "Butuh Bantuan?",
    url: route("help.index"),
  },
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
        ],
      }}
    >
      <NavbarBrand>
        <InertiaLink href={route('home')}>
          <img
            src="/assets/images/mbkm.png"
            alt={import.meta.env.VITE_APP_NAME}
            className="h-10"
          />
        </InertiaLink>
      </NavbarBrand>

      <NavbarContent className="hidden sm:flex gap-4" justify="center">
        {menuItems.map((item, index) => (
          <NavbarItem
            key={index}
            isActive={page.url === new URL(item.url).pathname}
          >
            {/* Tetap menggunakan Link dari NextUI untuk desktop */}
            <Link href={item.url} className="text-foreground" as={InertiaLink}>
              {item.label}
            </Link>
          </NavbarItem>
        ))}
      </NavbarContent>

      <NavbarContent justify="end" className="hidden sm:flex">
        <NavbarItem>
          {pageProps.auth.user ? (
            <Dropdown>
              <DropdownTrigger>
                <User
                  classNames={{
                    base: "cursor-pointer",
                  }}
                  name={pageProps.auth.user.name}
                  description={pageProps.auth.user.email}
                />
              </DropdownTrigger>
              <DropdownMenu variant="faded" aria-label="Dropdown menu with description">
                <DropdownItem href={route('dashboard')}>
                  Kegiatanku
                </DropdownItem>
              </DropdownMenu>
            </Dropdown>
          ) : (
            // Perbaikan utama: Gunakan <a> tag di dalam InertiaLink dengan Button
            <InertiaLink href={route('login')} className="inline-block">
              <a>
                <Button
                  color="default"
                  variant="bordered"
                  className="border-foreground dark:border-foreground"
                >
                  Login
                </Button>
              </a>
            </InertiaLink>
          )}
        </NavbarItem>
      </NavbarContent>

      <NavbarMenuToggle className="sm:hidden" />

      <NavbarMenu>
        {menuItems.map((item, index) => (
          <NavbarMenuItem key={`${item}-${index}`}>
            <Button color="primary" variant="bordered">
              <InertiaLink href={item.url} className="w-full inline-block" >
                {item.label}
              </InertiaLink>
            </Button>
          </NavbarMenuItem>
        ))}
        {
          pageProps.auth.user ? (
            <NavbarMenuItem>
              <a href={route('dashboard')} className="w-full inline-block">
                <Button
                  color="default"
                  variant="bordered"
                  className="border-foreground dark:border-foreground"
                >
              Kegiatanku
                </Button>
              </a>
            </NavbarMenuItem>
          ) : (
            <NavbarMenuItem>
              <a href={route('login')} className="w-full inline-block">
                <Button
                  color="default"
                  variant="bordered"
                  className="border-foreground dark:border-foreground"
                >
                Login
                </Button>
              </a>
            </NavbarMenuItem>
          )
        }
      </NavbarMenu>
    </NavbarBase>
  )
}

export default Navbar
