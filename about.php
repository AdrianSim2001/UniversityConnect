<!DOCTYPE html>

<html lang="en">
<!-- Description: Assignment 2 -->
<!-- Author: Kenny Tan Chee Lun -->
<!-- Date: 14th May 2021 -->

<head>
    <title>MyFriend - Home</title>
    <meta charset="utf-8">
    <meta name="author" content="Kenny Tan Chee Lun">
    <meta name="description" content="Assignment 2">
    <meta name="keywords" content="job, vacancy, posting">
    <link rel="icon" href="images/companylogo.png">

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,100,300,700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="style/style.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg ftco_navbar ftco-navbar-light" id="ftco-navbar">
        <div class="container">
            <a class="navbar-brand" href="index.php"><img src = 'images/companylogoNoText.png' alt='icon'><span class="company-name">University Connect</span></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="fa fa-bars"></span>
            </button>
            <div class="collapse navbar-collapse" id="ftco-nav">
                <ul class="navbar-nav ml-auto mr-md-3">
                    <li class="nav-item"><a href="index.php" class="nav-link">Home</a></li>
                    <li class="nav-item active"><a href="about.php" class="nav-link">About</a></li>
                    <li class="nav-item"><a href="login.php" class="nav-link">Log In</a></li>
                </ul>
            </div>
        </div>
    </nav>
    
    <h1>About the University</h1>

    <div class="about-container">
        <p>
            <img src="images/universityBuilding.jpg">
            The University is Established in 1990. It is the third largest campus of Malaysia's largest university.
            We are a premier research-intensive Malaysia university ranked among the top 100 universities in the world by the Times Higher Education World
            University Rankings, and a member of Malaysia prestigious Group. The University is also ranked 55 in the QS 2021 World University Rankings.
        </p>
        <p>
            <img src="images/universityHall.jpg">
            A self-accrediting university, our campus offers a distinctly international and culturally rich environment with approximately 8,400 students
            from 78 different countries. Students are taught by highly qualified academic staff from across the world and the same rigorous standards with
            the university in the overseas.
        </p>
        <p>
            <img src="images/universitySwimmingPool.jpg">
            In addition to a vibrant campus experience with excellent catering facilities, food outlets, gymnasium and outdoor swimming pool, the Sunway
            City township in which the campus is situated offer numerous shopping and leisure opportunities within walking distance. Students can also
            take advantage of many clubs and societies that organise exciting events, be it flea markets and competitions or cultural and music festivals.
        </p>
    </div>

    <?php include 'footer.php' ?>

    <script src="js/jquery.min.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
</body>

</html>