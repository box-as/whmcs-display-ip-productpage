<?php

# Add Dedicated IP To The Services Array Hook
# Written by brian! 

use Illuminate\Database\Capsule\Manager as Capsule;

function clients_services_add_dedicatedip_hook($vars) {

	$client = Menu::context('client');
	$services = $vars['services'];
	foreach($services as $key => $service) {
		$dedicatedip = Capsule::table('tblhosting')->where('userid',$client->id)->where('id',$service['id'])->value('dedicatedip');
		if ($dedicatedip) {
			$services[$key]['dedicatedip'] = $dedicatedip;
		}
	}	
	return array("services" => $services);
}
add_hook("ClientAreaPageProductsServices", 1, "clients_services_add_dedicatedip_hook");
?>
