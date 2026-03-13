<?php 
session_start();
// Segurança: Só entra no painel se o professor estiver logado
if (!isset($_SESSION['professor_logado'])) {
    header("Location: login.php");
    exit();
}

// O admin está na raiz, então entra na pasta config para achar o banco
include 'config/conexao.php'; 

$materia = isset($_GET['materia']) ? $_GET['materia'] : 'portugues';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Painel de Validação SESI</title>
    <script>
        function confirmarAprovacao(id) {
            if (confirm("Deseja APROVAR este termo? Ele aparecerá na página inicial.")) {
                window.location.href = './api/acoes.php?acao=aprovar&id=' + id;
            }
        }
        function confirmarExclusao(id) {
            if (confirm("Tem certeza que deseja EXCLUIR este termo?")) {
                window.location.href = './api/acoes.php?acao=excluir&id=' + id;
            }
        }
    </script>
    <style>
        /* Estilo base do Header */
        .header-sesi { padding: 20px 0; border-bottom: 5px solid rgba(0,0,0,0.2); color: white; }
        
        /* AJUSTE: Cores dinâmicas para a NAV baseadas na matéria */
        .nav-portugues { background-color: #0056b3 !important; } /* Azul para Português */
        .nav-matematica { background-color: #b30000 !important; } /* Vermelho para Matemática */

        .card-termo { border-left: 8px solid #444; margin-bottom: 15px; transition: 0.3s; border-radius: 15px; }
        .tema-portugues .card-termo { border-left-color: #0056b3; }
        .tema-matematica .card-termo { border-left-color: #b30000; }
        
        .img-preview {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 10px;
            margin-right: 20px;
            border: 1px solid #ddd;
        }
    </style>
</head>
<body class="bg-light tema-<?php echo $materia; ?>">

<header class="header-sesi text-center mb-4 shadow nav-<?php echo $materia; ?>">
    <h1 class="fw-bold">Validação: <?php echo ucfirst($materia); ?></h1>
</header>

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="selecao.php" class="btn btn-secondary shadow-sm">← Voltar para Seleção</a>
        <span class="text-muted small">Professor(a): <strong><?php echo $_SESSION['professor_nome'] ?? 'Logado'; ?></strong></span>
    </div>

    <?php
    if (isset($conn)) {
        $sql = "SELECT * FROM termos WHERE status = 'pendente' AND disciplina = '$materia' ORDER BY id DESC";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                ?>
                <div class="card card-termo shadow-sm border-0">
                    <div class="card-body d-flex align-items-center">
                        
                        <?php if(!empty($row['imagem_url'])): ?>
                            <img src="<?php echo $row['imagem_url']; ?>" alt="Preview" class="img-preview shadow-sm">
                        <?php else: ?>
                            <div class="img-preview d-flex align-items-center justify-content-center bg-secondary text-white small">
                                Sem imagem
                            </div>
                        <?php endif; ?>

                        <div class="flex-grow-1">
                            <h4 class="fw-bold mb-1"><?php echo htmlspecialchars($row['termo']); ?></h4>
                            <p class="text-muted mb-0 small"><?php echo htmlspecialchars($row['definicao']); ?></p>
                        </div>

                        <div class="d-flex gap-2 ms-3">
                            <button onclick="confirmarAprovacao(<?php echo $row['id']; ?>)" class="btn btn-success px-4 shadow-sm">Aprovar</button>
                            <button onclick="confirmarExclusao(<?php echo $row['id']; ?>)" class="btn btn-outline-danger shadow-sm">Excluir</button>
                        </div>
                    </div>
                </div>
                <?php
            }
        } else {
            echo "<div class='alert alert-info text-center shadow-sm py-4'>Nenhum termo pendente para " . ucfirst($materia) . ".</div>";
        }
    }
    ?>
</div>

</body>
</html>