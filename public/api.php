<?php
// Retorna JSON
header('Content-Type: application/json; charset=utf-8');

// Permitir apenas POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Método não permitido']);
    exit;
}

// Importa classes
require_once __DIR__ . '/../src/Gue/GueClient.php';
require_once __DIR__ . '/../src/Name/NameAvailabilityService.php';
require_once __DIR__ . '/../src/Name/NameSuggestionService.php';

// Lê body JSON
$input = json_decode(file_get_contents('php://input'), true);

$name = trim($input['name'] ?? '');

if ($name === '') {
    http_response_code(400);
    echo json_encode(['error' => 'Nome é obrigatório']);
    exit;
}

try {
    $gue = new GueClient();
    $checker = new NameAvailabilityService();
    $suggester = new NameSuggestionService();

    // Busca no GUE
    $html = $gue->searchByName($name);
    $exists = $checker->nameExists($html);

    // Se já existe, gera sugestões; se não, retorna vazio
    $suggestions = $exists ? $suggester->suggest($name, []) : [];

    // Retorno
    echo json_encode([
        'name' => $name,
        'suggestions' => $suggestions
    ]);

} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
