<?php

	//
	ini_set('display_errors', 1);
	//error_reporting('E_ERROR | E_WARNING | E_PARSE');	

    /**
    *
    * 28/06/2023
    *
    * Compress images 
    * 
    * @author VINICIUS BARSOTELI <vinicius@vetros.com.br>
    * @author CHATGPT
    *
    */
    function resizeJPG($imagem, $larguraMaxima, $alturaMaxima, $qualidade) {

        //
        $arquivo_nome =  pathinfo($imagem, PATHINFO_FILENAME).'.'.mb_strtolower(pathinfo($imagem, PATHINFO_EXTENSION));

        //
        list($larguraOriginal, $alturaOriginal) = getimagesize($imagem);
    
        //
        $proporcaoOriginal = $larguraOriginal / $alturaOriginal;
        $proporcaoDesejada = $larguraMaxima / $alturaMaxima;
        
        if ($proporcaoOriginal > $proporcaoDesejada) {
            $novaLargura = $larguraMaxima;
            $novaAltura = $larguraMaxima / $proporcaoOriginal;
        } else {
            $novaLargura = $alturaMaxima * $proporcaoOriginal;
            $novaAltura = $alturaMaxima;
        }
    
        //
        $imgOriginal = imagecreatefromjpeg($imagem);
    
        //
        $novaImagem = imagecreatetruecolor($novaLargura, $novaAltura);
    
        // 
        imagecopyresampled(
            $novaImagem, 
            $imgOriginal,
            0, 0, 0, 0, 
            $novaLargura, $novaAltura, $larguraOriginal, $alturaOriginal 
        );
  
        //
        imagejpeg($novaImagem, 'comprimidas/'.$arquivo_nome, $qualidade);
    
        //
        imagedestroy($imgOriginal);
        imagedestroy($novaImagem);

    }

    function compressJPG($diretorio, $larguraMaxima, $alturaMaxima, $qualidade) {

        // 
        $listaArquivos = scandir($diretorio);
        
        //
        foreach ($listaArquivos as $arquivo) {

            // 
            if ($arquivo == '.' || $arquivo == '..') {
                continue;
            }
            
            //
            $caminhoCompleto = $diretorio . '/' . $arquivo;

            // se for um diretorio
            if (is_dir($caminhoCompleto)) {
                compressJPG($caminhoCompleto, $larguraMaxima, $alturaMaxima, $qualidade);
            } else {
                // Verifica se é um arquivo JPG
                if (in_array(mb_strtolower(pathinfo($caminhoCompleto, PATHINFO_EXTENSION)), array('jpg', 'jpeg'))) {
                    // Compacta a imagem
                    resizeJPG($caminhoCompleto, $larguraMaxima, $alturaMaxima, $qualidade);
                }
            }
        }

    }
  
    @mkdir('comprimidas');
    @mkdir('original');

    // Chama a função para compactar as imagens recursivamente
    compressJPG('original', 5000, 2000, 90);

