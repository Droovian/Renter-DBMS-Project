<?php

include("../dist/database.php");
session_start();


?>

<?php

   if(isset($_SESSION['bookingemail'])){
        $bookingEmail = $_SESSION['bookingemail'];
        $check_in_date = $_SESSION['check-in'];
        $sql = "UPDATE bookings set payment_status = true WHERE email = ? AND check_in = '$check_in_date'";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $bookingEmail);

        if ($stmt->execute()) {
            echo "<script>
                setTimeout(() => {
                    alert('You will now be redirected to main page');
                    window.location.href = 'booking.php';
                }, 2000);
            </script>
            ";
        } else {
            // Error updating payment status
            echo "Error updating payment status: " . $stmt->error;
        }

        // Close the database connection (if you haven't done it already)
        $stmt->close();
        $conn->close();
   }



?>
<html>
  <head>
    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:400,400i,700,900&display=swap" rel="stylesheet">
    <link rel="icon" href="../dist/images/fox-svgrepo-com.svg">
  </head>
    <style>
      body {
        text-align: center;
        padding: 40px 0;
        background: #EBF0F5;
      }
        h1 {
          color: #88B04B;
          font-family: "Nunito Sans", "Helvetica Neue", sans-serif;
          font-weight: 900;
          font-size: 40px;
          margin-bottom: 10px;
        }
        p {
          color: #404F5E;
          font-family: "Nunito Sans", "Helvetica Neue", sans-serif;
          font-size:20px;
          margin: 0;
        }
      i {
        color: #9ABC66;
        font-size: 100px;
        line-height: 200px;
        margin-left:-15px;
      }
      .card {
        background: white;
        padding: 60px;
        border-radius: 4px;
        box-shadow: 0 2px 3px #C8D0D8;
        display: inline-block;
        margin: 0 auto;
      }
    </style>
    <body>
      <div class="card">
      <div style="border-radius:200px; height:200px; width:200px; background: #F8FAF5; margin:0 auto;">
        <i class="checkmark">✓</i>
      </div>
        <h1>Success</h1> 
        <p>We received your purchase request;<br/> we'll be in touch shortly!</p>
      </div>
    </body>
</html>