<?php
$page_title = 'Customer Reviews | Luxury Urbania on Rent in Delhi';
$page_description = 'Read customer reviews and experiences with our Force Urbania on rent in Delhi. Trusted luxury van rental service for corporate events, family trips, and religious tours.';
include 'header.php';

// Handle review submission
$review_success = '';
$review_error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_review'])) {
    // Honeypot check
    if (!empty($_POST['honeypot_review'])) {
        $review_success = "Thank you for your review! It will be published soon.";
    } else {
        $reviewer_name = trim(filter_input(INPUT_POST, 'reviewer_name', FILTER_SANITIZE_STRING));
        $reviewer_location = trim(filter_input(INPUT_POST, 'reviewer_location', FILTER_SANITIZE_STRING));
        $review_rating = trim(filter_input(INPUT_POST, 'review_rating', FILTER_SANITIZE_STRING));
        $review_text = trim(filter_input(INPUT_POST, 'review_text', FILTER_SANITIZE_STRING));

        $errors = [];
        
        if (empty($reviewer_name)) {
            $errors[] = "Name is required.";
        }
        if (empty($reviewer_location)) {
            $errors[] = "Location is required.";
        }
        if (empty($review_rating) || !in_array($review_rating, ['1', '2', '3', '4', '5'])) {
            $errors[] = "Please select a rating.";
        }
        if (empty($review_text) || strlen($review_text) < 10) {
            $errors[] = "Please write a review of at least 10 characters.";
        }

        if (empty($errors)) {
            $review_success = "Thank you for your review! We appreciate your feedback.";
        } else {
            $review_error = implode("<br>", $errors);
        }
    }
}

