<?php
include('includes/config.php');
session_start();

// Fetch the count of places by accessibility_level
$accessibilityQuery = "SELECT accessibility_level, COUNT(*) as count FROM place_accessibility GROUP BY accessibility_level";
$accessibilityResult = $con->query($accessibilityQuery);

// Prepare data for the accessibility chart
$accessibilityLabels = [];
$accessibilityData = [];
$accessibilityColors = []; // For storing colors based on accessibility level

while ($row = $accessibilityResult->fetch_assoc()) {
    $accessibilityLabels[] = $row['accessibility_level'];
    $accessibilityData[] = (int) $row['count'];

    // Set colors based on accessibility level
    switch ($row['accessibility_level']) {
        case 'Highly Accessible':
            $accessibilityColors[] = 'rgba(0, 204, 0)'; // Green
            break;
        case 'Accessible':
            $accessibilityColors[] = 'rgba(0, 128, 255)'; // Blue
            break;
        case 'Not Accessible':
            $accessibilityColors[] = 'rgba(255, 0, 0)'; // Red
            break;
        default:
            $accessibilityColors[] = 'rgba(0, 0, 0, 0.6)'; // Default color if none match
            break;
    }
}

// Fetch the count of each rating (1 to 5)
$ratingQuery = "SELECT rating, COUNT(*) as count FROM reviews GROUP BY rating";
$ratingResult = $con->query($ratingQuery);

// Prepare data for the rating chart
$ratings = [5, 4, 3, 2, 1]; // Fixed ratings 5 to 1
$ratingLabels = ["5 stars", "4 stars", "3 stars", "2 stars", "1 star"]; // User-friendly labels
$ratingData = array_fill(0, count($ratings), 0); // Initialize data array with 0s

while ($row = $ratingResult->fetch_assoc()) {
    $rating = (int) $row['rating'];
    $ratingData[5 - $rating] = (int) $row['count']; // Index 0 for rating 5, 1 for rating 4, etc.
}

// Close the database connection
$con->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Charts</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/modern-business.css" rel="stylesheet">
    <style>
        .chart-container {
            position: relative;
            width: 80%;
            max-width: 600px;
            /* Adjust the max-width as needed */
            margin: auto;
            margin-bottom: 30px;
            /* Space between charts */
        }

        canvas {
            width: 100% !important;
            height: auto !important;
        }

        .charts-column {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        #accessibilityChart {
            max-height: 300px;
            /* Adjust the size as needed */
        }
    </style>
</head>

<body>
    <?php include('includes/header.php') ?>;

    <div class="charts-column">
        <div class="chart-container">
            <canvas id="accessibilityChart"></canvas>
        </div>

        <div class="chart-container">
            <canvas id="ratingChart"></canvas>
        </div>
    </div>

    <script>
        // Accessibility Line Chart
        const ctxAccessibility = document.getElementById('accessibilityChart').getContext('2d');
        const accessibilityChart = new Chart(ctxAccessibility, {
            type: 'line',
            data: {
                labels: <?php echo json_encode($accessibilityLabels); ?>,
                datasets: [{
                    label: 'Accessibility count of Places',
                    data: <?php echo json_encode($accessibilityData); ?>,
                    backgroundColor: 'rgba(0, 0, 0, 0)', // Transparent background
                    borderColor: 'rgba(0, 0, 0, 1)', // Black border for the line
                    borderWidth: 2,
                    fill: false // No fill under the line
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Accessibility Level'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Count'
                        }
                    }
                },
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                const label = tooltipItem.label || '';
                                const value = tooltipItem.raw || 0;
                                return `${label}: ${value} places`;
                            }
                        }
                    }
                }
            }
        });

        // Rating Bar Chart
        const ctxRating = document.getElementById('ratingChart').getContext('2d');
        const ratingChart = new Chart(ctxRating, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($ratingLabels); ?>,
                datasets: [{
                    label: 'Count of Reviews',
                    data: <?php echo json_encode($ratingData); ?>,
                    backgroundColor: 'rgba(75, 192, 192, 0.6)', // Single color for all bars
                    borderColor: 'rgba(75, 192, 192, 1)', // Border color for all bars
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Rating'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Count'
                        }
                    }
                },
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                const label = tooltipItem.label || '';
                                const value = tooltipItem.raw || 0;
                                return `${label}: ${value} user generated reviews`;
                            }
                        }
                    }
                }
            }
        });
    </script>
</body>

</html>