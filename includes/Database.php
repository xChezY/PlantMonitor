<?php

namespace PlantMonitor;

use DateTime;
use Dotenv\Dotenv;
use GuzzleHttp\Client;

class Database {
	private Client $client;
	private string $baseURL;
	private string $apiKey;
	private string $bucket;
	private string $orgID;

	public function __construct() {
		$dotenv = Dotenv::createImmutable( __DIR__ . "/../" );
		$dotenv->load();
		$this->client  = new Client( [ "verify" => false ] );
		$this->baseURL = $_ENV['INFLUX_DB_URL'] ?? "";
		$this->apiKey  = $_ENV['INFLUX_DB_API_KEY'] ?? "";
		$this->bucket  = $_ENV["BUCKET"] ?? "";
		$this->orgID   = $_ENV["ORG_ID"] ?? "";
	}


	/**
	 * returns the data as csv
	 **/
	private function makeRequest( string $query ): string {

		$res = $this->client->request(
			'POST',
			$this->baseURL . "api/v2/query",
			[
				"headers" => [
					"Authorization" => "Token " . $this->apiKey,
					"Content-Type"  => "application/vnd.flux",
					"Accept"        => "application/csv",
				],
				"body"    => $query,
				"query"   => [ "orgID" => $this->orgID ]
			]
		);

		return (string) $res->getBody();
	}

	public function query( string $query ) : string {
		$query = 'from(bucket: "' . $this->bucket . '") |>
		' . $query;

		return trim( $this->makeRequest( $query ) );
	}


}
