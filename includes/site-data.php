<?php
// Shared content used across the homepage, fleet, blog and article pages.

$site_phone_display = '+91 72908 85949';
$site_phone_tel     = '+917290885949';
$site_whatsapp      = '917290885949';
$site_email         = 'rentonurbania@gmail.com';
$site_address       = 'B-26, Rajeev Nagar, Near Radhey Krishna Mandir, Begumpur, New Delhi - 110086 (Opp. Rohini Sec-22)';
$site_url           = 'https://urbaniaonrentdelhi.co.in';

function wa_link($text) {
    global $site_whatsapp;
    return 'https://wa.me/' . $site_whatsapp . '?text=' . rawurlencode($text);
}

$fleet = [
    ['slug' => '9-seater', 'name' => '9 Seater Urbania (Maharaja)', 'seats' => 9, 'price' => 45, 'img' => 'images/urbania-4.webp', 'tag' => 'Ultra luxury',
     'type' => 'luxury', 'url' => '9-seater-urbania-maharaja-delhi.php',
     'alt' => '9 seater Force Urbania Luxury Maharaja on rent in Delhi NCR with extra-wide seats – luxury Urbania hire for VIP & family trips',
     'best' => 'VIP guests, honeymoon couples, premium family tours',
     'features' => ['Extra-wide Maharaja seats', 'Privacy partition', 'Smart TV & premium WiFi', 'Mini bar & mood lighting']],
    ['slug' => '12-seater', 'name' => '12 Seater Urbania (Maharaja)', 'seats' => 12, 'price' => 45, 'img' => 'images/urbania-1.webp', 'tag' => 'Custom interior',
     'type' => 'luxury', 'url' => '12-seater-urbania-luxury-delhi.php',
     'alt' => '12 seater Force Urbania Luxury Maharaja on rent in Delhi NCR with captain seats – premium Urbania for weddings & corporate tours',
     'best' => 'Destination weddings, film crews, premium group events',
     'features' => ['Captain seats with armrests', 'Premium entertainment', 'Reclining seats', 'Designer interiors']],
    ['slug' => '16-seater', 'name' => '16 Seater Urbania', 'seats' => 16, 'price' => 40, 'img' => 'images/urbania-5.webp', 'tag' => '2x1 seating',
     'type' => 'normal', 'url' => '16-seater-urbania-normal-delhi.php',
     'alt' => '16 seater Force Urbania Normal on rent in Delhi NCR with 2x1 pushback seats – budget Urbania for group tours & pilgrimages',
     'best' => 'Senior citizens, long-distance tours, corporate delegations',
     'features' => ['2x1 pushback seats', 'Walk-through aisle', 'Entertainment system', 'Charging points']],
];

