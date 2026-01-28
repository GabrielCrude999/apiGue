<?php
// index.php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: Content-Type');

// Inclui os serviços
require_once __DIR__ . '/src/Gue/GueClient.php';
require_once __DIR__ . '/src/Name/NameAvailabilityService.php';
require_once __DIR__ . '/src/Name/NameSuggestionService.php';

$method = $_SERVER['REQUEST_METHOD'];
$name = '';

// Captura o nome
if ($method === 'GET') {
    $name = trim($_GET['name'] ?? '');
} elseif ($method === 'POST') {
    $input = file_get_contents('php://input');
    $data = json_decode($input, true) ?: $_POST;
    $name = trim($data['name'] ?? '');
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Método não permitido']);
    exit;
}

// Validação - Se nenhum nome foi fornecido
if ($name === '') {
    // Se nenhum parâmetro foi enviado, retorna info da API
    if (empty($_GET) && empty($_POST) && $method === 'GET') {
        http_response_code(200);
        echo json_encode([
            'message' => 'API GUE - Verificador de Disponibilidade de Nomes',
            'usage' => [
                'GET' => '?name=exemplo',
                'POST' => '{"name": "exemplo"}'
            ],
            'status' => 'online'
        ]);
        exit;
    }
    
    http_response_code(400);
    echo json_encode(['error' => 'Nome é obrigatório']);
    exit;
}

// Validação de tamanho mínimo
if (mb_strlen($name) < 4) {
    echo json_encode([
        'name' => $name,
        'exists' => false,
        'suggestions' => []
    ]);
    exit;
}

// Tenta processar a requisição
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
    echo json_encode(['error' => 'Erro interno: ' . $e->getMessage()]);
}
