<?php
// config/pickup-locations.php
// Centralized Pickup Locations for All 5 Origin Hubs:
// Delhi, Gurgaon, Noida, Ghaziabad, Faridabad
// Used across all 3,055 destination route pages

return [
    'delhi' => [
        [
            'category' => 'Delhi City Hubs & Neighborhoods',
            'icon'     => 'fa-location-dot',
            'locations' => [
                'Connaught Place (CP)', 'Aerocity Delhi', 'Dwarka (All Sectors)', 'Rohini (Sec 1-25)', 'Pitampura',
                'Janakpuri', 'Punjabi Bagh', 'Rajouri Garden', 'Vasant Kunj', 'Hauz Khas',
                'Greater Kailash (GK 1 & 2)', 'South Extension', 'Saket', 'Lajpat Nagar', 'Defence Colony',
                'Nehru Place', 'Model Town', 'Civil Lines', 'Karol Bagh', 'Paharganj',
                'Mayur Vihar (Phase 1-3)', 'Laxmi Nagar', 'Preet Vihar', 'Paschim Vihar', 'Patel Nagar',
                'Malviya Nagar', 'Green Park', 'Chhatarpur', 'Kalkaji', 'Okhla Phase 1-3'
            ]
        ],
        [
            'category' => 'Airports, Railway Stations & Terminals',
            'icon'     => 'fa-plane-departure',
            'locations' => [
                'Delhi Airport (IGI) Terminal 3', 'Delhi Airport (IGI) Terminal 1', 'Delhi Airport (IGI) Terminal 2',
                'New Delhi Railway Station (NDLS)', 'Old Delhi Railway Station (DLI)', 'Hazrat Nizamuddin Railway Station (NZM)',
                'Anand Vihar Railway Terminal (ANVT)', 'Delhi Sarai Rohilla (DEE)', 'Delhi Cantt Railway Station',
                'ISBT Kashmere Gate', 'ISBT Anand Vihar', 'ISBT Sarai Kale Khan'
            ]
        ],
        [
            'category' => 'Connected NCR Pickup Points',
            'icon'     => 'fa-city',
            'locations' => [
                'Gurgaon Border (Sirhaul)', 'DND Flyway Interchange', 'Kalindi Kunj Border', 'Badarpur Border',
                'Kundli Border (NH-44)', 'Tikri Border', 'Singhu Border', 'Apsara Border'
            ]
        ]
    ],

    'gurgaon' => [
        [
            'category' => 'DLF Phase & Cyber Hub Corridor',
            'icon'     => 'fa-building',
            'locations' => [
                'Cyber Hub / DLF Cyber City', 'DLF Phase 1', 'DLF Phase 2', 'DLF Phase 3', 'DLF Phase 4',
                'DLF Phase 5 (Horizon / Golf Drive)', 'Ambience Island / Mall', 'DLF The Camellias',
                'DLF The Aralias', 'DLF The Magnolias', 'Sikanderpur Metro', 'MG Road Metro'
            ]
        ],
        [
            'category' => 'Golf Course Road & Extension',
            'icon'     => 'fa-road',
            'locations' => [
                'Golf Course Road (Sec 42 & 43)', 'Golf Course Road (Sec 53 & 54)', 'Sector 55 & 56',
                'Golf Course Extension Road', 'Sector 65 (M3M / Trump Tower)', 'Sector 66 / 67',
                'Sector 57 / Sushant Lok 2 & 3', 'Sector 58 / 59 (Grand Arch)', 'Vatika Chowk (SPR)'
            ]
        ],
        [
            'category' => 'Sohna Road, Central Gurgaon & Manesar',
            'icon'     => 'fa-location-dot',
            'locations' => [
                'Subhash Chowk (Sohna Road)', 'Badshahpur / Sohna Elevated Road', 'South City 1 & 2',
                'Nirvana Country (Sec 50)', 'Sector 29 / Leisure Valley', 'Sector 14 & 15 Gurgaon',
                'Sector 31 / 32 Tech Park', 'Sector 47 / Malibu Towne', 'Sector 48 / 49',
                'IFFCO Chowk', 'Huda City Centre (Millennium City)', 'Rajiv Chowk Gurgaon',
                'Hero Honda Chowk', 'Manesar (IMT Manesar)', 'Kherki Daula / Cloverleaf Expressway'
            ]
        ]
    ],

    'noida' => [
        [
            'category' => 'Central Noida & Sector Hubs',
            'icon'     => 'fa-building',
            'locations' => [
                'Sector 18 (Atta Market / DLF Mall)', 'Sector 15 / 16 Metro Hub', 'Sector 27 / 29 (Brahmaputra)',
                'Sector 37 / Botanical Garden Metro', 'Sector 50 (Central Noida)', 'Sector 51 & 52 Metro Interchange',
                'Sector 62 (Electronic City / Tech Zone)', 'Sector 63 / 64 IT Corridor', 'Sector 70 / 71'
            ]
        ],
        [
            'category' => 'Noida Expressway Corridor',
            'icon'     => 'fa-road',
            'locations' => [
                'Sector 93 / 93A (Expressway)', 'Sector 104 / 107 / 108', 'Sector 110 (Lotus Panache)',
                'Sector 128 (Jaypee Greens Wish Town)', 'Sector 137 (Metro & Paras Tierea)', 'Sector 142 / Advant Navis',
                'Sector 143 / 144 Expressway', 'Sector 150 (Sports City / Prive)', 'Sector 168 / 165'
            ]
        ],
        [
            'category' => '7X Sectors & Greater Noida',
            'icon'     => 'fa-city',
            'locations' => [
                'Sector 74 / 75 / 76 Corridor', 'Sector 77 / 78 (Silicon City)', 'Sector 119 / 120 / 121 (Gaur Grandeur)',
                'Greater Noida West (Gaur City 1 & 2)', 'Noida Extension / Char Murti', 'Pari Chowk (Greater Noida)',
                'Knowledge Park 1, 2 & 3', 'Alpha 1 & 2 (Greater Noida)', 'Beta & Gamma Sectors',
                'Jaypee Greens (Surajpur)', 'Yamuna Expressway Zero Point'
            ]
        ]
    ],

    'ghaziabad' => [
        [
            'category' => 'Indirapuram & NH-9 / DME Corridor',
            'icon'     => 'fa-building',
            'locations' => [
                'Shipra Sun City (Indirapuram)', 'Ahinsa Khand 1 & 2 (Indirapuram)', 'Vaibhav Khand',
                'Niti Khand & Nyay Khand', 'Gyan Khand (Indirapuram)', 'Swarna Jayanti Park (Indirapuram)',
                'Kala Patthar / NH-9 Indirapuram Exit', 'Delhi-Meerut Expressway Junction'
            ]
        ],
        [
            'category' => 'Vaishali, Kaushambi & Vasundhara',
            'icon'     => 'fa-location-dot',
            'locations' => [
                'Vaishali Sector 1 to 5', 'Vaishali Metro Station', 'Kaushambi Sector 14',
                'Kaushambi Metro Station', 'Anand Vihar Ghaziabad Border', 'Radisson Blu Kaushambi',
                'Vasundhara Sector 1 to 10', 'Vasundhara Sector 11 to 19', 'Sahibabad Industrial Area',
                'Mohan Nagar Temple / Metro Interchange'
            ]
        ],
        [
            'category' => 'Raj Nagar, Crossings Republik & City Centers',
            'icon'     => 'fa-city',
            'locations' => [
                'Raj Nagar Extension (All Societies)', 'Raj Nagar (Sector 10 to 14)', 'Kavi Nagar Ghaziabad',
                'Sanjay Nagar & Shastri Nagar', 'Crossings Republik (NH-9)', 'Govindpuram',
                'Old Bus Stand Ghaziabad', 'Ghaziabad Junction Railway Station', 'Hindon Elevated Road Entry'
            ]
        ]
    ],

    'faridabad' => [
        [
            'category' => 'Central Faridabad & NIT Sectors',
            'icon'     => 'fa-building',
            'locations' => [
                'Sector 15 & 15A Market', 'Sector 16 & 16A Faridabad', 'NIT 1 (Faridabad)',
                'NIT 2 & 3 (Faridabad)', 'NIT 4 & 5 (Faridabad)', 'Neelam Chowk Faridabad',
                'Bata Chowk Metro Station', 'BK Chowk & Escorts Corridor', 'Sector 14 Faridabad'
            ]
        ],
        [
            'category' => 'Greater Faridabad (Neharpar) & Modern Hubs',
            'icon'     => 'fa-city',
            'locations' => [
                'Sector 81 (Vipul / Puri)', 'Sector 82 (Florida / Grandura)', 'Sector 85 (BPTP Park Elite)',
                'Sector 86 (Princess Park / Omaxe)', 'Sector 88 & 89 (Amrita Hospital Hub)',
                'BPTP Parklands (Neharpar)', 'SRS Pearl / Sector 87', 'Kheri Pul Crossing'
            ]
        ],
        [
            'category' => 'Highway Exits, Surajkund & Ballabhgarh',
            'icon'     => 'fa-road',
            'locations' => [
                'Surajkund / Charmwood Village', 'Green Field Colony Faridabad', 'Ashoka Enclave / Sarai Metro',
                'Badarpur Border (Faridabad Side)', 'Badkhal Lake / Sector 21A, B, C', 'Sector 28 & 29 Metro',
                'Sector 30 & 31 Police Lines', 'Ballabhgarh Bus Terminal', 'Ballabhgarh Railway Station',
                'Mathura Road (NH-19 Corridor)'
            ]
        ]
    ]
];
