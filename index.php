

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Hospital Management System</title>
  <link rel="icon" type="image/x-icon" href="/assets/icon.webp">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link rel="stylesheet" href="\css\style1.css" type="text/css">
</head>

<body>
  <header>
    <div id="head" class="head">
      <a href="#intro">
        <div class="logos">
          <img src="\assets\icon.webp" alt="logo">
          <ol>
            <li>MANOJ</li>
            <li>NISHAN</li>
            <li>MANDIP</li>
            <li>NARAYAN</li>
          </ol>
        </div>
      </a>


      <nav class="nav-bar">
        <a href="#intro">Home</a>
        <a href="#service">Services</a>
        <a href="#faq">FAQ</a>
        <a href="#About">About us</a>
      </nav>

      <div class="left">
        <div class="auto">
          <a href="/authorization/login.php">
            <button><i class="fas fa-sign-in-alt"></i> Login</button>
          </a>
          <a href="/authorization/register.php">
            <button><i class="fas fa-user-plus"></i> Register</button>
          </a>
        </div>

        <div id="search">
          <form id="form-search">
            <input type="text" placeholder="Search doctors, clinics, hospitals" id="search-input" name="query" required>
            <button type="submit" id="search-button">
              <img src="\assets\search.png" alt="search">
            </button>
          </form>
        </div>
      </div>
    </div>
  </header>



  <section id="intro">
    <div>
      <h2>WELCOME TO MNMN WEBSITE</h2>
    </div>
    <div class="intro-state">
      <p>A platform designed to streamline patient management,
        appointments, medical records, and hospital operations.
        This system ensures efficient healthcare service delivery
        through an intuitive and user-friendly interface.
      </p>
    </div>
    <div class="intro-img">
      <img src="/assets/intro.webp" alt="intro-image">
    </div>
  </section>
  <section id="service">
    <div class="service-head">
      <h3>
        OUR SERVICES
      </h3>
    </div>
    <div class="servuice-box">
      <div class="row">
        <div class="box">
          <img src="\assets\bed management system.jpg" alt="bed management">
          <h4>Bed Management</h4>
          <p>Keeping track of hospital beds and efficient allocation.</p>
        </div>
        <div class="box">
          <img src="\assets/billing and pay pic.png" alt="bilimg">
          <h4>Billing and Payments</h4>
          <p>Easy hospital care billing and payment processes.</p>
        </div>
        <div class="box">
          <img src="\assets/lab and test pic.jpg" alt="lab test">
          <h4>Lab and Test</h4>
          <p>Manage laboratory tests and examination results.</p>
        </div>
      </div>
      <div class="row">
        <div class="box">
          <img src="\assets/patient records.jpg" alt="patient record">
          <h4>Patient Records</h4>
          <p>Secure electronic storing of patient medical records.</p>
        </div>
        <div class="box">
          <img src="\assets/patient registration.jpg" alt="patient registeration">
          <h4>Patient Registration</h4>
          <p>Basic patient registration with medical and personal data.</p>
        </div>
      </div>
    </div>
  </section>


  <section id="faq">
    <div class="faq-img">
      <img src="assets/f&q.jpg" alt="faq">
    </div>
    <div class="faq-main">
      <h3>Questions</h3>
      <div class="q">
        <div id="q1">
          <h4>What should I do if I have a persistent cough for more than a week?</h4>
          <button id="bt1">Show</button>
        </div>
        <div id="a1">
          <p>If you have a persistent cough lasting more than a week, stay hydrated, get plenty of rest, 
            and avoid smoke or allergens. Remedies like honey, lozenges, and steam inhalation may help. 
            However, if the cough worsens, is severe, or comes with blood, fever, or breathing difficulties, 
            seek medical attention immediately.</p>
        </div>
      </div>

      <div class="q">
        <div id="q2">
          <h4>Can I take painkillers on an empty stomach?</h4>
          <button id="bt2">Show</button>
        </div>
        <div id="a2">
          <p>Some painkillers, like Paracetamol, are safe on an empty stomach. However, NSAIDs (Ibuprofen, Aspirin, etc.) 
            can irritate the stomach and should be taken with food. Always follow the instructions and consult a doctor if unsure.</p>
        </div>
      </div>

      <div class="q">
        <div id="q3">
          <h4>When should I visit the emergency department?</h4>
          <button id="bt3">Show</button>
        </div>
        <div id="a3">
          <p>Visit the emergency department if you have severe chest pain, difficulty breathing,
             sudden weakness, heavy bleeding, loss of consciousness, seizures, or a serious injury. 
             If in doubt, seek medical help immediately.</p>
        </div>
      </div>

      <div class="q">
        <div id="q4">
          <h4>How do I know if I need a blood test?</h4>
          <button id="bt4">Show</button>
        </div>
        <div id="a4">
          <p>You may need a blood test if you experience unexplained fatigue, frequent infections, 
            unusual bruising, persistent fever, drastic weight changes, or symptoms of a medical
             condition like diabetes or anemia. Consult a doctor for proper evaluation.</p>
        </div>
      </div>

      <div class="q">
        <div id="q5">
          <h4>What should I bring to my first appointment?</h4>
          <button id="bt5">Show</button>
        </div>
        <div id="a5">
          <p>For your first appointment, bring a valid ID, insurance details, medical history, current medications, test results 
            (if any), and a list of symptoms or concerns. Arriving early can also help with paperwork.</p>
        </div>
      </div>
    </div>


    <button id="Chat-toggle">
      <img src="assets/contact.png">
    </button>

    <div class="faq-email">
      <form id="contact" action="Action/send.php" method="post">
        <h1>Email Us</h1>

        <label for="name">Name</label><br>
        <input id="name" placeholder="Your name" name="name" type="text"><br>

        <label for="email">Email</label><br>
        <input id="email" placeholder="Your Email Address" name="email" type="email"><br>

        <label for="sub">Subject</label><br>
        <input id="sub" placeholder="Type your subject line" type="text" name="subject"><br>

        <label for="message">Message</label><br>
        <textarea id="message" name="message" placeholder="Type your Message Details Here..."></textarea><br><br>

        <button type="submit" name="send" id="contact-submit">Submit Now</button>
      </form>
      <h4></h4>
    </div>

  </section>


  <section id="map">
    <!-- Map section outside .about-main -->
    <div class="map">
      <iframe
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d387190.2799234265!2d85.2714767!3d27.7181032!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39eb196771667b4b%3A0x8d4950a1cdb6ccad!2sAmrit%20Science%20Campus%2C%20Kathmandu%2C%20Nepal!5e0!3m2!1sen!2sus!4v1671582968257!5m2!1sen!2sus"
        width="100%"
        height="400"
        style="border:0;"
        allowfullscreen=""
        loading="lazy">
      </iframe>
    </div>
  </section>


  <!-- About Section -->
  <section id="About">
    <div class="about-main">
      <div class="about-intro">
        <h1>About Us</h1>
        <p>Welcome to MNMN, an innovative hospital management system that streamlines healthcare operations and enhances patient care. Our system offers an end-to-end solution for healthcare practitioners to manage patient information, schedules, medical reports, billing, and so forth in a unified platform.</p>
        <p>We, at MNMN, are enthusiastic professionals who are technology users, innovators, and healthcare practitioners who wish to revolutionize the healthcare process. We endeavor to bring efficiency, accessibility, and accuracy to the healthcare industry so that patients can get the best care and medical professionals can focus on what matters the most—saving lives.</p>
        <p>We're dedicated to leveraging technology to simplify hospital management, facilitating easier delivery of high-quality, patient-centered care. We're revolutionizing the future of healthcare, one innovation at a time, together.</p>

        <h2>Contact Info</h2>
        <p><i class="fas fa-phone"></i> Phone: 9812183988</p>
        <p><i class="fas fa-envelope"></i> Email: MNMN9811@gmail.com</p>
        <p><i class="fas fa-map-marker-alt"></i> Address: Lainchaur, Thamel, Kathmandu</p>
      </div>

      <div class="about-members">
        <div class="team-member">
          <img src="assets\nishan.jpg" alt="Nishan Rai">
          <h4>Nishan Rai</h4>
          <p>nishanrai125@gmail.com</p>
        </div>
        <div class="team-member">
          <img src="assets\profiles_pic\manoj.jpg" alt="Manoj Kc">
          <h4>Manoj Kc</h4>
          <p>mkc58558@gmail.com</p>
        </div>
        <div class="team-member">
          <img src="assets/mandip.jpg" alt="Mandip Poudel">
          <h4>Mandip Poudel</h4>
          <p>mandippaudel11@gmail.com</p>
        </div>
        <div class="team-member">
          <img src="assets/narayan.jpg" alt="Narayan poudel">
          <h4>Narayan Poudel</h4>
          <p>narayanpoudel233@gmail.com</p>
        </div>
      </div>
    </div>
  </section>

  <footer>
    <div class="footer-first">
      <div class="contact-logo">
        <div class="footer-img">
          <img src="assets/icon.webp" alt="logo">
        </div>
        <div class="footor-contact">
          <h2>Contact US</h2>
          <p><i class="fas fa-envelope"></i> Email: MNMN9811@gmail.com</p>
          <div class="social-icons">
            <h5>Visit Us At</h5>
            <a href="https://www.facebook.com/nishan.raai122" target="_blank">
              <i class="fab fa-facebook"></i>
            </a>
            <a href="https://www.twitter.com" target="_blank">
              <i class="fab fa-twitter"></i>
            </a>
            <a href="https://wa.me/yourphonenumber" target="_blank">
              <i class="fab fa-whatsapp"></i>
            </a>
            <a href="https://www.linkedin.com" target="_blank">
              <i class="fab fa-linkedin"></i>
            </a>
            <a href="https://github.com" target="_blank">
              <i class="fab fa-github"></i>
            </a>
          </div>
        </div>
      </div>
      <div class="footer-login">
        <h2>Quick Login</h2>
        <div class="footer-login-main">
          <a href="authorization/login.php?role=Patient">
            <p>Patient Login</p>
          </a>
          <a href="authorization/login.php?role=Doctor">
            <p>Doctor Login</p>
          </a>
          <a href="authorization/login.php?role=Receptionist">
            <p>Receptionist Login</p>
          </a>
          <a href="authorization/login.php?role=Admin">
            <p>Admin Login</p>
          </a>
        </div>
      </div>

      <div class="term">
        <a href="#About">
          <h4>About US</h4>
        </a>
        <a href="footer-pages/privacyplicy.html">
          <h4>Privacy Policy</h4>
        </a>
        <a href="footer-pages/term.html">
          <h4>Term and Condition</h4>
        </a>
        <a href="footer-pages/adversite.html">
          <h4>Adverstisement Policy</h4>
        </a>
        <a href="footer-pages/doc.html">
          <h4>Doctor details</h4>
        </a>
      </div>
    </div>
    <hr>
    <div class="footer-last">
      <p>© 2025 MNMN | All Rights Reserved</p>
      <p>MNMN does not offer medical advice, diagnosis or treatment.</p>
      <p>The materials provided on our website, including services, content and products, are solely intended to provide informational purposes.</p>
    </div>

  </footer>


  <script>
