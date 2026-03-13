<?php
// AJUSTE: ../ sai da pasta 'api' e entra na 'config'
include '../config/conexao.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Escapa caracteres especiais para evitar erros no SQL
    $termo = $conn->real_escape_string($_POST['termo']);
    $disciplina = $conn->real_escape_string($_POST['disciplina']);
    $definicao = $conn->real_escape_string($_POST['definicao']);
    
    // Opcional: caso você use imagens, senão deixe vazio
    $imagem = isset($_POST['imagem_url']) ? $conn->real_escape_string($_POST['imagem_url']) : '';

    // Insere como 'pendente' para o professor validar depois
    $sql = "INSERT INTO termos (termo, definicao, disciplina, imagem_url, status) 
            VALUES ('$termo', '$definicao', '$disciplina', '$imagem', 'pendente')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>
                alert('Sugestão enviada com sucesso! Aguarde a avaliação do professor.');
                window.location.href='../index.php';
              </script>";
    } else {
        echo "Erro ao salvar: " . $conn->error;
    }
}
?>