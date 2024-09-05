import { onboarding } from "@/Typewritings/Onboarding"
import { Button } from "@nextui-org/react"
import BackgroundImage from '@/Images/onboarding.webp'

const title = onboarding.title
const description = onboarding.description

const Onboarding = () => {
  return (
    <section id="onboarding" className="relative">
      <div className="flex flex-col max-w-screen-md mx-auto p-3 sm:py-32 gap-3">
        <div className="max-w-screen-sm text-white">
          <h2 className="font-bossa text-2xl font-bold sm:text-5xl">
            {title}
          </h2>
          <p>{description}</p>
        </div>

        <div className="flex flex-col sm:flex-row gap-3">
          <Button color="primary">
            Telusuri Program
          </Button>
          <Button color="default">
            Daftar Sekarang
          </Button>
        </div>
      </div>

      <img src={BackgroundImage} alt={title} className="h-full w-full object-cover object-bottom absolute -z-50 brightness-50 top-0 left-0" />
    </section>
  )
}

export default Onboarding
