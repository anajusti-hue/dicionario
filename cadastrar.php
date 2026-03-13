<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #F0F4F8; padding: 50px 0; }
        .form-card { background: white; padding: 40px; border-radius: 30px; box-shadow: 0 20px 40px rgba(0,0,0,0.05); }
        .form-control, .form-select { border-radius: 15px; padding: 12px; border: 1px solid #E2E8F0; margin-bottom: 20px; }
        .btn-send { background: #007BFF; border: none; padding: 15px; border-radius: 15px; font-weight: 700; color: white; width: 100%; }
    </style>
</head>
<body>
    <div class="container" style="max-width: 600px;">
        <div class="form-card">
            <h2 class="fw-bold mb-4 text-center">Sugerir Novo Termo</h2>
            <form action="./api/salvar_termo.php" method="POST" enctype="multipart/form-data">
                <label class="fw-bold mb-2">Termo Técnico</label>
                <input type="text" name="termo" class="form-control" placeholder="Ex: Adjetivo" required>
                
                <label class="fw-bold mb-2">Disciplina</label>
                <select name="disciplina" class="form-select">
                    <option value="portugues">Português</option>
                    <option value="matematica">Matemática</option>
                </select>

                <label class="fw-bold mb-2">Definição</label>
                <textarea name="definicao" class="form-control" rows="5" placeholder="Explique o que significa..." required></textarea>

                <label class="fw-bold mb-2">Imagem Ilustrativa</label>
                <input type="file" name="foto" class="form-control" accept="image/*">

                <button type="submit" class="btn-send shadow" style="background: #10b981; color: white; border: none; padding: 15px; border-radius: 15px; font-weight: 800; width: 100%;">Enviar Sugestão</button>
            </form>
            <div class="text-center mt-4">
                <a href="index.php" class="text-muted text-decoration-none">← Voltar ao dicionário</a>
            </div>
        </div>
    </div>
</body>
</html>