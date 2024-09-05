import React, { useEffect, useState } from 'react';
import axios from 'axios';
import KampusMerLogo from '@/Images/onboarding.webp'; // Contoh gambar untuk deskripsi
import IconBenefit1 from '@/Images/icon-benefit-1.png'; // Contoh ikon untuk manfaat
import IconBenefit2 from '@/Images/icon-benefit-1.png';
import IconBenefit3 from '@/Images/icon-benefit-1.png';
import IconBenefit4 from '@/Images/icon-benefit-1.png';
import { Image } from "@nextui-org/react";

const benefits = [
    {
        icon: IconBenefit1,
        text: 'Kegiatan dapat dikonversi menjadi SKS',
    },
    {
        icon: IconBenefit2,
        text: 'Perluas jaringan hingga ke luar program studi dan universitas',
    },
    {
        icon: IconBenefit3,
        text: 'Eksplorasi pengetahuan dan kemampuan di lapangan selama lebih dari satu semester',
    },
    {
        icon: IconBenefit4,
        text: 'Menimba ilmu secara langsung dari mitra berkualitas dan terkemuka',
    }
];

const ProgramOverview = () => {
    // State untuk menyimpan data overview dari API
    const [overviewData, setOverviewData] = useState({
        name: '',
        description: ''
    });

    // Menjemput data dari API ketika komponen pertama kali di-render
    useEffect(() => {
        axios.get('/api/overview')
            .then(response => {
                setOverviewData(response.data); // Set data dari API
            })
            .catch(error => {
                console.error("Error fetching overview data:", error);
            });
    }, []);

    return (
        <section className="flex flex-col p-6 max-w-screen-xl mx-auto">
            {/* Section Deskripsi Program */}
            <div className="flex flex-col lg:flex-row items-center justify-between mb-10">
                <div className="max-w-lg mb-6 lg:mb-0 text-gray-900 dark:text-white">
                    <h2 className="text-4xl font-bossa font-bold mb-4">{overviewData.name}</h2> {/* Nama program dari API */}
                    <p className="text-lg">
                        {overviewData.description} {/* Deskripsi program dari API */}
                    </p>
                </div>
                <div className="flex-shrink-0">
                    <Image src={KampusMerLogo} alt={overviewData.name} width={350} height={250} className="rounded-lg object-cover" />
                </div>
            </div>

            {/* Section Manfaat Program */}
            <div className="text-gray-900 dark:text-white">
                <h3 className="text-2xl font-bossa font-bold mb-6 text-center">Apa saja manfaat program Kampus Merdeka?</h3>
                <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    {benefits.map((benefit, index) => (
                        <div key={index} className="flex flex-col items-center text-center">
                            <img src={benefit.icon} alt={benefit.text} className="w-16 h-16 mb-4" />
                            <p>{benefit.text}</p>
                        </div>
                    ))}
                </div>
            </div>
        </section>
    );
}

export default ProgramOverview;
