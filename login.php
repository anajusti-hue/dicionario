<?php
session_start();
// AJUSTE: O login está na raiz, a conexão está na pasta config
include 'config/conexao.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nif = $_POST['nif'];
    $senha = $_POST['senha'];

    // Consulta para verificar o professor
    $sql = "SELECT * FROM professores WHERE nif = '$nif' AND senha = '$senha'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $_SESSION['professor_logado'] = true;
        $_SESSION['professor_nif'] = $nif;
        header("Location: selecao.php"); // Manda para a página de seleção
        exit();
    } else {
        $erro = "NIF ou Senha inválidos!";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Login Professor - SESI</title>
    <style>
        /* CSS para centralizar tudo no meio da tela */
        body {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f1f3f5;
            margin: 0;
        }
        .card-login {
            width: 100%;
            max-width: 380px;
            border-radius: 20px; /* Bordas fofinhas */
            border: none;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        .btn-entrar {
            background-color: #057607;
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-weight: bold;
            transition: 0.3s;
        }
        
        .form-control {
            border-radius: 10px;
            padding: 10px 15px;
        }
    </style>
</head>
<body>

<div class="card card-login">
    <div class="card-body p-4 text-center">
        <h3 class="fw-bold mb-1 text-dark">Bem-vindo</h3>
        <p class="text-muted mb-4">Área Restrita ao Professor</p>

        <?php if(isset($erro)): ?>
            <div class="alert alert-danger py-2" style="font-size: 0.9rem; border-radius: 10px;">
                <?php echo $erro; ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <div class="text-start mb-3">
                <label class="form-label small fw-bold text-secondary">NIF</label>
                <input type="text" name="nif" class="form-control" placeholder="Digite seu NIF" required>
            </div>

            <div class="text-start mb-4">
                <label class="form-label small fw-bold text-secondary">SENHA</label>
                <input type="password" name="senha" class="form-control" placeholder="••••••••" required>
            </div>

            <button type="submit" class="btn btn-entrar bs-success btn-success w-100 shadow-sm">Entrar no Painel</button>
            
            <a href="index.php" class="d-block mt-3 text-decoration-none text-muted small">
                ← Voltar ao Dicionário
            </a>
        </form>
    </div>
</div>

</body>
</html>