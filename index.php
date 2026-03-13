<?php 
// 1. Conexão com o banco (Pasta config)
include 'config/conexao.php'; 

// 2. Captura dos filtros da URL
$busca = isset($_GET['busca']) ? $_GET['busca'] : '';
$filtro_letra = isset($_GET['letra']) ? $_GET['letra'] : '';
$filtro_disciplina = isset($_GET['disciplina']) ? $_GET['disciplina'] : '';

// 3. Construção da Query SQL Dinâmica
$query = "SELECT * FROM termos WHERE status = 'aprovado'";

if (!empty($busca)) { 
    $query .= " AND (termo LIKE '%$busca%' OR definicao LIKE '%$busca%')"; 
}
if (!empty($filtro_letra)) { 
    $query .= " AND termo LIKE '$filtro_letra%'"; 
}
if (!empty($filtro_disciplina)) { 
    $query .= " AND disciplina = '$filtro_disciplina'"; 
}

$query .= " ORDER BY termo ASC";
$result = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Dicionário SESI - Nivelamento</title>
    <style>
        .header-sesi { background: #333; color: white; padding: 40px 0; border-bottom: 5px solid #d32f2f; }
        /* Estilo para separar visualmente as matérias */
        .card-portugues { border-left: 8px solid #0056b3; }
        .card-matematica { border-left: 8px solid #b30000; }
        .letra-btn { min-width: 40px; margin: 2px; }
        .img-termo { width: 150px; height: 150px; object-fit: cover; border-radius: 8px; }
    </style>
</head>
<body class="bg-light">

<header class="header-sesi text-center mb-4 shadow">
    <h1 class="display-4 fw-bold">Dicionário de Termos Técnicos</h1>
    <p class="lead">Garantindo o entendimento de todos os alunos SESI</p>
</header>

<div class="container">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div class="d-flex gap-2">
            <a href="index.php?disciplina=portugues" class="btn btn-primary rounded-pill px-4 shadow-sm">📚 Português</a>
            <a href="index.php?disciplina=matematica" class="btn btn-danger rounded-pill px-4 shadow-sm">🔢 Matemática</a>
            <a href="index.php" class="btn btn-secondary rounded-pill shadow-sm">Ver Todos</a>
        </div>
        <a href="cadastrar.php" class="btn btn-success rounded-pill px-4 shadow-sm fw-bold">+ Sugerir Termo</a>
    </div>

    <form class="row g-2 mb-4" method="GET">
        <div class="col-md-10">
            <input type="text" name="busca" class="form-control form-control-lg rounded-pill shadow-sm" placeholder="O que você quer aprender hoje?" value="<?php echo htmlspecialchars($busca); ?>">
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-dark btn-lg w-100 rounded-pill shadow-sm">Buscar</button>
        </div>
    </form>

    <div class="text-center mb-4">
        <?php foreach (range('A', 'Z') as $char): ?>
            <a href="index.php?letra=<?php echo $char; ?><?php echo $filtro_disciplina ? "&disciplina=$filtro_disciplina" : ""; ?>" 
               class="btn btn-outline-secondary btn-sm letra-btn <?php echo $filtro_letra == $char ? 'active' : ''; ?>">
               <?php echo $char; ?>
            </a>
        <?php endforeach; ?>
    </div>

    <div class="row">
        <?php if ($result && $result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
                <div class="col-12 mb-3">
                    <div class="card shadow-sm <?php echo $row['disciplina'] == 'portugues' ? 'card-portugues' : 'card-matematica'; ?> border-0">
                        <div class="card-body d-flex gap-4 align-items-center flex-wrap flex-md-nowrap">
                            
                            <?php if(!empty($row['imagem_url'])): ?>
                                <img src="<?php echo $row['imagem_url']; ?>" alt="Imagem do termo" class="img-termo shadow-sm">
                            <?php endif; ?>

                            <div class="flex-grow-1">
                                <span class="badge <?php echo $row['disciplina'] == 'portugues' ? 'bg-primary' : 'bg-danger'; ?> mb-2">
                                    <?php echo ucfirst($row['disciplina']); ?>
                                </span>
                                <h2 class="card-title fw-bold text-dark h3"><?php echo htmlspecialchars($row['termo']); ?></h2>
                                <p class="card-text text-muted fs-5 mt-2"><?php echo htmlspecialchars($row['definicao']); ?></p>
                            </div>
                            
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="alert alert-warning text-center shadow-sm py-4">
                <h4>Ops! Nenhum termo encontrado.</h4>
                <p class="mb-0">Tente outra palavra ou verifique os filtros acima.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<footer class="text-center py-5 mt-5 border-top bg-white">
    <a href="login.php" class="text-decoration-none text-primary small">Entrar na Área do Professor</a>
    <p class="text-muted mb-1 small">&copy; 2026 Ana Clara e Nicolas - Dicionário de termos Técnicos</p>
   
</footer>

</body>
</html>