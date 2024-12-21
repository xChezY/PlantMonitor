<?php

namespace PlantMonitor;

class Icons {

	public static function createIcon( string $name, PlantStatus $status ) {
		$path = "../assets/icon-$name.svg";
		$icon = file_get_contents( $path );

		?>
        <div class="sensor-icon <?= $status!=PlantStatus::GOOD?"status-bad":""; ?>">
			<?php
			echo $icon;
			?>
            <style>

                .sensor-icon.status-bad svg {
                    fill: #ff0000;
                }

                .sensor-icon svg {
                    width: 100px;
                    fill: #000000;
                }

                .sensor-icon p {
                    font-size: 18px;
                }
            </style>
        </div>
		<?php
	}
}

?>