// Blog posts. `route` links each guide to its booking page.
$blogs = [
    'delhi-to-jaipur'    => ['title' => 'The Ultimate Delhi to Jaipur Road Trip Guide', 'dest' => 'Jaipur', 'cat' => 'heritage', 'tag' => 'Heritage', 'region' => 'Rajasthan', 'dist' => '280 km', 'time' => '4 hrs', 'read' => 5, 'route' => 'delhi-to-jaipur-urbania.php',
        'excerpt' => 'The new expressway, a Neemrana Fort stop, and why a luxury Force Urbania on rent in Delhi is the best way to tour the Pink City.'],
    'delhi-to-agra'      => ['title' => 'Journey to the Taj: Delhi to Agra Guide', 'dest' => 'Agra', 'cat' => 'heritage', 'tag' => 'Heritage', 'region' => 'Uttar Pradesh', 'dist' => '210 km', 'time' => '3 hrs', 'read' => 4, 'route' => 'delhi-to-agra-urbania.php',
        'excerpt' => 'Cruise the Yamuna Expressway, catch a sunrise Taj Mahal view, and plan the perfect day trip with Urbania hire in Delhi.'],
    'delhi-to-manali'    => ['title' => 'Escaping to the Hills: Delhi to Manali', 'dest' => 'Manali', 'cat' => 'hill', 'tag' => 'Himalayas', 'region' => 'Himachal', 'dist' => '530 km', 'time' => '11 hrs', 'read' => 7, 'route' => 'delhi-to-manali-urbania.php',
        'excerpt' => 'Atal Tunnel, Solang snow points and smooth mountain hairpins in a luxury Urbania rental built for the hills.'],
    'delhi-to-shimla'    => ['title' => 'The Queen of Hills: Delhi to Shimla Guide', 'dest' => 'Shimla', 'cat' => 'hill', 'tag' => 'Himalayas', 'region' => 'Himachal', 'dist' => '340 km', 'time' => '7 hrs', 'read' => 5, 'route' => 'delhi-to-shimla-urbania.php',
        'excerpt' => 'Colonial charm on Mall Road, Kufri adventure parks, and booking an AC Force Urbania on rent in Delhi for the drive up.'],
    'delhi-to-rishikesh' => ['title' => 'Spiritual & Adventure: Delhi to Rishikesh', 'dest' => 'Rishikesh', 'cat' => 'spiritual', 'tag' => 'Adventure', 'region' => 'Uttarakhand', 'dist' => '240 km', 'time' => '4.5 hrs', 'read' => 5, 'route' => 'delhi-to-rishikesh-urbania.php',
        'excerpt' => 'Ganga rafting, cliff jumping and yoga ashrams — plus a reliable Urbania with driver in Delhi for weekend group trips.'],
    'delhi-to-haridwar'  => ['title' => 'Divine Pilgrimage: Delhi to Haridwar', 'dest' => 'Haridwar', 'cat' => 'spiritual', 'tag' => 'Pilgrimage', 'region' => 'Uttarakhand', 'dist' => '220 km', 'time' => '4 hrs', 'read' => 4, 'route' => 'delhi-to-haridwar-urbania.php',
        'excerpt' => 'Har Ki Pauri, sacred temples and ghat timings — with comfortable, elder-friendly Urbania for rent in Delhi.'],
    'delhi-to-amritsar'  => ['title' => 'Delhi to Amritsar Road Trip: Golden Temple Guide', 'dest' => 'Amritsar', 'cat' => 'spiritual', 'tag' => 'Spiritual', 'region' => 'Punjab', 'dist' => '450 km', 'time' => '7.5 hrs', 'read' => 6, 'route' => 'delhi-to-amritsar-urbania.php',
        'excerpt' => 'Drive the GT Road, stop for Murthal parathas, witness the Wagah Border ceremony, and book a luxury Urbania in Delhi.'],
    'delhi-to-udaipur'   => ['title' => 'Venice of the East: Delhi to Udaipur Road Trip', 'dest' => 'Udaipur', 'cat' => 'heritage', 'tag' => 'Royal Luxury', 'region' => 'Rajasthan', 'dist' => '660 km', 'time' => '10.5 hrs', 'read' => 7, 'route' => 'delhi-to-udaipur-urbania.php',
        'excerpt' => 'Royal palaces, sunset boats on Lake Pichola and Aravalli routes in a luxury Force Urbania from Delhi.'],
    'delhi-to-nainital'  => ['title' => 'Emerald Lakes of Kumaon: Delhi to Nainital', 'dest' => 'Nainital', 'cat' => 'hill', 'tag' => 'Lakes', 'region' => 'Uttarakhand', 'dist' => '300 km', 'time' => '7 hrs', 'read' => 5, 'route' => 'delhi-to-nainital-urbania.php',
        'excerpt' => 'Naini Lake boating, Snow View cable cars and pine-forest viewpoints — reserve a premium Urbania for outstation from Delhi.'],
    'delhi-to-mussoorie' => ['title' => 'Misty Valleys: Delhi to Mussoorie Road Trip', 'dest' => 'Mussoorie', 'cat' => 'hill', 'tag' => 'Hills', 'region' => 'Uttarakhand', 'dist' => '290 km', 'time' => '6 hrs', 'read' => 5, 'route' => 'delhi-to-mussoorie-urbania.php',
        'excerpt' => 'Kempty Falls, Landour bakeries and Lal Tibba views, driven comfortably in an Urbania for group tours from Delhi.'],
    'delhi-to-varanasi'  => ['title' => 'Ancient Kashi: Delhi to Varanasi Road Trip', 'dest' => 'Varanasi', 'cat' => 'spiritual', 'tag' => 'Expressway', 'region' => 'Uttar Pradesh', 'dist' => '820 km', 'time' => '12 hrs', 'read' => 8, 'route' => 'delhi-to-varanasi-urbania.php',
        'excerpt' => 'Agra-Lucknow and Purvanchal Expressways, Dashashwamedh Aarti and the Kashi Vishwanath Corridor by Urbania rental from Delhi NCR.'],
    'delhi-to-chardham'  => ['title' => 'Sacred Himalayan Circuit: Char Dham Yatra Guide', 'dest' => 'Char Dham', 'cat' => 'spiritual', 'tag' => 'Sacred Circuit', 'region' => 'Uttarakhand', 'dist' => '1,600+ km', 'time' => '10–12 days', 'read' => 10, 'route' => 'char-dham-urbania-package.php',
        'excerpt' => 'Yamunotri, Gangotri, Kedarnath and Badrinath — a full itinerary and why Force Urbania on rent in Delhi is the safest yatra vehicle.'],
    'delhi-to-khatu-shyam' => ['title' => 'Delhi to Khatu Shyam Ji by Force Urbania: Darshan Guide', 'dest' => 'Khatu Shyam', 'cat' => 'spiritual', 'tag' => 'Pilgrimage', 'region' => 'Rajasthan', 'dist' => '265 km', 'time' => '5.5 hrs', 'read' => 5, 'route' => 'delhi-to-khatu-shyam-urbania-on-rent.php',
        'excerpt' => 'Shyam Baba darshan, the Phalgun mela crowds and a Salasar Balaji add-on, travelling together in a Force Urbania on rent in Delhi.'],
    'delhi-to-vrindavan' => ['title' => 'Delhi to Vrindavan & Mathura: Braj Yatra by Force Urbania', 'dest' => 'Vrindavan', 'cat' => 'spiritual', 'tag' => 'Braj Yatra', 'region' => 'Uttar Pradesh', 'dist' => '165 km', 'time' => '3 hrs', 'read' => 5, 'route' => 'delhi-to-vrindavan-urbania-on-rent.php',
        'excerpt' => 'Banke Bihari, Prem Mandir, Mathura and Govardhan in one easy day or weekend trip by Force Urbania hire from Delhi.'],
    'delhi-to-ayodhya' => ['title' => 'Delhi to Ayodhya Ram Mandir Yatra by Force Urbania', 'dest' => 'Ayodhya', 'cat' => 'spiritual', 'tag' => 'Ram Janmabhoomi', 'region' => 'Uttar Pradesh', 'dist' => '690 km', 'time' => '11 hrs', 'read' => 6, 'route' => 'delhi-to-ayodhya-urbania-on-rent.php',
        'excerpt' => 'Expressways all the way to Shri Ram Janmabhoomi, Hanuman Garhi and the Saryu aarti, in a comfortable Force Urbania from Delhi.'],
    'delhi-to-jim-corbett' => ['title' => 'Delhi to Jim Corbett: Weekend Safari Trip by Force Urbania', 'dest' => 'Jim Corbett', 'cat' => 'hill', 'tag' => 'Wildlife', 'region' => 'Uttarakhand', 'dist' => '255 km', 'time' => '5.5 hrs', 'read' => 5, 'route' => 'delhi-to-jim-corbett-urbania-on-rent.php',
        'excerpt' => 'India\'s oldest national park, jungle safaris, Garjia Devi and riverside resorts, a perfect group weekend by Force Urbania from Delhi.'],
    'delhi-to-dharamshala' => ['title' => 'Delhi to Dharamshala & McLeod Ganj by Force Urbania', 'dest' => 'Dharamshala', 'cat' => 'hill', 'tag' => 'Himalayas', 'region' => 'Himachal', 'dist' => '480 km', 'time' => '9.5 hrs', 'read' => 5, 'route' => 'delhi-to-dharamshala-urbania.php',
        'excerpt' => 'Tibetan monasteries, Bhagsu waterfall, the Triund trek and Dhauladhar views, on a hill trip by Force Urbania hire from Delhi.'],
    'delhi-to-jaisalmer' => ['title' => 'Delhi to Jaisalmer: The Golden City Road Trip by Force Urbania', 'dest' => 'Jaisalmer', 'cat' => 'heritage', 'tag' => 'Desert', 'region' => 'Rajasthan', 'dist' => '770 km', 'time' => '13 hrs', 'read' => 6, 'route' => 'delhi-to-jaisalmer-urbania.php',
        'excerpt' => 'The living Golden Fort, havelis, Gadisar Lake and a night at the Sam sand dunes, on a desert road trip by Force Urbania from Delhi.'],
    'delhi-to-ranthambore' => ['title' => 'Delhi to Ranthambore: Tiger Safari Trip by Force Urbania', 'dest' => 'Ranthambore', 'cat' => 'heritage', 'tag' => 'Tigers & Forts', 'region' => 'Rajasthan', 'dist' => '380 km', 'time' => '6 hrs', 'read' => 5, 'route' => 'delhi-to-ranthambore-urbania.php',
        'excerpt' => 'Tiger safaris, the UNESCO-listed Ranthambore Fort and Trinetra Ganesh, via the new Delhi–Mumbai Expressway in a Force Urbania.'],
    'delhi-to-kasol' => ['title' => 'Delhi to Kasol & Parvati Valley by Force Urbania', 'dest' => 'Kasol', 'cat' => 'hill', 'tag' => 'Parvati Valley', 'region' => 'Himachal', 'dist' => '520 km', 'time' => '11 hrs', 'read' => 5, 'route' => 'delhi-to-kasol-urbania-on-rent.php',
        'excerpt' => 'Riverside cafes, Manikaran Sahib, the Kheerganga trek and Tosh: a Parvati Valley group trip by Force Urbania hire from Delhi.'],
    'delhi-to-lansdowne' => ['title' => 'Delhi to Lansdowne: A Quiet Hill Weekend by Force Urbania', 'dest' => 'Lansdowne', 'cat' => 'hill', 'tag' => 'Quiet Hills', 'region' => 'Uttarakhand', 'dist' => '260 km', 'time' => '6 hrs', 'read' => 4, 'route' => 'delhi-to-lansdowne-urbania-on-rent.php',
        'excerpt' => 'A peaceful cantonment hill town with pine forests, Bhulla Tal and Tip-n-Top views, an easy weekend by Force Urbania from Delhi.'],
];

