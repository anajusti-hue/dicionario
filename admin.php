<?php 
session_start();
// Segurança: Só entra no painel se o professor estiver logado
if (!isset($_SESSION['professor_logado'])) {
    header("Location: login.php");
    exit();
}

include 'config/conexao.php'; 

$materia = isset($_GET['materia']) ? $_GET['materia'] : 'portugues';
$aba = isset($_GET['aba']) ? $_GET['aba'] : 'pendente'; 
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;700&display=swap" rel="stylesheet">
    <title>Painel SESI - <?php echo ucfirst($materia); ?></title>
    <script>
        function confirmarAcao(id, acao) {
            let msg = "";
            if (acao === 'aprovar') msg = "Deseja APROVAR este termo?";
            else if (acao === 'excluir') msg = "Deseja EXCLUIR este termo permanentemente?";
            else if (acao === 'pendente') msg = "Deseja mover este termo de volta para pendentes?";

            if (confirm(msg)) {
                window.location.href = './api/acoes.php?acao=' + acao + '&id=' + id;
            }
        }
    </script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .header-sesi { padding: 30px 0; color: white; border-radius: 0 0 40px 40px; }
        .nav-portugues { background-color: #007BFF !important; } 
        .nav-matematica { background-color: #DC3545 !important; } 
        .card-termo { border-radius: 20px; margin-bottom: 15px; border: none; transition: 0.3s; }
        .card-termo:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important; }
        .img-preview { width: 70px; height: 70px; object-fit: cover; border-radius: 12px; margin-right: 15px; }
        .btn { border-radius: 10px; font-weight: 600; }
        .btn-success { background-color: #10b981; border: none; }
        .btn-success:hover { background-color: #059669; }
        .btn-warning { background-color: #f59e0b; border: none; color: white; }
    </style>
</head>
<body class="bg-light">

<header class="header-sesi text-center mb-4 shadow nav-<?php echo $materia; ?>">
    <h1 class="fw-bold">Gestão: <?php echo ucfirst($materia); ?></h1>
    <p class="mb-0 opacity-75">Olá, Prof. <?php echo htmlspecialchars($_SESSION['professor_nome']); ?></p>
</header>

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="selecao.php" class="btn btn-secondary shadow-sm">← Voltar</a>
        
        <div class="btn-group shadow-sm">
            <a href="admin.php?materia=<?php echo $materia; ?>&aba=pendente" 
               class="btn btn-white <?php echo $aba == 'pendente' ? 'bg-dark text-white' : 'bg-white'; ?>">
                Pendentes
            </a>
            <a href="admin.php?materia=<?php echo $materia; ?>&aba=aprovado" 
               class="btn btn-white <?php echo $aba == 'aprovado' ? 'bg-dark text-white' : 'bg-white'; ?>">
                Já Postados
            </a>
        </div>
    </div>

    <?php
    $sql = "SELECT * FROM termos WHERE status = '$aba' AND disciplina = '$materia' ORDER BY id DESC";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            ?>
            <div class="card card-termo shadow-sm">
                <div class="card-body d-flex align-items-center">
                    
                    <?php if(!empty($row['imagem_url'])): ?>
                        <img src="<?php echo $row['imagem_url']; ?>" class="img-preview">
                    <?php else: ?>
                        <div class="img-preview d-flex align-items-center justify-content-center bg-secondary text-white small">Sem foto</div>
                    <?php endif; ?>

                    <div class="flex-grow-1">
                        <h5 class="fw-bold mb-1"><?php echo htmlspecialchars($row['termo']); ?></h5>
                        <p class="text-muted small mb-0"><?php echo htmlspecialchars($row['definicao']); ?></p>
                    </div>

                    <div class="d-flex gap-2 ms-3">
                        <?php if($aba == 'pendente'): ?>
                            <button onclick="confirmarAcao(<?php echo $row['id']; ?>, 'aprovar')" class="btn btn-success">Aprovar</button>
                            <a href="./api/editar.php?id=<?php echo $row['id']; ?>" class="btn btn-warning">Editar</a>
                            <button onclick="confirmarAcao(<?php echo $row['id']; ?>, 'excluir')" class="btn btn-outline-danger">Excluir</button>
                        <?php else: ?>
                            <a href="./api/editar.php?id=<?php echo $row['id']; ?>" class="btn btn-warning">Editar</a>
                            <button onclick="confirmarAcao(<?php echo $row['id']; ?>, 'pendente')" class="btn btn-outline-primary">Mover para Pendentes</button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php
        }
    } else {
        echo "<div class='alert alert-info text-center border-0 shadow-sm'>Nenhum termo encontrado nesta aba.</div>";
    }
    ?>
</div>

</body>
</html>