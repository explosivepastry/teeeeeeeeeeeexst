<?php
$currentPage = 'Invoice';
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
            <h1>Invoice</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active" id="pageTitle">Invoice</li>
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
                    <i class="fas fa-globe"></i> TRILOCOR ROBOTICS.
                    <small class="float-right">Date: <?php echo date("d/m/Y"); ?></small>
                  </h4>
                </div>
                <!-- /.col -->
              </div>
              <!-- info row -->
              <div class="row invoice-info">
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                  <b>Invoice #007612</b><br>
                  <br>
                  <b>Order ID:</b> <?php echo $order_number; ?><br>
                  <b>Payment Due:</b> <?php echo date('d/m/Y',strtotime('+30 days')); ?><br>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <!-- Table row -->
              <div class="row">
                <div class="col-12 table-responsive">
                  <table class="table table-striped">
                    <thead>
                    <tr>
                      <th>Qty</th>
                      <th>Product</th>
                      <th>Price</th>
                    </tr>
                    </thead>
                    <tbody>
                <?php
                  $sql = "SELECT * FROM order_items where order_id = ?";
                  if($stmt = $mysqli->prepare($sql)){
                    $stmt->bind_param('s',$order_number);
                    if($stmt->execute()){
                      $result = $stmt->get_result();
                      if($result->num_rows != 0){
                        while($row = $result->fetch_assoc()) {
			  echo "<tr>";
                          echo "<td>".$row['quantity']."</td>";
                          echo "<td>".$row['item_name']."</td>";
                          $sql = "SELECT price FROM parts where id = ?";
                          if($s = $mysqli->prepare($sql)){
                              $s->bind_param('s',$row['item_id']);
                              if($s->execute()){
                                  $res = $s->get_result();
                                  if($res->num_rows != 0){
					while($r = $res->fetch_assoc()) {
					    echo "<td>".$r['price']."</td>";
				       }
				  }
			      }
			  }
			  $stmt->close();
           	          echo "</tr>";
                        }
                      }
                    }
                  }
                  $stmt->close();
                ?>
                    </tbody>
                  </table>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

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
                <?php
                  $sql = "SELECT * FROM orders where order_number = ?";
                  if($stmt = $mysqli->prepare($sql)){
                    $stmt->bind_param('s',$order_number);
                    if($stmt->execute()){
                      $result = $stmt->get_result();
                      if($result->num_rows != 0){
                        while($row = $result->fetch_assoc()) {
                          echo "<tr>";
                          echo '<th style="width:50%">Subtotal:</th>';
                          echo "<td>$".$row['order_cost']."</td>";
                          echo "</tr>";
                          echo "<tr>";
			  echo "<th>Tax (21.25%)</th>";
			  echo "<td>";
                          $price = $row['order_cost'];
                          $taxRate=21.25;
                          $tax=$price*$taxRate/100;
                          $total=$price+$tax;
                          $calculatedTaxRate=(($total-$price)/$price)*100; 
                          echo "$".$tax."";
			  echo "</td>";
			  echo "<tr>";
			  echo "<th>Shipping:</th>";
			  $shipping = 5.80;
			  echo "<td>$".$shipping."</td>";
			  echo "</tr>";
			  echo "<tr>";
			  echo "<th>Total:</th>";
			  $grand_total = $price + $tax + $shipping;
			  echo "<td>$".$grand_total."</td>";
                        }
                      }
                    }
                  }
                  $stmt->close();
                ?>
                      </tr>
                    </table>
                  </div>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
            </div>
            <!-- /.invoice -->
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
<?php
include('includes/footer.php');
?>