<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');

require_once __DIR__ . '/../src/Gue/GueClient.php';
require_once __DIR__ . '/../src/Name/NameAvailabilityService.php';
require_once __DIR__ . '/../src/Name/NameSuggestionService.php';
// Apenas GET
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode(['error' => 'Método não permitido']);
    exit;
}

$name = trim($_GET['name'] ?? '');

if ($name === '') {
    http_response_code(400);
    echo json_encode(['error' => 'Nome é obrigatório']);
    exit;
}

try {
    $gue = new GueClient();
    $checker = new NameAvailabilityService();
    $suggester = new NameSuggestionService();

    $html = $gue->searchByName($name);
    $exists = $checker->nameExists($html);

    echo json_encode([
        'name' => $name,
        'exists' => $exists,
        'suggestions' => $exists ? $suggester->suggest($name, []) : []
    ]);

} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Erro interno']);
}
