<?php include 'header.php'; ?>
<?php
   if (isset($_POST['delete']) && $_POST['delete'] == 1){
	$file = $_POST['file'];
	//echo $file;
	if (file_exists('nutrients/' . $file)) {
        if (unlink('nutrients/' . $file)) {
          //echo "File deleted";
        } else {
          echo "Failed to delete file";
        }
        } else {
          echo "File does not exist";
        }
   }
?>
<?php
    if (isset($_POST['addnutrient']) && $_POST['addnutrient'] == 1) {
        $x = 0;
        if(isset($_POST['nName']) && $_POST['nName'] != "" ){
            $x = 1;
        } else {
            $x = 0;
        }

        if ($x == 1) {
            //print("- Adding new nutrient.<br><br>");
            $date = date('Y-m-d-H-i-s');
            $file = "nutrient-" . $_POST['nName'] . "-" . $date;

            $handle = fopen('nutrients/' . $file, 'w'); // 'w' = overwrite, 'a' = append

            if ($handle === false) {
                die('Unable to open file');
            }

            fwrite($handle, "Nutrient Name : " . $_POST['nName'] . "<br>");
            fclose($handle);

        } else {
            //print("- Not all data was entered.<br><br>");
        }
    }
?>

    <form action="add_nutrients.php" method="post">
    <input type="hidden" name="addnutrient" value="1"></input>
    <div class="nutrientfile" style="width:80%; margin: 0 auto; padding: 10px; background-color: #fff; border: 2px solid #000;">
        <div><h3><u>Add New Nutrient</u><h3></div>
        <div style="display: flex; padding: 10px;"">
            <div style="width: 200px;">Nutrient Name : </div>
            <div style="width: 230px;"><input type="text" name="nName"></input></div>
        </div>
        <div style="display: flex; padding: 10px;"">
            <div style="width: 230px;"><button type="submit">Add New Nutrient</button></form></div>
        </div>
    <div>
<br>

<?php
    $dir = 'nutrients/';

    $files = array_diff(scandir($dir), ['.', '..']);
    sort($files); // descending

    foreach ($files as $file) {
        $path = $dir . $file;

        if (is_file($path)) {
            $content = file_get_contents($path);
            print("<div class=\"nutrient\" style=\"width:98%; margin: 0 auto; padding: 10px; background-color: #000; border: 2px solid #000;\">");
            print("<form action=\"add_nutrients.php\" method=\"post\">
                <input type=\"hidden\" name=\"delete\" value=\"1\">
                <input type=\"hidden\" name=\"file\" value=\"$file\">");
                //echo $file;
            echo "$content<br>";
            ?><button type="submit">Delete Nutrient</button></form><?php
            echo "</div><br>";
        }
    }
?>
</div>
</div>
<?php include 'footer.php'; ?>
