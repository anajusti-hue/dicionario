<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/style.css">
    <title>Escolha a Disciplina</title>
</head>
<body>
    <header><h1>Painel de Gestão</h1></header>
    <div class="container">
        <div class="grid-selecao" style="display:flex; gap:20px; justify-content:center; margin-top:50px;">
            <div class="card-materia" style="background-color: #0056b3; padding:40px; color:white; cursor:pointer; border-radius:15px; width:250px; text-align:center;" onclick="location.href='admin.php?materia=portugues'">
                <h2>Português</h2>
                <p>Gerenciar Termos</p>
            </div>
            <div class="card-materia" style="background-color: #b30000; padding:40px; color:white; cursor:pointer; border-radius:15px; width:250px; text-align:center;" onclick="location.href='admin.php?materia=matematica'">
                <h2>Matemática</h2>
                <p>Gerenciar Termos</p>
            </div>
        </div>
    </div>
</body>
</html>