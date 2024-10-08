<?php
include('includes/config.php');
session_start();

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Function to calculate weighted rating
function calculateWeightedRating($rating, $numReviews) {
    $minReviews = 5; // Minimum number of reviews to be considered
    $averageRating = 3.5; // Assumed average rating
    
    // Cap the effect of review count to prevent too much influence from very high review counts
    $effectiveReviews = min($numReviews, 10); // Limit the effect of reviews after 10

    return ($rating * $effectiveReviews + $averageRating * $minReviews) / ($effectiveReviews + $minReviews);
}

// Fetch top-rated places
$query = "SELECT r.place_id, r.display_name, AVG(r.rating) as avg_rating, COUNT(*) as review_count, 
          (SELECT photo_url FROM reviews WHERE place_id = r.place_id AND photo_url IS NOT NULL LIMIT 1) as photo_url,
          (SELECT formatted_address FROM reviews WHERE place_id = r.place_id LIMIT 1) as formatted_address
          FROM reviews r
          GROUP BY r.place_id 
          HAVING review_count >= 1  -- Temporarily lowered for testing
          ORDER BY avg_rating DESC, review_count DESC 
          LIMIT 10";

$result = $con->query($query);

if (!$result) {
    die("Query failed: " . $con->error);
}

$places = [];
while ($row = $result->fetch_assoc()) {
    $row['weighted_rating'] = calculateWeightedRating($row['avg_rating'], $row['review_count']);
    $places[] = $row;
}

// Sort places by weighted rating with strict prioritization for ratings above 4.5
usort($places, function($a, $b) {
    // Strict prioritization for places with a rating above 4.5
    if ($a['avg_rating'] >= 4.5 && $b['avg_rating'] < 4.5) {
        return -1;
    } elseif ($a['avg_rating'] < 4.5 && $b['avg_rating'] >= 4.5) {
        return 1;
    }

    // Compare the weighted ratings
    if ($a['weighted_rating'] > $b['weighted_rating']) {
        return -1;
    } elseif ($a['weighted_rating'] < $b['weighted_rating']) {
        return 1;
    }

    // If both have similar weighted ratings, sort by average rating (prefer higher-rated)
    if ($a['avg_rating'] > $b['avg_rating']) {
        return -1;
    } elseif ($a['avg_rating'] < $b['avg_rating']) {
        return 1;
    }

    // Lastly, if both the weighted and avg ratings are equal, sort by number of reviews
    return $b['review_count'] <=> $a['review_count'];
});

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Top Rated Places</title>
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <link href="css/modern-business.css" rel="stylesheet">
    <style>
        .place-card {
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 4px;
            overflow: hidden;
        }
        .place-image {
            width: 100%;
            height: 150px;
            object-fit: cover;
        }
        .place-info {
            padding: 15px;
        }
        .place-name {
            font-weight: bold;
            margin-bottom: 5px;
        }
        .place-address {
            color: #666;
            font-size: 0.9em;
            margin-bottom: 5px;
        }
        .place-rating {
            color: #fbbc04;
            font-weight: bold;
        }
        .review-count {
            color: #666;
            font-size: 0.9em;
        }
        .rank-badge {
            position: absolute;
            top: 10px;
            left: 10px;
            background-color: rgba(0, 0, 0, 0.7);
            color: white;
            padding: 5px 10px;
            border-radius: 3px;
        }
        
    </style>
</head>
<body>
<?php include('includes/header.php'); ?>
    <div class="container mt-4">
        
        <?php if (empty($places)): ?>
            <div class="alert alert-warning">No places found. Make sure your database has reviews.</div>
        <?php else: ?>
            <div class="row">
                <?php foreach ($places as $index => $place): ?>
                    <div class="col-md-4">
                        <div class="place-card position-relative">
                            <div class="rank-badge"><?php echo $index + 1; ?></div>
                            <img src="<?php echo $place['photo_url'] ? htmlspecialchars($place['photo_url']) : 'https://via.placeholder.com/350x150'; ?>" 
                                 alt="<?php echo htmlspecialchars($place['display_name']); ?>" 
                                 class="place-image">
                            <div class="place-info">
                                <div class="place-name"><?php echo htmlspecialchars($place['display_name']); ?></div>
                                <div class="place-address"><?php echo htmlspecialchars($place['formatted_address']); ?></div>
                                <div>
                                    <span class="place-rating"><?php echo number_format($place['avg_rating'], 1); ?></span>
                                    <span class="review-count">(<?php echo $place['review_count']; ?> reviews)</span>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
