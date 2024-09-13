import MitraProfilePage from "@/Components/Mitra/MitraProfilePage"
import Lowongan, { Mitra } from "@/types/lowongan"
import Guest from "@/Layouts/Guest"



type Props = {
    data: Mitra&{lowongan: Lowongan[]}
}

const MitraProfile = ({data}: Props) => {
//   console.log(data)
  return (
    <Guest className="min-h-svh flex flex-col gap-8">
      <MitraProfilePage mitra={data} />
    </Guest>
  )
}

export default MitraProfile