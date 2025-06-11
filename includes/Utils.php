<?php

namespace PlantMonitor;

readonly class Utils {

    public static function giveRandomFloat($min, $max): float {
        return rand($min, $max) + (rand(0, 100) / 100);
    }


    public static function csvStringToArray(string $csv): array {
        // Zeilen aufsplitten
        $lines = explode("\n", trim($csv));

        // Header-Zeile extrahieren und trimmen
        $headers = str_getcsv(array_shift($lines), escape:  "\\");
        $headers = array_map('trim', $headers);

        $result = [];

        // Durch die Datenzeilen iterieren
        foreach ($lines as $line) {
            if (empty(trim($line))) continue; // Leere Zeilen überspringen

            $data = str_getcsv($line,",",escape:  "\\");

            // Assoziatives Array für jede Zeile erstellen
            $row = [];
            foreach ($headers as $i => $header) {
                if($header== "" || $header == "result" || $header == "table")
                    continue;
                // Nur zuweisen, wenn der Index existiert
                if (isset($data[$i])) {
                    $row[$header] = $data[$i];
                } else {
                    $row[$header] = null;
                }
            }

            $result[] = $row;
        }

        return $result;
    }

}
?>