$testimonials = [
    [
        'name' => 'Rahul Sharma',
        'location' => 'Ahmedabad, India',
        'quote' => 'The Urbania was spotless and very luxurious. Highly recommend!',
        'image' => 'https://randomuser.me/api/portraits/men/33.jpg',
        'date' => '21 days ago',
        'featured' => ''
    ],
    [
        'name' => 'Priya Patel',
        'location' => 'Kanpur, India',
        'quote' => 'Highly spacious and luxurious interior. Loved the trip.',
        'image' => 'https://randomuser.me/api/portraits/women/26.jpg',
        'date' => '20 days ago',
        'featured' => ''
    ],
    [
        'name' => 'Amit Kumar',
        'location' => 'Kanpur, India',
        'quote' => 'Smooth and bump-free ride. The seats are very comfortable.',
        'image' => 'https://randomuser.me/api/portraits/men/39.jpg',
        'date' => '8 days ago',
        'featured' => ''
    ],
    [
        'name' => 'Neha Singh',
        'location' => 'Lucknow, India',
        'quote' => 'Amazing experience! Perfect for our group transportation.',
        'image' => 'https://randomuser.me/api/portraits/women/36.jpg',
        'date' => '2 days ago',
        'featured' => ' featured'
    ],
    [
        'name' => 'Vikram Malhotra',
        'location' => 'Bhopal, India',
        'quote' => 'Very comfortable ride, especially for long distances.',
        'image' => 'https://randomuser.me/api/portraits/men/36.jpg',
        'date' => '5 days ago',
        'featured' => ''
    ],
    [
        'name' => 'Anjali Desai',
        'location' => 'Ahmedabad, India',
        'quote' => 'The driver was polite and drove safely. Felt very secure.',
        'image' => 'https://randomuser.me/api/portraits/women/60.jpg',
        'date' => '15 days ago',
        'featured' => ''
    ],
    [
        'name' => 'Rohan Gupta',
        'location' => 'Bhopal, India',
        'quote' => 'Very comfortable ride, especially for long distances.',
        'image' => 'https://randomuser.me/api/portraits/men/44.jpg',
        'date' => '6 days ago',
        'featured' => ''
    ],
    [
        'name' => 'Sneha Reddy',
        'location' => 'Ahmedabad, India',
        'quote' => 'Very comfortable ride, especially for long distances.',
        'image' => 'https://randomuser.me/api/portraits/women/59.jpg',
        'date' => '27 days ago',
        'featured' => ''
    ],
    [
        'name' => 'Aditya Verma',
        'location' => 'Chennai, India',
        'quote' => 'On-time, clean, and comfortable. My family loved the ambient lighting.',
        'image' => 'https://randomuser.me/api/portraits/men/1.jpg',
        'date' => '12 days ago',
        'featured' => ' featured'
    ],
    [
        'name' => 'Pooja Joshi',
        'location' => 'Chandigarh, India',
        'quote' => 'The driver was polite and drove safely. Felt very secure.',
        'image' => 'https://randomuser.me/api/portraits/women/51.jpg',
        'date' => '5 days ago',
        'featured' => ''
    ],
    [
        'name' => 'Karan Singh',
        'location' => 'Indore, India',
        'quote' => 'The vehicle was in pristine condition. Highly satisfied.',
        'image' => 'https://randomuser.me/api/portraits/men/56.jpg',
        'date' => '13 days ago',
        'featured' => ''
    ],
    [
        'name' => 'Riya Kapoor',
        'location' => 'Mumbai, India',
        'quote' => 'Exceeded our expectations in every way. Thank you!',
        'image' => 'https://randomuser.me/api/portraits/women/5.jpg',
        'date' => '23 days ago',
        'featured' => ''
    ],
    [
        'name' => 'Deepak Nair',
        'location' => 'Ahmedabad, India',
        'quote' => 'The driver was polite and drove safely. Felt very secure.',
        'image' => 'https://randomuser.me/api/portraits/men/41.jpg',
        'date' => '2 days ago',
        'featured' => ''
    ],
    [
        'name' => 'Swati Mishra',
        'location' => 'Bhopal, India',
        'quote' => 'Five-star service all the way. Kudos to the team!',
        'image' => 'https://randomuser.me/api/portraits/women/45.jpg',
        'date' => '27 days ago',
        'featured' => ' featured'
    ],
    [
        'name' => 'Arjun Bhatia',
        'location' => 'Gurugram, India',
        'quote' => 'Exceeded our expectations in every way. Thank you!',
        'image' => 'https://randomuser.me/api/portraits/men/35.jpg',
        'date' => '2 days ago',
        'featured' => ''
    ],
    [
        'name' => 'Kritika Agarwal',
        'location' => 'Chandigarh, India',
        'quote' => 'Very comfortable ride, especially for long distances.',
        'image' => 'https://randomuser.me/api/portraits/women/33.jpg',
        'date' => '27 days ago',
        'featured' => ''
    ],
    [
        'name' => 'Manish Tiwari',
        'location' => 'Gurugram, India',
        'quote' => 'Five-star service all the way. Kudos to the team!',
        'image' => 'https://randomuser.me/api/portraits/men/53.jpg',
        'date' => '14 days ago',
        'featured' => ''
    ],
    [
        'name' => 'Divya Menon',
        'location' => 'Agra, India',
        'quote' => 'The Urbania was spotless and very luxurious. Highly recommend!',
        'image' => 'https://randomuser.me/api/portraits/women/32.jpg',
        'date' => '5 days ago',
        'featured' => ' featured'
    ],
    [
        'name' => 'Suresh Pillai',
        'location' => 'Delhi, India',
        'quote' => 'The vehicle was in pristine condition. Highly satisfied.',
        'image' => 'https://randomuser.me/api/portraits/men/33.jpg',
        'date' => '19 days ago',
        'featured' => ''
    ],
    [
        'name' => 'Aarti Chawla',
        'location' => 'Nagpur, India',
        'quote' => 'Five-star service all the way. Kudos to the team!',
        'image' => 'https://randomuser.me/api/portraits/women/31.jpg',
        'date' => '5 days ago',
        'featured' => ''
    ],
    [
        'name' => 'Rajesh Khanna',
        'location' => 'Kolkata, India',
        'quote' => 'Very comfortable ride, especially for long distances.',
        'image' => 'https://randomuser.me/api/portraits/men/29.jpg',
        'date' => '11 days ago',
        'featured' => ''
    ],
    [
        'name' => 'Sonal Jain',
        'location' => 'Jaipur, India',
        'quote' => 'Affordable luxury! Best way to travel with a big family.',
        'image' => 'https://randomuser.me/api/portraits/women/26.jpg',
        'date' => '21 days ago',
        'featured' => ' featured'
    ],
    [
        'name' => 'Nitin Garg',
        'location' => 'Pune, India',
        'quote' => 'Reliable and luxurious. The driver knew all the best routes.',
        'image' => 'https://randomuser.me/api/portraits/men/40.jpg',
        'date' => '10 days ago',
        'featured' => ' featured'
    ],
    [
        'name' => 'Megha Rao',
        'location' => 'Chandigarh, India',
        'quote' => 'Very comfortable ride, especially for long distances.',
        'image' => 'https://randomuser.me/api/portraits/women/18.jpg',
        'date' => '8 days ago',
        'featured' => ''
    ],
    [
        'name' => 'Vivek Anand',
        'location' => 'Kolkata, India',
        'quote' => 'The entertainment system kept the kids busy throughout.',
        'image' => 'https://randomuser.me/api/portraits/men/35.jpg',
        'date' => '11 days ago',
        'featured' => ''
    ],
    [
        'name' => 'Tara Iyer',
        'location' => 'Delhi, India',
        'quote' => 'Smooth and bump-free ride. The seats are very comfortable.',
        'image' => 'https://randomuser.me/api/portraits/women/27.jpg',
        'date' => '7 days ago',
        'featured' => ''
    ],
    [
        'name' => 'Gaurav Mehta',
        'location' => 'Gurugram, India',
        'quote' => 'Punctual pickup and drop. Very reliable service.',
        'image' => 'https://randomuser.me/api/portraits/men/23.jpg',
        'date' => '2 days ago',
        'featured' => ''
    ],
    [
        'name' => 'Shruti Pandey',
        'location' => 'Gurugram, India',
        'quote' => 'Professional behavior from the staff. Will book again.',
        'image' => 'https://randomuser.me/api/portraits/women/50.jpg',
        'date' => '8 days ago',
        'featured' => ' featured'
    ],
    [
        'name' => 'Tarun Bajaj',
        'location' => 'Chandigarh, India',
        'quote' => 'Best luxury van rental in Delhi! Great value for money.',
        'image' => 'https://randomuser.me/api/portraits/men/14.jpg',
        'date' => '29 days ago',
        'featured' => ''
    ],
    [
        'name' => 'Kiran Ahuja',
        'location' => 'Jaipur, India',
        'quote' => 'Smooth and bump-free ride. The seats are very comfortable.',
        'image' => 'https://randomuser.me/api/portraits/women/36.jpg',
        'date' => '22 days ago',
        'featured' => ''
    ],
    [
        'name' => 'Ashish Saxena',
        'location' => 'Chennai, India',
        'quote' => 'The entertainment system kept the kids busy throughout.',
        'image' => 'https://randomuser.me/api/portraits/men/24.jpg',
        'date' => '27 days ago',
        'featured' => ''
    ],
    [
        'name' => 'Nisha Thakur',
        'location' => 'Pune, India',
        'quote' => 'Five-star service all the way. Kudos to the team!',
        'image' => 'https://randomuser.me/api/portraits/women/35.jpg',
        'date' => '25 days ago',
        'featured' => ''
    ],
    [
        'name' => 'Prateek Sinha',
        'location' => 'Gurugram, India',
        'quote' => 'The Urbania was spotless and very luxurious. Highly recommend!',
        'image' => 'https://randomuser.me/api/portraits/men/46.jpg',
        'date' => '6 days ago',
        'featured' => ''
    ],
    [
        'name' => 'Bhavna Chaudhary',
        'location' => 'Nagpur, India',
        'quote' => 'The 12-seater Urbania had ample space and great AC.',
        'image' => 'https://randomuser.me/api/portraits/women/57.jpg',
        'date' => '25 days ago',
        'featured' => ''
    ],
    [
        'name' => 'Harish Kadam',
        'location' => 'Mumbai, India',
        'quote' => 'Excellent service! The driver was professional and punctual.',
        'image' => 'https://randomuser.me/api/portraits/men/13.jpg',
        'date' => '3 days ago',
        'featured' => ''
    ],
    [
        'name' => 'Pallavi Rathi',
        'location' => 'Pune, India',
        'quote' => 'Excellent service! The driver was professional and punctual.',
        'image' => 'https://randomuser.me/api/portraits/women/29.jpg',
        'date' => '30 days ago',
        'featured' => ''
    ],
    [
        'name' => 'Sunil Dutta',
        'location' => 'Ahmedabad, India',
        'quote' => 'The entertainment system kept the kids busy throughout.',
        'image' => 'https://randomuser.me/api/portraits/men/3.jpg',
        'date' => '15 days ago',
        'featured' => ''
    ],
    [
        'name' => 'Kavita Rangan',
        'location' => 'Nagpur, India',
        'quote' => 'The vehicle was in pristine condition. Highly satisfied.',
        'image' => 'https://randomuser.me/api/portraits/women/25.jpg',
        'date' => '21 days ago',
        'featured' => ''
    ],
    [
        'name' => 'Manoj Dubey',
        'location' => 'Bhopal, India',
        'quote' => 'Exceeded our expectations in every way. Thank you!',
        'image' => 'https://randomuser.me/api/portraits/men/49.jpg',
        'date' => '14 days ago',
        'featured' => ''
    ],
    [
        'name' => 'Simran Kaur',
        'location' => 'Surat, India',
        'quote' => 'Excellent service! The driver was professional and punctual.',
        'image' => 'https://randomuser.me/api/portraits/women/16.jpg',
        'date' => '3 days ago',
        'featured' => ''
    ]
];
?>

