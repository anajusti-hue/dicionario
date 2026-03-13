<?php
// AJUSTE: ../ sai da pasta 'api' e entra na 'config' para achar o banco
include '../config/conexao.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$acao = isset($_GET['acao']) ? $_GET['acao'] : '';
$msg = "";

if ($id > 0) {
    if ($acao == 'aprovar') {
        // Muda o status para aprovado para aparecer na index.php
        $sql = "UPDATE termos SET status = 'aprovado' WHERE id = $id";
        if ($conn->query($sql)) {
            $msg = "Termo aprovado com sucesso!";
        }
    } elseif ($acao == 'excluir') {
        // Deleta o registro do banco
        $sql = "DELETE FROM termos WHERE id = $id";
        if ($conn->query($sql)) {
            $msg = "Termo excluído!";
        }
    }
} else {
    $msg = "Erro: ID inválido.";
}

// Retorna para a página onde o professor estava (admin.php) com um alerta
echo "<script>
    alert('$msg');
    window.location.href = '" . $_SERVER['HTTP_REFERER'] . "';
</script>";
?>