<?php
declare(strict_types=1);

use Eshop\Routing\Router;

require_once dirname(__DIR__) . '/boot.php';

// JSON methods
function jsonResponse(array $data, int $statusCode = 200): void
{
	http_response_code($statusCode);
	echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
	exit;
}

// HTTP METHOD
$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
$uri = $_SERVER['REQUEST_URI'] ?? '/';


// SIMPLE ROUTING
$route = Router::find($method, $uri);

if ($route)
{
	$action = $route->action;
	$variables = $route->getVariables();

	jsonResponse($action(...$variables));
}
else
{
	jsonResponse([
		'ok' => false,
		'error' => 'Page not found',
		'method' => $method,
		'uri' => $uri,
	], 404);
}
