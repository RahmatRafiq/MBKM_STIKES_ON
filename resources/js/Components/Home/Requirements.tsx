import { Card, CardBody, Link, ScrollShadow, Table, TableBody, TableCell, TableColumn, TableHeader, TableRow } from "@nextui-org/react"
import { Link as InertiaLink } from '@inertiajs/react'

const headers = [
  '',
  'Magang dan Studi Independen Bersertifikat (MSIB)',
  'Kampus Mengajar',
  'Pertukaran Mahasiswa Merdeka',
]

const indexes = [
  'Jenjang Pendidikan',
  'Semester',
  'Minimal IPK',
]

const cells = [
  ['S1 atau Vokasi', 'S1 atau Vokasi', 'S1 atau Vokasi'],
  [
    ['D2/D3/D4: Minimal Semester 2', 'S1: Minimal semester 4'],
    'Minimal semester 4',
    'Minimal semester 3',
  ],
  ['-', '3 dari skala 4', '2.8 dari skala 4'],
  ['#', '#', '#'],
]

const Requirements = () => {
  return (
    <section id="requirements" className="max-w-screen-xl w-full mx-auto p-3">
      <Card classNames={{
        base: 'bg-transparent',
      }}>
        <CardBody className="flex flex-col gap-3">
          <div className="mb-3">
            <h1 className="font-bossa text-xl md:text-3xl">Apa saja syarat keikutsertaan mahasiswa?</h1>
            <p>Berikut adalah <span className="font-bold">persyaratan umum</span> dari beberapa program Kampus Merdeka.</p>
          </div>
          <ScrollShadow
            orientation="horizontal"
            hideScrollBar
          >
            <Table
              isStriped
              aria-label="Example static collection table"
              layout="fixed"
              classNames={{
                base: 'min-w-[900px]',
                th: 'p-8 text-wrap text-medium',
                td: 'p-8',
              }}
            >
              <TableHeader>
                {
                  headers.map((header, index) => (
                    <TableColumn key={index}

                    >
                      {header}
                    </TableColumn>
                  ))
                }
              </TableHeader>
              <TableBody>
                {
                  cells.map((row, index) => (
                    <TableRow key={index}>
                      {
                        [indexes[index], ...row].map((cell, index) => (
                          <TableCell key={index}
                            className="first:font-bold text-medium"
                          >
                            {
                              Array.isArray(cell) ? (
                                <ul className="list-disc">
                                  {
                                    cell.map((item, index) => (
                                      <li key={index}>{item}</li>
                                    ))
                                  }
                                </ul>
                              ) : cell
                            }
                          </TableCell>
                        ))
                      }
                    </TableRow>
                  ))
                }
              </TableBody>
            </Table>
          </ScrollShadow>
          <div>
            <h3>Catatan Lain</h3>
            <ol className="pl-8">
              <li className="list-decimal">
                Perguruan Tinggi harus merupakan Perguruan Tinggi Negeri atau Swasta
                dan <span className="font-bold">berada di bawah Kementerian Pendidikan,
                Kebudayaan, Riset, dan Teknologi</span>.
                Cek panduannya <Link as={InertiaLink} href='#' className="font-bold">di sini</Link>.
              </li>
              <li className="list-decimal">
                Mahasiswa hanya dapat mengikuti
                <span className="font-bold">1 (satu) program per periode</span>.
              </li>
              <li className="list-decimal">
                Harus berstatus <span className="font-bold">mahasiswa aktif</span>. Jika mahasiswa lulus/mengikuti yudisium sebelum
                program berakhir maka dianggap mengundurkan diri dari program Kampus Merdeka.
              </li>
            </ol>
          </div>
        </CardBody>
      </Card>
    </section>
  )
}

export default Requirements