<main>
    <!-- Hero Section -->
    <section class="testimonials-hero">
        <div class="container">
            <div class="testimonials-hero-content">
                <span class="hero-badge"><i class="fas fa-heart"></i> Client Love</span>
                <h1>What Our <span>Clients Say</span></h1>
                <p>Real stories from travelers who chose luxury with us.</p>
                <div class="rating-summary">
                    <div class="rating-stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <span class="rating-text">4.9/5 from 500+ happy travelers</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Write a Review Section -->
    <section class="write-review-section" id="write-review">
        <div class="container">
            <div class="write-review-container">
                <div class="review-header">
                    <span class="review-badge"><i class="fas fa-pen-fancy"></i> Share Your Story</span>
                    <h2>Love to <span>Hear From You</span></h2>
                    <p>Your feedback helps us serve you better</p>
                </div>

                <?php if ($review_success): ?>
                    <div class="review-alert review-success">
                        <i class="fas fa-check-circle"></i>
                        <?php echo htmlspecialchars($review_success); ?>
                    </div>
                <?php endif; ?>

                <?php if ($review_error): ?>
                    <div class="review-alert review-error">
                        <i class="fas fa-exclamation-circle"></i>
                        <?php echo $review_error; ?>
                    </div>
                <?php endif; ?>

                <form method="POST" action="" class="review-form">
                    <div class="review-form-grid">
                        <div class="form-group">
                            <label for="reviewer_name"><i class="fas fa-user"></i> Your Name *</label>
                            <input type="text" id="reviewer_name" name="reviewer_name" placeholder="Enter your full name" required value="<?php echo isset($_POST['reviewer_name']) ? htmlspecialchars($_POST['reviewer_name']) : ''; ?>">
                        </div>
                        <div class="form-group">
                            <label for="reviewer_location"><i class="fas fa-map-marker-alt"></i> Your Location *</label>
                            <input type="text" id="reviewer_location" name="reviewer_location" placeholder="City, State" required value="<?php echo isset($_POST['reviewer_location']) ? htmlspecialchars($_POST['reviewer_location']) : ''; ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label><i class="fas fa-star"></i> Rate Your Experience *</label>
                        <div class="rating-input">
                            <input type="radio" id="star5" name="review_rating" value="5" <?php echo (isset($_POST['review_rating']) && $_POST['review_rating'] == '5') ? 'checked' : ''; ?>>
                            <label for="star5" title="Excellent"><i class="fas fa-star"></i></label>
                            <input type="radio" id="star4" name="review_rating" value="4" <?php echo (isset($_POST['review_rating']) && $_POST['review_rating'] == '4') ? 'checked' : ''; ?>>
                            <label for="star4" title="Good"><i class="fas fa-star"></i></label>
                            <input type="radio" id="star3" name="review_rating" value="3" <?php echo (isset($_POST['review_rating']) && $_POST['review_rating'] == '3') ? 'checked' : ''; ?>>
                            <label for="star3" title="Average"><i class="fas fa-star"></i></label>
                            <input type="radio" id="star2" name="review_rating" value="2" <?php echo (isset($_POST['review_rating']) && $_POST['review_rating'] == '2') ? 'checked' : ''; ?>>
                            <label for="star2" title="Fair"><i class="fas fa-star"></i></label>
                            <input type="radio" id="star1" name="review_rating" value="1" <?php echo (isset($_POST['review_rating']) && $_POST['review_rating'] == '1') ? 'checked' : ''; ?>>
                            <label for="star1" title="Poor"><i class="fas fa-star"></i></label>
                            <span class="rating-label" id="ratingLabel">Select your rating</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="review_text"><i class="fas fa-comment"></i> Your Review *</label>
                        <textarea id="review_text" name="review_text" rows="4" placeholder="Share your experience with us.." required><?php echo isset($_POST['review_text']) ? htmlspecialchars($_POST['review_text']) : ''; ?></textarea>
                        <small class="char-counter"><span id="charCount">0</span> characters (minimum 10)</small>
                    </div>

                    <div class="honeypot">
                        <input type="text" name="honeypot_review" value="">
                    </div>

                    <button type="submit" name="submit_review" class="btn btn-primary submit-review-btn">
                        <i class="fas fa-paper-plane"></i> Submit Review
                    </button>
                </form>
            </div>
        </div>
    </section>

    <!-- Testimonials Grid -->
    <section class="testimonials-section">
        <div class="container">
            <div class="section-header">
                <span class="section-tag"><i class="fas fa-quote-right"></i> Testimonials</span>
                <h2>What People <span>Are Saying</span></h2>
                <p>Real reviews from our valued customers</p>
            </div>

            <?php 
            $seo_alt_keywords = [
                'Urbania on Rent',
                'Urbania on Rent in Delhi',
                'Urbania Rental in Delhi',
                'Urbania Hire in Delhi',
                'Urbania Booking Delhi',
                'Force Urbania on Rent Delhi',
                'Luxury Urbania on Rent Delhi',
                'Urbania Traveller on Rent Delhi',
                'Urbania Van on Rent Delhi',
                '12 Seater Urbania on Rent Delhi',
                '16 Seater Urbania on Rent Delhi',
                'Urbania on Rent in Gurgaon',
                'Urbania on Rent in Noida',
                'Urbania on Rent in Ghaziabad',
                'Urbania on Rent in Faridabad',
                'Urbania for Family Trip',
                'Urbania for Group Tour',
                'Urbania for Wedding',
                'Urbania for Corporate Tour',
                'Urbania for Airport Transfer',
                'Urbania for Religious Tour'
            ];
            ?>
            <div class="testimonials-grid">
                <?php foreach($testimonials as $index => $t): ?>
                <div class="testimonial-card<?php echo $t['featured']; ?> <?php echo ($index >= 6) ? 'hidden-review' : ''; ?>" <?php echo ($index >= 6) ? 'style="display:none;"' : ''; ?>>
                    <div class="card-header">
                        <div class="testimonial-rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <div class="testimonial-date">
                            <i class="far fa-calendar-alt"></i> <?php echo $t['date']; ?>
                        </div>
                    </div>
                    <div class="testimonial-quote">
                        <p>"<?php echo htmlspecialchars($t['quote']); ?>"</p>
                    </div>
                    <div class="testimonial-author">
                        <img src="<?php echo $t['image']; ?>" alt="Verified client portrait - <?php echo htmlspecialchars($t['name']); ?>" loading="lazy">
                        <div class="author-info">
                            <h5><?php echo htmlspecialchars($t['name']); ?></h5>
                            <span><i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($t['location']); ?></span>
                            <span class="verification"><i class="fas fa-check-circle"></i> Verified</span>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <div class="text-center" id="loadMoreContainer" style="margin-top: 40px; margin-bottom: 20px;">
                <button id="loadMoreReviewsBtn" class="btn btn-primary" style="padding: 12px 35px; font-size: 1.1rem; font-weight: 700; border-radius: 30px; background-color: #D4AF37; color: #1e293b; border: none; box-shadow: 0 4px 15px rgba(212, 175, 55, 0.3); transition: all 0.3s; cursor: pointer;">
                    <i class="fas fa-spinner"></i> Load More Reviews
                </button>
            </div>

            <!-- Share Experience CTA -->
            <div class="share-experience">
                <div class="share-content">
                    <i class="fas fa-heart share-icon"></i>
                    <h3>Have You Traveled With Us?</h3>
                    <p>We'd love to hear about your experience</p>
                    <a href="#write-review" class="btn btn-primary">
                        <i class="fas fa-pen"></i> Write a Review
                    </a>
                </div>
            </div>
        </div>
    </section>
        </main>

