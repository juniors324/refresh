<?php

session_start(); // Start the session


$_SESSION['refresh_token'] = "iiN5jlWQZ20AAAAAAAAAATpWNw3TvmJa8TLn4Sc2nlsPfv2uEZrxf_h1CiRpvF1P";
function refreshAccessToken($refreshToken)
{
    $clientId = '8l86noc73ypxz5v';
    $clientSecret = 'jb0tnsbmrkt8dj5';

    $url = 'https://api.dropboxapi.com/oauth2/token';
    $postFields = [
        'grant_type' => 'refresh_token',
        'refresh_token' => $refreshToken,
        'client_id' => $clientId,
        'client_secret' => $clientSecret,
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postFields));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    curl_close($ch);

    return json_decode($response, true);
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // // $name = htmlspecialchars($_POST['name']);
    // // echo "Hello, " . $name . "!";
    $refreshToken = $_SESSION['refresh_token'];
    $newTokenData = refreshAccessToken($refreshToken);

    if (isset($newTokenData['refresh_token'])) {
        $_SESSION['refresh_token'] = $newTokenData['refresh_token'];
    }

    if (isset($newTokenData['access_token'])) {
        $accessToken = $newTokenData['access_token'];
        // // File to upload
        // $filePath = $_FILES[$inputfilename]['tmp_name']; // File uploaded from form
        // $dropboxPath = '/test/' . $_FILES[$inputfilename]['name'];

        // uploadToDropbox($accessToken, $filePath, $dropboxPath);
        echo $accessToken;
    } else {
        echo "Failed to refresh access token: " . json_encode($newTokenData);
    }
    // $name = htmlspecialchars($_POST['name']);
    // echo "Hello, " . $name . "!";
    // echo "Response success";
}
?>
