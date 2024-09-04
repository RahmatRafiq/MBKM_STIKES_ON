import Onboarding from "@/Components/Home/Onboarding"
import ProgramNavigation from "@/Components/Home/ProgramNavigation"
import Guest from "@/Layouts/Guest"

const Home = () => {
  console.log('asd')
  return (
    <Guest className="min-h-svh flex flex-col gap-8">
      <Onboarding />
      <ProgramNavigation />
    </Guest>
  )
}


export default Home
