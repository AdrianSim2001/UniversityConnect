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
        <link rel="stylesheet" type="text/css" href="style/style.css">
        <link rel="icon" href="images/companylogo.png">
    </head>

    <body>
        <header>
            <a href='index.php'><img src = 'images/companylogo.png' alt='icon'></a>
            <div><a href="index.php">Home</a></div>
            <div><a class="active" href="about.php">About</a></div>
            <div><a href="login.php">Log In</a></div>
        </header>

        <h1>
            University Connect
        </h1>

        <h2>About the University</h2>

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
    </body>

</html>