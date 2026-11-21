<?php

$dir = 'c:/xampp/htdocs/Urbaniaonrentdelhi';

$files = scandir($dir);
$skip_files = ['header.php', 'footer.php', 'about.php', 'contact.php', 'services.php', 'fleet.php', 'testimonials.php', 'add_urbania_images.php', 'generate_reviews.php', 'cleanup_css.php', 'theme_update.php', 'update_pages.php', 'update_whatsapp.php', 'update_seo_keywords.php'];

$seo_keywords = [
    'Urbania on rent in delhi',
    'Urbania hire in delhi',
    'Urbania rental in delhi',
    'Urbania for rent in delhi',
    'Urbania booking in delhi',
    'Urbania delhi',
    'Urbania rent delhi',
    'hire Urbania in delhi',
    'Urbania rental delhi ncr',
    'luxury Urbania on rent in delhi',
    'Ac Urbania on rent in delhi',
    'Urbania with driver in delhi',
    'Urbania for outstation in delhi',
    'Urbania for group tour in delhi',
    'Urbania near me'
];

foreach ($files as $file) {
    if (pathinfo($file, PATHINFO_EXTENSION) === 'php' && !in_array($file, $skip_files)) {
        $path = $dir . '/' . $file;
        $content = file_get_contents($path);

        // 1. Remove the old SEO Keywords Section
        $pattern = '/<!-- SEO Keywords Section -->.*?<\/section>\s*/s';
        $content = preg_replace($pattern, '', $content);

        // 2. Inject keywords organically into <p> tags
        $paragraphs_modified = 0;
        
        $content = preg_replace_callback('/<p[^>]*>(.*?)<\/p>/s', function($matches) use (&$paragraphs_modified, $seo_keywords) {
            $p_text = $matches[1];
            
            if (strlen(strip_tags($p_text)) > 50 && $paragraphs_modified < 3) {
                $k1 = $seo_keywords[array_rand($seo_keywords)];
                $k2 = $seo_keywords[array_rand($seo_keywords)];
                
                $sentences = [
                    " For those looking for <strong>$k1</strong>, our services guarantee comfort and reliability.",
                    " Whether you need <strong>$k2</strong> or an outstation trip, we've got you covered.",
                    " Choose us for the most reliable <strong>$k1</strong>.",
                    " We provide premium options for <strong>$k2</strong>.",
                    " Experience the best <strong>$k1</strong> with our well-maintained vehicles."
                ];
                
                $addition = $sentences[array_rand($sentences)];
                
                $paragraphs_modified++;
                return str_replace($p_text, rtrim($p_text, '.') . '.' . $addition, $matches[0]);
            }
            return $matches[0];
        }, $content);

        $content = preg_replace('/Force Urbania/i', '<strong>luxury Urbania on rent in delhi</strong>', $content, 1);
        
        file_put_contents($path, $content);
        echo "Updated $file\n";
    }
}

foreach (['index.php', 'about.php', 'contact.php', 'services.php', 'fleet.php', 'testimonials.php'] as $file) {
    $path = $dir . '/' . $file;
    if (file_exists($path)) {
        $content = file_get_contents($path);
        
        $pattern = '/<!-- SEO Keywords Section -->.*?<\/section>\s*/s';
        $content = preg_replace($pattern, '', $content);
        
        $paragraphs_modified = 0;
        $content = preg_replace_callback('/<p[^>]*>(.*?)<\/p>/s', function($matches) use (&$paragraphs_modified, $seo_keywords) {
            $p_text = $matches[1];
            if (strlen(strip_tags($p_text)) > 50 && $paragraphs_modified < 3) {
                $k1 = $seo_keywords[array_rand($seo_keywords)];
                $addition = " If you need <strong>$k1</strong>, we offer the best in class service.";
                $paragraphs_modified++;
                return str_replace($p_text, rtrim($p_text, '.') . '.' . $addition, $matches[0]);
            }
            return $matches[0];
        }, $content);
        
        file_put_contents($path, $content);
        echo "Updated core page: $file\n";
    }
}
echo "Done.\n";
?>