$blog_landmark_alts = [
    'delhi-to-jaipur'    => 'Hawa Mahal Palace of Winds in Jaipur, Rajasthan',
    'delhi-to-agra'      => 'Taj Mahal marble monument in Agra, Uttar Pradesh',
    'delhi-to-manali'    => 'Snow-covered mountain peaks in Manali, Himachal Pradesh',
    'delhi-to-shimla'    => 'Mall Road and Ridge hill station vista in Shimla, Himachal Pradesh',
    'delhi-to-rishikesh' => 'Laxman Jhula suspension bridge over river Ganga in Rishikesh, Uttarakhand',
    'delhi-to-haridwar'  => 'Ganga river ghats at Har Ki Pauri in Haridwar, Uttarakhand',
    'delhi-to-amritsar'  => 'Golden Temple sanctum and holy sarovar in Amritsar, Punjab',
    'delhi-to-udaipur'   => 'City Palace and Lake Pichola in Udaipur, Rajasthan',
    'delhi-to-nainital'  => 'Naini Lake and surrounding green hills in Nainital, Uttarakhand',
    'delhi-to-mussoorie' => 'Kempty Falls and scenic mountain valley in Mussoorie, Uttarakhand',
    'delhi-to-varanasi'  => 'Ganga Aarti evening prayer ritual at Dashashwamedh Ghat in Varanasi, Uttar Pradesh',
    'delhi-to-chardham'  => 'Ancient Kedarnath Temple against Himalayan snow peaks in Uttarakhand',
    'delhi-to-khatu-shyam' => 'Shri Khatu Shyam Ji temple sanctum in Sikar, Rajasthan',
    'delhi-to-vrindavan' => 'Prem Mandir white marble temple in Vrindavan, Uttar Pradesh',
    'delhi-to-ayodhya' => 'Shri Ram Janmabhoomi Mandir in Ayodhya, Uttar Pradesh',
    'delhi-to-jim-corbett' => 'Wild elephants in the grasslands of Dhikala, Jim Corbett National Park',
    'delhi-to-dharamshala' => 'View over McLeod Ganj and the Kangra valley, Dharamshala, Himachal Pradesh',
    'delhi-to-jaisalmer' => 'Jaisalmer Fort, the golden sandstone fort of Jaisalmer, Rajasthan',
    'delhi-to-ranthambore' => 'Bengal tiger in Ranthambore National Park, Rajasthan',
    'delhi-to-kasol' => 'Parvati valley near Kasol, Kullu district, Himachal Pradesh',
    'delhi-to-lansdowne' => 'Hills and winding road around Lansdowne in the monsoon, Uttarakhand',
];

