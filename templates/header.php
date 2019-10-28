<?php 
session_start();
if(!isset($_SESSION['user_id'])){
    header("Location: /");
}

$user = DBModel::read("SELECT DISTINCT u.* FROM users u WHERE u.id = ".$_SESSION['user_id'], PDO::FETCH_CLASS,'Users');

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>ITI Cafetria</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="../styles/main.css">
    <link rel="stylesheet" type="text/css" media="screen" href="../styles/bootstrap.css">
    <link rel="stylesheet" type="text/css" media="screen" href="../styles/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" media="screen" href="../styles/custom.sass">
    <link rel="stylesheet" type="text/css" media="screen" href="../styles/_variables.scss">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>


</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">ITI Cafetria</a>


        <div class="collapse navbar-collapse" id="navbarNav">
            <div>
                <ul class="navbar-nav">
                    <li class="nav-item active">
                        <a class="nav-link" href="AdminHome.php">Home <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="products.php">Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="users.php">Users</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="manual.php">Manual Order</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="checks.php">Checks</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="user-profile" style="float: right">
            <ul class="nav navbar-nav navbar-right profile-pic">
                <li>
                    <div class="inset">
                        <img src="<?php if($user->picture) echo $user->picture; else echo "http://rs775.pbsrc.com/albums/yy35/PhoenyxStar/link-1.jpg~c200"; ?>">
                    </div>
                </li>
            </ul>

            <div class="pull-right " style="padding-left: 2%">
                <ul class="nav pull-right user-name">
                    <li class="dropdown navbar-text"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Welcome, <?php echo $user->name; ?> <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                        <a href="logout.php" style="color:#000;text-decoration:none"><li>Logout</li></a>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">

            <span class="navbar-toggler-icon"></span>
        </button>
    </nav>
    <!-- </body>

</html>   --> 