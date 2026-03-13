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
$id_professor = $_SESSION['professor_id']; 
$msg = "";

if ($id > 0) {
    if ($acao == 'aprovar') {
        $sql = "UPDATE termos SET status = 'aprovado', id_professor_validador = '$id_professor' WHERE id = $id";
        if ($conn->query($sql)) {
            $msg = "Termo aprovado com sucesso!";
        }
    } 
    elseif ($acao == 'pendente') {
        // Nova lógica: Volta o termo para análise e remove quem validou
        $sql = "UPDATE termos SET status = 'pendente', id_professor_validador = NULL WHERE id = $id";
        if ($conn->query($sql)) {
            $msg = "Termo movido para pendentes!";
        }
    }
    elseif ($acao == 'excluir') {
        $sql = "DELETE FROM termos WHERE id = $id";
        if ($conn->query($sql)) {
            $msg = "Termo excluído permanentemente!";
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