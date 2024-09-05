import React, { useEffect, useState } from 'react';
import axios from 'axios';
import KampusMerLogo from '@/Images/onboarding.webp';
import IconBenefit1 from '@/Images/icon-benefit-1.png'; // Contoh ikon untuk manfaat 1
import IconBenefit2 from '@/Images/icon-benefit-1.png'; // Contoh ikon untuk manfaat 2
import IconBenefit3 from '@/Images/icon-benefit-1.png'; // Contoh ikon untuk manfaat 3
import IconBenefit4 from '@/Images/icon-benefit-1.png'; // Contoh ikon untuk manfaat 4
import { Image } from "@nextui-org/react";

const ProgramOverview = () => {
    // State untuk menyimpan data overview dari API
    const [overviewData, setOverviewData] = useState({
        name: '',
        description: '',
        benefits: []
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
        <section className="flex w-full flex-col p-3 max-w-screen-xl mx-auto">
            {/* Section Deskripsi Program */}
            <div className="flex w-full flex-col p-3 max-w-screen-xl mx-auto">
                <div className="max-w-lg text-gray-900 dark:text-white flex-grow">
                    <h2 className="text-4xl font-bossa font-bold mb-4 break-words">{overviewData.name}</h2> {/* Nama program dari API */}
                    <p className="text-lg break-words max-w-full">{overviewData.description}</p> {/* Deskripsi program dari API */}
                </div>
                <div className="flex justify-end w-full lg:w-auto">
                    <Image
                        src={KampusMerLogo}
                        alt={overviewData.name}
                        width={350}
                        height={250}
                        className="rounded-lg object-cover w-full lg:w-auto"
                    />
                </div>
            </div>


            {/* Section Manfaat Program */}
            <div className="text-gray-900 dark:text-white">
                <h3 className="text-2xl font-bossa font-bold mb-6 text-center">Apa saja manfaat program Kampus Merdeka?</h3>
                <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    {/* Manfaat 1 */}
                    <div className="flex flex-col items-center text-center">
                        <img src={IconBenefit1} alt={overviewData.benefits[0]} className="w-16 h-16 mb-4" />
                        <p>{overviewData.benefits[0]}</p>
                    </div>

                    {/* Manfaat 2 */}
                    <div className="flex flex-col items-center text-center">
                        <img src={IconBenefit2} alt={overviewData.benefits[1]} className="w-16 h-16 mb-4" />
                        <p>{overviewData.benefits[1]}</p>
                    </div>

                    {/* Manfaat 3 */}
                    <div className="flex flex-col items-center text-center">
                        <img src={IconBenefit3} alt={overviewData.benefits[2]} className="w-16 h-16 mb-4" />
                        <p>{overviewData.benefits[2]}</p>
                    </div>

                    {/* Manfaat 4 */}
                    <div className="flex flex-col items-center text-center">
                        <img src={IconBenefit4} alt={overviewData.benefits[3]} className="w-16 h-16 mb-4" />
                        <p>{overviewData.benefits[3]}</p>
                    </div>
                </div>
            </div>
        </section>
    );
}

export default ProgramOverview;
