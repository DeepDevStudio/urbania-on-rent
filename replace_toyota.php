<?php

$dir = 'c:/xampp/htdocs/Urbaniaonrentdelhi';
$files = scandir($dir);

foreach ($files as $file) {
    if (pathinfo($file, PATHINFO_EXTENSION) === 'php') {
        $path = $dir . '/' . $file;
        $content = file_get_contents($path);
        
        $new_content = str_ireplace('Force Urbania', 'Force Urbania', $content);
        
        if ($new_content !== $content) {
            file_put_contents($path, $new_content);
            echo "Updated $file\n";
        }
    }
}
echo "Done.\n";
?>
