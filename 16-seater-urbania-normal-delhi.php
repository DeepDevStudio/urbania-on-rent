<?php
require_once __DIR__ . '/includes/seo-blocks.php';

$v = fleet_by_slug('16-seater');

$lp = [
    'title'       => '16 Seater Force Urbania on Rent in Delhi NCR | Normal 2x1 @ ₹' . $v['price'] . '/km',
    'description' => 'Book the 16 seater Force Urbania Normal in Delhi NCR at ₹' . $v['price'] . '/km — 2x1 pushback seats, walk-through aisle, entertainment & charging points. Ideal for big group tours & pilgrimages. Call 7290885949.',
    'keywords'    => '16 seater force urbania on rent delhi, 16 seater urbania normal delhi, 16 seater urbania price delhi, 16 seater urbania per km, 2x1 urbania delhi, 16 seater urbania gurgaon noida',
    'hero_img'    => $v['img'],
    'crumbs'      => [['Normal Urbania', 'force-urbania-normal-on-rent-delhi.php'], ['16 Seater Urbania', null]],
    'eyebrow'     => 'Normal Urbania · 16 Seater',
    'h1'          => '16 Seater Urbania <em>Normal</em> on Rent in Delhi',
    'lead'        => 'Sixteen 2x1 pushback seats, a walk-through aisle and a charging point at every seat — ₹' . $v['price'] . ' per km with a verified chauffeur and free doorstep pickup across Delhi NCR.',
    'wa_text'     => 'Hi, I want a quote for the 16 Seater Normal Urbania in Delhi NCR.',
    'fleet_h2'    => '16 Seater Normal Urbania',
    'rate_h2'     => '16 Seater Urbania price in Delhi',
    'content_h2'  => 'The biggest Urbania, the lowest cost per person',
    'content'     => [
        'The <strong>16 seater Urbania</strong> is the largest van in our fleet and the core of our <a href="force-urbania-normal-on-rent-delhi.php">Normal Urbania</a> range. Its 2x1 layout gives every passenger a comfortable pushback seat, and the walk-through aisle lets anyone get in and out without disturbing the row.',
        'Because sixteen people share one fare, it is the cheapest way per person to take a big group from Delhi to the hills or on a pilgrimage — <a href="char-dham-urbania-package.php">Char Dham</a>, <a href="delhi-to-kedarnath-urbania.php">Kedarnath</a>, <a href="delhi-to-manali-urbania.php">Manali</a>, <a href="delhi-to-amritsar-urbania.php">Amritsar</a> and more.',
        'The fare is ₹' . $v['price'] . ' per km with fuel, toll tax, state tax and driver allowance included; parking, GST and night charges are extra, and outstation trips have a 250 km/day minimum. Want a premium cabin instead? See the <a href="12-seater-urbania-luxury-delhi.php">12 seater Luxury Urbania</a>.',
    ],
    'best_for_h3' => '16 seater Urbania is best for',
    'best_for'    => array_map('trim', explode(',', $v['best'])),
    'faq_h2'      => '16 seater Urbania questions',
    'faqs'        => [
        ['q' => 'What is the 16 seater Urbania rent per km in Delhi?',
         'a' => '₹' . $v['price'] . '/km, including fuel, toll tax, state tax and driver allowance. Parking, GST and night charges are extra; outstation trips have a 250 km/day minimum.'],
        ['q' => 'Is the 16 seater Urbania a normal or luxury model?',
         'a' => 'It is our Normal Urbania: 2x1 pushback seats, an entertainment system and charging points, priced lower than the 9 and 12 seater Luxury Maharaja models.'],
        ['q' => 'What if my group is bigger than 16?',
         'a' => 'We can send two or more Urbanias travelling together, and mix Normal and Luxury Maharaja vans if needed.'],
    ],
    'schema_name' => '16 Seater Force Urbania Normal on Rent in Delhi NCR',
    'cta_h2'      => 'Book the <em>16 seater Urbania</em>',
    'vehicles'    => [$v],
];

require __DIR__ . '/includes/landing-page.php';
