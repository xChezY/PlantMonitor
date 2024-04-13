# PlantMonitor

**PlantMonitor** is an open-source PHP web frontend that allows users to monitor the condition of their plants in real time. This project retrieves data from an InfluxDB database, which has been collected from various sensors. Each sensor measures different aspects such as moisture, light intensity, and temperature to assess the health status of each plant.

## Features

- **Real-time Data Visualization**: View the current condition of your plants through real-time data from the database.
- **Individual Plant Views**: Access specific information for each of your plants.
- **Responsive Design**: Accessible on both desktop and mobile devices.

## Technologies

- **Backend**: PHP
- **Database**: InfluxDB
- **Frontend**: HTML, CSS, JavaScript

## Prerequisites

To run this project, you will need:

- PHP 8.0 or higher
- Access to an InfluxDB instance with pre-installed sensor data

## Installation

1. **Clone the Repository:**
   ```bash
   git clone https://github.com/username/plantmonitor.git
   cd plantmonitor
   ```
2. **Configure Your Database Connection:**
   - Edit the `config.php` file and enter your database details.

3. **Start Your Web Server:**
   - Ensure your web server (e.g., Apache) is running and PHP is configured correctly.

## Usage

Open your web browser and navigate to your local address (e.g., `http://localhost` or the appropriate URL of your web server) to access the user interface and monitor the condition of your plants in real time.

## Contributing

Contributions are welcome! Please create a pull request for new features or bug fixes.

## License

This project is licensed under the MIT License. For more details, see the `LICENSE` file.
