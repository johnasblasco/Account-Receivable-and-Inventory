<?php

require_once '../vendor/autoload.php';
use App\classes\Database;
use App\classes\Manage;
use App\classes\DBoperation;
use App\classes\User;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if(isset($_POST['username']) && isset($_POST['email'])){
    $uob = new User();
    $result = $uob->createUserAccount($_POST['username'],$_POST['email'],$_POST['password1'],$_POST['usertype']);
    echo $result;
    die();
}

if(isset($_POST["email"]) && isset($_POST["password"])) {
    $user = new User();
    $result = $user->userLogin($_POST["email"],$_POST["password"]);
    echo $result;
    exit();
}
//To get Category
if (isset($_POST["getCategory"])) {
    $obj = new DBoperation();
    $rows = $obj->getAllData('categories','cid','DESC');
    foreach ($rows as $row) {
        echo "<option value='".$row["cid"]."'>".$row["catname"]."</option>";
    }
    exit();
}

//Add Category
if(isset($_POST["catname"]) && isset($_POST["parent_cat"])) {
    $obj = new DBoperation();
    echo $result = $obj->addCategory($_POST["parent_cat"],$_POST["catname"]);
    exit();
}
//FETCH BRAND
if (isset($_POST["getBrand"])) {
    $obj = new DBoperation();
    $rows = $obj->getAllData("brands",'bid','DESC');
    foreach ($rows as $row) {
        echo "<option value='".$row["bid"]."'>".strtoupper($row["brandname"])."</option>";
    }
    exit();
}
//ADD BRAND
if (isset($_POST["brandname"])) {
    $obj = new DBoperation();
    $result = $obj->addNewBrand($_POST["brandname"]);
    echo $result;
    exit();
}

//Add Product
if (isset($_POST["added_date"]) AND isset($_POST["productname"])) {
    $obj = new DBoperation();
    $result = $obj->addNewProduct($_POST["productname"],
        $_POST["select_cat"],
        $_POST["select_brand"],
        $_POST["price"],
        $_POST["productquantity"],
        $_POST["added_date"]);
    echo $result;
    exit();
}



//--------------------------Manage Category--------------------------------

if (isset($_POST["manageCategory"])) {
    $m = new Manage();
    $result = $m->manageRecordWithPagination("categories",$_POST["pageno"]);
    $rows = $result["rows"];
    $pagination = $result["pagination"];
    if (count($rows) > 0) {
        $n = (($_POST["pageno"] - 1) * 5)+1;
        foreach ($rows as $row) {
            ?>
            <tr class="text-center">
                <td><?php echo $n; ?></td>
                <td class="text-left"><?php echo ucwords($row["category"]); ?></td>
                <td>
                    <?= $row["parent"] == NULL? 'Root':$row["parent"]; ?>
                </td>
                <td>
                    <?php
                    if($row["status"] == 1){
                        echo '<a href="#" class="btn btn-success btn-sm">Active</a>';
                    }else{
                        echo '<a href="#" class="btn btn-danger btn-sm">Inctive</a>';
                    }
                    ?>
                </td>
                <td>
                    <a href="#" did="<?php echo $row['cid']; ?>" class="btn btn-danger btn-sm del_cat">Delete</a>
                    <a href="#" eid="<?php echo $row['cid']; ?>" data-toggle="modal" data-target="#categoryModal" class="btn btn-info btn-sm edit_cat">Edit</a>
                </td>
            </tr>
            <?php
            $n++;
        }
        ?>
        <tr><td colspan="5"><?php echo $pagination; ?></td></tr>
        <?php
        exit();
    }
}
//Delete Category
if (isset($_POST["deleteCategory"])) {
    $m = new Manage();
    $result = $m->deleteRecord("categories","cid",$_POST["id"]);
    echo $result;
}
//Update Category
if (isset($_POST["updateCategory"])) {
    $m = new Manage();
    $result = $m->getSingleData("categories","cid",$_POST["id"]);
    echo json_encode($result);
    exit();
}

//Update Record after getting data
if (isset($_POST["update_category"])) {
    $m = new Manage();
    $id = $_POST["cid"];
    $name = $_POST["update_category"];
    $parent = $_POST["parent_cat"];
    $result = $m->update_record("categories",["cid"=>$id],["parent_cat"=>$parent,"catname"=>$name,"status"=>1]);
    echo $result;
}

//--------------------------Manage Category--------------------------------

