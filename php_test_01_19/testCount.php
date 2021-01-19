<?php

require 'skaiciavimoSistema.php';
$asoc = array(
    'Transportas' => array(
        'Du ratai' => array(
            'Dviraciai' => array(
                'Extrime' => 10,
                'Author' => 122
            ),
            'Paspirtukai' => 12
        ),
        'Automobiliai' => array(
            'Opel' => array(
                'Astra' => 5
            ),
            'Honda' => 5,
            'Audi' => 11
        ),
        'Reikmenys' => 7
    ),
    'Elektronika' => array(
        'Fotokameros' => 1475,
        'Videokameros' => 3
    )
);

echo "<br>";

$numberCount = new CalculationSystem($asoc);

print_r($numberCount->binary());
echo "<br>";
print_r($numberCount->octal());
echo "<br>";
print_r($numberCount->hexadecimal());
echo "<br>";
print_r($numberCount->decimal());
echo "<br>";
