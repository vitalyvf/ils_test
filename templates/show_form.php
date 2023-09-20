<?php

$kladr_list = fn_get_kladr_list();
$service_list = fn_get_service_list();

if (is_array($kladr_list) && !empty($kladr_list)) {
    echo "<table border = 0 cellspacing=20 style='border-radius: 15px; background: #eeeeee; width: 400px'>
    <form action='index.php' method='post'>";

    echo "<tr><td align='right' width='50%'>Shipping service</td><td><select name='service'>
    ";
    foreach ($service_list as $service => $sname) {
        echo "<option value='$service'";
        if ($_GET['service'] == $service) {
            echo " selected";
        }
        echo ">$sname</option>";
    }
    echo "</select></td></tr>";

    echo "<tr><td align='right'>Source kladr</td><td><select name='source_kladr'>
    <option value=''>Select source kladr</option>
    ";
    foreach ($kladr_list as $kladr => $kname) {
        echo "<option value='$kladr'";
        if ($_GET['source_kladr'] == $kladr) {
            echo " selected";
        }
        echo ">$kname</option>";
    }
    echo "</select></td></tr>";

    echo "<tr><td align='right'>Target kladr</td><td><select name='target_kladr'>
    <option value=''>Select target kladr</option>
    ";
    foreach ($kladr_list as $kladr => $kname) {
        echo "<option value='$kladr'";
        if ($_GET['target_kladr'] == $kladr) {
            echo " selected";
        }

        echo ">$kname</option>";
    }

    echo "<tr><td align='right'>Weight</td><td>
    <input name='weight' value='".$_GET['weight']."' size='6'></td></tr>
    <tr><td colspan=2 align='center'><input type='submit' value='Calculate'></td></tr>
    </form>
    </table>";
} else {
	echo '<b>Error:</b> No kladr found';
}
?>