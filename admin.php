<?php 
include 'conexao.php'; 
$materia = isset($_GET['materia']) ? $_GET['materia'] : 'portugues';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/style.css">
    <title>Painel de Validação</title>
    <script>
        function confirmarAprovacao(id) {
            if (confirm("Deseja APROVAR este termo? Ele aparecerá na página inicial.")) {
                window.location.href = 'acoes.php?acao=aprovar&id=' + id;
            }
        }
        function confirmarExclusao(id) {
            if (confirm("Tem certeza que deseja EXCLUIR este termo?")) {
                window.location.href = 'acoes.php?acao=excluir&id=' + id;
            }
        }
    </script>
</head>
<body class="tema-<?php echo $materia; ?>">
    <header><h1>Validação: <?php echo ucfirst($materia); ?></h1></header>
    <div class="container">
        <div style="margin-bottom: 20px;"><a href="selecao.php" class="btn" style="background:#444; color:white;">← Voltar</a></div>
        <?php
        $sql = "SELECT * FROM termos WHERE status = 'pendente' AND disciplina = '$materia' ORDER BY id DESC";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<div class='card-termo'>
                        <div style='display:flex; justify-content:space-between; align-items:center; width:100%;'>
                            <div><h3>{$row['termo']}</h3><p>{$row['definicao']}</p></div>
                            <div style='display:flex; gap:10px;'>
                                <button onclick='confirmarAprovacao({$row['id']})' class='btn' style='background:#28a745; color:white;'>Aprovar</button>
                                <button onclick='confirmarExclusao({$row['id']})' class='btn' style='background:#dc3545; color:white;'>Excluir</button>
                            </div>
                        </div>
                      </div>";
            }
        } else { echo "<p>Nenhum termo pendente.</p>"; }
        ?>
    </div>
</body>
</html>