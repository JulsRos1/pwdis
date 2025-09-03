<?php
session_start();
include('includes/config.php');
$config = include 'config.php';  // load key safely
$apiKey = $config['GOOGLE_PLACES_API_KEY'];
if (!isset($_SESSION['user_login'])) {
  // Redirect the user to the login page if not logged in
  header("Location: user_login.php");
  exit;
  
}
?>

<!DOCTYPE html>
<html>

<head>
  <title>Navigate Accessibility in Los Baños, Laguna</title>
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
  <link rel="stylesheet" href="css/mapcontent.css" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBowuNI1xQJvodo3uooqXbVbFnoRtcOJ1E&libraries=places" defer async></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link rel="stylesheet" href="css/sidebar.css">
</head>

<div>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

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

  <div id="map-container">
    <div class="top-controls-container">
      <div class="search-container">
        <input type="text" id="searchInput" placeholder="Search for a place...">
        <div id="searchResults" class="search-results"></div>
      </div>

      <div class="top-button-bar">
        <button class="category-button" onclick="updatePlaces('restaurant')">
          <i class="fas fa-utensils"></i>
          Restaurants
        </button>
        <button class="category-button" onclick="updatePlaces('school')">
          <i class="fas fa-school"></i>
          Educational Institutions
        </button>
        <button class="category-button" onclick="updatePlaces('hospital')">
          <i class="fas fa-hospital"></i>
          Healthcare
        </button>
        <button class="category-button" onclick="updatePlaces('grocery_store')">
          <i class="fa-solid fa-cart-shopping"></i>
          Grocery
        </button>
        <button class="category-button" data-toggle="modal" data-target="#moreCategoriesModal">
          <i class="fas fa-ellipsis-h"></i>
          More
        </button>
      </div>
    </div>

    <div id="map"></div>
    <div class="legend">
      <h4>Legend</h4>
      <ul>
        <li><span style="background-color: red"></span> Not Accessible (0 Options)</li>
        <li><span style="background-color: blue"></span> Partially Accessible (1-2 Options)</li>
        <li><span style="background-color: green"></span> Highly Accessible (3-4 Options)</li>
      </ul>
    </div>
    <div id="place-details-panel" class="place-details-panel">
      <button id="close-details" class="close-details">&times;</button>
      <div id="place-details-content"></div>
    </div>
  </div>

  <!-- Write Reviews Modal -->
  <div class="modal fade" id="reviewModal" tabindex="-1" role="dialog" aria-labelledby="reviewModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="reviewModalLabel">Write a Review</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="submit_review.php" method="POST">
            <div class="rating-box">
              <header>How was your experience?</header>
              <div class="stars">
                <i class="fa-solid fa-star" data-value="1"></i>
                <i class="fa-solid fa-star" data-value="2"></i>
                <i class="fa-solid fa-star" data-value="3"></i>
                <i class="fa-solid fa-star" data-value="4"></i>
                <i class="fa-solid fa-star" data-value="5"></i>
              </div>
              <p>Leave a Review:</p>
              <input type="hidden" id="rating_input" name="rating" value="">
              <textarea id="review" name="review" rows="4" cols="50"></textarea>
              <br>
              <input type="hidden" name="place_type" id="place_type_modal">
              <input type="hidden" name="display_name" id="display_name_modal">
              <input type="hidden" name="place_id" id="place_id_modal">
              <input type="hidden" name="photo_url" id="photo_url_modal">
              <input type="hidden" name="formatted_address" id="formatted_address_modal">
              <input type="hidden" name="first_name" value="<?php echo $_SESSION['name']; ?>">
              <input type="hidden" name="last_name" value="<?php echo $_SESSION['lname']; ?>">
              <input type="hidden" name="review_date" id="review_date_modal" value="<?php echo date('Y-m-d H:i:s'); ?>">
              <input type="hidden" name="avatar_url" id="avatar_url_modal">
              <input type="submit" value="Submit" name="submit">
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div

  <!-- Accessibility Options Modal -->
