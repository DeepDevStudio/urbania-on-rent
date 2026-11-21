<?php

$dir = 'c:\xampp\htdocs\Urbaniaonrentdelhi';
$files = glob($dir . '\*.php');

$whatsapp_url = 'https://wa.me/917290885949';

foreach ($files as $file) {
    if (basename($file) === 'update_pages.php' || basename($file) === 'update_whatsapp.php') continue;
    
    $content = file_get_contents($file);
    
    // We will use regex to find anchor tags with href="contact.php" and text containing "Book"
    // e.g. <a href="contact.php" class="btn btn-primary">Book Now</a>
    // We only want to replace the href part if the inner text contains "Book"
    
    $pattern = '/<a\s+([^>]*?)href=["\']contact\.php["\']([^>]*?)>(.*?)Book(.*?)(<\/a>)/i';
    
    $new_content = preg_replace_callback($pattern, function($matches) use ($whatsapp_url) {
        $before_href = $matches[1];
        $after_href = $matches[2];
        $inner_text1 = $matches[3];
        $inner_text2 = $matches[4];
        $close_tag = $matches[5];
        
        return '<a ' . $before_href . 'href="' . $whatsapp_url . '"' . $after_href . '>' . $inner_text1 . 'Book' . $inner_text2 . $close_tag;
    }, $content);
    
    if ($content !== $new_content) {
        file_put_contents($file, $new_content);
        echo "Updated Book buttons in " . basename($file) . "\n";
    }
}
?>
