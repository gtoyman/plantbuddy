<?php 
	include 'header.php'; 
	//print_r($_POST); 
?>

<?php
   if (isset($_POST['edit']) && $_POST['edit'] == 1  && !isset($_POST['clear'])) {
        $file = $_POST['file'];
        //print_r($_POST);

        if (file_exists('plants/' . $file)) {
             $path="plants/" . $file;
             if (is_file($path)) {
                $content = file_get_contents($path);
                $result = explode('<br>', $content);

                $pSDate = explode(':', $result[3]); $sDate = $pSDate[1];
                $sDate = ltrim($sDate);
                $pVSDate = explode(':', $result[4]); $VSDate = $pVSDate[1];
                $VSDate = ltrim($VSDate);
                $pFSDate = explode(':', $result[5]); $FSDate = $pFSDate[1];
                $FSDate = ltrim($FSDate);
                $pFEDate = explode(':', $result[6]); $FEDate = $pFEDate[1];
                $FEDate = ltrim($FEDate);
                $pName = explode(':', $result[0]); $plantName = $pName[1];
                $plantName = ltrim($plantName);
                $pStrain = explode(':', $result[1]); $plantStrain = $pStrain[1];
                $plantStrain = ltrim($plantStrain);
            }
        }
    }
?>

<?php
   if (isset($_POST['delete']) && $_POST['delete'] == 1){
        $file = $_POST['file'];
        //echo $file;
        if (file_exists('plants/' . $file)) {
        if (unlink('plants/' . $file)) {
          //echo "File deleted";
        } else {
	  echo "Failed to delete file";
        }
        } else {
          echo "File does not exist";
        }
        if (file_exists('water/' . $file)) {
        if (unlink('water/' . $file)) {
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
    if (isset($_POST['addplant']) && $_POST['addplant'] == 1) {

        $x = 0;
        if(isset($_POST['pName']) && $_POST['pName'] != "" ){
            $x = 1;
        } else {
            $x = 0;
        }
        if(isset($_POST['pStrain']) && $_POST['pStrain'] != "") {
            $x = 1;
        } else {
            $x = 0;
        }
        if(isset($_POST['pSDate']) && $_POST['pSDate'] != "") {
            $x = 1;
        } else {
            $x = 0;
        }
        if(isset($_POST['pVSDate']) && $_POST['pVSDate'] != "") {
            $x = 1;
        } else {
            $x = 0;
        }
        if(isset($_POST['pFSDate']) && $_POST['pFSDate'] != "") {
            $x = 1;
        } else {
            $x = 0;
        }
        if(isset($_POST['pFEDate']) && $_POST['pFEDate'] != "") {
            $x = 1;
        } else {
            $x = 0;
        }

        if ($x == 1 && !isset($_POST['edit'])) {
            //print("- Adding new plant.<br><br>");
            $date = date('Y-m-d-H-i-s');
            $file = "plant-" . $date;

            $handle = fopen('plants/' . $file, 'w'); // 'w' = overwrite, 'a' = append

            if ($handle === false) {
                die('Unable to open file');
            }

            fwrite($handle, "Plant Name : " . $_POST['pName'] . "<br>");
            fwrite($handle, "Plant Strain : " . $_POST['pStrain'] . "<br><br>");
            fwrite($handle, "Seed Start Date : " . $_POST['pSDate'] . "<br>");
            fwrite($handle, "Vegetative Start Date : " . $_POST['pVSDate'] . "<br>");
            fwrite($handle, "Flowering Start Date : " . $_POST['pFSDate'] . "<br>");
            fwrite($handle, "Flowering End Date : " . $_POST['pFEDate'] . "<br>");
            fclose($handle);

        } else {

            if(isset($_POST['edit']) && isset($_POST['clear'])) {
                $file = $_POST['file'];
                echo "file : " . $file;
                $handle = fopen('plants/' . $file, 'w'); // 'w' = overwrite, 'a' = append

                if ($handle === false) {
                    die('Unable to open file HERE');
                }

                fwrite($handle, "Plant Name : " . $_POST['pName'] . "<br>");
                fwrite($handle, "Plant Strain : " . $_POST['pStrain'] . "<br><br>");
                fwrite($handle, "Seed Start Date : " . $_POST['pSDate'] . "<br>");
                fwrite($handle, "Vegetative Start Date : " . $_POST['pVSDate'] . "<br>");
                fwrite($handle, "Flowering Start Date : " . $_POST['pFSDate'] . "<br>");
                fwrite($handle, "Flowering End Date : " . $_POST['pFEDate'] . "<br>");
                fclose($handle);

            } else {
                print("- Not all data was entered.<br><br>");
            }
        }
    }
?>

    <form action="add_plant.php" method="post">
        <?php
        if (isset($_POST['edit']) && !isset($_POST['clear']))
        {
            echo "<input type=\"hidden\" name=\"edit\" value=\"1\"></input>";
            echo "<input type=\"hidden\" name=\"file\" value=\"$file\"></input>";
            echo "<input type=\"hidden\" name=\"clear\" value=\"1\"></input>";

        }
        ?>
    <input type="hidden" name="addplant" value="1"></input>
    <div class="addplant" style="width:98%; margin: 0 auto; padding: 10px; background-color: #fff; border: 2px solid #000;">
        <div><h3><u>Add New Plant</u><h3></div>
        <div style="display: flex; padding: 10px;"">
            <div style="width: 230px;">Plant Name : </div>
            <?php
            if(isset($_POST['edit']) && isset($plantName)) {
                echo "<div style=\"width: 230px;\"><input type=\"text\" name=\"pName\" value=\"$plantName\"</input></div>";
            } else {
                echo "<div style=\"width: 230px;\"><input type=\"text\" name=\"pName\"></input></div>";
            }
            ?>
        </div>
        <div style="display: flex; padding: 10px;"">
            <div style="width: 230px;">Strain Name : </div>
            <?php
            if(isset($_POST['edit']) && isset($plantStrain)) {
                echo "<div style=\"width: 230px;\"><input type=\"text\" name=\"pStrain\" value=\"$plantStrain\"></input></div>";
            } else {
                echo "<div style=\"width: 230px;\"><input type=\"text\" name=\"pStrain\"></input></div>";
            }
            ?>
        </div>
        <div style="display: flex; padding: 10px;"">
            <div style="width: 230px;">Seed Start Date : </div>
            <?php
            if(isset($_POST['edit']) && isset($sDate)) {
                echo "<div style=\"width: 230px;\"><input type=\"text\" name=\"pSDate\" value=\"$sDate\"></input></div>";
            } else {
                echo "<div style=\"width: 230px;\"><input type=\"text\" name=\"pSDate\"></input></div>";
            }
            ?>
            <div style="width: 230px;">(YYYY/MM/DD)</div>
        </div>
        <div style="display: flex; padding: 10px;"">
            <div style="width: 230px;">Vegetative Start Date : </div>
<?php
            if(isset($_POST['edit']) && isset($VSDate)) {
                echo "<div style=\"width: 230px;\"><input type=\"text\" name=\"pVSDate\" value=\"$VSDate\"></input></div>";
            } else {
                echo "<div style=\"width: 230px;\"><input type=\"text\" name=\"pVSDate\"></input></div>";
            }
            ?>
            <div style="width: 230px;">(YYYY/MM/DD)</div>
        </div>
        <div style="display: flex; padding: 10px;"">
            <div style="width: 230px;">Flowering Start Date : </div>
           <?php
            if(isset($_POST['edit']) && isset($FSDate)) {
                echo "<div style=\"width: 230px;\"><input type=\"text\" name=\"pFSDate\" value=\"$FSDate\"></input></div>";
            } else {
                echo "<div style=\"width: 230px;\"><input type=\"text\" name=\"pFSDate\"></input></div>";
            }
            ?>
            <div style="width: 230px;">(YYYY/MM/DD)</div>
        </div>
        <div style="display: flex; padding: 10px;"">
            <div style="width: 230px;">Flowering End Date : </div>
            <?php
            if(isset($_POST['edit']) && isset($FEDate)) {
                echo "<div style=\"width: 230px;\"><input type=\"text\" name=\"pFEDate\" value=\"$FEDate\"></input></div>";
            } else {
                echo "<div style=\"width: 230px;\"><input type=\"text\" name=\"pFEDate\"></input></div>";
            }
            ?>
            <div style="width: 230px;">(YYYY/MM/DD)</div>
        </div>
        <div style="display: flex; padding: 10px;"">
            <?php
                if (isset($_POST['edit']) && !isset($_POST['clear'])) {
                    echo "<div style=\"width: 230px;\"><button type=\"submit\">Edit This Plant</button></form></div>";
                } else {
                    echo "<div style=\"width: 230px;\"><button type=\"submit\">Add New Plant</button></form></div>";
                }
            ?>
        </div><br>
<?php
    $dir = 'plants/';

    $files = array_diff(scandir($dir), ['.', '..']);
    rsort($files); // descending

    foreach ($files as $file) {
        $path = $dir . $file;

        if (is_file($path)) {
            $content = file_get_contents($path);
            $result = explode('<br>', $content);
            print("<div class=\"plantfile\" style=\"width:98%; margin: 0 auto; padding: 10px; background-color: #000; border: 2px solid #000;\">");
            echo "<h3>$result[0]</h3>";
            echo "$result[1]<br><br>";
            echo "$result[3]<br>";
            echo "$result[4]<br>";
            echo "$result[5]<br>";
            echo "$result[6]<br><br>";

            $pSDate = explode(':', $result[3]); $sDate = $pSDate[1];
            $sDate = ltrim($sDate);
            $pVSDate = explode(':', $result[4]); $VSDate = $pVSDate[1];
            $VSDate = ltrim($VSDate);
            $pFSDate = explode(':', $result[5]); $FSDate = $pFSDate[1];
            $FSDate = ltrim($FSDate);
            $pFEDate = explode(':', $result[6]); $FEDate = $pFEDate[1];
            $FEDate = ltrim($FEDate);

                $start = new DateTime($sDate);
                $end = new DateTime($VSDate);
                $diff = $start->diff($end);
                $tdays = ($diff->days);
                echo "Total Seedling Days: $tdays<br>";
                $start = new DateTime($VSDate);
                $end = new DateTime($FSDate);
                $diff = $start->diff($end);
                $tdays = ($diff->days);
                echo "Total Vegetative Days: $tdays<br>";
                $start = new DateTime($FSDate);
                $end = new DateTime($FEDate);
                $diff = $start->diff($end);
                $tdays = ($diff->days);
                echo "Total Flowering Days: $tdays<br><br>";

            // EDIT PLANT BUTTON
            print("<form action=\"add_plant.php\" method=\"post\">
                <input type=\"hidden\" name=\"edit\" value=\"1\">
                <input type=\"hidden\" name=\"file\" value=\"$file\">");
            echo "<button type=\"submit\">Edit Plant</button></form>";
            // DELETE PLANT BUTTON
            print("<form action=\"add_plant.php\" method=\"post\">
                <input type=\"hidden\" name=\"delete\" value=\"1\">
                <input type=\"hidden\" name=\"file\" value=\"$file\">");
            echo "<button type=\"submit\">Delete Plant</button></form>";
            echo "</div><br>";
        }
    }
?>
</div>
<?php include 'footer.php'; ?>
