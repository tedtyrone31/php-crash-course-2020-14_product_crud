<?php

$pdo = new PDO('mysql:host=localhost;port=3306;dbname=products_crud', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$id = $_GET['id'] ?? null;


if (!$id) {
    header('location: index.php');
    exit;
}

$statement =$pdo->prepare('SELECT * FROM products WHERE id = :id');
$statement->bindValue(':id', $id);
$statement->execute();
$product = $statement->fetch(PDO::FETCH_ASSOC);


//   echo '<pre>';
//  var_dump($_SERVER);
//   echo '</pre>';

//   echo '<pre>';
//  var_dump($_FILES);
//   echo '</pre>';



$errors = [];

$title = '';
$price = '';
$description ='';



  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
 
$title = $_POST['title'];
$description = $_POST['description'];
$price = $_POST['price'];
$date = date('Y-m-d H:i:s');



    if (!$title) {
        $errors[] = 'Product title is required.';
    }

    if (!$price) {
        $errors[] = 'Product price is required.';
    }

if (!is_dir('images')) {
    mkdir('images');
}

 if (empty($errors)) {
     $image = $_FILES['image'] ?? null;
     $imagePath = '';
     if ($image && $image['tmp_name']) {
        $imagePath = 'images/' .randomString(8).'/'.$image['name'];
        mkdir(dirname($imagePath));

        move_uploaded_file($image['tmp_name'], $imagePath);
     }
    

$statement = $pdo->prepare("INSERT INTO products (title, image, description, price, create_date)
                    VALUES (:title, :image, :description, :price, :date)");

$statement->bindValue(':title', $title);
$statement->bindValue(':image', $imagePath);
$statement->bindValue(':description', $description);
$statement->bindValue(':price', $price);
$statement->bindValue(':date', $date);
$statement->execute();
header('location: index.php');

}
}
function randomString($n)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $str = '';
    for ($i = 0; $i < 10; $i++) {
        $index = rand(0, strlen($characters)-1);
        $str .= $characters[$index];
    }
    return $str;
}


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
    <h1>Create New Product</h1>

    <?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        <?php foreach ($errors as $error): ?>
          <div><?php echo $error ?></div>      
        <?php endforeach; ?>    
    </div>
    <?php endif; ?>

    <form action="create.php" method="post" enctype="multipart/form-data">
  <div class="mb-3">
    <label>Product Image</label><br>
    <input type="file" name="image">
  </div>
  <div class="mb-3">
    <label>Product Title</label>
    <input type="text" class="form-control" name="title" value="<?php echo $title?>">
  </div>
  <div class="mb-3">
    <label>Product Description</label>
    <textarea type="text" class="form-control" name="description"><?php echo $description ?></textarea>
  </div>
  <div class="mb-3">
    <label>Product Price</label>
    <input type="number" step= ".01"  class="form-control" name="price" value ="<?php echo $price?>" required>
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
        
</form>
  


    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    -->
  </body>
</html>