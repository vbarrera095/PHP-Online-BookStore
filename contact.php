<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact</title>
    <style>
        /* Styling for the contact page */
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }

        body {
            background-color: #00FFDC;
        }

        .container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            margin: 100px auto;
        }

        h2 {
            color: #0066cc;
        }

        label {
            color: #0066cc;
            font-weight: bold;
        }

        /* Styling for phone number and email links */
        .contact-info {
            margin-top: 20px;
        }

        .contact-info a {
            color: #0066cc;
            text-decoration: none;
            margin: 0 10px;
        }

        .contact-info a:hover {
            text-decoration: underline;
        }

        .social-media-icons {
            margin-top: 20px;
        }

        .social-media-icons img {
            width: 40px;
            height: 40px;
            margin: 0 10px;
            cursor: pointer;
        }

        .back-arrow-container {
            position: absolute;
            top: 20px;
            left: 20px;
            display: flex;
            align-items: center;
            z-index: 999;
        }

        .back-arrow img {
            width: 30px;
            height: 30px;
            cursor: pointer;
            margin-right: 5px;
        }

        .back-arrow-text {
            color: #0066cc;
            font-size: 16px;
        }
    </style>
</head>

<body>
    <div class="back-arrow-container">
        <!-- Back arrow -->
        <div class="back-arrow">
            <a href="index.php"><img src="images/back-arrow.png" alt="Back to BookStore"></a>
        </div>
        <div class="back-arrow-text">Back to BookStore</div>
    </div>
    <div class="container">
        <h2>Contact Us</h2>
        <div class="contact-info">
            <p>Phone: <a href="tel:+18001226657">+1 800-12-BOOKS</a></p>
            <p><a href="tel:+18001226657">(+1 800-12-26657)</a></p>
            <p>Email: <a href="mailto:onlinebookstore@books.com">onlinebookstore@books.com</a></p>
        </div>
        <div class="social-media-icons">
            <a href="https://www.facebook.com/onlinebookstore"><img src="images/facebook.png" alt="Facebook"></a>
            <a href="https://www.twitter.com/onlinebookstore"><img src="images/x.png" alt="X"></a>
            <a href="https://www.instagram.com/onlinebookstore"><img src="images/instagram.png" alt="Instagram"></a>
        </div>
    </div>
</body>

</html>
