<?php
spl_autoload_register(function($class){
require"$class.php";
});



$db = new DbConnection();
$con = $db->connect();

class main
{






  static function generate_user($department)
  {

    $user_id = "";
    $current_time = time();
    $shuffled_time = str_shuffle($current_time);

    if ($department == "1") {

      $user_id = "ADM" . $shuffled_time;
    }

    if ($department == "3") {

      $user_id = "MAR" . $shuffled_time;
    } else if ($department == "2") {

      $user_id = "PRO" . $shuffled_time;
    } else if ($department == "5") {

      $user_id = "FIN" . $shuffled_time;
    } else if ($department == "4") {

      $user_id = "MNE" . $shuffled_time;
    } else {

      $new_value = substr(strtoupper($department), 0, 3);
      $user_id = $new_value . $shuffled_time;
    }




    return $user_id;
  }


  //user log-in function
























  function check_user_data($fullname, $dob, $sex, $phone, $email, $password)
  {


    global $con;

    $sql = "SELECT * FROM `user` WHERE email = '$email' OR fullname = '$fullname'";

    $result =  $con->query($sql);

    $count = $result->num_rows;

    if ($count >= 1) {
      return "Name or email already exists in the Database. Change and try again ";
    } else {
      return $this->register_user($fullname, $dob, $sex, $phone, $email, $password);
    }
  }


  static function suspend_user_account($user_id)
  {
    global $con;
    $sql = "UPDATE `user` SET `account_status`='suspended' WHERE `user_ID`='$user_id'";
    $statement = $con->prepare($sql);
    if ($statement->execute()) {

      return "suspended";
    }
  }


  static function update_profile_picture($userId, $file)
  {

    global $con;

    $sql = "UPDATE `user` SET `profile_picture`='$file' WHERE `user_ID`='$userId'";
    $statement = $con->prepare($sql);
    if ($statement->execute()) {
      return "updated";
    }
  }









  static function register_crop($crop_name)
  {
    global $con;
    $name = strtolower($crop_name);
    $user_id = self::generate_user("crop");
    $sql = "INSERT INTO `crop`(`crop_ID`, `crop`) VALUES ('$user_id','$name')";
    $statement = $con->prepare($sql);
    if ($statement->execute()) {
      return "registered";
    }
  }

  // checking if variety name already exists in the database
  static function check_new_crop_name($crop_name)
  {
    $name = strtolower($crop_name);
    global $con;

    $sql = "SELECT * FROM crop WHERE  `crop` LIKE '%$name%'";
    $result =  $con->query($sql);
    if ($result->num_rows > 0) {

      return "already_exists";
    }
  }
  // checking if variety name already exists in the database

  static function check_new_variety_name($crop, $new_variety_name)
  {
    $variety = strtoupper($new_variety_name);
    global $con;

    $sql = "SELECT * FROM variety WHERE `crop_ID`='$crop' AND `variety` LIKE '%$variety%'";
    $result =  $con->query($sql);
    if ($result->num_rows > 0) {

      return "already_exists";
    }
  }

  //  adding new variety 
  static function register_variety($crop_id, $variety_name, $variety_type)
  {

    $v_name = strtoupper($variety_name);
    global $con;
    $variety_id = self::generate_user("variety");
    $sql = "INSERT INTO `variety`(`variety_ID`, `variety`, `crop_ID`,`variety_type`) VALUES ('$variety_id','$v_name','$crop_id','$variety_type')";
    $statement = $con->prepare($sql);
    if ($statement->execute()) {



      return self::add_price($crop_id, $variety_id);
    }
  }

  function add_price($crop_id, $variety_id)
  {

    global $con;
    $price_id = time();
    $sql = "INSERT INTO `price`(`prices_ID`, `crop_ID`, `variety_ID`,`sell_breeder`,`sell_basic`, 
    `sell_pre_basic`,`sell_certified`,`buy_breeder`,`buy_basic`, `buy_pre_basic`, `buy_certified`) VALUES 
    ('$price_id','$crop_id','$variety_id','0.00','0.00',
    '0.00','0.00','0.00','0.00','0.00','0.00')";

