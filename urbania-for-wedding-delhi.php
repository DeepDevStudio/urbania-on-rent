<?php
require_once __DIR__ . '/includes/seo-blocks.php';

$from = fleet_min_price($fleet);

$lp = [
    'title'       => 'Urbania for Wedding in Delhi NCR | Luxury Maharaja Baraat & Guest Transfers',
    'description' => 'Book Luxury Maharaja and Normal Force Urbania for weddings in Delhi NCR — baraat, bridal family & guest transfers from ₹' . $from . '/km with uniformed chauffeurs. Decoration on request. Call 7290885949.',
    'keywords'    => 'urbania for wedding delhi, luxury urbania for wedding delhi, wedding van on rent delhi, baraat urbania delhi, premium force urbania on rent delhi for wedding, wedding guest transport delhi ncr',
    'hero_img'    => 'images/urbania-1.webp',
    'crumbs'      => [['Services', 'services.php'], ['Urbania for Wedding', null]],
    'eyebrow'     => 'Weddings · Delhi NCR',
    'eyebrow_icon'=> 'fa-ring',
    'h1'          => 'Urbania for <em>Weddings</em> in Delhi NCR',
    'lead'        => 'Luxury Maharaja Urbania for the bridal family and VIP guests, 16 seater Normal Urbania for guest shuttles — with uniformed chauffeurs and decoration on request.',
    'wa_text'     => 'Hi, I want to book Urbania for a wedding in Delhi NCR.',
    'fleet_h2'    => 'Wedding Urbania options',
    'rate_h2'     => 'Wedding Urbania price in Delhi NCR',
    'content_h2'  => 'How couples use Urbania at Delhi weddings',
    'content'     => [
        'A wedding in Delhi NCR usually means moving guests between hotels, the venue and the airport several times a day. One Urbania replaces three or four cars, keeps families together, and arrives with a chauffeur who knows the venue.',
        'Most families book the <a href="force-urbania-luxury-maharaja-on-rent-delhi.php">Luxury Maharaja Urbania</a> for the baraat, the bridal party and elderly relatives — the <a href="9-seater-urbania-maharaja-delhi.php">9 seater</a> for a private, lounge-like cabin or the <a href="12-seater-urbania-luxury-delhi.php">12 seater</a> for more seats. For hotel-to-venue guest shuttles, the <a href="16-seater-urbania-normal-delhi.php">16 seater Normal Urbania</a> moves the most people per trip.',
        'We cover farmhouses and venues across Chhattarpur, Gurgaon, Noida and Greater Noida, as well as destination weddings in <a href="delhi-to-jaipur-urbania.php">Jaipur</a>, <a href="delhi-to-udaipur-urbania.php">Udaipur</a> and <a href="delhi-to-rishikesh-urbania.php">Rishikesh</a>. Book 2–3 weeks ahead in the wedding season.',
    ],
    'best_for_h3' => 'Wedding services',
    'best_for'    => [
        'Baraat and bridal family transfers',
        'Hotel-to-venue guest shuttles',
        'IGI Airport pickups for out-of-town guests',
        'Destination weddings outside Delhi',
        'Decoration on request',
    ],
    'faq_h2'      => 'Wedding Urbania questions',
    'faqs'        => [
        ['q' => 'Which Urbania is best for a wedding?',
         'a' => 'The Luxury Maharaja Urbania (9 or 12 seater) for the bridal family and VIP guests, and the 16 seater Normal Urbania for guest shuttles.'],
        ['q' => 'Can you decorate the Urbania for a wedding?',
         'a' => 'Yes, decoration can be arranged on request. Tell us your theme when you book.'],
        ['q' => 'How early should I book Urbania for a wedding?',
         'a' => 'We recommend 2–3 weeks ahead for weddings, especially in the November–February season.'],
    ],
    'schema_name' => 'Urbania for Wedding in Delhi NCR',
    'cta_h2'      => 'Planning a wedding? <em>Let\'s plan the transport.</em>',
    'vehicles'    => $fleet,
];

require __DIR__ . '/includes/landing-page.php';
