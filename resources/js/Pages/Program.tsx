import ProgramShowSection from "@/Components/Program/ProgramShowSection"
import Guest from "@/Layouts/Guest"
import Lowongan from "@/types/lowongan"
import { router } from "@inertiajs/react"
import {
  Avatar,
  Card,
  CardBody,
  Spinner,
  Table,
  TableBody,
  TableCell,
  TableColumn,
  TableHeader,
  TableRow,
} from "@nextui-org/react"
import { useInfiniteScroll } from "@nextui-org/use-infinite-scroll"
import axios from "axios"
import { useEffect, useState } from "react"
import { useAsyncList } from "react-stately"
import { useMediaQuery } from "usehooks-ts"
import SearchFilterSection from "@/Components/Program/SearchFilterSection" // Import SearchFilterSection

const Program = () => {
  const [isLoading, setIsLoading] = useState(false)
  const [hasMore, setHasMore] = useState(true)
  const [lowongans, setLowongans] = useState<Lowongan[]>([]) // State untuk menyimpan hasil pencarian dan filter
  const smallMatch = useMediaQuery("(min-width: 640px)")
  const [active, setActive] = useState<number | null>(null) // Untuk menyimpan ID lowongan yang dipilih

  // Fungsi untuk menangani perubahan hasil filter dan pencarian dari SearchFilterSection
  const handleFilterChange = (filteredData: Lowongan[]) => {
    setLowongans(filteredData) // Update daftar lowongan dengan hasil filter dan pencarian
  }

  // Mengambil data awal menggunakan useAsyncList
  const data = useAsyncList<Lowongan>({
    load: async ({ cursor }) => {
      if (cursor) setIsLoading(false)
      const res = await axios.get(cursor || "/api/lowongan")

      setHasMore(!!res.data.data.next_page_url)
      return {
        items: res.data.data.data,
        cursor: res.data.data.next_page_url,
      }
    },
  })

  // Infinite scroll jika tidak ada pencarian/filter
  const [loaderRef, scrollerRef] = useInfiniteScroll({
    hasMore: lowongans.length === 0 && hasMore, // Hanya gunakan infinite scroll jika tidak ada hasil filter
    onLoadMore: data.loadMore,
  })

  const preventBack = () => {
    if (location.pathname.startsWith("/program")) {
      router.visit("/program")
    }
  }

  useEffect(() => {
    window.addEventListener("popstate", preventBack, false)
    return () => {
      window.removeEventListener("popstate", preventBack, false)
    }
  }, [])

  // Menangani aksi reset ketika pengguna menekan tombol Escape
  useEffect(() => {
    const handleEscape = (e: KeyboardEvent) => {
      if (e.key === "Escape") {
        setActive(null)
      }
    }
    window.addEventListener("keydown", handleEscape)
    return () => {
      window.removeEventListener("keydown", handleEscape)
    }
  }, [active])

  return (
    <Guest>
      {/* Bagian SearchFilterSection */}
      <SearchFilterSection
        lowongans={data.items} // Mengirimkan data lowongans dari API
        onFilterChange={handleFilterChange}
      />

      <section className="p-3 grid grid-cols-1 sm:grid-cols-[300px_minmax(0,_1fr)] w-full gap-3 h-max">
        {/* Tabel Lowongan */}
        <Table
          baseRef={scrollerRef}
          classNames={{
            thead: "hidden",
            base:
              "sm:max-w-sm bg-background z-10 no-scrollbar max-h-[calc(100vh-6rem)]",
            wrapper: "h-full overflow-y-auto ",
          }}
          aria-label="Lowongan"
          bottomContent={
            hasMore && lowongans.length === 0 ? (
              <div className="flex justify-center">
                <Spinner ref={loaderRef} />
              </div>
            ) : null
          }
        >
          <TableHeader>
            <TableColumn aria-label="Lowongan">Lowongan</TableColumn>
          </TableHeader>
          <TableBody
            emptyContent="Tidak ada data"
            isLoading={isLoading}
            loadingContent={<Spinner />}
            items={lowongans.length > 0 ? lowongans : data.items} // Prioritaskan hasil pencarian/filter
          >
            {(item) => (
              <TableRow key={item.id} aria-label={item.name}>
                <TableCell
                  className="hover:cursor-pointer hover:bg-default-100"
                  aria-label="Lowongan"
                  onClick={() => {
                    if (smallMatch) {
                      setActive(item.id!)
                    } else {
                      router.visit(`/program/${item.id}`)
                    }
                  }}
                >
                  <div className="flex gap-3">
                    <Avatar
                      src={item.mitra?.image_url}
                      name={item.mitra?.name}
                      classNames={{ base: "w-12 h-12" }}
                    />
                    <div className="flex flex-col">
                      <span className="font-bold">{item.name}</span>
                      <span className="text-foreground-500">
                        {item.mitra?.name}
                      </span>
                      <span className="text-foreground-500 line-clamp-1">
                        {item.location}
                      </span>
                      <span className="text-foreground-500">
                        {item.month_duration}
                      </span>
                    </div>
                  </div>
                </TableCell>
              </TableRow>
            )}
          </TableBody>
        </Table>

        {/* Bagian detail Lowongan */}
        {smallMatch && active ? (
          <Card classNames={{ base: "w-full h-max" }}>
            <CardBody>
              <ProgramShowSection id={active} />
            </CardBody>
          </Card>
        ) : (
          <Card classNames={{ base: "w-full h-[calc(100vh-6rem)]" }}>
            <CardBody>
              <div className="flex justify-center items-center h-full">
                <span>Pilih lowongan program untuk melihat detail</span>
              </div>
            </CardBody>
          </Card>
        )}
      </section>
    </Guest>
  )
}

export default Program
