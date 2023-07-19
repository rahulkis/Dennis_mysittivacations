 <?php 

 $server     = 'localhost';
 $username   = 'root';
 $password   = 'mYsiTTi341Com';
 $database   = 'mysitti_live';

 $dsn        = "mysql:host=$server;dbname=$database";

 try {
    
    $db = new PDO($dsn, $username, $password);
    $db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    session_start();
    $conn = new mysqli("localhost", "root", "mYsiTTi341Com", "mysitti_live"); 
    $email = $_SESSION['username'];
     $trip_id = $_SESSION['trip_id'];
    $sql = "Select * from user where email='$email'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_row($result);
    $user_id = $row[0];
    $sth = $db->query("SELECT * FROM trip_location where user_id=$user_id AND trip_id=$trip_id");

    $locations = $sth->fetchAll();

    echo json_encode( $locations );

} catch (Exception $e) {
    echo $e->getMessage();
}