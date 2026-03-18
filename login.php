<?php
session_start();
include 'config/conexao.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nif = $conn->real_escape_string($_POST['nif']);
    $senha = $_POST['senha']; 
    $sql = "SELECT * FROM professores WHERE nif = '$nif' AND senha = '$senha'";
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        $dados = $result->fetch_assoc();
        $_SESSION['professor_logado'] = true;
        $_SESSION['professor_id'] = $dados['id'];
        $_SESSION['professor_nome'] = $dados['nome'];
        header("Location: selecao.php"); exit();
    } else { $erro = "NIF ou Senha inválidos!"; }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <title>Login Professor - Dicionário SESI</title>
    
    <style>
        :root {
            --primary: #10b981; 
            --primary-dark: #064e3b; 
            --bg-body: #f8fafc; 
            --text-dark: #0f172a;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--bg-body);
            color: var(--text-dark);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            -webkit-font-smoothing: antialiased;
        }

        .login-card {
            background: white;
            border-radius: 24px;
            padding: 40px;
            width: 100%;
            max-width: 450px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.05);
            border: 1px solid rgba(0,0,0,0.03);
            transition: all 0.3s ease;
        }

        .login-card:hover {
            box-shadow: 0 30px 60px rgba(0,0,0,0.08);
            transform: translateY(-5px);
        }

        .logo-circle {
            width: 80px;
            height: 80px;
            background: rgba(16, 185, 129, 0.1);
            color: var(--primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            margin: 0 auto 20px;
        }

        .form-control-custom {
            border: 2px solid rgba(0,0,0,0.05);
            border-radius: 14px;
            padding: 14px 20px;
            font-size: 1rem;
            background: #f8fafc;
            transition: all 0.3s ease;
        }

        .form-control-custom:focus {
            border-color: var(--primary);
            background: white;
            box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1);
            outline: none;
        }

        .btn-login {
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 14px;
            padding: 14px;
            font-weight: 700;
            font-size: 1.1rem;
            width: 100%;
            transition: all 0.3s ease;
            margin-top: 10px;
        }

        .btn-login:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(16, 185, 129, 0.2);
        }

        .btn-voltar {
            display: block;
            text-align: center;
            margin-top: 25px;
            color: #64748b;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.95rem;
            transition: 0.3s;
        }

        .btn-voltar:hover {
            color: var(--primary);
        }

        /* Estilo do Ícone de Senha */
        .password-container {
            position: relative;
        }

        .toggle-password-icon {
            position: absolute;
            top: 50%;
            right: 15px;
            transform: translateY(-50%);
            cursor: pointer;
            color: #94a3b8;
            font-size: 1.2rem;
            transition: color 0.3s;
        }

        .toggle-password-icon:hover {
            color: var(--primary);
        }
    </style>
</head>
<body>

    <div class="container d-flex justify-content-center">
        <div class="login-card">
            
            <div class="logo-circle">
                <i class="bi bi-person-badge-fill"></i>
            </div>

            <h2 class="fw-bold text-center mb-2" style="letter-spacing: -1px;">Painel do Professor</h2>
            <p class="text-muted text-center mb-4 pb-2">Faça o login para gerir o dicionário</p>

            <?php if(isset($erro)): ?>
                <div class="alert alert-danger rounded-4 text-center fw-bold" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i> <?php echo $erro; ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="">
                
                <div class="mb-3">
                    <label class="form-label fw-bold text-dark small">NIF</label>
                    <input type="text" name="nif" class="form-control-custom w-100" placeholder="Seu NIF" required>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold text-dark small">Senha</label>
                    <div class="password-container">
                        <input type="password" name="senha" id="inputSenha" class="form-control-custom w-100" placeholder="Sua Senha" required>
                        <i class="bi bi-eye toggle-password-icon" id="iconeOlho" title="Mostrar/Esconder Senha"></i>
                    </div>
                </div>

                <button type="submit" class="btn-login shadow-sm">
                    <i class="bi bi-box-arrow-in-right me-2"></i> Entrar no Sistema
                </button>

            </form>

            <a href="index.php" class="btn-voltar">
                <i class="bi bi-arrow-left me-1"></i> Voltar ao Dicionário
            </a>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const inputSenha = document.getElementById('inputSenha');
            const iconeOlho = document.getElementById('iconeOlho');

            iconeOlho.addEventListener('click', function() {
                // Se estiver como password, muda para text. Se não, volta para password.
                if (inputSenha.type === 'password') {
                    inputSenha.type = 'text';
                    iconeOlho.classList.remove('bi-eye');
                    iconeOlho.classList.add('bi-eye-slash'); // Ícone de olho riscado
                } else {
                    inputSenha.type = 'password';
                    iconeOlho.classList.remove('bi-eye-slash');
                    iconeOlho.classList.add('bi-eye'); // Ícone de olho normal
                }
            });
        });
    </script>

</body>
</html>