$(document).ready(function() {
  // Hide all answers initially
  $('[id^=a]').hide();

  // Function to toggle FAQ answers
  function toggleAnswer(btn) {
    const btnId = btn.attr('id'); // e.g., "bt3"
    const index = btnId.replace('bt', ''); // Extract the number
    const answer = $(`#a${index}`);
    const isAnswerVisible = answer.is(':visible');

    // Hide all answers and reset buttons
    $('[id^=a]').slideUp();
    $('.faq-main button').text('Show');

    // Show or hide the clicked answer
    if (!isAnswerVisible) {
      answer.slideDown();
      btn.text('Hide');
    }
  }

  // Bind both click and touchstart events to FAQ buttons
  $('.faq-main button').on('click touchstart', function(e) {
    e.preventDefault(); // Prevent default behavior on touch devices
    toggleAnswer($(this));
  });

  // Chat toggle functionality
  $("#faq .faq-email").hide(); // Hide initially
  $("#Chat-toggle").on('click touchstart', function(e) {
    e.preventDefault();
    $("#faq .faq-email").toggle();
  });

  // Form submission handler
  $("#contact").on("submit", function(e) {
    e.preventDefault();
    const formData = new FormData(this);

    $.ajax({
      url: $(this).attr("action"),
      type: "POST",
      data: formData,
      processData: false,
      contentType: false,
      success: function(response) {
        const msgBox = $(".faq-email h4");
        if (response.trim() === "success") {
          msgBox.css("color", "var(--success-color)").text("✅ Message sent successfully!");
          $("#contact")[0].reset();
        } else if (response.trim() === "error") {
          msgBox.css("color", "red").text("❌ Message could not be sent. Please try again.");
        } else {
          msgBox.css("color", "var(--warning-color)").text("⚠️ Invalid request.");
        }
      },
      error: function() {
        $(".faq-email h4").css("color", "red").text("❌ Something went wrong. Try again later.");
      }
    });
  });
});
</script>



</body>

</html>