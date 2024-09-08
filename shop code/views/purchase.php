<?php
$currentPage = 'Purchase';
include('includes/header.php');
require "config.php";

?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Purchase Products</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active" id="pageTitle" value="Purchase Products">Purchase Products</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <!-- Main content -->
            <div class="invoice p-3 mb-3">
              <!-- title row -->
              <div class="row">
                <div class="col-12">
                  <h4>
                    <i class="fas fa-shopping-cart"></i> Cart
                  </h4>
                </div>
                <!-- /.col -->
              </div>
              <!-- Table row -->
              <div class="row">
                <div class="col-12 table-responsive">
                  <table class="table table-striped" id="cartTable">
                    <thead>
                    <tr>
                      <th>Qty</th>
                      <th>Product</th>
                      <th>Price</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                    </tr>
                    </tbody>
                  </table>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
              <div class="row no-print">
                <div class="col-2">
                  <button type="button" class="btn btn-success" onclick="addItem(); add();"><i class="far fa-credit-card"></i> Add Item</button>
                </div>
                <div class="col-1">
                  <input type="number" id="partQuantity" value="1" style="width:80%" disabled></input>
                </div>
                <div class="col-3">
                <select id="partName">
                <?php
	          $sql = "SELECT * FROM parts";
        	  if($stmt = $mysqli->prepare($sql)){
          	    if($stmt->execute()){
                      $result = $stmt->get_result();
                      if($result->num_rows != 0){
                        while($row = $result->fetch_assoc()) {
		          echo '<option value="'.$row['part_name'].'">'.$row['part_name'].'</option>';
		        }
		      }
		    }
		  }
		?>
		</select>
                </div>
              </div>

              <div class="row">
                <!-- accepted payments column -->
                <div class="col-6">
                  <p class="lead">Payment Methods:</p>
                  <img src="../../assets/images/credit/visa.png" alt="Visa">
                  <img src="../../assets/images/credit/mastercard.png" alt="Mastercard">
                  <img src="../../assets/images/credit/american-express.png" alt="American Express">
                  <img src="../../assets/images/credit/paypal2.png" alt="Paypal">

                </div>
                <!-- /.col -->
                <div class="col-6">
                  <div class="table-responsive">
                    <table class="table">
                      <tr>
                        <th>Total:</th>
                        <td id="totalPrice">$0</td>
                      </tr>
                    </table>
                  </div>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
              <form id="purchase-form" action="/api/products/buy" method="POST">
              <!-- this row will not appear when printing -->
              <div class="row no-print">
                <div class="col-12">
                  <button type="submit" class="btn btn-success float-right"><i class="far fa-credit-card"></i> Place Order</button>
                </div>
              </div>
	      </form>
            </div>
            <!-- /.invoice -->
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
<?php
include('includes/footer.php');
?>