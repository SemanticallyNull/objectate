<?php 

// Load all the things
require_once __DIR__ . '/../loader.php';

// Load Klein.php
require_once __DIR__ . '/../libs/klein.php';

$lines = file(__DIR__ . '/../line_of_the_day.txt');
$view_data['lotd'] = $lines[array_rand($lines)];

respond('GET', '/', function($request, $response) use ($view_data) {
	$view_data['contents'] = __DIR__ . '/../templates/pages/home.phtml';
	$response->render(__DIR__ . '/../templates/main.phtml', $view_data);
});

with('/poems',function() use ($view_data) {
	respond('GET', '/?', function($request, $response)  use ($view_data) {
		$view_data['contents'] = __DIR__ . '/../templates/pages/poem_index.phtml';
		$view_data['index'] = new Anontate_Index('poems');
		$response->render(__DIR__ . '/../templates/main.phtml', $view_data);
	});
	respond('GET', '/[:name]', function($request, $response)  use ($view_data) {
		$view_data['contents'] = __DIR__ . '/../templates/pages/poem.phtml';
		$view_data['poem'] = new Anontate_Poem(urldecode($request->name));
		$response->render(__DIR__ . '/../templates/main.phtml', $view_data);
	});
});


dispatch();

?>