<?php

namespace PlantMonitor;

readonly class Utils {

    public static function giveRandomFloat($min, $max): float {
        return rand($min, $max) + (rand(0, 100) / 100);
    }

}
?>
