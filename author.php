<?php 
session_start();

# If no author ID is set, redirect to index.php
if (!isset($_GET['id'])) {
	header("Location: index.php");
	exit;
}

# Get author ID from GET request
$id = $_GET['id'];

# Database Connection File
include "db_conn.php";

# Book helper function
include "php/func-book.php";
$books = get_books_by_author($conn, $id);

# author helper function
include "php/func-author.php";
$authors = get_all_author($conn);
$current_author = get_author($conn, $id);

# Category helper function
include "php/func-category.php";
$categories = get_all_categories($conn);
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?=$current_author['name']?></title>

    <!-- Bootstrap 5 CDN-->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap 5 JS bundle CDN-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="css/style.css">

</head>
<body>
	<div class="container">
		<!-- Navigation bar -->
		<nav class="navbar navbar-expand-lg navbar-light bg-light">
		  <div class="container-fluid">
		    <a class="navbar-brand" href="index.php">Vladimir's Online Book Store</a>
		    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		      <span class="navbar-toggler-icon"></span>
		    </button>
		    <div class="collapse navbar-collapse" 
		         id="navbarSupportedContent">
		      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
		        <!-- Navigation links -->
		        <li class="nav-item">
		          <a class="nav-link active" 
		             aria-current="page" 
		             href="index.php">Store</a>
		        </li>
		        <li class="nav-item">
		          <a class="nav-link" 
		             href="#">Contact</a>
		        </li>
		        <li class="nav-item">
		          <a class="nav-link" 
		             href="#">About</a>
		        </li>
		        <li class="nav-item">
		          <!-- Display admin link if user is logged in, otherwise display login link -->
		          <?php if (isset($_SESSION['user_id'])): ?>
		          	<a class="nav-link" 
		             href="admin.php">Admin</a>
		          <?php else: ?>
		          <a class="nav-link" 
		             href="login.php">Login</a>
		          <?php endif; ?>

		        </li>
		      </ul>
		    </div>
		  </div>
		</nav>
		<!-- Page header -->
		<h1 class="display-4 p-3 fs-3"> 
			<a href="index.php"
			   class="nd">
				<img src="images/back-arrow.PNG" 
				     width="35">
			</a>
		   <?=$current_author['name']?>
		</h1>
		<div class="d-flex pt-3">
			<!-- Display message if there are no books for this author -->
			<?php if ($books == 0): ?>
				<div class="alert alert-warning 
        	            text-center p-5" 
        	     role="alert">
        	     <img src="images/empty.png" 
        	          width="100">
        	     <br>
			    There is no book in the database
		       </div>
			<?php else: ?>
			<!-- Display books if there are any for this author -->
			<div class="pdf-list d-flex flex-wrap">
				<?php foreach ($books as $book): ?>
				<div class="card m-1" style="height: fit-content">
					<img src="images/<?=$book['cover']?>"
					     class="card-img-top">
					<div class="card-body">
						<h5 class="card-title">
							<?=$book['title']?>
						</h5>
						<p class="card-text">
							<!-- Display author name -->
							<i><b>By:
								<?php foreach($authors as $author): 
									if ($author['id'] == $book['author_id']) {
										echo $author['name'];
										break;
									}
								endforeach; ?>
							<br></b></i>
							<?=$book['description']?>
							<br>
							<!-- Display category name -->
							<i><b>Category:
								<?php foreach($categories as $category): 
									if ($category['id'] == $book['category_id']) {
										echo $category['name'];
										break;
									}
								endforeach; ?>
							<br></b></i>
						</p>
                       <a href="uploads/files/<?=$book['file']?>"
                          class="btn btn-success">Open</a>

                        <a href="uploads/files/<?=$book['file']?>"
                          class="btn btn-primary"
                          download="<?=$book['title']?>">Download</a>
					</div>
				</div>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

		<div class="category">
			<!-- List of categories -->
			<div class="list-group">
				<?php if ($categories == 0): ?>
					<!-- If there are no categories, do nothing -->
				<?php else: ?>
				<a href="#"
				   class="list-group-item list-group-item-action active">Category</a>
				   <?php foreach ($categories as $category ): ?>
				  
				   <a href="category.php?id=<?=$category['id']?>"
				      class="list-group-item list-group-item-action">
				      <?=$category['name']?></a>
				<?php endforeach; ?>
				<?php endif; ?>
			</div>

			<!-- List of authors -->
			<div class="list-group mt-5">
				<?php if ($authors == 0): ?>
					<!-- If there are no authors, do nothing -->
				<?php else: ?>
				<a href="#"
				   class="list-group-item list-group-item-action active">Author</a>
				   <?php foreach ($authors as $author ): ?>
				  
				   <a href="author.php?id=<?=$author['id']?>"
				      class="list-group-item list-group-item-action">
				      <?=$author['name']?></a>
				<?php endforeach; ?>
				<?php endif; ?>
			</div>
		</div>
		</div>
	</div>
</body>
</html>