<div class="modal fade" id="accessibilityModal" tabindex="-1" role="dialog" aria-labelledby="accessibilityModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="accessibilityModalLabel">Update Accessibility Options</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="alert alert-info" role="alert">
          <h5 class="alert-heading">Importance of Accurate Information</h5>
          <p>Accurate accessibility information is vital for ensuring that all individuals can navigate public spaces with ease. This information helps people with disabilities plan their visits confidently, ensuring they can access essential services and facilities.
          </p>
        </div>

        <div class="accessibility-criteria mb-4">
          <h5>Criteria for Accessibility Features</h5>
          <div class="accordion" id="accessibilityCriteriaAccordion">
            <div class="card">
              <div class="card-header" id="headingEntrance">
                <h2 class="mb-0">
                  <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseEntrance">
                    PWD - Accessible Entrance
                  </button>
                </h2>
              </div>
              <div id="collapseEntrance" class="collapse" aria-labelledby="headingEntrance" data-parent="#accessibilityCriteriaAccordion">
                <div class="card-body">
                  <p><strong>Criteria:</strong> The entrance should be at least 3 feet wide and free of steps. If there are steps, a permanent or movable ramp must be available. Revolving doors should be marked as not accessible.</p>
                  <p><strong>Why It Matters:</strong> A wide, step-free entrance allow individuals using wheelchairs, scooters, or other mobility devices to navigate spaces more easily.</p>
                </div>
              </div>
            </div>

            <div class="card">
              <div class="card-header" id="headingRestroom">
                <h2 class="mb-0">
                  <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseRestroom">
                    PWD - Accessible Restroom
                  </button>
                </h2>
              </div>
              <div id="collapseRestroom" class="collapse" aria-labelledby="headingRestroom" data-parent="#accessibilityCriteriaAccordion">
                <div class="card-body">
                  <p><strong>Criteria:</strong> if the entrance to the restroom is at least one meter wide and can be reached without going up or down steps. If a person in a wheelchair would need to enter a stall inside the restroom, the stall’s entrance also needs to be one meter wide. (Remember, one meter is about the width of two people standing comfortably side by side.)</p>
                  <p><strong>Why It Matters:</strong> Accessible restrooms are crucial for the dignity and independence of users.</p>
                </div>
              </div>
            </div>

            <div class="card">
              <div class="card-header" id="headingSeating">
                <h2 class="mb-0">
                  <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseSeating">
                    PWD - Accessible Seating
                  </button>
                </h2>
              </div>
              <div id="collapseSeating" class="collapse" aria-labelledby="headingSeating" data-parent="#accessibilityCriteriaAccordion">
                <div class="card-body">
                  <p><strong>Criteria:</strong> if the main area of the place can be accessed without stairs and there’s enough space for someone in a wheelchair to navigate to and sit at a table. If all tables are high (e.g. at standing level), the place isn’t wheelchair-friendly.</p>
                  <p><strong>Why It Matters:</strong> Ensures equal access for persons with disabilities so that they can enjoy dining or socializing in the space.</p>
                </div>
              </div>
            </div>

            <div class="card">
              <div class="card-header" id="headingParking">
                <h2 class="mb-0">
                  <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseParking">
                    PWD - Accessible Parking
                  </button>
                </h2>
              </div>
              <div id="collapseParking" class="collapse" aria-labelledby="headingParking" data-parent="#accessibilityCriteriaAccordion">
                <div class="card-body">
                  <p><strong>Criteria:</strong>Accessible parking slot shall be located nearest to accessible main entrances and </p>
                  <p><strong>Why It Matters:</strong> Accessible parking is essential for persons with disabilities ensuring convenient access to the venue.</p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <form id="accessibilityForm" action="submit_accessibility.php" method="POST" onsubmit="updateAccessibilityLevel()">
          <p>Check the accessibility features available. If there are none, don't check any and submit the form.</p>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" id="parking" name="accessibilityOptions[]" value="wheelchairAccessibleParking">
            <i class='fa-solid fa-wheelchair' style='color: #007bff;'></i> <label class="form-check-label" for="parking">Has PWD Accessible Parking</label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" id="entrance" name="accessibilityOptions[]" value="wheelchairAccessibleEntrance">
            <i class='fa-solid fa-wheelchair' style='color: #007bff;'></i><label class="form-check-label" for="entrance">Has PWD Accessible Entrance</label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" id="restroom" name="accessibilityOptions[]" value="wheelchairAccessibleRestroom">
            <i class='fa-solid fa-wheelchair' style='color: #007bff;'></i> <label class="form-check-label" for="restroom">Has PWD Accessible Restroom</label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" id="seating" name="accessibilityOptions[]" value="wheelchairAccessibleSeating">
            <i class='fa-solid fa-wheelchair' style='color: #007bff;'></i> <label class="form-check-label" for="seating">Has PWD Accessible Seating</label>
          </div>
          <input type="hidden" name="accessibility_level" id="accessibility_level">
          <input type="hidden" name="display_name" id="display_name_modal1">
          <input type="hidden" name="place_id" id="place_id_accessibility_modal">
          <input type="hidden" name="first_name" value="<?php echo $_SESSION['name']; ?>">
          <input type="hidden" name="last_name" value="<?php echo $_SESSION['lname']; ?>">
          <button type="submit" class="btn btn-primary mt-3">Submit</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Add this modal after your existing modals -->
