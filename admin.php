<?php 
// AJUSTE: O admin está na raiz, então entra na pasta config para achar o banco
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
        .header-sesi { background: #333; color: white; padding: 20px 0; border-bottom: 5px solid #d32f2f; }
        .card-termo { border-left: 8px solid #444; margin-bottom: 15px; transition: 0.3s; }
        .tema-portugues .card-termo { border-left-color: #0056b3; }
        .tema-matematica .card-termo { border-left-color: #b30000; }
    </style>
</head>
<body class="bg-light tema-<?php echo $materia; ?>">

<header class="header-sesi text-center mb-4">
    <h1>Validação: <?php echo ucfirst($materia); ?></h1>
</header>

<div class="container">
    <div class="mb-4">
        <a href="selecao.php" class="btn btn-secondary shadow-sm">← Voltar para Seleção</a>
    </div>

    <?php
   
    if (isset($conn)) {
        $sql = "SELECT * FROM termos WHERE status = 'pendente' AND disciplina = '$materia' ORDER BY id DESC";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                ?>
                <div class="card card-termo shadow-sm border-0">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="fw-bold mb-1"><?php echo htmlspecialchars($row['termo']); ?></h4>
                            <p class="text-muted mb-0"><?php echo htmlspecialchars($row['definicao']); ?></p>
                        </div>
                        <div class="d-flex gap-2">
                            <button onclick="confirmarAprovacao(<?php echo $row['id']; ?>)" class="btn btn-success px-4">Aprovar</button>
                            <button onclick="confirmarExclusao(<?php echo $row['id']; ?>)" class="btn btn-outline-danger">Excluir</button>
                        </div>
                    </div>
                </div>
                <?php
            }
        } else {
            echo "<div class='alert alert-info text-center shadow-sm'>Nenhum termo pendente para " . ucfirst($materia) . ".</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>Erro de conexão: Verifique o arquivo config/conexao.php</div>";
    }
    ?>
</div>

</body>
</html>