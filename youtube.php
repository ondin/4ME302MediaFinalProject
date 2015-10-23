<?php
$htmlBody = '';
require_once 'src/Google/autoload.php';
require_once 'src/Google/Client.php';
require_once 'src/Google/Service/YouTube.php';

/*
  * Set $DEVELOPER_KEY to the "API key" value from the "Access" tab of the
  * {{ Google Cloud Console }} <{{ https://cloud.google.com/console }}>
  * Please ensure that you have enabled the YouTube Data API for your project.
  */
$DEVELOPER_KEY = 'AIzaSyBEi7ff7BQ_bCNPN9HuYM16NSnJdTpo650';
$client = new Google_Client();
$client->setDeveloperKey($DEVELOPER_KEY);
// Define an object that will be used to make all API requests.
$youtube = new Google_Service_YouTube($client);

try {
    // Call the search.list method to retrieve results matching the specified
    // query term.
    $searchResponse = $youtube->search->listSearch('id,snippet', array(
        'q' => $_SESSION['vehicleModel'] ,
        'maxResults' => 3,
    ));
    $videos = '';
    // Add each result to the appropriate list, and then display the lists of
    // matching videos
    foreach ($searchResponse['items'] as $searchResult) {
        switch ($searchResult['id']['kind']) {
            case 'youtube#video':
                $videos .= sprintf('<li>%s (%s)</li>',
                    $searchResult['snippet']['title'], $searchResult['id']['videoId']);
                $videos .= '<iframe width="560" height="315" src="https://www.youtube.com/embed/'.$searchResult['id']['videoId'].'" frameborder="0" allowfullscreen></iframe> <br />';
                break;
        }
    }
    $htmlBody .= <<<END
    <h3>Videos</h3>
    <ul>$videos</ul>
END;
    } catch (Google_Service_Exception $e) {
        $htmlBody .= sprintf('<p>A service error occurred: <code>%s</code></p>',
            htmlspecialchars($e->getMessage()));
    } catch (Google_Exception $e) {
        $htmlBody .= sprintf('<p>An client error occurred: <code>%s</code></p>',
            htmlspecialchars($e->getMessage()));
    }
echo $htmlBody;
