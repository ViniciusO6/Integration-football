<?php
// Os imports são usados para adicionar links de fontes e bibliotecas externas no HTML
// No caso, estão substituindo as tradicionais tags <link rel="stylesheet">
$imports = [
  "https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,200;0,400;0,600;1,200;1,400;1,600&display=swap", // Importando fonte "Poppins"
  "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css", // Importando ícones do Font Awesome
  "https://fonts.gstatic.com/", // Link necessário para funcionar fontes do Google
  "https://fonts.googleapis.com/css2?family=Barlow&family=Teko:wght@300&display=swap",// Importando fontes adicionais
  "https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap"
];

// Variáveis que armazenam o título da página, os arquivos CSS e JS específicos da página
$titulo = 'Power Soccer'; // Título da página

$pageCSS = ["index.css"]; // Arquivo CSS específico da página
$pageJS = ["index.js"]; // Arquivo JS específico da página
$pageCSS = ["power_soccer.css"]; // Arquivo CSS dos Cards


// Inclui o arquivo index.php que contém a estrutura base da página
include_once('./templetes/index.php');
?>

<!--TOPO PRIMEIRA PARTE(FOTO E EXPLICAÇÃO)-->
<div class="container">

<section class="primeira-parte">
  <div class="interface">
    <div class="flex">
    <div class="img-topo-site">
      <img src="./Imagens/power_soccer1.jpg" alt="Power_Soccer1">
      </div><!--img-topo-site-->
        <div class="txt-topo-site">
          <h1>Power Soccer <img id="icon-card" src="./Imagens/jogador.png" alt=""></h1>
          <p>Futebol em Cadeira de Rodas</p><br>
          <p>Power Soccer, também conhecido como Futebol em Cadeira de Rodas, é um esporte adaptado para pessoas com deficiência motora que utilizam cadeiras de rodas motorizadas. Jogando em quadras internas, os atletas controlam suas cadeiras equipadas com escudos frontais para chutar e passar a bola. As partidas são disputadas por dois times de quatro jogadores, com regras semelhantes ao futebol tradicional, como gols, passes e dribles.</p>
        </div><!--txt-topo-site-->
    </div><!--flex-->
  </div><!--interface-->
</section><!--primeira-parte-->


<!--TOPO SEGUNDA PARTE (VÍDEO E EXPLICAÇÃO)-->
<section class="segunda-parte">
  <div class="interface-video">
    <div class="flex1">
        <div class="txt-topo-site">
          <h2>Como começou o Power Soccer? <img id="icon-card" srcPower="./Imagens/jogador.png" alt=""></h2>
          <p> O primeiro torneio foi realizado em 1982, e rapidamente ganhou popularidade, levando à formação de ligas e competições. O esporte combina estratégia, habilidades técnicas e trabalho em equipe, promovendo não apenas a inclusão, mas também a competição saudável. Desde então, o Power Soccer se espalhou pelo mundo, transformando vidas e desafiando estereótipos sobre a capacidade dos atletas.</p><br>
          </div><!--txt-topo-site-->
          <div class="video-topo-site">
        <iframe width="560" height="315" src="https://www.youtube.com/embed/OWhY7C64ILc?si=Ge2wSUPVtBJphFEI" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>      
          </div><!--video-topo-site-->
    </div><!--flex-->
  </div><!--interface-->
  <div class="triangulo"></div> <!-- Elemento decorativo (triângulo) -->

</section><!--segunda-parte-->


<div class= "fundo-azul">
  <div class="curva"></div>
  <div class="txt-topo-site">
     <h1>Por dentro do Power Soccer! <img id="icon-card" alt=""></h1>
  

  <div class="gallery">
        <img src="imagens/foto1.jpg" alt="Foto 1">
        <img src="imagens/foto2.jpg" alt="Foto 2">
        <img src="imagens/foto3.jpg" alt="Foto 3">
        <img src="imagens/foto4.jpg" alt="Foto 4">
        <img src="imagens/foto5.jpg" alt="Foto 5">
        <img src="imagens/foto6.png" alt="Foto 6">
      </div><!--gallery-->
  </div><!--fundo-azul-->
</div>
        
<div class="img-inscrever"> 
    <img src="imagens/img-inscrever.jpg" alt="">
    <div class="text-inscrever">
        <h1>SE INTERESSOU? NÃO PERCA TEMPO E SE INCREVA.</h1>
        <button id="btn-saiba-mais" type="button">INSCREVA-SE</button>
    </div><!-- text-inscrever -->
</div><!-- img-inscrever -->


</div><!--container-->


<?php
// Inclui o arquivo do rodapé (footer.php)
include_once('./templetes/footer.php');
?>