    $statement = $con->prepare($sql);
    if ($statement->execute()) {

      return "registered";
    } else {

      return "error";
    }
  }








  function register_user($fullname, $dob, $sex, $phone, $email, $password)
  {


    $user_id = $this->generate_user("user");
    global $con;
    $registered_date =  date("Y-m-d");
    $userFullName = strtolower($fullname);

    $sql = "INSERT INTO `user`(`user_ID`, `fullname`,`DOB`,`sex`,`registered_date`,`phone`, `email`, `password`,`account_status`) 
                       VALUES ('$user_id','$userFullName','$dob','$sex','$registered_date',
                            '$phone','$email','$password','unsigned')";

    $statement = $con->prepare($sql);
    if ($statement->execute()) {
      return "registered";
    }
  }
  static function update_user($user_id, $fullname, $phone, $email)
  {

    $sql = "UPDATE `user` SET `fullname`='$fullname',`phone`='$phone',`email`='$email' WHERE `user_ID`='$user_id'";
    global $con;
    $statement = $con->prepare($sql);
    if ($statement->execute()) {

      return "updated";
    }
  }

  function delete_user()
  {

    $sql = "DELETE FROM `user` WHERE 0";
  }


  //admin set prices for all products function


  static function allocate_role_to_user($userId, $department, $role)
  {

    global $con;

    $sql = "UPDATE `user` SET `user_type_ID`='$department', `postion`='$role', `account_status`='active' WHERE `user_ID`='$userId'";

    $statement = $con->prepare($sql);
    if ($statement->execute()) {

      return "registered";
    };
  }








  //  get crop prices

  static function get_prices($crop, $variety)
  {
    global $con;

    $sql = "SELECT * FROM price WHERE `crop_ID`='$crop' AND `variety_ID`='$variety'";
    $result =  $con->query($sql);
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        return $row["sell_breeder"] . "," . $row["sell_basic"] . "," . $row["sell_pre_basic"] . "," . $row["sell_certified"] . "," . $row["buy_breeder"] . "," . $row["buy_basic"] . "," . $row["buy_pre_basic"] . "," . $row["buy_certified"];
      }
    }
  }

  static function set_sell_prices($crop, $variety, $breeder, $pre_basic, $basic, $certified)
  {


    global $con;
    $sql = "SELECT `prices_ID` FROM `price` WHERE `crop_ID`='$crop' AND `variety_ID`='$variety'";
    $result =  $con->query($sql);
    $count = $result->num_rows;
    if ($count == 1) {
      $name = $result->fetch_assoc();
      $price_id = $name['prices_ID'];



      $sql = "UPDATE `price` SET `sell_breeder`='$breeder',`sell_basic`='$basic',`sell_pre_basic`='$pre_basic',`sell_certified`='$certified' WHERE prices_ID='$price_id'";
      $statement = $con->prepare($sql);
      if ($statement->execute()) {
        return "updated";
      } else {

        return "error";
      }
    } else {
      return "error";
    }




    /*global $con;
      $sql=" UPDATE `price` SET `basic`='$basic',`pre_basic`='$pre_basic',`certified`='$certified' WHERE `prices_ID`='$price_id';";
      $statement->execute();
      
        */
  }

  /// set  buy back price
  static function set_buy_prices($crop, $variety, $breeder, $pre_basic, $basic, $certified)
  {


    global $con;
    $sql = "SELECT `prices_ID` FROM `price` WHERE `crop_ID`='$crop' AND `variety_ID`='$variety'";
    $result =  $con->query($sql);
    $count = $result->num_rows;
    if ($count == 1) {



      $name = $result->fetch_assoc();
      $price_id = $name['prices_ID'];
      $sql = "UPDATE `price` SET `buy_breeder`='$breeder',`buy_basic`='$basic',`buy_pre_basic`='$pre_basic',`buy_certified`='$certified' WHERE prices_ID='$price_id'";
      $statement = $con->prepare($sql);
      $statement->execute();

      return "updated";
    } else {
      return "error";
    }






    /*global $con;
      $sql=" UPDATE `price` SET `basic`='$basic',`pre_basic`='$pre_basic',`certified`='$certified' WHERE `prices_ID`='$price_id';";
      $statement->execute();
      
        */
  }

  //Marketing sales functions 

  // grower order is a little different from the normal order 


  function temp_data($data_result, $order_note_number, $order_type, $crop, $variety, $class, $order_quantity, $price_per_kg, $discount_price, $total_price)
  {

    // sessions for holding temp data when order is in progress

    if (empty($_SESSION['order'])) {
      global $con;

      $order_ID = $this->generate_user("order");
      $_SESSION['order'] =  $order_ID;
      $_SESSION['customer_ID'] = $data_result[0];
      $_SESSION['customer_name'] = $data_result[2];
      $_SESSION['type'] = $order_type;


      $sql = "INSERT INTO `order_table`(`order_ID`) VALUES
    ('$order_ID')";
      $statement = $con->prepare($sql);
      $statement->execute();

      $this->add_order_item($order_ID, $crop, $variety, $class, $order_quantity, $price_per_kg, $discount_price, $total_price);
    }
  }

  function check_order_book_number($order, $order_book_number, $crop, $variety, $class, $order_quantity, $price_per_kg, $discount_price, $total_price)
  {

    $this->add_order_item($order, $crop, $variety, $class, $order_quantity, $price_per_kg, $discount_price, $total_price);

    // global $con;
    // $sql = "SELECT * FROM `order_table` WHERE `order_book_number`='$order_book_number'";
    // $result =  $con->query($sql);
    // $count = $result->num_rows;
    // if ($count >= 1) {
    //   echo ("<script> alert('Error: Order book number already exists ');
    //                                         </script>");
    // } else {



    //   $this->add_order_item($order, $crop, $variety, $class, $order_quantity, $price_per_kg, $discount_price, $total_price);
    // }
  }











  function place_order()
  {


    $temp =  $_SESSION['order'];


    // checking is order has items added 

    if (empty($temp)) {


      echo ("<script> alert('No items add to order !');
    </script>");
    } else {

      global $con;
      $status = "pending";
      $date = date("Y-m-d");
      $time = date("H:i:s");
      $sum = "";
      $count = "";
      $user_ID =  $_SESSION['user'];
      $order_ID = $_SESSION['order'];
      $order_type = $_SESSION['type'];
      $customer_id = $_SESSION['customer_ID'];
      $customer_name = $_SESSION['customer_name'];
      $lpoFile = $_SESSION['lpoFile'];







      //calculating the total price and count of all items added in the order 
      $sql = "SELECT sum(total_price) as total , COUNT(*) as total_count FROM `item` WHERE order_ID ='$order_ID'";
      $result = $con->query($sql);
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          $sum    = $row["total"];
          $count = $row["total_count"];
        }
      }



      if (!empty($sum)) {
        /// finalizing order by updating the total of all added atems in the order 


        $sql = " UPDATE `order_table` SET `order_type`='$order_type',
      `customer_id`='$customer_id',`customer_name`='$customer_name',`user_ID`='$user_ID',
      `status`='$status',`date`='$date',`time`='$time',
      `count`='$count',`total_amount`='$sum',`order_files`='$lpoFile' WHERE order_ID ='$order_ID'";

        $statement = $con->prepare($sql);
        $statement->execute();



        unset($_SESSION['order']);
        unset($_SESSION['type']);
        unset($_SESSION['customer_ID']);
        unset($_SESSION['customer_name']);
        unset($_SESSION['order_book_number']);





        echo ("<script> alert('Order placed !!');
        window.location='place_order.php';
         </script>");
      } else {

        echo ("<script> alert('Can not process order. price not added to products !');
        </script>");
      }
    }
  }







  static function admin_approve_order($order_id, $action)
  {
    global $con;

    if ($action == "approve") {

      $sql = "UPDATE `order_table` SET `status`='approved' WHERE `order_ID`='$order_id'";
      $statement = $con->prepare($sql);
      $statement->execute();
      self::check_farm_order($order_id, "order_approved");
      echo "approved";
    } else if ("deny") {

      $sql = "UPDATE `order_table` SET `status`='denied' WHERE `order_ID`='$order_id'";
      $statement = $con->prepare($sql);
      $statement->execute();
      self::check_farm_order($order_id, "order_denied");
      echo "denied";
    }
  }



  static function  check_farm_order($order_id, $status)
  {
    global $con;

    $sql = "SELECT `farm_id` FROM `order_table` WHERE  `order_ID`='$order_id'";
    $result = $con->query($sql);
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        $farm_id = $row["farm_id"];
        $sql = "UPDATE `farm` SET `order_status`='$status' WHERE farm_ID ='$farm_id'";
        $statement = $con->prepare($sql);
        $statement->execute();
      }
    }
  }




  function order_process($order_book_number, $user_id, $customer_name, $customer_type, $crop, $variety, $class, $order_quantity, $price_per_kg, $discount_price, $count, $total_price)
  {
    // starting order process by generating order ID and and startying the order session
    $check_cat = $_SESSION['order'];

    if (empty($check_cat)) {

      $order_ID = $this->generate_user("order");

      $order_date = date("Y-m-d");
      $order_time = date("H:i:s");
      global $con;

      $sql = "INSERT INTO `order_table`(`order_ID`, 
     `customer_name`, `order_book_number`, `user_ID`,
      `status`, `date`, `time`, `count`, `total`) VALUES
      ($order_ID','$customer_name',''$order_book_number','$user_id',
      'pending','$order_date','$order_time','$count','$total_price')";
      $statement = $con->prepare($sql);
      $statement->execute();

      $this->add_order_item($order_ID, $crop, $variety, $class, $order_quantity, $price_per_kg, $discount_price, $total_price);
    } else {

      $this->add_order_item($_SESSION['order'], $crop, $variety, $class, $order_quantity, $price_per_kg, $discount_price, $total_price);
    }
  }




















  function add_order_item($order_ID, $crop, $variety, $class, $order_quantity, $price_per_kg, $discount_price, $total_price)
  {
    global $con;
    $item_ID = $this->generate_user("item");



    $sql = "INSERT INTO `item`(`item_ID`, `order_ID`, `crop_ID`,
     `variety_ID`, `class`, `quantity`, `price_per_kg`, `discount_price`, 
     `total_price`) VALUES ('$item_ID','$order_ID','$crop','$variety','$class',
     '$order_quantity','$price_per_kg','$discount_price','$total_price')";

    $statement = $con->prepare($sql);
    $statement->execute();



    echo ("<script> alert('Item added to order');
      window.location='place_order.php';
      </script>");
  }

  /// update order

  function update_order()
  {

    $sql = "UPDATE `order_table` SET `order_ID`='[value-1]',`order_book_number`='[value-2]',
        `user_ID`='[value-3]',`customer_name`='[value-4]',`crop`='[value-5]',`variety`='[value-6]',
        `class`='[value-7]',`order_quantity`='[value-8]',`price_per_kg`='[value-9]',`total_price`='[value-10]' WHERE 1";
  }
  function  process_order()
  {
  }

  function delete_order()
  {
  }

  function process_receipt()
  {
  }































  // production stock in functions 



  function stock_in($creditor, $certificate, $farm, $status, $crop, $variety, $class, $source, $srn, $bincard, $bags, $quantity, $description, $supporting_dir, $user)
  {

    global $con;


    //  Checking if prices are set before adding stock in 

    if ($class == "pre_basic") {

      $temp_class = "buy_pre_basic";
    } else if ($class == "basic") {
      $temp_class = "buy_basic";
    } else if ($class == "certified") {
      $temp_class = "buy_certified";
    } else if ($class == "breeder") {
      $temp_class = "buy_breeder";
    }


    //calculate amount add stock in transaction 

    $sql = "SELECT * FROM 
    `price` WHERE `crop_ID` = '$crop' AND `variety_ID`= '$variety'";
    $result =  $con->query($sql);
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        $temp_amount = $row["$temp_class"];
      }

      if ($temp_amount > 0) {

        $calculated_amount = (int)$temp_amount * (int)$quantity;
        $transaction_price = (int)$temp_amount;
        $account_funds = "";
        $transaction_ID = $transaction_ID = $this->generate_user("transaction");
        $trans_type = "stock_in";



        $stock_ID = $this->generate_user("stock");
        $date = date("Y-m-d");
        $time = date("H:i:s");


        if ($source == "external") {

          $available_quantity = $quantity;
          $this->use_certificate($certificate, $available_quantity);
        } else if ($source == "internal") {

          $available_quantity =  $quantity;
          self::farm_update_order_status($farm, "stock_in");
        }


        $sql = "INSERT INTO `stock_in`(`stock_in_ID`, `user_ID`, `certificate_ID`, `farm_ID`,
         `creditor_ID`, `source`, `crop_ID`, `status`, `variety_ID`, `class`, `SLN`,
          `bincard`, `number_of_bags`, `quantity`, `used_quantity`, `available_quantity`,`processed_quantity`,`grade_outs_quantity`, `trash_quantity`,
           `description`, `supporting_dir`, `date`, `time`) VALUES ('$stock_ID','$user',
           '$certificate','$farm','$creditor','$source','$crop','$status','$variety','$class',
           '$srn','$bincard','$bags','$quantity',0,$available_quantity,0,0,0,'$description',
           '$supporting_dir','$date','$time')";

        $statement = $con->prepare($sql);
        $statement->execute();

        $temp_class = "";


        // register transaction 
        ///   update creditor funds account 
        $sql = "SELECT * FROM `creditor` WHERE `creditor_ID`='$creditor'";
        $result =  $con->query($sql);
        if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            $account_funds = $row["account_funds"];
          }
        }
        $temp_funds = $account_funds + $calculated_amount;

        $sql = "UPDATE `creditor` SET `account_funds`='$temp_funds' WHERE `creditor_ID`='$creditor'";
        $statement = $con->prepare($sql);
        $statement->execute();

        $this->stock_in_add_transaction($transaction_ID, $trans_type, $stock_ID, $creditor, $transaction_price, $calculated_amount, $user);
      } else {

        echo "Not set";
      }
    }
  }



  function stock_in_add_transaction($transaction_ID, $trans_type, $stock_ID, $creditor, $transaction_price, $calculated_amount, $user_ID)
  {


    $date = date("Y-m-d");
    $time = date("H:i:s");
    global $con;

    $sql = "INSERT INTO `transaction`(`transaction_ID`, `type`, `action_name`,
    `action_ID`, `C_D_ID`,`transaction_price`, `amount`, `trans_date`, `trans_time`, `trans_status`, `user_ID`) VALUES
    ('$transaction_ID','creditor_buy_back','$trans_type','$stock_ID','$creditor','$transaction_price','$calculated_amount',
    '$date','$time','payment_pending','$user_ID')";

    $statement = $con->prepare($sql);
    $statement->execute();
  }










  function use_certificate($certificateID, $quantity)
  {

    global $con;


    $sql = "UPDATE `certificate` SET `available_quantity`= available_quantity-$quantity WHERE `lot_number`='$certificateID'";

    $statement = $con->prepare($sql);
    $statement->execute();
  }


























  function update_stock_in($stockInId, $old_certificate, $new_certificate, $crop, $variety, $class, $srn, $binCardNumber, $numberOfBags, $newQuantity, $oldQuantity, $description, $fileDirectory, $creditorId, $status)
  {

    global $con;



    // $transAmount = $this->get_transacton_details($stockInId);
    // $certificate = $old_certificate;
    if ($status == 0) {
    } else if ($status == 4) {
      $this->stock_in_update_certificate($old_certificate, $new_certificate, $newQuantity, $oldQuantity);
    } else {

      $this->stock_in_update_transaction($creditorId, $stockInId, $newQuantity, $crop, $variety, $class);
      $this->stock_in_update_certificate($old_certificate, $new_certificate, $newQuantity, $oldQuantity);
    }



    //Checking status to see update type( != 41 restore and update creditor account, transaction and certificate)
    //Checking status to see update type( 4 restore old certificate and update new certificate)
    //Don't mind my code, at this point I'm starting to loose my sainity. 
    //Need some pussy !!!!!!!!!!!


    $sql = "UPDATE `stock_in` SET`crop_ID`='$crop',`variety_ID`='$variety',`class`='$class',`SLN`='$srn',`bincard`='$binCardNumber',`number_of_bags`='$numberOfBags',`quantity`='$newQuantity',`available_quantity`='$newQuantity',
      `description`='$description',`supporting_dir`='$fileDirectory',`certificate_ID`='$new_certificate' WHERE `stock_in_ID`='$stockInId'";
    $statement = $con->prepare($sql);
    if ($statement->execute()) {

      echo "success";
    }
  }



  //  Functions assisting the main stock in function
  // The first function is restoring creditor account funds, the calculating new transaction amount based on the updated details 

  function get_old_trans_details($stockInId)
  {

    global $con;


    $sql = "SELECT  `transaction_price`, `amount` FROM `transaction` WHERE `action_ID`='$stockInId'";
    $result =  $con->query($sql);
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        $amount = $row["amount"];
      }

      return $amount;
    }
  }


  function stock_in_update_transaction($creditorId, $stockInId, $quantity, $crop, $variety, $class)
  {

    global $con;
    $oldAmount = $this->get_old_trans_details($stockInId);

    //Restore old account funds amount

    $sql = "UPDATE `creditor` SET `account_funds`=account_funds-$oldAmount WHERE `creditor_ID`='$creditorId'";

    $statement = $con->prepare($sql);
    if ($statement->execute()) {

      ///After creditor account restored calculate new amount and update creditor and transaction with new details.
      //Getting transaction price and calculating the amount 

      if ($class == "pre_basic") {

        $temp_class = "buy_pre_basic";
      } else if ($class == "basic") {
        $temp_class = "buy_basic";
      } else if ($class == "certified") {
        $temp_class = "buy_certified";
      }

      $sql = "SELECT * FROM 
      `price` WHERE `crop_ID` = '$crop' AND `variety_ID`= '$variety'";
      $result =  $con->query($sql);
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          $transaction_price =  $row["$temp_class"];
        }
      }
      $new_amount = (int)$transaction_price * (int)$quantity;

      /// Adding new amount tom creditor account 

      $sql = "UPDATE `creditor` SET `account_funds`=account_funds+$new_amount WHERE `creditor_ID`='$creditorId'";

      $statement = $con->prepare($sql);
      if ($statement->execute()) {

        // updating transaction with new transaction price and amount

        $sql = "UPDATE `transaction` SET      
        `transaction_price`='$transaction_price',`amount`='$new_amount' 
       WHERE `action_ID`='$stockInId',";
      }
    }
  }

  function stock_in_update_certificate($old_certificate, $new_certificate, $newQuantity, $oldQuantity)
  {
    global $con;
    //  restore and update certificate 

    $sql = "UPDATE `certificate` SET `available_quantity`=available_quantity + $oldQuantity  WHERE `lot_number`='$old_certificate'";
    $statement = $con->prepare($sql);
    if ($statement->execute()) {
      $sql = "UPDATE `certificate` SET `available_quantity`=available_quantity - $newQuantity  WHERE `lot_number`='$new_certificate'";
      $statement = $con->prepare($sql);
      $statement->execute();
    }
  }




  function calculate_amount()
  {
  }


  function get_transacton_details($actionId)
  {

    global $con;

    $sql = "SELECT `transaction_ID`, `type`, `action_name`, `action_ID`, `C_D_ID`, `amount`, `trans_date`, `trans_time`, `trans_status`, `user_ID` FROM `transaction` WHERE `action_ID`='$actionId'";
    $result = $con->query($sql);
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        $amount = $row["amount"];
      }
      return $amount;
    }
  }


  //  Delete stock in entry 


  function delete_stock_in($creditor_id, $stock_in_id, $certificate, $quantity)
  {
    global $con;
    // get transaction amount
    (int)$amount = $this->get_transacton_details($stock_in_id);

    // Restore creditor funds account 
    $sql = "UPDATE `creditor` SET `account_funds`=account_funds-$amount WHERE `creditor_ID`='$creditor_id'";

    $statement = $con->prepare($sql);
    $statement->execute();

    // Restore certificate if seed is certified

    if ($certificate == "not_certified") {
    } else {

      $sql = "UPDATE `certificate` SET `available_quantity`=available_quantity + $quantity  WHERE `lot_number`='$certificate'";
      $statement = $con->prepare($sql);

      $statement->execute();
    }


    // Delete transaction 

    $sql = "DELETE FROM `transaction` WHERE transaction.action_ID ='$stock_in_id'";

    $statement = $con->prepare($sql);
    $statement->execute();

    // Delete entery 


    $sql = "DELETE FROM stock_in WHERE stock_in.stock_in_ID ='$stock_in_id'";
    $statement = $con->prepare($sql);
    $statement->execute();
    echo "deleted";
  }

  function delete_certificate($lot_number)
  {

    global $con;

    $sql = "DELETE FROM `certificate` WHERE `lot_number` ='$lot_number'";

    $statement = $con->prepare($sql);
    $statement->execute();
  }












  /// production: stock out function 
  //production: stock out function is updating the item table , stock in table and its inserting data in the stock out table 
  // data is inserted depending on the quantity of the item and the stock in which the item is being subtracted from


  function stock_out($item_ID, $stock_in_ID, $item_quantity, $stock_in_quantity, $order_ID, $amount)
  {

    $stock_out_ID = $this->generate_user('stock_out');
    $user_ID = $_SESSION['user'];
    $date = date("Y-m-d");
    $time = date("H:i:s");
    global $con;

    $intItemQuantity = (int) $item_quantity;
    $intStockInQuantity = (int) $stock_in_quantity;

    if ($intStockInQuantity >= $intItemQuantity) {



      $sql = "INSERT INTO `stock_out`(`stock_out_ID`, `item_ID`, `stock_in_ID`, `order_ID`, `Quntity`, `amount`, `date`, `time`, `user_ID`) VALUES
       ('$stock_out_ID','$item_ID','$stock_in_ID','$order_ID','$item_quantity',$amount,'$date','$time','$user_ID')";


      $statement = $con->prepare($sql);
      $statement->execute();

      $sql = "UPDATE `item` SET `status`='complete' WHERE `item_ID`='$item_ID'";

      $statement = $con->prepare($sql);
      $statement->execute();

      $sql = "UPDATE `stock_in` SET `used_quantity`='$item_quantity',`available_quantity`= available_quantity-'$item_quantity' WHERE`stock_in_ID`='$stock_in_ID'";

      $statement = $con->prepare($sql);
      $statement->execute();

      /// update item stock .... contradiction with the stock out table .. but will leave it as it is... maybe will refactor later

      $sql = "UPDATE `item` SET `stock_out_quantity`='$item_quantity' WHERE`item_ID`='$item_ID'";

      $statement = $con->prepare($sql);
      $statement->execute();
    } else if ($intItemQuantity >=  $intStockInQuantity) {





      $sql = "INSERT INTO `stock_out`(`stock_out_ID`, `item_ID`, `stock_in_ID`, `order_ID`, `Quntity`, `amount`, `date`, `time`, `user_ID`) VALUES
       ('$stock_out_ID','$item_ID','$stock_in_ID','$order_ID','$stock_in_quantity','$amount','$date','$time','$user_ID')";

      $statement = $con->prepare($sql);
      $statement->execute();

      $sql = "UPDATE `item` SET `status`='partly' WHERE `item_ID`='$item_ID'";

      $statement = $con->prepare($sql);
      $statement->execute();

      $sql = "UPDATE `stock_in` SET `used_quantity`='$stock_in_quantity',`available_quantity`='0' WHERE`stock_in_ID`='$stock_in_ID'";

      $statement = $con->prepare($sql);
      $statement->execute();


      /// update item stock .... contradiction with the stock out table .. but will leave it as it is... maybe will refactor later

      $sql = "UPDATE `item` SET `stock_out_quantity`='$item_quantity' WHERE`item_ID`='$item_ID'";

      $statement = $con->prepare($sql);
      $statement->execute();
    }
  }
















  //production Reverse stock out (reverse stock out transaction from order item) 
  function reverse_stock_out($stock_out_ID, $item_ID, $item_quantity, $stock_in_ID)
  {

    global $con;

    $sql = "UPDATE `item` SET `status`='not added' WHERE `item_ID`='$item_ID'";

    $statement = $con->prepare($sql);
    $statement->execute();

    $sql = "UPDATE `stock_in` SET `used_quantity`= used_quantity - '$item_quantity',`available_quantity`= available_quantity + '$item_quantity' WHERE`stock_in_ID`='$stock_in_ID'";

    $statement = $con->prepare($sql);
    $statement->execute();

    $sql = "DELETE FROM `stock_out` WHERE `stock_out_ID` = '$stock_out_ID'";

    $statement = $con->prepare($sql);
    $statement->execute();

    $sql = "UPDATE `item` SET `stock_out_quantity`= stock_out_quantity - '$item_quantity' WHERE`item_ID`='$item_ID'";

    $statement = $con->prepare($sql);
    $statement->execute();
  }








  ///production process order 

  function production_process_order($order_ID, $C_D_ID, $type, $printSave, $user)
  {


    global $con;
    $pdfType = "dispatch_note";
    $user_ID = $user;
    $date = date("Y-m-d");
    $time = date("H:i:s");
    $transaction_ID = $this->generate_user("transaction");
    $amount = "";
    $total_quantity = "";
    //step 0: pass data to dispatch note pdf function


    // step 1: update order to process

    $sql = "UPDATE `order_table` SET `status` ='processed' WHERE `order_ID` = '$order_ID'";

    $statement = $con->prepare($sql);
    $statement->execute();

    //step 2: calculate the total amount for the order

    $sql = "SELECT sum(amount) as total_amount,sum(Quntity) as total_quantity  FROM `stock_out`WHERE order_ID ='$order_ID'";

    $result = $con->query($sql);
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {

        $amount = $row["total_amount"];
        $total_quantity = $row["total_quantity"];
      }
    }


    //step 3: register transaction 

    $sql = "INSERT INTO `transaction`(`transaction_ID`, `type`, `action_ID`, `C_D_ID`, `amount`, 
    `trans_date`, `trans_time`, `trans_status`, `user_ID`) VALUES
     ('$transaction_ID','$type','$order_ID','$C_D_ID',
     '$amount','$date','$time','payment_pending','$user_ID')";

    $statement = $con->prepare($sql);
    $statement->execute();

    //step 4 deduct funds from customer account, call create pdf class for dispatch notes and delivery notes etc

    if ($type == "customer" || $type == "b_to_b_order" || $type == "agro_dealer_order") {




      $temp_amount = (int)$amount;

      $sql = "UPDATE `debtor` SET `account_funds`= account_funds-$temp_amount WHERE `debtor_ID`= '$C_D_ID'";

      $statement = $con->prepare($sql);
      $statement->execute();

      if ($printSave == "print") {

        ///header("Location:../class/pdf_handler.php? order_ID=$order_ID & transaction_ID=$transaction_ID & total_quantity=$total_quantity & type=$pdfType");
        $url = "../class/pdf_handler.php? order_ID=$order_ID & transaction_ID=$transaction_ID & total_quantity=$total_quantity & type=$pdfType";
        echo '<script>window.open("' . $url . '", "_blank");</script>';
      } else if ($printSave == "save") {

        header('location:stock_out.php');
      }
    } elseif ($type == "grower_order") {


      $temp_amount = (int)$amount;
      $sql = "UPDATE `creditor` SET `account_funds`=account_funds-$temp_amount WHERE `creditor_ID`= '$C_D_ID'";

      $statement = $con->prepare($sql);
      $statement->execute();

      self::farm_update_order_status(self::order_get_farm_id($order_ID), "order_processed");

      if ($printSave == "print") {
        $jsonArray = array("order_id" => "$order_ID", "transaction_id" => $transaction_ID, "total_quantity" => "$total_quantity", "pdfType" => "$pdfType");
        $file = "assets/JSON/dispatch_order_details.json";
        self::handle_json($file, $jsonArray);
      } else if ($printSave == "save") {

        header('location:stock_out.php');
      }
    }
  }



  static function farm_update_order_status($farm_id, $status)
  {
    global $con;


    $sql = "UPDATE `farm` SET `order_status`='$status' WHERE `farm_ID`='$farm_id'";

    $statement = $con->prepare($sql);
    $statement->execute();
  }

  static function order_get_farm_id($order_id)
  {
    global $con;

    $sql = "SELECT `order_ID`, `order_type`, `customer_id`, `customer_name`, `order_book_number`, `user_ID`, `status`, `date`, `time`, `count`, `total_amount`, `order_files`, `farm_id` FROM `order_table` WHERE `order_ID`='$order_id'";
    $result = $con->query($sql);

    while ($row = $result->fetch_assoc()) {
      $farm_id = $row["farm_id"];
    }
    return $farm_id;
  }





  static function handle_json($file, $jsonArray)
  {


    if (file_exists($file)) {

      $path = file_get_contents($file);
      $json_data[] = array(json_decode($path));


      if (!empty($json_data[0])) {

        unset($json_data[0]);

        $unsave = json_encode($json_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        if (file_put_contents($file, $unsave)) {
          $final_data = self::add_data($jsonArray);
          file_put_contents($file, $final_data);
        }
      } else {

        echo "
         error";
      }
    } else {

      echo "
         error";
    }
  }


  static function add_data($data)
  {
    $eco_data = json_encode($data);
    return $eco_data;
  }

  function admin_approval($approvalId, $department, $action_name, $action_id, $description, $requested_ID, $requested_name)
  {


    $date = date("Y-m-d");
    $time = date("H:i:s");
    global $con;

    $sql = "INSERT INTO `approval`(`approval_ID`, `depertment`, `action_name`, 
  `action_id`, `description`, `date`, `time`, `requested_id`, 
  `requested_name`) VALUES
   ('$approvalId','$department','$action_name','$action_id','$description',
   '$date','$time','$requested_ID','$requested_name')";

    $statement = $con->prepare($sql);
    $statement->execute();
  }










  /// Administrative Approval functions

  function admin_confirm_approval($approvalId, $approvalCode, $userId)
  {
    global $con;

    $sql = "UPDATE `approval` SET `approved_ID`='$userId',`approval_code`='$approvalCode' WHERE `approval_ID`='$approvalId'";
    $statement = $con->prepare($sql);
    $statement->execute();
  }


  function deny_acccess($approvalId)
  {
    global $con;
    $sql = "DELETE FROM `approval` WHERE `approval_ID`='$approvalId'";

    $statement = $con->prepare($sql);
    $statement->execute();
  }
  function admin_deny_requested_access($approvalId)
  {
    global $con;

    $sql = "DELETE FROM `approval` WHERE `approval`.`approval_ID` = '$approvalId'";
    $statement = $con->prepare($sql);
    $statement->execute();
  }





  /// ledger function
  function ledger_new_entry($ledger_type, $description, $amount, $bank_ID, $transaction_ID, $reference_amount, $custome)
  {
    global $con;
    $ledger_ID = $this->generate_user('ledger');
    $user_ID = $_SESSION['user'];
    $date = date("Y-m-d");
    $time = date("H:i:s");
    $amount_to_bank = intval($amount);
    $bank_reference_amount = $this->get_reference_amount($amount, $bank_ID, $ledger_type);


    if ($custome == "user") {

      $sql = "INSERT INTO `ledger`(`ledger_ID`, `ledger_type`, `description`,
    `amount`, `bank_ID`, `transaction_ID`, `user_ID`,
     `reference_bank_amount`, `entry_date`, `entry_time`) VALUES 
    ('$ledger_ID','$ledger_type','$description','$amount','$bank_ID',
    '$transaction_ID','$user_ID','$bank_reference_amount','$date','$time')";


      $statement = $con->prepare($sql);
      $statement->execute();
      if ($ledger_type == "debit") {

        $sql = "UPDATE `bank_account` SET 
        `account_funds`= account_funds+$amount_to_bank WHERE `bank_ID`='$bank_ID'";

        $statement = $con->prepare($sql);
        $statement->execute();

        header('Location:finance_ledger.php');
      } else if ($ledger_type == "credit") {




        $sql = "UPDATE `bank_account` SET 
        `account_funds`= account_funds-$amount_to_bank WHERE `bank_ID`='$bank_ID'";

        $statement = $con->prepare($sql);
        $statement->execute();

        header('Location:finance_ledger.php');
      }
    } else if ($custome == "system") {


      $sql = "INSERT INTO `ledger`(`ledger_ID`, `ledger_type`, `description`,
    `amount`, `bank_ID`, `transaction_ID`, `user_ID`,
     `reference_bank_amount`, `entry_date`, `entry_time`) VALUES 
    ('$ledger_ID','$ledger_type','$description','$amount','$bank_ID',
    '$transaction_ID','$user_ID','$bank_reference_amount','$date','$time')";


      $statement = $con->prepare($sql);
      $statement->execute();
    }
  }








  // get bank reference amount
  function get_reference_amount($ledger_trans_amount, $bank_account_id, $type)
  {
    global $con;
    $reference_amount = "";
    $account_funds = "";
    $sql = "SELECT  `account_funds` FROM `bank_account` WHERE `bank_ID` ='$bank_account_id'";

    $result = $con->query($sql);
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        $account_funds = $row["account_funds"];
      }
    }

    if ($type = "debit") {
      $reference_amount = (int)$ledger_trans_amount + (int)$account_funds;
    } else if ($type = "credit") {
      $reference_amount = (int)$ledger_trans_amount - (int)$account_funds;
    }
    return $reference_amount;
  }







  //add creditor function 
  function add_creditor($source, $name, $phone, $email, $description, $user, $status)
  {

    $creditor_ID = $this->generate_user("creditor");
    $date = date("Y-m-d");
    global $con;

    //  $sql="INSERT INTO `creditor`(`creditor_ID`, `source`, `name`, `phone`, `email`, `description`, `creditor_status`, `user_ID`, `creditor_files`, `registered_date`, `account_funds`) VALUES
    // //   ('[value-1]','[value-2]','[value-3]','[value-4]','[value-5]','[value-6]','[value-7]','[value-8]','[value-9]','[value-10]','[value-11]')";

    $sql = "INSERT INTO `creditor`(`creditor_ID`, `source`, `name`, `phone`, `email`, `description`, `user_ID`,`registered_date`, `account_funds`,`creditor_status`) VALUES
  ('$creditor_ID','$source','$name','$phone','$email','$description','$user','$date',0,'$status')";


    $statement = $con->prepare($sql);
    $statement->execute();


    return ["added", $creditor_ID];

    // if ($source == "External") {
    //   header('Location:stock_in.php');
    // } else {

    //   header('Location:grower.php');
    // }
  }

  //Update creditor 



  function update_grower($grower_id, $grower_name, $phone, $email, $file_directory)
  {
    global $con;
    $sql = "UPDATE `creditor` SET `name`='$grower_name',`phone`='$phone',`email`='$email' WHERE `creditor_ID`='$grower_id'";
    $statement = $con->prepare($sql);
    if ($statement->execute()) {

      $season = $this->get_season();
      // Update contract file
      $sql = "UPDATE `contract` SET `dir`='$file_directory' WHERE `season`='$season' AND `grower`='$grower_id'";
      $statement = $con->prepare($sql);
      $statement->execute();

      return 'updated';
    }
  }


  // Activate inactive grower
  function activate_grower($grower_id, $file_directory, $user)
  {


    global $con;
    $sql = "UPDATE `creditor` SET `creditor_status`='active' WHERE `creditor_ID`='$grower_id'";
    $statement = $con->prepare($sql);
    $statement->execute();

    $return_data = $this->register_contract($grower_id, $user, "grower", $file_directory);

    if ($return_data == "grower_registered") {
      return "activated";
    } else {
      return "error";
    }
  }






  function get_season()
  {
    global $con;

    $sql = "SELECT max(season) AS season FROM growing_season";
    $result = $con->query($sql);
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        $season = $row['season'];
      }
      return $season;
    }
  }

  function register_contract($creditor_id, $user_id, $type, $contract_directory)
  {

    global $con;
    $contract_ID = $this->generate_user("contract");
    $season = $this->get_season();


    $sql = "INSERT INTO `contract`(`contract_ID`, `season`, `type`, `grower`, `dir`, `user_ID`) VALUES 
    ('$contract_ID','$season','$type','$creditor_id','$contract_directory','$user_id')";

    // echo  $creditor_id,$user_id,$type,$contract_directory;

    $statement = $con->prepare($sql);
    $statement->execute();
    echo "grower_registered";
  }


  // function check_season_closing()
  // {



  //   //$season = $this->get_season();
  //   global $con;
  //   // get colosing date 
  //   $sql = "SELECT opening_date,closing_date FROM growing_season WHERE season='$season'";
  //   $result = $con->query($sql);

  //   if ($result->num_rows > 0) {
  //     while ($row = $result->fetch_assoc()) {
  //       $closing_date = $row['closing_date'];
  //       $opening_date = $row['opening_date'];
  //     }

  //     $target_date = '2023-06-01';
  //     $current_date = date('Y-m-d');


  //     $target_timestamp = strtotime($closing_date);
  //     $current_timestamp = strtotime($current_date);

  //     if ($target_timestamp < $current_timestamp) {
  //       $this->deactivate_growers($season);
  //       $this->create_new_season($opening_date, $closing_date);
  //     }
  //   }
  // }




  function deactivate_growers($season)
  {

    global $con;
    // getting all expired contracts

    $sql = "SELECT creditor_ID FROM creditor INNER JOIN contract ON contract.grower = creditor.creditor_ID INNER JOIN growing_season ON growing_season.season = contract.season WHERE growing_season.season='$season'";
    $result = $con->query($sql);
    //   Update all expired grower
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        $creditors[] = $row['creditor_ID'];
      }
      foreach ($creditors as $id) {
        $sql = "UPDATE `creditor` SET `creditor_status`='inactive' WHERE `creditor_ID`='$id'";

        $statement = $con->prepare($sql);
        $statement->execute();
      }
    }



    // New season when max season expire
  }


  function create_new_season($opening_date, $closing_date)
  {
    global $con;
    $date = date("Y");
    $int_value = (int)$date + 1;
    $season = $date . "-" . $int_value;
    $sql = "INSERT INTO `growing_season`(`season`, `opening_date`, `closing_date`) VALUES ('$season','$opening_date','$closing_date')";

    $statement = $con->prepare($sql);
    $statement->execute();
  }

  //  Update seaso details 


  function update_business($name, $country, $physical_address, $logo_drectory)
  {

    global $con;
    $sql = "UPDATE `client` SET `business_name`='$name',`country`='$country',`physical_address`='$physical_address'";
    $statement = $con->prepare($sql);
    if ($statement->execute()) {

      return "updated";
    }
  }

  // save business logo image

  static function save_logo($image)
  {

    global $con;
    $sql = "UPDATE `client` SET `logo`='$image'";
    $statement = $con->prepare($sql);
    if ($statement->execute()) {

      return "saved";
    }
  }

  function update_season($opening_date, $closing_date)
  {

    global $con;
    $season = "";


    $sql = "SELECT max(season) AS season FROM growing_season";

    $result = $con->query($sql);
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        $season = $row["season"];
      }

      $date = date("Y");
      $int_value = (int)$date + 1;
      $season = $date . "-" . $int_value;

      $sql = "UPDATE `growing_season` SET `season`='$season',`opening_date`='$opening_date',`closing_date`='$closing_date'";

      $statement = $con->prepare($sql);
      $statement->execute();
    }
  }









  // production certicate functions 


  static function add_certificate($lot_number, $crop, $variety, $class, $type, $source, $source_name, $date_tested, $expire_date, $certificate_quantity, $directory, $user)
  {

    $added_date = date("Y-m-d");
    global $con;

    if (self::check_ids("certificate", "lot_number", $lot_number)) {
      return 'lot_number already exists';
    } else {

      $sql = "INSERT INTO `certificate`(`lot_number`, `crop_ID`, `variety_ID`, `class`, `type`, `source`, 
      `source_name`, `date_tested`, `expiry_date`, `date_added`, `certificate_quantity`, 
      `available_quantity`, `assigned_quantity`, `status`, `directory`, `user_ID`) VALUES 
      ('$lot_number','$crop','$variety','$class','$type','$source','$source_name',
      '$date_tested','$expire_date','$added_date','$certificate_quantity',
      '$certificate_quantity','$certificate_quantity','available','$directory','$user')";

      $statement = $con->prepare($sql);

      if ($statement->execute()) {

        return "registered";
      } else {

        return "error ";
      }
    }
  }


  //  checking if ids already exists 


  static function check_ids($table_name, $id_title, $id_value)
  {
    global $con;

    $sql = "SELECT * FROM `" . $table_name . "` WHERE `" . $id_title . "` ='$id_value'";
    $result =  $con->query($sql);
    if ($result->num_rows > 0) {

      return true;
    } else {
      return false;
    }
  }




  //production register grower's farm


  function register_farm(
    $hectors,
    $crop,
    $variety,
    $class,
    $region,
    $district,
    $area_name,
    $address,
    $physical_address,
    $epa,
    $grower_ID,
    $previous_year,
    $other_year,
    $main_certificate,
    $main_quantity,
    $male_certificate,
    $male_quantity,
    $female_certificate,
    $female_quantity,
    $user,
    $hybrid_type

  ) {



    $farm_ID = $this->generate_user("farm");
    $registered_date = date("Y-m-d");

    global $con;

    if (!empty('$main_quantity')) {

      $sql = "INSERT INTO `farm`(`farm_ID`, `Hectors`, `crop_species`, 
      `crop_variety`, `class`, `region`, `district`, `area_name`,
       `address`, `physical_address`, `EPA`, `user_ID`, `creditor_ID`, 
       `registered_date`, `previous_year_crop`, `other_year_crop`, `order_status`,
        `main_lot_number`, `main_quantity`, `male_lot_number`, `male_quantity`,
         `female_lot_number`, `female_quantity`,`breeding_type`) VALUES ('$farm_ID','$hectors',
         '$crop','$variety','$class','$region','$district','$area_name',
         '$address','$physical_address','$epa','$user','$grower_ID','$registered_date','$previous_year',
         '$other_year','unconfirmed','$main_certificate','$main_quantity','$male_certificate','$male_quantity','$female_certificate','$female_quantity','$hybrid_type')";



      $statement = $con->prepare($sql);
      $statement->execute();


      if ($hybrid_type == "-") {

        $newMainQuantity = (int)$main_quantity;

        $sql = "UPDATE `certificate` SET `assigned_quantity`=assigned_quantity-$newMainQuantity WHERE `lot_number`='$main_certificate'";
        $statement = $con->prepare($sql);
        $statement->execute();
      } else  if ($hybrid_type == "hybrid_inbred") {



        $newMaleQuantity = (int)$male_quantity;
        $newFemaleQuantity = (int)$female_quantity;



        $sql = "UPDATE `certificate` SET `assigned_quantity`=assigned_quantity-$newMaleQuantity WHERE `lot_number`='$male_certificate'";
        $statement = $con->prepare($sql);
        $statement->execute();


        $sql = "UPDATE `certificate` SET `assigned_quantity`=assigned_quantity-$newFemaleQuantity WHERE `lot_number`='$female_certificate'";
        $statement = $con->prepare($sql);
        $statement->execute();
      }

      if ($statement = true) {

        return "added";
      } else {
        return "Error";
      }
    }
  }


  // function updating certificate quantity after registering farm 



  function change_assigned_certificate_quantity(
    $hybrid_type,
    $main_lot_number,
    $main_quantity,
    $male_lot_number,
    $male_quantity,
    $female_lot_number,
    $female_quantity,
    $variety
  ) {

    global $con;

    if ($hybrid_type == "hybrid_inbred") {



      $newMaleQuantity = (int)$male_quantity;
      $newFemaleQuantity = (int)$female_quantity;



      $sql = "UPDATE `certificate` SET `assigned_quantity`=assigned_quantity-$newMaleQuantity WHERE `lot_number`='$male_lot_number'";
      $statement = $con->prepare($sql);
      $statement->execute();


      $sql = "UPDATE `certificate` SET `assigned_quantity`=assigned_quantity-$newFemaleQuantity WHERE `lot_number`='$female_lot_number'";
      $statement = $con->prepare($sql);
      $statement->execute();
    } else if ($hybrid_type == "-") {



      $newMainQuantity = (int)$main_quantity;

      $sql = "UPDATE `certificate` SET `assigned_quantity`=assigned_quantity-$newMainQuantity WHERE `lot_number`='$main_lot_number'";
      $statement = $con->prepare($sql);
      $statement->execute();
    }
  }

  //  Update registered farm 





  function update_farm(

    $hectors,
    $crop,
    $variety,
    $class,
    $region,
    $district,
    $area_name,
    $address,
    $physical_address,
    $epa,
    $farm_ID,
    $previous_year,
    $other_year,
    $main_certificate,
    $main_quantity,
    $male_certificate,
    $male_quantity,
    $female_certificate,
    $female_quantity,
    $user,
    $hybrid_type,
    $old_main_certificate,
    $old_main_quantity,
    $old_male_certificate,
    $old_male_quantity,
    $old_female_certificate,
    $old_female_quantity,
    $old_hybrid_type



  ) {
    global $con;

    $sql = "UPDATE `farm` SET `Hectors`='$hectors',`crop_species`='$crop',
    `crop_variety`='$variety',`class`='$class',`region`='$region',`district`='$district',
    `area_name`='$area_name',`address`='$address',`physical_address`='$physical_address',`EPA`='$epa',
    `previous_year_crop`='$previous_year',`other_year_crop`='$other_year',
    `main_lot_number`='$main_certificate',`main_quantity`='$main_quantity',
    `male_lot_number`='$male_certificate',`male_quantity`='$male_quantity',`female_lot_number`='$female_certificate',`female_quantity`='$female_quantity',`breeding_type`='$hybrid_type' WHERE `farm_ID`='$farm_ID'";

    $statement = $con->prepare($sql);
    if ($statement->execute()) {

      $old_certificate = [$old_main_certificate, $old_main_quantity, $old_male_certificate, $old_male_quantity, $old_female_certificate, $old_female_quantity];
      $new_certificate = [$main_certificate, $main_quantity, $male_certificate, $male_quantity, $female_certificate, $female_quantity];

      self::restore_assigned_seed_certificates($old_hybrid_type, $old_certificate);
      self::assign_farm_certificate_quantity($hybrid_type, $new_certificate);

      return  "updated";
    } else {
      return "Error";
    }
  }




  function delete_farm(
    $farm_ID,
    $old_hybrid_type,
    $old_main_certificate,
    $old_main_quantity,
    $old_male_certificate,
    $old_male_quantity,
    $old_female_certificate,
    $old_female_quantity


  ) {
    global $con;

    $sql = "DELETE FROM `farm` WHERE `farm_ID`='$farm_ID'";
    $statement = $con->prepare($sql);
    if ($statement->execute()) {
      $old_certificate = [$old_main_certificate, $old_main_quantity, $old_male_certificate, $old_male_quantity, $old_female_certificate, $old_female_quantity];
      self::restore_assigned_seed_certificates($old_hybrid_type, $old_certificate);

      return "deleted";
    }
  }







  //    restoring assigned quantity to old certificates after updating farm details

  static function restore_assigned_seed_certificates(
    $hybrid_type,
    $old_certificates

  ) {

    global $con;
    if ($hybrid_type == "-") {

      $oldMainQuantity = (int)$old_certificates[1];

      $sql = "UPDATE `certificate` SET `assigned_quantity`=assigned_quantity+$oldMainQuantity WHERE `lot_number`='$old_certificates[0]'";
      $statement = $con->prepare($sql);
      $statement->execute();
    } else  if ($hybrid_type == "hybrid_inbred") {



      $oldMaleQuantity = (int)$old_certificates[3];
      $oldFemaleQuantity = (int)$old_certificates[5];
      $sql = "UPDATE `certificate` SET `assigned_quantity`=assigned_quantity+$oldMaleQuantity WHERE `lot_number`='$old_certificates[2]'";
      $statement = $con->prepare($sql);
      $statement->execute();


      $sql = "UPDATE `certificate` SET `assigned_quantity`=assigned_quantity+$oldFemaleQuantity WHERE `lot_number`='$old_certificates[4]'";
      $statement = $con->prepare($sql);
      $statement->execute();
    }
  }


  // assign new certificate quntities after registering or updating farm details

  static function assign_farm_certificate_quantity(
    $hybrid_type,
    $new_certificates
  ) {

    global $con;
    if ($hybrid_type == "-") {

      $newMainQuantity = (int)$new_certificates[1];

      $sql = "UPDATE `certificate` SET `assigned_quantity`=assigned_quantity-$newMainQuantity WHERE `lot_number`='$new_certificates[0]'";
      $statement = $con->prepare($sql);
      $statement->execute();
    } else  if ($hybrid_type == "hybrid_inbred") {



      $newMaleQuantity = (int)$new_certificates[3];
      $newFemaleQuantity = (int)$new_certificates[5];
      $sql = "UPDATE `certificate` SET `assigned_quantity`=assigned_quantity-$newMaleQuantity WHERE `lot_number`='$new_certificates[2]'";
      $statement = $con->prepare($sql);
      $statement->execute();


      $sql = "UPDATE `certificate` SET `assigned_quantity`=assigned_quantity-$newFemaleQuantity WHERE `lot_number`='$new_certificates[4]'";
      $statement = $con->prepare($sql);
      $statement->execute();
    }
  }




  function grower_order_price($crop, $variety, $class)
  {

    global $con;

    $sql = "SELECT `prices_ID`, `crop_ID`, 
   `variety_ID`, `sell_basic`,
    `sell_pre_basic`, 
    `sell_certified`,
     `buy_basic`,
     `buy_pre_basic`, `buy_certified` FROM `price` WHERE `crop_ID` ='$crop' AND `variety_ID`='$variety'";

    $result = $con->query($sql);
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        $basic = $row['sell_basic'];
        $pre_basic = $row['sell_pre_basic'];
      }

      if ($class == "certified") {


        return $basic;
      } else if ($class == "basic") {

        return $pre_basic;
      }
    }
  }




  // assign ungraded seed for processing

  static function assign_processing_quantity($stock_in_id, $assigned_quantity, $user)
  {



    global $con;
    $grade_ID = self::generate_user("grade_seed");
    $user_ID = $user;
    $date = date("Y-m-d");
    $time = date("H:i:s");
    $pdfType = "handover";
    $total_quantity = "";
    $stock_in_quantity = "";


    //Checking if all graded seed quantity are less than or equal to stock_in quantity

    $sql = "SELECT SUM(assigned_quantity) AS total_graded, stock_in.quantity FROM `grading`
    INNER JOIN stock_in ON stock_in.stock_in_ID = grading.stock_in_ID WHERE grading.stock_in_ID = '$stock_in_id'";

    $result = $con->query($sql);
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        $total_quantity = $row['total_graded'];
        $stock_in_quantity = $row['quantity'];
      }
      // echo ("<script> alert('$total_quantity.$stock_in_quantity');
      // window.location='process_seed.php';
      // </script>");

      $stock = (int)$stock_in_quantity;
      $total = (int)$total_quantity + (int)$assigned_quantity;

      if ($total > $stock) {

        //echo ("<scriTY\t> alert('$stock.$total'); </script>");

        return "quantity_exceeded";
      } else {
        $sql = "INSERT INTO `grading`(`grade_ID`, `assigned_date`, `assigned_time`, `assigned_quantity`, `used_quantity`, `available_quantity`, `stock_in_ID`,
          `assigned_by`, `received_ID`, `received_name`, `status`, `file_directory`) VALUES 
          ('$grade_ID','$date','$time','$assigned_quantity','0','$assigned_quantity','$stock_in_id','$user_ID','-','-','unconfirmed','-')";

        $statement = $con->prepare($sql);
        $statement->execute();

        // update stock in available quantity by subtracting assigned quantity with available 

        if ($total == $stock) {

          main::update_stockIn_grading_status($stock_in_id, "handover_pending");
        }

        if ($total < $stock) {

          main::update_stockIn_grading_status($stock_in_id, "partly_assigned");
        }


        // create PDF file for assigned seed

        echo $grade_ID;
      }
    }
  }

  static function update_stockIn_grading_status($stock_in_id, $status)
  {

    global $con;

    $sql = "UPDATE `stock_in` SET `status`='$status' WHERE `stock_in_ID`='$stock_in_id'";
    $statement = $con->prepare($sql);
    if ($statement->execute()) {

      echo "updated" . $stock_in_id;
    }
  }

  static function handover_conformation($receive_id, $received_name, $file_directory, $grade_id, $passed_quantity, $stock_in_ID)
  {
    global $con;

    $sql = "UPDATE `grading` SET `received_ID`='$receive_id',
    `received_name`='$received_name',`status`='unprocessed',
    `file_directory`='$file_directory' WHERE `grade_ID`='$grade_id'";
    $statement = $con->prepare($sql);
    if ($statement->execute()) {

      echo "successful";
    };




    // Check if all stock_in quantity has been assigned for processing, if so update the status to unprocesssed 
    $checkStatus = self::checkProcessStatus($stock_in_ID, "unprocessed");
    if ((int)$checkStatus[0] + (int)$passed_quantity == (int)$checkStatus[1]) {
      self::update_stockIn_grading_status($stock_in_ID, "uprocessed");
    }
    // $sql = "UPDATE `stock_in` SET `processed_quantity`='$passed_quantity' WHERE `stock_in_ID` = '$stock_in_ID'";
    // $statement = $con->prepare($sql);
    // $statement->execute();
  }


  static function checkProcessStatus($stock_in_id, $stage)
  {
    global $con;
    $sql = "SELECT SUM(assigned_quantity) AS total_graded, stock_in.quantity FROM `grading`
    INNER JOIN stock_in ON stock_in.stock_in_ID = grading.stock_in_ID WHERE grading.stock_in_ID = '$stock_in_id' AND grading.status='$stage'";

    $result = $con->query($sql);
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        $total_quantity = $row['total_graded'];
        $stock_in_quantity = $row['quantity'];
      }

      return [$total_quantity, $stock_in_quantity];
    }
  }





  // clean and process seed

  function process_seed($grade_ID, $type, $assigned_quantity, $grade_outs_quantity, $trash_quantity, $available_quantity, $process_ID, $passed_process_type_id)
  {


    $process_type_ID = $this->generate_user("pr_type");
    global $con;

    //Check if all processed transaction are greater are not more than the stock in quantity 

    // $sql="SELECT SUM(assigned_quantity) AS total_processed FROM `process_seed`WHERE `process_ID` =''";


    // echo("<script>$available_quantity</script>");




    if ($type == "Cleaning ") {



      $process_ID = $this->generate_user("process");

      $user = $_SESSION['user'];
      $process_date = date("Y-m-d");
      $process_time = date("H:i:s");

      // update available quantity in gr
      $this->update_available_quantity_grading($grade_ID, $available_quantity, $assigned_quantity);

      $sql = "INSERT INTO `process_seed`(`process_ID`, `assigned_quantity`, `processed_date`, `processed_time`, `grade_ID`, `user_ID`) VALUES 
          ('$process_ID','$assigned_quantity','$process_date','$process_time','$grade_ID','$user')";

      $statement = $con->prepare($sql);
      $statement->execute();


      $processed_quantity = $this->get_processed_quantity($trash_quantity, $grade_outs_quantity, $assigned_quantity);

      $sql = "INSERT INTO `process_type`(`process_type_ID`, `process_ID`, `grade_outs_quantity`, `processed_quantity`, `trash_quantity`, `process_type`) 
        VALUES ('$process_type_ID','$process_ID','$grade_outs_quantity','$processed_quantity','$trash_quantity','$type')";

      $statement = $con->prepare($sql);
      $statement->execute();
      $this->update_available_quantity_grading($grade_ID, $available_quantity, $assigned_quantity);

      echo ("<script> alert('saved!');
       window.location='process_seed.php';
       </script>");
    } else {

      $processed_quantity = $this->get_processed_quantity($trash_quantity, $grade_outs_quantity, $assigned_quantity);


      // update cleaning status (i was lazy at the end)

      // FIY this was not even close to the end 


      $sql = "UPDATE `process_type` SET
        `process_type`='Cleaning_' WHERE `process_type_ID`='$passed_process_type_id'";
      $statement = $con->prepare($sql);
      $statement->execute();

      $sql = "INSERT INTO `process_type`(`process_type_ID`, `process_ID`, `grade_outs_quantity`, `processed_quantity`, `trash_quantity`, `process_type`) 
        VALUES ('$process_type_ID','$process_ID','$grade_outs_quantity','$processed_quantity','$trash_quantity','$type')";

      $statement = $con->prepare($sql);
      $statement->execute();

      $sql = "UPDATE `stock_in` INNER JOIN grading ON grading.stock_in_ID = stock_in.stock_in_ID INNER JOIN process_seed ON
       process_seed.grade_ID = grading.grade_ID SET stock_in.status = 'uncertified' WHERE process_seed.process_ID='$process_ID'";

      $statement = $con->prepare($sql);
      $statement->execute();

      echo ("<script> alert('saved!');
      window.location='process_seed.php';
      </script>");
    }
  }


  function get_processed_quantity($trash_quantity, $grade_outs_quantity, $assigned_quantity)
  {
    $t = (int)$trash_quantity + (int)$grade_outs_quantity;
    $processed_quantity = (int)$assigned_quantity - $t;
    return $processed_quantity;
  }




  function update_available_quantity_grading($grade_id, $available_quantity, $assigned_quantity)
  {

    global $con;
    $new_available_quantity = (int)$available_quantity - (int)$assigned_quantity;
    $sql = "UPDATE `grading` SET `available_quantity`=' $new_available_quantity' WHERE `grade_ID`='$grade_id'";

    $statement = $con->prepare($sql);
    $statement->execute();
  }








  // function register inspection log 




  ///change date format from yyyy-mm-dd to dd-mm-yyyy

  static function change_date_format($date)
  {
    $date = date_create($date);
    $date = date_format($date, "d-m-Y");
    return $date;
  }


  function register_inspection()
  {



    $sql = "INSERT INTO `inspection`(`inspection_ID`, `date`, `time`, `farm_ID`,
  `user_ID`, `type`, `isolation`, `planting_pattern`, `off_type_percetage`,
   `pest_disease_incidence`, `defective_plants`, `pollinating_females_percentage`,
    `female_receptive_skills_percentage`, `male_leimination`, `off_type_cobs_at_shelling`, 
    `defective_cobs_at_shelling`, `remarks`, `image_directory`) VALUES ('[value-1]','[value-2]',
    '[value-3]','[value-4]','[value-5]','[value-6]','[value-7]','[value-8]','[value-9]','[value-10]',
    '[value-11]','[value-12]','[value-13]','[value-14]','[value-15]','[value-16]','[value-17]','[value-18]')";
  }

















  // function register lab test

  function register_lab_test($stock_ID, $germ_perc, $shell_perc, $purity_perc, $defects_perc, $moisture_content, $oil_content, $grade, $crop, $variety, $farm)
  {


    $sql = "SELECT `test_ID`, `test_status` FROM `lab_test` WHERE stock_in_ID ='$stock_ID' AND test_status='active' ";

    global $con;
    $result =  $con->query($sql);
    if ($result->num_rows > 0) {

      echo ("<script> alert('action failed (test is already active)');
      </script>");
      $nn = 1;
      if ($nn == 1) {

        header('Location:new_test.php');
      }
    } else {


      $status = '';
      if ($grade == 'passed') {

        $status = 'active';
      } elseif ($grade == 'failed') {

        $status = 'inactive';
      }

      $test_ID = $this->generate_user("test");
      $test_date = date("Y-m-d");
      $test_time = date("H:m:i");
      $user_ID = $_SESSION['user'];
      global $con;






      $sql = "INSERT INTO `lab_test`(`test_ID`, `date`, `time`, `crop_ID`, `variety_ID`, 
      `farm_ID`, `germination_percentage`, `moisture_content`, `oil_content`,
       `shelling_percentage`, `purity_percentage`, `defects_percentage`, `grade`,
       `stock_in_ID`, `user_ID`, `test_status`) VALUES ('$test_ID','$test_date',
      '$test_time','$crop','$variety','$farm','$germ_perc','$moisture_content','$oil_content','$shell_perc','$purity_perc','$defects_perc',
      '$grade','$stock_ID','$user_ID','$status')";



      $statement = $con->prepare($sql);
      $statement->execute();
      header('Location:new_test.php');
    }
  }


















  /// marketing functions 

  // register agro dealer 
  static function add_agro_dealer($name, $phone, $email, $debtor_type, $debtor_files)
  {


    if (!empty($name)) {

      $sql = "SELECT * FROM `debtor` WHERE `name` = '$name'";

      global $con;
      $result =  $con->query($sql);
      if ($result->num_rows > 0) {

        echo ("<script> alert('agro dealer name already registered');
      </script>");
      } else {

        $agro_dealer_ID = self::generate_user("debtor");
        $user_ID = $_SESSION['user'];
        $register_date = date("Y-m-d");

        global $con;


        $sql = "INSERT INTO `debtor`(`debtor_ID`, `name`, `phone`, `email`, `description`, `debtor_type`, `user_ID`, `debtor_files`, `registered_date`,`account_funds`) 
      VALUES ('$agro_dealer_ID','$name','$phone','$email','-','$debtor_type','$user_ID','$debtor_files','$register_date',0)";

        $statement = $con->prepare($sql);
        $statement->execute();

        header('Location:agro_dealer.php');
      }
    }
  }


















  //register b_to_b

  function register_B_to_B($name, $description, $phone, $email, $debtor_type, $debtor_files)
  {


    if (!empty($name)) {



      $sql = "SELECT * FROM `debtor` WHERE `name` = '$name' AND `debtor_type` = 'b_to_b'";

      global $con;
      $result =  $con->query($sql);
      if ($result->num_rows > 0) {

        echo ("<script> alert('Business name already registered');
     </script>");
      } else {

        $agro_dealer_ID = $this->generate_user("debtor");
        $user_ID = $_SESSION['user'];
        $register_date = date("Y-m-d");
        global $con;


        $sql = "INSERT INTO `debtor`(`debtor_ID`, `name`, `phone`, `email`, `description`, `debtor_type`, `user_ID`, `debtor_files`, `registered_date`,`account_funds`) 
     VALUES ('$agro_dealer_ID','$name','$phone','$email','$description','$debtor_type','$user_ID','$debtor_files','$register_date',0)";

        $statement = $con->prepare($sql);
        $statement->execute();

        header('Location:b_to_b.php');
      }
    }
  }







  //register customer 
  function register_customer($name, $phone)
  {



    $customer_ID = $this->generate_user("debtor");
    $user_ID = $_SESSION['user'];
    $register_date = date("Y-m-d");
    global $con;

    $sql = "INSERT INTO `debtor`(`debtor_ID`, `name`, `phone`, `debtor_type`, `user_ID`,`registered_date`,`account_funds`) VALUES 
      ('$customer_ID','$name','$phone','customer','$user_ID','$register_date',0)";

    $statement = $con->prepare($sql);
    $statement->execute();
  }


  /// add payment 
















  function add_debtor_payment($type, $amount, $dir, $user_id, $transaction_id, $debtor_id, $trans_amount, $trans_status, $cheque_number, $bank_name, $account_name, $description, $save_type, $company_bank_account)
  {

    global $con;
    $payed_amount = "";
    $transaction_amount = "";
    $pdfType = "receipt";

    $newAmount = (int) $amount;
    $newTransAmount = (int) $trans_amount;

    $order_id = "";
    $date = date("Y-m-d");
    $time = date("H:m:i");
    $update_status = "";
    $payment_ID = $this->generate_user("payment");

    $sql = "SELECT * FROM `transaction` WHERE `transaction_ID`='$transaction_id'";

    $result = $con->query($sql);
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {

        $order_id = $row["action_ID"];
      }
    }

    if ($trans_status == "payment_pending") {
      /// adding new payment

      $sql = "INSERT INTO `payment`(`payment_ID`, `type`, `amount`, `description`, `documents`, `cheque_number`, `bank_name`, `account_name`,`date`, `time`, `user_ID`, `transaction_ID`) VALUES 
      ('$payment_ID','$type','$amount','$description','$dir','$cheque_number','$bank_name','$account_name','$date','$time','$user_id','$transaction_id')";


      $statement = $con->prepare($sql);
      $statement->execute();
      /// checking payment amount and type 

      if ($newAmount < $newTransAmount) {
        $update_status = "partly_payed";
      } else if ($newAmount >= $newTransAmount) {
        $update_status = "fully_payed";
      }

      // update transaction status 

      $sql = "UPDATE transaction SET `trans_status`='$update_status' WHERE `transaction_ID`='$transaction_id'";
      $statement = $con->prepare($sql);
      $statement->execute();

      //update debtor funds 

      $sql = "UPDATE debtor set `account_funds` =`account_funds`+'$amount' WHERE `debtor_ID`='$debtor_id'";
      $statement = $con->prepare($sql);
      $statement->execute();

      //update bank_account
      $sql = "UPDATE `bank_account` SET `account_funds`=`account_funds`+$amount WHERE `bank_ID`='$company_bank_account'";

      $statement = $con->prepare($sql);
      $statement->execute();

      // update ledger 
      $this->ledger_new_entry("credit", $description, $amount, $company_bank_account, $transaction_id, $amount, "system");

      if ($save_type == "save") {
        header('Location:add_payment.php');
      } else {
        header("Location:../class/pdf_handler.php? order_id=$order_id & debtor_id=$debtor_id & total=$trans_amount & payment_id=$payment_ID & type=$pdfType");
      }
      //header("Location:../class/pdf_handler.php? order_id=$order_id & debtor_id=$debtor_id & total=$trans_amount & payment_id=$payment_ID");
      // header('Location:add_payment.php');


      //generate payment receipt pdf

















    } else if ($trans_status == "partly_payed") {


      $sql = "SELECT sum(amount) as total_amount FROM `payment`WHERE transaction_Id ='$transaction_id'";

      $result = $con->query($sql);
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {

          $total_payment_amount = $row["total_amount"];
        }

        $balance = $total_payment_amount - $amount;
      }
      if ($balance = $amount) {

        $update_status = "fully_payed";

        $sql = "INSERT INTO `payment`(`payment_ID`, `type`, `amount`, `description`, `documents`, `cheque_number`, `bank_name`, `account_name`,`date`, `time`, `user_ID`, `transaction_ID`) VALUES 
          ('$payment_ID','$type','$amount','$description','$dir','$cheque_number','$bank_name','$account_name','$date','$time','$user_id','$transaction_id')";


        $statement = $con->prepare($sql);
        $statement->execute();



        // update transaction status 

        $sql = "UPDATE transaction SET `trans_status`='$update_status' WHERE `transaction_ID`='$transaction_id'";
        $statement = $con->prepare($sql);
        $statement->execute();

        //update debtor funds 

        $sql = "UPDATE debtor set `account_funds` =`account_funds`+'$amount' WHERE `debtor_ID`='$debtor_id'";
        $statement = $con->prepare($sql);
        $statement->execute();

        if ($save_type == "save") {
          header('Location:add_payment.php');
        } else {
          header("Location:../class/pdf_handler.php? order_id=$order_id & debtor_id=$debtor_id & total=$trans_amount & payment_id=$payment_ID & type=$pdfType");
        }
      } else if ($amount < $balance) {

        $update_status = "partly_payed";

        $sql = "INSERT INTO `payment`(`payment_ID`, `type`, `amount`, `description`, `documents`, `cheque_number`, `bank_name`, `account_name`,`date`, `time`, `user_ID`, `transaction_ID`) VALUES 
        ('$payment_ID','$type','$amount','$description','$dir','$cheque_number','$bank_name','$account_name','$date','$time','$user_id','$transaction_id')";


        $statement = $con->prepare($sql);
        $statement->execute();


        // update transaction status 

        $sql = "UPDATE transaction SET `trans_status`='$update_status' WHERE `transaction_ID`='$transaction_id'";
        $statement = $con->prepare($sql);
        $statement->execute();

        //update debtor funds 

        $sql = "UPDATE debtor set `account_funds` =`account_funds`+'$amount' WHERE `debtor_ID`='$debtor_id'";
        $statement = $con->prepare($sql);
        $statement->execute();

        //update ledger

        $this->ledger_new_entry("credit", $description, $amount, $company_bank_account, $transaction_id, $amount, "system");

        if ($save_type == "save") {
          header('Location:add_payment.php');
        } else {
          header("Location:../class/pdf_handler.php? order_id=$order_id & debtor_id=$debtor_id & total=$trans_amount & payment_id=$payment_ID & type=$pdfType");
        }
      } else if ($amount > $balance) {
      }
    }
  }









  //register new bank account
  function register_bank_account($bank_name, $account_number)
  {

    global $con;

    $sql = "SELECT * FROM bank_account WHERE `bank_name`='$bank_name' OR `account_number`='$account_number'";

    $result = $con->query($sql);
    if ($result->num_rows > 0) {

      echo ("<script> alert('Bank name or Account number already registered');
     </script>");
    } else {
      $bank_ID = $this->generate_user("bank");
      $account_funds = 0;
      $user_ID = $_SESSION['user'];
      $register_date = date("Y-m-d");



      $sql = "INSERT INTO `bank_account`(`bank_ID`, `bank_name`, `account_number`, `account_funds`, `register_date`, `user_ID`)
     VALUES ('$bank_ID','$bank_name','$account_number','$account_funds','$register_date','$user_ID')";

      $statement = $con->prepare($sql);
      $statement->execute();


      echo ("<script> alert('New bank account registered');
       </script>");
    }
  }

  // process payback function

  function add_creditor_payment($amount, $dir, $user_id, $transaction_id, $creditor_id, $trans_amount, $trans_status, $cheque_number, $bank_name, $description)
  {
    // note: trans_status is passed using trans date 
    // insert into payment

    global $con;
    $payed_amount = "";
    $transaction_amount = "";
    $date = date("Y-m-d");
    $time = date("H:m:i");
    $update_status = "";
    $payment_ID = $this->generate_user("payment");

    $newAmount = (int) $amount;
    $newTransAmount = (int)$trans_amount;

    if ($trans_status == "payment_pending") {
      /// adding new payment


      $sql = "INSERT INTO `payment`(`payment_ID`, `type`, `amount`, 
      `description`, `documents`, `cheque_number`, `bank_name`, 
      `account_name`, `date`, `time`, `user_ID`, `transaction_ID`) VALUES
       ('$payment_ID','cheque','$amount','$description','$dir',
       '$cheque_number','-','-','$date','$time','$user_id','$transaction_id')";


      $statement = $con->prepare($sql);
      $statement->execute();
      /// checking payment amount and type 

      if ($newAmount < $newTransAmount) {
        $update_status = "partly_payed";
      } else if ($newAmount >= $newTransAmount) {
        $update_status = "fully_payed";
      }

      // update transaction status 

      $sql = "UPDATE transaction SET `trans_status`='$update_status' WHERE `transaction_ID`='$transaction_id'";
      $statement = $con->prepare($sql);
      $statement->execute();

      //update creditor funds 

      $sql = "UPDATE creditor set `account_funds` = `account_funds`-$amount WHERE `creditor_ID`='$creditor_id'";
      $statement = $con->prepare($sql);
      $statement->execute();

      header('Location:add_payment.php');


      // update bank account funds 

      $sql = "UPDATE `bank_account` SET `account_funds`=`account_funds`-$amount WHERE `bank_ID`='$bank_name'";

      $statement = $con->prepare($sql);
      $statement->execute();

      header('Location:add_payback_payment.php');
    } else if ($trans_status == "partly_payed") {


      $sql = "SELECT sum(amount) as total_amount FROM `payment`WHERE transaction_Id ='$transaction_id'";

      $result = $con->query($sql);
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {

          $total_payment_amount = $row["total_amount"];
        }
      }
      $ava_balance = $trans_amount - $total_payment_amount;


      if ($ava_balance == $amount) {

        echo ("<script> alert('$ava_balance');
      </script>");

        $update_status = "fully_payed";

        $sql = "INSERT INTO `payment`(`payment_ID`, `type`, `amount`, 
            `description`, `documents`, `cheque_number`, `bank_name`, 
            `account_name`, `date`, `time`, `user_ID`, `transaction_ID`) VALUES
             ('$payment_ID','cheque','$amount','$description','$dir',
             '$cheque_number','-','-','$date','$time','$user_id','$transaction_id')";


        $statement = $con->prepare($sql);
        $statement->execute();



        // update transaction status 

        $sql = "UPDATE transaction SET `trans_status`='$update_status' WHERE `transaction_ID`='$transaction_id'";
        $statement = $con->prepare($sql);
        $statement->execute();

        //update creditor funds 

        $sql = "UPDATE creditor set `account_funds` =`account_funds`+'$amount' WHERE `creditor_ID`='$creditor_id'";
        $statement = $con->prepare($sql);
        $statement->execute();



        /// Update company bank account


        $sql = "UPDATE `bank_account` SET `account_funds`= `account_funds`-'$amount' WHERE `bank_ID` = '$bank_name'";

        $statement = $con->prepare($sql);
        $statement->execute();

        header('Location:add_payback_payment.php');

        $this->ledger_new_entry("credit", $description, $amount, $bank_name, $transaction_id, $amount, "system");
      } else if ($amount < $ava_balance) {



        $update_status = "partly_payed";

        $sql = "INSERT INTO `payment`(`payment_ID`, `type`, `amount`, 
            `description`, `documents`, `cheque_number`, `bank_name`, 
            `account_name`, `date`, `time`, `user_ID`, `transaction_ID`) VALUES
             ('$payment_ID','cheque','$amount','$description','$dir',
             '$cheque_number','-','-','$date','$time','$user_id','$transaction_id')";


        $statement = $con->prepare($sql);
        $statement->execute();



        // update transaction status 

        $sql = "UPDATE transaction SET `trans_status`='$update_status' WHERE `transaction_ID`='$transaction_id'";
        $statement = $con->prepare($sql);
        $statement->execute();

        //update creditor funds 

        $sql = "UPDATE creditor set `account_funds` =`account_funds`+'$amount' WHERE `creditor_ID`='$creditor_id'";
        $statement = $con->prepare($sql);
        $statement->execute();



        // Update company bank account


        $sql = "UPDATE `bank_account` SET `account_funds`= `account_funds` - '$amount' WHERE `bank_ID` = '$bank_name'";

        $statement = $con->prepare($sql);
        $statement->execute();

        header('Location:add_payback_payment.php');

        //update ledger


        $this->ledger_new_entry("debit", $description, $amount, $bank_name, $transaction_id, $amount, "system");
      } else if ($amount > $ava_balance) {

        echo ("<script> alert('Error Amount greater than required balance ');
    </script>");
        mysqli_close($con);
      }
    }
  }


  // Creating database files 

  function create_back_up_file()
  {
    global $con;
    global $database;
    global $localhost;
    global $username;
    global $password;



    $backup_file = $database . '_' . date("Y-m-d-H-i-s") . '.sql';

    // Connect to the database


    // Check if the connection was successful
    if (!$con) {
      die('Could not connect: ');
    }

    // Select the database
    mysqli_select_db($con, $database);

    // Run the mysqldump command
    $command = "mysqldump --opt -h $localhost -u $username -p$password $database > $backup_file";
    system($command);

    // Close the connection
    mysqli_close($con);
  }
  function get_progress()
  {

    $sql = "SELECT MONTH(date) AS month, YEAR(date) AS year, SUM(amount) AS total_amount
  FROM transactions
  WHERE YEAR(date) = [year_number]
  GROUP BY MONTH(date), YEAR(date)";
  }
}





