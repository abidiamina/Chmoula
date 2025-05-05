<?php
session_start();
include 'db.php';

// Recherche & filtre
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$category = isset($_GET['category']) ? trim($_GET['category']) : '';

// Ajout ou mise à jour
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $ingredients = trim($_POST['ingredients']);
    $instructions = trim($_POST['instructions']);
    $cat = trim($_POST['category']);
    $recipe_id = isset($_POST['recipe_id']) && is_numeric($_POST['recipe_id']) && $_POST['recipe_id'] > 0 ? (int)$_POST['recipe_id'] : null;

    if ($recipe_id !== null) {
        $stmt = $conn->prepare("UPDATE recipes SET title = ?, ingredients = ?, instructions = ?, category = ? WHERE id = ?");
        $stmt->execute([$title, $ingredients, $instructions, $cat, $recipe_id]);
    } else {
        $stmt = $conn->prepare("INSERT INTO recipes (title, ingredients, instructions, category, user_id) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$title, $ingredients, $instructions, $cat, $_SESSION['user_id']]);
    }

    header("Location: index.php");
    exit();
}

// Suppression
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM recipes WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: index.php");
    exit();
}

// Récupération filtrée
$sql = "SELECT * FROM recipes WHERE 1";
$params = [];

if (!empty($search)) {
    $sql .= " AND title LIKE ?";
    $params[] = "%$search%";
}
if (!empty($category)) {
    $sql .= " AND category = ?";
    $params[] = $category;
}

$sql .= " ORDER BY created_at DESC";
$stmt = $conn->prepare($sql);
$stmt->execute($params);
$recipes = $stmt->fetchAll(PDO::FETCH_ASSOC);

$categories = ["Salée", "Sucrée", "Tunisienne", "Italienne", "Asiatique", "Internationale"];
?>

<!DOCTYPE html>
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
     <style>
        body, td, th, label, input, textarea, h1, h2, h3, h4, h5, h6, p {
            color: white !important;
        }

        .form-control {
            background-color: transparent;
            color: white !important;
            border: 1px solid white;
        }

        .form-control::placeholder {
            color: #ccc;
        }
        select.form-control, 
select.form-control option {
    background-color: #222 !important;
    color: white !important;
}
        .table {
            color: white;
        }

        .btn {
            color: white !important;
        }

        .btn-warning, .btn-danger, .btn-success {
            color: #fff !important;
        }
    </style>
  
</head>
<body>
    <div class="fh5co-loader"></div>
    <div id="page">
        <nav class="fh5co-nav" role="navigation">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 text-center logo-wrap">
                        <div id="fh5co-logo"><a href="welcome.html">Chmoula<span>.</span></a></div>
                    </div>
                    <div class="col-xs-12 text-center menu-1 menu-wrap">
                    <ul><li><a href="welcome.php">Home</a></li>
							<li><a href="signup.php">Sign up</a></li>
							<li><a href="login.php">Login</a></li>
							<li><a href="logout.php">logout</a></li></ul>

                    </div>
                </div>
            </div>
        </nav>

        <header >
        </header>

    <div id="fh5co-contact" class="fh5co-section animate-box">
        <div class="container">
            <div class="row mb-4">
                <div class="col-md-8 col-md-offset-2 text-center fh5co-heading">
                    <h2>Ajouter / Modifier une Recette</h2>
                </div>
            </div>

          
            <!-- Barre de recherche et filtre -->
<form method="GET" action="index.php" class="row text-center mb-4">
    <div class="col-md-5">
        <input type="text" name="search" class="form-control" placeholder="Rechercher une recette..." value="<?= htmlspecialchars($search) ?>">
    </div>
    <div class="col-md-4">
        <select name="category" class="form-control">
            <option value="">Toutes les catégories</option>
            <?php foreach ($categories as $cat): ?>
                <option value="<?= htmlspecialchars($cat) ?>" <?= $category === $cat ? 'selected' : '' ?>>
                    <?= htmlspecialchars($cat) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="col-md-3">
        <button type="submit" class="btn btn-success btn-block">🔍 Filtrer</button>
    </div>
</form>


            <!-- Formulaire recette -->
          
<form method="POST" action="index.php">
    <input type="hidden" name="recipe_id" id="recipe_id">
    <div class="row form-group">
        <div class="col-md-12">
            <label>Titre</label>
            <input type="text" name="title" id="title" class="form-control" required>
        </div>
        <div class="col-md-12">
            <label>Ingrédients</label>
            <textarea name="ingredients" id="ingredients" class="form-control" required></textarea>
        </div>
        <div class="col-md-12">
            <label>Instructions</label>
            <textarea name="instructions" id="instructions" class="form-control" required></textarea>
        </div>
        <div class="col-md-12">
            <label>Catégorie</label>
            <select name="category" id="category" class="form-control" required>
                <option value="">Sélectionner une catégorie</option>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?= htmlspecialchars($cat) ?>"><?= htmlspecialchars($cat) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-12 text-center">
            <input type="submit" value="Enregistrer la recette" class="btn btn-success mt-3">
        </div>
    </div>
</form>


            <hr>

            <div class="row">
                <div class="col-md-12">
                    <h3>Liste des Recettes</h3>
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Titre</th>
                            <th>Ingrédients</th>
                            <th>Instructions</th>
                            <th>Catégorie</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($recipes as $r): ?>
                            <tr>
                                <td><?= htmlspecialchars($r['title']) ?></td>
                                <td><?= nl2br(htmlspecialchars($r['ingredients'])) ?></td>
                                <td><?= nl2br(htmlspecialchars($r['instructions'])) ?></td>
                                <td><?= htmlspecialchars($r['category']) ?></td>
                                <td><?= date('d/m/Y H:i', strtotime($r['created_at'])) ?></td>
                                <td>
                                    <a href="#" onclick="editRecipe(<?= $r['id'] ?>, '<?= addslashes($r['title']) ?>', `<?= addslashes($r['ingredients']) ?>`, `<?= addslashes($r['instructions']) ?>`, '<?= addslashes($r['category']) ?>')" class="btn btn-sm btn-warning">Modifier</a>
                                    <a href="?delete=<?= $r['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Supprimer cette recette ?')">Supprimer</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <footer id="fh5co-footer" role="contentinfo" class="fh5co-section">
        <div class="container text-center">
            <p>&copy; 2025 Chmoula - Tous droits réservés 🍽️</p>
        </div>
    </footer>
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

