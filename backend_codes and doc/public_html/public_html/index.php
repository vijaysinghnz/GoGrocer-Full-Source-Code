<?php

if(file_exists('includes/.lic')){
    
    require 'includes/lb_helper.php';
    $api = new LicenseBoxAPI();
    
    $res = $api->verify_license();
  

define('LARAVEL_START', microtime(true));



require __DIR__.'/source/vendor/autoload.php';



$app = require_once __DIR__.'/source/bootstrap/app.php';



$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$response->send();

$kernel->terminate($request, $response);

}
else{
	$config['base_url'] = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
	$config['base_url'] .= "://".$_SERVER['HTTP_HOST'];
	$config['base_url'] .= str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);
	$base = $config['base_url'];
	header('Location: '.$base.'install');
}