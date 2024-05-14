<?php  

# Get all Categories function
function get_all_categories($con){
   $sql  = "SELECT * FROM categories";
   $stmt = $con->prepare($sql);
   $stmt->execute();

   // Fetch the results
   $result = $stmt->get_result();

   // Check if there are any rows returned
   if ($result->num_rows > 0) {
       // Fetch all rows into an associative array
       $categories = $result->fetch_all(MYSQLI_ASSOC);
   } else {
      $categories = 0;
   }

   return $categories;
}



# Get category by ID
function get_category($con, $id){
   $sql  = "SELECT * FROM categories WHERE id=?";
   $stmt = $con->prepare($sql);
   $stmt->bind_param("i", $id);
   $stmt->execute();
   
   // Fetch the results
   $result = $stmt->get_result();

   // Check if there are any rows returned
   if ($result->num_rows > 0) {
       // Fetch the first row into an associative array
       $category = $result->fetch_assoc();
   } else {
      $category = 0;
   }

   return $category;
}