foreach ($blogs as $slug => &$b) {
    $b['slug'] = $slug;
    $b['url']  = 'blog-' . $slug . '.php';
    $b['img']  = 'images/blog_' . str_replace('delhi-to-', 'delhi_', $slug) . '.jpg';
    $b['alt']  = ($blog_landmark_alts[$slug] ?? ('Scenic landscape in ' . $b['dest'])) . ' – Delhi to ' . $b['dest'] . ' Urbania on rent for family & group tours';
}
unset($b);

// Normal vs Luxury Maharaja fleet groups. Prices always come from $fleet above.
$fleet_types = [
    'luxury' => ['label' => 'Luxury Maharaja Urbania', 'url' => 'force-urbania-luxury-maharaja-on-rent-delhi.php'],
    'normal' => ['label' => 'Normal Urbania', 'url' => 'force-urbania-normal-on-rent-delhi.php'],
];

function fleet_by_type($type) {
    global $fleet;
    return array_values(array_filter($fleet, function ($v) use ($type) { return $v['type'] === $type; }));
}

function fleet_min_price(array $vehicles) {
    return min(array_column($vehicles, 'price'));
}

// Delhi NCR pickup areas shown on the homepage and landing pages.
$ncr_areas = [
    'Delhi'     => ['url' => null, 'areas' => 'Rohini, Pitampura, Dwarka, Janakpuri, Lajpat Nagar, Connaught Place, Karol Bagh, Saket, Vasant Kunj, Mayur Vihar, Preet Vihar, IGI Airport'],
    'Gurgaon'   => ['url' => 'urbania-on-rent-gurgaon.php', 'areas' => 'Cyber City, Golf Course Road, Sohna Road, MG Road, DLF Phases 1–5, Udyog Vihar, Manesar'],
    'Noida'     => ['url' => 'urbania-on-rent-noida.php', 'areas' => 'Sector 18, Sector 62, Film City, Noida Extension, Greater Noida, Pari Chowk'],
    'Ghaziabad' => ['url' => null, 'areas' => 'Vaishali, Indirapuram, Kaushambi, Raj Nagar Extension, Crossings Republik'],
    'Faridabad' => ['url' => null, 'areas' => 'NIT, Sector 15, Ballabgarh, Surajkund, Greater Faridabad'],
];

