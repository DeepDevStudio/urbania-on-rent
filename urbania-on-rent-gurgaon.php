<?php
require_once __DIR__ . '/includes/seo-blocks.php';

$from = fleet_min_price($fleet);

$lp = [
    'title'       => 'Urbania on Rent in Gurgaon | Normal & Luxury Maharaja from ₹' . $from . '/km',
    'description' => 'Force Urbania on rent in Gurgaon — 16 seater Normal and 9 & 12 seater Luxury Maharaja with driver from ₹' . $from . '/km. Doorstep pickup in Cyber City, Golf Course Road, Sohna Road & Manesar. Call 7290885949.',
    'keywords'    => 'urbania on rent gurgaon, urbania on rent in gurgaon, force urbania gurgaon, luxury urbania gurgaon, 12 seater urbania gurgaon, 16 seater urbania gurgaon, urbania hire gurugram, cheap urbania on rent gurgaon',
    'hero_img'    => 'images/urbania-rent.webp',
    'crumbs'      => [['Urbania on Rent Gurgaon', null]],
    'eyebrow'     => 'Gurgaon · Gurugram',
    'eyebrow_icon'=> 'fa-location-dot',
    'h1'          => 'Urbania on Rent <em>in Gurgaon</em>',
    'lead'        => 'Book a Force Urbania with driver anywhere in Gurgaon — Cyber City, Golf Course Road, Sohna Road, DLF Phases, Udyog Vihar and Manesar. 9, 12 &amp; 16 seater, from ₹' . $from . ' per km.',
    'wa_text'     => 'Hi, I want to book an Urbania in Gurgaon.',
    'fleet_h2'    => 'Urbania available in Gurgaon',
    'rate_h2'     => 'Urbania on rent price in Gurgaon',
    'content_h2'  => 'Force Urbania hire in Gurgaon for offices, weddings and weekend trips',
    'content'     => [
        'Gurgaon is our busiest pickup zone after Delhi, and most bookings here are <a href="urbania-for-corporate-delhi-ncr.php">corporate</a>: client visits from IGI Airport, team offsites, and employee shuttles between Cyber City, Golf Course Road and Manesar. We provide GST invoices and monthly billing for companies.',
        'For weddings at the farmhouses and hotels on Sohna Road and MG Road, the <a href="force-urbania-luxury-maharaja-on-rent-delhi.php">Luxury Maharaja Urbania</a> is the usual choice. For weekend getaways from Gurgaon to <a href="delhi-to-jaipur-urbania.php">Jaipur</a>, <a href="delhi-to-rishikesh-urbania.php">Rishikesh</a> or <a href="delhi-to-shimla-urbania.php">Shimla</a>, big groups pick the 16 seater <a href="force-urbania-normal-on-rent-delhi.php">Normal Urbania</a>.',
        'Rates are the same as Delhi — the Gurgaon pickup is free. Fuel, toll tax, state tax and driver allowance are included; parking, GST and night charges are extra. Outstation trips from Gurgaon follow the 250 km/day minimum. See all <a href="destinations.php?origin=gurgaon">routes from Gurgaon</a>.',
    ],
    'faq_h2'      => 'Urbania in Gurgaon — questions',
    'faqs'        => [
        ['q' => 'What is the Urbania on rent price in Gurgaon?',
         'a' => 'The 16 seater Normal Urbania starts at ₹' . fleet_min_price(fleet_by_type('normal')) . '/km and the 9 & 12 seater Luxury Maharaja Urbania at ₹' . fleet_min_price(fleet_by_type('luxury')) . '/km — the same rates as Delhi, with free pickup in Gurgaon.'],
        ['q' => 'Which areas of Gurgaon do you cover?',
         'a' => 'All of Gurgaon, including Cyber City, Golf Course Road, Sohna Road, MG Road, DLF Phases 1–5, Udyog Vihar and Manesar.'],
        ['q' => 'Do you offer corporate billing in Gurgaon?',
         'a' => 'Yes. We provide GST invoices and monthly billing for corporate shuttles, offsites and client transfers.'],
    ],
    'schema_name' => 'Force Urbania on Rent in Gurgaon',
    'cta_h2'      => 'Book an Urbania <em>in Gurgaon</em>',
    'vehicles'    => $fleet,
];

require __DIR__ . '/includes/landing-page.php';
