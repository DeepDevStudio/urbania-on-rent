<?php
require_once __DIR__ . '/includes/seo-blocks.php';

$from = fleet_min_price($fleet);

$lp = [
    'title'       => 'Urbania on Rent in Noida & Greater Noida | from ₹' . $from . '/km',
    'description' => 'Force Urbania on rent in Noida and Greater Noida — 16 seater Normal and 9 & 12 seater Luxury Maharaja with driver from ₹' . $from . '/km. Pickup from Sector 18, Sector 62, Film City & Noida Extension. Call 7290885949.',
    'keywords'    => 'urbania on rent noida, urbania on rent in noida, urbania on rent greater noida, force urbania noida, luxury urbania noida, 12 seater urbania noida, 16 seater urbania noida, cheap urbania on rent noida',
    'hero_img'    => 'images/urbania-rent.webp',
    'crumbs'      => [['Urbania on Rent Noida', null]],
    'eyebrow'     => 'Noida · Greater Noida',
    'eyebrow_icon'=> 'fa-location-dot',
    'h1'          => 'Urbania on Rent <em>in Noida</em>',
    'lead'        => 'Force Urbania with driver from any sector in Noida, Noida Extension and Greater Noida. 9, 12 &amp; 16 seater, from ₹' . $from . ' per km, with free doorstep pickup.',
    'wa_text'     => 'Hi, I want to book an Urbania in Noida.',
    'fleet_h2'    => 'Urbania available in Noida',
    'rate_h2'     => 'Urbania on rent price in Noida',
    'content_h2'  => 'Urbania hire in Noida for families, offices and the Yamuna Expressway',
    'content'     => [
        'Noida and Greater Noida sit right on the Yamuna Expressway, which makes them the natural starting point for <a href="delhi-to-agra-urbania.php">Agra</a>, Mathura–Vrindavan and the Golden Triangle. Families heading out on those trips usually book the 16 seater <a href="force-urbania-normal-on-rent-delhi.php">Normal Urbania</a> for the lowest per-person cost.',
        'IT offices in Sector 62, Sector 125 and Film City use our Urbanias for team outings and client pickups, and wedding venues across Greater Noida book the <a href="force-urbania-luxury-maharaja-on-rent-delhi.php">Luxury Maharaja Urbania</a> for bridal families and VIP guests.',
        'Rates are the same as Delhi, with free pickup anywhere in Noida. Fuel, toll tax, state tax and driver allowance are included; parking, GST and night charges are extra. See all <a href="destinations.php?origin=noida">routes from Noida</a>.',
    ],
    'faq_h2'      => 'Urbania in Noida — questions',
    'faqs'        => [
        ['q' => 'What is the Urbania on rent price in Noida?',
         'a' => 'The 16 seater Normal Urbania starts at ₹' . fleet_min_price(fleet_by_type('normal')) . '/km and the 9 & 12 seater Luxury Maharaja Urbania at ₹' . fleet_min_price(fleet_by_type('luxury')) . '/km — the same rates as Delhi, with free pickup in Noida.'],
        ['q' => 'Do you pick up from Greater Noida and Noida Extension?',
         'a' => 'Yes. We cover all Noida sectors, Noida Extension, Greater Noida and Pari Chowk.'],
        ['q' => 'Can I book a Noida to Agra Urbania trip?',
         'a' => 'Yes. Noida to Agra via the Yamuna Expressway is one of our most popular routes; share your dates for a written quote.'],
    ],
    'schema_name' => 'Force Urbania on Rent in Noida',
    'cta_h2'      => 'Book an Urbania <em>in Noida</em>',
    'vehicles'    => $fleet,
];

require __DIR__ . '/includes/landing-page.php';
