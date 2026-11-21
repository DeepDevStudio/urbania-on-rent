<?php
/**
 * ImageAltService - Centralized Image ALT SEO & Accessibility Optimization Service
 * Force Urbania on Rent Delhi NCR
 *
 * Implements deterministic, landmark-accurate, and seater-specific ALT text generation
 * across static pages, dynamic route pages, fleet cards, and tour packages.
 */

class ImageAltService {
    private static ?array $destinationSubjects = null;
    private static ?array $fileSubjects = null;

    /**
     * Known vehicle image catalog with verified SEO ALT descriptions
     */
    private static array $vehicleCatalog = [
        'images/urbania-rent.webp' => 'Luxury Force Urbania on rent in Delhi NCR with driver – Urbania tempo traveller for group travel',
        'images/urbania-4.webp'    => 'White Force Urbania luxury van on rent in Delhi NCR – Urbania hire with driver for outstation & local trips',
        'images/urbania-1.webp'   => '12 seater Force Urbania Maharaja on rent in Delhi with luxury captain seats – premium Urbania hire for weddings & group tours',
        'images/urbania-5.webp'    => '16 seater Force Urbania on rent in Delhi NCR with 2x1 pushback seats – Urbania tempo traveller for group tours',
    ];

    /**
     * Fleet seater capacity verified ALT mappings
     */
    private static array $fleetSeaterMap = [
        9  => '9 seater Force Urbania Maharaja on rent in Delhi NCR with premium seating – luxury Urbania for VIP & family trips',
        12 => '12 seater Force Urbania Maharaja on rent in Delhi with luxury captain seats – premium Urbania hire for weddings & group tours',
        16 => '16 seater Force Urbania on rent in Delhi NCR with 2x1 pushback seats – Urbania tempo traveller for group tours',
    ];

    /**
     * Blog guide header image landmark mappings
     */
    private static array $blogLandmarkMap = [
        'delhi-to-jaipur'    => 'Hawa Mahal Palace of Winds in Jaipur, Rajasthan – Delhi to Jaipur Urbania on rent for family & group tours',
        'delhi-to-agra'      => 'Taj Mahal marble monument in Agra, Uttar Pradesh – Delhi to Agra Urbania on rent for family & group tours',
        'delhi-to-manali'    => 'Snow-covered mountain peaks in Manali, Himachal Pradesh – Delhi to Manali Urbania on rent for family & group tours',
        'delhi-to-shimla'    => 'Mall Road and Ridge hill station vista in Shimla, Himachal Pradesh – Delhi to Shimla Urbania on rent for family & group tours',
        'delhi-to-rishikesh' => 'Laxman Jhula suspension bridge over river Ganga in Rishikesh, Uttarakhand – Delhi to Rishikesh Urbania on rent for family & group tours',
        'delhi-to-haridwar'  => 'Ganga river ghats at Har Ki Pauri in Haridwar, Uttarakhand – Delhi to Haridwar Urbania on rent for family & group tours',
        'delhi-to-amritsar'  => 'Golden Temple sanctum and holy sarovar in Amritsar, Punjab – Delhi to Amritsar Urbania on rent for family & group tours',
        'delhi-to-udaipur'   => 'City Palace and Lake Pichola in Udaipur, Rajasthan – Delhi to Udaipur Urbania on rent for family & group tours',
        'delhi-to-nainital'  => 'Naini Lake and surrounding green hills in Nainital, Uttarakhand – Delhi to Nainital Urbania on rent for family & group tours',
        'delhi-to-mussoorie' => 'Kempty Falls and scenic mountain valley in Mussoorie, Uttarakhand – Delhi to Mussoorie Urbania on rent for family & group tours',
        'delhi-to-varanasi'  => 'Ganga Aarti evening prayer ritual at Dashashwamedh Ghat in Varanasi, Uttar Pradesh – Delhi to Varanasi Urbania on rent for family & group tours',
        'delhi-to-chardham'  => 'Ancient Kedarnath Temple against Himalayan snow peaks in Uttarakhand – Delhi to Kedarnath Urbania on rent for family & group tours',
    ];

    /**
     * Clean conversational prefixes from raw subject strings
     */
    public static function cleanSubject(string $subject): string {
        $s = trim($subject);
        $patterns = [
            '/^(?:it is\s+)?(?:known|famous|noted|renowned)\s+(?:for|as)\s+(?:the\s+|its\s+)?/i',
            '/^(?:the\s+)?(?:town|city|village|region|place|destination)\s+(?:features|is known for|is famous for)\s+(?:the\s+|its\s+)?/i',
        ];
        foreach ($patterns as $pattern) {
            $s = preg_replace($pattern, '', $s);
        }
        $s = trim($s);
        return $s !== '' ? ucfirst($s) : '';
    }

