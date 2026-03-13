<?php 
session_start();
if (!isset($_SESSION['professor_logado'])) {
    header("Location: login.php");
    exit();
}
include 'config/conexao.php'; 

$materia = isset($_GET['materia']) ? $_GET['materia'] : 'portugues';
// NOVA LÓGICA: Verifica se o professor quer ver os pendentes ou os já postados
$aba = isset($_GET['aba']) ? $_GET['aba'] : 'pendente'; 
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Painel SESI - <?php echo ucfirst($materia); ?></title>
    <script>
        function confirmarAcao(id, acao) {
            let msg = acao === 'aprovar' ? "Deseja APROVAR este termo?" : "Deseja EXCLUIR este termo permanentemente?";
            if (confirm(msg)) {
                window.location.href = './api/acoes.php?acao=' + acao + '&id=' + id;
            }
        }
    </script>
    <style>
        .header-sesi { padding: 20px 0; color: white; border-bottom: 5px solid rgba(0,0,0,0.2); }
        .nav-portugues { background-color: #0056b3 !important; }
        .nav-matematica { background-color: #b30000 !important; }
        .card-termo { border-radius: 15px; margin-bottom: 15px; border: none; }
        .img-preview { width: 70px; height: 70px; object-fit: cover; border-radius: 10px; margin-right: 15px; }
    </style>
</head>
<body class="bg-light">

<header class="header-sesi text-center mb-4 shadow nav-<?php echo $materia; ?>">
    <h1 class="fw-bold">Gestão: <?php echo ucfirst($materia); ?></h1>
</header>

<div class="container">
    <div class="d-flex justify-content-between mb-4">
        <a href="selecao.php" class="btn btn-secondary">← Voltar</a>
        
        <div class="btn-group">
            <a href="admin.php?materia=<?php echo $materia; ?>&aba=pendente" class="btn <?php echo $aba == 'pendente' ? 'btn-dark' : 'btn-outline-dark'; ?>">
                Pendentes
            </a>
            <a href="admin.php?materia=<?php echo $materia; ?>&aba=aprovado" class="btn <?php echo $aba == 'aprovado' ? 'btn-dark' : 'btn-outline-dark'; ?>">
                Já Postados (Excluir Errados)
            </a>
        </div>
    </div>

    <?php
    // Busca termos baseados na aba selecionada (pendente ou aprovado)
    $sql = "SELECT * FROM termos WHERE status = '$aba' AND disciplina = '$materia' ORDER BY termo ASC";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            ?>
            <div class="card card-termo shadow-sm">
                <div class="card-body d-flex align-items-center">
                    <?php if(!empty($row['imagem_url'])): ?>
                        <img src="<?php echo $row['imagem_url']; ?>" class="img-preview">
                    <?php endif; ?>

                    <div class="flex-grow-1">
                        <h5 class="fw-bold mb-0"><?php echo htmlspecialchars($row['termo']); ?></h5>
                        <p class="text-muted small mb-0"><?php echo htmlspecialchars($row['definicao']); ?></p>
                    </div>

                    <div class="d-flex gap-2">
                        <?php if($aba == 'pendente'): ?>
                            <button onclick="confirmarAcao(<?php echo $row['id']; ?>, 'aprovar')" class="btn btn-success">Aprovar</button>
                        <?php endif; ?>
                        
                        <button onclick="confirmarAcao(<?php echo $row['id']; ?>, 'excluir')" class="btn btn-outline-danger">Excluir</button>
                    </div>
                </div>
            </div>
            <?php
        }
    } else {
        echo "<div class='alert alert-secondary text-center'>Nenhum termo encontrado nesta categoria.</div>";
    }
    ?>
</div>

</body>
</html>