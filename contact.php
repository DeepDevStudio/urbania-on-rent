<?php
require __DIR__ . '/includes/site-data.php';

// Form handling runs before any output so the WhatsApp redirect header can be sent.
$error_messages = [];

function clean_input($key) {
    return isset($_POST[$key]) ? trim(strip_tags((string) $_POST[$key])) : '';
}
function old($key) {
    if (isset($_POST[$key])) {
        return htmlspecialchars((string) $_POST[$key]);
    }
    if (isset($_GET[$key])) {
        return htmlspecialchars((string) $_GET[$key]);
    }
    return '';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['contact_submit'])) {
    if (!empty($_POST['honeypot'])) {
        header('Location: contact.php');
        exit;
    }

    $name         = clean_input('name');
    $email        = clean_input('email');
    $phone        = clean_input('phone');
    $service_type = clean_input('service_type');
    $vehicle      = clean_input('vehicle');
    $pickup       = clean_input('pickup');
    $destination  = clean_input('destination');
    $travel_date  = clean_input('travel_date');
    $message      = clean_input('message');

    if ($name === '') {
        $error_messages[] = 'Please enter your name.';
    }
    if ($phone === '' || !preg_match('/^[0-9+\-\s]{8,15}$/', $phone)) {
        $error_messages[] = 'Please enter a valid phone number.';
    }
    if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_messages[] = 'Please enter a valid email address.';
    }
    if ($travel_date !== '' && !preg_match('/^\d{4}-\d{2}-\d{2}$/', $travel_date)) {
        $error_messages[] = 'Invalid travel date.';
    }

    if (empty($error_messages)) {
        $lines = [
            'New Booking Inquiry - Urbania on Rent Delhi',
            'Name: ' . $name,
            'Phone: ' . $phone,
            'Email: ' . ($email ?: 'Not provided'),
            'Service: ' . ($service_type ?: 'Not specified'),
            'Vehicle: ' . ($vehicle ?: 'Not specified'),
            'Pickup: ' . ($pickup ?: 'Not specified'),
            'Destination: ' . ($destination ?: 'Not specified'),
            'Travel Date: ' . ($travel_date ?: 'Not specified'),
        ];
        if ($message !== '') {
            $lines[] = 'Message: ' . $message;
        }
        header('Location: ' . wa_link(implode("\n", $lines)));
        exit;
    }
}

$page_title = 'Contact Us | Book Force Urbania on Rent in Delhi | Call 7290885949';
$page_description = 'Book Force Urbania on rent in Delhi NCR. Call or WhatsApp +91 7290885949 for an instant quote on 9, 12 & 16 seater luxury Urbania with driver. Open 24/7, based in Rohini, New Delhi.';
$page_keywords = 'urbania booking delhi, contact force urbania on rent delhi, urbania on rent near me, urbania hire rohini, urbania rental number delhi, book urbania with driver delhi, urbania on rent quote';
$extra_css = ['css/home.css', 'css/pages.css'];
$hide_breadcrumb = true;
include 'header.php';

