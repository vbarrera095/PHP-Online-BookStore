<?php
include 'db_conn.php';

# Book helper function
include "php/func-book.php";
$books = get_all_books($conn);

# author helper function
include "php/func-author.php";
$authors = get_all_author($conn);

# Category helper function
include "php/func-category.php";
$categories = get_all_categories($conn);

// Remove duplicate line
// $categories = get_all_categories($conn);
// $authors = get_all_author($conn);

# Get category ID from URL parameter
$category_id = isset($_GET['category_id']) ? $_GET['category_id'] : null;

# Get author ID from URL parameter
$author_id = isset($_GET['author_id']) ? $_GET['author_id'] : null;

# Filter books by category or author
if ($category_id !== null) {
    $books = get_books_by_category($conn, $category_id);
} elseif ($author_id !== null) {
    $books = get_books_by_author($conn, $author_id);
} else {
    $books = get_all_books($conn);
}

// SQL query to fetch book title, cover, and author name
$sql = "SELECT books.title AS book_title, books.cover AS cover, authors.name AS author_name 
        FROM books
        INNER JOIN authors ON books.author_id = authors.id";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Bookstore</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles -->
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="container">
        <!-- Navigation bar -->
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.php">Vladimir's Online Book Store</a>
                <!-- Navbar toggler for responsive design -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <!-- Navigation links -->
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="index.php">Store</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="contact.php">Contact</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="about.php">About</a>
                        </li>
                        <li class="nav-item">
                            <!-- Display admin link if user is logged in, otherwise display login link -->
                            <?php if (isset($_SESSION['user_id'])): ?>
                                <a class="nav-link" href="admin.php">Admin</a>
                            <?php else: ?>
                                <a class="nav-link" href="login.php">Login</a>
                            <?php endif; ?>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Search form -->
        <form action="search.php" method="get" style="width: 100%; max-width: 30rem">
            <div class="input-group my-5">
                <input type="text" class="form-control" name="key" placeholder="Search Book..."
                    aria-label="Search Book..." aria-describedby="basic-addon2">
                <button class="input-group-text btn btn-primary" id="basic-addon2">
                    <img src="images/search.png" width="20">
                </button>
            </div>
        </form>

        <div class="d-flex pt-3">
            <?php if ($result->num_rows == 0): ?>
                <!-- Display a message if there are no books in the database -->
                <div class="alert alert-warning text-center p-5" role="alert">
                    <img src="img/empty.png" width="100"><br>
                    There is no book in the database
                </div>
            <?php else: ?>
                <!-- Display books if there are any in the database -->
                <div class="pdf-list d-flex flex-wrap">
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <!-- Card for each book -->
                        <div class="card m-1 text-center">
                            <div class="d-flex justify-content-center align-items-center" style="height: 300px;">
                                <!-- Book cover image -->
                                <img src="images/<?php echo $row['cover']; ?>" class="card-img-top"
                                    style="max-width: 200px; max-height: 250px;">
                            </div>
                            <div class="card-body d-flex flex-column justify-content-between">
                                <div>
                                    <!-- Book title and author -->
                                    <h5 class="card-title"><?php echo $row['book_title']; ?></h5>
                                    <p class="card-text"><i><b>By: <?php echo $row['author_name']; ?></b></i></p>
                                </div>
                                <div>
                                    <!-- Buttons to open or download the book -->
                                    <a href="#" class="btn btn-success">Open</a>
                                    <a href="#" class="btn btn-primary">Download</a>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php endif; ?>

            <!-- Sidebar with categories and authors -->
            <div class="category">
                <!-- List of categories -->
                <div class="list-group">
                    <a href="#" class="list-group-item list-group-item-action active">Category</a>
                    <?php foreach ($categories as $category): ?>
                        <a href="category.php?id=<?=$category['id']?>"
                            class="list-group-item list-group-item-action"><?php echo $category['name']; ?></a>
                    <?php endforeach; ?>
                </div>

                <!-- List of authors -->
                <div class="list-group mt-5">
                    <a href="#" class="list-group-item list-group-item-action active">Author</a>
                    <?php foreach ($authors as $author): ?>
                        <a href="author.php?id=<?=$author['id']?>"
                            class="list-group-item list-group-item-action"><?php echo $author['name']; ?></a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
