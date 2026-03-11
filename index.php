<?php 
include 'conexao.php'; 

$busca = isset($_GET['busca']) ? $_GET['busca'] : '';
$filtro_letra = isset($_GET['letra']) ? $_GET['letra'] : '';

$query = "SELECT * FROM termos WHERE status = 'aprovado'";
if (!empty($busca)) {
    $query .= " AND (termo LIKE '%$busca%' OR definicao LIKE '%$busca%')";
}
if (!empty($filtro_letra)) {
    $query .= " AND termo LIKE '$filtro_letra%'";
}
$query .= " ORDER BY termo ASC";
$result = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Dicionário Técnico - SENAI</title>

</head>
<body>
<header>
    <h1>Dicionário de Termos Técnicos</h1>
    <p>SENAI - Português & Matemática</p>
</header>
<div class="container">
    <div style="text-align: right; margin-top: 20px;">
        <a href="cadastrar.php" class="btn" style="background: #28a745; color: white; border-radius: 25px;">+ Sugerir Novo Termo</a>
    </div>
    <form class="busca-container" method="GET" action="index.php" style="display:flex; gap:10px; margin:20px 0;">
        <input type="text" name="busca" class="busca-input" placeholder="O que você está procurando?" value="<?php echo $busca; ?>" style="flex-grow:1; padding:12px; border-radius:20px; border:1px solid #ccc;">
        <button type="submit" class="btn" style="background: #444; color: white;">Buscar</button>
    </form>
    <div class="alfabeto" style="display:flex; justify-content:center; flex-wrap:wrap; gap:5px; margin-bottom:30px;">
        <?php foreach (range('A', 'Z') as $char): ?>
            <a href="index.php?letra=<?php echo $char; ?>" class="letra" style="padding:8px 12px; background:white; border:1px solid #ddd; text-decoration:none; color:#333; font-weight:bold;"><?php echo $char; ?></a>
        <?php endforeach; ?>
        <a href="index.php" class="letra" style="padding:8px 12px; background:#eee; border:1px solid #ddd; text-decoration:none; color:#333;">TODOS</a>
    </div>
    <div class="lista-termos">
        <?php if ($result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
                <div class="card-termo">
                    <div style="display: flex; gap: 20px; align-items: flex-start;">
                        <?php if($row['imagem_url']): ?>
                            <img src="<?php echo $row['imagem_url']; ?>" style="width:100px; height:100px; object-fit:cover; border-radius:8px;">
                        <?php endif; ?>
                        <div>
                            <span class="tag tag-<?php echo $row['disciplina']; ?>"><?php echo ucfirst($row['disciplina']); ?></span>
                            <h2 style="margin:10px 0;"><?php echo $row['termo']; ?></h2>
                            <p style="color:#555;"><?php echo $row['definicao']; ?></p>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p style="text-align:center; color:#888;">Nenhum termo encontrado.</p>
        <?php endif; ?>
    </div>
</div>
<footer style="text-align: center; margin: 50px 0; padding: 20px; border-top: 1px solid #ddd;">
    <a href="login.php" style="color: #999; text-decoration: none;">Acesso Restrito ao Professor</a>
</footer>
</body>
</html>