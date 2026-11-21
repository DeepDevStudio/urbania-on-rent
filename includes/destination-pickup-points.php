<?php
// includes/destination-pickup-points.php
// Reusable Component: Dynamic "Pickup from Delhi NCR" Section for all Destination Route Pages
// Urbania on Rent Delhi

// Determine destination name, slug & origin dynamically
$pickup_dest_name = !empty($destinationName) ? $destinationName : (!empty($dest['destination']) ? $dest['destination'] : 'Outstation');
$pickup_dest_slug = !empty($destinationSlug) ? $destinationSlug : (!empty($dest['slug']) ? $dest['slug'] : 'delhi-outstation');
$pickup_origin_id = !empty($originId) ? strtolower($originId) : (!empty($dest['origin_id']) ? strtolower($dest['origin_id']) : 'delhi');
$pickup_origin_name = !empty($originName) ? $originName : (!empty($dest['origin']) ? $dest['origin'] : 'Delhi');

// Load centralized pickup configuration
static $all_pickup_configs = null;
if ($all_pickup_configs === null) {
    $config_path = __DIR__ . '/../config/pickup-locations.php';
    if (file_exists($config_path)) {
        $all_pickup_configs = require $config_path;
    } else {
        $all_pickup_configs = [];
    }
}
$pickup_categories = $all_pickup_configs[$pickup_origin_id] ?? ($all_pickup_configs['delhi'] ?? []);
?>

<!-- ============================================================== -->
<!-- DESTINATION PICKUP FROM DELHI NCR SECTION                      -->
<!-- ============================================================== -->
<section class="destination-pickup-section" id="pickup-locations">
    <div class="container">
        <!-- Main Section Container with Glass/Shadow Styling -->
        <div class="pickup-container-card">
            
            <!-- Section Header -->
            <div class="pickup-header text-center">
                <div class="pickup-kicker">
                    <i class="fas fa-location-crosshairs"></i> Doorstep Pickup Coverage
                </div>
                <h2 class="pickup-main-heading">
                    <span class="highlight-dest"><?php echo htmlspecialchars($pickup_dest_name); ?></span> Urbania Pickup from Anywhere in <?php echo htmlspecialchars($pickup_origin_id === 'delhi' ? 'Delhi NCR' : $pickup_origin_name); ?>
                </h2>
                <p class="pickup-main-desc">
                    We pick up your group from your home, residential society, hotel, airport or metro station in <?php echo htmlspecialchars($pickup_origin_name); ?>. Popular pickup points:
                </p>
            </div>

            <!-- Categories Container -->
            <div class="pickup-categories-wrapper">
                <?php foreach ($pickup_categories as $cat_index => $cat): ?>
                <div class="pickup-category-block">
                    <!-- Category Title Header -->
                    <div class="pickup-category-header">
                        <div class="pickup-category-title-group">
                            <span class="pickup-cat-icon">
                                <i class="fas <?php echo htmlspecialchars($cat['icon']); ?>"></i>
                            </span>
                            <h3 class="pickup-category-title"><?php echo htmlspecialchars($cat['category']); ?></h3>
                        </div>
                        <span class="pickup-count-badge"><?php echo count($cat['locations']); ?> Pickup Points</span>
                    </div>

                    <!-- 4-Column Pickup Grid -->
                    <div class="pickup-grid-4col">
                        <?php foreach ($cat['locations'] as $loc): ?>
                        <a href="contact.php?pickup=<?php echo urlencode($loc); ?>&destination=<?php echo urlencode($pickup_dest_name); ?>&origin=<?php echo urlencode($pickup_origin_name); ?>#booking" 
                           class="pickup-route-item" 
                           data-pickup="<?php echo htmlspecialchars($loc, ENT_QUOTES, 'UTF-8'); ?>" 
                           data-destination="<?php echo htmlspecialchars($pickup_dest_name, ENT_QUOTES, 'UTF-8'); ?>"
                           title="<?php echo htmlspecialchars($loc . ' to ' . $pickup_dest_name . ' Urbania on rent'); ?>">
                            <div class="pickup-item-left">
                                <span class="pickup-vehicle-bullet">
                                    <i class="fas fa-van-shuttle"></i>
                                </span>
                                <span class="pickup-route-text">
                                    <strong class="pickup-source-name"><?php echo htmlspecialchars($loc); ?></strong> to <strong class="pickup-dest-name"><?php echo htmlspecialchars($pickup_dest_name); ?></strong> Urbania on rent
                                </span>
                            </div>
                            <span class="pickup-arrow-indicator">
                                <i class="fas fa-chevron-right"></i>
                            </span>
                        </a>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <!-- Bottom Assistance & Assurance Strip -->
            <div class="pickup-footer-strip">
                <div class="pickup-assurance-item">
                    <i class="fas fa-house-chimney-user"></i>
                    <span><strong>100% Doorstep Pickup:</strong> Chauffeur arrives at your exact porch/gate.</span>
                </div>
                <div class="pickup-assurance-item">
                    <i class="fas fa-clock"></i>
                    <span><strong>On-Time Guarantee:</strong> Zero delays for early morning &amp; midnight starts.</span>
                </div>
                <div class="pickup-assurance-item">
                    <i class="fas fa-headset"></i>
                    <span><strong>Custom Pickup?</strong> Need multi-point <?php echo htmlspecialchars($pickup_origin_name); ?> pickup? Call <a href="tel:+917290885949">+91 7290885949</a></span>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- ============================================================== -->
