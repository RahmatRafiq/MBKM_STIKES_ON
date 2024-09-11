import { useState, useEffect } from "react"
import { Input, Spinner, Tab, Tabs } from "@nextui-org/react"
import Lowongan from "@/types/lowongan"
import debounce from "lodash.debounce"

type Props = {
  lowongans: Lowongan[];  // Menerima data lowongan sebagai props
  onFilterChange: (filteredData: Lowongan[]) => void;
};

const SearchFilterSection = ({ lowongans, onFilterChange }: Props) => {
  const [searchKeyword, setSearchKeyword] = useState<string>("")
  const [selectedMitra, setSelectedMitra] = useState<string | undefined>(undefined)
  const [isLoading, setIsLoading] = useState(false)

  // Debounced filter function to avoid unnecessary repeated calls
  const filterLowonganDebounced = debounce(() => {
    setIsLoading(true)
    const filtered = lowongans.filter((lowongan) => {
      const matchKeyword = lowongan.name?.toLowerCase().includes(searchKeyword.toLowerCase())
      const matchMitra = selectedMitra ? lowongan.mitra?.type === selectedMitra : true
      return matchKeyword && matchMitra
    })
    onFilterChange(filtered)
    setIsLoading(false)
  }, 300) // Debounce for 300ms

  // useEffect to trigger filtering whenever searchKeyword or selectedMitra changes
  useEffect(() => {
    filterLowonganDebounced()
    // Clean up debounce on unmount
    return () => {
      filterLowonganDebounced.cancel()
    }
  }, [searchKeyword, selectedMitra]) // Dependencies: searchKeyword and selectedMitra

  const handleSearchChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    setSearchKeyword(e.target.value)
  }

  const handleMitraChange = (value: string) => {
    setSelectedMitra(value)
  }

  return (
    <div className="flex flex-col gap-4 mb-4">
      <Input
        placeholder="Cari lowongan..."
        value={searchKeyword}
        onChange={handleSearchChange}
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
