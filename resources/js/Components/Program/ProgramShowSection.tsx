import { FaGlobe, FaMapMarkerAlt, FaPhone, FaRegClock } from "react-icons/fa"
import { MdArrowForward, MdOutlineEmail, MdShare } from "react-icons/md"
import { Accordion, AccordionItem, Button, Card, CardBody, Image, User, Link as NextUILink, Spacer, Listbox, ListboxItem, Avatar, Skeleton, Divider, Snippet } from "@nextui-org/react"
import { Link, router, usePage } from "@inertiajs/react"
import Lowongan from "@/types/lowongan"
import { useEffect, useState } from "react"
import axios from "axios"
import Swal from "sweetalert2"
import 'sweetalert2/dist/sweetalert2.min.css'
import withReactContent from "sweetalert2-react-content"

type Props = {
  id?: number
}

const ProgramShowSection = (props: Props) => {
  const page = usePage()
  const dataProps = page.props.data as Lowongan & { is_registered?: boolean }
  const [data, setData] = useState(dataProps)
  const [isLoading, setIsLoading] = useState(!data)
  const smallMatch = window.matchMedia('(min-width: 640px)').matches
  const [isRegistered, setIsRegistered] = useState(data?.is_registered)

  const ReactSwal = withReactContent(Swal)

  useEffect(() => {
    if (props.id) {
      axios.get(route('program.show.json', { id: props.id }))
        .then(res => {
          console.log(res.data.data)
          setData(res.data.data)
          setIsRegistered(res.data.data.is_registered)
          setIsLoading(false)
        })
        .catch(err => {
          console.error(err)
        })
    }

    return () => {
      setData({})
      setIsLoading(true)
    }
  }, [props.id])

  const handleRegister = async () => {
    console.log(page.props.csrf_token)
    const res = await axios.post(route('program.registrasi'),
      {
        _token: page.props.csrf_token,
        lowongan_id: data.id
      },
      {
        headers: {
          'X-CSRF-TOKEN': page.props.csrf_token
        },
        withXSRFToken: true
      }
    ).catch(err => err.response)
    console.log(res)
    if (res.status === 201) {
      Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: 'Anda berhasil mendaftar program ini'
      })
      setIsRegistered(true)
      return
    }

    if (res.status === 401) {
      Swal.fire({
        icon: 'warning',
        title: 'Peringatan',
        text: 'Anda harus login terlebih dahulu'
      })
      return
    }

    if (res.status === 400) {
      Swal.fire({
        icon: 'error',
        title: 'Gagal',
        text: res.data.message
      })
      return
    }
  }

  return (
    <div>
      {
        isLoading ? (
          <div className="flex flex-col gap-3">
            <Skeleton className="h-[100px] w-[100px] mx-auto rounded my-10" />
            <Card>
              <CardBody>
                <Skeleton className="h-[200px] w-full mx-auto rounded" />
              </CardBody>
            </Card>
            <Card>
              <CardBody>
                <Skeleton className="h-[400px] w-full mx-auto rounded" />
              </CardBody>
            </Card>
            <Card>
              <CardBody className="flex flex-col gap-3">
                <Skeleton className="h-[50px] w-full mx-auto rounded" />
                <Skeleton className="h-[50px] w-full mx-auto rounded" />
                <Skeleton className="h-[50px] w-full mx-auto rounded" />
                <Skeleton className="h-[50px] w-full mx-auto rounded" />
              </CardBody>
            </Card>
          </div>
        ) : (
          <>
            <Image
              isBlurred
              src={data.mitra?.image_url}
              alt={data.mitra?.name}
              width={200}
              height={200}
              classNames={{
                wrapper: "block mx-auto my-10",
                img: "rounded-full",
              }}
              fallbackSrc="https://via.placeholder.com/200x200"
            />

            <Card
              classNames={{
                base: 'container mx-auto',
                body: 'p-3',
              }}
            >
              <CardBody>
                <h1 className="text-2xl font-bossa font-black">{data.name}</h1>
                <p>{data.mitra?.name}</p>
                <p>{data.location}</p>
                {
                  smallMatch && (
                    <>
                      <Divider className="my-3" />
                      <div className="flex gap-3">
                        <Button
                          color="primary"
                          onPress={() => {
                            if (page.props.auth.user) {
                              Swal.fire({
                                title: 'Apakah Anda yakin?',
                                text: 'Anda akan mendaftar program ini',
                                icon: 'question',
                                showCancelButton: true,
                                confirmButtonText: 'Ya, daftar',
                                cancelButtonText: 'Batal',
                              })
                                .then(res => {
                                  if (res.isConfirmed) {
                                    handleRegister()
                                  }
                                })
                            } else {
                              Swal.fire({
                                icon: 'warning',
                                title: 'Peringatan',
                                text: 'Anda harus login terlebih dahulu',
                                showCancelButton: true,
                                confirmButtonText: 'Login',
                                cancelButtonText: 'Batal',
                              })
                                .then(res => {
                                  if (res.isConfirmed) {
                                    window.location.href = route('login')
                                  }
                                })
                            }
                          }}
                          isDisabled={isRegistered}
                        >
                          {isRegistered ? 'Anda sudah terdaftar' : 'Daftar Sekarang'}
                        </Button>
                        <Button
                          variant="bordered"
                          onPress={() => {
                            navigator.clipboard.writeText(window.location.href)

                            ReactSwal.fire({
                              icon: 'success',
                              title: 'Berhasil',
                              text: 'Link berhasil disalin',
                              toast: true,
                              showConfirmButton: false,
                              timer: 1500,
                              timerProgressBar: true,
                            })
                          }}
                        >
                          <MdShare size={24} /> Salin Link
                        </Button>
                      </div>
                    </>
                  )
                }
                <Accordion
                  selectionMode="multiple"
                  defaultExpandedKeys={['property', 'description']}
                >
                  <AccordionItem
                    key='property'
                    title={<span className="font-bold">Properti</span>}
                    aria-label='Property'
                  >
                    <div className="flex items-center gap-3">
                      <FaRegClock size={24} />
                      <div>
                        <p>Durasi</p>
                        <p><span className="font-bold">{data.month_duration}</span> <span className="text-nowrap">({data.start_date + ' - ' + data.end_date})</span></p>
                      </div>
                    </div>
                  </AccordionItem>
                  <AccordionItem
                    key='description'
                    aria-label='Rincian Kegiatan'
                    title={<span className="font-bold">Rincian Kegiatan</span>}
                  >
                    {data.description}
                  </AccordionItem>
                </Accordion>
              </CardBody>
            </Card>
            <Spacer y={4} />
            <Card
              classNames={{
                base: 'container mx-auto',
                body: 'p-3',
              }}
            >
              <CardBody>
                <h1 className="text-2x font-bossa font-black">Tentang Perusahaan</h1>
                <Spacer y={4} />
                <User
                  classNames={{
                    base: 'justify-start',
                  }}
                  name={data.mitra?.name}
                  description={data.mitra?.description}
                />
                <Spacer y={4} />
                <ul className="flex flex-col gap-3">
                  <li className="flex items-center gap-3"><FaMapMarkerAlt size={14} /> <NextUILink href={`https://www.google.com/maps/search/?api=1&query=${data.mitra?.address}`} underline="always" target="_blank" rel="noreferrer">{data.mitra?.address}</NextUILink></li>
                  <li className="flex items-center gap-3"><FaPhone size={14} /> <NextUILink href={`https://wa.me/${data.mitra?.phone}`} underline="always">{data.mitra?.phone}</NextUILink></li>
                  <li className="flex items-center gap-3"><MdOutlineEmail size={14} /> <NextUILink href={`mailto:${data.mitra?.email}`} underline="always">{data.mitra?.email}</NextUILink></li>
                  <li className="flex items-center gap-3"><FaGlobe size={14} /> <NextUILink href={data.mitra?.website} underline="always" target="_blank" rel="noreferrer">{data.mitra?.website?.replace(/(^\w+:|^)\/\//, '')}</NextUILink></li>
                </ul>
                <Spacer y={4} />
                <Button
                  as={Link}
                  href={route('mitra.profile', { id: data.mitra?.id })}
                  color="primary"
                >
                  Lihat Profil Lengkap <MdArrowForward size={24} />
                </Button>
              </CardBody>
            </Card>
            <Spacer y={4} />
            <Card>
              <CardBody>
                <h1 className="text-2x font-bossa font-black">Program lain dari {data.mitra?.name}</h1>
                <Listbox
                  items={data.mitra?.others}
                  emptyContent="Tidak ada program lain"
                  aria-label="Program Lain"
                >
                  {(item) => (
                    <ListboxItem
                      key={item.id!}
                      href={`/program/${item.id}`}
                    >
                      <div className="flex gap-3 items-center">
                        <Avatar
                          src={item.mitra?.image_url}
                          alt={item.mitra?.name}
                          showFallback
                        />
                        <div className="flex flex-col">
                          <span className="font-bold">{item.name}</span>
                          <span className="text-foreground-500">{item.mitra?.name}</span>
                          <span className="text-foreground-500">{item.location}</span>
                          <span className="text-foreground-500">{item.month_duration}</span>
                        </div>
                      </div>
                    </ListboxItem>
                  )}
                </Listbox>
              </CardBody>
            </Card>
          </>
        )
      }
      {
        !smallMatch && (
          <div className="sticky bottom-0 bg-background p-3">
            {
              isRegistered ? (
                <Button
                  className="w-full"
                  isDisabled
                >
                  Anda sudah terdaftar
                </Button>
              ) : (
                <Button
                  className="w-full"
                  color="primary"
                  onPress={handleRegister}
                >
                  Daftar Sekarang
                </Button>
              )
            }
          </div>
        )
      }
    </div>
  )
}

export default ProgramShowSection
