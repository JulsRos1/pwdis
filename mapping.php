<?php
include('includes/config.php');
session_start();
?>
<!DOCTYPE html>
<html>

<head>
  <title>Wheelchair Accessible Places in Los Baños, Laguna</title>
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
  <link href="css/modern-business.css" rel="stylesheet" />
  <link rel="stylesheet" href="css/mapcontent.css" />
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBO23kIOUSOKRGYzYoVMbnEMmbriP6IvR8&libraries=places" defer async></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
  <?php include("includes/header.php"); ?>
  <div id="map-container">
    <div class="legend">
      <h4>Legend</h4>
      <ul>
        <li><span style="background-color: red"></span> Not Accessible (0 Options)</li>
        <li><span style="background-color: blue"></span> Accessible (1-2 Options)</li>
        <li><span style="background-color: green"></span> Highly Accessible (3-4 Options)</li>
      </ul>
    </div>

    <div id="map"></div>
    <div class="hamburger-menu" id="hamburger-menu" onclick="toggleSidebar()">
      <i class="fas fa-bars fa-2x"></i>
    </div>
    <div class="close-btn" id="close-btn" onclick="toggleSidebar()">
      <i class="fas fa-times fa-2x"></i>
    </div>
    <div class="sidebar" id="sidebar">
      <div class="sidebar-header">Point of Interest Categories</div>
      <div class="sidebar-body">
        <button class="btn btn-primary sidebar-btn" onclick="updatePlaces('restaurant')">Restaurants</button>
        <button class="btn btn-primary sidebar-btn" onclick="updatePlaces('school')">Schools</button>
        <button class="btn btn-primary sidebar-btn" onclick="updatePlaces('hospital')">Healthcare</button>
        <button class="btn btn-primary sidebar-btn" onclick="updatePlaces('grocery_store')">Grocery Store</button>
        <button class="btn btn-primary sidebar-btn" onclick="updatePlaces('community_center')">Community Center</button>
      </div>
    </div>
  </div>
</body>


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
            <input type="hidden" name="display_name" id="display_name_modal">
            <input type="hidden" name="place_id" id="place_id_modal">
            <input type="hidden" name="first_name" value="<?php echo $_SESSION['name']; ?>">
            <input type="hidden" name="last_name" value="<?php echo $_SESSION['lname']; ?>">
            <input type="submit" value="Submit" name="submit">
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Accessibility Options Modal -->
<div class="modal fade" id="accessibilityModal" tabindex="-1" role="dialog" aria-labelledby="accessibilityModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="accessibilityModalLabel">Update Accessibility Options</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="submit_accessibility.php" method="POST">
          <p>Check the Accessibility Options Available</p>
          <input type="checkbox" id="parking" name="accessibilityOptions[]" value="wheelchairAccessibleParking">
          <label for="parking">Has PWD Accessible Parking</label><br>
          <input type="checkbox" id="entrance" name="accessibilityOptions[]" value="wheelchairAccessibleEntrance">
          <label for="entrance">Has PWD Accessible Entrance</label><br>
          <input type="checkbox" id="restroom" name="accessibilityOptions[]" value="wheelchairAccessibleRestroom">
          <label for="restroom">Has PWD Accessible Restroom</label><br>
          <input type="checkbox" id="seating" name="accessibilityOptions[]" value="wheelchairAccessibleSeating">
          <label for="seating">Has PWD Accessible Seating</label><br>

          <input type="hidden" name="display_name" id="display_name_modal1">
          <input type="hidden" name="place_id" id="place_id_accessibility_modal">
          <input type="submit" value="Submit" name="submit">
        </form>
      </div>
    </div>
  </div>
