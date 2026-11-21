<?php
require_once __DIR__ . '/includes/seo-blocks.php';

$v = fleet_by_slug('12-seater');

$lp = [
    'title'       => '12 Seater Luxury Maharaja Force Urbania on Rent Delhi | ₹' . $v['price'] . '/km',
    'description' => 'Hire the 12 seater Luxury Maharaja Force Urbania in Delhi NCR at ₹' . $v['price'] . '/km — reclining captain seats with armrests, premium entertainment & designer interiors. Weddings, events & group tours. Call 7290885949.',
    'keywords'    => '12 seater force urbania on rent delhi, 12 seater luxury urbania delhi, 12 seater maharaja urbania delhi, 12 seater urbania price per km delhi, urbania traveller 12 seater rent delhi, 12 seater urbania for wedding delhi',
    'hero_img'    => $v['img'],
    'crumbs'      => [['Luxury Maharaja Urbania', 'force-urbania-luxury-maharaja-on-rent-delhi.php'], ['12 Seater Luxury Urbania', null]],
    'eyebrow'     => 'Luxury Maharaja · 12 Seater',
    'eyebrow_icon'=> 'fa-crown',
    'h1'          => '12 Seater <em>Luxury Urbania</em> on Rent in Delhi',
    'lead'        => 'Reclining captain seats with armrests, premium entertainment and designer interiors for up to 12 passengers — ₹' . $v['price'] . ' per km with a verified chauffeur and free doorstep pickup across Delhi NCR.',
    'wa_text'     => 'Hi, I want a quote for the 12 Seater Luxury Maharaja Urbania in Delhi NCR.',
    'fleet_h2'    => '12 Seater Luxury Maharaja Urbania',
    'rate_h2'     => '12 Seater Luxury Urbania price in Delhi',
    'content_h2'  => 'Luxury for the whole group',
    'content'     => [
        'The <strong>12 seater Luxury Maharaja Urbania</strong> balances space and seat count. Twelve reclining captain seats with armrests mean nobody is squeezed onto a bench, while the custom designer interior and premium entertainment system keep the whole group comfortable on long drives.',
        'It is the van most often booked for <a href="urbania-for-wedding-delhi.php">wedding guest transfers</a>, film crews, destination weddings and premium group events — and for family trips to <a href="delhi-to-rishikesh-urbania.php">Rishikesh</a>, <a href="delhi-to-mussoorie-urbania.php">Mussoorie</a> and <a href="delhi-to-jaipur-urbania.php">Jaipur</a>.',
        'The fare is ₹' . $v['price'] . ' per km with fuel, toll tax, state tax and driver allowance included; parking, GST and night charges are extra. For more space per person choose the <a href="9-seater-urbania-maharaja-delhi.php">9 seater Maharaja</a>; for 16 seats at a lower rate choose the <a href="16-seater-urbania-normal-delhi.php">16 seater Normal Urbania</a>.',
    ],
    'best_for_h3' => '12 seater Luxury Urbania is best for',
    'best_for'    => array_map('trim', explode(',', $v['best'])),
    'faq_h2'      => '12 seater Urbania questions',
    'faqs'        => [
        ['q' => 'What is the 12 seater Luxury Urbania rent per km in Delhi?',
         'a' => '₹' . $v['price'] . '/km, including fuel, toll tax, state tax and driver allowance. Parking, GST and night charges are extra; outstation trips have a 250 km/day minimum.'],
        ['q' => 'What type of seats does the 12 seater Urbania have?',
         'a' => 'Reclining captain seats with armrests in a custom Maharaja interior.'],
        ['q' => 'Is the 12 seater Urbania available for weddings in Gurgaon and Noida?',
         'a' => 'Yes. We serve all of Delhi NCR — Delhi, Gurgaon, Noida, Greater Noida, Ghaziabad and Faridabad — with doorstep pickup.'],
    ],
    'schema_name' => '12 Seater Luxury Maharaja Force Urbania on Rent in Delhi NCR',
    'cta_h2'      => 'Book the <em>12 seater Luxury Urbania</em>',
    'vehicles'    => [$v],
];

require __DIR__ . '/includes/landing-page.php';
