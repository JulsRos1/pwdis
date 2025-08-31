<?php
session_start();
include('includes/config.php');
if (!isset($_SESSION['user_login'])) {
    // Redirect the user to the login page if not logged in
    header("Location: user_login.php");
    exit;
}

// Function to calculate weighted rating
function calculateWeightedRating($rating, $numReviews)
{
    $minReviews = 5;
    $averageRating = 3.5;
    $effectiveReviews = min($numReviews, 10);
    return ($rating * $effectiveReviews + $averageRating * $minReviews) / ($effectiveReviews + $minReviews);
}

// Function to format place type for display
function formatPlaceType($placeType)
{
    $formatted = str_replace(['_', '-'], ' ', $placeType);
    return ucwords($formatted);
}

// Fetch all unique place types
$placeTypesQuery = "SELECT DISTINCT place_type FROM reviews WHERE place_type IS NOT NULL AND place_type != '' ORDER BY place_type ASC";
$placeTypesResult = $con->query($placeTypesQuery);
$placeTypes = [];
while ($row = $placeTypesResult->fetch_assoc()) {
    $placeTypes[] = $row['place_type'];
}

// Get the selected place type from the URL parameter
$selectedType = isset($_GET['type']) ? $_GET['type'] : 'all';

// Modify the main query to include place type filtering
$query = "SELECT r.place_id, r.display_name, AVG(r.rating) as avg_rating, COUNT(*) as review_count, 
          (SELECT photo_url FROM reviews WHERE place_id = r.place_id AND photo_url IS NOT NULL LIMIT 1) as photo_url,
          (SELECT formatted_address FROM reviews WHERE place_id = r.place_id LIMIT 1) as formatted_address,
          r.place_type
          FROM reviews r
          WHERE 1=1 ";

if ($selectedType != 'all') {
    $query .= "AND r.place_type = '" . $con->real_escape_string($selectedType) . "' ";
}

$query .= "GROUP BY r.place_id 
           HAVING review_count >= 1
           ORDER BY avg_rating DESC, review_count DESC 
           LIMIT 10";

$result = $con->query($query);

if (!$result) {
    die("Query failed: " . $con->error);
}

$places = [];
while ($row = $result->fetch_assoc()) {
    $row['weighted_rating'] = calculateWeightedRating($row['avg_rating'], $row['review_count']);
    $row['formatted_place_type'] = formatPlaceType($row['place_type']);
    $places[] = $row;
}