</div>

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
  let infoWindow;
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

  function toggleSidebar() {
    const sidebar = document.getElementById("sidebar");
    sidebar.classList.toggle("open");
    const hamburgerMenu = document.getElementById("hamburger-menu");
    const closeBtn = document.getElementById("close-btn");
    hamburgerMenu.style.display = sidebar.classList.contains("open") ? "none" : "block";
    closeBtn.style.display = sidebar.classList.contains("open") ? "block" : "none";
  }

  function initMap() {
    navigator.geolocation.getCurrentPosition(
      (position) => {
        userLocation = {
          lat: position.coords.latitude,
          lng: position.coords.longitude,
        };

        map = new google.maps.Map(document.getElementById("map"), {
          center: userLocation,
          zoom: 15,
        });

        infoWindow = new google.maps.InfoWindow();

        // Display user's current location
        new google.maps.Marker({
          position: userLocation,
          map: map,
          title: "Your Location",
          icon: {
            url: "images/usericonmap.png",
          },
        });
      },
      (error) => {
        console.error("Geolocation error:", error);
      }
    );
  }

  function updatePlaces(type) {
    // Clear existing markers (if any)
    clearMarkers();
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
        "https://places.googleapis.com/v1/places:searchNearby?key=AIzaSyBO23kIOUSOKRGYzYoVMbnEMmbriP6IvR8", {
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
        data.places.forEach((place) => {
          console.log("Parsed data: ", data);
          if (
            place.location &&
            place.location.latitude &&
            place.location.longitude
          ) {
            fetch(`fetch_accessibility_options.php?place_id=${place.id}`)
              .then((response) => response.json())
              .then((userAccessibility) => {
                const accessibilityOptions = {
                  wheelchairAccessibleParking: userAccessibility?.wheelchairAccessibleParking !== null ?
                    userAccessibility.wheelchairAccessibleParking : place.accessibilityOptions
                    ?.wheelchairAccessibleParking,
                  wheelchairAccessibleEntrance: userAccessibility?.wheelchairAccessibleEntrance !== null ?
                    userAccessibility.wheelchairAccessibleEntrance : place.accessibilityOptions
                    ?.wheelchairAccessibleEntrance,
                  wheelchairAccessibleRestroom: userAccessibility?.wheelchairAccessibleRestroom !== null ?
                    userAccessibility.wheelchairAccessibleRestroom : place.accessibilityOptions
                    ?.wheelchairAccessibleRestroom,
                  wheelchairAccessibleSeating: userAccessibility?.wheelchairAccessibleSeating !== null ?
                    userAccessibility.wheelchairAccessibleSeating : place.accessibilityOptions
                    ?.wheelchairAccessibleSeating,
                };

                addMarker(place, accessibilityOptions);
              })
              .catch((error) => {
                console.error(
                  "Fetch error for accessibility options:",
                  error
                );
              });
          }
        });
      })
      .catch((error) => {
        console.error("Fetch error for places:", error);
      });

    toggleSidebar();
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

    markers.push(marker); // Add the marker to our array

    marker.addListener("click", function() {
    fetch(`fetch_reviews.php?place_id=${place.id}`)
      .then((response) => response.json())
      .then((reviewsData) => {
        const content = createInfoWindowContent(
          place,
          reviewsData,
          accessibilityOptions,
          place.photos && place.photos.length > 0 ? place.photos[0] : null
        );
        infoWindow.setContent(content);
        infoWindow.open(map, marker);
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

  function createInfoWindowContent(place, reviewsData, accessibilityOptions, photo) {
  const averageRating = reviewsData.averageRating !== undefined ? reviewsData.averageRating.toFixed(1) : "No ratings yet";
  const reviewCount = reviewsData.reviewCount || "No reviews";
  const starsHtml = Array.from({ length: 5 }, (v, i) => `<i class="fa fa-star ${i < averageRating ? "active" : ""}"></i>`).join("");
  const reviewsHtml = reviewsData.reviews.map(review => `<p><strong>Rating:</strong> ${review.rating} - ${review.review}</p>`).join("<br>");

  // Create the photo HTML if a photo is available
  const photoHtml = photo ? `
    <img src="https://places.googleapis.com/v1/${photo.name}/media?key=AIzaSyBO23kIOUSOKRGYzYoVMbnEMmbriP6IvR8&maxHeightPx=200&maxWidthPx=200" 
         alt="${place.displayName.text}" 
         style="max-width: 200px; max-height: 200px; object-fit: cover;   display: block; margin-left: auto;  margin-right: auto; width: 100%;">` : '';

  return `
    <div>
      ${photoHtml}
      <h4>${place.displayName.text}</h4>
      <p>${place.formattedAddress}</p>
      <ul>
        ${accessibilityOptions.wheelchairAccessibleParking
          ? "<li>Has PWD Accessible Parking: <img class='icon' src='images/check.png' alt='Check Icon' width='15'></li>"
          : "<li>Has PWD Accessible Parking - Not Accessible</li>"}
        ${accessibilityOptions.wheelchairAccessibleEntrance
          ? "<li>Has PWD Accessible Entrance: <img class='icon' src='images/check.png' alt='Check Icon' width='15'></li>"
          : "<li>Has PWD Accessible Entrance - Not Accessible</li>"}
        ${accessibilityOptions.wheelchairAccessibleRestroom
          ? "<li>Has PWD Accessible Restroom: <img class='icon' src='images/check.png' alt='Check Icon' width='15'></li>"
          : "<li>Has PWD Accessible Restroom - Not Accessible</li>"}
        ${accessibilityOptions.wheelchairAccessibleSeating
          ? "<li>Has PWD Accessible Seating: <img class='icon' src='images/check.png' alt='Check Icon' width='15'></li>"
          : "<li>Has PWD Accessible Seating - Not Accessible</li>"}
      </ul>
      <div class="d-flex justify-content-center">
        <button class="btn btn-primary btn-sm" onclick="openReviewModal('${place.id}', '${place.displayName.text}')">Write a Review</button>
        <button class="btn btn-info btn-sm" onclick="openAccessibilityModal('${place.id}', '${place.displayName.text}')">Update Accessibility</button>
      </div>
      <hr>
      <div>
        <h4>Reviews Summary:</h4>
        <p><strong>Average Rating:</strong> ${averageRating} / 5</p>
        <div class="stars">${starsHtml}</div>
        <p><strong>Total Reviews:</strong> ${reviewCount}</p>
        <hr>
      </div>
      <div class="d-flex justify-content-center">
        <button class="btn btn-primary btn-sm" onclick="showReviews('${place.id}')">Show Reviews</button>
      </div>
    </div>
  `;
}

  function openReviewModal(placeId, displayName) {
    document.getElementById('place_id_modal').value = placeId;
    document.getElementById('display_name_modal').value = displayName;
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
    document.getElementById("place_id_accessibility_modal").value = placeId;
    document.getElementById("display_name_modal1").value = displayName;

    fetch(`fetch_accessibility_options.php?place_id=${placeId}`)
      .then((response) => response.json())
      .then((data) => {
        // Update checkboxes based on fetched data
        for (const [key, value] of Object.entries(data)) {
          const checkbox = document.querySelector(
            `#accessibilityModal input[name="accessibilityOptions[]"][value="${key}"]`
          );
          if (checkbox) {
            checkbox.checked = value;
          }
        }
        $("#accessibilityModal").modal("show");
      })
      .catch((error) => {
        console.error("Error fetching accessibility options:", error);
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
              updatePlaceInfo(formData.get("place_id"));
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
  else if (accessibilityCount > 0) accessibilityLevel = "Accessible";
  
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
          const starsHtml = Array.from({length: 5}, (_, i) => 
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
</script>
</body>

</html>