<?php include 'auth.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <title>Smart Inventory</title>
  <?php include 'head.php'; ?>
</head>
<body>
<?php
$id = $_GET['id'];

// Fetch the item data from the database
$query = "SELECT * FROM InventoryItem WHERE ItemID = $id";
$result = mysqli_query($con, $query);
$item = mysqli_fetch_assoc($result);
?>
<div class="container-scroller">
  <?php include 'navBar.php'; ?>
  <div class="container-fluid page-body-wrapper">
    <?php include 'sidebar.php'; ?>
    <div class="main-panel">
      <div class="content-wrapper">
        <div class="page-header">
          <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
              <i class="mdi mdi-view-list menu-icon"></i>
            </span>
            Inventory Management
          </h3>
        </div>
        <div class="container">
          <h2 class="mt-4">Edit Inventory Item</h2>
          <form action="edit_item.php?id=<?php echo $item['ItemID']; ?>" method="POST">
            <div class="form-group">
              <label for="itemName">Item Name</label>
              <input type="text" name="itemName" id="itemName" class="form-control" value="<?php echo $item['ItemName']; ?>" required>
            </div>
            <div class="form-group">
              <label for="category">Category</label>
              <input type="text" name="category" id="category" class="form-control" value="<?php echo $item['Category']; ?>" required>
            </div>
            <div class="form-group">
              <label for="quantity">Quantity</label>
              <input type="number" name="quantity" id="quantity" class="form-control" value="<?php echo $item['Quantity']; ?>" required>
            </div>
            <div class="form-group">
              <label for="location">Location</label>
              <input type="text" name="location" id="location" class="form-control" value="<?php echo $item['Location']; ?>" required>
            </div>
            <div class="form-group">
              <label for="price">Price</label>
              <input type="number" step="0.01" name="price" id="price" class="form-control" value="<?php echo $item['Price']; ?>" required>
            </div>
            <div class="form-group">
              <label for="supplierID">Supplier ID</label>
              <input type="number" name="supplierID" id="supplierID" class="form-control" value="<?php echo $item['SupplierID']; ?>">
            </div>
            <button type="submit" class="btn btn-primary mt-3">Update Item</button>
          </form>
        </div>
        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
          $itemName = mysqli_real_escape_string($con, $_POST['itemName']);
          $category = mysqli_real_escape_string($con, $_POST['category']);
          $quantity = mysqli_real_escape_string($con, $_POST['quantity']);
          $location = mysqli_real_escape_string($con, $_POST['location']);
          $price = mysqli_real_escape_string($con, $_POST['price']);
          $supplierID = mysqli_real_escape_string($con, $_POST['supplierID']);
          $last_updated = date('Y-m-d H:i:s');

          // Update the SQL query to match the InventoryItem table structure
          $query = "UPDATE InventoryItem SET ItemName='$itemName', Category='$category', Quantity='$quantity', Location='$location', Price='$price', SupplierID='$supplierID', UpdatedAt='$last_updated' WHERE ItemID = $id";
          
          if (mysqli_query($con, $query)) {
            echo "<script>alert('Item updated successfully!'); window.location.href = 'inventory.php';</script>";
          } else {
            echo "<script>alert('Error updating item: " . mysqli_error($con) . "');</script>";
          }
        }
        ?>
      </div>
    </div>
  </div>
</div>
<?php include 'footer.php'; ?>
</body>
</html>
