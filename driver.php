<?php
    //get the vehicle that is assigned to that logged in user
    $vehicleIdUrl = "http://4me302-ht15.host22.com/index.php?table=Bitacora";
    $v = new SimpleXMLElement(file_get_contents($vehicleIdUrl));
    foreach($v ->children() as $obj){
        if($_SESSION['xml_id'] == (string) $obj ->User_idUser)
            $_SESSION['vehicleID'] = (string) $obj ->Vehicle_idvehicle;
    }


    //get the vehicle model id
    $vehicleModelIdUrl = "http://4me302-ht15.host22.com/index.php?table=Vehicle&id=".$_SESSION['vehicleID'];
    $vmid = new SimpleXMLElement(file_get_contents($vehicleModelIdUrl));
    foreach($vmid ->children() as $vehicleModelId){
        $_SESSION['vehicleModelId'] = (string) $vehicleModelId -> Vehicle_model_idVehicle_model;
    }


    //once I got the vehicle model id, get the model name for the content page
    $vehicleModelUrl = "http://4me302-ht15.host22.com/index.php?table=Vehicle_model&id=".$_SESSION['vehicleModelId'];
    $vm = new SimpleXMLElement(file_get_contents($vehicleModelUrl));
    foreach($vm ->children() as $vehicleModel){
        $_SESSION['vehicleModel'] = (string) $vehicleModel ->name;
        $_SESSION['vehicleModelYear'] = (string) $vehicleModel ->year;
    }