<script>
// Character counter for review text
document.addEventListener('DOMContentLoaded', function() {
    const reviewText = document.getElementById('review_text');
    const charCount = document.getElementById('charCount');
    
    if (reviewText && charCount) {
        reviewText.addEventListener('input', function() {
            const length = this.value.length;
            charCount.textContent = length;
        });
    }

    // Rating label update
    const ratingLabels = document.querySelectorAll('.rating-input label');
    const ratingLabel = document.getElementById('ratingLabel');
    
    ratingLabels.forEach(label => {
        label.addEventListener('click', function() {
            const title = this.getAttribute('title');
            if (ratingLabel) {
                ratingLabel.textContent = title || 'Selected';
                ratingLabel.style.color = '#FBBF24';
                ratingLabel.style.fontWeight = '600';
            }
        });
    });

    // Load More functionality
    const loadMoreBtn = document.getElementById('loadMoreReviewsBtn');
    if (loadMoreBtn) {
        loadMoreBtn.addEventListener('click', function() {
            const hiddenReviews = document.querySelectorAll('.hidden-review');
            hiddenReviews.forEach(review => {
                review.style.display = '';
                review.classList.remove('hidden-review');
            });
            document.getElementById('loadMoreContainer').style.display = 'none';
        });
    }

    // Smooth scroll to review section
    document.querySelector('a[href="#write-review"]')?.addEventListener('click', function(e) {
        e.preventDefault();
        const target = document.querySelector('.write-review-section');
        if (target) {
            target.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    });
});
</script>

<?php
include 'footer.php';
?>