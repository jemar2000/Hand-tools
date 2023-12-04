<?php
session_start();
include('connect.php');


$user_id = $_SESSION['user_id']; // Assuming you have the user's ID available in the session
$sql = "SELECT id, total_price, placed_on FROM orders WHERE user_id = $user_id";
$result = $conn->query($sql);

if ($result->rowCount() > 0) {
    echo "<h3>HISTORY</h3>";
    // Output data of each row
    echo "<table><tr><th>Order ID</th><th>Price</th> <th>Date</th> <th>Action</th></tr>";
    while($row = $result->fetch()) {
        echo "<tr>
                <td>" . $row["id"] . "</td>
                <td>" . $row["total_price"] . "</td>
                <td>" . $row["placed_on"] . "</td>
                <td><button onclick='deleteOrder(" . $row["id"] . ")'>Delete</button></td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "0 results";
}
?>

<script>
    function deleteOrder(orderId) {
        var row = document.querySelector("tr[data-order-id='" + orderId + "']");
        if (row) {
            row.remove();
        } else {
            alert("Order ID not found: " + orderId);
        }
    }
</script>