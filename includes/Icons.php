<?php

namespace PlantMonitor;

class Icons {

	const ARROW_UP = "⇧";
	const ARROW_DOWN = "⇩";

	public static function createIcon( string $name, PlantStatus $status ) {
		$path = "../assets/icon-$name.svg";
		$icon = file_get_contents( $path );

		$arrow = null;

		if ( $status == PlantStatus::HIGH ) {
			$arrow = self::ARROW_UP;
		}
		if ( $status == PlantStatus::LOW ) {
			$arrow = self::ARROW_DOWN;
		}



		?>
        <div class="sensor-icon <?= $arrow?"status-bad":""; ?>">
			<?php
			echo $icon;
			echo $arrow;
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