$services = ['Outstation Tour', 'Local City Rental', 'Airport Transfer', 'Wedding Transfer', 'Corporate Travel', 'Char Dham / Pilgrimage', 'General Inquiry'];
$contact_faqs = [
    ['q' => 'How quickly will I get a quote?',
     'a' => 'Most WhatsApp and phone inquiries receive a written quote within minutes, 24 hours a day.'],
    ['q' => 'Where do you pick up from?',
     'a' => 'We offer doorstep pickup anywhere in Delhi, Gurgaon, Noida, Faridabad, Ghaziabad and from IGI Airport. Our office is in Rajeev Nagar, Begumpur, opposite Rohini Sector 22.'],
    ['q' => 'How do I confirm my Urbania booking?',
     'a' => 'Once you approve the quote, a small advance confirms the vehicle and chauffeur. The balance is paid at the end of the trip.'],
];
?>
<main class="hp">

    <section class="pg-hero pg-hero-center" style="padding-bottom:150px">
        <div class="container">
            <div class="pg-hero-copy">
                <?php render_crumbs([['Contact', null]]); ?>
                <span class="hp-eyebrow"><i class="fas fa-headset"></i> Open 24/7</span>
                <h1>Book your <em>Urbania on rent</em> in Delhi</h1>
                <p class="pg-lead">Call, WhatsApp or send the form — get an all-inclusive quote for your luxury Force Urbania within minutes.</p>
            </div>
        </div>
    </section>

    <section class="hp-section" style="padding-top:0">
        <div class="container">
            <div class="ct-actions">
                <a href="tel:<?php echo $site_phone_tel; ?>" class="ct-action"><i class="fas fa-phone"></i><small>Call us</small><strong><?php echo $site_phone_display; ?></strong><span>Fastest for urgent bookings</span></a>
                <a href="<?php echo wa_link('Hi, I want to book a luxury Urbania in Delhi.'); ?>" target="_blank" rel="noopener" class="ct-action is-wa"><i class="fab fa-whatsapp"></i><small>WhatsApp</small><strong>Chat instantly</strong><span>Quotes in minutes</span></a>
                <a href="mailto:<?php echo $site_email; ?>" class="ct-action"><i class="fas fa-envelope"></i><small>Email</small><strong><?php echo $site_email; ?></strong><span>For corporate &amp; bulk bookings</span></a>
                <a href="https://www.google.com/maps/search/?api=1&query=<?php echo rawurlencode('B-26 Rajeev Nagar Begumpur New Delhi 110086'); ?>" target="_blank" rel="noopener" class="ct-action"><i class="fas fa-location-dot"></i><small>Visit</small><strong>Rohini, New Delhi</strong><span>Opp. Rohini Sector 22</span></a>
            </div>

            <div class="ct-grid" id="booking" style="margin-top:64px">
                <form class="ct-form reveal" method="POST" action="contact.php#booking">
                    <h2>Request a free quote</h2>
                    <p>Fill in your trip details and we'll reply on WhatsApp with availability and pricing.</p>
                    <?php if (!empty($error_messages)): ?>
                        <div class="hp-alert" role="alert">
                            <?php foreach ($error_messages as $err): ?>
                                <span><i class="fas fa-circle-exclamation"></i> <?php echo htmlspecialchars($err); ?></span>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                    <div class="ct-form-grid">
                        <label class="hp-field"><span>Full name *</span><i class="fas fa-user"></i>
                            <input type="text" name="name" placeholder="Your name" required value="<?php echo old('name'); ?>"></label>
                        <label class="hp-field"><span>Phone *</span><i class="fas fa-phone"></i>
                            <input type="tel" name="phone" placeholder="+91 98xxx xxxxx" required value="<?php echo old('phone'); ?>"></label>
                        <label class="hp-field"><span>Email</span><i class="fas fa-envelope"></i>
                            <input type="email" name="email" placeholder="you@example.com" value="<?php echo old('email'); ?>"></label>
                        <label class="hp-field"><span>Travel date</span><i class="fas fa-calendar-days"></i>
                            <input type="date" name="travel_date" min="<?php echo date('Y-m-d'); ?>" value="<?php echo old('travel_date'); ?>"></label>
                        <label class="hp-field"><span>Pickup location</span><i class="fas fa-location-dot"></i>
                            <input type="text" name="pickup" placeholder="e.g. Dwarka, Delhi" value="<?php echo old('pickup'); ?>"></label>
                        <label class="hp-field"><span>Destination</span><i class="fas fa-flag-checkered"></i>
                            <input type="text" name="destination" placeholder="e.g. Manali" value="<?php echo old('destination'); ?>"></label>
                        <label class="hp-field"><span>Service</span><i class="fas fa-route"></i>
                            <select name="service_type">
                                <option value="">Select a service</option>
                                <?php foreach ($services as $sv): ?>
                                    <option <?php echo old('service_type') === $sv ? 'selected' : ''; ?>><?php echo $sv; ?></option>
                                <?php endforeach; ?>
                            </select></label>
                        <label class="hp-field"><span>Vehicle</span><i class="fas fa-van-shuttle"></i>
                            <select name="vehicle">
                                <option value="">Any Urbania</option>
                                <?php foreach ($fleet as $v): ?>
                                    <option <?php echo old('vehicle') === htmlspecialchars($v['name']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($v['name']); ?></option>
                                <?php endforeach; ?>
                            </select></label>
                        <label class="hp-field hp-field-area is-full"><span>Trip details</span><i class="fas fa-comment"></i>
                            <textarea name="message" placeholder="Number of passengers, return date, special requests..."><?php echo old('message'); ?></textarea></label>
                    </div>
                    <div class="hp-honeypot" aria-hidden="true"><input type="text" name="honeypot" tabindex="-1" autocomplete="off"></div>
                    <button type="submit" name="contact_submit" class="hp-btn hp-btn-gold"><i class="fab fa-whatsapp"></i> Send inquiry on WhatsApp</button>
                    <p class="ct-form-note"><i class="fas fa-lock"></i> Your details are only used to prepare your quote.</p>
                </form>

                <div class="ct-side">
                    <div class="ct-map reveal">
                        <iframe title="Urbania on Rent Delhi office location in Rohini, New Delhi" src="https://maps.google.com/maps?q=<?php echo rawurlencode('Rajeev Nagar Begumpur New Delhi 110086'); ?>&z=15&output=embed" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                    <div class="ct-box reveal">
                        <h3>Urbania on Rent Delhi</h3>
                        <ul>
                            <li><i class="fas fa-location-dot"></i><span><?php echo $site_address; ?></span></li>
                            <li><i class="fas fa-phone"></i><a href="tel:<?php echo $site_phone_tel; ?>"><?php echo $site_phone_display; ?></a></li>
                            <li><i class="fas fa-envelope"></i><a href="mailto:<?php echo $site_email; ?>"><?php echo $site_email; ?></a></li>
                            <li><i class="fas fa-clock"></i><span>Open 24 hours, 7 days a week</span></li>
                        </ul>
                        <div class="ct-social">
                            <a href="https://www.facebook.com/GetMeCabFB" target="_blank" rel="noopener" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                            <a href="https://www.instagram.com/urbania_onrent/" target="_blank" rel="noopener" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                            <a href="https://x.com/getmecab" target="_blank" rel="noopener" aria-label="X (Twitter)"><i class="fab fa-x-twitter"></i></a>
                            <a href="https://www.youtube.com/@getmecab9627" target="_blank" rel="noopener" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Service area -->
    <section class="hp-section hp-soft">
        <div class="container">
            <div class="hp-head reveal">
                <span class="hp-kicker">We Pick Up From</span>
                <h2>Urbania on rent near you</h2>
            </div>
            <div class="pg-areas reveal">
                <span><i class="fas fa-location-dot"></i> Delhi</span>
                <span><i class="fas fa-location-dot"></i> Gurgaon</span>
                <span><i class="fas fa-location-dot"></i> Noida</span>
                <span><i class="fas fa-location-dot"></i> Greater Noida</span>
                <span><i class="fas fa-location-dot"></i> Faridabad</span>
                <span><i class="fas fa-location-dot"></i> Ghaziabad</span>
                <span><i class="fas fa-plane"></i> IGI Airport</span>
            </div>
        </div>
    </section>

    <!-- FAQ -->
    <section class="hp-section">
        <div class="container hp-faq-wrap">
            <div class="hp-faq-intro reveal">
                <span class="hp-kicker">Booking FAQ</span>
                <h2>Before you book</h2>
                <p>Quick answers about quotes, pickup and confirmation.</p>
            </div>
            <div class="hp-faq">
                <?php foreach ($contact_faqs as $i => $f): ?>
                <details class="reveal" <?php echo $i === 0 ? 'open' : ''; ?> style="border-color:var(--hp-line)">
                    <summary><?php echo $f['q']; ?><i class="fas fa-plus"></i></summary>
                    <p><?php echo $f['a']; ?></p>
                </details>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php echo faq_schema($contact_faqs); ?>
</main>
<?php include 'footer.php'; ?>
