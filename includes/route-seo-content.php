<?php
// SEO meta tags, schema, keyword content and FAQs for every route page rendered by route.php.
// Tokens: {O} origin, {D} destination, {KM} distance, {REGION} state or region,
// {FOR_STATE} " for <state>" (blank when only a region is known), {SEATS}, {LARGE_SEATS}.

// The live fleet is 9, 12 and 16 seaters. Set to true to publish the 20 and 26 seater copy too.
const ROUTE_SHOW_20_26_SEATERS = false;

const ROUTE_SITE_URL = 'https://urbaniaonrentdelhi.co.in/';

// Every origin has a physical <slug>.php stub that loads route.php (no .htaccess needed).
function route_public_url(array $dest) {
    return ROUTE_SITE_URL . $dest['slug'] . '.php';
}

function route_seo_fill($text, array $dest) {
    $is_real_state = !empty($dest['state']) && $dest['state'] !== 'North India';
    $extra = ROUTE_SHOW_20_26_SEATERS;
    return strtr($text, [
        '{O}' => $dest['origin'],
        '{D}' => $dest['destination'],
        '{KM}' => $dest['distance_str'],
        '{REGION}' => $is_real_state ? $dest['state'] : 'North India',
        '{FOR_STATE}' => $is_real_state ? ' for ' . $dest['state'] : '',
        '{SEATS}' => $extra ? '9-seater, 12-seater, 16-seater, 20-seater, and 26-seater' : '9-seater, 12-seater, and 16-seater',
        '{LARGE_SEATS}' => $extra ? '16, 20, and 26 seaters' : '12 and 16 seaters',
    ]);
}