if (isset($_POST["manageBrand"])) {
    $m = new Manage();
    $result = $m->manageRecordWithPagination("brands",$_POST["pageno"]);
    $rows = $result["rows"];
    $pagination = $result["pagination"];
    if (count($rows) > 0) {
        $n = (($_POST["pageno"] - 1) * 5)+1;
        foreach ($rows as $row) {
            ?>
            <tr class="text-center">
                <td><?php echo $n; ?></td>
                <td class="text-left"><?php echo ucwords($row["brandname"]); ?></td>
                <td>
                    <?php
                    if($row["status"] == 1){
                        echo '<a href="#" class="btn btn-success btn-sm">Active</a>';
                    }else{
                        echo '<a href="#" class="btn btn-danger btn-sm">Inctive</a>';
                    }
                    ?>
                </td>
                <td>
                    <a href="#" did="<?php echo $row['bid']; ?>" class="btn btn-danger btn-sm del_brand">Delete</a>
                    <a href="#" eid="<?php echo $row['bid']; ?>" data-toggle="modal" data-target="#brandModal" class="btn btn-info btn-sm edit_brand">Edit</a>
                </td>
            </tr>
            <?php
            $n++;
        }
        ?>
        <tr><td colspan="5"><?php echo $pagination; ?></td></tr>
        <?php
        exit();
    }
}
//Delete
if (isset($_POST["deleteBrand"])) {
    $m = new Manage();
    $result = $m->deleteRecord("brands","bid",$_POST["id"]);
    echo $result;
}

//Update Brand
if (isset($_POST["updateBrand"])) {
    $m = new Manage();
    $result = $m->getSingleData("brands","bid",$_POST["id"]);
    echo json_encode($result);
    exit();
}

//Update Record after getting data
if (isset($_POST["update_brand"])) {
    $m = new Manage();
    $id = $_POST["bid"];
    $name = $_POST["update_brand"];
    $result = $m->update_record("brands",["bid"=>$id],["brandname"=>$name,"status"=>1]);
    echo $result;
};

// --------------------------------Mange Product--------------------
if (isset($_POST["manageProduct"])) {
    $m = new Manage();
    $result = $m->manageRecordWithPagination("products",$_POST["pageno"]);
    $rows = $result["rows"];
    $pagination = $result["pagination"];
    if (count($rows) > 0) {
        $n = (($_POST["pageno"] - 1) * 5)+1;
        foreach ($rows as $row) {
            ?>
            <tr>
                <td><?php echo $n; ?></td>
                <td><?php echo ucwords($row["productname"]); ?></td>
                <td><?php echo ucwords($row["catname"]); ?></td>
                <td><?php echo ucwords($row["brandname"]); ?></td>
                <td><?php echo $row["price"]; ?></td>
                <td><?php echo $row["quantity"]; ?></td>
                <td><?php echo $row["added_date"]; ?></td>
                <td>
                    <?php
                    if($row["status"] == 1){
                        echo '<a href="#" class="btn btn-success btn-sm">Active</a>';
                    }else{
                        echo '<a href="#" class="btn btn-danger btn-sm">Inactive</a>';
                    }
                    ?>

                </td>
                <td>
                    <a href="#" did="<?php echo $row['pid']; ?>" class="btn btn-danger btn-sm del_product">Delete</a>
                    <a href="#" eid="<?php echo $row['pid']; ?>" data-toggle="modal" data-target="#form_products" class="btn btn-info btn-sm edit_product">Edit</a>
                </td>
            </tr>
            <?php
            $n++;
        }
        ?>
        <tr><td colspan="5"><?php echo $pagination; ?></td></tr>
        <?php
        exit();
    }
}

//Delete
if (isset($_POST["deleteProduct"])) {
    $m = new Manage();
    $result = $m->deleteRecord("products","pid",$_POST["id"]);
    echo $result;
}

//Update Product
if (isset($_POST["updateProduct"])) {
    $m = new Manage();
    $result = $m->getSingleData("products","pid",$_POST["id"]);
    echo json_encode($result);
    exit();
}


//Update Record after getting data
if (isset($_POST["update_product"])) {
    $m = new Manage();
    $id = $_POST["pid"];
    $name = $_POST["update_product"];
    $cat = $_POST["select_cat"];
    $brand = $_POST["select_brand"];
    $price = $_POST["product_price"];
    $qty = $_POST["product_qty"];
    $date = $_POST["added_date"];
    $result = $m->update_record("products",["pid"=>$id],["cid"=>$cat,"bid"=>$brand,"productname"=>$name,"price"=>$price,"quantity"=>$qty,"added_date"=>$date]);

    echo $result;
}
//-----------------------------ORDER------------------------------

