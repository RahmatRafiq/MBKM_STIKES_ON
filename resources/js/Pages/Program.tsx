import ProgramShowSection from "@/Components/Program/ProgramShowSection"
import Guest from "@/Layouts/Guest"
import Lowongan from "@/types/lowongan"
import { router } from "@inertiajs/react"
import { Avatar, Card, CardBody, Spinner, Table, TableBody, TableCell, TableColumn, TableHeader, TableRow } from "@nextui-org/react"
import { useInfiniteScroll } from "@nextui-org/use-infinite-scroll"
import axios from "axios"
import { useEffect, useState } from "react"
import { useAsyncList } from "react-stately"
import { useMediaQuery } from "usehooks-ts"

const Program = () => {
  const [isLoading, setIsLoading] = useState(false)
  const [hasMore, setHasMore] = useState(true)
  const smallMatch = useMediaQuery('(min-width: 640px)')
  const id = new URLSearchParams(location.search).get('id')
  const [active, setActive] = useState(0)

  const data = useAsyncList<Lowongan>({
    load: async ({cursor}) => {
      if (cursor) setIsLoading(false)
      const res = await axios.get(cursor || '/api/lowongan')

      if (!smallMatch && id) {
        //
      }

      setHasMore(!!res.data.data.next_page_url)
      return {
        items: res.data.data.data,
        cursor: res.data.data.next_page_url
      }
    }
  })

  const [loaderRef, scrollerRef] = useInfiniteScroll({hasMore, onLoadMore: data.loadMore})

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

  // active
  useEffect(() => {
    // press escape to reset active
    const handleEscape = (e: KeyboardEvent) => {
      if (e.key === 'Escape') {
        setActive(0)
      }
    }
    window.addEventListener('keydown', handleEscape)

    return () => {
      window.removeEventListener('keydown', handleEscape)
    }
  }, [active])

  return (
    <>
      <Guest>
        <section className="p-3 grid grid-cols-1 sm:grid-cols-[300px_minmax(0,_1fr)] w-full gap-3 h-max">
          <Table
            baseRef={scrollerRef}
            classNames={{
              thead: 'hidden',
              base: 'sm:max-w-sm bg-background z-10 no-scrollbar max-h-[calc(100vh-6rem)]',
              wrapper: 'h-full overflow-y-auto '
            }}
            aria-label="Lowongan"
            bottomContent={
              hasMore ? (
                <div className="flex justify-center">
                  <Spinner
                    ref={loaderRef}
                  />
                </div>
              ) : null
            }
          >
            <TableHeader>
              <TableColumn
                aria-label="Lowongan"
              >
                Lowongan
              </TableColumn>
            </TableHeader>
            <TableBody
              emptyContent="Tidak ada data"
              isLoading={isLoading}
              loadingContent={<Spinner />}
              items={data.items}
            >
              {(item) => (
                <TableRow key={item.id}
                  aria-label={item.name}
                >
                  <TableCell
                    className="hover:cursor-pointer hover:bg-default-100"
                    aria-label="Lowongan"
                    onClick={() => {
                      console.log(smallMatch)
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
                        classNames={{
                          base: 'w-12 h-12'
                        }}
                      />
                      <div className="flex flex-col">
                        <span className="font-bold">{item.name}</span>
                        <span className="text-foreground-500">{item.mitra?.name}</span>
                        <span className="text-foreground-500 line-clamp-1">{item.location}</span>
                        <span className="text-foreground-500">{item.month_duration}</span>
                      </div>
                    </div>
                  </TableCell>
                </TableRow>
              )}
            </TableBody>
          </Table>

          {
            smallMatch ? (
              active ? (
                <Card
                  classNames={{
                    base: 'w-full h-max'
                  }}
                >
                  <CardBody>
                    <ProgramShowSection id={active} />
                  </CardBody>
                </Card>
              ) : (
                <Card
                  classNames={{
                    base: 'w-full h-[calc(100vh-6rem)]'
                  }}
                >
                  <CardBody>
                    <div className="flex justify-center items-center h-full">
                      <span>Pilih lowongan program untuk melihat detail</span>
                    </div>
                  </CardBody>
                </Card>
              )
            ) : <></>
          }
        </section>
      </Guest>
    </>
  )
}

export default Program
