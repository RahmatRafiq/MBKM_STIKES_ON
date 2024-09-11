import { useState } from "react"
import { Input, Spinner, Tab, Tabs } from "@nextui-org/react"
import Lowongan from "@/types/lowongan"

type Props = {
  lowongans: Lowongan[];  // Menerima data lowongan sebagai props
  onFilterChange: (filteredData: Lowongan[]) => void;
};

const SearchFilterSection = ({ lowongans, onFilterChange }: Props) => {
  const [searchKeyword, setSearchKeyword] = useState<string>("")
  const [selectedMitra, setSelectedMitra] = useState<string | undefined>(undefined)
  const [isLoading, setIsLoading] = useState(false)

  // Function to handle the search and filter logic
  const filterLowongan = () => {
    setIsLoading(true)
    const filtered = lowongans.filter((lowongan) => {
      const matchKeyword = lowongan.name?.toLowerCase().includes(searchKeyword.toLowerCase())
      const matchMitra = selectedMitra ? lowongan.mitra?.type === selectedMitra : true
      return matchKeyword && matchMitra
    })
    onFilterChange(filtered)
    setIsLoading(false)
  }

  const handleSearchChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    setSearchKeyword(e.target.value)
    filterLowongan()
  }

  const handleMitraChange = (value: string) => {
    setSelectedMitra(value)
    filterLowongan()
  }

  return (
    <div className="flex flex-col gap-4 mb-4">
      <Input
        placeholder="Cari lowongan..."
        value={searchKeyword}
        onChange={handleSearchChange}
        className="border p-2 w-full"
        isClearable
      />

      <Tabs
        aria-label="Mitra Filter"
        selectedKey={selectedMitra || ""}
        onSelectionChange={(key) => handleMitraChange(key as string)}
      >
        <Tab key="" title="Semua Mitra">
          Semua Mitra
        </Tab>
        {Array.from(new Set(lowongans.map((lowongan) => lowongan.mitra?.type))).map((type) => (
          <Tab key={type || "unknown"} title={type || "Unknown"}>
            {type}
          </Tab>
        ))}
      </Tabs>

      {isLoading && <Spinner />}
    </div>
  )
}

export default SearchFilterSection
