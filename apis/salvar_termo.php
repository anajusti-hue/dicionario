<?php
include 'conexao.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $termo = $conn->real_escape_string($_POST['termo']);
    $disciplina = $conn->real_escape_string($_POST['disciplina']);
    $definicao = $conn->real_escape_string($_POST['definicao']);
    $imagem = $conn->real_escape_string($_POST['imagem_url']);

    $sql = "INSERT INTO termos (termo, definicao, disciplina, imagem_url, status) 
            VALUES ('$termo', '$definicao', '$disciplina', '$imagem', 'pendente')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Sugestão enviada! Aguarde aprovação.'); window.location.href='index.php';</script>";
    } else {
        echo "Erro: " . $conn->error;
    }
}
?>