<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About</title>
    <style>
        /* CSS styles for the page */
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
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        h2 {
            color: #0066cc;
            margin-bottom: 20px;
        }

        .content {
            text-align: left;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            max-width: 100%;
        }

        .content img {
            max-width: 250px;
            margin-right: 20px;
        }

        .caption {
            text-align: center;
            max-width: 100%;
        }

        /* Styling for the back arrow */
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
        <h2>About Us</h2>
        <div class="content">
            <img src="images/machine.webp" alt="Bookstore">
            <div class="caption">
                <?php
                // Original caption text
                $caption = "Vladimir's Online BookStore works to connect readers with independent booksellers all over the world. We believe local bookstores are essential community hubs that foster culture, curiosity, and a love of reading, and we're committed to helping them thrive. Every purchase on the site financially supports independent bookstores. Our platform gives independent bookstores tools to compete online and financial support to help them maintain their presence in local communities.";

                // Split the caption into chunks of approximately 10 words each
                $chunks = array_chunk(explode(' ', $caption), 10);

                // Print each chunk as a separate paragraph
                foreach ($chunks as $chunk) {
                    echo '<p>' . implode(' ', $chunk) . '</p>';
                }
                ?>
            </div>
        </div>
    </div>
</body>

</html>
