<?php
include 'db_conn.php';

// Initialize variables
$title = $author = $description = $category = "";
$titleErr = $authorErr = $descriptionErr = $categoryErr = "";

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate form fields
    if (empty($_POST['title'])) {
        $titleErr = "Title is required";
    } else {
        $title = $_POST['title'];
    }

    if (empty($_POST['author'])) {
        $authorErr = "Author is required";
    } else {
        $author = $_POST['author'];
    }

    if (empty($_POST['description'])) {
        $descriptionErr = "Description is required";
    } else {
        $description = $_POST['description'];
    }

    if (empty($_POST['category'])) {
        $categoryErr = "Category is required";
    } else {
        $category = $_POST['category'];
    }

    // Handle file upload for book cover image
    $targetDirectory = "uploads/";
    $targetFile = $targetDirectory . basename($_FILES["file"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    if (isset($_POST["submit"])) {
        $check = getimagesize($_FILES["file"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
    }

    // Check if file already exists
    if (file_exists($targetFile)) {
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["file"]["size"] > 500000) {
        $uploadOk = 0;
    }

    // Allow certain file formats
    if (
        $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif"
    ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile)) {
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }

    // Handle file upload for PDF version of the book
    $pdfTargetDirectory = "uploads/";
    $pdfTargetFile = $pdfTargetDirectory . basename($_FILES["pdfFile"]["name"]);
    $pdfUploadOk = 1;
    $pdfFileType = strtolower(pathinfo($pdfTargetFile, PATHINFO_EXTENSION));

    // Check if file already exists
    if (file_exists($pdfTargetFile)) {
        $pdfUploadOk = 0;
    }

    // Check file size
    if ($_FILES["pdfFile"]["size"] > 5000000) {
        echo "Sorry, your PDF file is too large.";
        $pdfUploadOk = 0;
    }

    // Allow certain file formats
    if ($pdfFileType != "pdf") {
        echo "Sorry, only PDF files are allowed.";
        $pdfUploadOk = 0;
    }

    // Check if $pdfUploadOk is set to 0 by an error
    if ($pdfUploadOk == 0) {
    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["pdfFile"]["tmp_name"], $pdfTargetFile)) {
        } else {
            echo "Sorry, there was an error uploading your PDF file.";
        }
    }

    if (!empty($title) && !empty($author) && !empty($description) && !empty($category)) {
        // Form is valid, proceed with adding book

        // Check if the author exists in the authors table
        $author_id = null;
        $author_sql = "SELECT id FROM authors WHERE name = '$author'";
        $author_result = $conn->query($author_sql);
        if ($author_result->num_rows > 0) {
            // Author already exists, retrieve the author id
            $author_row = $author_result->fetch_assoc();
            $author_id = $author_row['id'];
        } else {
            // Author doesn't exist, insert a new record
            $author_insert_sql = "INSERT INTO authors (name) VALUES ('$author')";
            if ($conn->query($author_insert_sql) === TRUE) {
                // Get the auto-generated author id
                $author_id = $conn->insert_id;
            } else {
                echo "Error inserting author: " . $conn->error;
            }
        }

        // Check if the category exists in the categories table
        $category_id = null;
        $category_sql = "SELECT id FROM categories WHERE name = '$category'";
        $category_result = $conn->query($category_sql);
        if ($category_result->num_rows > 0) {
            // Category already exists, retrieve the category id
            $category_row = $category_result->fetch_assoc();
            $category_id = $category_row['id'];
        } else {
            // Category doesn't exist, insert a new record
            $category_insert_sql = "INSERT INTO categories (name) VALUES ('$category')";
            if ($conn->query($category_insert_sql) === TRUE) {
                // Get the auto-generated category id
                $category_id = $conn->insert_id;
            } else {
                echo "Error inserting category: " . $conn->error;
            }
        }

        // After moving the uploaded file, get the file names
        $imageFileName = basename($_FILES["file"]["name"]);
        $pdfFileName = basename($_FILES["pdfFile"]["name"]);

        // Remove the 'uploads/' part of the file paths
        $imagePath = str_replace('uploads/', '', $targetFile);
        $pdfFilePath = str_replace('uploads/', '', $pdfTargetFile);

        // Insert the book into the database
        $sql = "INSERT INTO books (title, author_id, description, category_id, cover, file)
        VALUES ('$title', '$author_id', '$description', '$category_id', '$imagePath', '$pdfFilePath')";

        if ($conn->query($sql) === TRUE) {
            // Display pop-up message indicating success
            echo "<script>alert('The book was added to the store successfully.');</script>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Book</title>
    <style>
        /* CSS styles for the form */
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
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
        }

        h2 {
            color: #0066cc;
        }

        label {
            color: #0066cc;
            font-weight: bold;
        }

        input[type="text"],
        textarea,
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        textarea {
            resize: vertical;
        }

        input[type="submit"] {
            background-color: #0066cc;
            color: white;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056a0;
        }

        .error {
            color: red;
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

        .delete-container {
            margin-left: 20px;
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
        <!-- Add New Book Form -->
        <h2>Add New Book</h2>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"
            enctype="multipart/form-data">
            <!-- Title Field -->
            <label for="title">Title:</label><br>
            <input type="text" id="title" name="title">
            <span class="error"><?php echo $titleErr; ?></span>
            <br><br>

            <!-- Author Field -->
            <label for="author">Author:</label><br>
            <input type="text" id="author" name="author">
            <span class="error"><?php echo $authorErr; ?></span>
            <br><br>

            <!-- Description Field -->
            <label for="description">Description:</label><br>
            <textarea id="description" name="description"></textarea>
            <span class="error"><?php echo $descriptionErr; ?></span>
            <br><br>

            <!-- Category Field -->
            <label for="category">Category:</label><br>
            <input type="text" id="category" name="category">
            <span class="error"><?php echo $categoryErr; ?></span>
            <br><br>

            <!-- File upload for book cover image -->
            <label for="file">Book Cover Image:</label><br>
            <input type="file" id="file" name="file">
            <br><br>

            <!-- File upload for PDF version of the book -->
            <label for="pdfFile">PDF File:</label><br>
            <input type="file" id="pdfFile" name="pdfFile">
            <br><br>

            <!-- Submit Button -->
            <input type="submit" value="Submit" name="submit">
        </form>
    </div>
    <div class="container delete-container">
        <h2>Delete Book</h2>
        <!-- Delete book form -->
        <form method="POST" action="func-delete.php">
            <!-- Dropdown to select book -->
            <label for="delete-book">Select Book to Delete:</label><br>
            <select name="delete-book" id="delete-book">
                <?php
                // Include database connection code here
                include 'db_conn.php';

                // Query to select all books
                $sql = "SELECT id, title FROM books";
                $result = $conn->query($sql);

                // Populate dropdown options with book titles
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['id'] . "'>" . $row['title'] . "</option>";
                    }
                }
                ?>
            </select><br><br>

            <!-- Submit Button to delete book -->
            <input type="submit" value="Delete Book">
        </form>
    </div>
</body>

</html>