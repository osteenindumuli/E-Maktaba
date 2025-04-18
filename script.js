document.addEventListener("DOMContentLoaded", function() {
      let currentSlide = 0;
      const slides =  document.querySelectorAll('.slide');

      //Function to show the current slide
      function showSlide(n) {
        slides[currentSlide].style.display = 'none';
        currentSlide = (n + slides.length) % slides.length;
        slides[currentSlide].style.display = 'block';

      }

      //Initial display of the first slide
        showSlide(currentSlide);

        //Automatically advance to the next slide every 3 seconds
        setInterval(function() {
            showSlide(currentSlide + 1);
        }, 3000)

    // Toggle the navbar menu on small screens
    const menuIcon = document.querySelector(".menu-icon");
    const navbarMenu = document.querySelector(".navbar ul");

    menuIcon.addEventListener("click", function () {
        navbarMenu.classList.toggle("active");
    });
})


//Slider JavaScript Code
new Swiper('.card-wrapper', {
    loop: true,
    spaceBetween: 30,
  
    // Pagination bullets
    pagination: {
      el: '.swiper-pagination',
      clickable: true,
      dynamicBullets: true
    },
  
    // Navigation arrows
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },

    // Responsive breakpoints
    breakpoints: {
        0:{
            slidesPerView: 1,
        },
        768:{
            slidesPerView: 1,
        },
        1024:{
            slidesPerView: 1,
        },
    }
  
  });


//Search Button
function selectFilter(filter) {
    document.getElementById('searchInput').value = filter;
    document.getElementById('filterMenu').style.display = 'none';
  }
  
  document.getElementById('searchInput').addEventListener('focus', function() {
    document.getElementById('filterMenu').style.display = 'block';
  });
  
  document.addEventListener('click', function(event) {
    var isClickInside = document.getElementById('searchInput').contains(event.target) || document.getElementById('filterMenu').contains(event.target);
  
    if (!isClickInside) {
        document.getElementById('filterMenu').style.display = 'none';
    }
  });




 