
// Open mobile navbar
const tBtn = document.getElementById("nav-toggler");
const mNav = document.getElementById("mobile-nav").querySelector("#sidebar");
const nOverlay = document.getElementsByClassName("mobile-nav-overlay");
const topNav = document.getElementById("top-nav");
tBtn.addEventListener("click", () => {
  nOverlay[0].classList.remove("d-none");
  nOverlay[0].classList.add("d-block");
  mNav.style.marginLeft = "0px";
});

// Close mobile navbar
nOverlay[0].addEventListener("click", (e) => {
  let ele = e.target;
  mNav.style.marginLeft = "-250px";
  ele.classList.remove("d-block");
  ele.classList.add("d-none")
})

// Change topnav bg color on scroll
const logoBlack = document.getElementsByClassName("nav-logo-black")[0];
const logoWhite = document.getElementsByClassName("nav-logo-white")[0];
const optionsNav = document.getElementById("nav-options");
const child = [...topNav.children[0].children]
document.addEventListener("scroll", () => {
  if (window.scrollY > 100) {
    // changing text color
    child.map((nod, i) => {
      if (i == 4) {
        nod.classList.add("join-btn-second");
        nod.classList.remove("border-white");
      } else nod.classList.add("text-black");
      nod.classList.remove("text-white");
    })
    // changing bg color
    topNav.classList.add("bg-white");
    // changing logo
    logoWhite.classList.remove("d-block")
    logoWhite.classList.add("d-none")
    logoBlack.classList.add("d-block")
    logoBlack.classList.remove("d-none")

    //Adding options bar on scroll 
    optionsNav.classList.add("d-sm-flex");
  } else {
    // changin bg color
    topNav.classList.remove("bg-white");
    // changing text color
    child.map((nod, i) => {
      if (i == 4) {
        nod.classList.remove("join-btn-second");
        nod.classList.add("border-white");
      } else nod.classList.remove("text-black");
      nod.classList.add("text-white");
    })
    // changing logo
    logoWhite.classList.remove("d-none")
    logoWhite.classList.add("d-block")
    logoBlack.classList.add("d-none")
    logoBlack.classList.remove("d-block")

    //Removing options bar on scroll 
    optionsNav.classList.remove("d-sm-flex");
  }
})

$(document).ready(function () {
  const servParent = $("#services-slider-wrapper");

  // Add a loading indicator before fetching categories
  const loadingIndicator = $(`
      <div id="services-loading-indicator" class="text-center my-3">
          <div class="spinner-border text-primary" role="status">
              <span class="visually-hidden">Loading...</span>
          </div>
      </div>
  `);
  servParent.before(loadingIndicator);

  // Fetch all categories via AJAX
  $.ajax({
    url: '../actions/get_all_categories_action.php',
    type: 'GET',
    dataType: 'json',
    success: function (data) {
      // Hide the loading indicator after receiving data
      loadingIndicator.hide();

      // Clear any existing content in the slider wrapper
      servParent.empty();

      if (Array.isArray(data) && data.length > 0) {
        // Create a container div for the service cards
        const servDivNode = $('<div>').addClass('row d-flex flex-nowrap').css({
          'gap': '16px',
          'overflow-x': 'auto'
        });

        // Iterate over each category and create a service card
        data.forEach(function (category) {
          // Capitalize the first letter of the category name
          const categoryName = category.name.charAt(0).toUpperCase() + category.name.slice(1);

          // Create the service card div using Bootstrap's Card component
          const cardDiv = $(`
                      <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                          <div class="card h-100 text-white" style="position: relative; border: none;">
                              <img src="${category.image}" class="card-img" alt="${category.name}" style="height: 200px; object-fit: cover; border-radius: 10px;">
                              <div class="card-img-overlay d-flex align-items-end p-0">
                                  <h5 class="card-title w-100 text-center bg-dark bg-opacity-50 py-2 m-0">${categoryName}</h5>
                              </div>
                          </div>
                      </div>
                  `);

          // Append the service card to the container
          servDivNode.append(cardDiv);
        });

        // Append the container to the slider wrapper
        servParent.append(servDivNode);
      } else {
        // If no categories are found, display a message
        const noDataMessage = $('<p>').text('No categories found.').addClass('text-center');
        servParent.append(noDataMessage);
      }
    },
    error: function (xhr, status, error) {
      // Hide the loading indicator in case of an error
      loadingIndicator.hide();
      console.error('Error fetching categories:', error);

      // Clear any existing content and display an error message
      servParent.empty();
      const errorMessage = $('<p>')
        .text('Failed to load categories. Please try again later.')
        .addClass('text-center text-danger');
      servParent.append(errorMessage);
    }
  });
});
//scroll services
const servLeft = document.getElementById("slider-left-arrow");
const servRight = document.getElementById("slider-right-arrow");
servRight.addEventListener("click", () => {
  const width = servParent.offsetWidth;
  const current = servParent.scrollLeft;
  servParent.scrollTo(current + width, 0)
})

servLeft.addEventListener("click", () => {
  const width = servParent.offsetWidth;
  const current = servParent.scrollLeft;
  servParent.scrollTo(current - width, 0)
})

// In script.js
window.people = [
  {
    id: 1,
    name: "Gideon Boakye",
    startingPrice: "$50",
    rating: 4.5,
    image: "img/silhouette.png",
    profileLink: "profile.html?id=1",
    phone: "+233 123 456 789",
    email: "gideon.boakye@example.com",
    numberOfJobs: 25,
    description: "Experienced graphic designer with a passion for creating stunning visuals. I have worked with numerous clients to bring their visions to life."
  }
];