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
    // Sidebar is open
    hamburgerMenu.style.display = "none";
    closeBtn.style.display = "block";
  } else {
    // Sidebar is closed
    hamburgerMenu.style.display = "block";
    closeBtn.style.display = "none";
  }
}

function initMap() {
  // Create a map centered around the user's location
  navigator.geolocation.getCurrentPosition(
    (position) => {
      const userLocation = {
        lat: position.coords.latitude,
        lng: position.coords.longitude,
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
        includedTypes: [currentType], // Use the currentType variable
        locationRestriction: {
          circle: {
            center: {
              latitude: userLocation.lat,
              longitude: userLocation.lng,
            },
            radius: 5000,
          },
        },
      };

      // Make a POST request to the Nearby Search (New) endpoint
      fetch(
        "https://places.googleapis.com/v1/places:searchNearby?key=AIzaSyBO23kIOUSOKRGYzYoVMbnEMmbriP6IvR8",
        {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
            "X-Goog-FieldMask":
              "places.id,places.displayName,places.formattedAddress,places.accessibilityOptions,places.location",
          },
          body: JSON.stringify(request),
        }
      )
        .then((response) => response.json())
        .then((data) => {
          console.log(data);

          // Create an info window
          const infoWindow = new google.maps.InfoWindow();

          // Loop through places and add markers
          data.places.forEach((place) => {
            // Check if the location property exists
            if (
              place.location &&
              place.location.latitude &&
              place.location.longitude
            ) {
              // Create content for the info window
              const content = `
                        <div>
                          <h3>${place.displayName.text}</h3>
                          <p>${place.formattedAddress}</p>
                          <p>Latitude: ${place.location.latitude}</p>
                          <p>Longitude: ${place.location.longitude}</p>
                          <ul>
                            ${
                              place.accessibilityOptions
                                .wheelchairAccessibleParking
                                ? "<li>pwdAccessibleParking : " +
                                  '<img class="icon" src="images/check.png" alt="Check Icon" width="5">' +
                                  "</li>"
                                : "<li>pwdAccessibleParking - Not Available</li>"
                            }
                            ${
                              place.accessibilityOptions
                                .wheelchairAccessibleEntrance
                                ? "<li>pwdAccessibleEntrance : " +
                                  '<img class="icon" src="images/check.png" alt="Check Icon" width="5">' +
                                  "</li>"
                                : "<li>pwdAccessibleEntrance- Not Available</li>"
                            }
                            ${
                              place.accessibilityOptions
                                .wheelchairAccessibleRestroom
                                ? "<li>pwdAccessibleRestroom : " +
                                  '<img class="icon" src="images/check.png" alt="Check Icon" width="5">' +
                                  "</li>"
                                : "<li>pwdAccessibleRestroom - Not Available</li>"
                            }
                            ${
                              place.accessibilityOptions
                                .wheelchairAccessibleSeating
                                ? "<li>pwdAccessibleSeating : " +
                                  '<img class="icon" src="images/check.png" alt="Check Icon" width="5">' +
                                  "</li>"
                                : "<li>pwdAccessibleSeating - Not Available</li>"
                            }
                          </ul>
                          <p>Leave a Review:</p>
                          <form>
                            <label for="review">Your Review:</label>
                            <textarea id="review" name="review" rows="4" cols="50"></textarea>
                            <br>
                            <input type="submit" value="Submit">
                          </form>
                        </div>
                      `;
              // Create a marker that maps the accessible places
              const marker = new google.maps.Marker({
                position: {
                  lat: place.location.latitude,
                  lng: place.location.longitude,
                },
                map: map,
                title: place.displayName.text,
              });

              // Add click event listener to open the info window
              marker.addListener("click", function () {
                infoWindow.setContent(content);
                infoWindow.open(map, marker);
              });
            }
          });
        })
        .catch((error) => console.error("Error:", error));
    },
    (error) => {
      console.error("Error getting user location:", error);
    }
  );
}
// Call initMap when the page loads
window.onload = initMap;
