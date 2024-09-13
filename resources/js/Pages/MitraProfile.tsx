import MitraProfile from "@/Components/Mitra/MitraProfile"
import Lowongan, { Mitra } from "@/types/lowongan"
import Guest from "@/Layouts/Guest"



type Props = {
    data: Mitra&{lowongan: Lowongan[]}
}

const MitraProfilePage = ({data}: Props) => {
//   console.log(data)
  return (
    <Guest className="min-h-svh flex flex-col gap-8">
      <MitraProfile mitra={data} />
    </Guest>
  )
}

export default MitraProfilePage