<!-- INTERACTIVE QUICK PICKUP BOOKING MODAL                         -->
<!-- ============================================================== -->
<div class="pickup-booking-modal" id="pickupBookingModal" aria-hidden="true" role="dialog">
    <div class="pickup-modal-backdrop" id="pickupModalBackdrop"></div>
    <div class="pickup-modal-dialog">
        <div class="pickup-modal-content">
            <button type="button" class="pickup-modal-close" id="pickupModalClose" aria-label="Close Modal">&times;</button>
            
            <div class="pickup-modal-header">
                <div class="pickup-modal-badge">
                    <i class="fas fa-bolt"></i> Instant Doorstep Pickup
                </div>
                <h3 class="pickup-modal-title">
                    Hire Urbania: <span id="modalPickupFrom" style="color: #D4AF37;">Rohini</span> to <span id="modalPickupTo" style="color: #38bdf8;">Manali</span>
                </h3>
                <p class="pickup-modal-subtitle">
                    Get instant vehicle availability, transparent per-km quote, and doorstep pickup confirmation.
                </p>
            </div>

            <div class="pickup-modal-body">
                <!-- Trip Summary Route Pill -->
                <div class="modal-route-pill">
                    <div class="m-route-point">
                        <small>Pickup Point</small>
                        <strong id="modalRouteSource">Rohini, Delhi NCR</strong>
                    </div>
                    <div class="m-route-arrow">
                        <i class="fas fa-arrow-right-long"></i>
                    </div>
                    <div class="m-route-point">
                        <small>Destination</small>
                        <strong id="modalRouteDest">Manali</strong>
                    </div>
                </div>

                <!-- Instant Action CTA Buttons -->
                <div class="pickup-modal-actions">
                    <a href="#" id="modalWhatsAppBtn" target="_blank" class="p-btn p-btn-wa">
                        <i class="fab fa-whatsapp"></i> Chat on WhatsApp (Fastest)
                    </a>
                    <a href="tel:+917290885949" class="p-btn p-btn-call">
                        <i class="fas fa-phone-alt"></i> Call +91 7290885949
                    </a>
                </div>

                <div class="pickup-modal-divider">
                    <span>or fill details for instant callback</span>
                </div>

                <!-- Fast Inquiry Form -->
                <form class="pickup-quick-form" id="pickupQuickForm" method="POST" action="contact.php#booking">
                    <input type="hidden" name="pickup" id="modalFormPickup" value="">
                    <input type="hidden" name="destination" id="modalFormDestination" value="">
                    <input type="hidden" name="service_type" value="Outstation Tour">

                    <div class="p-form-row">
                        <div class="p-form-group">
                            <label><i class="fas fa-user"></i> Your Name *</label>
                            <input type="text" name="name" required placeholder="Full Name">
                        </div>
                        <div class="p-form-group">
                            <label><i class="fas fa-phone"></i> Mobile Number *</label>
                            <input type="tel" name="phone" required placeholder="+91 98xxx xxxxx">
                        </div>
                    </div>

                    <div class="p-form-row">
                        <div class="p-form-group">
                            <label><i class="fas fa-calendar-day"></i> Travel Date</label>
                            <input type="date" name="travel_date" min="<?php echo date('Y-m-d'); ?>">
                        </div>
                        <div class="p-form-group">
                            <label><i class="fas fa-van-shuttle"></i> Urbania Seating</label>
                            <select name="vehicle">
                                <option value="9 Seater Force Urbania">9 Seater Urbania</option>
                                <option value="12 Seater Force Urbania">12 Seater Urbania</option>
                                <option value="16 Seater Force Urbania">16 Seater Force Urbania</option>
                            </select>
                        </div>
                    </div>

                    <div class="p-form-group is-full">
                        <label><i class="fas fa-comment"></i> Notes / Passenger Count</label>
                        <textarea name="message" rows="2" placeholder="e.g. 10 adults, 3 days roundtrip..."></textarea>
                    </div>

                    <button type="submit" name="contact_submit" class="p-btn-submit">
                        <i class="fas fa-paper-plane"></i> Submit Pickup Inquiry
                    </button>
                </form>
            </div>
            
            <div class="pickup-modal-footer">
                <i class="fas fa-shield-halved" style="color: #10b981;"></i> All Urbania rentals come with clean interiors, commercial permits &amp; certified drivers.
            </div>
        </div>
    </div>