<div class="modal fade" id="moreCategoriesModal" tabindex="-1" role="dialog" aria-labelledby="moreCategoriesModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="moreCategoriesModalLabel">More Categories</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="category-grid">
          <button class="category-button" onclick="updatePlaces('community_center')" data-dismiss="modal">
            Community Center
          </button>
          <button class="category-button" onclick="updatePlaces('hotel')">
            Hotel
          </button>
          <button class="category-button" onclick="updatePlaces('park')">
            Park
          </button>
          <button class="category-button" onclick="updatePlaces('cafe')">
            Cafe
          </button>
          <button class="category-button" onclick="updatePlaces('coffee_shop')">
            Coffee Shop
          </button>
          <button class="category-button" onclick="updatePlaces('police')">
            Police Station
          </button>
          <button class="category-button" onclick="updatePlaces('pharmacy')">
            Pharmacy
          </button>
          <!-- Add more category buttons as needed -->
        </div>
      </div>
    </div>
  </div>
</div>

</body>

<!-- Show Reviews Modal -->
<div class="modal fade" id="reviewsModal" tabindex="-1" role="dialog" aria-labelledby="reviewsModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="reviewsModalLabel">Reviews</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="reviewsContent">
        <!-- Dito magshowshow yung reviews content -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Bootstrap JS -->

