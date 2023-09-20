<?php
$result = $_SESSION['saved_result'];
if (!empty($result)) {
    $shipping_info = json_decode($result, true);

    if (!empty($shipping_info['error'])) {
        echo "<table border = 0 cellspacing=20 style='border-radius: 15px; background: #ffeeee; width: 400px; font-size: 20px'>";
        echo "<tr><td valign=top><b>Error:</b></td><td> " . $shipping_info['error'] . "</td></tr>";
        echo "</table>";
    } else {
        echo "<table border = 0 cellspacing=20 style='border-radius: 15px; background: #eeffee; width: 400px; font-size: 20px'>";
        echo "<tr><td align=right width=50%><b>Price:</b></td><td>" . $shipping_info['price'] . "</td></tr>";
        echo "<tr><td align=right><b>Date:</b></td><td>" . $shipping_info['date'] . "</td></tr>";
        echo "</table>";
    }
    echo '<br/><br/>';
}
?>