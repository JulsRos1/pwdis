<?php
include('includes/config.php');
session_start();
?>
<!DOCTYPE html>
<html>

<head>
  <title>Wheelchair Accessible Places in Los Baños, Laguna</title>
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link href="css/modern-business.css" rel="stylesheet">
  <link rel="stylesheet" href="css/mapcontent.css">
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBO23kIOUSOKRGYzYoVMbnEMmbriP6IvR8&libraries=places" defer async></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
  <?php include("includes/header.php"); ?>
  <div id="map-container">
    <div class="legend">
      <h4>Legend</h4>
      <ul>
        <li><span style="background-color: red;"></span> Not Accessible (0 Options)</li>
        <li><span style="background-color: blue;"></span> Accessible (1-2 Options)</li>
        <li><span style="background-color: green;"></span> Highly Accessible (3-4 Options)</li>
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
      <div class="sidebar-header">
        Point of Interest Categories
      </div>
      <div class="sidebar-body">
        <button class="btn btn-primary sidebar-btn" onclick="getNearbyAccessibleHospital(); toggleSidebar()">Healthcare</button>
        <button class="btn btn-primary sidebar-btn" onclick="getNearbyAccessibleSchools(); toggleSidebar()">Schools</button>
        <button class="btn btn-primary sidebar-btn" onclick="getNearbyAccessibleGroceryStore(); toggleSidebar()">Grocery Store</button>
        <button class="btn btn-primary sidebar-btn" onclick="getNearbyAccessibleRestaurants(); toggleSidebar()">Restaurants</button>
        <button class="btn btn-primary sidebar-btn" onclick="getNearbyAccessibleCommunityCenter(); toggleSidebar()">Community Center</button>
      </div>
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
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script> <!-- Bootstrap JS -->

  <script>
    let currentType = '';
    document.addEventListener('DOMContentLoaded', function() {
      // Call initMap() when the page is fully loaded
      initMap();
      const reviewForm = document.querySelector('#reviewModal form');

      reviewForm.addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent the default form submission

        const formData = new FormData(reviewForm);

        // Use fetch to submit the form data via AJAX
        fetch('submit_review.php', {
            method: 'POST',
            body: formData
          })
          .then(response => response.json())
          .then(data => {
            // Handle the response
            if (data.status === 'success') {
              Swal.fire({
                title: 'Success!',
                text: data.message,
                icon: 'success',
                confirmButtonText: 'OK'
              }).then(() => {
                // Optionally, reload the page or close the modal
                $('#reviewModal').modal('hide');
                reviewForm.reset(); // Clear the form after success
              });
            } else {
              Swal.fire({
                title: 'Error!',
                text: data.message,
                icon: 'error',
                confirmButtonText: 'OK'
              });
            }
          })
          .catch(error => {
            console.error('Error submitting review:', error);
            Swal.fire({
              title: 'Error!',
              text: 'There was an error submitting your review. Please try again.',
              icon: 'error',
              confirmButtonText: 'OK'
            });
          });
      });
    });

    function getNearbyAccessibleRestaurants() {
      currentType = "restaurant";
      initMap();
    }

    function getNearbyAccessibleSchools() {
      currentType = "school";
      initMap();
    }

    function getNearbyAccessibleHospital() {
      currentType = "hospital";
      initMap();
    }

    function getNearbyAccessibleGroceryStore() {
      currentType = "grocery_store";
      initMap();
    }

    function getNearbyAccessibleCommunityCenter() {
      currentType = "community_center";
      initMap();
    }



    function toggleSidebar() {
      const sidebar = document.getElementById("sidebar");
      sidebar.classList.toggle("open");

      const hamburgerMenu = document.getElementById("hamburger-menu");
      const closeBtn = document.getElementById("close-btn");

      if (sidebar.classList.contains("open")) {
        hamburgerMenu.style.display = "none";
        closeBtn.style.display = "block";
      } else {
        hamburgerMenu.style.display = "block";
        closeBtn.style.display = "none";
      }
    }

    function initMap() {
      // Create a map centered around the user's location
      navigator.geolocation.getCurrentPosition(position => {
        const userLocation = {
          lat: position.coords.latitude,
          lng: position.coords.longitude
        };

        const map = new google.maps.Map(document.getElementById("map"), {
          center: userLocation,
          zoom: 15,
        });

        // display initial userlocation when accessible places not clicked
        const userMarker = new google.maps.Marker({
          position: userLocation,
          map: map,
          title: "Your Location",
          icon: {
            url: "images/usericonmap.png",
          },
        });

        const request = {
          "includedTypes": [currentType], // Use the currentType variable
          "locationRestriction": {
            "circle": {
              "center": {
                "latitude": userLocation.lat,
                "longitude": userLocation.lng,
              },
              "radius": 3000,
            },
          },
        };

        fetch('https://places.googleapis.com/v1/places:searchNearby?key=AIzaSyBO23kIOUSOKRGYzYoVMbnEMmbriP6IvR8', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'X-Goog-FieldMask': 'places.id,places.displayName,places.formattedAddress,places.accessibilityOptions,places.location,places.photos',
            },
            body: JSON.stringify(request),
          })
          .then((response) => response.json())
          .then((data) => {
            const infoWindow = new google.maps.InfoWindow();
            console.log('Parsed data:', data);



            data.places.forEach((place) => {
              if (place.location && place.location.latitude && place.location.longitude) {
                fetch(`fetch_reviews.php?place_id=${place.id}`)
                  .then(response => response.json())
                  .then(reviewsData => {
                    const accessibilityCount = [
                      place.accessibilityOptions?.wheelchairAccessibleParking,
                      place.accessibilityOptions?.wheelchairAccessibleEntrance,
                      place.accessibilityOptions?.wheelchairAccessibleRestroom,
                      place.accessibilityOptions?.wheelchairAccessibleSeating
                    ].filter(Boolean).length; // Count the true (available) options

                    if (accessibilityCount === 0) {
                      markerIcon = "images/red-marker.png"; // Not accessible
                    } else if (accessibilityCount <= 2) {
                      markerIcon = "images/blue-marker.png"; // Accessible
                    } else {
                      markerIcon = "images/green-marker.png"; // Highly accessible
                    }


                    const marker = new google.maps.Marker({
                      position: {
                        lat: place.location.latitude,
                        lng: place.location.longitude,
                      },
                      map: map,
                      title: place.displayName.text,
                      icon: {
                        url: markerIcon, // Use the icon variable based on accessibility
                        scaledSize: new google.maps.Size(40, 40) // Optional: Resize the icon
                      },
                    });

                    const reviews = reviewsData.reviews.map(review => `
                  <p><strong>Rating:</strong> ${review.rating} - ${review.review}</p>
                `).join('<br>');

                    const content = createInfoWindowContent(place, reviews, reviewsData);

                    marker.addListener("click", function() {
                      infoWindow.setContent(content);
                      infoWindow.open(map, marker);
                    });
                  });
              }
            });
          })
          .catch((error) => {
            console.error("Error:", error);
          });
      }, (error) => {
        console.error(error);
      });
    }

    // Function to count available accessibility options
    function countAccessibilityOptions(accessibilityOptions) {
      let count = 0;
      if (accessibilityOptions) {
        if (accessibilityOptions.wheelchairAccessibleParking) count++;
        if (accessibilityOptions.wheelchairAccessibleEntrance) count++;
        if (accessibilityOptions.wheelchairAccessibleRestroom) count++;
        if (accessibilityOptions.wheelchairAccessibleSeating) count++;
      }
      return count;
    }

    // Function to create info window content
    function createInfoWindowContent(place, reviews, reviewsData) {
      const averageRating = reviewsData.averageRating || 'No ratings yet';
      const reviewCount = reviewsData.reviewCount || 'No reviews';

      const starsHtml = Array.from({
          length: 5
        }, (v, i) =>
        `<i class="fa fa-star ${i < averageRating ? 'active' : ''}"></i>`
      ).join('');

      return `
    <div>
      <hr>
      <h4>${place.displayName.text}</h4>
      <p>${place.formattedAddress}</p>
      <ul>
        ${place.accessibilityOptions && place.accessibilityOptions.wheelchairAccessibleParking
          ? "<li>pwdAccessibleParking : <img class='icon' src='images/check.png' alt='Check Icon' width='5'></li>"
          : "<li>pwdAccessibleParking - Not Available</li>"
        }
        ${place.accessibilityOptions && place.accessibilityOptions.wheelchairAccessibleEntrance
          ? "<li>pwdAccessibleEntrance : <img class='icon' src='images/check.png' alt='Check Icon' width='5'></li>"
          : "<li>pwdAccessibleEntrance - Not Available</li>"
        }
        ${place.accessibilityOptions && place.accessibilityOptions.wheelchairAccessibleRestroom
          ? "<li>pwdAccessibleRestroom : <img class='icon' src='images/check.png' alt='Check Icon' width='5'></li>"
          : "<li>pwdAccessibleRestroom - Not Available</li>"
        }
        ${place.accessibilityOptions && place.accessibilityOptions.wheelchairAccessibleSeating
          ? "<li>pwdAccessibleSeating : <img class='icon' src='images/check.png' alt='Check Icon' width='5'></li>"
          : "<li>pwdAccessibleSeating - Not Available</li>"
        }
      </ul>
      <div class="d-flex justify-content-center">
        <button class="btn btn-primary btn-sm" onclick="openReviewModal('${place.id}')">Write a Review</button>
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



    function openReviewModal(placeId) {
      document.getElementById('place_id_modal').value = placeId;
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

    function showReviews(placeId) {
      // Fetch the reviews for the place
      fetch(`fetch_reviews.php?place_id=${placeId}`)
        .then(response => response.json())
        .then(reviewsData => {
          let reviewsHtml = '';

          if (reviewsData.reviews && reviewsData.reviews.length > 0) {
            reviewsHtml = reviewsData.reviews.map(review => `
          <p><strong>${review.full_name}</strong> - <strong>Rating:</strong> ${review.rating}</p>
          <p>${review.review}</p>
        `).join('<hr>');
          } else {
            reviewsHtml = 'No reviews yet.';
          }

          document.getElementById('reviewsContent').innerHTML = reviewsHtml;

          // Show the reviews modal
          $('#reviewsModal').modal('show');
        })
        .catch(error => {
          console.error('Error fetching reviews:', error);
          document.getElementById('reviewsContent').innerHTML = 'Error loading reviews.';
          $('#reviewsModal').modal('show');
        });
    }
  </script>
</body>

</html>