<?php
 include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
     $name = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);

     if (empty($name) || empty($email) || empty($password) || empty($confirm_password) || empty($phone) || empty($address)) {
        echo "<script>alert('Tous les champs sont obligatoires'); window.location.href='signup.php';</script>";
        exit();
    }

     if ($password !== $confirm_password) {
        echo "<script>alert('Les mots de passe ne correspondent pas'); window.location.href='signup.php';</script>";
        exit();
    }

     $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    try {
         $check = $conn->prepare("SELECT Id FROM users WHERE email = ?");
        $check->execute([$email]);

        if ($check->rowCount() > 0) {
            echo "<script>alert('Un utilisateur existe déjà avec cet email'); window.location.href='signup.php';</script>";
        } else {
                   
            $stmt = $conn->prepare("INSERT INTO users (username, email, password, phone, address) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$name, $email, $hashed_password, $phone, $address]);

            echo "<script>alert('Inscription réussie !'); window.location.href='login.php';</script>";
        }
    } catch (PDOException $e) {
       
        echo "<script>alert('Erreur lors de l\'inscription : " . addslashes($e->getMessage()) . "'); window.location.href='signup.php';</script>";
        error_log("Erreur PDO : " . $e->getMessage());
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
                    <ul><li>                    
                    <a href="welcome.php">Home</a></li>
 
							<li class="active"><a href="signup.php">Sign up</a></li>
							<li><a href="login.php">Login</a></li>
							<li><a href="logout.php">logout</a></li>

</ul>

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
                                <h1>Inscrivez-vous <em>Maintenant</em></h1>
                                <h2>Rejoignez notre communauté dès aujourd'hui !</h2>
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
                        <h2>Créez votre compte</h2>
                        <p>Veuillez remplir le formulaire ci-dessous pour créer votre compte.</p>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6 col-md-push-3 col-sm-8 col-sm-push-2">
                        <form method="POST" action="">
                            <div class="row form-group">
                                <div class="col-md-12">
                                    <label for="username">Nom d'utilisateur</label>
                                    <input type="text" class="form-control" name="username" required>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-md-12">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" name="email" required>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-md-12">
                                    <label for="password">Mot de passe</label>
                                    <input type="password" class="form-control" name="password" required>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-md-12">
                                    <label for="confirm_password">Confirmer le mot de passe</label>
                                    <input type="password" class="form-control" name="confirm_password" required>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-md-12">
                                    <label for="phone">Numéro de téléphone</label>
                                    <input type="tel" class="form-control" name="phone" required>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-md-12">
                                    <label for="address">Adresse</label>
                                    <textarea class="form-control" name="address" rows="3" required></textarea>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary btn-outline btn-lg">S'inscrire</button>
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
                        <p>Délicieux FastFood.</p>
                    </div>
                   
                    <div class="col-md-4 col-md-push-1 fh5co-widget">
                        <h4>Informations de contact</h4>
                        <ul class="fh5co-footer-links">
                            <li>198 West 21th Street, <br> Suite 721 New York NY 10016</li>
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