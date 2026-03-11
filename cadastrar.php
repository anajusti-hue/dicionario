<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/style.css">
    <title>Sugerir Novo Termo</title>
</head>
<body>
    <header><h1>Sugerir Termo Técnico</h1></header>
    <div class="container" style="max-width: 500px; margin-top: 30px;">
        <div style="background: white; padding: 30px; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
            <form action="./api/salvar_termo.php" method="POST">
                <label>Termo Técnico:</label>
                <input type="text" name="termo" required style="width:100%; padding:10px; margin: 10px 0;">
                <label>Disciplina:</label>
                <select name="disciplina" style="width:100%; padding:10px; margin: 10px 0;">
                    <option value="portugues">Português</option>
                    <option value="matematica">Matemática</option>
                </select>
                <label>Definição:</label>
                <textarea name="definicao" rows="5" required style="width:100%; padding:10px; margin: 10px 0;"></textarea>
                <label>Link da Imagem:</label>
                <input type="text" name="imagem_url" style="width:100%; padding:10px; margin: 10px 0;">
                <button type="submit" class="btn" style="background: #28a745; color: white; width: 100%;">ENVIAR SUGESTÃO</button>
                <a href="index.php" style="display:block; text-align:center; margin-top:15px; color:#666;">Voltar</a>
            </form>
        </div>
    </div>
</body>
</html>