<?php

//Os imports subistituem os ( <link rel="stylesheet" href="/meu-projeto/css/styles.css">  )
//Basta colocar os links


require_once $_SERVER['DOCUMENT_ROOT'] . '/Integration-Football/Integration-Football/controller/professorcontroller.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/Integration-Football/Integration-Football/controller/turmacontroller.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/Integration-Football/Integration-Football/controller/modalidadecontroller.php';


$imports = [
  "https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,200;0,400;0,600;1,200;1,400;1,600&display=swap",
  "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css",
  "https://fonts.gstatic.com/",
  "https://fonts.googleapis.com/css2?family=Barlow&family=Teko:wght@300&display=swap"
];
$titulo = 'Meu Perfil | Professor';
$pageCSS = ["perfilProfessor.css"];
$pageJS = ["perfilProfessor.js"];

include_once('./templetes/headerProfessor.php');

$id = 5;
$idModalidade;

$professorController = new ProfessorController;
$professor = $professorController->buscarPorId($id);

$turmaController = new TurmaController;
$dados_turmas = $turmaController->buscarProfessor($id);


?>

<script>
  function enviarModalidade() {

var modalidade = document.getElementById("input-modalidade").value;
let tipo = "buscarTurmas";

var xhr = new XMLHttpRequest();
xhr.open("POST", "./ajax/perfilProfessorAjax.php", true); 
xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); 

xhr.send("modalidade=" + modalidade +"&tipo="+ tipo);


xhr.onload = function() {
    if (xhr.status === 200) {
        document.getElementById("select-turma").innerHTML = xhr.responseText;
    }
};


}

</script>


<div class="container">
  <div id="perfil">


    <form id="form" action="">
      <h1 id="titulo">Bem Vindo(a)!</h1>
      <div id="informacoes">


        <div id="bloco1">

          <label for="input-matricula">Matricula</label>
          <input id="input-matricula" type="text" name="matricula" value="<?= $professor['id']; ?>" disabled>

          <label for="input-nome">Nome</label>
          <input id="input-nome" type="text" name="nome" value="<?= $professor['nome_professor']; ?>" disabled>

          <div id="modalidade-turma">

          <div id="modalidade">
              <label for="input-modalidade">Modalidade</label>
              <select id="input-modalidade" onChange="enviarModalidade()">
              <?php
                $modalidadecontroller = new modalidadecontroller();
                $modalidades = $modalidadecontroller->listar();
                echo '<option value="" disabled selected hidden>Modalidade</option>';
                    $i = 0;
                    foreach ($modalidades as $modalidade) {
                    $i++;
                    echo "<option id='".$i."' value='" . $modalidade['id'] . "'>" . htmlspecialchars($modalidade['nome_modalidade']) . "</option>";
                    }
                    ?>


              </select>
            </div>

            <div id="turma">
              <label for="input-turma">Turma</label>
              <select id="select-turma">
                
                <option value="" disabled selected hidden>-</option>

              </select>
            </div>
          </div>

          <label for="input-professor">Cordenador Correspondente</label>
          <input id="input-professor" type="text" value="<?= $professor['nome_coordenador']; ?>" disabled>

          <label for="input-email">E-mail</label>
          <input id="input-email" type="text" value="<?= $professor['email_professor']; ?>" disabled>

          <label for="input-senha">Senha</label>
          <input id="input-senha" type="password" value="<?= $professor['senha']; ?>" disabled>
          <div id="btns">
          <button id="btn-enviar" type="submit">Alterar Email</button>
          <button id="btn-enviar" type="submit">Redefinir Senha</button>
        </div>
        </div>

        <div id="bloco2">
          <div id="foto-perfil">
            <button type="button" onclick="file()" id="btn-editar-foto"> <img src="./Imagens/editar.png" alt=""> </button>
            <input id="input-file" style="display: none;" type="file" name="foto">
          </div>

        </div>
      </div>
    </form>
  </div>

  <br><br><br><br><br>


<div id="redefinir-senha">
  <form action="">
    <h1>Redefinir Senha</h1>

    <label for="input-senha">Digite sua senha atual</label>
    <input id="input-senha" type="password" value="">

    <label for="input-senha">Digite sua nova senha</label>
    <input id="input-senha" type="password" value="">

    <label for="input-senha">Confirme sua nova senha</label>
    <input id="input-senha" type="password" value="">
    <div id="btns-redefinir">
      <button id="btn-confirmar" type="submit">Cancelar</button>
      <button id="btn-cancelar" type="button">Redefinir Senha</button>
    </div>
  </form>

</div><div id="sombra"></div>
</div>








<?php
include_once('./templetes/footer.php');
?>