// Returns [[heading, [paragraph, ...]], ...]
function route_seo_sections(array $dest) {
    $raw = <<<'TXT'
Urbania on rent from {O} to {D}
Securing an authentic Urbania on rent from {O} to {D} directly through our transport operations guarantees a smooth, safe, and luxurious highway transit experience. As an established direct service provider operating our own vehicle fleet across Delhi NCR, we ensure that every customer seeking Urbania on rent from {O} to {D} receives a commercially licensed, impeccably maintained, and thoroughly sanitized luxury vehicle. The highway corridor connecting {O} to {D} requires vehicle stability, reliable air cooling performance, and superior structural damping, making our Urbania on rent from {O} to {D} the first choice for family holidays, corporate tours, and destination wedding parties. Choosing Urbania on rent from {O} to {D} removes all the hassle of organizing multiple small private cabs, keeping your entire travel entourage together inside a peaceful, climate-controlled mobile lounge.
Our operational team manages the dispatch process for Urbania on rent from {O} to {D} with extreme precision, conducting routine computer diagnostic checks on engine parameters, tire tread depth, suspension bushes, and electronic brake systems before every highway assignment. Travelers booking Urbania on rent from {O} to {D} enjoy door-to-door pickup from any address in Delhi, Noida, Gurgaon, Ghaziabad, or Faridabad, followed by direct highway transit to {D}. The quiet ride, high aerodynamic stability, and plush interior appointments of our modern fleet ensure that choosing Urbania on rent from {O} to {D} turns a tedious {KM} road trip into a deeply relaxing travel experience.

Urbania hire in {O} to {D}
Opting for our direct Urbania hire in {O} to {D} gives private groups and executive delegations access to premium commercial travel machinery without paying third-party broker fees. When you finalize an Urbania hire in {O} to {D} with our agency, you deal directly with the vehicle owners, ensuring accurate communication regarding pickup timelines, route options, and vehicle modifications. Our transparent pricing model for Urbania hire in {O} to {D} protects your budget from sudden last-minute surcharges, hidden maintenance fees, or inflated peak-season adjustments. Every vehicle dispatched under our Urbania hire in {O} to {D} division is backed by commercial passenger permits and comprehensive insurance policies for interstate highway transit.
Our chauffeurs assigned to Urbania hire in {O} to {D} are verified highway specialists who understand the driving conditions, bypass intersections, and safe resting stops along the {REGION} corridor. By choosing Urbania hire in {O} to {D}, senior citizens and young children avoid the physical fatigue caused by stiff suspensions and cramped knee angles found in older vans. The independent front suspension and monocoque chassis that power our Urbania hire in {O} to {D} fleet absorb road bumps seamlessly, ensuring a calm, smooth journey from the moment you depart {O} until you arrive at your {D} hotel.

Urbania booking {O} to {D}
Confirming an Urbania booking {O} to {D} through our reservation team is a fast, straightforward, and dependable procedure. When you submit your requirements for an Urbania booking {O} to {D}, our staff confirms chassis availability, calculates transparent travel quotes, and locks in your travel schedule without complex paperwork. Completing your Urbania booking {O} to {D} well before departure guarantees that a pristine, pre-inspected luxury vehicle is assigned exclusively to your family or corporate group. Event organizers managing destination weddings rely on our Urbania booking {O} to {D} because our team honors commitments with zero cancellations or last-minute vehicle downgrades.
Our customer support desk assists you throughout the entire Urbania booking {O} to {D} cycle, providing itemized invoices that clearly explain highway toll fees, state road taxes, parking fees, and driver allowances. Once your Urbania booking {O} to {D} is logged into our central dispatch software, you receive direct driver credentials, vehicle registration details, and real-time support. In the event of flight schedule changes at Indira Gandhi International Airport, our Urbania booking {O} to {D} team adapts pickup times dynamically, ensuring that your vehicle is waiting right at the arrival terminal when you step outside.

outstation Urbania from {O} to {D}
Hiring an outstation Urbania from {O} to {D} from our licensed operations ensures complete mechanical reliability and passenger safety across interstate borders. Driving long stretches of open highway demands high engine torque, efficient thermal heat dissipation, and powerful disc brakes, which are standard features in every outstation Urbania from {O} to {D} we operate. Our outstation drivers possess extensive knowledge of state border tax procedures, expressway toll plazas, and clean highway rest stops, ensuring that your outstation Urbania from {O} to {D} journey runs smoothly without unnecessary roadside delays.
Booking an outstation Urbania from {O} to {D} allows you to design custom itineraries that combine highway transfers with local sightseeing across the landmarks and busy bazaars of {D}. Because your outstation Urbania from {O} to {D} stays dedicated to your group for the entire trip, you enjoy complete freedom over departure hours, meal stops, and photo sessions along the way. Every outstation Urbania from {O} to {D} features strong thermal window insulation and individual air conditioning louvers at each seat, keeping everyone cool and comfortable even during peak summer heat.

best Urbania service in {O} to {D}
We are committed to delivering the best Urbania service in {O} to {D} through our private company-owned fleet, stringent maintenance standards, and customer-focused hospitality. Travelers and corporate planners consider our company the best Urbania service in {O} to {D} because we never outsource bookings to unverified third-party operators. Providing the best Urbania service in {O} to {D} means each vehicle leaves our garage with pristine upholstery, spotless floors, fully functioning personal device charging ports, and crystal-clear sound systems.
Our drivers uphold the reputation of our best Urbania service in {O} to {D} by practicing courteous road etiquette, keeping safe following distances, and dressing in neat professional uniforms. They avoid harsh acceleration and sudden braking, ensuring that elderly relatives and young children rest peacefully. When you choose the best Urbania service in {O} to {D}, you receive dedicated trip monitoring, clear billing without hidden fuel surcharges, and a comfortable highway ride that sets the standard for modern outstation travel.

Book Urbania from {O} to {D}
When you choose to Book Urbania from {O} to {D} with our team, you partner directly with a dedicated group transportation specialist. We know that every group has distinct requirements; when corporate planners Book Urbania from {O} to {D}, they require quiet interiors, individual high-speed USB ports, and smooth ride dynamics to review business presentations on laptops. Conversely, extended families who Book Urbania from {O} to {D} look for plush reclining seats, generous luggage capacity, and soft cabin lighting to keep toddlers and seniors comfortable.
Our reservation agents simplify the process when you Book Urbania from {O} to {D}, offering multiple pickup stops across South Delhi, Central Delhi, West Delhi, Noida, and Gurgaon without complicated paperwork. When you Book Urbania from {O} to {D} in advance of long weekends, festival periods, or wedding seasons, you secure your preferred seating configuration and lock in predictable, fair rates. Choosing to Book Urbania from {O} to {D} through our transport desk gives you absolute peace of mind, backed by guaranteed on-time arrivals and dedicated round-the-clock trip coordination.

luxury Urbania hire {O} to {D}
Choosing our luxury Urbania hire {O} to {D} transforms long highway travel into an executive lounge experience that rivals business-class air transit. Every vehicle in our luxury Urbania hire {O} to {D} tier features customized ergonomic captain seating, soft Italian leatherette upholstery, integrated calf supports, and wide armrests. Our luxury Urbania hire {O} to {D} vans feature panoramic sealed windows with sun-protection tinting, giving you sweeping views of the passing landscape while keeping out highway heat, glare, and road noise.
Our luxury Urbania hire {O} to {D} provides generous interior headroom, allowing adult passengers to stand upright and walk freely down the central gangway without stooping or bumping into neighboring seats. The acoustic soundproofing engineered into our luxury Urbania hire {O} to {D} fleet dampens tire noise and engine roar, creating a calm environment where you can conduct clear phone calls, hold discussions, or sleep undisturbed. With individual reading lamps, balanced ceiling-mounted air blowers, and high-definition multimedia screens, our luxury Urbania hire {O} to {D} sets the benchmark for interstate road luxury.

9 seater Force Urbania on rent in {O} for {D}
Selecting a 9 seater Force Urbania on rent in {O} for {D} from our luxury garage provides an ultra-spacious, executive sanctuary for smaller leadership teams, VIP clients, and intimate family circles. This specialized 9 seater Force Urbania on rent in {O} for {D} trades high passenger density for spacious standalone captain recliners arranged with generous legroom. When you reserve a 9 seater Force Urbania on rent in {O} for {D}, each passenger enjoys their own dedicated personal space, complete with individual charging ports, cup holders, and deep seat recline angles for refreshing highway naps.
The generous proportions of our 9 seater Force Urbania on rent in {O} for {D} create a massive rear luggage area capable of accommodating large suitcases, golf kits, and fragile gift boxes without infringing upon passenger foot room. Booking our 9 seater Force Urbania on rent in {O} for {D} guarantees nimble highway handling, smooth acceleration along open highways, and effortless maneuvering through local {D} streets. Discerning travelers who value individual comfort, privacy, and prestige consistently choose our 9 seater Force Urbania on rent in {O} for {D} for their outstation journeys.

12 seater Urbania hire in {O} for {D}
Reserving a 12 seater Urbania hire in {O} for {D} provides an ideal balance of group seating capacity and generous personal comfort, making it our most requested configuration for family holidays and mid-sized corporate groups. Opting for a 12 seater Urbania hire in {O} for {D} ensures that all twelve passengers travel together in plush, individual reclining bucket seats with direct aisle access. Our 12 seater Urbania hire in {O} for {D} eliminates the tight seating, stiff suspension, and stuffy cabin air associated with older commercial vans, keeping everyone relaxed and energized throughout the journey.
Each row in our 12 seater Urbania hire in {O} for {D} is served by overhead high-velocity air conditioning louvers and individual reading lamps, ensuring personalized comfort across changing ambient weather conditions. The robust build and independent front suspension of our 12 seater Urbania hire in {O} for {D} fleet smooth out expansion joints, potholes, and speed breakers with ease. When you select our 12 seater Urbania hire in {O} for {D}, your luggage is stowed securely in a dedicated rear cargo hold, keeping the passenger aisle clean, spacious, and safe.

book 16 seater luxury Urbania from {O} to {D}
When you choose to book 16 seater luxury Urbania from {O} to {D}, your extended family, corporate department, or wedding entourage travels together without the hassle of splitting up into separate cars. Choosing to book 16 seater luxury Urbania from {O} to {D} provides a spacious cabin with an upright standing height of over six feet, allowing passengers to move along the center aisle with complete ease. Our clients book 16 seater luxury Urbania from {O} to {D} because it combines the generous capacity of a minibus with the smooth handling and refined suspension of a luxury passenger van.
The high-output climate control systems inside our fleet ensure that when you book 16 seater luxury Urbania from {O} to {D}, cool air circulates evenly to every single seat, including the rear row. Ample under-seat space and an expansive rear trunk ensure that when you book 16 seater luxury Urbania from {O} to {D}, all baggage, shopping purchases, and event materials are stored securely away from passenger legroom. Backed by our verified highway drivers and strict maintenance schedules, choosing to book 16 seater luxury Urbania from {O} to {D} guarantees a dependable and enjoyable road trip for your entire party.

20 seater Urbania on rent from {O} to {D}
Opting for our 20 seater Urbania on rent from {O} to {D} delivers a modern, comfortable travel solution for large tour groups, international travel contingents, and destination wedding parties who want to avoid the noisy, bumpy ride of traditional large buses. The chassis architecture of our 20 seater Urbania on rent from {O} to {D} utilizes advanced monocoque construction, delivering superior structural rigidity, reduced body lean around curves, and low vibration levels on high-speed expressways. Securing a 20 seater Urbania on rent from {O} to {D} keeps your group unified, making departure roll calls and highway meal stops easy to coordinate.
Our drivers assigned to the 20 seater Urbania on rent from {O} to {D} are seasoned highway operators trained in gradual braking, smooth acceleration, and disciplined lane control. Every seat in the 20 seater Urbania on rent from {O} to {D} is fitted with high-density cushioning, headrests, and three-point safety belts, ensuring that long travel hours remain safe and restful. Choosing our 20 seater Urbania on rent from {O} to {D} simplifies interstate toll plaza clearances and state border tax paperwork, giving your entire travel party a smooth, worry-free outstation transit experience.

26 seater Urbania hire from {O} to {D}
Our heavy-duty 26 seater Urbania hire from {O} to {D} represents our highest-capacity configuration, engineered specifically to transport large tour groups, university faculties, corporate teams, and extended wedding parties in complete luxury. Older large buses frequently suffer from stiff leaf-spring suspensions, noisy interiors, and slow hill climbs; our 26 seater Urbania hire from {O} to {D} replaces those outdated dynamics with independent suspension comfort, low internal noise levels, and modern turbodiesel performance. Reserving a 26 seater Urbania hire from {O} to {D} allows twenty-six travelers to enjoy panoramic views, personalized air cooling vents, and comfortable recline angles throughout the ride.
Passenger safety is paramount in our 26 seater Urbania hire from {O} to {D} operations, which is why every vehicle features anti-lock braking systems (ABS), electronic stability programs (ESP), dual emergency exits, and certified commercial fire extinguishers. The cavernous luggage storage engineered into our 26 seater Urbania hire from {O} to {D} accommodates dozens of large travel bags, wedding gifts, and promotional equipment with ease. When you select our 26 seater Urbania hire from {O} to {D}, our route logistics managers coordinate every pickup milestone, ensuring on-time departure and direct delivery right to your {D} destination.

online Urbania booking {O} to {D}
Completing an online Urbania booking {O} to {D} through our digital platform gives you instant access to confirmed fleet availability, transparent pricing, and immediate booking verification. By utilizing our online Urbania booking {O} to {D} portal at https://urbaniaonrentdelhi.co.in/, you bypass middlemen, booking agents, and third-party aggregators, securing the best direct fleet rates for your travel dates. The online Urbania booking {O} to {D} system lets you select your preferred seating layout, enter custom pickup points across Delhi NCR, specify one-way or round-trip requirements, and lock in your reservation within minutes.
Once your online Urbania booking {O} to {D} request is submitted, our operations desk processes your travel plan, verifies the assigned vehicle chassis, and sends an itemized digital confirmation along with full driver credentials. Choosing online Urbania booking {O} to {D} provides access to round-the-clock customer assistance on phone and WhatsApp lines, ensuring immediate help if flight schedules shift or pickup locations change. With our proven online Urbania booking {O} to {D} infrastructure, you can reserve with complete confidence, knowing that a clean, fully fueled luxury vehicle with a professional driver will be waiting at your doorstep right on time.
TXT;

    $sections = [];
    foreach (preg_split('/\n\s*\n/', trim(route_seo_fill($raw, $dest))) as $block) {
        $lines = explode("\n", trim($block));
        $heading = array_shift($lines);
        if (!ROUTE_SHOW_20_26_SEATERS && preg_match('/^(20|26) seater/', $heading)) {
            continue;
        }
        $sections[] = [ucfirst($heading), $lines];
    }
    return $sections;
}