</div>

<!-- ============================================================== -->
<!-- CSS STYLES FOR PICKUP SECTION & MODAL                         -->
<!-- ============================================================== -->
<style>
/* Pickup Section Scoped Styles */
.destination-pickup-section {
    padding: 70px 0 50px;
    background: #f8fafc;
    position: relative;
}

.pickup-container-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 24px;
    padding: 50px 40px;
    box-shadow: 0 10px 40px -10px rgba(15, 23, 42, 0.05);
    position: relative;
}

.pickup-header {
    max-width: 900px;
    margin: 0 auto 40px;
    text-align: center;
}

.pickup-kicker {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(212, 175, 55, 0.12);
    color: #b08d27;
    font-weight: 700;
    font-size: 0.85rem;
    text-transform: uppercase;
    letter-spacing: 1px;
    padding: 6px 16px;
    border-radius: 30px;
    border: 1px solid rgba(212, 175, 55, 0.3);
    margin-bottom: 12px;
}

.pickup-main-heading {
    font-size: clamp(1.8rem, 3.5vw, 2.4rem);
    font-weight: 900;
    color: #0f172a;
    line-height: 1.25;
    margin: 0 0 12px;
}

.pickup-main-heading .highlight-dest {
    color: #D4AF37;
    position: relative;
}

.pickup-main-desc {
    color: #64748b;
    font-size: 1.05rem;
    line-height: 1.6;
    margin: 0;
}

.pickup-categories-wrapper {
    display: flex;
    flex-direction: column;
    gap: 35px;
}

.pickup-category-block {
    background: #fdfefe;
    border: 1px solid #edf2f7;
    border-radius: 18px;
    padding: 26px 28px;
    transition: box-shadow 0.3s ease, border-color 0.3s ease;
}

.pickup-category-block:hover {
    border-color: #cbd5e1;
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.03);
}

.pickup-category-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    padding-bottom: 14px;
    border-bottom: 2px solid #f1f5f9;
}

.pickup-category-title-group {
    display: flex;
    align-items: center;
    gap: 12px;
}

.pickup-cat-icon {
    width: 38px;
    height: 38px;
    border-radius: 10px;
    background: #0f172a;
    color: #D4AF37;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 1.1rem;
    flex-shrink: 0;
}

