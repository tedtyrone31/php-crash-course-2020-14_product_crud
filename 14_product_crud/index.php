<?php

$pdo = new PDO('mysql:host=localhost;port=3306;dbname=products_crud', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$statement = $pdo->prepare('SELECT * FROM products ORDER BY create_date DESC');
$statement-> execute();
$products = $statement->fetchAll(PDO::FETCH_ASSOC);

// echo '<pre>';
// var_dump($products);
// echo '</pre>';

?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="app.css">

    <title>Products CRUD</title>
  </head>
  <body>
    <h1>Products CRUD</h1>

    <p>
      <a href="create.php" class="btn btn-success">Create Product</a>
    </p>

    <table class="table">
  <thead> 
    <tr>
      <th scope="col">#</th>
      <th scope="col">Image</th>
      <th scope="col">Title</th>
      <th scope="col">Price</th>
      <!-- <th scope="col">Description</th> -->
      <th scope="col">Create Date</th>
      <th scope="col">Action</th>

    </tr>
  </thead>
  <tbody>   
    <?php foreach ($products as $i => $product): ?>
  
    <tr>
      <th scope="row"><?php echo $i +1 ?></th>
      <td>
        <img src="<?php echo $product['image'] ?>"  class="thumb-image">
      </td>
      <td><?php echo $product['title'] ?></td>
      <td><?php echo $product['price'] ?></td>
      <!-- <td><?php echo $product['description'] ?></td> -->
      <td><?php echo $product['create_date'] ?></td>
      <td>
      <a href="update.php?id=<?php echo $product['id'] ?>" type = "button" class="btn-sm btn-outline-primary">Edit</a>
      <form style="display:inline-block;" method="post" action="delete.php">
       <input type="hidden" name="id" value="<?php echo $product['id'] ?>"> 
       <button type="submit" class="btn-sm btn-outline-danger">Delete</button>
      </form>
      </td>
        
    </tr>

  <?php endforeach; ?> 
   
  </tbody>
</table>


    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    -->
  </body>
</html> 