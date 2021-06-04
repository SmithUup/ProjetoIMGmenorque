<?php
include 'menu.html';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">


       <!-- Imagens do Success, Danger, Infor e etc -->
       <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
        <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
          <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
        </symbol>
        <symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
          <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
        </symbol>
        <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
          <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
        </symbol>
      </svg>

    <title>IMG < Marca D'água</title>

    <script>
    // Evita de reenviar o formulário
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
    </script> 

</head>

<body>
<br /><br />

    <div class=" bg-dark p-5 text-center text-white">       
        <h1 class="display-10">Insira uma Marca D'água em sua imagem.</h1>
        <hr>
    </div>


<div class="container">
<form method="POST" enctype="multipart/form-data" style="margin-top: 20px;">

    <div>
    <p class="fw-bold" style="margin-bottom:-2px">Imagem:</p>   
    <input class="form-control form-control-lg" id="formFileLg" type="file" name="imgback" accept="image/*" required>
    </div>
    <br />
    <div>
    <p class="fw-bold" style="margin-bottom:-2px"> Marca D'água (.png):</p>   
    <input class="form-control form-control-lg" id="formFileLg" type="file" name="img_md" accept="image/*" required>
    </div>

    <div class="dropdown">
        <a class="btn btn-dark dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
        Inserir logo no:
        </a>
      
        <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
          <li class="dropdown-item">Superior Esquerdo</li>
          <li class="dropdown-item" >Superior Meio</li>
          <li class="dropdown-item" >Superior Direito</li>
          <li class="dropdown-divider"></li>
          <li class="dropdown-item">Centro da Imagem</li>
          <li class="dropdown-divider"></li>
          <li class="dropdown-item" value="esquerdo" >Inferior Esquerdo</li>
          <li class="dropdown-item" >Inferior Meio</li>
          <li class="dropdown-item" >Inferior Direito</li>
        </ul>
      </div>

    
   
    <div class="d-grid gap-2">
    <input type="submit" value="Inserir Marca D'agua" class="btn btn-dark" style="margin-top: 10px;">
    </div>
</form>

</body>
</html>


<?php

if(isset($_FILES['imgback']))
{
$imgback = $_FILES['imgback']['tmp_name'];
$img_md = $_FILES['img_md']['tmp_name'];
$tipofotoback = substr($_FILES['imgback']['name'], -4);

        if($tipofotoback == "jpeg" or $tipofotoback == ".jpg")
        {
        //Capturando a largura e altura da imagem background.
        list($lg_ori, $alt_ori) = getimagesize($imgback);
        //Capturando a largura e altura da imagem marca D'agua.
        list($lg_md, $alt_md) = getimagesize($img_md);

        // //topo esquedo
        // $lg_ori_meio = 0;
        // $alt_ori_meio = 0;

        // //topo meio
        // $lg_ori_meio = ($lg_ori / 2) - ($lg_md / 2);
        // $alt_ori_meio = 0;

        // //topo direito
        // $lg_ori_meio = $lg_ori - $lg_md;
        // $alt_ori_meio = 0;
       
        //meio
        $lg_ori_meio = ($lg_ori / 2) - ($lg_md / 2);
        $alt_ori_meio = ($alt_ori / 2) - ($alt_md / 2);

        // //btt esquerdo
        // $lg_ori_meio = 0;
        // $alt_ori_meio = $alt_ori - $alt_md;

        // //btt esquerdo
        // $lg_ori_meio = ($lg_ori / 2) - ($lg_md / 2);
        // $alt_ori_meio = $alt_ori - $alt_md;
        
        // //btt direito
        // $lg_ori_meio = $lg_ori - $lg_md;
        // $alt_ori_meio = $alt_ori - $alt_md;
        
    
        //Criando uma img com o mesmo tamanho da imagem original.
        $img_final = imagecreatetruecolor($lg_ori, $alt_ori);

        //Capturando a imamgem original(back).
        $img_orginal = imagecreatefromjpeg($imgback);

        //Capturando a imamgem Marca D'agua.
        $marcadagua = imagecreatefrompng($img_md);

        //A imagem final é uma tela em branco.
        //Estamos copiando a Imagem Original(BACK) para essa tela em branco.
        imagecopy($img_final, $img_orginal, 0, 0, 0, 0, $lg_ori, $alt_ori);

        //Agora estamos copiando a marca dágua em cima da Imagem Final.
        imagecopy($img_final, $marcadagua, $lg_ori_meio, $alt_ori_meio, 0, 0, $lg_md, $alt_md);

        //Criando a imagem em PNG e salvando no diretório.
        imagepng($img_final, "img/teste.png");

        echo "IMG criada com sucesso.";
        }
        elseif($tipofotoback == ".png")
        {
        //Capturando a largura e altura da imagem background.
        list($lg_ori, $alt_ori) = getimagesize($imgback);

        //meio
        $lg_ori_meio = $lg_ori / 2;
        $alt_ori_meio = $lg_ori / 2;

        //Capturando a largura e altura da imagem marca D'agua.
        list($lg_md, $alt_md) = getimagesize($img_md);

        //Criando uma img com o mesmo tamanho da imagem original.
        $img_final = imagecreatetruecolor($lg_ori, $alt_ori);

        //Capturando a imamgem original(back).
        $img_orginal = imagecreatefrompng($imgback);

        //Capturando a imamgem Marca D'agua.
        $marcadagua = imagecreatefrompng($img_md);

        //A imagem final é uma tela em branco.
        //Estamos copiando a Imagem Original(BACK) para essa tela em branco.
        imagecopy($img_final, $img_orginal, 0, 0, 0, 0, $lg_ori, $alt_ori);

        //Agora estamos copiando a marca dágua em cima da Imagem Final.
        imagecopy($img_final, $marcadagua, $lg_ori_meio, $alt_ori_meio, 0, 0, $lg_md, $alt_md);

        //Criando a imagem em PNG e salvando no diretório.
        imagepng($img_final, "img/teste.png");

        echo "IMG criada com sucesso.";

        }
        else
        {
            echo "Erro na imamgem. Aceitamos apenas .JPG . JPEG e PNG no fundo e na Marca D'agua apenas .PNG";
        }

}
?>