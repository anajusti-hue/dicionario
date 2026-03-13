<?php
session_start();
include 'config/conexao.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nif = $conn->real_escape_string($_POST['nif']);
    $senha = $_POST['senha']; 
    $sql = "SELECT * FROM professores WHERE nif = '$nif' AND senha = '$senha'";
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        $dados = $result->fetch_assoc();
        $_SESSION['professor_logado'] = true;
        $_SESSION['professor_id'] = $dados['id'];
        $_SESSION['professor_nome'] = $dados['nome'];
        header("Location: selecao.php"); exit();
    } else { $erro = "NIF ou Senha inválidos!"; }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;700&display=swap" rel="stylesheet">
    <title>Login - SESI</title>
    <style>
        /* Dentro do seu <style> no login.php */
.btn-primary { 
    background: #10b981 !important; 
    border: none; 
    padding: 12px; 
    border-radius: 12px; 
    font-weight: 700; 
}
.btn-primary:hover { background: #059669 !important; transform: translateY(-2px); }
.form-control:focus { border-color: #10b981; box-shadow: 0 0 0 0.25rem rgba(16, 185, 129, 0.25); }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #F0F4F8; height: 100vh; display: flex; align-items: center; justify-content: center; }
        .login-card { background: white; padding: 40px; border-radius: 30px; box-shadow: 0 20px 40px rgba(0,0,0,0.05); width: 100%; max-width: 400px; }
        .form-control { border-radius: 12px; padding: 12px; border: 1px solid #E2E8F0; }
        .btn-primary { background: #007BFF; border: none; padding: 12px; border-radius: 12px; font-weight: 700; }
    </style>
</head>
<body>
    <div class="login-card text-center">
        <h2 class="fw-bold mb-4">Painel do Professor</h2>
        <?php if(isset($erro)): ?> <div class="alert alert-danger py-2"><?php echo $erro; ?></div> <?php endif; ?>
        <form method="POST">
            <input type="text" name="nif" class="form-control mb-3" placeholder="Seu NIF" required>
            <input type="password" name="senha" class="form-control mb-4" placeholder="Sua Senha" required>
            <button type="submit" class="btn btn-primary w-100 shadow">Entrar no Sistema</button>
        </form>
        <a href="index.php" class="d-block mt-4 text-muted text-decoration-none small">← Voltar ao Dicionário</a>
    </div>
</body>
</html>