    /**
     * Load destination subject audit database lazily
     */
    private static function loadDatabase(): void {
        if (self::$destinationSubjects !== null) {
            return;
        }

        self::$destinationSubjects = [];
        self::$fileSubjects = [];

        $auditFile = dirname(__DIR__, 2) . '/destination_image_audit_report.json';
        if (file_exists($auditFile)) {
            $raw = json_decode(file_get_contents($auditFile), true);
            if (is_array($raw)) {
                foreach ($raw as $item) {
                    $d = strtolower(trim($item['destination'] ?? ''));
                    $f = strtolower(trim($item['file'] ?? ''));
                    $s = self::cleanSubject($item['subject'] ?? '');
                    $st = trim($item['state'] ?? '');

                    $record = [
                        'destination' => $item['destination'] ?? '',
                        'subject'     => $s,
                        'state'       => $st,
                        'type'        => $item['type'] ?? 'REGIONAL_SCENIC',
                        'file'        => $item['file'] ?? ''
                    ];

                    if ($d !== '') {
                        self::$destinationSubjects[$d] = $record;
                    }
                    if ($f !== '') {
                        self::$fileSubjects[$f] = $record;
                    }
                }
            }
        }
    }

    /**
     * Generate deterministic, accurate ALT text for a destination image
     *
     * @param string|null $imgSrc Image source path or URL
     * @param string $destination Destination name
     * @param string $origin Origin city name (Delhi, Gurgaon, Noida, etc.)
     * @param string $state State name (Rajasthan, Himachal Pradesh, etc.)
     * @return string Descriptive, concise ALT text
     */
    public static function getDestinationAlt(?string $imgSrc, string $destination, string $origin = 'Delhi', string $state = ''): string {
        $imgSrc = trim((string)$imgSrc);

        // 1. Check if the image is actually a vehicle image
        $cleanSrc = preg_replace('/\?.*$/', '', $imgSrc);
        if (isset(self::$vehicleCatalog[$cleanSrc])) {
            return self::$vehicleCatalog[$cleanSrc];
        }

        self::loadDatabase();

        $destKey = strtolower(trim($destination));
        $fileKey = strtolower(basename($cleanSrc));

        $record = null;
        if (isset(self::$fileSubjects[$fileKey])) {
            $record = self::$fileSubjects[$fileKey];
        } elseif (isset(self::$destinationSubjects[$destKey])) {
            $record = self::$destinationSubjects[$destKey];
        }

        if ($record && !empty($record['subject'])) {
            $subject = $record['subject'];
            $st = !empty($record['state']) ? $record['state'] : $state;
            $loc = trim($destination . ($st ? ', ' . $st : ''));
            return $subject . ($loc ? ' in ' . $loc : '');
        }

        // Descriptive fallback without vehicle keyword stuffing
        $loc = trim($destination . ($state ? ', ' . $state : ''));
        return 'Scenic travel attractions and landmark landscape in ' . ($loc ?: 'North India');
    }

    /**
     * Append the route booking keyword to a destination image ALT
     */
    public static function withRouteKeywords(string $alt, string $destination, string $origin = 'Delhi'): string {
        if (strpos($alt, ' – ') !== false) {
            return $alt;
        }
        return $alt . ' – ' . $origin . ' to ' . $destination . ' Urbania on rent for family & group tours';
    }

    /**
     * Return verified fleet seater capacity ALT text
     */
    public static function getFleetAlt(int $seats, ?string $model = null): string {
        if (isset(self::$fleetSeaterMap[$seats])) {
            return self::$fleetSeaterMap[$seats];
        }
        return $seats . ' seater luxury Force Urbania on rent in Delhi for group travel';
    }

    /**
     * Return blog landmark image ALT text
     */
    public static function getBlogAlt(string $slug, ?string $dest = null): string {
        $slug = trim($slug);
        if (isset(self::$blogLandmarkMap[$slug])) {
            return self::$blogLandmarkMap[$slug];
        }
        return 'Scenic travel destination and attractions in ' . ($dest ?: 'North India');
    }

    /**
     * Return vehicle catalog image ALT text or null
     */
    public static function getVehicleImageAlt(string $imgSrc): ?string {
        $clean = preg_replace('/\?.*$/', '', trim($imgSrc));
        return self::$vehicleCatalog[$clean] ?? null;
    }
}

/**
 * Global helper function for deterministic, safely-escaped ALT text
 */
if (!function_exists('imageAlt')) {
    function imageAlt(string $subject, ?string $context = null): string {
        $alt = trim($subject . ($context ? ' ' . $context : ''));
        return htmlspecialchars($alt, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }
}
