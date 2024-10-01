<?php
require_once 'config/db.php';

if (isset($_GET['ChannelId']) && isset($_GET['AccountId'])) {
    $channelId = $_GET['ChannelId'];
    $accountId = $_GET['AccountId'];

    //get msg by id
    if(isset($_GET['Id']))
    {
        $id = $_GET['Id'];
        $query = "SELECT `Id`, `Msg` FROM `Message` WHERE ChannelId = $channelId and AccountId = $accountId and Id >= $id";
        GetMsg($conn, $query);
    }
    //get all msg of account in channel
    else{
        $query = "SELECT `Id`, `Msg` FROM `Message` WHERE ChannelId = $channelId and AccountId = $accountId";
        GetMsg($conn, $query);
    }

    
    
}

function GetMsg($conn, $query)
{
    $result = mysqli_query($conn, $query);
    if($result)
    {
        while ($r = mysqli_fetch_assoc($result)) 
        {
            echo "Id: ".$r['Id']." Message: ".$r["Msg"];            
            echo '<br>';               
        }
    }else {
        echo "Error: " . mysqli_error($conn);
    }
}

?>