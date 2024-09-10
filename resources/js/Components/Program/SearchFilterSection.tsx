import { useState, useEffect } from "react"
import axios from "axios"
import debounce from "lodash.debounce"
import { Input, Spinner, Tab, Tabs } from "@nextui-org/react"
import Lowongan from "@/types/lowongan"

type Props = {
  onFilterChange: (filteredData: Lowongan[]) => void;
};

const SearchFilterSection = ({ onFilterChange }: Props) => {
  const [searchKeyword, setSearchKeyword] = useState<string>("")
  const [selectedMitra, setSelectedMitra] = useState<string | undefined>(undefined)
  const [isLoading, setIsLoading] = useState(false)
  const [mitraList, setMitraList] = useState<string[]>([])

  const fetchFilteredLowongan = async () => {
    setIsLoading(true)
    try {
      const response = await axios.get("/api/lowongan", {
        params: {
          search: searchKeyword,
          type: selectedMitra,
        },
      })

      onFilterChange(response.data.data.data)
    } catch (error) {
      console.error("Error fetching filtered lowongan:", error)
    } finally {
      setIsLoading(false)
    }
  }

  const fetchMitraList = async () => {
    try {
      const response = await axios.get("/mitra/types")
      const types = response.data.data.map((item: any) => item.type)
      setMitraList(types)
    } catch (error) {
      console.error("Error fetching mitra types:", error)
    }
  }

  useEffect(() => {
    fetchMitraList()
  }, [])

  const debouncedFetchLowongan = debounce(() => {
    fetchFilteredLowongan()
  }, 300)

  const handleSearchChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    setSearchKeyword(e.target.value)
    debouncedFetchLowongan()
  }

  const handleMitraChange = (value: string) => {
    setSelectedMitra(value)
  }

  useEffect(() => {
    fetchFilteredLowongan()
  }, [selectedMitra])

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
        {mitraList.length > 0 ? (
          mitraList.map((type) => (
            <Tab key={type} title={type}>
              {type}
            </Tab>
          ))
        ) : (
          <Tab key="empty" title="No mitra types available">
            No mitra types available
          </Tab>
        )}
      </Tabs>

      {isLoading && <Spinner />}
    </div>
  )
}

export default SearchFilterSection
