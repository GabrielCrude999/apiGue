<?php 
// index.php
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>NomeSeguro | Verificador de Nome</title>
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

        h4 {
            color: #203a43;
        }

        footer {
            font-size: 0.8rem;
            color: #555;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">

            <div class="card">
                <h4 class="text-center mb-2">NomeSeguro</h4>
                <p class="text-center text-muted small mb-4">
                    Verifique se um nome de empresa já está registado no Guiché Único
                </p>

                <form action="result.php" method="post">
                    <div class="mb-3">
                        <label class="form-label">Nome da empresa</label>
                        <input type="text" name="name" class="form-control"
                               required placeholder="Ex: Ara Jackson">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Área de atuação</label>
                        <input type="text" name="area" class="form-control"
                               placeholder="Ex: tecnologia, comércio">
                    </div>

                    <div class="d-grid gap-2">
                        <button class="btn btn-primary" type="submit">Verificar disponibilidade</button>
                    </div>
                </form>

                <footer class="text-center mt-3">
                    Ferramenta informativa. Confirmação oficial deve ser feita no GUE.
                </footer>
            </div>

        </div>
    </div>
</div>

</body>
</html>
