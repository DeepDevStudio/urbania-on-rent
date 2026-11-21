<?php
$page_title = 'Uttarakhand Tour Package | Delhi to Nainital Mussoorie Urbania on Rent';
$page_description = 'Book luxury Force Urbania for Uttarakhand tour package from Delhi. Travel to Nainital, Mussoorie, and Jim Corbett in 12 & 16 seater luxury Urbania.';
include 'header.php';
?>

<main>
    <style>
        /* Tour Hero Section */
        .tour-hero {
            background: linear-gradient(rgba(15, 23, 42, 0.6), rgba(15, 23, 42, 0.7)), url('https://upload.wikimedia.org/wikipedia/commons/thumb/5/50/Valley_of_flowers_national_park%2C_Uttarakhand%2C_India_03_%28edit%29.jpg/1280px-Valley_of_flowers_national_park%2C_Uttarakhand%2C_India_03_%28edit%29.jpg') center center/cover no-repeat fixed;
            padding: 180px 0 140px;
            text-align: center;
            position: relative;
        }
        .tour-hero-content {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 24px;
            padding: 60px;
            max-width: 900px;
            margin: 0 auto;
            box-shadow: 0 20px 40px rgba(0,0,0,0.3);
            animation: slideUp 1s ease-out forwards;
        }
        .tour-badge {
            background: rgba(212, 175, 55, 0.2);
            color: #D4AF37;
            border: 1px solid #D4AF37;
            padding: 8px 24px;
            border-radius: 30px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-size: 0.9rem;
            display: inline-block;
            margin-bottom: 20px;
        }
        .tour-hero h1 {
            color: #ffffff;
            font-size: 4.5rem;
            font-weight: 900;
            margin-bottom: 20px;
            letter-spacing: -1px;
        }
        .tour-hero h1 span {
            color: #D4AF37;
        }
        .tour-tagline {
            color: #e2e8f0;
            font-size: 1.4rem;
            font-weight: 300;
            max-width: 700px;
            margin: 0 auto;
        }
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(50px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Overview Section */
        .tour-overview {
            padding: 80px 0;
            background: #ffffff;
        }
        .overview-stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-top: -120px;
            position: relative;
            z-index: 10;
            margin-bottom: 60px;
        }
        .stat-card {
            background: #ffffff;
            border-radius: 16px;
            padding: 30px 20px;
            text-align: center;
            box-shadow: 0 15px 35px rgba(0,0,0,0.08);
            border-bottom: 4px solid #00a388;
            transition: transform 0.3s ease;
        }
        .stat-card:hover {
            transform: translateY(-10px);
        }
        .stat-icon {
            font-size: 2.5rem;
            color: #00a388;
            margin-bottom: 15px;
        }
        .stat-title {
            font-size: 0.9rem;
            color: #718096;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 600;
            margin-bottom: 5px;
        }
        .stat-val {
            font-size: 1.5rem;
            font-weight: 800;
            color: #1a202c;
        }

        /* Places Covered */
        .places-section {
            padding: 80px 0;
            background: #f8fafc;
        }
        .section-title {
            text-align: center;
            margin-bottom: 60px;
        }
        .section-title h2 {
            font-size: 3rem;
            font-weight: 800;
            color: #1a202c;
            margin-bottom: 15px;
        }
        .places-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
        }
        .place-card {
            background: #ffffff;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
        }
        .place-card:hover {
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            transform: translateY(-10px);
        }
        .place-img {
            height: 250px;
            background: #e2e8f0;
            position: relative;
        }
        .place-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .place-content {
            padding: 30px;
        }
        .place-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .place-title i {
            color: #D4AF37;
        }
        .place-desc {
            color: #4a5568;
            line-height: 1.6;
            margin-bottom: 20px;
        }

        /* Why Urbania */
        .why-urbania {
            padding: 100px 0;
            background: linear-gradient(135deg, #1e293b, #0f172a);
            color: white;
        }
        .urbania-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 50px;
            align-items: center;
        }
        .urbania-text h2 {
            font-size: 3rem;
            font-weight: 800;
            margin-bottom: 20px;
        }
        .urbania-text h2 span {
            color: #D4AF37;
        }
        .urbania-text p {
            font-size: 1.15rem;
            color: #cbd5e1;
            margin-bottom: 30px;
            line-height: 1.8;
        }
        .feat-list {
            list-style: none;
            padding: 0;
        }
        .feat-list li {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            font-size: 1.1rem;
            color: #f1f5f9;
        }
        .feat-list li i {
            color: #38a169;
            margin-right: 15px;
            font-size: 1.3rem;
        }

        /* CTA */
        .tour-cta {
            padding: 80px 0;
            background: #ffffff;
            text-align: center;
        }
        .tour-cta h2 {
            font-size: 2.5rem;
            font-weight: 800;
            color: #1a202c;
            margin-bottom: 30px;
        }
        
        @media (max-width: 992px) {
            .overview-stats { grid-template-columns: repeat(2, 1fr); margin-top: -60px; }
            .places-grid { grid-template-columns: repeat(2, 1fr); }
            .urbania-grid { grid-template-columns: 1fr; }
            .tour-hero h1 { font-size: 3.5rem; }
        }
        @media (max-width: 768px) {
            .places-grid { grid-template-columns: 1fr; }
            .tour-hero h1 { font-size: 2.5rem; }
            .tour-hero-content { padding: 40px 20px; }
        }
    </style>

    <!-- Hero Section -->
    <section class="tour-hero">
        <div class="container">
            <div class="tour-hero-content">
                <span class="tour-badge"><i class="fas fa-tree"></i> Devbhoomi Explorations</span>
                <h1>Uttarakhand <span>Tour</span></h1>
                <p class="tour-tagline">Explore the serene lakes, green hills, and wildlife of Uttarakhand in complete luxury.</p>
            </div>
        </div>
    </section>

    <!-- Overview Section -->
    <section class="tour-overview">
        <div class="container">
            <div class="overview-stats">
                <div class="stat-card">
                    <i class="fas fa-clock stat-icon"></i>
                    <div class="stat-title">Duration</div>
                    <div class="stat-val">7 Days / 6 Nights</div>
                </div>
                <div class="stat-card">
                    <i class="fas fa-map-marker-alt stat-icon"></i>
                    <div class="stat-title">Start / End</div>
                    <div class="stat-val">Delhi / Nainital</div>
                </div>
                <div class="stat-card">
                    <i class="fas fa-users stat-icon"></i>
                    <div class="stat-title">Ideal For</div>
                    <div class="stat-val">Families & Nature Lovers</div>
                </div>
                <div class="stat-card">
                    <i class="fas fa-car-side stat-icon"></i>
                    <div class="stat-title">Vehicle</div>
                    <div class="stat-val">Luxury Urbania</div>
                </div>
            </div>

            <div class="text-center mt-5" style="max-width: 800px; margin: 0 auto;">
                <h2 style="font-size: 2.5rem; font-weight: 800; color: #1a202c; margin-bottom: 20px;">Land of the Gods</h2>
                <p style="font-size: 1.15rem; color: #4a5568; line-height: 1.8;">Known as Devbhoomi, Uttarakhand is a haven of pristine lakes and majestic forests. Traverse through the scenic routes with our premium Urbania fleet, built for a bump-free ride amidst the hills.</p>
            </div>
        </div>
    </section>

    <!-- Places Covered -->
    <section class="places-section">
        <div class="container">
            <div class="section-title">
                <h2>Places Covered</h2>
                <p style="font-size: 1.1rem; color: #718096;">Discover the beauty of Uttarakhand</p>
            </div>

            <div class="places-grid">
                <!-- Place 1 -->
                <div class="place-card">
                    <div class="place-img">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/6/6f/Nainital_metro.jpg/1280px-Nainital_metro.jpg" alt="Naini Lake nestled amidst green Kumaon hills in Nainital, Uttarakhand – Delhi to Nainital Urbania on rent for family & group tours">
                    </div>
                    <div class="place-content">
                        <div class="place-title"><i class="fas fa-map-pin"></i> Nainital</div>
                        <p class="place-desc">The Lake District of India. Enjoy a boat ride on the Naini Lake and visit the Naina Devi Temple.</p>
                        <div style="color: #00a388; font-weight: 600;"><i class="fas fa-moon"></i> 2 Nights Stay</div>
                    </div>
                </div>

                <!-- Place 2 -->
                <div class="place-card">
                    <div class="place-img">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/e/e0/Mussoorie_Snow_Over_Dehradun_%2814831297545%29.jpg/1280px-Mussoorie_Snow_Over_Dehradun_%2814831297545%29.jpg" alt="Snow-capped Himalayan peaks seen from high vantage points in Mussoorie, Uttarakhand – Delhi to Mussoorie Urbania on rent for family & group tours">
                    </div>
                    <div class="place-content">
                        <div class="place-title"><i class="fas fa-map-pin"></i> Mussoorie</div>
                        <p class="place-desc">The Queen of the Hills. Explore Mall Road, Kempty Falls, and enjoy panoramic views of the Doon Valley.</p>
                        <div style="color: #00a388; font-weight: 600;"><i class="fas fa-moon"></i> 2 Nights Stay</div>
                    </div>
                </div>

                <!-- Place 3 -->
                <div class="place-card">
                    <div class="place-img">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/7/78/Bengal-Tiger_Corbett_Uttarakhand_Dec-2013.jpg" alt="Royal Bengal Tiger in wilderness at Jim Corbett National Park, Uttarakhand – Delhi to Jim Corbett Urbania on rent for family & group tours">
                    </div>
                    <div class="place-content">
                        <div class="place-title"><i class="fas fa-map-pin"></i> Jim Corbett</div>
                        <p class="place-desc">India's oldest national park. Experience thrilling jungle safaris and witness exotic wildlife in their natural habitat.</p>
                        <div style="color: #00a388; font-weight: 600;"><i class="fas fa-moon"></i> 2 Nights Stay</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Urbania -->
    <section class="why-urbania">
        <div class="container">
            <div class="urbania-grid">
                <div class="urbania-text">
                    <h2>Why choose <span>Urbania</span> for Uttarakhand?</h2>
                    <p>Uttarakhand's winding mountain roads demand a comfortable ride. The Force Urbania provides ample legroom and pushback seats to ensure you enjoy the journey as much as the destination.</p>
                    <ul class="feat-list">
                        <li style="display: flex; align-items: center; gap: 10px; color: #4a5568;"><i class="fas fa-check-circle" style="color: #1e7a44;"></i> <i class="fas fa-check-circle"></i> Panoramic windows for stunning hill views</li>
                        <li style="display: flex; align-items: center; gap: 10px; color: #4a5568;"><i class="fas fa-check-circle" style="color: #1e7a44;"></i> <i class="fas fa-check-circle"></i> Spacious pushback seats for maximum relaxation</li>
                        <li style="display: flex; align-items: center; gap: 10px; color: #4a5568;"><i class="fas fa-check-circle" style="color: #1e7a44;"></i> <i class="fas fa-check-circle"></i> Superior suspension for uneven mountain terrain</li>
                        <li style="display: flex; align-items: center; gap: 10px; color: #4a5568;"><i class="fas fa-check-circle" style="color: #1e7a44;"></i> <i class="fas fa-check-circle"></i> Experienced drivers familiar with local routes</li>
                    </ul>
                </div>
                <div class="urbania-img text-center">
                    <i class="fas fa-bus-alt" style="font-size: 15rem; color: rgba(255,255,255,0.05); text-shadow: 0 0 50px rgba(212,175,55,0.2);"></i>
                </div>
            </div>
        </div>
    </section>

    
    <!-- Pricing Section -->
    <section class="pricing-section" style="padding: 80px 0; background: #f8fafc;">
        <div class="container">
            <div class="section-title text-center" style="margin-bottom: 50px;">
                <h2 style="font-size: 2.5rem; font-weight: 800; color: #1a202c;">Package Pricing</h2>
                <p style="color: #718096; font-size: 1.1rem;">Transparent and competitive pricing for your perfect trip</p>
            </div>
            <div class="pricing-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px;">
                <!-- 9 Seater -->
                <div class="pricing-card" style="background: white; border-radius: 20px; padding: 40px; text-align: center; box-shadow: 0 10px 30px rgba(0,0,0,0.05); border-top: 5px solid #00a388; transition: transform 0.3s ease;">
                    <h3 style="font-size: 1.5rem; color: #2d3748; margin-bottom: 15px;">9 Seater Urbania</h3>
                    <div class="price" style="font-size: 2.5rem; font-weight: 800; color: #1a202c; margin-bottom: 20px;">₹77,000</div>
                    <ul style="list-style: none; padding: 0; margin-bottom: 30px; color: #4a5568; text-align: left;">
                        <li style="margin-bottom: 10px;"><i class="fas fa-check" style="color: #00a388; margin-right: 10px;"></i> Professional Driver</li>
                        <li style="margin-bottom: 10px;"><i class="fas fa-check" style="color: #00a388; margin-right: 10px;"></i> Toll & State Taxes Included</li>
                        <li style="margin-bottom: 10px;"><i class="fas fa-check" style="color: #00a388; margin-right: 10px;"></i> Fuel Included</li>
                    </ul>
                    <a href="https://wa.me/917290885949" class="btn btn-outline-dark" style="width: 100%; border-radius: 30px; font-weight: 700; padding: 12px; border: 2px solid #1a202c; text-decoration: none; color: #1a202c; display: inline-block;">Book Now</a>
                </div>
                <!-- 12 Seater -->
                <div class="pricing-card" style="background: white; border-radius: 20px; padding: 40px; text-align: center; box-shadow: 0 15px 40px rgba(0,0,0,0.08); border-top: 5px solid #D4AF37; transform: scale(1.05); position: relative; z-index: 2;">
                    <div style="position: absolute; top: -15px; left: 50%; transform: translateX(-50%); background: #D4AF37; color: white; padding: 5px 15px; border-radius: 20px; font-size: 0.85rem; font-weight: 700;">MOST POPULAR</div>
                    <h3 style="font-size: 1.5rem; color: #2d3748; margin-bottom: 15px;">12 Seater Urbania</h3>
                    <div class="price" style="font-size: 2.5rem; font-weight: 800; color: #1a202c; margin-bottom: 20px;">₹77,000</div>
                    <ul style="list-style: none; padding: 0; margin-bottom: 30px; color: #4a5568; text-align: left;">
                        <li style="margin-bottom: 10px;"><i class="fas fa-check" style="color: #D4AF37; margin-right: 10px;"></i> Professional Driver</li>
                        <li style="margin-bottom: 10px;"><i class="fas fa-check" style="color: #D4AF37; margin-right: 10px;"></i> Toll & State Taxes Included</li>
                        <li style="margin-bottom: 10px;"><i class="fas fa-check" style="color: #D4AF37; margin-right: 10px;"></i> Fuel Included</li>
                    </ul>
                    <a href="https://wa.me/917290885949" class="btn btn-primary" style="width: 100%; border-radius: 30px; font-weight: 700; padding: 12px; background: #1a202c; color: white; text-decoration: none; display: inline-block;">Book Now</a>
                </div>
                <!-- 16 Seater -->
                <div class="pricing-card" style="background: white; border-radius: 20px; padding: 40px; text-align: center; box-shadow: 0 10px 30px rgba(0,0,0,0.05); border-top: 5px solid #1e7a44; transition: transform 0.3s ease;">
                    <h3 style="font-size: 1.5rem; color: #2d3748; margin-bottom: 15px;">16 Seater Urbania</h3>
                    <div class="price" style="font-size: 2.5rem; font-weight: 800; color: #1a202c; margin-bottom: 20px;">₹70,000</div>
                    <ul style="list-style: none; padding: 0; margin-bottom: 30px; color: #4a5568; text-align: left;">
                        <li style="margin-bottom: 10px;"><i class="fas fa-check" style="color: #1e7a44; margin-right: 10px;"></i> Professional Driver</li>
                        <li style="margin-bottom: 10px;"><i class="fas fa-check" style="color: #1e7a44; margin-right: 10px;"></i> Toll & State Taxes Included</li>
                        <li style="margin-bottom: 10px;"><i class="fas fa-check" style="color: #1e7a44; margin-right: 10px;"></i> Fuel Included</li>
                    </ul>
                    <a href="https://wa.me/917290885949" class="btn btn-outline-dark" style="width: 100%; border-radius: 30px; font-weight: 700; padding: 12px; border: 2px solid #1a202c; text-decoration: none; color: #1a202c; display: inline-block;">Book Now</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Top Places & FAQs Section -->
    <section class='destination-info-section' style='padding: 60px 0; background: #fdfdfd;'>
        <div class='container'>
            <div class='row' style='display: flex; flex-wrap: wrap; gap: 40px;'>
                
                <!-- Places to Visit -->
                <div class='col-md-6' style='flex: 1; min-width: 300px;'>
                    <div class='info-box glass-panel' style='background: white; padding: 30px; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); border-top: 4px solid #D4AF37; height: 100%;'>
                        <h3 style='font-size: 1.8rem; color: #1e293b; margin-bottom: 20px; font-weight: 800;'><i class='fas fa-map-marked-alt' style='color: #D4AF37; margin-right: 10px;'></i> Top Places to Visit in Uttarakhand Urbania</h3>
                        <ul style='list-style: none; padding: 0;'>
                            <li style='margin-bottom: 15px; padding-bottom: 15px; border-bottom: 1px solid #f1f5f9;'>
                                <strong style='color: #1e7a44; font-size: 1.1rem;'><i class='fas fa-check-circle' style='margin-right: 8px;'></i>Uttarakhand Urbania City Center</strong>
                                <p style='color: #4a5568; margin-top: 5px; font-size: 0.95rem; margin-bottom: 0;'>Experience the local culture and vibrant markets.</p>
                            </li>
                            <li style='margin-bottom: 15px; padding-bottom: 15px; border-bottom: 1px solid #f1f5f9;'>
                                <strong style='color: #1e7a44; font-size: 1.1rem;'><i class='fas fa-check-circle' style='margin-right: 8px;'></i>Historical Monuments</strong>
                                <p style='color: #4a5568; margin-top: 5px; font-size: 0.95rem; margin-bottom: 0;'>Explore the rich heritage of the region.</p>
                            </li>
                            <li style='margin-bottom: 15px; padding-bottom: 15px; border-bottom: 1px solid #f1f5f9;'>
                                <strong style='color: #1e7a44; font-size: 1.1rem;'><i class='fas fa-check-circle' style='margin-right: 8px;'></i>Scenic Spots</strong>
                                <p style='color: #4a5568; margin-top: 5px; font-size: 0.95rem; margin-bottom: 0;'>Perfect for photography and relaxation.</p>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- FAQs -->
                <div class='col-md-6' style='flex: 1; min-width: 300px;'>
                    <div class='info-box glass-panel' style='background: white; padding: 30px; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); border-top: 4px solid #1e7a44; height: 100%;'>
                        <h3 style='font-size: 1.8rem; color: #1e293b; margin-bottom: 20px; font-weight: 800;'><i class='fas fa-question-circle' style='color: #1e7a44; margin-right: 10px;'></i> Frequently Asked Questions</h3>
                        <div class='faqs-container'>
                            <div class='faq-item' style='margin-bottom: 20px;'>
                                <h4 style='font-size: 1.05rem; color: #1e293b; font-weight: 700; margin-bottom: 8px;'><i class='fas fa-angle-right' style='color: #D4AF37; margin-right: 5px;'></i> What is the ideal duration for a trip to Uttarakhand Urbania?</h4>
                                <p style='color: #4a5568; font-size: 0.95rem; margin-bottom: 0; padding-left: 15px; border-left: 2px solid #e2e8f0;'>A trip of 3 to 5 days is highly recommended to comfortably explore all major attractions.</p>
                            </div>
                            <div class='faq-item' style='margin-bottom: 20px;'>
                                <h4 style='font-size: 1.05rem; color: #1e293b; font-weight: 700; margin-bottom: 8px;'><i class='fas fa-angle-right' style='color: #D4AF37; margin-right: 5px;'></i> Are the Urbania vehicles equipped with AC and WiFi?</h4>
                                <p style='color: #4a5568; font-size: 0.95rem; margin-bottom: 0; padding-left: 15px; border-left: 2px solid #e2e8f0;'>Yes, all our premium Urbania vans come with Dual AC, pushback luxury seats, and modern amenities.</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="tour-cta">
        <div class="container">
            <h2>Ready to explore Devbhoomi?</h2>
            <div style="display: flex; gap: 20px; justify-content: center; flex-wrap: wrap;">
                <a href="contact.php" class="btn btn-primary" style="padding: 15px 40px; font-size: 1.1rem; border-radius: 30px; font-weight: 700;"><i class="fas fa-paper-plane"></i> Get Custom Quote</a>
                <a href="tel:+917290885949" class="btn btn-outline-dark" style="padding: 15px 40px; font-size: 1.1rem; border-radius: 30px; font-weight: 700; border: 2px solid #1a202c;"><i class="fas fa-phone-alt"></i> Call Now</a>
            </div>
        </div>
    </section>

        
    <!-- SEO Keywords Highlights Box -->
    <section class="seo-highlights-section" style="padding: 40px 0; background: #ffffff; border-top: 1px solid #e2e8f0;">
        <div class="container">
            <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 16px; padding: 30px; box-shadow: 0 4px 20px rgba(0,0,0,0.03);">
                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 15px;">
                    <i class="fas fa-crown" style="color: #D4AF37; font-size: 1.3rem;"></i>
                    <h3 style="font-size: 1.25rem; color: #0f172a; margin: 0; font-weight: 700;">Uttarakhand Devbhoomi Tour - Luxury Force Urbania Tour Rental</h3>
                </div>
                <p style="color: #64748b; font-size: 0.95rem; line-height: 1.7; margin-bottom: 20px;">
                    Experience the ultimate in group luxury travel with our customized <strong>Uttarakhand Devbhoomi Tour</strong>. We offer sanitized <strong>9, 12 & 16 seater Force Urbania on rent in Delhi</strong> equipped with pushback leather seats, panoramic windows, ambient lighting, and expert mountain/highway chauffeurs.
                </p>
                <div style="display: flex; flex-wrap: wrap; gap: 8px;">
                    <span class="seo-badge-tag"><i class="fas fa-tag"></i> <strong>luxury Force Urbania on rent in delhi</strong></span>
                    <span class="seo-badge-tag"><i class="fas fa-tag"></i> <strong>Urbania for group tour in delhi</strong></span>
                    <span class="seo-badge-tag"><i class="fas fa-tag"></i> <strong>Urbania for outstation in delhi</strong></span>
                    <span class="seo-badge-tag"><i class="fas fa-tag"></i> <strong>12 seater urbania hire delhi</strong></span>
                    <span class="seo-badge-tag"><i class="fas fa-tag"></i> <strong>16 seater urbania rental delhi</strong></span>
                    <span class="seo-badge-tag"><i class="fas fa-tag"></i> <strong>Urbania booking in delhi</strong></span>
                    <span class="seo-badge-tag"><i class="fas fa-tag"></i> <strong>Urbania rental delhi ncr</strong></span>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include 'footer.php'; ?>