// Vehicle + offer schema for a set of fleet entries.
function fleet_offer_schema(array $vehicles, $name) {
    global $site_url;
    $prices = array_column($vehicles, 'price');
    return '<script type="application/ld+json">' . json_encode([
        '@context' => 'https://schema.org',
        '@type' => 'Service',
        'name' => $name,
        'serviceType' => 'Force Urbania rental with driver',
        'provider' => ['@id' => $site_url],
        'areaServed' => array_map(function ($c) { return ['@type' => 'City', 'name' => $c]; }, ['Delhi', 'Gurgaon', 'Noida', 'Greater Noida', 'Ghaziabad', 'Faridabad']),
        'offers' => [
            '@type' => 'AggregateOffer',
            'priceCurrency' => 'INR',
            'lowPrice' => min($prices),
            'highPrice' => max($prices),
            'offerCount' => count($vehicles),
            'offers' => array_map(function ($v) use ($site_url) {
                return [
                    '@type' => 'Offer',
                    'url' => $site_url . '/' . $v['url'],
                    'priceSpecification' => ['@type' => 'UnitPriceSpecification', 'price' => $v['price'], 'priceCurrency' => 'INR', 'unitText' => 'km'],
                    'itemOffered' => [
                        '@type' => 'Vehicle',
                        'name' => $v['name'],
                        'brand' => ['@type' => 'Brand', 'name' => 'Force Motors'],
                        'model' => 'Force Urbania',
                        'seatingCapacity' => $v['seats'],
                        'image' => $site_url . '/' . $v['img'],
                    ],
                ];
            }, $vehicles),
        ],
    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>';
}

// Breadcrumb trail + BreadcrumbList schema. $items = [['Label', 'url.php'], ..., ['Current page', null]]
function render_crumbs(array $items) {
    global $site_url;
    $all = array_merge([['Home', 'index.php']], $items);
    echo '<nav class="pg-crumbs" aria-label="Breadcrumb">';
    foreach ($all as $i => $item) {
        if ($i > 0) echo '<i class="fas fa-chevron-right"></i>';
        echo $item[1] ? '<a href="' . $item[1] . '">' . htmlspecialchars($item[0]) . '</a>' : '<span>' . htmlspecialchars($item[0]) . '</span>';
    }
    echo '</nav>';
    $list = [];
    foreach ($all as $i => $item) {
        $url = $item[1] ?: basename($_SERVER['PHP_SELF']);
        $list[] = ['@type' => 'ListItem', 'position' => $i + 1, 'name' => $item[0], 'item' => $site_url . '/' . ($url === 'index.php' ? '' : $url)];
    }
    echo '<script type="application/ld+json">' . json_encode(['@context' => 'https://schema.org', '@type' => 'BreadcrumbList', 'itemListElement' => $list], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>';
}

function faq_schema(array $faqs) {
    return '<script type="application/ld+json">' . json_encode([
        '@context' => 'https://schema.org', '@type' => 'FAQPage',
        'mainEntity' => array_map(function ($f) {
            return ['@type' => 'Question', 'name' => $f['q'], 'acceptedAnswer' => ['@type' => 'Answer', 'text' => $f['a']]];
        }, $faqs),
    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>';
}