function route_seo_faqs(array $dest) {
    $raw = <<<'TXT'
What seating capacities of Force Urbania are available in your fleet for the {O} to {D} route?
Our garage maintains a versatile fleet consisting of {SEATS} Force Urbania models. Our fleet is available in Normal and Luxury Maharaja formats to suit family holidays, executive delegations, destination weddings, and corporate outings.
How does Force Urbania provide a better travel experience than traditional tempo travellers on the highway?
Force Urbania is built on a modern monocoque chassis featuring independent front suspension, which significantly reduces body roll, chassis twisting, and vertical road shocks. Combined with factory-fitted noise insulation, individual passenger air vents, direct USB charging ports, and wide reclining bucket seats, it offers a smoother, quieter, and more comfortable ride than older commercial vans.
Are interstate border taxes, toll road fees, and driver allowances included in the trip quote?
We provide clear, customized quotations based on your specific travel plans. We can bill all highway tolls, state passenger taxes{FOR_STATE}, and driver night allowances into one transparent, all-inclusive package, or itemize them based on your billing preferences, ensuring zero surprise charges at the end of your trip.
Can your vehicles pick up passengers from multiple addresses across Delhi NCR before heading to {D}?
Yes, we readily accommodate multi-point pickups across Delhi, Noida, Greater Noida, Ghaziabad, and Gurugram, as well as direct terminal meet-and-greets at Indira Gandhi International Airport (DEL). Simply provide your scheduled stops when booking so our dispatch team can plot the most efficient highway route.
How much advance notice is required to reserve an Urbania for an outstation trip?
While we can often arrange same-day dispatches depending on vehicle availability, we recommend reserving your Urbania at least 3 to 7 days ahead of your travel date. Peak travel windows, long holiday weekends, and winter wedding seasons see high demand, so booking early secures your preferred seating layout and luxury tier.
What luggage storage space is available on the various Urbania models?
All of our Force Urbania vans feature dedicated rear boot compartments designed to hold full-sized suitcases, duffel bags, and cabin luggage safely outside the passenger area. Larger capacity configurations ({LARGE_SEATS}) offer expanded luggage capacity, ensuring the interior aisle and legroom remain completely unobstructed throughout the journey.
TXT;

    $lines = explode("\n", trim(route_seo_fill($raw, $dest)));
    $faqs = [];
    for ($i = 0; $i + 1 < count($lines); $i += 2) {
        $faqs[] = ['q' => $lines[$i], 'a' => $lines[$i + 1]];
    }
    return $faqs;
}

