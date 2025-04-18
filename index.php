<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Kitabu Digital Library</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://kit.fontawesome.com/972dea01b5.js" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/972dea01b5.js" crossorigin="anonymous"></script>
      <!-- Google fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=arrow_forward" />

    <!-- Swiper JS -->
    <link
  rel="stylesheet"
  href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"
/>
    


</head>
<body>

    <!-- Homepage -->
     <section class="header" id="home">

        <div class="carousel">
            <div class="slide">
                <img src="images/img-1.jpg" >
                <div class="gradient-overlay"></div>
            </div>
            <div class="slide">
                <img src="images/img-2.jpg" >
                <div class="gradient-overlay"></div>
            </div>
            <div class="slide">
                <img src="images/img-4.jpg" >
                <div class="gradient-overlay"></div>
            </div>
            <div class="slide">
                <img src="images/img-5.jpg" >
                <div class="gradient-overlay"></div>
            </div>
            <div class="slide">
                <img src="images/img-6.jpg" >
                <div class="gradient-overlay"></div>
            </div>
        </div>

        <div class="navbar">
            <a href="index.php" class="logo">E-Maktaba</a>
            <!-- <span class="menu-icon" >&#9776;</span> Menu icon for small screens -->
            <nav>
                <ul id="navLinks">
                    <li><a href="#home" >Home</a></li>
                    <li><a href="#about">About Us</a></li>
                    <li><a href="#services">Services</a></li>
                    <li><a href="#contact">Contact Us</a></li>
                    <div class="search-container">
                        <input type="text" class="search-input" placeholder="Login" id="searchInput">
                        <div class="filter-menu" id="filterMenu">
                            <a href="Login Form/index.php" onclick="selectFilter('User')">User</a>
                            <a href="Login Form/index.php" onclick="selectFilter('Admin')">Admin</a>
                        </div>
                    </div>
                </ul>
                
            </nav>
            <i class="fa-solid fa-bars" id="toggleButton"></i>
        </div>

        <script>
        const toggleButton = document.getElementById('toggleButton');
        const navLinks = document.getElementById('navLinks');

        toggleButton.addEventListener('click', () => {
        navLinks.classList.toggle('active');
            });
        </script>

        <div class="text-box">
            <h1>Are you Intrested in Accessing and Reading Books Online?</h1>
            <p>Welcome to E-Maktaba Digital Library your gateway to a brighter tech career!</p>
            <a href="Login Form/index.php" class="hero-btn">Explore Now</a>
        </div>


     </section>

     <!-- About Section -->
      <div id="about">
      <div class="heading" >
        <h1>About Us</h1>
        <p>We are a Digital Library Platform ready to engage with learners to access books virtually.</p>
      </div>

      <div class="container">
        <section class="about">
            <div class="about-image">
                <img src="images/img-5.jpg" >
            </div>
            <div class="about-content">
                <h2>Welcome to Tech Study Group.</h2>
                <p>
                Welcome to E-Maktaba, your gateway to knowledge in the digital age. 
                E-Maktaba is a modern digital library designed to provide seamless 
                access to a wide range of academic, professional, and recreational 
                resources. Whether you're a student, researcher, or lifelong learner,
                 our platform offers an intuitive and user-friendly experience to explore
                  e-books, journals, articles, and multimedia content from anywhere, at any time. </p>
                    <a href="Login Form/index.php" class="read-more">E-Maktaba</a>
            </div>

        </section>
      </div>


      </div>
      
        <!-- Services Section -->
         <div id="services">
         <div class="work">
            <h1>Services</h1>
            <p> Our mission is to bridge the gap between information and accessibility
                 by harnessing the power of technology to support education and intellectual growth.
                  At E-Maktaba, we believe that knowledge should be within reach for everyone, 
                  and we are committed to building an inclusive digital space that empowers users
                   through learning, discovery, and innovation.
            </p>
         </div>

         <div class="card-container swiper">
            <div class="card-wrapper">
                <ul class="card-list swiper-wrapper">
                    <li class="card-item swiper-slide">
                        <a href="#" class="card-link">
                            <img src="images/frontend.jpg" class="card-image">
                            <p class="badge">Frontend Development</p>
                            <h2 class="card-title">Learn HTML,CSS,JavaScript and Frameworks like React</h2>
                            <button class="card-button material-symbols-rounded">
                                arrow_forward
                            </button>
                        </a>
                    </li>
                    <li class="card-item swiper-slide">
                        <a href="#" class="card-link">
                            <img src="images/backend.jpg" class="card-image">
                            <p class="badge">Backend Development</p>
                            <h2 class="card-title">Master server-side programming,databases and APIs</h2>
                            <button class="card-button material-symbols-rounded">
                                arrow_forward
                            </button>
                        </a>
                    </li>
                    <li class="card-item swiper-slide">
                        <a href="#" class="card-link">
                            <img src="images/img-2.jpg" class="card-image">
                            <p class="badge">UI/UX Development</p>
                            <h2 class="card-title">Dive into user experience design, prototyping and AI integration</h2>
                            <button class="card-button material-symbols-rounded">
                                arrow_forward
                            </button>
                        </a>
                    </li>
                    <li class="card-item swiper-slide">
                        <a href="#" class="card-link">
                            <img src="images/IT.jpg" class="card-image">
                            <p class="badge">IT Support</p>
                            <h2 class="card-title">Gain skills in troubleshooting,networking and system administration</h2>
                            <button class="card-button material-symbols-rounded">
                                arrow_forward
                            </button>
                        </a>
                    </li>
                    <li class="card-item swiper-slide">
                        <a href="#" class="card-link">
                            <img src="images/img-1.jpg" class="card-image">
                            <p class="badge">Copywriting</p>
                            <h2 class="card-title">Develop persuasive and engaging content for tech and beyond</h2>
                            <button class="card-button material-symbols-rounded">
                                arrow_forward
                            </button>
                        </a>
                    </li>
                </ul>


                <div class="swiper-pagination"></div>
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
            </div>
           </div>

         </div>
         

         <!-- About Section -->
      <div class="heading">
        <h1>Success Stories</h1>
        <p> Our members have gone on to land internships,
             secure full-time roles at top tech companies, and even launch their own startups.
             From building stunning websites to designing intuitive AI-driven apps, their achievements
             are a testament to the power of our collaborative learning environment. 
        </p>
      </div>

      <div class="container">
        <section class="about">
            <div class="about-image">
                <img src="images/img-3.jpg" >
            </div>
            <div class="about-content">
                <h2>Candidate Skill</h2>
                <p>
                    We welcome anyone with a passion for tech,
                    regardless of their background or experience level. 
                    Whether you're a beginner looking to start your journey 
                    or a seasoned professional aiming to upskill, you’ll find
                    a supportive community here. 
                </p>
                    <a href="#" class="read-more">Read More</a>
            </div>

        </section>
      </div>


      <div class="heading">
        <h1>Contact Us</h1>
        <p>Stay connected with our message system for real-time updates, 
            discussions, and direct communication with mentors and peers.
             Have a question? Need feedback? Our platform ensures you’re 
             never alone on your learning journey. 
 
        </p>
      </div>


      <div id="contact">
        <div class="container">
            <div class="row">
                <div class="contact-left">
                    <h1 class="sub-title">Join Us Today!</h1>
                    <p>If you’re ready to take your tech skills to the next level, 
                        you’ve come to the right place. Together, we’ll learn, grow, and build the future of tech. 
                        Let’s create success stories together! </p>
                    <p><i class="fa-solid fa-paper-plane"></i> osteenstark48@gmail.com</p>
                    <p><i class="fa-solid fa-phone"></i> +254745394683</p>
                    <div class="social-icons">
                        <a href="https://gmail.com"><i class="fa-solid fa-envelopes-bulk"></i></a>
                        <a href="https://github.com/osteenindumuli"><i class="fa-brands fa-github"></i></a>
                        <a href="https://linkedin.com/in/osteen-joel-indumuli-820b842a2 "><i class="fa-brands fa-linkedin"></i></a>
                    </div>
                    
                </div>
                <div class="contact-right">

                    <form name="submit-to-google-sheet">
                        <input type="text" name="Name" placeholder="Your Name" required>
                        <input type="email" name="Email" placeholder="Your Email" required>
                        <textarea name="Message" rows="6" placeholder="Your Message"></textarea>
                        <button type="submit" class="btn btn2">Submit</button>
                    </form>

                    <span id="msg"></span>


                </div>
            </div>
        </div>

             
      </div>

      
        


       

      



         

       

                
            
         

         




     <!-- Footer -->
     <div class="footer" >
        <div class="container">
            <div class="row">
                <div class="footer-col-1">
                    <h3>Download Our App</h3>
                    <p>Download App for Android and ios mobile phone.</p>
                    <div class="app-logo">
                        <img src="images/google-store.png">
                        <img src="images/app-store.png">
                    </div>
                </div>
                <div class="footer-col-2">
                    <img src="images/Logo-1.png" >
                    <p>Re-inventing the future with a Digital Library </p>
                </div>
                <div class="footer-col-3">
                    <h3>Useful links</h3>
                    <ul>
                        <li>Coupons</li>
                        <li>Blog Post</li>
                        <li>Return Policy</li>
                        <li>Join Affiliate</li>
                    </ul>
                </div>
                <div class="footer-col-4">
                    <h3>Follow us</h3>
                    <ul>
                        <li>Facebook</li>
                        <li>Twitter</li>
                        <li>Instagram</li>
                        <li>LinkedIn</li>
                    </ul>
                </div>

            </div>
            <hr>
            <p class="copyright">&copy; 2023 | Data Privacy and policy | All rights reserved | Designed by Osteen Joel/Fredrick/Dulce</p>
        </div>
    </div>   






   
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="script.js"></script>

    <script>
        const scriptURL = 'https://script.google.com/macros/s/AKfycbw7oPd6GIlLQb5uUkRphnha2oPN3Pdjy1ZKI7kBymDa-QxWD9uavVNyV6wPlwNpSq2O/exec'
        const form = document.forms['submit-to-google-sheet']
        const msg = document.getElementById('msg')
      
        form.addEventListener('submit', e => {
          e.preventDefault()
          fetch(scriptURL, { method: 'POST', body: new FormData(form)})
            .then(response =>  {
                msg.innerHTML = "Message Sent Successfully"
                setTimeout(function(){
                    msg.innerHTML = ""
                },5000) 
                form.reset()
            })
            .catch(error => console.error('Error!', error.message))
        })
      </script>
</body>
</html>