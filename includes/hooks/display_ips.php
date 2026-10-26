<?php
use WHMCS\Database\Capsule;

add_hook('ClientAreaPageProductsServices', 1, function($vars) {
    if (empty($vars['services'])) {
        return;
    }

    // Collect all service IDs present on the page
    $serviceIds = array_column($vars['services'], 'id');

    // Fetch all IPs in ONE single query
    $serviceIps = Capsule::table('tblhosting')
        ->whereIn('id', $serviceIds)
        ->pluck('dedicatedip', 'id');

    // Attach IPs directly back to the services array
    $updatedServices = $vars['services'];
    foreach ($updatedServices as &$service) {
        $service['dedicatedip'] = $serviceIps[$service['id']] ?? '';
    }

    return ['services' => $updatedServices];
});
