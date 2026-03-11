<?php
include 'conexao.php';
$id = (int)$_GET['id'];
$acao = $_GET['acao'];
$msg = "";

if ($acao == 'aprovar') {
    $conn->query("UPDATE termos SET status = 'aprovado' WHERE id = $id");
    $msg = "Termo aprovado com sucesso!";
} elseif ($acao == 'excluir') {
    $conn->query("DELETE FROM termos WHERE id = $id");
    $msg = "Termo excluído!";
}

echo "<script>alert('$msg'); window.location.href = '" . $_SERVER['HTTP_REFERER'] . "';</script>";
?>