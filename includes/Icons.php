<?php
namespace PlantMonitor;


 class Icons{
    static function createIcons(){
?>
<div class="sensor-icon">
    <?php
    $temp = 20;
    $water = 60;
    $conduct = 600;
    if ($temp < 20 || )
    echo file_get_contents("../assets/icon-temp.svg");
    echo "<br>";
    echo file_get_contents("../assets/icon-thermometer.svg");
    echo "<br>";
    echo file_get_contents("../assets/icon-water-drop.svg");
    ?>

    
    <style>
        .sensor-icon svg{
            width: 100px;
            fill: #ffffff;
        }
        .sensor-icon p{
            font-size:18px;
        }
    </style> 
</div>
<?php
    }
}

?>