.pickup-category-title {
    font-size: 1.25rem;
    font-weight: 800;
    color: #0f172a;
    margin: 0;
}

.pickup-count-badge {
    background: #f1f5f9;
    color: #475569;
    font-size: 0.8rem;
    font-weight: 700;
    padding: 5px 12px;
    border-radius: 20px;
    border: 1px solid #e2e8f0;
}

/* 4 Column Grid */
.pickup-grid-4col {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 12px 14px;
}

/* Pickup Route Item Link */
.pickup-route-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 10px;
    padding: 10px 14px;
    text-decoration: none;
    color: #334155;
    transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
    min-height: 48px;
}

.pickup-item-left {
    display: flex;
    align-items: center;
    gap: 10px;
    min-width: 0;
    flex: 1;
}

.pickup-vehicle-bullet {
    color: #D4AF37;
    font-size: 0.85rem;
    flex-shrink: 0;
    transition: transform 0.25s ease;
}

.pickup-route-text {
    font-size: 0.88rem;
    font-weight: 500;
    line-height: 1.35;
    color: #334155;
    overflow-wrap: break-word;
    word-break: normal;
}

.pickup-route-text .pickup-source-name {
    color: #0f172a;
    font-weight: 700;
}

.pickup-route-text .pickup-dest-name {
    color: #1e293b;
    font-weight: 700;
}

.pickup-arrow-indicator {
    color: #cbd5e1;
    font-size: 0.75rem;
    flex-shrink: 0;
    transition: all 0.25s ease;
}

.pickup-route-item:hover {
    background: #0f172a;
    color: #ffffff;
    border-color: #0f172a;
    transform: translateY(-2px);
    box-shadow: 0 6px 15px rgba(15, 23, 42, 0.12);
}

.pickup-route-item:hover .pickup-route-text {
    color: #f1f5f9;
}

.pickup-route-item:hover .pickup-route-text .pickup-source-name {
    color: #D4AF37;
}

.pickup-route-item:hover .pickup-route-text .pickup-dest-name {
    color: #ffffff;
}

.pickup-route-item:hover .pickup-vehicle-bullet {
    color: #D4AF37;
    transform: translateX(2px);
}

.pickup-route-item:hover .pickup-arrow-indicator {
    color: #D4AF37;
    transform: translateX(3px);
}

/* Bottom Assurance Strip */
.pickup-footer-strip {
    margin-top: 40px;
    padding-top: 25px;
    border-top: 1px solid #e2e8f0;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
    gap: 20px;
}

.pickup-assurance-item {
    display: flex;
    align-items: center;
    gap: 12px;
    font-size: 0.9rem;
    color: #475569;
}

.pickup-assurance-item i {
    font-size: 1.3rem;
    color: #D4AF37;
    flex-shrink: 0;
}

.pickup-assurance-item a {
    color: #0f172a;
    font-weight: 700;
    text-decoration: underline;
}

/* Modal Window Styles */
.pickup-booking-modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    z-index: 99999;
    align-items: center;
    justify-content: center;
    padding: 20px;
}

.pickup-booking-modal.is-active {
    display: flex;
}

.pickup-modal-backdrop {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(15, 23, 42, 0.75);
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
}

.pickup-modal-dialog {
    position: relative;
    z-index: 2;
    width: 100%;
    max-width: 580px;
    max-height: 90vh;
    overflow-y: auto;
    background: #ffffff;
    border-radius: 20px;
    box-shadow: 0 25px 60px rgba(0, 0, 0, 0.35);
    border: 1px solid rgba(212, 175, 55, 0.4);
    animation: pickupModalSlideIn 0.3s cubic-bezier(0.16, 1, 0.3, 1);
}

@keyframes pickupModalSlideIn {
    from { opacity: 0; transform: translateY(20px) scale(0.96); }
    to { opacity: 1; transform: translateY(0) scale(1); }
}