/// If getting new order items
// If getting new order items
if (isset($_POST["getNewOrderItem"])) {
      $obj = new DBoperation();
      $rows = $obj->getAllData("products", 'pid', 'DESC');
      ?>
      <tr>
          <td><b class="number">1</b></td>
          <td>
              <select name="pid[]" class="form-control form-control-sm pid" required>
                  <option value="">Choose Product</option>
                  <?php
                  foreach ($rows as $row) {
                      ?><option value="<?php echo $row['pid']; ?>"><?php echo $row["productname"]; ?></option><?php
                  }
                  ?>
              </select>
          </td>
          <td><input name="tqty[]" readonly type="text" class="form-control form-control-sm tqty"></td>
          <td><input name="qty[]" type="text" class="form-control form-control-sm qty" required></td>
          <td><input name="price[]" type="text" class="form-control form-control-sm price" readonly></span>
              <span><input name="pro_name[]" type="hidden" class="form-control form-control-sm pro_name"></td>
          <td style="margin-left:5px;"> PHP:<span class="amt">0</span></td>
      </tr>
      <?php
      exit();
  }
  
  // Get price and quantity of one item
  if (isset($_POST["getPriceAndQty"])) {
      $m = new Manage();
      $result = $m->getSingleData("products", "pid", $_POST["id"]);
      echo json_encode($result);
      exit();
  }
  
  // Check if the order details are set and proceed with order processing
  if (isset($_POST["order_date"]) AND isset($_POST["cust_name"])) {
  
      // Debugging: Log incoming POST data to a log file or error log
      error_log("Received POST data: " . print_r($_POST, true));
  
      $orderdate = $_POST["order_date"];
      $cust_name = $_POST["cust_name"];
  
      // Now getting arrays from the order form
      $ar_tqty = $_POST["tqty"];
      $ar_qty = $_POST["qty"];
      $ar_price = $_POST["price"];
      $ar_pro_name = $_POST["pro_name"];
  
      $sub_total = $_POST["sub_total"];
      $gst = $_POST["gst"];
      $discount = $_POST["discount"];
      $net_total = $_POST["net_total"];
      $paid = $_POST["paid"];
      $due = $_POST["due"];
      $payment_type = $_POST["payment_type"];
  
      // Process the order using the Manage class
      $m = new Manage();
  
      // Step 1: Insert the order details into the invoice table
      $orderQuery = "INSERT INTO invoice (customer_name, order_date, sub_total, gst, discount, net_total, paid, due, payment_type)
                     VALUES ('$cust_name', '$orderdate', '$sub_total', '$gst', '$discount', '$net_total', '$paid', '$due', '$payment_type')";
      
      // Execute the query to insert the order into the invoice table
      $m->executeQuery($orderQuery);
  
      // Get the last inserted invoice number (invoice_no)
      $invoice_no = $m->getLastInsertId();  // Assuming getLastInsertId gets the last inserted ID
  
      // Step 2: Insert order items into the invoice_details table
      foreach ($ar_pro_name as $index => $pro_name) {
          $product_id = $ar_pro_name[$index];  // Assuming product_id is in the ar_pro_name array
          $quantity = $ar_qty[$index];
          $price = $ar_price[$index];
  
          // Insert each product into the invoice_details table
          $itemQuery = "INSERT INTO invoice_details (invoice_no, product_name, price, qty)
                        VALUES ('$invoice_no', '$pro_name', '$price', '$quantity')";
          
          // Execute the query to insert the order item into the invoice_details table
          $m->executeQuery($itemQuery);
      }
  
      // Return the invoice number (or any other information you need)
      echo $invoice_no;
  }
  
  

//manage order

if (isset($_POST["manageOrder"])) {
    $m = new Manage();
    $result = $m->manageRecordWithPagination("invoice",$_POST["pageno"]);
    $rows = $result["rows"];
    $pagination = $result["pagination"];
    if (count($rows) > 0) {
        $n = (($_POST["pageno"] - 1) * 5)+1;
        foreach ($rows as $row) {
            ?>
            <tr class="text-center">
                <td><?php echo $n; ?></td>
                <td class="text-left"><?php echo ucwords($row["customer_name"]); ?></td>
                <td ><?php echo ucwords($row["order_date"]); ?></td>
                <td ><?php echo ucwords($row["sub_total"]); ?></td>
                <td ><?php echo ucwords($row["gst"]); ?></td>
                <td ><?php echo ucwords($row["discount"]); ?></td>
                <td ><?php echo ucwords($row["net_total"]); ?></td>
                <td ><?php echo ucwords($row["paid"]); ?></td>
                <td ><?php echo ucwords($row["due"]); ?></td>
                <td ><?php echo ucwords($row["payment_type"]);  ?></td>
                <td style="overflow:hidden;">
                    <?php
                    if($row["due"] == 0){
                        echo '<span><a href="" class="btn btn-success">Paid</a></span>';
                    }else{
                        echo '<span><a href="" class="btn btn-danger">Due</a></span>';
                    }
                    ?>
                </td>
            </tr>
            <?php
            $n++;
        }
        ?>
        <tr><td colspan="5"><?php echo $pagination; ?></td></tr>
        <?php
        exit();
    }
}
//----------------

?>