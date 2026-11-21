<?php
require_once __DIR__ . '/includes/seo-blocks.php';

$vehicles = fleet_by_type('normal');
$from = fleet_min_price($vehicles);

$lp = [
    'title'       => 'Force Urbania Normal on Rent in Delhi NCR | 16 Seater 2x1 @ ₹' . $from . '/km',
    'description' => 'Book Force Urbania Normal on rent in Delhi NCR — 16 seater with 2x1 pushback seats from ₹' . $from . '/km, fuel & toll included. Best value Urbania for group tours, Char Dham & hill trips. Call 7290885949.',
    'keywords'    => 'force urbania normal on rent delhi, normal force urbania on rent delhi, 16 seater urbania normal delhi, urbania 2x1 seater delhi, budget force urbania on rent delhi, cheap urbania on rent gurgaon, urbania on rent noida, urbania traveller per km delhi',
    'hero_img'    => 'images/urbania-5.webp',
    'crumbs'      => [['Our Fleet', 'fleet.php'], ['Normal Urbania', null]],
    'eyebrow'     => 'Normal Force Urbania · Delhi NCR',
    'h1'          => 'Force Urbania <em>Normal</em> on Rent in Delhi',
    'lead'        => 'The best-value Force Urbania for large groups: 2x1 pushback seats, full AC and a verified chauffeur, from ₹' . $from . ' per km with fuel, toll and state tax included. Doorstep pickup in Delhi, Gurgaon, Noida, Ghaziabad &amp; Faridabad.',
    'wa_text'     => 'Hi, I want a quote for a Normal Force Urbania (16 seater) in Delhi NCR.',
    'fleet_h2'    => 'Normal Urbania models available in Delhi NCR',
    'rate_h2'     => 'Normal Urbania on rent price in Delhi NCR',
    'content_h2'  => 'Why book a Normal Force Urbania in Delhi?',
    'content'     => [
        'The <strong>Force Urbania Normal</strong> is our 16 seater with 2x1 pushback seats and a walk-through aisle. Every passenger gets a comfortable pushback seat, a charging point and the same smooth, quiet ride that makes the Urbania better than a regular tempo traveller — at a lower per-km rate than our <a href="force-urbania-luxury-maharaja-on-rent-delhi.php">Luxury Maharaja Urbania</a>.',
        'With 16 seats in one van, the per-person cost on a long trip is the lowest in our fleet. That is why groups pick the Normal Urbania for <a href="char-dham-urbania-package.php">Char Dham Yatra</a>, <a href="delhi-to-manali-urbania.php">Delhi to Manali</a>, <a href="delhi-to-shimla-urbania.php">Shimla</a>, <a href="delhi-to-haridwar-urbania.php">Haridwar</a> and <a href="delhi-to-jaipur-urbania.php">Jaipur</a>, as well as office outings and school or college trips.',
        'The fare is simple: ₹' . $from . ' per km, with fuel, toll tax, state tax and driver allowance included. Outstation trips carry a minimum of 250 km per day. Parking, GST and night charges (10 PM – 6 AM) are extra, and we share a written quote before you pay anything.',
        'We pick you up from your doorstep anywhere in Delhi NCR — <a href="urbania-on-rent-gurgaon.php">Gurgaon</a>, <a href="urbania-on-rent-noida.php">Noida</a>, Greater Noida, Ghaziabad and Faridabad included — and every Urbania is deep-cleaned before each trip.',
    ],
    'best_for_h3' => 'Normal Urbania is best for',
    'best_for'    => [
        'Group tours of 12–16 people on a budget',
        'Char Dham, Vaishno Devi and other pilgrimage trips with senior citizens',
        'Hill trips to Manali, Shimla, Mussoorie and Nainital',
        'Corporate delegations, office offsites and college trips',
    ],
    'faq_h2'      => 'Normal Urbania questions',
    'faqs'        => [
        ['q' => 'What is the price of a Normal Force Urbania on rent in Delhi?',
         'a' => 'The 16 seater Normal Urbania starts at ₹' . $from . '/km in Delhi NCR. Fuel, toll tax, state tax and driver allowance are included; parking, GST and night charges are extra. Outstation trips have a 250 km/day minimum.'],
        ['q' => 'What is the difference between Normal and Luxury Maharaja Urbania?',
         'a' => 'The Normal Urbania is a 16 seater with 2x1 pushback seats, built for value on large group trips. The Luxury Maharaja Urbania (9 and 12 seater) adds extra-wide Maharaja or captain seats, Smart TV, premium WiFi, mood lighting and designer interiors for weddings, corporate guests and VIP travel.'],
        ['q' => 'Is the 16 seater Normal Urbania good for senior citizens?',
         'a' => 'Yes. The 2x1 layout and walk-through aisle make boarding easy, which makes it the most comfortable choice for elderly travellers on long pilgrimages.'],
        ['q' => 'Do you provide Normal Urbania in Gurgaon and Noida?',
         'a' => 'Yes. We provide doorstep pickup across Delhi, Gurgaon, Noida, Greater Noida, Ghaziabad and Faridabad for local and outstation trips.'],
    ],
    'schema_name' => 'Force Urbania Normal on Rent in Delhi NCR',
    'cta_h2'      => 'Book a Normal Urbania <em>for your group</em>',
    'vehicles'    => $vehicles,
];

require __DIR__ . '/includes/landing-page.php';