class marketing extends main
{

  //  Inserting grower order, grower order is different from the normal order as the order ITEMS are added based on the registered farm details 


  function grower_order($creditor_id, $creditor_name, $crop, $variety, $class, $order_quantity, $price_per_kg, $discount_price, $total_price, $farm_id)
  {

    global $con;
    $order_ID = $this->generate_user("order");
    $user = $_SESSION["user"];
    $date = date("Y-m-d");
    $time = date("H:i:s");

    $sql = "INSERT INTO `order_table`(`order_ID`, `order_type`,
       `customer_id`, `customer_name`, `order_book_number`, 
       `user_ID`, `status`, `date`, `time`, `count`, `total_amount`,`farm_id`) 
      VALUES ('$order_ID','grower_order','$creditor_id','$creditor_name',
      '-','$user','pending','$date','$time','1','$total_price','$farm_id')";

    $statement = $con->prepare($sql);
    $statement->execute();

    $sql = "UPDATE `farm` SET `order_status`='order_pending' WHERE `farm_ID`='$farm_id'";
    $statement = $con->prepare($sql);
    $statement->execute();

    $this->add_order_item($order_ID, $crop, $variety, $class, $order_quantity, $price_per_kg, $discount_price, $total_price);
  }

  //GEtting order details based on the added farm details and registed certificate details 

  static function get_grower_order_details($lot_number)
  {
    global $con;

    $sql = "SELECT price.sell_breeder,crop.crop,crop.crop_ID,variety.variety,variety.variety_ID,certificate.class FROM `certificate` 
    INNER JOIN crop ON crop.crop_ID =certificate.crop_ID INNER JOIN 
    variety ON variety.variety_ID = certificate.variety_ID LEFT JOIN 
    price ON variety.variety_ID = price.variety_ID WHERE lot_number  = '$lot_number'";

    $result = $con->query($sql);
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        $price = $row['sell_breeder'];
        $crop_ID = $row['crop_ID'];
        $crop_name = $row['crop'];
        $variety_ID = $row['variety_ID'];
        $variety_name = $row['variety'];
      }

      return [$price, $crop_ID, $crop_name, $variety_ID, $variety_name];
    }
  }
  /*

Here we sprit the order one more time into three sections, the normal grower order , hybrid inbred order 
(uses two certificates male and female ) and hybred single closs order 
(uses one certificate, I call it main certificate but its just a normal certificate )



*/
  static function add_hybrid_order($order_id)
  {

    global $con;
    $sql = "SELECT * FROM `order_table` WHERE `order_ID`='$order_id'";
    $result = $con->query($sql);
    if ($result->num_rows > 0) {
      return "already_registered";
    } else {
      $sql = "INSERT INTO `order_table`(`order_ID`) VALUES ('$order_id')";
      $statement = $con->prepare($sql);
      if ($statement->execute()) {
        return "registered";
      }
    }
  }

  static function hybrid_item($order_ID, $crop, $variety, $class, $order_quantity, $price_per_kg, $discount_price, $total_price)
  {
    global $con;
    $item_ID = self::generate_user("item");

    $sql = "INSERT INTO `item`(`item_ID`, `order_ID`, `crop_ID`,
     `variety_ID`, `class`, `quantity`, `price_per_kg`, `discount_price`, 
     `total_price`) VALUES ('$item_ID','$order_ID','$crop','$variety','$class',
     '$order_quantity','$price_per_kg','$discount_price','$total_price')";

    $statement = $con->prepare($sql);
    if ($statement->execute()) {

      echo "registered";
    }
  }

  static function prepare_hybred_order($order_id, $grower_name, $grower_id, $user_id, $count, $farm_id)
  {

    global $con;
    $date = date("Y-m-d");
    $time = date("H:m:i");
    $total_amount = self::get_hybrid_total_amount($order_id);

    $sql = "UPDATE `order_table` SET `order_type`='grower_order',`customer_id`='$grower_id',`customer_name`='$grower_name',
    `order_book_number`='-',`user_ID`='$user_id',`status`='pending',
    `date`='$date',`time`='$time',`count`='$count',`total_amount`='$total_amount',`farm_id`='$farm_id' WHERE order_ID = '$order_id'";

    $statement = $con->prepare($sql);
    if ($statement->execute() && self::update_order_status($farm_id, "order_pending")) {
      echo "registered";
    }
  }




  static function get_hybrid_total_amount($order_id)
  {

    global $con;
    $sql = "SELECT SUM(`total_price`) AS total FROM item WHERE order_ID ='$order_id'";

    $result = $con->query($sql);
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        return $row['total'];
      }
    }
  }

  static function update_order_status($farm_id, $status)
  {

    global $con;

    $sql = "UPDATE `farm` SET `order_status`='$status' WHERE farm_ID = '$farm_id'";
    $statement = $con->prepare($sql);
    if ($statement->execute()) {
      echo "updated";
    }
  }
}
