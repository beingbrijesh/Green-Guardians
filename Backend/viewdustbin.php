<?php
// viewdustbin.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="/Bin-Buddy/images/logo.webp" sizes="16x16" type="image/x-icon">
  <link rel="icon" href="/Bin-Buddy/favicon-32x32.png" sizes="32x32" type="image/png">
  <link rel="icon" href="/Bin-Buddy/favicon-48x48.png" sizes="48x48" type="image/png">
  <link rel="icon" href="/Bin-Buddy/favicon-96x96.png" sizes="96x96" type="image/png">
  
  <!-- CSS FILES -->
  <link href="/Bin-Buddy/css/bootstrap.min.css" rel="stylesheet">
  <link href="/Bin-Buddy/css/bootstrap-icons.css" rel="stylesheet">
  <link href="/Bin-Buddy/css/binbuddy.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
  
  <title>View Registered Dustbins</title>
</head>
<body>
    <!-- Header -->
    <header class="site-header">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-12 d-flex flex-wrap">
                    <p class="d-flex me-4 mb-0">
                        <i class="bi-geo-alt me-2"></i>
                        Ghaziabad, Uttar Pradesh, India
                    </p>
                    <p class="d-flex mb-0">
                        <i class="bi-envelope me-2"></i>
                        <a href="mailto:info@company.com">info@binbuddy.org</a>
                    </p>
                </div>
                <div class="col-lg-3 col-12 ms-auto d-lg-block d-none">
                    <ul class="social-icon">
                        <li class="social-icon-item"><a href="https://twitter.com/" class="social-icon-link bi-twitter"></a></li>
                        <li class="social-icon-item"><a href="https://facebook.com/" class="social-icon-link bi-facebook"></a></li>
                        <li class="social-icon-item"><a href="https://instagram.com/" class="social-icon-link bi-instagram"></a></li>
                        <li class="social-icon-item"><a href="https://youtube.com/" class="social-icon-link bi-youtube"></a></li>
                        <li class="social-icon-item"><a href="https://web.whatsapp.com/" class="social-icon-link bi-whatsapp"></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </header>
  
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg bg-light shadow-lg">
        <div class="container">
            <a class="navbar-brand" href="/Bin-Buddy/index.html">
                <img src="/Bin-Buddy/images/logo.webp" class="logo img-fluid" alt="">
                <span>
                    Bin Buddy
                    <small>Building a Green Future</small>
                </span>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item ms-3">
                        <a class="nav-link custom-btn custom-border-btn btn" href="#"><b>Volunteer's Application</b></a>
                    </li>
                    <li class="nav-item ms-3">
                        <a class="nav-link custom-btn custom-border-btn btn" href="/Bin-Buddy/finished-tasks.html"><b>Dustbin's Data</b></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container my-5">
        <h2 class="text-center">Registered Dustbins</h2>
        <div id="dustbinList" class="row my-4"></div>

        <div class="text-center">
            <a href="/Bin-Buddy/Backend/dustbinqw.php" class="btn btn-primary">Register New Dustbin</a>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            loadDustbins();
        });

        function loadDustbins() {
            $.get('api.php?action=list_dustbins', function(dustbins) {
    const container = $("#dustbinList").empty();
    dustbins.forEach(d => {
        container.append(`
            <div class="col-md-4">
                <div class="card p-3 mb-4 shadow-sm">
                    <img src="${d.image}" class="card-img-top" style="height:200px; object-fit:cover;">
                    <div class="card-body text-center">
                        <h5 class="card-title">Dustbin ID: ${d.id}</h5>
                        <p><a href="${d.location}" target="_blank">View Location</a></p>
                        <button class="btn btn-danger btn-sm mt-2" onclick="deleteDustbin('${d.id}')">Delete</button>
                    </div>
                </div>
            </div>
        `);
    });
}).fail(function(err) {
    console.error("Failed to fetch dustbins:", err.responseText);
});

        }

        function deleteDustbin(id) {
            if(confirm("Are you sure you want to delete this dustbin?")) {
                $.post('api.php?action=delete', { id: id }, function(response) {
                    alert('Dustbin deleted successfully!');
                    loadDustbins(); // Refresh the list
                }).fail(function(xhr) {
                    alert('Failed to delete dustbin.');
                });
            }
        }
    </script>

    <!-- Footer -->
    <footer class="site-footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-12 mb-4">
                    <img src="/Bin-Buddy/images/logo.webp" class="logo img-fluid" alt="">
                </div>

                <div class="col-lg-4 col-md-6 col-12 mb-4">
                    <h5 class="site-footer-title mb-3">Quick Links</h5>
                    <ul class="footer-menu">
                        <li class="footer-menu-item"><a href="/Bin-Buddy/index.html#section_2" class="footer-menu-link">Our Story</a></li>
                        <li class="footer-menu-item"><a href="/Bin-Buddy/index.html#section_5" class="footer-menu-link">Newsroom</a></li>
                        <li class="footer-menu-item"><a href="/Bin-Buddy/index.html#section_3" class="footer-menu-link">Works</a></li>
                        <li class="footer-menu-item"><a href="/Bin-Buddy/index.html#section_4" class="footer-menu-link">Become a volunteer</a></li>
                        <li class="footer-menu-item"><a href="#" class="footer-menu-link">Partner with us</a></li>
                    </ul>
                </div>

                <div class="col-lg-4 col-md-6 col-12 mx-auto">
                    <h5 class="site-footer-title mb-3">Contact Information</h5>
                    <p class="text-white d-flex mb-2"><i class="bi-telephone me-2"></i><a href="tel:180000XXXX" class="site-footer-link">1800-00-XXXX-XXXX</a></p>
                    <p class="text-white d-flex"><i class="bi-envelope me-2"></i><a href="mailto:donate@binbuddy.org" class="site-footer-link">donate@binbuddy.org</a></p>
                    <p class="text-white d-flex mt-3"><i class="bi-geo-alt me-2"></i>Ghaziabad, Uttar Pradesh, India</p>
                    <a href="https://www.google.com/maps/place/ABESIT+GROUP+OF+INSTITUTIONS/" class="custom-btn btn mt-3">Get Direction</a>
                </div>
            </div>
        </div>
        <div class="site-footer-bottom">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-7 col-12">
                        <p class="copyright-text mb-0">Copyright © 2025 
                            <a href="#">Bin Buddy</a> Org. Design: 
                            <a href="/Bin-Buddy/index.html" target="_blank">Bin Buddy</a>
                        </p>
                    </div>
                    <div class="col-lg-6 col-md-5 col-12 d-flex justify-content-center align-items-center mx-auto">
                        <ul class="social-icon">
                            <li class="social-icon-item"><a href="https://twitter.com/" class="social-icon-link bi-twitter"></a></li>
                            <li class="social-icon-item"><a href="https://facebook.com/" class="social-icon-link bi-facebook"></a></li>
                            <li class="social-icon-item"><a href="https://instagram.com/" class="social-icon-link bi-instagram"></a></li>
                            <li class="social-icon-item"><a href="https://linkedin.com/" class="social-icon-link bi-linkedin"></a></li>
                            <li class="social-icon-item"><a href="https://youtube.com/" class="social-icon-link bi-youtube"></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- JS FILES -->
    <script src="/Bin-Buddy/js/jquery.min.js"></script>
    <script src="/Bin-Buddy/js/bootstrap.min.js"></script>
    <script src="/Bin-Buddy/js/jquery.sticky.js"></script>
    <script src="/Bin-Buddy/js/counter.js"></script>
    <script src="/Bin-Buddy/js/custom.js"></script>
</body>
</html>

