import { default as IconBenefit1 } from '@/Images/icon-benefit-1.png' // Contoh ikon untuk manfaat 1
import KampusMerLogo from '@/Images/onboarding.webp'
import { HomeOverview } from '@/types/home'
import { Image } from "@nextui-org/react"

type Props = {
    data: HomeOverview
}

const ProgramOverview = (props: Props) => {
  console.log(props.data)
  //   // State untuk menyimpan data overview dari API
  //   const [overviewData, setOverviewData] = useState({
  //     name: '',
  //     description: '',
  //     benefits: []
  //   })

  //   // Menjemput data dari API ketika komponen pertama kali di-render
  //   useEffect(() => {
  //     axios.get('/api/overview')
  //       .then(response => {
  //         setOverviewData(response.data) // Set data dari API
  //       })
  //       .catch(error => {
  //         console.error("Error fetching overview data:", error)
  //       })
  //   }, [])

  return (
    <section className="flex w-full flex-col p-3 max-w-screen-xl mx-auto">
      {/* Section Deskripsi Program */}
      <div className="flex flex-col lg:flex-row w-full p-3 max-w-screen-xl mx-auto lg:justify-center lg:items-center gap-8">
        {/* Name and Description */}
        <div className="max-w-lg text-gray-900 dark:text-white flex-grow">
          <h2 className="text-4xl font-bossa font-bold mb-4 break-words text-center lg:text-left">
            {props.data.name}
          </h2> {/* Nama program dari API */}
          <p className="text-lg break-words max-w-full text-center lg:text-left">
            {props.data.description}
          </p> {/* Deskripsi program dari API */}
        </div>

        {/* Program Image */}
        <div className="flex justify-center lg:justify-end w-full lg:w-auto">
          <Image
            src={KampusMerLogo}
            alt={props.data.name}
            width={350}
            height={250}
            className="rounded-lg object-cover w-full lg:w-auto"
          />
        </div>
      </div>

      {/* Section Manfaat Program */}
      <div className="text-gray-900 dark:text-white mt-10">
        <h3 className="text-2xl font-bossa font-bold mb-6 text-center">
                    Apa saja manfaat program Kampus Merdeka?
        </h3>
        <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
          {
            props.data.benefits ? props.data.benefits.map((benefit, index) => (
              <div key={index} className="flex flex-col items-center text-center">
                <img src={IconBenefit1} alt={benefit} className="w-16 h-16 mb-4" />
                <p>{benefit}</p>
              </div>
            )) : <></>
          }
        </div>
      </div>
    </section>
  )
}

export default ProgramOverview
