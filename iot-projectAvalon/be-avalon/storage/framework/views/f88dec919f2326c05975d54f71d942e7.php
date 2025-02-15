<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Status ESP32</title>
        <style>
            /* Responsive styling */
            body {
                font-family: Arial, sans-serif;
                margin: 0;
                padding: 0;
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                background-color: #f4f4f4;
            }

            .container {
                text-align: center;
                padding: 20px;
                background-color: white;
                border-radius: 10px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            }

            h1 {
                color: #333;
            }

            .error {
                color: red;
            }

            /* Responsive for mobile devices */
            @media (max-width: 600px) {
                .container {
                    width: 90%;
                }
            }

            @media (min-width: 601px) {
                .container {
                    width: 50%;
                }
            }
        </style>

        <!-- Add jQuery -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

        <script>
            // URL API Laravel
            const apiUrl = <?php echo json_encode(url('/api/status'), 15, 512) ?>;

            // Function to fetch data from Laravel API and update the view
            function fetchData() {
                $.get(apiUrl, function(data) {
                    // If data is valid, update the view with the fetched data
                    if (data.status === 'Data Lost') {
                        $('#status').text('No data received from ESP32 within the last 60 seconds.');
                        $('#temperature').text('N/A');
                        $('#humidity').text('N/A');
                        $('#soilMoisture').text('N/A');
                    } else {
                        $('#status').text(data.status);
                        $('#temperature').text(data.temperature + " °C");
                        $('#humidity').text(data.humidity + " %");
                        $('#soilMoisture').text(data.soilMoisture + " %");
                    }
                }).fail(function(jqXHR, textStatus, errorThrown) {
                    // Error handling if the data fetch fails
                    console.error("Failed to fetch data:", textStatus, errorThrown);
                    $('#status').text('Error fetching data from Laravel API.');
                    $('#temperature').text('N/A');
                    $('#humidity').text('N/A');
                    $('#soilMoisture').text('N/A');
                });
            }

            // Fetch data every 5 seconds
            setInterval(fetchData, 5000);

            // Initial data fetch when the page loads
            $(document).ready(function() {
                fetchData();
            });
        </script>
    </head>
    <body>
        <div class="container">
            <h1>Status ESP32</h1>

            <!-- Display the latest status data from Laravel API -->
            <p>Status: <span id="status">Loading...</span></p>
            <p>Temperature: <span id="temperature">Loading...</span></p>
            <p>Humidity: <span id="humidity">Loading...</span></p>
            <p>Soil Moisture: <span id="soilMoisture">Loading...</span></p>
        </div>
    </body>
</html>
<?php /**PATH /Users/irfanzharauri/Development/GitHub/Arcadia-ProjectAvalon/iot-projectAvalon/resources/views/status-iot-data.blade.php ENDPATH**/ ?>