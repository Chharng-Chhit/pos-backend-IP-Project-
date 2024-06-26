<!DOCTYPE html>
<html lang="zxx">
<head>
	<title>TP-09</title>
	<meta charset="UTF-8">
	<meta name="description" content="Boto Photo Studio HTML Template">
	<meta name="keywords" content="photo, html">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- Stylesheets -->
	<link rel="stylesheet" href="{{url('css/bootstrap.min.css')}}"/>
	<link rel="stylesheet" href="{{url('css/font-awesome.min.css')}}"/>
	<link rel="stylesheet" href="{{url('css/slicknav.min.css')}}"/>
	<link rel="stylesheet" href="{{url('css/fresco.css')}}"/>

	<!-- Main Stylesheets -->
	<link rel="stylesheet" href="{{url('css/style.css')}}"/>


	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->

</head>
<body>
	<!-- Page Preloder -->
	<div id="preloder">
		<div class="loader"></div>
	</div>

	<!-- Header Section -->
	<header class="header" >
		<div class="container-fluid">
			<div class="row">
				<div class="order-2 col-sm-4 col-md-3 order-sm-1">
					<div class="header__social">
						<a href="#"><i class="fa fa-facebook"></i></a>
						<a href="#"><i class="fa fa-twitter"></i></a>
						<a href="#"><i class="fa fa-instagram"></i></a>
					</div>
				</div>
				<div class="order-1 text-center col-sm-4 col-md-6 order-md-2">
					<a href="./index.html" class="site-logo">
						<img src="{{asset('img/logo.png')}}" alt="">
					</a>
				</div>
				<div class="order-3 col-sm-4 col-md-3 order-sm-3">
					<div class="header__switches">
						<a href="#" class="search-switch"><i class="fa fa-search"></i></a>
						<a href="#" class="nav-switch"><i class="fa fa-bars"></i></a>
						<a href="#"><i class="fa fa-shopping-cart"></i></a>
                        <a href="/upload"><i class="fa fa-plus" aria-hidden="true"></i></a>
					</div>
				</div>
			</div>
			<nav class="main__menu">
				<ul class="nav__menu">
					<li><a href="./index.html">Home</a></li>
					<li><a href="./about.html">About</a></li>
					<li><a href="/gallery">Gallery</a></li>
					<li><a href="./blog.html">Blog</a>
						<ul class="sub__menu">
							<li><a href="./blog-single.html">Blog Single</a></li>
						</ul>
					</li>
					<li><a href="./contact.html">Contact</a></li>
				</ul>
			</nav>
		</div>
	</header>
	<!-- Header Section end -->

    <div class="p-5 container-fluid d-flex justify-content-center">
        <form action="/store" method="POST" enctype="multipart/form-data" class="form">
            @csrf
            <input type="file" name="image" id="upload" ><br>
            {{-- <label>Input Filename: </label>
            <input type='text' name="filename" id="filename"><br> --}}
            <button type="submit" class="btn btn-success">Submit</button>

        </form>
    </div>


	<!-- Footer Section -->
	<footer class="footer__section" style="margin-top: 40vh ">
		<div class="container">
			<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
			<div class="footer__copyright__text">
				<p>Copyright &copy; <script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="fa fa-heart" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a></p>
			</div>
			<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
		</div>
	</footer>
	<!-- Footer Section end -->

	<!-- Search Begin -->
	<div class="search-model">
		<div class="h-100 d-flex align-items-center justify-content-center">
			<div class="search-close-switch">+</div>
			<form class="search-model-form">
				<input type="text" id="search-input" placeholder="Search here.....">
			</form>
		</div>
	</div>
	<!-- Search End -->

	<!--====== Javascripts & Jquery ======-->
	<script src="js/vendor/jquery-3.2.1.min.js"></script>
	<script src="js/jquery.slicknav.min.js"></script>
	<script src="js/slick.min.js"></script>
	<script src="js/fresco.min.js"></script>
	<script src="js/main.js"></script>

	</body>
</html>
