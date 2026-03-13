<?php 
// 1. Conexão com o banco
include 'config/conexao.php'; 

// 2. Captura dos filtros
$busca = isset($_GET['busca']) ? $_GET['busca'] : '';
$filtro_letra = isset($_GET['letra']) ? $_GET['letra'] : '';
$filtro_disciplina = isset($_GET['disciplina']) ? $_GET['disciplina'] : '';

// 3. Query Dinâmica
$query = "SELECT * FROM termos WHERE status = 'aprovado'";
if (!empty($busca)) { $query .= " AND (termo LIKE '%$busca%' OR definicao LIKE '%$busca%')"; }
if (!empty($filtro_letra)) { $query .= " AND termo LIKE '$filtro_letra%'"; }
if (!empty($filtro_disciplina)) { $query .= " AND disciplina = '$filtro_disciplina'"; }
$query .= " ORDER BY termo ASC";
$result = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;800&display=swap" rel="stylesheet">
    <title>Dicionário Técnico SESI</title>
    <style>
        :root {
            /* PALETA EMERALD & SLATE */
            --primary: #10b981; /* Verde Esmeralda */
            --primary-dark: #064e3b; /* Verde Floresta Profundo */
            --accent: #334155; /* Cinza Ardósia */
            --bg-body: #f1f5f9;
            --text-dark: #0f172a;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--bg-body);
            color: var(--text-dark);
        }

        /* Hero Section - Elegante e Sóbrio */
        .hero-section {
            padding: 80px 0;
            background-color: var(--primary-dark);
            background-image: radial-gradient(circle at 2px 2px, rgba(255,255,255,0.05) 1px, transparent 0);
            background-size: 32px 32px;
            color: white;
            border-radius: 0 0 40px 40px;
            text-align: center;
        }

        .search-container {
            background: white;
            padding: 8px;
            border-radius: 18px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            margin-top: 30px;
        }

        .form-control-custom {
            border: none;
            padding: 12px 20px;
            font-size: 1.1rem;
            width: 100%;
            outline: none;
            background: transparent;
        }

        /* Botões de Filtro de Disciplina */
        .btn-filter {
            transition: 0.3s;
            font-weight: 700;
            border: 2px solid transparent;
            background: white;
            color: var(--accent);
        }
        
        .btn-active-all { background: var(--primary) !important; color: white !important; }
        .btn-active-port { background: #2563eb !important; color: white !important; }
        .btn-active-mat { background: #e11d48 !important; color: white !important; }

        /* Alfabeto */
        .alphabet-filter {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 8px;
            margin: 40px 0;
        }
        .letter-btn {
            width: 38px;
            height: 38px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            background: white;
            color: var(--accent);
            text-decoration: none;
            font-weight: 600;
            border: 1px solid #e2e8f0;
            transition: 0.2s;
        }
        .letter-btn:hover, .letter-btn.active { 
            background: var(--primary-dark); 
            color: white; 
            border-color: var(--primary-dark);
        }

        /* Cards de Termos */
        .term-card {
            background: white;
            border: none;
            border-radius: 24px;
            padding: 25px;
            transition: 0.4s;
            height: 100%;
            border-bottom: 4px solid transparent;
        }
        .term-card:hover { 
            transform: translateY(-8px); 
            box-shadow: 0 20px 30px rgba(0,0,0,0.05);
            border-bottom-color: var(--primary);
        }
        
        .img-container { width: 100%; height: 180px; border-radius: 18px; overflow: hidden; margin-bottom: 18px; }
        .img-container img { width: 100%; height: 100%; object-fit: cover; }

        .badge-disc { padding: 6px 14px; border-radius: 10px; font-size: 0.75rem; font-weight: 800; text-transform: uppercase; margin-bottom: 12px; display: inline-block; }
        .bg-port { background: #eff6ff; color: #2563eb; }
        .bg-mat { background: #fff1f2; color: #e11d48; }

        .btn-sugerir {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 25px;
            background: var(--primary);
            color: white;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 700;
            transition: 0.3s;
        }
        .btn-sugerir:hover { background: #059669; transform: scale(1.05); color: white; }
    </style>
</head>
<body>

<section class="hero-section">
    <div class="container">
        <h1 class="fw-800 display-4">Dicionário Técnico</h1>
        <p class="opacity-75 fs-5">A sua base de conhecimento para Português e Matemática</p>
        
        <div class="row justify-content-center">
            <div class="col-md-7">
                <div class="search-container">
                    <form action="index.php" method="GET" class="d-flex align-items-center">
                        <input type="text" name="busca" class="form-control-custom" placeholder="O que deseja pesquisar?" value="<?php echo $busca; ?>">
                        <button type="submit" class="btn px-4 py-2 rounded-pill me-1 fw-bold" style="background: var(--primary-dark); color: white;">Buscar</button>
                    </form>
                </div>
            </div>
        </div>
        <a href="cadastrar.php" class="btn-sugerir shadow">+ Sugerir Termo</a>
    </div>
</section>

<div class="container mt-5">
    <div class="d-flex justify-content-center flex-wrap gap-3 mb-4">
        <a href="index.php" class="btn btn-filter shadow-sm px-4 py-2 rounded-pill <?php echo empty($filtro_disciplina) ? 'btn-active-all' : ''; ?>">
            📚 Todos
        </a>
        <a href="index.php?disciplina=portugues" class="btn btn-filter shadow-sm px-4 py-2 rounded-pill <?php echo $filtro_disciplina == 'portugues' ? 'btn-active-port' : ''; ?>" style="border-color: #2563eb33;">
            📖 Português
        </a>
        <a href="index.php?disciplina=matematica" class="btn btn-filter shadow-sm px-4 py-2 rounded-pill <?php echo $filtro_disciplina == 'matematica' ? 'btn-active-mat' : ''; ?>" style="border-color: #e11d4833;">
            📐 Matemática
        </a>
    </div>

    <div class="alphabet-filter">
        <?php foreach (range('A', 'Z') as $l): ?>
            <a href="index.php?letra=<?php echo $l; ?>&disciplina=<?php echo $filtro_disciplina; ?>" 
               class="letter-btn shadow-sm <?php echo ($filtro_letra == $l) ? 'active' : ''; ?>">
               <?php echo $l; ?>
            </a>
        <?php endforeach; ?>
    </div>

    <div class="row g-4">
        <?php if ($result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
                <div class="col-md-4">
                    <div class="term-card shadow-sm">
                        <?php if(!empty($row['imagem_url'])): ?>
                            <div class="img-container">
                                <img src="<?php echo $row['imagem_url']; ?>" alt="Termo Técnico">
                            </div>
                        <?php endif; ?>
                        
                        <span class="badge-disc <?php echo $row['disciplina'] == 'portugues' ? 'bg-port' : 'bg-mat'; ?>">
                            <?php echo $row['disciplina']; ?>
                        </span>
                        
                        <h3 class="fw-bold h4 mb-2 text-dark"><?php echo htmlspecialchars($row['termo']); ?></h3>
                        <p class="text-muted small mb-0"><?php echo htmlspecialchars($row['definicao']); ?></p>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="col-12 text-center py-5">
                <h4 class="text-muted">Nenhum termo encontrado para esta seleção.</h4>
            </div>
        <?php endif; ?>
    </div>
</div>

<footer class="py-5 mt-5 text-center bg-white border-top">
    <p class="text-muted small mb-1">© Ana Clara e Nicolas 2026 - Projeto Educativo SESI</p>
    <a href="login.php" class="text-decoration-none fw-bold" style="color: var(--primary-dark);">Área do Professor</a>
</footer>

</body>
</html>