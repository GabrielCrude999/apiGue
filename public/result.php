<?php
require_once __DIR__.'/../src/Gue/GueClient.php';
require_once __DIR__.'/../src/Name/NameAvailabilityService.php';
require_once __DIR__.'/../src/Name/NameSuggestionService.php';

$name = trim($_POST['name'] ?? '');
$area = trim($_POST['area'] ?? '');

$result = null;

if ($name !== '') {
    $gue = new GueClient();
    $checker = new NameAvailabilityService();
    $suggester = new NameSuggestionService();

    try {
        $html = $gue->searchByName($name);
        $exists = $checker->nameExists($html);

        $result = [
            'exists' => $exists,
            'suggestions' => $exists ? $suggester->suggest($name, $area) : []
        ];

    } catch (Throwable $e) {
        $result = ['error' => $e->getMessage()];
    }
} else {
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Resultado - Verificador de Nome | GUE</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .card {
            border-radius: 14px;
            padding: 2rem;
            background: #ffffffee;
            box-shadow: 0 10px 25px rgba(0,0,0,0.25);
        }

        .suggestion-item:hover {
            background-color: #e9f0f7;
            cursor: pointer;
        }

        footer {
            margin-top: 15px;
            font-size: 0.8rem;
            color: #666;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">

            <div class="card">
                <h4 class="text-center mb-2">Resultado da Busca</h4>

                <?php if (isset($result['error'])): ?>
                    <div class="alert alert-danger">
                        ⚠ <?= htmlspecialchars($result['error']) ?>
                    </div>

                <?php elseif ($result['exists']): ?>
                    <div class="alert alert-warning">
                        ❌ <strong>O nome <?= htmlspecialchars($name) ?> já está registado</strong>
                    </div>

                    <?php if (!empty($result['suggestions'])): ?>
                        <p><strong>Sugestões alternativas:</strong></p>
                        <ul class="list-group mb-3">
                            <?php foreach ($result['suggestions'] as $s): ?>
                                <li class="list-group-item suggestion-item"><?= htmlspecialchars($s) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>

                    <div class="alert alert-info">
                        💡 Dica: Tente variar o nome, adicione a área de atuação ou palavras-chave únicas para aumentar a chance de aprovação.
                    </div>

                <?php else: ?>
                    <div class="alert alert-success">
                        ✅ O nome <?= htmlspecialchars($name) ?> parece estar disponível.
                    </div>
                    <div class="alert alert-info">
                        💡 Dica: Antes de registrar, confirme no GUE e verifique se o domínio ou marca está disponível.
                    </div>
                <?php endif; ?>

                <div class="d-grid mt-3">
                    <a href="index.php" class="btn btn-outline-primary">Nova pesquisa</a>
                </div>

                <footer class="text-center mt-3">
                    ⚠ Ferramenta informativa. Confirmação oficial deve ser feita no GUE.
                </footer>
            </div>

        </div>
    </div>
</div>

</body>
</html>