<script>
  let map;
  let userLocation;
  let markers = [];
  document.addEventListener("DOMContentLoaded", function() {
    // Call initMap() when the page is fully loaded
    initMap();
    const reviewForm = document.querySelector("#reviewModal form");
    reviewForm.addEventListener("submit", function(event) {
      event.preventDefault(); // Prevent the default form submission
      const formData = new FormData(reviewForm);

      // Use fetch to submit the form data via AJAX
      fetch("submit_review.php", {
          method: "POST",
          body: formData
        })
        .then(response => response.json())
        .then(data => {
          // Handle the response
          if (data.status === "success") {
            Swal.fire({
              title: "Success!",
              text: data.message,
              icon: "success",
              confirmButtonText: "OK",
            }).then(() => {
              // Optionally, reload the page or close the modal
              $("#reviewModal").modal("hide");
              reviewForm.reset(); // Clear the form after success
            });
          } else {
            Swal.fire({
              title: "Error!",
              text: data.message,
              icon: "error",
              confirmButtonText: "OK",
            });
          }
        })
        .catch(error => {
          console.error("Error submitting review:", error);
          Swal.fire({
            title: "Error!",
            text: "There was an error submitting your review. Please try again.",
            icon: "error",
            confirmButtonText: "OK",
          });
        });
    });
  });

  function initMap() {
    navigator.geolocation.getCurrentPosition(
      (position) => {
        userLocation = {
          lat: position.coords.latitude,
          lng: position.coords.longitude,
        };
        // Adjust zoom level based on screen width
        const zoomLevel = window.innerWidth <= 768 ? 14 : 16; // Zoom out for mobile devices
        map = new google.maps.Map(document.getElementById("map"), {
          center: userLocation,
          zoom: zoomLevel,
          mapTypeControl: false, // This disables the default "Map" and "Satellite" buttons
          streetViewControl: false, // Optionally disable the Street View button
          fullscreenControl: false // Optionally disable the fullscreen control
        });

        // Display user's current location
        new google.maps.Marker({
          position: userLocation,
          map: map,
          title: "Your Location",
          icon: {
            url: "images/usericonmap.png",
          },
        });

        // Add click event listener to the map
        map.addListener('click', function(event) {
          event.stop(); // Stop any default actions
          handleMapClick(event.latLng);
        });
      },
      (error) => {
        console.error("Geolocation error:", error);
      }
    );
  }


  function updatePlaces(type) {
    currentPlaceType = type;
    // Clear existing markers (if any)
    clearMarkers();
    map.setZoom(13.80);
    $('#moreCategoriesModal').modal('hide');
    const request = {
      includedTypes: [type],
      locationRestriction: {
        circle: {
          center: {
            latitude: userLocation.lat,
            longitude: userLocation.lng,
          },
          radius: 3000,
        },
      },
    };

    fetch(
        "https://places.googleapis.com/v1/places:searchNearby?key=AIzaSyBowuNI1xQJvodo3uooqXbVbFnoRtcOJ1E", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
            "X-Goog-FieldMask": "places.id,places.displayName,places.formattedAddress,places.accessibilityOptions,places.location,places.photos",
          },
          body: JSON.stringify(request),
        }
      )
      .then((response) => response.json())
      .then((data) => {
        console.log("Parsed data: ", data);

        if (data.places && Array.isArray(data.places)) {
          data.places.forEach((place) => {
            if (
              place.location &&
              place.location.latitude &&
              place.location.longitude
            ) {
              fetchPlaceDetails(place, false, currentPlaceType, false); // Pass currentPlaceType and false for isFromMapClick
            }
          });
        } else {
          console.error("No places found in the response");
        }
      })
      .catch((error) => {
        console.error("Fetch error for places:", error);
      });
  }

  let currentPlaceType = '';

  function handleMapClick(latLng) {
    console.log("Handled Map Click");
    clearMarkers();

    map.setCenter(latLng);
    map.setZoom(19);

    const request = {
      locationRestriction: {
        circle: {
          center: {
            latitude: latLng.lat(),
            longitude: latLng.lng(),
          },
          radius: 10,
        },
      },
      maxResultCount: 1
    };

    fetch(
        "https://places.googleapis.com/v1/places:searchNearby?key=AIzaSyBowuNI1xQJvodo3uooqXbVbFnoRtcOJ1E", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
            "X-Goog-FieldMask": "places.id,places.displayName,places.formattedAddress,places.accessibilityOptions,places.location,places.photos,places.primaryType"
          },
          body: JSON.stringify(request),
        }
      )
      .then((response) => response.json())
      .then((data) => {
        console.log("Place: ", data);
        if (data.places && data.places.length > 0) {
          const place = data.places[0];
          // Use primaryType from API for handleMapClick
          fetchPlaceDetails(place, true, place.primaryType || 'Unknown', true);
        } else {
          console.log("No place found at this location");
          addMarker({
            location: {
              latitude: latLng.lat(),
              longitude: latLng.lng()
            },
            displayName: {
              text: "Unknown Location"
            },
            formattedAddress: "Unknown Address",
            id: "clicked_location",
          }, {}, 'Unknown', true);
        }
      })
      .catch((error) => {
        console.error("Fetch error for places:", error);
      });
  }

  function fetchPlaceDetails(place, shouldOpenPanel = true, placeType = "", isFromMapClick = false) {
    fetch(`fetch_accessibility_options.php?place_id=${place.id}`)
      .then((response) => response.json())
      .then((userAccessibility) => {
        const accessibilityOptions = {
          wheelchairAccessibleParking: userAccessibility?.wheelchairAccessibleParking ?? place.accessibilityOptions?.wheelchairAccessibleParking ?? false,
          wheelchairAccessibleEntrance: userAccessibility?.wheelchairAccessibleEntrance ?? place.accessibilityOptions?.wheelchairAccessibleEntrance ?? false,
          wheelchairAccessibleRestroom: userAccessibility?.wheelchairAccessibleRestroom ?? place.accessibilityOptions?.wheelchairAccessibleRestroom ?? false,
          wheelchairAccessibleSeating: userAccessibility?.wheelchairAccessibleSeating ?? place.accessibilityOptions?.wheelchairAccessibleSeating ?? false,
        };

        addMarker(place, accessibilityOptions);

        if (shouldOpenPanel) {
          fetch(`fetch_reviews.php?place_id=${place.id}`)
            .then((response) => response.json())
            .then((reviewsData) => {
              const content = createPlaceDetailsContent(
                place,
                reviewsData,
                accessibilityOptions,
                place.photos && place.photos.length > 0 ? place.photos[0] : null,
                placeType,
                isFromMapClick
              );
              document.getElementById('place-details-content').innerHTML = content;
              openPlaceDetailsPanel();
            })
            .catch((error) => {
              console.error("Fetch error for reviews:", error);
            });
        }
      })
      .catch((error) => {
        console.error("Fetch error for accessibility options:", error);
        addMarker(place, {}, placeType, isFromMapClick);
      });
  }


  function addMarker(place, accessibilityOptions) {
    const accessibilityCount =
      Object.values(accessibilityOptions).filter(Boolean).length;

    let markerIcon;
    if (accessibilityCount === 0) {
      markerIcon = "images/red-marker.png";
    } else if (accessibilityCount <= 2) {
      markerIcon = "images/blue-marker.png";
    } else {
      markerIcon = "images/green-marker.png";
    }

    const marker = new google.maps.Marker({
      position: {
        lat: place.location.latitude,
        lng: place.location.longitude,
      },
      map: map,
      title: place.displayName.text,
      icon: {
        url: markerIcon,
        scaledSize: new google.maps.Size(40, 40),
      },
    });

    markers.push(marker);

    marker.addListener("click", function() {
      fetch(`fetch_reviews.php?place_id=${place.id}`)
        .then((response) => response.json())
        .then((reviewsData) => {
          const content = createPlaceDetailsContent(
            place,
            reviewsData,
            accessibilityOptions,
            place.photos && place.photos.length > 0 ? place.photos[0] : null
          );
          document.getElementById('place-details-content').innerHTML = content;
          openPlaceDetailsPanel();
        })
        .catch((error) => {
          console.error("Fetch error for reviews:", error);
        });
    });
  }

  function clearMarkers() {
    for (let marker of markers) {
      marker.setMap(null);
    }
    markers = [];
  }

  function createPlaceDetailsContent(place, reviewsData, accessibilityOptions, photo, placeType, isFromMapClick) {
    const averageRating = reviewsData.averageRating !== undefined ? reviewsData.averageRating.toFixed(1) : "No ratings yet";
    const reviewCount = reviewsData.reviewCount || "No reviews";
    const avatarUrl = <?php echo json_encode($_SESSION['avatar_url'] ?? ''); ?>;
    const starsHtml = Array.from({
      length: 5
    }, (v, i) => `<i class="fa fa-star ${i < averageRating ? "active" : ""}"></i>`).join("");

    // Helper function to calculate time ago
    function timeAgo(reviewDate) {
      const date = new Date(reviewDate); // Make sure reviewDate is a valid Date string
      const now = new Date();
      const seconds = Math.floor((now - date) / 1000);

      let interval = Math.floor(seconds / 31536000);
      if (interval >= 1) return interval === 1 ? "1 year ago" : `${interval} years ago`;

      interval = Math.floor(seconds / 2592000);
      if (interval >= 1) return interval === 1 ? "1 month ago" : `${interval} months ago`;

      interval = Math.floor(seconds / 86400);
      if (interval >= 1) return interval === 1 ? "1 day ago" : `${interval} days ago`;

      interval = Math.floor(seconds / 3600);
      if (interval >= 1) return interval === 1 ? "1 hour ago" : `${interval} hours ago`;

      interval = Math.floor(seconds / 60);
      if (interval >= 1) return interval === 1 ? "1 minute ago" : `${interval} minutes ago`;

      return seconds < 5 ? "just now" : `${Math.floor(seconds)} seconds ago`;
    }


    // Generate reviews HTML
    const reviewsHtml = reviewsData.reviews.map(review => {
      const starsHtml = Array.from({
        length: 5
      }, (v, i) => `<i class="fa fa-star ${i < review.rating ? "active" : ""}"></i>`).join("");
      const reviewTimeAgo = timeAgo(review.review_date); // Use the review_date field here
      return `
            <div class="review">
              <div style="display: flex; align-items: center;">
                <img src="${review.avatar_url}" alt="Avatar" style="width: 30px; height: 30px; border-radius: 50%; margin-right: 10px;">
                <p><strong>${review.full_name}</strong> - <strong>Rating:</strong> ${review.rating}</p>
              </div>
              <div class="stars">${starsHtml}</div>
              <p>${review.review}</p>
              <p><small>${reviewTimeAgo}</small></p>  <!-- Display the time ago -->
            </div>
            <hr>
        `;
    }).join("");

    const photoUrl = photo ? `https://places.googleapis.com/v1/${photo.name}/media?maxHeightPx=400&key=AIzaSyBowuNI1xQJvodo3uooqXbVbFnoRtcOJ1E` : '';

    // Create the photo HTML if a photo is available
    const photoHtml = photoUrl ? `
      <div class="placeimage">
        <img src="${photoUrl}" alt="${place.displayName.text}"  </div>` : '';
    return `

        <div>
            ${photoHtml}
            <h4>${place.displayName.text}</h4>
            <p>${place.formattedAddress}</p>
            <ul>
              ${accessibilityOptions.wheelchairAccessibleParking
                ? "<li class='no-bullet'><i class='fa-solid fa-wheelchair' style='color: #007bff;'></i> Has PWD Accessible Parking: <i class='fa-solid fa-check' style='color: green;'></i></li>"
                : "<li class='no-bullet'><i class='fa-solid fa-wheelchair' style='color: #007bff;'></i> Has PWD Accessible Parking - Not Accessible</li>"}
              ${accessibilityOptions.wheelchairAccessibleEntrance
                ? "<li class='no-bullet'><i class='fa-solid fa-wheelchair' style='color: #007bff;'></i> Has PWD Accessible Entrance: <i class='fa-solid fa-check' style='color: green;'></i></li>"
                : "<li class='no-bullet'><i class='fa-solid fa-wheelchair' style='color: #007bff;'></i> Has PWD Accessible Entrance - Not Accessible</li>"}
              ${accessibilityOptions.wheelchairAccessibleRestroom
                ? "<li class='no-bullet'><i class='fa-solid fa-wheelchair' style='color: #007bff;'></i> Has PWD Accessible Restroom: <i class='fa-solid fa-check' style='color: green;'></i></li>"
                : "<li class='no-bullet'><i class='fa-solid fa-wheelchair' style='color: #007bff;'></i> Has PWD Accessible Restroom - Not Accessible</li>"}
              ${accessibilityOptions.wheelchairAccessibleSeating
                ? "<li class='no-bullet'><i class='fa-solid fa-wheelchair' style='color: #007bff;'></i> Has PWD Accessible Seating: <i class='fa-solid fa-check' style='color: green;'></i></li>"
                : "<li class='no-bullet'><i class='fa-solid fa-wheelchair' style='color: #007bff;'></i> Has PWD Accessible Seating - Not Accessible</li>"}
            </ul>
            <div class="d-flex justify-content-center">
                <button class="btn btn-primary btn-sm" onclick="openReviewModal('${place.id}', '${place.displayName.text.replace(/'/g, "\\'")}', '${place.formattedAddress.replace(/'/g, "\\'")}', '${photoUrl.replace(/'/g, "\\'")}', '${placeType}', ${isFromMapClick}, '${avatarUrl.replace(/'/g, "\\'")}')">Write a Review</button>
                <button class="btn btn-primary btn-sm" onclick="openAccessibilityModal('${place.id}', '${place.displayName.text.replace(/'/g, "\\'")}')">Update Accessibility</button>
            </div>
            
            <hr>
            <div class="review-summary">
              <div class="average-rating">
                <span class="rating-number">${averageRating}</span>
                <div class="stars">${starsHtml}</div>
                <p class="total-reviews">${reviewCount} reviews</p> 
              </div>
              <hr>
            </div>

            <div class="recent-reviews">
              <div class="reviews-list">
                <h4>Recent Reviews:</h4>
                ${reviewsHtml}
              </div>
            </div>
        </div>
    `;
  }

  function openReviewModal(placeId, displayName, formattedAddress, photoUrl, placeType, isFromMapClick, avatarUrl) {
    console.log("Opening review modal for:", placeId, displayName, formattedAddress, placeType, isFromMapClick, avatarUrl);
    document.getElementById('place_id_modal').value = placeId;
    document.getElementById('photo_url_modal').value = photoUrl || '';
    document.getElementById('display_name_modal').value = displayName;
    document.getElementById('formatted_address_modal').value = formattedAddress;
    document.getElementById('place_type_modal').value = isFromMapClick ? placeType : currentPlaceType;
    document.getElementById('avatar_url_modal').value = avatarUrl;
    $('#reviewModal').modal('show');
  }
  // Eto yung logic sa stars in the ratings
  document.addEventListener('DOMContentLoaded', function() {
    const stars = document.querySelectorAll('.stars i');
    let selectedRating = 0;
    stars.forEach((star, index1) => {
      star.addEventListener('click', () => {
        selectedRating = index1 + 1;
        stars.forEach((star, index2) => {
          index1 >= index2 ? star.classList.add('active') : star.classList.remove('active');
        });
        document.getElementById('rating_input').value = selectedRating;
      });
    });
  });

  function openAccessibilityModal(placeId, displayName) {
    console.log("Opening accessibility modal for:", placeId, displayName);

    // Set place ID and display name
    document.getElementById("place_id_accessibility_modal").value = placeId;
    document.getElementById("display_name_modal1").value = displayName;

    // Fetch accessibility options and update the checkboxes
    fetch(`fetch_accessibility_options.php?place_id=${placeId}`)
      .then(response => response.json())
      .then(data => {
        // Update checkboxes based on fetched data
        for (const [key, value] of Object.entries(data)) {
          const checkbox = document.querySelector(`#accessibilityModal input[name="accessibilityOptions[]"][value="${key}"]`);
          if (checkbox) {
            checkbox.checked = value;
          }
        }
        // Show the modal
        $("#accessibilityModal").modal("show");
      })
      .catch(error => {
        console.error("Error fetching accessibility options:", error);
        // Show the modal even if fetch fails
        $("#accessibilityModal").modal("show");
      });
  }

  // Add event listener for accessibility form submission
  document.querySelector("#accessibilityModal form").addEventListener("submit", function(event) {
    event.preventDefault();
    const formData = new FormData(this);
    fetch("submit_accessibility.php", {
        method: "POST",
        body: formData,
      })
      .then((response) => response.json())
      .then((data) => {
        if (data.status === "success") {
          Swal.fire({
            title: "Success!",
            text: data.message,
            icon: "success",
            confirmButtonText: "OK",
          }).then(() => {
            $("#accessibilityModal").modal("hide");

            // Get the place details
            const placeId = formData.get('place_id');
            const displayName = formData.get('display_name');
            // Find the place's location
            const place = markers.find(marker => marker.getTitle() === displayName);
            if (place) {
              // Simulate a click on the place's location
              handleMapClick(place.getPosition());
            } else {
              console.error("Place not found for updating marker");
            }
          });
        } else {
          Swal.fire({
            title: "Error!",
            text: data.message,
            icon: "error",
            confirmButtonText: "OK",
          });
        }
      })
      .catch((error) => {
        console.error("Error updating accessibility options:", error);
        Swal.fire({
          title: "Error!",
          text: "There was an error updating accessibility options. Please try again.",
          icon: "error",
          confirmButtonText: "OK",
        });
      });
  });

  function updateAccessibilityLevel() {
    const checkboxes = document.querySelectorAll('#accessibilityModal input[type="checkbox"]');
    const accessibilityCount = Array.from(checkboxes).filter(checkbox => checkbox.checked).length;

    let accessibilityLevel = "Not Accessible";
    if (accessibilityCount > 2) accessibilityLevel = "Highly Accessible";
    else if (accessibilityCount > 0) accessibilityLevel = "Partially Accessible";

    document.getElementById("accessibility_level").value = accessibilityLevel;
  }

  document.querySelectorAll('#accessibilityModal input[type="checkbox"]')
    .forEach(checkbox => checkbox.addEventListener("change", updateAccessibilityLevel));

  function showReviews(placeId) {
    fetch(`fetch_reviews.php?place_id=${placeId}`)
      .then(response => response.json())
      .then(reviewsData => {
        let reviewsHtml = "No reviews yet.";
        if (reviewsData.reviews && reviewsData.reviews.length > 0) {
          reviewsHtml = reviewsData.reviews.map(review => {
            const starsHtml = Array.from({
                length: 5
              }, (_, i) =>
              `<i class="fa fa-star ${i < review.rating ? "active" : ""}"></i>`
            ).join("");
            return `
            <div class="review">
              <p><strong>${review.full_name}</strong> - <strong>Rating:</strong> ${review.rating}</p>
              <div class="stars">${starsHtml}</div>
              <p>${review.review}</p>
            </div>
            <hr>
          `;
          }).join("");
        }
        document.getElementById("reviewsContent").innerHTML = reviewsHtml;
        $("#reviewsModal").modal("show");
      })
      .catch(error => {
        console.error("Error fetching reviews:", error);
        document.getElementById("reviewsContent").innerHTML = "Error loading reviews.";
        $("#reviewsModal").modal("show");
      });
  }

  function openPlaceDetailsPanel() {
    document.getElementById('place-details-panel').classList.add('open');
    document.getElementById('map').classList.add('panel-open');
  }

  function closePlaceDetailsPanel() {
    document.getElementById('place-details-panel').classList.remove('open');
    document.getElementById('map').classList.remove('panel-open');
  }

  document.getElementById('close-details').addEventListener('click', closePlaceDetailsPanel);

  // Add these functions to your existing JavaScript
  let searchTimeout;

  document.getElementById('searchInput').addEventListener('input', function(e) {
    const input = e.target.value;

    // Clear previous timeout
    clearTimeout(searchTimeout);

    // Set new timeout to avoid too many API calls
    searchTimeout = setTimeout(() => {
      if (input.length >= 3) { // Only search if input is 3 or more characters
        searchPlaces(input);
      } else {
        document.getElementById('searchResults').style.display = 'none';
      }
    }, 300);
  });

  function searchPlaces(input) {
    const request = {
      input: input,
      locationBias: {
        circle: {
          center: {
            latitude: 14.1846,
            longitude: 121.2385
          },
          radius: 5000.0
        }
      }
    };

    fetch('https://places.googleapis.com/v1/places:autocomplete', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-Goog-Api-Key': 'AIzaSyBowuNI1xQJvodo3uooqXbVbFnoRtcOJ1E'
        },
        body: JSON.stringify(request)
      })
      .then(response => response.json())
      .then(data => {
        displaySearchResults(data.suggestions);
      })
      .catch(error => {
        console.error('Error fetching autocomplete results:', error);
      });
  }

  function displaySearchResults(suggestions) {
    const resultsDiv = document.getElementById('searchResults');
    resultsDiv.innerHTML = '';

    if (!suggestions || suggestions.length === 0) {
      resultsDiv.style.display = 'none';
      return;
    }

    suggestions.forEach(suggestion => {
      if (suggestion.placePrediction) {
        const place = suggestion.placePrediction;
        const div = document.createElement('div');
        div.className = 'search-result-item';
        div.textContent = place.text.text;

        div.addEventListener('click', () => {
          handlePlaceSelection(place.place);
          resultsDiv.style.display = 'none';
          document.getElementById('searchInput').value = place.text.text;
        });

        resultsDiv.appendChild(div);
      }
    });

    resultsDiv.style.display = 'block';
  }

  function handlePlaceSelection(placeId) {
    // Fetch place details using Places API
    fetch(`https://places.googleapis.com/v1/${placeId}`, {
        headers: {
          'X-Goog-Api-Key': 'AIzaSyBowuNI1xQJvodo3uooqXbVbFnoRtcOJ1E',
          'X-Goog-FieldMask': 'id,displayName,formattedAddress,location,accessibilityOptions,photos,primaryType'
        }
      })
      .then(response => response.json())
      .then(place => {
        // Center and zoom the map
        const location = new google.maps.LatLng(
          place.location.latitude,
          place.location.longitude
        );
        map.setCenter(location);
        map.setZoom(19);

        // Use your existing functions to handle the place
        fetchPlaceDetails(place, true, place.primaryType || 'Unknown', true);
      })
      .catch(error => {
        console.error('Error fetching place details:', error);
      });
  }

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