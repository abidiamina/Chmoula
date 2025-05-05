<?php
include 'db.php';  

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (!empty($email) && !empty($password)) {
        try {
             $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['password'])) {
                 session_start();
                $_SESSION['user_id'] = $user['Id'];
                $_SESSION['username'] = $user['username'];

                 echo "<script>alert('Login successful!'); window.location.href='index.php';</script>";
            } else {
                echo "<script>alert('Invalid email or password'); window.location.href='login.php';</script>";
            }
        } catch (PDOException $e) {
             echo "<script>alert('Error: " . addslashes($e->getMessage()) . "'); window.location.href='login.php';</script>";
            error_log("PDO Error: " . $e->getMessage());
        }
    } else {
        echo "<script>alert('All fields are required'); window.location.href='login.php';</script>";
    }
}
?>
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Chmoula &mdash;</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Free HTML5 Website Template by freehtml5.co" />
    <meta name="keywords" content="free website templates, free html5, free template, free bootstrap, free website template, html5, css3, mobile first, responsive" />
    <meta name="author" content="freehtml5.co" />
 
    <meta property="og:title" content=""/>
    <meta property="og:image" content=""/>
    <meta property="og:url" content=""/>
    <meta property="og:site_name" content=""/>
    <meta property="og:description" content=""/>
    <meta name="twitter:title" content="" />
    <meta name="twitter:image" content="" />
    <meta name="twitter:url" content="" />
    <meta name="twitter:card" content="" />

    <link href="https://fonts.googleapis.com/css?family=Cormorant+Garamond:300,300i,400,400i,500,600i,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Satisfy" rel="stylesheet">
    
 
    <link rel="stylesheet" href="css/animate.css">
  
    <link rel="stylesheet" href="css/icomoon.css">
 
    <link rel="stylesheet" href="css/bootstrap.css">
     <link rel="stylesheet" href="css/flexslider.css">
     <link rel="stylesheet" href="css/style.css">
     <script src="js/modernizr-2.6.2.min.js"></script>
  
</head>
<body>
    <div class="fh5co-loader"></div>
    <div id="page">
        <nav class="fh5co-nav" role="navigation">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 text-center logo-wrap">
                        <div id="fh5co-logo"><a href="index.html">Chmoula<span>.</span></a></div>
                    </div>
                    <div class="col-xs-12 text-center menu-1 menu-wrap">
                    <ul><li><a href="welcome.php">Home</a></li>
							<li><a href="signup.php">Sign up</a></li>
							<li class="active"><a href="login.php">Login</a></li>
							<li><a href="logout.php">logout</a></li></ul>

                    </div>
                </div>
            </div>
        </nav>

        <header id="fh5co-header" class="fh5co-cover js-fullheight" role="banner" style="background-image: url(images/fastfood.jpeg);" data-stellar-background-ratio="0.5">
            <div class="overlay"></div>
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <div class="display-t js-fullheight">
                            <div class="display-tc js-fullheight animate-box" data-animate-effect="fadeIn">
                                <h1>Welcome <em>Back</em></h1>
                                <h2>Login to your account</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <div id="fh5co-contact" class="fh5co-section animate-box">
            <div class="container">
                <div class="row animate-box">
                    <div class="col-md-8 col-md-offset-2 text-center fh5co-heading">
                        <h2>Login</h2>
                        <p>Please enter your credentials to access your account.</p>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6 col-md-push-3 col-sm-8 col-sm-push-2">
                        <form method="POST" action="">
                            <div class="row form-group">
                                <div class="col-md-12">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" name="email" required>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-md-12">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" name="password" required>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary btn-outline btn-lg">Login</button>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-md-12 text-center">
                                    <a href="forgot-password.html" class="btn btn-link">Forgot Password?</a>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-md-12 text-center">
                                    <p>Don't have an account? <a href="signup.php" class="btn btn-link">Sign Up</a></p>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <footer id="fh5co-footer" role="contentinfo" class="fh5co-section">
            <div class="container">
                <div class="row row-pb-md">
                    <div class="col-md-4 fh5co-widget">
                        <h4>Chmoula</h4>
                        <p>Tasty FastFood.</p>
                    </div>
                    <div class="col-md-4 col-md-push-1 fh5co-widget">
                        <h4>Contact Information</h4>
                        <ul class="fh5co-footer-links">
                             <li><a href="tel://1234567920">+ 1235 2355 98</a></li>
                            <li><a href="mailto:info@yoursite.com">info@yoursite.com</a></li>
                            <li><a href="http://https://freehtml5.co">freehtml5.co</a></li>
                        </ul>
                    </div>
                </div>
                <div class="row copyright">
                    <div class="col-md-12 text-center">
                        <p>
                            <small class="block">&copy; 2025 OnlineRestaurant</small>
                        </p>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <div class="gototop js-top">
        <a href="#" class="js-gotop"><i class="icon-arrow-up22"></i></a>
    </div>
 
    <script src="js/jquery.min.js"></script>
     
    <script src="js/jquery.easing.1.3.js"></script>
  
    <script src="js/bootstrap.min.js"></script>
 
    <script src="js/jquery.waypoints.min.js"></script>
         <script src="js/jquery.stellar.min.js"></script>
   
    <script src="js/jquery.flexslider-min.js"></script>
 
    <script src="js/main.js"></script>
</body>
</html>