// Returns ['primary' => html, 'social' => html] for header.php.
function route_seo_meta(array $dest, $page_url) {
    $o = $dest['origin'];
    $d = $dest['destination'];
    $extra = ROUTE_SHOW_20_26_SEATERS;
    $max = $extra ? '26' : '16';
    $seats = $extra ? '9, 12, 16, 20 &amp; 26' : '9, 12 &amp; 16';
    $route = htmlspecialchars("$o to $d");
    $from = htmlspecialchars("from $o to $d");
    $in_for = htmlspecialchars("in $o for $d");

    $keywords = [
        "Urbania on rent from $o to $d", "Urbania hire in $o to $d", "Urbania booking $o to $d",
        "outstation Urbania from $o to $d", "best Urbania service in $o to $d", "Book Urbania from $o to $d",
        "luxury Urbania hire $o to $d", "9 seater Force Urbania on rent in $o for $d", "12 seater Urbania hire in $o for $d",
        "book 16 seater luxury Urbania from $o to $d",
    ];
    if ($extra) {
        $keywords[] = "20 seater Urbania on rent from $o to $d";
        $keywords[] = "26 seater Urbania hire from $o to $d";
    }
    $keywords[] = "online Urbania booking $o to $d";
    $keywords = htmlspecialchars(implode(', ', $keywords));

    $url = htmlspecialchars($page_url);
    $image = ROUTE_SITE_URL . $dest['hero_image'];
    $size = getimagesize(dirname(__DIR__) . '/' . $dest['hero_image']);
    $alt = "Force Urbania on Rent $from";

    $primary = <<<HTML
    <title>Urbania on Rent $from | 9 to $max Seater Luxury Van Hire</title>
    <meta name="description" content="Book luxury Force Urbania on rent $from. Direct fleet service provider for $seats seater Urbania hire with verified drivers. Best rates.">
    <meta name="keywords" content="$keywords">
    <meta name="robots" content="index, follow">
    <meta name="author" content="Urbania on Rent Delhi">
    <link rel="canonical" href="$url">
HTML;

    $social = <<<HTML
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:locale" content="en_IN">
    <meta property="og:url" content="$url">
    <meta property="og:site_name" content="Urbania on Rent Delhi">
    <meta property="og:title" content="Urbania on Rent $from | Luxury Van Hire Service">
    <meta property="og:description" content="Hire luxury Force Urbania vans $from directly from the service provider. $seats seater options with expert highway chauffeurs.">
    <meta property="og:image" content="$image">
    <meta property="og:image:secure_url" content="$image">
    <meta property="og:image:type" content="{$size['mime']}">
    <meta property="og:image:width" content="{$size[0]}">
    <meta property="og:image:height" content="{$size[1]}">
    <meta property="og:image:alt" content="$alt">

    <!-- Twitter Cards -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="$url">
    <meta name="twitter:title" content="Urbania on Rent $from | 9 to $max Seater Fleet">
    <meta name="twitter:description" content="Direct service provider for Force Urbania on rent $from. Monocoque chassis comfort, clean fleet, transparent rates.">
    <meta name="twitter:image" content="$image">
    <meta name="twitter:image:alt" content="$alt">
HTML;

    return ['primary' => $primary, 'social' => $social];
}

