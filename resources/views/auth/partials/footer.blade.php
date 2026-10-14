<!-- Footer Start -->
<footer class="footer footer-default sec-padding bg-secondary pb-0">
    <div class="container">
        <div class="footer-top d-sm-flex align-items-center justify-content-between">
            <h3 class="h6 mb-0 text-white d-none d-lg-block">Latest updates from {{ env('APP_NAME') }}</h3>
            <div class="subs-form">
                <form action="#">
                    <input type="email" placeholder="Email Address">
                    <button class="icon-lg rounded-3"><i class="fa fa-paper-plane"></i></button>
                </form>
            </div>
        </div>
        <div class="row footer-wrap">
            <div class="col-lg-6 col-md-6">
                <div class="footer-widget footer-about">
                    <div class="f-logo mb-4">
                        <a href="index-2.html"><img src="assets/images/logo-w.svg" alt="Logo"></a>
                    </div>

                    <p>Join our community! Get exclusive news, and tips delivered to your inbox.</p>
                </div>
            </div>
            <div class="col-lg-6 col-md-12">
                <div class="footer-widget quick-links">
                    <h3 class="widget-title">Quick Links</h3>
                    <ul>
                        <li><a href="{{ route('profiles.index') }}">Researchers</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="container">
            <div class="d-flex flex-wrap justify-content-between align-items-center">
                <p class="copy-right mb-0 order-2 order-md-1">
                    Copyright &copy;@php echo date('Y') @endphp <a href="#">{{ env('APP_NAME') }}</a> All Rights Reserved.</p>
                <nav class="footer-nav order-1 order-md-2">
                </nav>
            </div>
        </div>
    </div>
</footer>
<!-- Footer End -->

<!-- Scroll Top -->
<div class="scroll-top">
    <svg class="progress-circle svg-content" height="100%" viewBox="-1 -1 102 102" width="100%">
        <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" fill="none" stroke="black" stroke-width="2">
        </path>
    </svg>
</div>

<!--Javascript
========================================================-->
<script src="assets/js/jquery-3.7.1.min.js"></script>
<script src="assets/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/swiper-bundle.min.js"></script>
<script src="assets/js/lenis.min.js"></script>
<script src="assets/js/jarallax.min.js"></script>
<script src="assets/js/gsap.min.js"></script>
<script src="assets/js/ScrollTrigger.min.js"></script>
<script src="assets/js/SplitText.js"></script>
<script src="assets/js/fancybox.umd.js"></script>
<script src="assets/js/isotope.pkgd.min.js"></script>
<script src="assets/js/jquery.nice-select.min.js"></script>
<script src="assets/js/wow.min.js"></script>
<script src="assets/js/form.js"></script>
<script src="assets/js/tv-cursor.js"></script>
<script src="assets/js/jquery.waypoints.min.js"></script>
<script src="assets/js/jquery.counterup.min.js"></script>
<script src="assets/js/custom.js"></script>

</body>
</html>

