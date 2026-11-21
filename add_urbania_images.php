<?php
$files = glob("*.php");
$updatedCount = 0;

foreach ($files as $file) {
    if ($file == 'header.php' || $file == 'footer.php' || $file == 'index.php' || $file == 'fleet.php' || $file == 'services.php' || $file == 'contact.php') {
        continue;
    }

    $content = file_get_contents($file);
    
    // Check if it has pricing cards
    if (strpos($content, '<h3>9 Seater Urbania</h3>
                        <img src="images/urbania-1.webp" alt="9 seater Force Urbania Maharaja on rent in Delhi NCR – luxury Urbania with driver for family & VIP trips" style="width: 100%; height: 160px; object-fit: cover; border-radius: 12px; margin-bottom: 20px; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">') === false) {
        continue;
    }

    // Replace 9 Seater
    $search9 = '<h3>9 Seater Urbania</h3>
                        <img src="images/urbania-1.webp" alt="9 seater Force Urbania Maharaja on rent in Delhi NCR – luxury Urbania with driver for family & VIP trips" style="width: 100%; height: 160px; object-fit: cover; border-radius: 12px; margin-bottom: 20px; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">';
    $replace9 = '<h3>9 Seater Urbania</h3>
                        <img src="images/urbania-1.webp" alt="9 seater Force Urbania Maharaja on rent in Delhi NCR – luxury Urbania with driver for family & VIP trips" style="width: 100%; height: 160px; object-fit: cover; border-radius: 12px; margin-bottom: 20px; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">' . "\n" . '                        <img src="images/urbania-1.webp" alt="9 seater Force Urbania Maharaja on rent in Delhi NCR – luxury Urbania with driver for family & VIP trips" style="width: 100%; height: 160px; object-fit: cover; border-radius: 12px; margin-bottom: 20px; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">';
    
    // Replace 12 Seater
    $search12 = '<h3>12 Seater Urbania</h3>
                        <img src="images/urbania-3.avif" alt="12 seater Force Urbania Maharaja on rent in Delhi NCR – luxury Urbania with driver for weddings & corporate tours" style="width: 100%; height: 160px; object-fit: cover; border-radius: 12px; margin-bottom: 20px; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">';
    $replace12 = '<h3>12 Seater Urbania</h3>
                        <img src="images/urbania-3.avif" alt="12 seater Force Urbania Maharaja on rent in Delhi NCR – luxury Urbania with driver for weddings & corporate tours" style="width: 100%; height: 160px; object-fit: cover; border-radius: 12px; margin-bottom: 20px; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">' . "\n" . '                        <img src="images/urbania-3.avif" alt="12 seater Force Urbania Maharaja on rent in Delhi NCR – luxury Urbania with driver for weddings & corporate tours" style="width: 100%; height: 160px; object-fit: cover; border-radius: 12px; margin-bottom: 20px; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">';
    
    // Replace 16 Seater
    $search16 = '<h3>16 Seater Urbania</h3>
                        <img src="images/urbania-5.webp" alt="16 seater Force Urbania on rent in Delhi NCR with 2x1 pushback seats – best Urbania tempo traveller for group tours" style="width: 100%; height: 160px; object-fit: cover; border-radius: 12px; margin-bottom: 20px; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">';
    $replace16 = '<h3>16 Seater Urbania</h3>
                        <img src="images/urbania-5.webp" alt="16 seater Force Urbania on rent in Delhi NCR with 2x1 pushback seats – best Urbania tempo traveller for group tours" style="width: 100%; height: 160px; object-fit: cover; border-radius: 12px; margin-bottom: 20px; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">' . "\n" . '                        <img src="images/urbania-5.webp" alt="16 seater Force Urbania on rent in Delhi NCR with 2x1 pushback seats – best Urbania tempo traveller for group tours" style="width: 100%; height: 160px; object-fit: cover; border-radius: 12px; margin-bottom: 20px; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">';

    $newContent = str_replace([$search9, $search12, $search16], [$replace9, $replace12, $replace16], $content);
    
    if ($content !== $newContent) {
        file_put_contents($file, $newContent);
        echo "Updated $file\n";
        $updatedCount++;
    }
}

echo "Total updated: $updatedCount\n";
?>
