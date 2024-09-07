import Onboarding from "@/Components/Home/Onboarding"
import ProgramOverview from "@/Components/Home/ProgramOverview"
import ProgramNavigation from "@/Components/Home/ProgramNavigation"
import Requirements from "@/Components/Home/Requirements"
import Guest from "@/Layouts/Guest"
import TypeProgram from "@/types/type-program"
import { HomeOverview } from "@/types/home"

type Props = {
    overview: HomeOverview
    programs: TypeProgram[]
}

const Home = (props: Props) => {
  console.log('asd')
  return (
    <Guest className="min-h-svh flex flex-col gap-8">
      <Onboarding />
      <ProgramOverview data={props.overview} />
      <ProgramNavigation data={props.programs} />
      <Requirements />
    </Guest>
  )
}


export default Home