.pickup-modal-content {
    padding: 32px 30px;
    position: relative;
}

.pickup-modal-close {
    position: absolute;
    top: 18px;
    right: 20px;
    background: #f1f5f9;
    border: none;
    font-size: 1.6rem;
    line-height: 1;
    color: #64748b;
    width: 36px;
    height: 36px;
    border-radius: 50%;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s ease;
}

.pickup-modal-close:hover {
    background: #0f172a;
    color: #ffffff;
}

.pickup-modal-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: rgba(212, 175, 55, 0.15);
    color: #b08d27;
    font-size: 0.75rem;
    font-weight: 800;
    text-transform: uppercase;
    padding: 4px 12px;
    border-radius: 20px;
    margin-bottom: 10px;
}

.pickup-modal-title {
    font-size: 1.4rem;
    font-weight: 800;
    color: #0f172a;
    margin: 0 0 6px;
    line-height: 1.3;
}

.pickup-modal-subtitle {
    font-size: 0.88rem;
    color: #64748b;
    margin: 0 0 20px;
    line-height: 1.5;
}

.modal-route-pill {
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 12px 18px;
    margin-bottom: 20px;
}

.m-route-point small {
    display: block;
    font-size: 0.7rem;
    color: #94a3b8;
    text-transform: uppercase;
    font-weight: 700;
}

.m-route-point strong {
    font-size: 0.95rem;
    color: #0f172a;
}

.m-route-arrow {
    color: #D4AF37;
    font-size: 1.2rem;
}

.pickup-modal-actions {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 12px;
    margin-bottom: 20px;
}

.p-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 12px 16px;
    border-radius: 10px;
    font-weight: 700;
    font-size: 0.9rem;
    text-decoration: none;
    transition: transform 0.2s ease;
    text-align: center;
}

.p-btn:hover { transform: translateY(-2px); }

.p-btn-wa {
    background: #25D366;
    color: #ffffff;
    box-shadow: 0 4px 12px rgba(37, 211, 102, 0.3);
}

.p-btn-call {
    background: #0f172a;
    color: #D4AF37;
    box-shadow: 0 4px 12px rgba(15, 23, 42, 0.2);
}

.pickup-modal-divider {
    text-align: center;
    position: relative;
    margin: 18px 0;
}

.pickup-modal-divider::before {
    content: '';
    position: absolute;
    left: 0;
    top: 50%;
    width: 100%;
    height: 1px;
    background: #e2e8f0;
}

.pickup-modal-divider span {
    position: relative;
    background: #ffffff;
    padding: 0 12px;
    font-size: 0.78rem;
    color: #94a3b8;
    text-transform: uppercase;
    font-weight: 600;
}

.pickup-quick-form {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.p-form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 12px;
}

.p-form-group {
    display: flex;
    flex-direction: column;
    gap: 5px;
}

.p-form-group.is-full {
    grid-column: 1 / -1;
}

.p-form-group label {
    font-size: 0.78rem;
    font-weight: 700;
    color: #334155;
    display: flex;
    align-items: center;
    gap: 6px;
}

.p-form-group input,
.p-form-group select,
.p-form-group textarea {
    width: 100%;
    padding: 10px 12px;
    border: 1px solid #cbd5e1;
    border-radius: 8px;
    font-size: 0.88rem;
    font-family: inherit;
    color: #0f172a;
    background: #ffffff;
    outline: none;
    transition: border-color 0.2s ease;
}

.p-form-group input:focus,
.p-form-group select:focus,
.p-form-group textarea:focus {
    border-color: #D4AF37;
}

.p-btn-submit {
    width: 100%;
    padding: 12px;
    background: #D4AF37;
    color: #0f172a;
    font-weight: 800;
    border: none;
    border-radius: 10px;
    font-size: 0.95rem;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    margin-top: 6px;
    box-shadow: 0 4px 15px rgba(212, 175, 55, 0.35);
    transition: background 0.2s ease;
}

.p-btn-submit:hover {
    background: #b08d27;
    color: #ffffff;
}

