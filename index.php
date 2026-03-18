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
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <title>Dicionário Técnico SESI</title>
    
    <style>
        :root {
            /* PALETA ULTRA-MODERNA FIXA (CLARA) */
            --primary: #10b981; 
            --primary-dark: #064e3b; 
            --accent: #1e293b; 
            --bg-body: #f8fafc; 
            --text-dark: #0f172a;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--bg-body);
            color: var(--text-dark);
            font-size: 1rem;
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
        }

        /* Hero Section Premium (Verde Sólido) */
        .hero-section {
            padding: 100px 0 90px;
            background-color: var(--primary-dark);
            background-image: radial-gradient(circle at 1px 1px, rgba(255,255,255,0.03) 1px, transparent 0);
            background-size: 40px 40px;
            color: white;
            border-radius: 0 0 50px 50px;
            text-align: center;
            box-shadow: 0 15px 40px rgba(0,0,0,0.1);
            position: relative;
        }

        .search-container {
            background: rgba(255, 255, 255, 0.95);
            padding: 10px;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
            margin-top: 40px;
            display: flex;
            border: 2px solid rgba(255,255,255,0.3);
            backdrop-filter: blur(10px);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .search-container:focus-within {
            transform: translateY(-2px);
            box-shadow: 0 25px 50px rgba(0,0,0,0.25);
            border-color: rgba(255,255,255,0.8);
        }

        .form-control-custom {
            border: none;
            padding: 15px 25px;
            font-size: 1.15rem;
            width: 100%;
            outline: none;
            background: transparent;
            color: var(--text-dark);
            font-weight: 500;
        }

        /* Botões de Filtro Modernos */
        .btn-filter {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            font-weight: 700;
            background: white;
            color: var(--accent);
            padding: 12px 26px;
            border-radius: 16px;
            text-decoration: none;
            box-shadow: 0 4px 10px rgba(0,0,0,0.03);
            border: 1px solid rgba(0,0,0,0.02);
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        
        .btn-filter:hover { 
            background: #f1f5f9; 
            transform: translateY(-2px); 
            box-shadow: 0 8px 15px rgba(0,0,0,0.05);
        }
        
        .btn-active-all { background: linear-gradient(135deg, var(--primary) 0%, #059669 100%) !important; color: white !important; box-shadow: 0 10px 20px rgba(16, 185, 129, 0.3) !important; border: none; }
        .btn-active-port { background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%) !important; color: white !important; box-shadow: 0 10px 20px rgba(59, 130, 246, 0.3) !important; border: none; }
        .btn-active-mat { background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%) !important; color: white !important; box-shadow: 0 10px 20px rgba(239, 68, 68, 0.3) !important; border: none; }

        /* Alfabeto Estilizado */
        .alphabet-filter {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 8px;
            margin: 50px 0;
        }
        
        .alphabet-filter a {
            width: 42px;
            height: 42px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: white;
            color: var(--accent);
            text-decoration: none;
            border-radius: 12px;
            font-weight: 700;
            font-size: 1.1rem;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 2px 8px rgba(0,0,0,0.02);
            border: 1px solid rgba(0,0,0,0.01);
        }
        
        .alphabet-filter a:hover, .alphabet-filter a.active {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
            transform: translateY(-3px) scale(1.05);
            box-shadow: 0 10px 20px rgba(16, 185, 129, 0.35);
        }
        
        /* Estilo dos Cards Premium */
        .term-card {
            background: white;
            padding: 28px;
            border-radius: 24px;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
            height: 100%;
            display: flex;
            flex-direction: column;
            border: 1px solid rgba(0,0,0,0.03);
            box-shadow: 0 4px 15px rgba(0,0,0,0.02);
        }
        
        .term-card:hover { 
            transform: translateY(-12px); 
            box-shadow: 0 30px 60px rgba(0,0,0,0.08) !important; 
            border-color: rgba(16, 185, 129, 0.1);
        } 
        
        .img-container { 
            width: 100%; 
            height: 220px; 
            border-radius: 16px; 
            overflow: hidden; 
            margin-bottom: 20px; 
            background: #f1f5f9;
            position: relative;
        } 
        
        .img-container img { 
            width: 100%; 
            height: 100%; 
            object-fit: cover; 
            transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .term-card:hover .img-container img {
            transform: scale(1.1);
        }
        
        .badge-disc { 
            padding: 8px 16px; 
            border-radius: 10px; 
            font-size: 0.75rem; 
            font-weight: 800; 
            text-transform: uppercase; 
            letter-spacing: 0.5px;
            margin-bottom: 15px; 
            display: inline-block; 
        } 
        
        .bg-port { background: #eff6ff; color: #2563eb; } 
        .bg-mat { background: #fef2f2; color: #dc2626; } 
        
        .btn-sugerir { 
            display: inline-block; 
            margin-top: 30px; 
            padding: 14px 30px;
            background: rgba(255,255,255,0.1);
            color: white;
            text-decoration: none;
            border-radius: 16px;
            font-weight: 700;
            font-size: 1.05rem;
            transition: all 0.3s ease;
            border: 1px solid rgba(255,255,255,0.2);
            backdrop-filter: blur(5px);
        }
        
        .btn-sugerir:hover {
            background: white;
            color: var(--primary-dark);
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(255,255,255,0.25);
        }

        /* ------------------------------------------- */
        /* MODAL ULTRA-MODERNO (ANIMAÇÃO E IMAGEM)     */
        /* ------------------------------------------- */
        
        @keyframes modalFadeIn {
            from { opacity: 0; transform: translateY(30px) scale(0.98); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }

        .modal.show .modal-dialog {
            animation: modalFadeIn 0.4s cubic-bezier(0.4, 0, 0.2, 1) forwards;
        }

        .modal-content {
            border-radius: 32px;
            border: none;
            overflow: hidden;
            box-shadow: 0 40px 100px rgba(0,0,0,0.2);
            background: white;
        }

        .modal-backdrop.show {
            opacity: 0.65;
            backdrop-filter: blur(8px);
        }

        .modal-close-custom {
            position: absolute;
            top: 20px;
            right: 20px;
            z-index: 30;
            width: 45px;
            height: 45px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.6);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.8);
            border-radius: 50%;
            cursor: pointer;
            font-size: 1.2rem;
            color: var(--accent);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        }
        
        .modal-close-custom:hover {
            background: #ef4444; 
            color: white;
            border-color: #ef4444;
            transform: scale(1.15) rotate(90deg); 
            box-shadow: 0 15px 35px rgba(239, 68, 68, 0.4);
        }
        
        /* IMAGEM PERFEITA (EM PÉ OU DEITADA) */
        .modal-img-wrapper {
            width: 100%;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
            position: relative;
            border-bottom: 1px solid rgba(0,0,0,0.05);
        }

        .modal-img-wrapper img {
            max-width: 100%;
            max-height: 60vh; 
            width: auto;
            height: auto;
            object-fit: contain; 
            border-radius: 16px;
            box-shadow: 0 20px 50px rgba(0,0,0,0.15); 
            transition: transform 0.4s ease;
        }

        .modal-img-wrapper img:hover {
            transform: scale(1.03);
        }
        
        .modal-content-inner {
            padding: 50px;
            background: white;
        }
        
        .modal-title-custom {
            font-size: 3.2rem;
            letter-spacing: -1.5px;
            line-height: 1.1;
            font-weight: 800;
            color: var(--text-dark);
            margin-bottom: 25px;
        }
        
        .badge-modal {
            padding: 10px 20px;
            font-size: 0.85rem;
            font-weight: 800;
            text-transform: uppercase;
            border-radius: 12px;
            display: inline-flex;
            align-items: center;
        }

        .bg-port-modal { background: #eff6ff; color: #2563eb; border: 1px solid #bfdbfe; } 
        .bg-mat-modal { background: #fef2f2; color: #dc2626; border: 1px solid #fecaca; }

        .definition-container {
            background: #f8fafc;
            border-left: 6px solid var(--primary); 
            border-radius: 0 24px 24px 0;
            padding: 40px;
            margin-top: 30px;
            position: relative;
            overflow: hidden;
            box-shadow: inset 0 2px 10px rgba(0,0,0,0.01);
        }

        .definition-container::before {
            content: "\F6B0"; 
            font-family: "bootstrap-icons";
            position: absolute;
            top: -10px;
            right: 20px;
            font-size: 8rem;
            color: rgba(16, 185, 129, 0.05);
            z-index: 0;
            pointer-events: none;
            transform: rotate(10deg);
        }

        .definition-container > * {
            position: relative;
            z-index: 1;
        }

    </style>
</head>
<body>

<div class="hero-section">
    <div class="container" style="max-width: 850px;">
        <h1 class="fw-bold" style="font-size: 3.5rem; letter-spacing: -2px;">Dicionário SESI</h1>
        <p class="fs-5 opacity-75 mb-3">Explore e aprenda os termos técnicos da nossa escola</p>
        
        <form method="GET" class="search-container">
            <input type="text" name="busca" class="form-control-custom" placeholder="Pesquise por uma palavra..." value="<?php echo htmlspecialchars($busca); ?>">
            <button type="submit" class="btn rounded-4 px-4 fw-bold shadow-sm" style="background: var(--primary); border: none; color: white; font-weight: 800; font-size: 1.1rem;"><i class="bi bi-search"></i> Buscar</button>
        </form>

        <a href="cadastrar.php" class="btn-sugerir shadow-sm"><i class="bi bi-plus-circle me-2"></i> Sugerir Novo Termo</a>
    </div>
</div>

<div class="container py-5 mt-4" style="max-width: 1200px;">
    
    <div class="d-flex justify-content-center gap-3 mb-4 flex-wrap">
        <a href="index.php" class="btn-filter <?php echo empty($filtro_disciplina) ? 'btn-active-all' : ''; ?>"><i class="bi bi-grid-fill"></i> Todas as Matérias</a>
        <a href="index.php?disciplina=portugues" class="btn-filter <?php echo $filtro_disciplina == 'portugues' ? 'btn-active-port' : ''; ?>"><i class="bi bi-book-half"></i> Português</a>
        <a href="index.php?disciplina=matematica" class="btn-filter <?php echo $filtro_disciplina == 'matematica' ? 'btn-active-mat' : ''; ?>"><i class="bi bi-calculator-fill"></i> Matemática</a>
    </div>

    <div class="alphabet-filter">
        <?php
        $letras = range('A', 'Z');
        foreach ($letras as $letra) {
            $ativo = ($filtro_letra == $letra) ? 'active' : '';
            $url = "index.php?letra=$letra";
            if (!empty($filtro_disciplina)) $url .= "&disciplina=$filtro_disciplina";
            echo "<a href='$url' class='$ativo'>$letra</a>";
        }
        ?>
        <a href="index.php" class="text-danger" style="background: #fef2f2; border: 1px solid #fecaca;"><i class="bi bi-x-lg"></i></a>
    </div>

    <div class="row g-4 mt-2">
        <?php if ($result && $result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
                <div class="col-md-6 col-lg-4 col-xl-4 mb-3">
                    
                    <div class="term-card" data-bs-toggle="modal" data-bs-target="#modalDetalhes<?php echo $row['id']; ?>">
                        
                        <?php if(!empty($row['imagem_url'])): ?>
                            <div class="img-container">
                                <img src="<?php echo $row['imagem_url']; ?>" alt="Imagem do termo">
                            </div>
                        <?php endif; ?>
                        
                        <div>
                            <span class="badge-disc <?php echo $row['disciplina'] == 'portugues' ? 'bg-port' : 'bg-mat'; ?>">
                                <?php echo ucfirst($row['disciplina']); ?>
                            </span>
                        </div>
                        
                        <h3 class="fw-bold h4 mb-2 text-dark" style="letter-spacing: -1px;"><?php echo htmlspecialchars($row['termo']); ?></h3>
                        
                        <p class="text-muted small mb-3" style="display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; line-height: 1.6; font-size: 0.95rem;">
                            <?php echo htmlspecialchars($row['definicao']); ?>
                        </p>

                        <div class="mt-auto text-end pt-3" style="border-top: 1px solid rgba(0,0,0,0.05);">
                            <span class="fw-bold" style="color: var(--primary); font-size: 0.95rem;">Ver detalhes <i class="bi bi-arrow-right ms-1"></i></span>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="modalDetalhes<?php echo $row['id']; ?>" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-xl">
                        <div class="modal-content">
                            <button type="button" class="modal-close-custom" data-bs-dismiss="modal" aria-label="Close">
                                <i class="bi bi-x-lg"></i>
                            </button>
                            
                            <div class="modal-body p-0">
                                
                                <?php if(!empty($row['imagem_url'])): ?>
                                    <div class="modal-img-wrapper">
                                        <img src="<?php echo $row['imagem_url']; ?>" alt="Imagem do termo">
                                    </div>
                                <?php endif; ?>
                                
                                <div class="modal-content-inner">
                                    <div class="mb-3">
                                        <span class="badge-modal <?php echo $row['disciplina'] == 'portugues' ? 'bg-port-modal' : 'bg-mat-modal'; ?>">
                                            <i class="bi <?php echo $row['disciplina'] == 'portugues' ? 'bi-book-half' : 'bi-calculator-fill'; ?> me-2"></i>
                                            <?php echo ucfirst($row['disciplina']); ?>
                                        </span>
                                    </div>
                                    
                                    <h1 class="modal-title-custom"><?php echo htmlspecialchars($row['termo']); ?></h1>
                                    
                                    <div class="definition-container">
                                        <h4 class="fw-bold text-dark mb-3">
                                            <i class="bi bi-chat-square-quote-fill text-primary me-2"></i> Significado
                                        </h4>
                                        <p class="text-secondary fs-5 m-0" style="line-height: 1.8; font-weight: 500;">
                                            <?php echo nl2br(htmlspecialchars($row['definicao'])); ?>
                                        </p>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>

            <?php endwhile; ?>
        <?php else: ?>
            <div class="col-12 text-center py-5">
                <div class="p-5 bg-white rounded-5 shadow-sm" style="max-width: 550px; margin: auto; border: 1px solid rgba(0,0,0,0.03);">
                    <i class="bi bi-search text-muted mb-4" style="font-size: 4rem; opacity: 0.3;"></i>
                    <h4 class="fw-bold text-dark" style="letter-spacing: -1px;">Nenhuma palavra encontrada</h4>
                    <p class="text-muted mb-4 fs-5">Tente buscar por outro termo ou remova os filtros.</p>
                    <a href="index.php" class="btn btn-primary fw-bold rounded-pill px-4 py-2" style="background: var(--primary); border: none;">Voltar para o início</a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<footer class="text-center py-5 mt-5 bg-white border-top border-light-subtle">
    <div class="container" style="max-width: 600px;">
        <p class="text-muted mb-3 fw-bold fs-5">© <?php echo date('Y'); ?> Ana Clara e Nicolas</p>
        <p class="text-muted small mb-4">Projeto Educativo SESI</p>
        <a href="login.php" class="text-decoration-none small fw-bold mt-2 d-inline-block p-2 px-4 rounded-pill bg-light text-dark shadow-sm hover-lift" style="border: 1px solid rgba(0,0,0,0.05); transition: 0.3s;"><i class="bi bi-shield-lock-fill text-primary me-2"></i>Acesso aos Professores</a>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>