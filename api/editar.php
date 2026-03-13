<?php
session_start();
// Segurança: Verifica se o professor está logado
if (!isset($_SESSION['professor_logado'])) { header("Location: ../login.php"); exit(); }

// Caminho para a conexão (saindo da pasta api)
include '../config/conexao.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id > 0) {
    $sql = "SELECT * FROM termos WHERE id = $id";
    $res = $conn->query($sql);
    $termo = $res->fetch_assoc();
}

if (!$termo) {
    echo "<script>alert('Termo não encontrado!'); window.location.href='../admin.php';</script>";
    exit();
}

// Lógica para salvar a edição
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $txt_termo = $conn->real_escape_string($_POST['termo']);
    $txt_def = $conn->real_escape_string($_POST['definicao']);
    $caminho_final = $termo['imagem_url']; // Mantém a imagem atual por padrão

    // Verifica se uma NOVA imagem foi enviada
    if (isset($_FILES['nova_foto']) && $_FILES['nova_foto']['error'] === 0) {
        $extensao = pathinfo($_FILES['nova_foto']['name'], PATHINFO_EXTENSION);
        $novo_nome = md5(uniqid()) . "." . $extensao;
        $destino = "../uploads/" . $novo_nome;

        if (move_uploaded_file($_FILES['nova_foto']['tmp_name'], $destino)) {
            // Se subiu a nova, podemos apagar a antiga da pasta para não encher o servidor (opcional)
            if (!empty($termo['imagem_url']) && file_exists("../" . $termo['imagem_url'])) {
                unlink("../" . $termo['imagem_url']);
            }
            $caminho_final = "uploads/" . $novo_nome;
        }
    }

    $update = "UPDATE termos SET termo = '$txt_termo', definicao = '$txt_def', imagem_url = '$caminho_final' WHERE id = $id";
    
    if ($conn->query($update)) {
        echo "<script>alert('Alterações salvas com sucesso!'); window.location.href='../admin.php?materia=".$termo['disciplina']."';</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Editar Termo - SESI</title>
    <style>
        body { background-color: #f8f9fa; }
        .header-edit { 
            background-color: <?php echo $termo['disciplina'] == 'portugues' ? '#007BFF' : '#DC3545'; ?>; 
            color: white; padding: 20px 0; margin-bottom: 30px;
        }
        .card-edit { border-radius: 15px; border: none; box-shadow: 0 4px 15px rgba(0,0,0,0.1); background: white; }
        .img-atual { width: 100%; max-height: 200px; object-fit: contain; border-radius: 10px; margin-bottom: 15px; border: 1px solid #ddd; }
    </style>
</head>
<body>

<header class="header-edit text-center shadow-sm">
    <h2 class="fw-bold">Editando: <?php echo htmlspecialchars($termo['termo']); ?></h2>
</header>

<div class="container mb-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card card-edit p-4">
                <form method="POST" enctype="multipart/form-data">
                    
                    <div class="mb-3 text-center">
                        <label class="form-label fw-bold d-block">Imagem Atual:</label>
                        <?php if(!empty($termo['imagem_url'])): ?>
                            <img src="../<?php echo $termo['imagem_url']; ?>" class="img-atual">
                        <?php else: ?>
                            <div class="p-3 bg-light text-muted border rounded mb-3">Sem imagem cadastrada</div>
                        <?php endif; ?>
                        
                        <label class="form-label fw-bold">Alterar Imagem (opcional):</label>
                        <input type="file" name="nova_foto" class="form-control" accept="image/*">
                    </div>

                    <hr>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Nome do Termo:</label>
                        <input type="text" name="termo" class="form-control" value="<?php echo htmlspecialchars($termo['termo']); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Definição:</label>
                        <textarea name="definicao" class="form-control" rows="5" required><?php echo htmlspecialchars($termo['definicao']); ?></textarea>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-success btn-lg fw-bold">Salvar Alterações</button>
                        <a href="../admin.php?materia=<?php echo $termo['disciplina']; ?>" class="btn btn-light">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

</body>
</html>