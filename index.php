<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personal Budget Tracker</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            line-height: 1.6;
        }
        header {
            background: #0078d4;
            color: #fff;
            padding: 0;
            text-align: center;
        }
        nav {
            background: #f4f4f4;
            display: flex;
            justify-content: center;
            padding: 1rem;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        nav a {
            margin: 0 15px;
            text-decoration: none;
            color: #333;
            font-weight: bold;
            transition: color 0.3s ease;
        }
        nav a:hover {
            color: #0078d4;
        }
        header h1, header p {
            margin: 0;
            padding: 1rem;
        }
        section {
            padding: 2rem;
            text-align: center;
        }
        #about-us {
            background: #eaeaea;
        }
        #contact-us {
            background: #f9f9f9;
        }
        footer {
            background: #333;
            color: #fff;
            text-align: center;
            padding: 1rem 0;
            margin-top: 1rem;
        }
        .nav{
            background-color:rgb(60, 203, 196);
        }
        .home{
            block-size: 150px;
            background-color: bisque;
        }
        .btn{
            background-color:rgb(60, 203, 196) ;
        }
       
    </style>
</head>
<body>
    <header>
        <nav class="nav">
            <a href="index.php">Home</a>
            <a href="#about-us">About Us</a>
            <a href="register.php">Sign up</a>
            <a href="login.php">Log in</a>

        </nav>
        <h1>Welcome to Personal Budget Tracker</h1>
        <p>Your smart companion for managing finances</p>
    </header>
    <section id="home">
       <button class="btn"><a href="login.php">GET STARTED</a></button> 
        
    </section>
    <section id="about-us">
        <h2>About Us</h2>
        <p>
            The Personal Budget Tracker is your all-in-one solution to track income, expenses, and savings. 
            Our goal is to make financial management simple and effective for everyone.
        </p>
    </section>
    <section id="contact-us">
        <h2>Contact Us</h2>
        <p>Have questions or need support? Reach out to us:</p>
        <p>Email: <a href="mailto:support@budgettracker.com">support@budgettracker.com</a></p>
        <p>Phone: + (255) 616-4567</p>
    </section>
    <footer>
        <p>&copy; 2024 Personal Budget Tracker. All rights reserved.</p>
    </footer>
</body>
</html>
