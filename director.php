<?php
    //get the organization id from the logged in user
    $userOrganizationIdUrl = "http://4me302-ht15.host22.com/index.php?table=User&id=".$_SESSION['xml_id'];
    $userOrganizationIdXML = new SimpleXMLElement(file_get_contents($userOrganizationIdUrl));
    foreach($userOrganizationIdXML ->children() as $userIdO){
        $_SESSION['userOrganizationId'] = (string) $userIdO ->Organization_idOrganization;
    }

    //use the organization id retrieved earlier to find the stock name of the company of the user that is logged in
    $userOrganizationUrl = "http://4me302-ht15.host22.com/index.php?table=Organization&id=".$_SESSION['userOrganizationId'];
    $userOrganizationXML = new SimpleXMLElement(file_get_contents($userOrganizationUrl));
    foreach($userOrganizationXML -> children() as $userO){
        $_SESSION['stockName'] = (string) $userO ->stockName;
        echo "Download the historical stock market value of ".$userO ->name. " in a CVS format file: ";

        //use the Yahoo finance Api to get information about the stock market value of the representative company
        echo "<a href='http://ichart.finance.yahoo.com/table.csv?s=".$userO -> stockName."&ignore=.csv'>".$userO ->name."</a>";
        echo '<h2>Analyse the graphic below concerning the stock market value of '.$userO ->name.'</h2>';
        echo '<script src="js/financeChart.js"></script>';
    }

