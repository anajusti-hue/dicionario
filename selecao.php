<?php 
session_start(); 
if (!isset($_SESSION['professor_logado'])) { header("Location: login.php"); exit(); } 
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #F0F4F8; height: 100vh; display: flex; align-items: center; }
        .option-card { background: white; padding: 40px; border-radius: 30px; box-shadow: 0 20px 40px rgba(0,0,0,0.05); text-align: center; width: 100%; }
        .btn-materia { padding: 30px; border-radius: 20px; font-size: 1.5rem; font-weight: 800; text-decoration: none; display: block; transition: 0.3s; margin-bottom: 20px; }
        .btn-port { background: #E0EFFF; color: #007BFF; }
        .btn-mat { background: #FFE5E7; color: #DC3545; }
        .btn-materia:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1); }
    </style>
</head>
<body>
    <div class="container" style="max-width: 600px;">
    <div class="option-card" style="border-top: 8px solid #10b981; background: white; padding: 40px; border-radius: 30px; box-shadow: 0 20px 40px rgba(0,0,0,0.05); text-align: center;">
        <h2 class="fw-bold mb-2">Olá, Prof. <?php echo htmlspecialchars($_SESSION['professor_nome']); ?>! 👋</h2>
        <p class="text-muted mb-5">Selecione a disciplina para gerir:</p>
        <a href="admin.php?materia=portugues" class="btn-materia" style="background: #eff6ff; color: #2563eb; display: block; padding: 20px; border-radius: 15px; text-decoration: none; font-weight: 800; margin-bottom: 15px;">PORTUGUÊS</a>
        <a href="admin.php?materia=matematica" class="btn-materia" style="background: #fff1f2; color: #e11d48; display: block; padding: 20px; border-radius: 15px; text-decoration: none; font-weight: 800; margin-bottom: 15px;">MATEMÁTICA</a>
        <a href="api/logout.php" class="text-danger d-block mt-4 text-decoration-none small fw-bold">Sair do Sistema</a>
 
        </div>
    </div>
</body>
</html>