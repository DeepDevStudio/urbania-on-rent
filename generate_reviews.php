<?php
$names = ["Rahul Sharma", "Priya Patel", "Amit Kumar", "Neha Singh", "Vikram Malhotra", "Anjali Desai", "Rohan Gupta", "Sneha Reddy", "Aditya Verma", "Pooja Joshi", "Karan Singh", "Riya Kapoor", "Deepak Nair", "Swati Mishra", "Arjun Bhatia", "Kritika Agarwal", "Manish Tiwari", "Divya Menon", "Suresh Pillai", "Aarti Chawla", "Rajesh Khanna", "Sonal Jain", "Nitin Garg", "Megha Rao", "Vivek Anand", "Tara Iyer", "Gaurav Mehta", "Shruti Pandey", "Tarun Bajaj", "Kiran Ahuja", "Ashish Saxena", "Nisha Thakur", "Prateek Sinha", "Bhavna Chaudhary", "Harish Kadam", "Pallavi Rathi", "Sunil Dutta", "Kavita Rangan", "Manoj Dubey", "Simran Kaur"];
$locations = ["Delhi", "Mumbai", "Noida", "Jaipur", "Gurugram", "Ahmedabad", "Pune", "Bengaluru", "Chennai", "Kolkata", "Chandigarh", "Lucknow", "Indore", "Bhopal", "Surat", "Patna", "Kanpur", "Nagpur", "Agra", "Varanasi"];
$feedbacks = [
    "The Urbania was spotless and very luxurious. Highly recommend!",
    "Excellent service! The driver was professional and punctual.",
    "On-time, clean, and comfortable. My family loved the ambient lighting.",
    "Amazing experience! Perfect for our group transportation.",
    "Best luxury van rental in Delhi! Great value for money.",
    "Reliable and luxurious. The driver knew all the best routes.",
    "Superb experience from booking to the actual journey.",
    "The vehicle was in pristine condition. Highly satisfied.",
    "Very comfortable ride, especially for long distances.",
    "The 12-seater Urbania had ample space and great AC.",
    "Professional behavior from the staff. Will book again.",
    "Smooth and bump-free ride. The seats are very comfortable.",
    "Affordable luxury! Best way to travel with a big family.",
    "The entertainment system kept the kids busy throughout.",
    "Five-star service all the way. Kudos to the team!",
    "Punctual pickup and drop. Very reliable service.",
    "The driver was polite and drove safely. Felt very secure.",
    "Highly spacious and luxurious interior. Loved the trip.",
    "Great customer support and easy booking process.",
    "Exceeded our expectations in every way. Thank you!"
];

$reviews = [];
for ($i = 0; $i < 40; $i++) {
    $name = $names[$i % count($names)];
    $location = $locations[array_rand($locations)] . ", India";
    $feedback = $feedbacks[array_rand($feedbacks)];
    $gender = ($i % 2 == 0) ? "men" : "women";
    $imgNum = rand(1, 60);
    $img = "https://randomuser.me/api/portraits/$gender/$imgNum.jpg";
    $date = rand(1, 30) . " days ago";
    $featured = (rand(0, 5) == 0) ? ' featured' : '';
    
    $reviews[] = [
        'name' => $name,
        'location' => $location,
        'quote' => $feedback,
        'image' => $img,
        'date' => $date,
        'featured' => $featured
    ];
}

$phpArray = "<?php\n\$testimonials = [\n";
foreach ($reviews as $r) {
    $phpArray .= "    [\n";
    $phpArray .= "        'name' => '" . addslashes($r['name']) . "',\n";
    $phpArray .= "        'location' => '" . addslashes($r['location']) . "',\n";
    $phpArray .= "        'quote' => '" . addslashes($r['quote']) . "',\n";
    $phpArray .= "        'image' => '" . addslashes($r['image']) . "',\n";
    $phpArray .= "        'date' => '" . addslashes($r['date']) . "',\n";
    $phpArray .= "        'featured' => '" . addslashes($r['featured']) . "'\n";
    $phpArray .= "    ],\n";
}
$phpArray .= "];\n?>\n";

// Now, replace the static HTML in testimonials.php with a loop
$file = 'testimonials.php';
$content = file_get_contents($file);

// Find the start of the grid
$startToken = '<div class="testimonials-grid">';
$endToken = '<!-- Share Experience CTA -->';

$startPos = strpos($content, $startToken);
$endPos = strpos($content, $endToken);

if ($startPos !== false && $endPos !== false) {
    $before = substr($content, 0, $startPos + strlen($startToken));
    $after = substr($content, $endPos);
    
    $loop = "
            <?php 
            \$seo_alt_keywords = [
                'Urbania on Rent',
                'Urbania on Rent in Delhi',
                'Urbania Rental in Delhi',
                'Urbania Hire in Delhi',
                'Urbania Booking Delhi',
                'Force Urbania on Rent Delhi',
                'Luxury Urbania on Rent Delhi',
                'Urbania Traveller on Rent Delhi',
                'Urbania Van on Rent Delhi'
            ];
            ?>
            <div class=\"testimonials-grid\">
                <?php foreach(\$testimonials as \$index => \$t): ?>
                <div class=\"testimonial-card<?php echo \$t['featured']; ?>\">
                    <div class=\"card-header\">
                        <div class=\"testimonial-rating\">
                            <i class=\"fas fa-star\"></i>
                            <i class=\"fas fa-star\"></i>
                            <i class=\"fas fa-star\"></i>
                            <i class=\"fas fa-star\"></i>
                            <i class=\"fas fa-star\"></i>
                        </div>
                        <div class=\"testimonial-date\">
                            <i class=\"far fa-calendar-alt\"></i> <?php echo \$t['date']; ?>
                        </div>
                    </div>
                    <div class=\"testimonial-quote\">
                        <p>\"<?php echo htmlspecialchars(\$t['quote']); ?>\"</p>
                    </div>
                    <div class=\"testimonial-author\">
                        <img src=\"<?php echo \$t['image']; ?>\" alt=\"Verified client portrait - <?php echo htmlspecialchars(\$t['name']); ?>\">
                        <div class=\"author-info\">
                            <h5><?php echo htmlspecialchars(\$t['name']); ?></h5>
                            <span><i class=\"fas fa-map-marker-alt\"></i> <?php echo htmlspecialchars(\$t['location']); ?></span>
                            <span class=\"verification\"><i class=\"fas fa-check-circle\"></i> Verified</span>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>";
            
    // Add the array at the very top of the file
    $content = str_replace("<?php", $phpArray, $before . "\n" . $loop . $after);
    
    file_put_contents($file, $content);
    echo "Successfully updated testimonials.php with 40 dynamic reviews.\n";
} else {
    echo "Could not find insertion points.\n";
}
?>
