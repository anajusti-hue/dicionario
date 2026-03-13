<?php
session_start();
include '../config/conexao.php';

// Segurança: Verifica se há um professor logado
if (!isset($_SESSION['professor_logado'])) {
    header("Location: ../login.php");
    exit();
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$acao = isset($_GET['acao']) ? $_GET['acao'] : '';
$id_professor = $_SESSION['professor_id']; // Pega o ID da sessão
$msg = "";

if ($id > 0) {
    if ($acao == 'aprovar') {
        // AJUSTE: Agora preenche também quem foi o professor que validou
        $sql = "UPDATE termos SET status = 'aprovado', id_professor_validador = '$id_professor' WHERE id = $id";
        if ($conn->query($sql)) {
            $msg = "Termo aprovado com sucesso!";
        }
    } elseif ($acao == 'excluir') {
        $sql = "DELETE FROM termos WHERE id = $id";
        if ($conn->query($sql)) {
            $msg = "Termo excluído!";
        }
    }
} else {
    $msg = "Erro: ID inválido.";
}

echo "<script>
    alert('$msg');
    window.location.href = '" . $_SERVER['HTTP_REFERER'] . "';
</script>";
?>