// Sort places by weighted rating
usort($places, function ($a, $b) {
    if ($a['avg_rating'] >= 4.5 && $b['avg_rating'] < 4.5) {
        return -1;
    } elseif ($a['avg_rating'] < 4.5 && $b['avg_rating'] >= 4.5) {
        return 1;
    }
    if ($a['weighted_rating'] != $b['weighted_rating']) {
        return $b['weighted_rating'] <=> $a['weighted_rating'];
    }
    if ($a['avg_rating'] != $b['avg_rating']) {
        return $b['avg_rating'] <=> $a['avg_rating'];
    }
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
    <link href="css/sidebar.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/sidebar.css">
    <style>
        .place-card {
            display: flex;
            flex-direction: column;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 4px;
            overflow: hidden;
            height: 100%;
        }

        .review-avatar {
            width: 40px;
            height: 40px;
            object-fit: cover;
            margin-right: 10px;
        }

        .review-item {
            padding: 10px 0;
        }


        .row {
            margin-top: 20px;
        }

        .col-md-4 {
            padding: 0 15px;
        }

        .place-image {
            width: 100%;
            height: 250px;
            object-fit: cover;
        }

        .place-info {
            padding: 15px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
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

        .rating-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .stars i {
            font-size: 22px;
            color: #FFD700;
        }

        .starsaverage i {
            font-size: 40px;
            color: #FFD700;
        }

        .total-reviews {
            margin-top: 10px;
            margin-bottom: 10px;
            font-size: 16px;
            color: black;
            font-weight: 600;
        }

        .recent-reviews h4 {
            font-size: 18px;
            margin-bottom: 10px;
        }

        .reviews-list {
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }

        .review-item {
            margin-bottom: 10px;
        }

        .reviewsummary {
            border-bottom: 1px solid #ddd;
            margin-bottom: 10px;
        }

        .filter-button {
            margin-bottom: 20px;
        }

        .place-type {
            font-size: 0.9em;
            color: #666;
            margin-top: 5px;
        }

        #filterModal .modal-body {
            max-height: 300px;
            overflow-y: auto;
        }

        .img-fluid {
            width: 85%;
            height: 350px;
            object-fit: cover;
        }

        .heading-section {
            position: relative;
            text-align: center;
            overflow: hidden;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
            background-color: #1F2937;
            color: white;
            padding: 40px 20px;
            border-radius: 8px;
        }

        .heading-section h1,
        .heading-section p {
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.5);/
        }

        .display-4 {
            font-size: 2.5rem;
            font-weight: bold;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
        }

        .lead {
            font-size: 1.25rem;
            margin-bottom: 20px;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
        }

        .btn-light {
            background-color: rgba(255, 255, 255, 0.8);
            color: #333;
        }

        .btn-outline-light {
            border: 2px solid rgba(255, 255, 255, 0.8);
            color: white;
        }

        .form-check {
            margin-bottom: 15px;
            font-size: 1.2rem;
        }

        .form-check-input {
            transform: scale(1.5);
            margin-right: 10px;
        }

        @media only screen and (max-width: 768px) {
            .img-fluid {
                width: 100%;
                height: 250px;
                object-fit: cover;
            }

            .display-4 {
                font-size: 1.8rem;
                font-weight: bold;
                text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
            }

            .lead {
                font-size: 1rem;
                margin-bottom: 20px;
                text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
            }

        }
    </style>
</head>

<body>
    <div class="top-header">
        <div class="logo-header">
            <a href="dashboard.php">
                <img src="images/pwdislogo.png" alt="pwdislogo" class="logo-image">
            </a>
        </div>
        <button class="openbtn" onclick="toggleNav()">&#9776;</button>
    </div>
    <!-- Sidebar -->
    <?php include("includes/sidebar.php"); ?>
    <!-- Page Content -->
    <div id="main">
        <div class="container mt-4">
            <div class="heading-section text-center mb-4">
                <h1 class="display-4">Discover Top-Rated Places</h1>
                <p class="lead">Explore the best places based on user reviews.</p>
            </div>

            <div class="filter-button">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#filterModal">
                    Filter Place
                </button>
                <?php if ($selectedType != 'all'): ?>
                    <a href="?type=all" class="btn btn-outline-secondary">Clear Filter</a>
                <?php endif; ?>
            </div>

            <?php if (empty($places)): ?>
                <div class="alert alert-warning">No places found for the selected type. Try a different filter.</div>
            <?php else: ?>
                <div class="row">
                    <?php foreach ($places as $index => $place): ?>
                        <div class="col-md-4 mb-4">
                            <div class="place-card position-relative" data-place-id="<?php echo htmlspecialchars($place['place_id']); ?>">
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
                                    <div class="place-type"><?php echo htmlspecialchars($place['formatted_place_type']); ?></div>
                                    <button class="btn btn-primary mt-2 read-reviews-btn">See Reviews</button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Review Modal -->
        <div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="reviewModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="reviewModalLabel">Place Reviews</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div id="reviews-content">
                            <!-- Reviews will be loaded here dynamically -->
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="filterModal" tabindex="-1" role="dialog" aria-labelledby="filterModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="filterModalLabel">Filter by Place Type</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="filterForm" action="" method="get">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="type" id="typeAll" value="all" <?php echo $selectedType == 'all' ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="typeAll">
                                    All Types
                                </label>
                            </div>
                            <?php foreach ($placeTypes as $type): ?>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="type" id="type<?php echo htmlspecialchars($type); ?>" value="<?php echo htmlspecialchars($type); ?>" <?php echo $selectedType == $type ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="type<?php echo htmlspecialchars($type); ?>">
                                        <?php echo formatPlaceType($type); ?>
                                    </label>
                                </div>
                            <?php endforeach; ?>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" onclick="document.getElementById('filterForm').submit();">Apply Filter</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            // Handle click on Read Reviews button
            $('.read-reviews-btn').on('click', function() {
                var placeId = $(this).closest('.place-card').data('place-id'); // Fetch place_id from the card

                // Fetch reviews using fetch_reviews.php
                $.ajax({
                    url: 'fetch_reviews.php',
                    type: 'GET',
                    data: {
                        place_id: placeId
                    },
                    success: function(response) {
                        var data = JSON.parse(response);
                        var reviewsHtml = '';

                        // Display the review summary
                        reviewsHtml += `
                            <div class="reviewsummary text-center">
                        `;

                        // Display the first review photo if it exists
                        if (data.reviews.length > 0 && data.reviews[0].photo_url) {
                            reviewsHtml += `
                                <div class="mb-3">
                                    <img src="${data.reviews[0].photo_url}" alt="Review Photo" class="img-fluid">   
                                </div>`;
                        }

                        // Average rating and review count centered 
                        reviewsHtml += `
                                <div class="starsaverage">
                                    ${getStars(data.averageRating)}
                                </div>
                                <div class="total-reviews">
                                    Average Rating: ${data.averageRating.toFixed(1)} (${data.reviewCount} reviews)
                                </div>
                            </div>`; // Close the reviewsummary div

                        // Add the reviews list
                        data.reviews.forEach(function(review) {
                            const reviewTimeAgo = timeAgo(review.review_date);
                            reviewsHtml += `
                                <div class="review-item">
                                    <div class="d-flex align-items-center mb-2">
                                        <img src="${review.avatar_url || 'path/to/default-avatar.png'}" 
                                            alt="User Avatar" 
                                            class="rounded-circle me-2 review-avatar">
                                        <strong>${review.full_name}</strong>
                                    </div>
                                    <div class="stars">${getStars(review.rating)}</div>
                                    <p>${review.review}</p>
                                    <small>${reviewTimeAgo}</small>
                                </div>
                                <hr>`;
                        });
                        reviewsHtml += '</div></div>'; // Close the reviews list div

                        // Insert the reviews HTML into the modal
                        $('#reviews-content').html(reviewsHtml);

                        // Show the modal
                        $('#reviewModal').modal('show');
                    },
                    error: function() {
                        alert('Failed to fetch reviews.');
                    }
                });
            });

            // Function to return star HTML based on rating
            function getStars(rating) {
                let starsHtml = '';
                for (let i = 1; i <= 5; i++) {
                    starsHtml += `<i class="fa ${i <= rating ? 'fa-star' : 'fa-star-o'}"></i>`;
                }
                return starsHtml;
            }

            // Function to format the date into "time ago" format
            function timeAgo(date) {
                const seconds = Math.floor((new Date() - new Date(date)) / 1000);
                let interval = Math.floor(seconds / 31536000);
                if (interval > 1) return interval + " years ago";
                interval = Math.floor(seconds / 2592000);
                if (interval > 1) return interval + " months ago";
                interval = Math.floor(seconds / 86400);
                if (interval > 1) return interval + " days ago";
                interval = Math.floor(seconds / 3600);
                if (interval > 1) return interval + " hours ago";
                interval = Math.floor(seconds / 60);
                if (interval > 1) return interval + " minutes ago";
                return seconds + " seconds ago";
            }
        });

        function toggleNav() {
            const sidebar = document.getElementById("mySidebar");
            if (sidebar.style.width === "250px") {
                closeNav();
            } else {
                openNav();
            }
        }

        function openNav() {
            document.getElementById("mySidebar").style.width = "250px";
            document.getElementById("main").style.marginLeft = "250px";
        }

        // Function to close sidebar
        function closeNav() {
            document.getElementById("mySidebar").style.width = "0";
            document.getElementById("main").style.marginLeft = "0";
        }
    </script>

</body>

</html>