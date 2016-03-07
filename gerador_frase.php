<?php

// PRINCIPAL
// 
// Variáveis
$nome = rand_line("Dados/lista_nomes.txt");
$verbo = rand_line("Dados/sub_lista_verbos.txt");
$substantivo = rand_line("Dados/sub_lista_substantivos.txt");
$verbo_passado = conjugar_passado($verbo);

// Chamadas
$frase = $nome . ' ' . conjugar_passado($verbo) . ' ' . pronome($substantivo) . ' ' . $substantivo;
echo $frase;

// METODOS
// @param = string substantivo
// @retorna = string pronome ( de acordo com o genero do substantivo)
function pronome($substantivo) {

    $palavra = str_split($substantivo);
    $tam = sizeof($palavra) - 2;
    $last_char = $palavra[$tam];

    if ($last_char == 'a') {
        return 'a';
    } else
        return 'o';
}

// @param = string verbo no presente
// @retorna = string verbo no passado
function conjugar_passado($verbo) {

    $padrao = array('/ar$/', '/or$/');

    $verbo_passado = preg_replace($padrao, "ou", $verbo);
    if ($verbo_passado == $verbo) {
        $verbo_passado = preg_replace('/er$/', "eu", $verbo);
        if ($verbo_passado == $verbo) {
            $verbo_passado = preg_replace('/ir$/', "iu", $verbo);
        }
    }
    return $verbo_passado;
}

// @param = caminho do arquivo contendo a lista de palavras
// @retorna = string linha aleatoria
function rand_line($fileName, $maxLineLength = 4096) {
    $handle = @fopen($fileName, "r");
    if ($handle) {
        $random_line = null;
        $line = null;
        $count = 0;
        while (($line = fgets($handle, $maxLineLength)) !== false) {
            $count++;
            // P(1/$count) probability of picking current line as random line
            if (rand(0, 1299) % $count == 0) {
                $random_line = $line;
            }
        }
        if (!feof($handle)) {
            echo "Error: unexpected fgets() fail\n";
            fclose($handle);
            return null;
        } else {
            fclose($handle);
        }
        return $random_line;
    }
}

?>