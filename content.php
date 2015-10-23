<?php

if($_SESSION['roleName'] == "Driver"){
    require 'driver.php';
    echo "Content specific for the role of ".$_SESSION['roleName'] . "<br />";
    echo "Related videos for the vehicle assigned to the driver: ".$_SESSION['vehicleModel'].', year: '.$_SESSION['vehicleModelYear']. " <br />";

    require 'youtube.php';

}
elseif(($_SESSION['roleName'] == "Director")|| ($_SESSION['roleName'] == "CTO")){
    echo "This page has content specific for the role of ".$_SESSION['roleName']."<br />";
    require 'director.php';
    echo '<div style="margin-right: 40px;">
        <div id="legend"></div>
            <svg id="time-series" style="height: 300px; width: 100%;  overflow: visible">
              <defs>
                <linearGradient id="area-gradient"
                                x1="0%" y1="0%"
                                x2="0%" y2="100%">
                   <stop offset="0%" stop-opacity="0.3" stop-color="#fff" />
                  <stop offset="100%" stop-opacity="0" stop-color="#1a9af9" />
                </linearGradient>
              </defs>
            </svg>
        </div>';
}


elseif(($_SESSION['roleName'] == "Analyst Junior") || ($_SESSION['roleName'] == "Analyst Senior")) {
    echo "This page has content specific for the role of ".$_SESSION['roleName'];
    require 'analyst.php';
    echo '<div class="form_style">
        <textarea name="content_txt" id="contentText" cols="45" rows="5" placeholder="Enter note content for task"></textarea>
        <button id="FormSubmit">Add note</button>
        <img src="images/loading.gif" id="LoadingImage" style="display:none" />
    </div>
    <div id="charts" style="margin-left: auto;margin-right: auto;width: 1200px">
        <div class="group">
            <h3>Engine water temperature</h3>
            <svg id="veh17_EngineWaterTemp"></svg>
        </div>
        <div class="group">
            <h3>Hydraulic oil temperature</h3>
            <svg id="veh17_Hydrualoljetemp"></svg>
        </div>
        <div class="group">
            <h3>Transmission conv temperature</h3>
            <svg id="veh17_Transmission_conv_temp"></svg>
        </div>
        <div class="group">
            <h3>Transmission sump temperature</h3>
            <svg id="veh17_Transmission_sump_temp"></svg>
        </div>
    </div>';
}