import { useState } from "react"
import Lowongan from "@/types/lowongan"

type Props = {
  lowongan: Lowongan[] // Data lowongan dari props
  mitraList: string[]  // Daftar nama mitra untuk filter
  onFilterChange: (filteredData: Lowongan[]) => void // Fungsi untuk mengirimkan hasil pencarian dan filter
}
console.log('props')
const SearchFilterSection = ({ lowongan, mitraList, onFilterChange }: Props) => {
  const [searchKeyword, setSearchKeyword] = useState<string>("")
  const [selectedMitra, setSelectedMitra] = useState<string | undefined>(undefined)

  // Fungsi untuk melakukan filter berdasarkan pencarian dan mitra
  const handleFilter = () => {
    const filteredLowongan = lowongan.filter((item) => {
      const matchesSearch = item.name?.toLowerCase().includes(searchKeyword.toLowerCase())
      const matchesMitra = selectedMitra ? item.mitra?.name === selectedMitra : true
      return matchesSearch && matchesMitra
    })

    // Kirim hasil filter ke komponen induk
    onFilterChange(filteredLowongan)
  }

  // Lakukan filter saat keyword atau mitra berubah
  const handleSearchChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    setSearchKeyword(e.target.value)
    handleFilter()
  }

  const handleMitraChange = (e: React.ChangeEvent<HTMLSelectElement>) => {
    setSelectedMitra(e.target.value)
    handleFilter()
  }

  return (
    <div className="flex flex-col gap-4 mb-4">
      {/* Input untuk Pencarian */}
      <input
        type="text"
        placeholder="Cari lowongan..."
        value={searchKeyword}
        onChange={handleSearchChange}
        className="border p-2 w-full"
      />

      {/* Dropdown untuk Filter Mitra */}
      <select
        value={selectedMitra}
        onChange={handleMitraChange}
        className="border p-2 w-full"
      >
        <option value="">Semua Mitra</option>
        {mitraList.map((mitra, index) => (
          <option key={index} value={mitra}>
            {mitra}
          </option>
        ))}
      </select>
    </div>
  )
}

export default SearchFilterSection
