<?php

$packages = [
    'char-dham-urbania-package.php' => ['1,44,000', '1,44,000', '1,32,000'],
    'himachal-urbania-package.php' => ['66,000', '66,000', '60,000'],
    'kashmir-urbania-package.php' => ['80,000', '80,000', '75,000'],
    'leh-ladakh-urbania-package.php' => ['1,44,000', '1,44,000', '1,32,000'],
    'rajasthan-urbania-package.php' => ['88,000', '88,000', '80,000'],
    'uttarakhand-urbania-package.php' => ['77,000', '77,000', '70,000'],
    'golden-triangle-urbania-package.php' => ['66,000', '66,000', '60,000'],
    'wildlife-urbania-package.php' => ['33,000', '33,000', '30,000'],
    'pilgrimage-urbania-package.php' => ['88,000', '88,000', '80,000']
];

$html_template = <<<HTML
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
                    <div class="price" style="font-size: 2.5rem; font-weight: 800; color: #1a202c; margin-bottom: 20px;">₹[9S_PRICE]</div>
                    <ul style="list-style: none; padding: 0; margin-bottom: 30px; color: #4a5568; text-align: left;">
                        <li style="margin-bottom: 10px;"><i class="fas fa-check" style="color: #00a388; margin-right: 10px;"></i> Professional Driver</li>
                        <li style="margin-bottom: 10px;"><i class="fas fa-check" style="color: #00a388; margin-right: 10px;"></i> Toll & State Taxes Included</li>
                        <li style="margin-bottom: 10px;"><i class="fas fa-check" style="color: #00a388; margin-right: 10px;"></i> Fuel Included</li>
                    </ul>
                    <a href="contact.php" class="btn btn-outline-dark" style="width: 100%; border-radius: 30px; font-weight: 700; padding: 12px; border: 2px solid #1a202c; text-decoration: none; color: #1a202c; display: inline-block;">Book Now</a>
                </div>
                <!-- 12 Seater -->
                <div class="pricing-card" style="background: white; border-radius: 20px; padding: 40px; text-align: center; box-shadow: 0 15px 40px rgba(0,0,0,0.08); border-top: 5px solid #D4AF37; transform: scale(1.05); position: relative; z-index: 2;">
                    <div style="position: absolute; top: -15px; left: 50%; transform: translateX(-50%); background: #D4AF37; color: white; padding: 5px 15px; border-radius: 20px; font-size: 0.85rem; font-weight: 700;">MOST POPULAR</div>
                    <h3 style="font-size: 1.5rem; color: #2d3748; margin-bottom: 15px;">12 Seater Urbania</h3>
                    <div class="price" style="font-size: 2.5rem; font-weight: 800; color: #1a202c; margin-bottom: 20px;">₹[12S_PRICE]</div>
                    <ul style="list-style: none; padding: 0; margin-bottom: 30px; color: #4a5568; text-align: left;">
                        <li style="margin-bottom: 10px;"><i class="fas fa-check" style="color: #D4AF37; margin-right: 10px;"></i> Professional Driver</li>
                        <li style="margin-bottom: 10px;"><i class="fas fa-check" style="color: #D4AF37; margin-right: 10px;"></i> Toll & State Taxes Included</li>
                        <li style="margin-bottom: 10px;"><i class="fas fa-check" style="color: #D4AF37; margin-right: 10px;"></i> Fuel Included</li>
                    </ul>
                    <a href="contact.php" class="btn btn-primary" style="width: 100%; border-radius: 30px; font-weight: 700; padding: 12px; background: #1a202c; color: white; text-decoration: none; display: inline-block;">Book Now</a>
                </div>
                <!-- 16 Seater -->
                <div class="pricing-card" style="background: white; border-radius: 20px; padding: 40px; text-align: center; box-shadow: 0 10px 30px rgba(0,0,0,0.05); border-top: 5px solid #1e7a44; transition: transform 0.3s ease;">
                    <h3 style="font-size: 1.5rem; color: #2d3748; margin-bottom: 15px;">16 Seater Urbania</h3>
                    <div class="price" style="font-size: 2.5rem; font-weight: 800; color: #1a202c; margin-bottom: 20px;">₹[16S_PRICE]</div>
                    <ul style="list-style: none; padding: 0; margin-bottom: 30px; color: #4a5568; text-align: left;">
                        <li style="margin-bottom: 10px;"><i class="fas fa-check" style="color: #1e7a44; margin-right: 10px;"></i> Professional Driver</li>
                        <li style="margin-bottom: 10px;"><i class="fas fa-check" style="color: #1e7a44; margin-right: 10px;"></i> Toll & State Taxes Included</li>
                        <li style="margin-bottom: 10px;"><i class="fas fa-check" style="color: #1e7a44; margin-right: 10px;"></i> Fuel Included</li>
                    </ul>
                    <a href="contact.php" class="btn btn-outline-dark" style="width: 100%; border-radius: 30px; font-weight: 700; padding: 12px; border: 2px solid #1a202c; text-decoration: none; color: #1a202c; display: inline-block;">Book Now</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Top Places & FAQs Section -->
HTML;

foreach ($packages as $file => $prices) {
    if (!file_exists($file)) {
        echo "File not found: $file\n";
        continue;
    }
    
    $content = file_get_contents($file);
    
    // Check if we already added it
    if (strpos($content, '<!-- Pricing Section -->') !== false) {
        echo "Pricing section already exists in $file\n";
        continue;
    }

    $replacement = str_replace(['[9S_PRICE]', '[12S_PRICE]', '[16S_PRICE]'], $prices, $html_template);
    
    // Most files have the <!-- Top Places & FAQs Section --> tag.
    $new_content = str_replace('    <!-- Top Places & FAQs Section -->', $replacement, $content);
    
    if ($content !== $new_content) {
        file_put_contents($file, $new_content);
        echo "Updated $file successfully.\n";
    } else {
        echo "Failed to find anchor tag in $file.\n";
    }
}
?>
