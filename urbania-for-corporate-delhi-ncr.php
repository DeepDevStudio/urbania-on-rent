<?php
require_once __DIR__ . '/includes/seo-blocks.php';

$from = fleet_min_price($fleet);

$lp = [
    'title'       => 'Urbania for Corporate Travel in Delhi NCR | GST Invoice & Monthly Billing',
    'description' => 'Force Urbania for corporate tours in Delhi NCR — offsites, client visits, airport transfers & employee shuttles in Gurgaon, Noida & Delhi from ₹' . $from . '/km. GST invoice & monthly billing. Call 7290885949.',
    'keywords'    => 'urbania for corporate delhi ncr, luxury urbania for corporate tour delhi, corporate van on rent gurgaon, employee shuttle urbania noida, offsite transport delhi, urbania corporate billing',
    'hero_img'    => 'images/urbania-4.webp',
    'crumbs'      => [['Services', 'services.php'], ['Urbania for Corporate', null]],
    'eyebrow'     => 'Corporate · Delhi NCR',
    'eyebrow_icon'=> 'fa-briefcase',
    'h1'          => 'Urbania for <em>Corporate Travel</em> in Delhi NCR',
    'lead'        => 'Reliable Force Urbania for teams and client visits across Delhi, Gurgaon and Noida — from ₹' . $from . ' per km, with GST invoicing and monthly billing.',
    'wa_text'     => 'Hi, I want a corporate Urbania quote for Delhi NCR.',
    'fleet_h2'    => 'Corporate Urbania options',
    'rate_h2'     => 'Corporate Urbania price in Delhi NCR',
    'content_h2'  => 'Group transport that runs on time',
    'content'     => [
        'Companies across <a href="urbania-on-rent-gurgaon.php">Gurgaon</a>, <a href="urbania-on-rent-noida.php">Noida</a> and Delhi use our Urbanias for team offsites, client site visits, conference transfers and employee shuttles. One van carries the whole team, so everyone arrives together and on time.',
        'For senior management and visiting clients, the <a href="force-urbania-luxury-maharaja-on-rent-delhi.php">Luxury Maharaja Urbania</a> gives a quiet cabin with WiFi and reclining seats — the 9 seater adds a privacy partition for working on the move. For team outings to <a href="delhi-to-rishikesh-urbania.php">Rishikesh</a>, <a href="delhi-to-jaipur-urbania.php">Jaipur</a> or <a href="delhi-to-mussoorie-urbania.php">Mussoorie</a>, the 16 seater <a href="force-urbania-normal-on-rent-delhi.php">Normal Urbania</a> keeps the per-head cost low.',
        'Every booking includes a verified, uniformed chauffeur, GPS tracking and comprehensive insurance. We provide GST invoices and can set up monthly billing for repeat bookings.',
    ],
    'best_for_h3' => 'Corporate services',
    'best_for'    => [
        'Team offsites and outbound trips',
        'Client and investor site visits',
        'IGI Airport pickups for visiting executives',
        'Conference and event transfers',
        'Employee shuttles with monthly billing',
    ],
    'faq_h2'      => 'Corporate Urbania questions',
    'faqs'        => [
        ['q' => 'Do you provide GST invoices for corporate bookings?',
         'a' => 'Yes. Every corporate booking gets a GST invoice, and we offer monthly billing for repeat bookings.'],
        ['q' => 'Which Urbania is best for client visits?',
         'a' => 'The Luxury Maharaja Urbania — the 9 seater has a privacy partition, Smart TV and premium WiFi; the 12 seater has reclining captain seats for larger delegations.'],
        ['q' => 'Do you serve offices in Gurgaon and Noida?',
         'a' => 'Yes. We pick up from offices across Gurgaon, Noida, Greater Noida, Delhi, Ghaziabad and Faridabad.'],
    ],
    'schema_name' => 'Urbania for Corporate Travel in Delhi NCR',
    'cta_h2'      => 'Need transport for your team? <em>Get a corporate quote.</em>',
    'vehicles'    => $fleet,
];

require __DIR__ . '/includes/landing-page.php';
