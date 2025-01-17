<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// Imports dos estilos e definições do cabeçalho
$imports = [
    "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css",
    "https://fonts.gstatic.com/",
    "https://fonts.googleapis.com/css2?family=Barlow+Condensed:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
];
$titulo = 'Aceitar Inscrição';



include_once('./config.php');
if (!isset($_SESSION['id'])) {
    echo "Você precisa estar logado para acessar esta página.";
    exit;
}
// Recupera o ID da instituição a partir da sessão
$id_instituicao = $_SESSION['id'];

// Consulta SQL para pegar as informações da tabela instituicao
$sql = "SELECT * FROM instituicao WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_instituicao); // Bind do parâmetro do tipo inteiro
$stmt->execute();
$result = $stmt->get_result();

// Verificando se a consulta retornou algum resultado
if ($result->num_rows > 0) {
    // Pega os dados da instituição
    $instituicao = $result->fetch_assoc();
} else {
    // Se não encontrar nenhum resultado
    echo "Instituição não encontrada!";
    exit;
}
// Inclui o cabeçalho com base no padrão da instituição
include_once('./templetes/headerInstituicao.php');

// Verifica se a sessão já foi iniciada, se não, inicia a sessão



$sucessoCadastro = false; // Variável para controle de sucesso

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitização e recebimento do ID da inscrição
    $id = isset($_POST['id']) ? intval($_POST['id']) : null;
    if (!$id) {
        echo "ID não fornecido.";
        exit;
    }

    // Buscar os dados da inscrição
    $stmt = $conn->prepare("SELECT * FROM inscricao WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 0) {
        echo "Nenhuma inscrição encontrada para o ID: $id.";
        exit;
    }

    $inscricao = $result->fetch_assoc(); // Dados da inscrição

    // Verificar se o formulário foi enviado com a turma escolhida
    if (isset($_POST['turma'])) {
        $turma = $_POST['turma']; // ID da turma escolhida

        // Verificar se a turma existe no banco de dados
        $stmtTurma = $conn->prepare("SELECT id_turma FROM turma WHERE nome_turma = ?");
        $stmtTurma->bind_param("s", $turma);
        $stmtTurma->execute();
        $resultTurma = $stmtTurma->get_result();

        if ($resultTurma->num_rows === 0) {
            echo "Turma não encontrada.";
            exit;
        }

        $turmaData = $resultTurma->fetch_assoc();
        $idTurma = $turmaData['id_turma']; // ID da turma escolhida
        $foto_perfil = './Imagens/user.png';

        // Ajustes para garantir que CPF e telefone sejam armazenados corretamente
        $cpf = str_pad($inscricao['Cpf_inscrito'], 11, '0', STR_PAD_LEFT); // Garantir CPF com 11 dígitos
        $telefone = preg_replace('/\D/', '', $inscricao['telefone_inscrito']);
        if (strlen($telefone) == 10) {
            $telefone = '0' . $telefone; // Adiciona DDD se necessário
        }

        // Inserir os dados na tabela 'alunos'
        $senha = $_POST['senha'];
        echo $senha;
        $stmtAluno = $conn->prepare("
            INSERT INTO alunos (nome_aluno, email_aluno, id_turma, senha, data_nasc, cpf_aluno, telefone_aluno, foto_perfil) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $stmtAluno->bind_param(
            "ssisssss", 
            $inscricao['nome_inscrito'], 
            $inscricao['email_inscrito'],
            $idTurma,
            $senha,
            $inscricao['data_nasc'],
            $inscricao['Cpf_inscrito'],  
            $inscricao['telefone_inscrito'], 
            $foto_perfil
        );

        if ($stmtAluno->execute()) {
            // Atualizar o status da inscrição para "ativa"
            $stmtUpdate = $conn->prepare("UPDATE inscricao SET status = 'ativa' WHERE id = ?");
            $stmtUpdate->bind_param("i", $id);

            if ($stmtUpdate->execute()) {
                $sucessoCadastro = true; // Indica que o cadastro foi bem-sucedido
            } else {
                echo "Erro ao atualizar o status da inscrição.";
            }
        } else {
            echo "Erro ao cadastrar aluno: " . $stmtAluno->error;
        }
    }
}

// Buscar as turmas disponíveis no banco de dados para o select
$stmtTurmas = $conn->prepare("SELECT id_turma, nome_turma FROM turma");
$stmtTurmas->execute();
$resultTurmas = $stmtTurmas->get_result();
$turmas = [];
while ($row = $resultTurmas->fetch_assoc()) {
    $turmas[] = $row;
}
?>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/aceitarInscricao.css">
    <!-- Adicionando o link para a biblioteca SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<div class="container">
    <h1>CADASTRAR ALUNO </h1>
    <form action="aceitarInscricao.php" method="POST">
        <input type="hidden" name="id" value="<?= htmlspecialchars($id, ENT_QUOTES) ?>"> <!-- ID seguro -->

        <label for="nome">Nome do Aluno:</label>
        <input type="text" name="nome" id="nome" value="<?= htmlspecialchars($inscricao['nome_inscrito'], ENT_QUOTES) ?>" readonly>

        <label for="email">E-mail:</label>
        <input type="email" name="email" id="email" value="<?= htmlspecialchars($inscricao['email_inscrito'], ENT_QUOTES) ?>" readonly>

        <label for="unidade">Unidade:</label>
        <input type="text" name="unidade" id="unidade" value="<?= htmlspecialchars($inscricao['unidadeInscrito'], ENT_QUOTES) ?>" readonly>

        <label for="modalidade">Modalidade:</label>
        <input type="text" name="modalidade" id="modalidade" value="<?= htmlspecialchars($inscricao['modalidadeInscrito'], ENT_QUOTES) ?>" readonly>
        <input type="hidden" name="senha" id="modalidade" value="<?= htmlspecialchars($inscricao['senha_inscrito'], ENT_QUOTES) ?>" readonly>
        <label for="turma">Turma:</label>
        <select name="turma" id="turma" required>
            <?php foreach ($turmas as $turma): ?>
                <option value="<?= htmlspecialchars($turma['nome_turma'], ENT_QUOTES) ?>"><?= htmlspecialchars($turma['nome_turma'], ENT_QUOTES) ?></option>
            <?php endforeach; ?>
        </select>

        <button class="resposta" type="submit">Salvar</button>
    </form>
</div>

<script>
    <?php if ($sucessoCadastro): ?>
        Swal.fire({
            icon: 'success',
            title: 'Aluno cadastrado com sucesso!',
            text: 'A inscrição foi ativada e o aluno foi registrado.',
            iconColor: ' rgb(221, 161, 50)',
            confirmButtonText: 'OK',
            confirmButtonColor:' rgb(221, 161, 50)',
            customClass: {
                confirmButton: 'swal-custom-btn' // Classe personalizada para o botão
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Redireciona para a página de visualização de inscrições
                window.location.href = 'visualizarInscricoes.php';
            }
        });
    <?php endif; ?>
</script>



