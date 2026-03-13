<?php
session_start();
// Proteção: Se não estiver logado, volta para o login
if (!isset($_SESSION['professor_logado'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Escolha a Disciplina</title>
    <style>
        body {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f8f9fa;
        }
        .selection-card {
            width: 100%;
            max-width: 500px;
            padding: 2.5rem;
            border-radius: 25px;
            background: white;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            text-align: center;
        }
        .btn-materia {
            padding: 20px;
            font-size: 1.2rem;
            font-weight: bold;
            border-radius: 15px;
            transition: 0.3s;
            margin-bottom: 15px;
            color: white !important;
            text-decoration: none;
            display: block;
        }
        .btn-portugues { background-color: #0056b3; }
        .btn-matematica { background-color: #b30000; }
        .btn-materia:hover { transform: scale(1.02); opacity: 0.9; }
    </style>
</head>
<body>
    <div class="selection-card">
        <h2 class="fw-bold mb-2">Olá, <?php echo $_SESSION['professor_nome']; ?>! 👋</h2>
        <p class="text-muted mb-4">Selecione a disciplina para gerir:</p>
        
        <a href="admin.php?materia=portugues" class="btn-materia btn-portugues shadow-sm">📚 Português</a>
        <a href="admin.php?materia=matematica" class="btn-materia btn-matematica shadow-sm">🔢 Matemática</a>
        
        <hr class="my-4">
        <a href="./api/logout.php" class="text-decoration-none text-danger small">Sair do Sistema</a>
    </div>
</body>
</html>
</html>