function route_seo_schema(array $dest, $page_url, array $faqs) {
    $o = $dest['origin'];
    $d = $dest['destination'];
    $extra = ROUTE_SHOW_20_26_SEATERS;
    $provider_id = 'https://urbaniaonrentdelhi.co.in'; // Same @id as the AutoRental block in header.php
    $website_id = ROUTE_SITE_URL . '#website';
    $seats = $extra ? '9, 12, 16, 20 & 26' : '9, 12 & 16';
    $max = $extra ? '26' : '16';

    $area = [
        ['@type' => 'City', 'name' => $o],
        ['@type' => 'City', 'name' => $d],
        ['@type' => 'AdministrativeArea', 'name' => 'Delhi NCR'],
    ];
    if (!empty($dest['state']) && $dest['state'] !== 'North India') {
        $area[] = ['@type' => 'State', 'name' => $dest['state']];
    }

    $offer_names = [
        "9 Seater Force Urbania on Rent in $o for $d",
        "12 Seater Urbania Hire in $o for $d",
        "16 Seater Luxury Urbania from $o to $d",
    ];
    if ($extra) {
        $offer_names[] = "20 Seater Urbania on Rent from $o to $d";
        $offer_names[] = "26 Seater Urbania Hire from $o to $d";
    }

    $graph = [
        [
            '@type' => 'AutoRental',
            '@id' => $provider_id,
            'name' => 'Urbania on Rent Delhi',
            'url' => ROUTE_SITE_URL,
            'image' => ROUTE_SITE_URL . 'images/urbania-rent.webp',
            'telephone' => '+91-7290885949',
            'email' => 'rentonurbania@gmail.com',
            'priceRange' => '₹40 - ₹45/km',
            'areaServed' => $area,
            'address' => [
                '@type' => 'PostalAddress',
                'streetAddress' => 'B-26, Rajeev Nagar, Near Radhey Krishna Mandir, Begumpur, Opp. Rohini Sec-22',
                'addressLocality' => 'New Delhi',
                'postalCode' => '110086',
                'addressRegion' => 'DL',
                'addressCountry' => 'IN',
            ],
        ],
        [
            '@type' => 'WebPage',
            '@id' => $page_url . '#webpage',
            'url' => $page_url,
            'name' => "Urbania on Rent from $o to $d | 9 to $max Seater Luxury Van Hire",
            'description' => "Book luxury Force Urbania on rent from $o to $d. Direct fleet service provider for $seats seater Urbania hire with verified drivers.",
            'isPartOf' => ['@type' => 'WebSite', '@id' => $website_id, 'url' => ROUTE_SITE_URL, 'name' => 'Urbania on Rent Delhi'],
            'about' => ['@id' => $provider_id],
        ],
        [
            '@type' => 'Service',
            '@id' => $page_url . '#service',
            'name' => "Urbania on Rent from $o to $d",
            'url' => $page_url,
            'serviceType' => 'Intercity Luxury Van Rental',
            'provider' => ['@id' => $provider_id],
            'areaServed' => [['@type' => 'City', 'name' => $o], ['@type' => 'City', 'name' => $d]],
            'hasOfferCatalog' => [
                '@type' => 'OfferCatalog',
                'name' => "$o to $d Fleet Models",
                'itemListElement' => array_map(function ($name) {
                    return ['@type' => 'Offer', 'itemOffered' => ['@type' => 'Service', 'name' => $name]];
                }, $offer_names),
            ],
        ],
        [
            '@type' => 'FAQPage',
            '@id' => $page_url . '#faq',
            'mainEntity' => array_map(function ($f) {
                return ['@type' => 'Question', 'name' => $f['q'], 'acceptedAnswer' => ['@type' => 'Answer', 'text' => $f['a']]];
            }, $faqs),
        ],
    ];

    return '<script type="application/ld+json">'
        . json_encode(['@context' => 'https://schema.org', '@graph' => $graph], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG)
        . '</script>';
}

// Prints every section with all uses of its keyword (source + destination) in bold.
function render_route_seo_sections(array $dest) {
    foreach (route_seo_sections($dest) as $section) {
        $heading = htmlspecialchars($section[0]);
        $pattern = '/' . preg_quote($heading, '/') . '/i';
        echo '<h2>' . $heading . '</h2>' . "\n";
        foreach ($section[1] as $paragraph) {
            $body = preg_replace($pattern, '<strong>$0</strong>', htmlspecialchars($paragraph));
            $body = str_replace(ROUTE_SITE_URL, '<a href="' . ROUTE_SITE_URL . '">' . ROUTE_SITE_URL . '</a>', $body);
            echo '<p>' . $body . '</p>' . "\n";
        }
    }
}
