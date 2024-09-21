<?php

namespace PlantMonitor;

class View {

	public static function get(string $name){
		require_once  '../parts/' . $name . '.php';
	}


}
