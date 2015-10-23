<?php


    echo "<h2>A list of all the vehicles</h2>";
    //get all the vehicles from the database
    $vehicleUrl = "http://4me302-ht15.host22.com/index.php?table=Vehicle";
    $xmlVehicle = new SimpleXMLElement(file_get_contents($vehicleUrl));
    foreach($xmlVehicle ->children() as $vehicle){

        echo '<div class="record" style="border: 1px solid black; margin: 20px;width: 400px;padding: 8px">';


        //for each vehicle ID get all the vehicle details from the other table Vehicle_model
        $eachVehicleUrl = "http://4me302-ht15.host22.com/index.php?table=Vehicle_model&id=".$vehicle ->Vehicle_model_idVehicle_model;
        $eachVehicle = new SimpleXMLElement(file_get_contents($eachVehicleUrl));
        foreach($eachVehicle ->children() as $eachV){
            echo "<p>";
            echo "Name: ".$eachV ->name;
            echo " Year : ".$eachV -> year;
            echo "</p>";
        }

        //get the owner name of the each vehicle
        $eachOwnerUrl = "http://4me302-ht15.host22.com/index.php?table=Organization&id=".$vehicle ->VehicleOwner_idOrganization;
        $eachOrganization = new SimpleXMLElement(file_get_contents($eachOwnerUrl));
        foreach($eachOrganization ->children() as $eachO){
            echo "<p>";
            echo "Name of the organization: ". $eachO ->name;
            echo "</p>";
        }
        echo "plate: ". $vehicle ->plate;
        echo "</div>";
    }
    //get all the tasks from Bitacora
    $eachBitacoraUrl = "http://4me302-ht15.host22.com/index.php?table=Bitacora";
    $eachBitacora = new SimpleXMLElement(file_get_contents($eachBitacoraUrl));
    foreach($eachBitacora ->children() as $eachB){
        //memorize the bitacora ID to use it for data insertion into annotations
        $_SESSION['bitacoraID'] = (string) $eachBitacora -> idBitacora['id'];

        //get the vehicle model id
        $vehicleModelIdUrl = "http://4me302-ht15.host22.com/index.php?table=Vehicle&id=".$eachB ->Vehicle_idvehicle;
        $vmid = new SimpleXMLElement(file_get_contents($vehicleModelIdUrl));
        foreach($vmid ->children() as $vehicleModelId){
            $_SESSION['vehicleModelId'] = (string) $vehicleModelId -> Vehicle_model_idVehicle_model;

        }


        echo "<p>Vehicle ";
        //once I got the vehicle model id, get the model name
        $vehicleModelUrl = "http://4me302-ht15.host22.com/index.php?table=Vehicle_model&id=".$_SESSION['vehicleModelId'];
        $vm = new SimpleXMLElement(file_get_contents($vehicleModelUrl));
        foreach($vm ->children() as $vehicleModel){
            echo $vehicleModel ->name;
            echo " from year ";
            echo $vehicleModel ->year;
            echo " is driven/operated by: ";
            $userUrl = "http://4me302-ht15.host22.com/index.php?table=User&id=".$eachB -> User_idUser;
            $userXml = new SimpleXMLElement(file_get_contents($userUrl));
            foreach($userXml ->children() as $u){
                echo $u ->username."<br />";
            }
        }
        echo "start time: ".$eachB ->start_time."<br />";
        echo "start microseconds: ".$eachB ->start_microseconds."<br />";
        echo "end time: ".$eachB ->end_time."<br />";
        echo "end microseconds: ".$eachB ->end_microseconds."<br />";

        echo "<h3>Information about the sensors and their logs:</h3>";

        //get the information about the sensors attached
        $sensorUrl = "http://4me302-ht15.host22.com/index.php?table=Sensor";
        $sensorXML = new SimpleXMLElement(file_get_contents($sensorUrl));
        foreach($sensorXML ->children() as $sensor){
            if((string) $sensor -> Vehicle_idvehicle == (string)$eachB ->Vehicle_idvehicle){
                $_SESSION['sensorTypeId'] = (string) $sensor ->Sensor_type_idSensor_type;
                $_SESSION['sensorId'] = (string) $sensor -> attributes();

                //once grabbed the sensor id, get the name
                $sensorTypeUrl = "http://4me302-ht15.host22.com/index.php?table=Sensor_type&id=".$_SESSION['sensorTypeId'];
                $sensorTypeXML = new SimpleXMLElement(file_get_contents($sensorTypeUrl));
                foreach($sensorTypeXML ->children() as $sensorType){
                    echo "Sensor: <b>". $sensorType ->name . "</b>  ";
                }

                //get all the log for that particular sensor id
                $logUrl = "http://4me302-ht15.host22.com/index.php?table=Logs";
                $logXML = new SimpleXMLElement(file_get_contents($logUrl));
                foreach ($logXML ->children() as $log){
                    if($_SESSION['sensorId'] == (string) $log -> Sensor_idsensor){
                        $_SESSION['logname'] = (string) $log ->logname;

                        $statusTypeUrl = "http://4me302-ht15.host22.com/index.php?table=Status_type&id=".$log ->Status_type_idStatus_type;
                        $statusTypeXML = new SimpleXMLElement(file_get_contents($statusTypeUrl));
                        foreach($statusTypeXML ->children() as $statusType){
                            echo "Task status: ". $statusType ->name. "<br />";
                        }
                        echo "View the log file: <a href='http://4me302-ht15.host22.com/".$log ->logname."' target='_blank'>".$log -> logname."</a><br /><br />";
                    }
                }

            }
        }



        echo "</p>";
        echo '<ul id="responds">';

        //include db configuration file
        include_once 'include/db.php';
        //create a new db() object
        $note = new db();
        //retrieve only the notes that are associated to the logged in user
        $notes = $note ->getNotes($_SESSION['xml_id']);

        //retrieve one notes one by one adding them to HTML
        while($row = mysqli_fetch_assoc($notes))
        {
            echo '<li id="item_'.$row["id"].'">';
            echo '<div class="del_wrapper"><a href="#" class="del_button" id="del-'.$row["id"].'">';
            echo '<img src="images/icon_del.gif" border="0" />';
            echo '</a></div>';
            echo $row["content"].'</li>';
        }
        echo '</ul>';
}
echo '<script src="js/analystChart.js"></script>';

