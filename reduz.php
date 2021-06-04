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

    <title>IMG < Redução</title>

    <script>
    // Evita de reenviar o formulário
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
    </script> 

</head>

<?php

if(isset($_FILES['img']) && !empty($_FILES['img']))
{
$img = $_FILES['img'];
$qualidade = addslashes($_POST['qualidade']);
$tipofoto = substr($img['name'], -4);

        if($tipofoto == "jpeg" or $tipofoto == ".jpg")
        {
            $arquivo = md5(time().rand(0,99999)).'.'.$tipofoto;
            move_uploaded_file($img['tmp_name'], 'img/'.$arquivo);

            //O GetImagesSize é um arrya com duas variaeis do arquivo, altura e largura.
            list($larguraOriginal, $alturaOriginal) = getimagesize('img/'.$arquivo);

            //Criando uma imagem em branco com o tamanho especulado.
            $imageFinal = imagecreatetruecolor($larguraOriginal, $alturaOriginal);

            //Criando um JPEG da img original, se quiser PNG insira imagecreatefrompng
            $imageOriginal = imagecreatefromjpeg('img/'.$arquivo);

            //Estamos copiando a imagem final a oartur da original, inicializando de ambos ponto X e Y 0,
            imagecopyresampled($imageFinal, $imageOriginal, 0, 0, 0, 0, $larguraOriginal, $alturaOriginal, $larguraOriginal, $alturaOriginal);

            imagejpeg($imageFinal, "img/".$arquivo, $qualidade);
        }

        elseif($tipofoto == ".png")
        {
            $arquivo = md5(time().rand(0,99999)).'.'.$tipofoto;
            move_uploaded_file($img['tmp_name'], 'img/'.$arquivo);
    
            //O GetImagesSize é um arrya com duas variaeis do arquivo, altura e largura.
            list($larguraOriginal, $alturaOriginal) = getimagesize('img/'.$arquivo);
    
            //Criando uma imagem em branco com o tamanho especulado.
            $imageFinal = imagecreatetruecolor($larguraOriginal, $alturaOriginal);
    
            //Criando um JPEG da img original, se quiser PNG insira imagecreatefrompng
            $imageOriginal = imagecreatefrompng('img/'.$arquivo);

            //Mantendo a transparência
            imagealphablending($imageFinal, false);
            imagesavealpha($imageFinal, true);

            $qualidade = $qualidade / 10;
    
            //Estamos copiando a imagem final a oartur da original, inicializando de ambos ponto X e Y 0,
            imagecopyresampled($imageFinal, $imageOriginal, 0, 0, 0, 0, $larguraOriginal, $alturaOriginal, $larguraOriginal, $alturaOriginal);
    
            imagepng($imageFinal, "img/".$arquivo, (int)$qualidade);
        }

        else
        {
            echo "<div class='alert alert-danger' role='alert'>
            <svg class='bi flex-shrink-0 me-2' width='24' height='2' role='img' aria-label='Danger:'><use xlink:href='#exclamation-triangle-fill'/></svg>
            No momento só aceitamos .JPG . JPEG e .PNG!
            </div>";
        }


}

?>



<body>
<br /><br />

    <div class=" bg-dark p-5 text-center text-white">
        <h1 class="display-10">Reduza o peso da sua imagem, mantendo as dimensões.</h1>
        <hr>
    </div>


<div class="container">
    
<form method="POST" enctype="multipart/form-data" style="margin-top: 20px;">

    <div>
    <input class="form-control form-control-lg" id="formFileLg" type="file" name="img" accept="image/*" required>
    </div>
    
    <div class="input-group mb-3">
     <input type="number" class="form-control" placeholder="Qualidade de 1-99 %" aria-label="Recipient's username" aria-describedby="basic-addon2" name="qualidade" min="1" max="99" required>
    <span class="input-group-text" id="basic-addon2">%</span>
    </div>
    
   
    <div class="d-grid gap-2">
    <input type="submit" value="Reduzir" class="btn btn-dark" style="margin-top: 10px;">
    </div>
</form>
<br>
<?php if($tipofoto == "jpeg" or $tipofoto == ".jpg" or $tipofoto ==".png"):
$img['size'] = $img['size'] / 1000;
$imgnova = filesize('img/'.$arquivo) / 1000;
    
?>

    
    <div class="alert alert-success">
        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
        Sua IMG tinha <?php echo (int)$img['size'] ?>KB e agora tem <?php echo (int)$imgnova  ?>KB.
    </div>

<img src="img/<?php echo $arquivo ?>" class="img-fluid">
<br /><br /><br /><br />
<?php endif; ?>
</div>
</body>
</html>