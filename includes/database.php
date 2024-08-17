<?php

function getPlantData($plantID){
    //Database blabla
    $plants = [['temp' => 30, 'conduct' => 0, 'water' => 1],
    ['temp' => 23, 'conduct' => 0, 'water' => 1],
    ['temp' => 22, 'conduct' => 0, 'water' => 1]];

    //gibt pflanze zurück an index plantID falls vorhanden, sonst null
    return isset($plants[$plantID]) ? $plants[$plantID] : null;
}

?>