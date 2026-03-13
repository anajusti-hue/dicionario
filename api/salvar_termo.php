<?php
include '../config/conexao.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $termo = $conn->real_escape_string($_POST['termo']);
    $disciplina = $conn->real_escape_string($_POST['disciplina']);
    $definicao = $conn->real_escape_string($_POST['definicao']);
    
    $caminho_imagem = null;

    // Lógica para processar o upload da imagem
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === 0) {
        $extensao = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
        $novo_nome = md5(uniqid()) . "." . $extensao; // Nome aleatório para o ficheiro
        $diretorio_destino = "../uploads/" . $novo_nome;

        if (move_uploaded_file($_FILES['foto']['tmp_name'], $diretorio_destino)) {
            $caminho_imagem = "uploads/" . $novo_nome; // Caminho guardado no banco
        }
    }

    $sql = "INSERT INTO termos (termo, definicao, disciplina, imagem_url, status) 
            VALUES ('$termo', '$definicao', '$disciplina', '$caminho_imagem', 'pendente')";

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