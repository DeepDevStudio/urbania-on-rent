<?php
// Multi-Origin Destination Data Store for Urbania on Rent Delhi
// Master data layer supporting 5 origin hubs: Delhi, Gurgaon, Noida, Ghaziabad, Faridabad (3,055 total routes)

function get_multi_origin_store() {
    static $store = null;
    if ($store === null) {
        $json_file = __DIR__ . '/destinations_multi_origin.json';
        if (file_exists($json_file)) {
            $store = json_decode(file_get_contents($json_file), true) ?: [];
        } else {
            // Fallback to legacy single origin dataset if multi-origin not yet present
            $legacy_file = __DIR__ . '/destinations_dataset.json';
            $legacy_routes = file_exists($legacy_file) ? json_decode(file_get_contents($legacy_file), true) : [];
            $store = [
                'origins' => [
                    'delhi' => ['id' => 'delhi', 'name' => 'Delhi', 'full_name' => 'Delhi NCR', 'state' => 'Delhi NCR', 'pickup_hub' => 'Connaught Place / Aerocity / South Delhi']
                ],
                'routes_by_origin' => ['delhi' => $legacy_routes],
                'routes_by_slug' => []
            ];
            foreach ($legacy_routes as $r) {
                $store['routes_by_slug'][$r['slug']] = $r;
            }
        }
    }
    return $store;
}

function get_all_origins() {
    $store = get_multi_origin_store();
    return $store['origins'] ?? [
        'delhi' => ['id' => 'delhi', 'name' => 'Delhi', 'full_name' => 'Delhi NCR', 'state' => 'Delhi NCR', 'pickup_hub' => 'Connaught Place / Aerocity / South Delhi'],
        'gurgaon' => ['id' => 'gurgaon', 'name' => 'Gurgaon', 'full_name' => 'Gurgaon (Gurugram)', 'state' => 'Haryana', 'pickup_hub' => 'Cyber Hub / Golf Course Road / Sector 29'],
        'noida' => ['id' => 'noida', 'name' => 'Noida', 'full_name' => 'Noida (Gautam Buddha Nagar)', 'state' => 'Uttar Pradesh', 'pickup_hub' => 'Sector 18 / Sector 62 / Greater Noida Pari Chowk'],
        'ghaziabad' => ['id' => 'ghaziabad', 'name' => 'Ghaziabad', 'full_name' => 'Ghaziabad', 'state' => 'Uttar Pradesh', 'pickup_hub' => 'Indirapuram / Vaishali / Raj Nagar Extension'],
        'faridabad' => ['id' => 'faridabad', 'name' => 'Faridabad', 'full_name' => 'Faridabad', 'state' => 'Haryana', 'pickup_hub' => 'Sector 15 / NIT Faridabad / Badarpur Border']
    ];
}

function get_all_destinations($origin_id = 'delhi') {
    $store = get_multi_origin_store();
    $origin_id = strtolower(trim((string)$origin_id));
    if (empty($origin_id)) {
        $origin_id = 'delhi';
    }
    if (isset($store['routes_by_origin'][$origin_id])) {
        return $store['routes_by_origin'][$origin_id];
    }
    return $store['routes_by_origin']['delhi'] ?? [];
}

function get_destination_by_slug($slug) {
    $store = get_multi_origin_store();
    $slug = trim($slug, '/');
    $slug = str_replace('.php', '', $slug);
    $clean_slug = strtolower($slug);

    // 1. Direct O(1) hash lookup
    if (isset($store['routes_by_slug'][$clean_slug])) {
        return $store['routes_by_slug'][$clean_slug];
    }

    // 2. Detect origin prefix
    $origin_detected = 'delhi';
    $core_dest = $clean_slug;
    foreach (['delhi', 'gurgaon', 'noida', 'ghaziabad', 'faridabad'] as $org) {
        if (strpos($clean_slug, $org . '-to-') === 0) {
            $origin_detected = $org;
            $core_dest = substr($clean_slug, strlen($org . '-to-'));
            break;
        }
    }
    $clean_dest_core = preg_replace('/-urbania(-on-rent)?$/', '', $core_dest);
    $clean_dest_core = preg_replace('/-(innova|cabs?|taxi|rental).*$/', '', $clean_dest_core);

    $standard_slug = $origin_detected . '-to-' . $clean_dest_core . '-urbania-on-rent';
    if (isset($store['routes_by_slug'][$standard_slug])) {
        return $store['routes_by_slug'][$standard_slug];
    }

    // 3. Fallback scan inside the origin list
    $origin_routes = get_all_destinations($origin_detected);
    foreach ($origin_routes as $item) {
        if (strtolower($item['base_slug']) === $clean_dest_core ||
            strtolower($item['destination']) === str_replace('-', ' ', $clean_dest_core)) {
            return $item;
        }
    }

    // Fallback to Delhi routes scan if not matched in detected origin
    if ($origin_detected !== 'delhi') {
        foreach (get_all_destinations('delhi') as $item) {
            if (strtolower($item['base_slug']) === $clean_dest_core) {
                // Adapt to requested origin
                return get_destination_by_slug($origin_detected . '-to-' . $item['base_slug'] . '-urbania-on-rent');
            }
        }
    }

    return null;
}