.pickup-modal-footer {
    margin-top: 18px;
    padding-top: 14px;
    border-top: 1px solid #f1f5f9;
    font-size: 0.8rem;
    color: #64748b;
    text-align: center;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
}

/* ============================================================== */
/* RESPONSIVE LAYOUT (Desktop 4col, Tablet 2col, Mobile 1col)     */
/* ============================================================== */
@media (max-width: 1199px) {
    .pickup-grid-4col {
        grid-template-columns: repeat(3, 1fr);
    }
}

@media (max-width: 991px) {
    .pickup-container-card {
        padding: 35px 24px;
        border-radius: 20px;
    }
    .pickup-grid-4col {
        grid-template-columns: repeat(2, 1fr);
        gap: 10px;
    }
}

@media (max-width: 640px) {
    .destination-pickup-section {
        padding: 50px 0 35px;
    }
    .pickup-container-card {
        padding: 26px 16px;
        border-radius: 16px;
    }
    .pickup-category-block {
        padding: 18px 14px;
        border-radius: 14px;
    }
    .pickup-category-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 8px;
    }
    .pickup-count-badge {
        align-self: flex-start;
    }
    .pickup-grid-4col {
        grid-template-columns: 1fr;
        gap: 8px;
    }
    .pickup-route-item {
        padding: 10px 12px;
    }
    .pickup-route-text {
        font-size: 0.84rem;
    }
    .p-form-row {
        grid-template-columns: 1fr;
    }
    .pickup-modal-actions {
        grid-template-columns: 1fr;
    }
    .pickup-modal-content {
        padding: 24px 18px;
    }
}
</style>

<!-- ============================================================== -->
<!-- JAVASCRIPT FOR MODAL INTERACTIVITY & PRE-FILL                  -->
<!-- ============================================================== -->
<script>
(function() {
    function initPickupModal() {
        const modal = document.getElementById('pickupBookingModal');
        const backdrop = document.getElementById('pickupModalBackdrop');
        const closeBtn = document.getElementById('pickupModalClose');
        const fromSpan = document.getElementById('modalPickupFrom');
        const toSpan = document.getElementById('modalPickupTo');
        const routeSource = document.getElementById('modalRouteSource');
        const routeDest = document.getElementById('modalRouteDest');
        const waBtn = document.getElementById('modalWhatsAppBtn');
        const inputPickup = document.getElementById('modalFormPickup');
        const inputDest = document.getElementById('modalFormDestination');
        
        if (!modal) return;

        function openModal(pickup, destination) {
            if (fromSpan) fromSpan.textContent = pickup;
            if (toSpan) toSpan.textContent = destination;
            if (routeSource) routeSource.textContent = pickup + ', Delhi NCR';
            if (routeDest) routeDest.textContent = destination;
            
            if (inputPickup) inputPickup.value = pickup;
            if (inputDest) inputDest.value = destination;

            if (waBtn) {
                const waMessage = 'Hello, I want to book a luxury Force Urbania for pickup from ' + pickup + ' to ' + destination + '. Please share vehicle options, rates and availability.';
                waBtn.href = 'https://wa.me/917290885949?text=' + encodeURIComponent(waMessage);
            }

            modal.classList.add('is-active');
            modal.setAttribute('aria-hidden', 'false');
            document.body.style.overflow = 'hidden';
        }

        function closeModal() {
            modal.classList.remove('is-active');
            modal.setAttribute('aria-hidden', 'true');
            document.body.style.overflow = '';
        }

        document.querySelectorAll('.pickup-route-item').forEach(function(item) {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                const pickup = this.getAttribute('data-pickup') || 'Delhi';
                const dest = this.getAttribute('data-destination') || 'Outstation';
                openModal(pickup, dest);
            });
        });

        if (closeBtn) closeBtn.addEventListener('click', closeModal);
        if (backdrop) backdrop.addEventListener('click', closeModal);

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && modal.classList.contains('is-active')) {
                closeModal();
            }
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initPickupModal);
    } else {
        initPickupModal();
    }
})();
</script>
