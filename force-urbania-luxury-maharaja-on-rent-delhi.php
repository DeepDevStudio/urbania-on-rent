<?php
require_once __DIR__ . '/includes/seo-blocks.php';

$vehicles = fleet_by_type('luxury');
$from = fleet_min_price($vehicles);

$lp = [
    'title'       => 'Luxury Maharaja Force Urbania on Rent Delhi NCR | 9 & 12 Seater',
    'description' => 'Hire Luxury Maharaja Force Urbania in Delhi NCR — 9 & 12 seater with extra-wide recliner seats, Smart TV, WiFi & mood lighting from ₹' . $from . '/km. For weddings, corporate & VIP travel. Call 7290885949.',
    'keywords'    => 'luxury force urbania on rent delhi, maharaja force urbania on rent delhi, premium urbania delhi, 9 seater luxury urbania maharaja delhi, 12 seater maharaja urbania delhi, urbania with recliner seats delhi, luxury urbania for wedding delhi, luxury urbania corporate delhi ncr',
    'hero_img'    => 'images/urbania-1.webp',
    'crumbs'      => [['Our Fleet', 'fleet.php'], ['Luxury Maharaja Urbania', null]],
    'eyebrow'     => 'Luxury Maharaja Force Urbania · Delhi NCR',
    'eyebrow_icon'=> 'fa-crown',
    'h1'          => 'Luxury <em>Maharaja Urbania</em> on Rent in Delhi',
    'lead'        => 'Our premium Force Urbania with extra-wide Maharaja seats, reclining captain chairs, Smart TV, WiFi and designer interiors — from ₹' . $from . ' per km with a verified chauffeur. For weddings, corporate guests and VIP family travel across Delhi NCR.',
    'wa_text'     => 'Hi, I want a quote for a Luxury Maharaja Force Urbania in Delhi NCR.',
    'fleet_h2'    => 'Luxury Maharaja Urbania models in Delhi NCR',
    'rate_h2'     => 'Luxury Maharaja Urbania on rent price in Delhi NCR',
    'content_h2'  => 'What makes the Maharaja Urbania a luxury ride?',
    'content'     => [
        'The <strong>Luxury Maharaja Urbania</strong> is a Force Urbania rebuilt inside for comfort first. Instead of rows of standard seats you get fewer, larger seats: extra-wide Maharaja seats in the <a href="9-seater-urbania-maharaja-delhi.php">9 seater</a>, and reclining captain seats with armrests in the <a href="12-seater-urbania-luxury-delhi.php">12 seater</a>.',
        'The cabin is finished with designer interiors, mood lighting, a Smart TV and premium WiFi, and the 9 seater adds a privacy partition and mini bar. It is the van we send for baraat and bridal family transfers, airport pickups for corporate guests, and family trips where the journey matters as much as the destination.',
        'Pricing starts at ₹' . $from . ' per km, with fuel, toll tax, state tax and driver allowance included. Parking, GST and night charges are extra, and outstation trips have a 250 km per day minimum. If you need the most seats for the money instead, see our <a href="force-urbania-normal-on-rent-delhi.php">Normal Urbania</a>.',
        'Doorstep pickup is free anywhere in Delhi NCR, including <a href="urbania-on-rent-gurgaon.php">Gurgaon</a>, <a href="urbania-on-rent-noida.php">Noida</a>, Ghaziabad and Faridabad. Popular luxury routes include <a href="delhi-to-jaipur-urbania.php">Delhi to Jaipur</a>, <a href="delhi-to-udaipur-urbania.php">Udaipur</a>, <a href="delhi-to-agra-urbania.php">Agra</a> and <a href="delhi-to-rishikesh-urbania.php">Rishikesh</a>.',
    ],
    'best_for_h3' => 'Luxury Maharaja Urbania is best for',
    'best_for'    => [
        '<a href="urbania-for-wedding-delhi.php">Weddings</a> — baraat, bridal family and VIP guest transfers',
        '<a href="urbania-for-corporate-delhi-ncr.php">Corporate</a> client visits, executive offsites and airport pickups',
        'Premium family tours and honeymoon road trips',
        'Destination weddings, film crews and premium group events',
    ],
    'faq_h2'      => 'Luxury Maharaja Urbania questions',
    'faqs'        => [
        ['q' => 'What is the price of a Luxury Maharaja Force Urbania on rent in Delhi?',
         'a' => 'The 9 seater and 12 seater Luxury Maharaja Urbania start at ₹' . $from . '/km in Delhi NCR. Fuel, toll tax, state tax and driver allowance are included; parking, GST and night charges are extra.'],
        ['q' => 'What features does the Maharaja Urbania have?',
         'a' => 'Extra-wide Maharaja seats or reclining captain seats with armrests, Smart TV, premium WiFi and entertainment, mood lighting and designer interiors. The 9 seater also has a privacy partition and mini bar.'],
        ['q' => 'Can I book a Luxury Urbania for a wedding in Delhi?',
         'a' => 'Yes. The Maharaja Urbania is our most-booked van for baraat, bridal family and guest transfers in Delhi, Gurgaon and Noida, and decoration can be arranged on request.'],
        ['q' => 'Should I choose 9 seater or 12 seater Maharaja Urbania?',
         'a' => 'Choose the 9 seater for the most space per person and a private, lounge-like cabin. Choose the 12 seater when you need more seats but still want reclining captain seats and a premium interior.'],
    ],
    'schema_name' => 'Luxury Maharaja Force Urbania on Rent in Delhi NCR',
    'cta_h2'      => 'Travel like royalty in a <em>Maharaja Urbania</em>',
    'vehicles'    => $vehicles,
];

require __DIR__ . '/includes/landing-page.php';
