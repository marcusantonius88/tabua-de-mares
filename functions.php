<?php

function exibeMensagem(array $tabuas){
    echo 'Tabua das mares JP de hoje: ' . date('d/m/Y') .  PHP_EOL;
    foreach($tabuas as $tabua){
        echo 'Hora: '. str_pad($tabua['hora'], '5', '0', STR_PAD_LEFT)  . ' | Altura: ' .str_replace(' ','', $tabua['altura']) . PHP_EOL;
    }
}