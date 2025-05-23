<?php
// dustbinqw.php
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
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <title>Bin Buddy - Admin Panel</title>
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
            <a class="navbar-brand" href="index.html">
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
                        <a class="nav-link custom-btn custom-border-btn btn" href="XXXXXXXXXX"><b>Volunteer's Application </b></a>
                    </li>
                    <li class="nav-item ms-3">
                        <a class="nav-link custom-btn custom-border-btn btn" href="XXXXXXXXXXXXXXX"><b>Dustbin's Status</b></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container my-5">
        <h2 class="text-center">Register New Dustbin</h2>
        <div class="text-center my-4">
            <video id="video" width="320" height="240" autoplay class="border"></video><br><br>
            <button class="btn btn-primary" id="captureBtn">Capture & Register</button>
        </div>
        <div id="qrSection" class="text-center my-4" style="display:none;">
            <h4>Dustbin QR Code:</h4>
            <canvas id="qrCode"></canvas><br><br>
            <a href="viewdustbin.php" class="btn btn-success">View All Dustbins</a>
        </div>
    </div>
 <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrious/4.0.2/qrious.min.js"></script>

    <script>
        let stream;

        $(document).ready(function() {
            startCamera();

            $("#captureBtn").click(async function() {
                await captureAndRegister();
            });
        });

        function startCamera() {
            navigator.mediaDevices.getUserMedia({ video: { facingMode: "environment" } })
                .then(s => {
                    stream = s;
                    const video = document.getElementById('video');
                    video.srcObject = stream;
                    video.play();
                })
                .catch(err => alert('Camera error: ' + err));
        }

        async function captureAndRegister() {
            const video = document.getElementById('video');
            const canvas = document.createElement('canvas');
            canvas.width = 320;
            canvas.height = 240;
            canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
            const imageDataUrl = canvas.toDataURL('image/png');

            navigator.geolocation.getCurrentPosition(position => {
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;

                const id = Date.now();

                $.post('/Bin-Buddy/Backend/api.php?action=add', {
                    id: id,
                    image: imageDataUrl,
                    location: `https://maps.google.com/?q=${lat},${lng}`
                }, function(response) {
                    // After successful register, generate QR
                    generateQR(`Dustbin ID: ${id}\nLocation: https://maps.google.com/?q=${lat},${lng}`);
                }).fail(function(xhr) {
    alert('Failed to register dustbin: ' + xhr.status + ' - ' + xhr.responseText);
});


            }, err => {
                alert('Location error: ' + err.message);
            });
        }

        function generateQR(text) {
            $('#qrSection').show();
            var qr = new QRious({
                element: document.getElementById('qrCode'),
                value: text,
                size: 250
            });
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

