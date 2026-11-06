<?php

$method = $_SERVER['REQUEST_METHOD'];

$path = parse_url(
    $_SERVER['REQUEST_URI'],
    PHP_URL_PATH
);

if ($path === '/api/products' && $method === 'GET') {
    $controller->index();
    exit;
}

if ($path === '/api/products/register' && $method === 'POST') {
    $controller->store();
    exit;
}

if (preg_match('#^/api/products/([1-9][0-9]*)$#', $path, $matches)) {

    $id = (int) $matches[1];

    if ($method === 'GET') {
        $controller->show($id);
        exit;
    }

    if ($method === 'PUT') {
        $controller->update($id);
        exit;
    }

    if ($method === 'DELETE') {
        $controller->destroy($id);
        exit;
    }
}
//usuario
if ($path === '/api/user' && $method === 'GET') {
    $userControllers->index();
    exit;
}

if ($path === '/api/user/register' && $method === 'POST') {
    $userControllers->store();
    exit;
}

if (preg_match('#^/api/user/([1-9][0-9]*)$#', $path, $matches)) {

    $id = (int) $matches[1];

    if ($method === 'GET') {
        $userControllers->show($id);
        exit;
    }

    if ($method === 'PUT') {
        $userControllers->update($id);
        exit;
    }

    if ($method === 'DELETE') {
        $userControllers->destroy($id);
        exit;
    }
}

http_response_code(404);

echo json_encode([
    'error' => 'Endpoint no encontrado'
]);