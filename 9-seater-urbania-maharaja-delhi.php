<?php
require_once __DIR__ . '/includes/seo-blocks.php';

$v = fleet_by_slug('9-seater');

$lp = [
    'title'       => '9 Seater Urbania Maharaja on Rent in Delhi NCR | ₹' . $v['price'] . '/km',
    'description' => 'Book the 9 seater Luxury Maharaja Force Urbania in Delhi NCR at ₹' . $v['price'] . '/km — extra-wide seats, privacy partition, Smart TV, WiFi, mini bar & mood lighting. VIP, honeymoon & premium family trips. Call 7290885949.',
    'keywords'    => '9 seater force urbania on rent delhi, 9 seater luxury urbania maharaja delhi, 9 seater urbania price delhi, maharaja urbania 9 seater, luxury van 9 seater delhi ncr, urbania with privacy partition delhi',
    'hero_img'    => $v['img'],
    'crumbs'      => [['Luxury Maharaja Urbania', 'force-urbania-luxury-maharaja-on-rent-delhi.php'], ['9 Seater Urbania Maharaja', null]],
    'eyebrow'     => 'Luxury Maharaja · 9 Seater',
    'eyebrow_icon'=> 'fa-crown',
    'h1'          => '9 Seater Urbania <em>Maharaja</em> on Rent in Delhi',
    'lead'        => 'Nine extra-wide Maharaja seats, a privacy partition, Smart TV, premium WiFi, mini bar and mood lighting — at ₹' . $v['price'] . ' per km with a verified chauffeur and doorstep pickup across Delhi NCR.',
    'wa_text'     => 'Hi, I want a quote for the 9 Seater Urbania Maharaja in Delhi NCR.',
    'fleet_h2'    => '9 Seater Luxury Maharaja Urbania',
    'rate_h2'     => '9 Seater Urbania Maharaja price in Delhi',
    'content_h2'  => 'A private lounge on wheels',
    'content'     => [
        'The <strong>9 seater Urbania Maharaja</strong> is the top of our <a href="force-urbania-luxury-maharaja-on-rent-delhi.php">Luxury Maharaja</a> range. With only nine seats in a full-size Force Urbania, every passenger gets an extra-wide Maharaja seat and far more legroom than in any standard van.',
        'A privacy partition separates the cabin from the driver, so you can hold a meeting, rest or celebrate in private. The Smart TV, premium WiFi, mini bar and mood lighting make long drives to <a href="delhi-to-jaipur-urbania.php">Jaipur</a>, <a href="delhi-to-udaipur-urbania.php">Udaipur</a> or <a href="delhi-to-agra-urbania.php">Agra</a> feel short.',
        'The fare is ₹' . $v['price'] . ' per km with fuel, toll tax, state tax and driver allowance included; parking, GST and night charges are extra. Need a few more seats? See the <a href="12-seater-urbania-luxury-delhi.php">12 seater Luxury Urbania</a>.',
    ],
    'best_for_h3' => '9 seater Maharaja is best for',
    'best_for'    => array_map('trim', explode(',', $v['best'])),
    'faq_h2'      => '9 seater Urbania questions',
    'faqs'        => [
        ['q' => 'What is the 9 seater Urbania Maharaja rent per km in Delhi?',
         'a' => '₹' . $v['price'] . '/km, including fuel, toll tax, state tax and driver allowance. Parking, GST and night charges are extra; outstation trips have a 250 km/day minimum.'],
        ['q' => 'How many people can travel in the 9 seater Urbania?',
         'a' => 'Nine passengers plus the chauffeur, each in an extra-wide Maharaja seat.'],
        ['q' => 'Does the 9 seater Urbania have a TV and WiFi?',
         'a' => 'Yes — a Smart TV, premium WiFi, mini bar, mood lighting and a privacy partition between the cabin and driver.'],
    ],
    'schema_name' => '9 Seater Urbania Maharaja on Rent in Delhi NCR',
    'cta_h2'      => 'Book the <em>9 seater Maharaja</em>',
    'vehicles'    => [$v],
];

require __DIR__ . '/includes/landing-page.php';
