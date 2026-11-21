<?php
require_once __DIR__ . '/../includes/destinations-data.php';

$store = get_multi_origin_store();
echo "Origins in store: " . count($store['origins']) . PHP_EOL;
foreach ($store['origins'] as $orgId => $org) {
    $count = count($store['routes_by_origin'][$orgId] ?? []);
    echo "Origin '{$orgId}': {$count} routes" . PHP_EOL;
}
echo "Total routes in routes_by_slug: " . count($store['routes_by_slug'] ?? []) . PHP_EOL;
