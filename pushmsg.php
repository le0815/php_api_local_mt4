<?php
require_once 'config/db.php';

if (isset($_GET['ChannelId']) && isset($_GET['AccountId']) && isset($_GET['Msg'])) {
    $channelId = $_GET['ChannelId'];
    $accountId = $_GET['AccountId'];
    $msg = $_GET['Msg'];
    $numberOfRowsToDelete = 50;
    $maxRows = 150;

    
    // if total msg pass over Limit msg -> delete old msg
    $query = "SELECT COUNT(*) AS total FROM Message";
    $totalMsg = GetTotals($conn, $query);
    if ($totalMsg > $maxRows)
    {
        $query = "DELETE FROM Message WHERE id IN ( SELECT id FROM ( SELECT id FROM Message ORDER BY id LIMIT $numberOfRowsToDelete ) AS subquery );";
        DeleteMsg($conn, $query);
    }        

    //sent new msg
    $query = "INSERT INTO `Message`(`AccountId`, `ChannelId`, `Msg`) VALUES ('$accountId','$channelId','$msg')";
    SentMsg($conn, $query);
    

}

function GetTotals($conn, $query)
{
    
    $result = mysqli_query($conn, $query);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $totalMsg = $row['total'];
        echo $totalMsg;
        return $totalMsg;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

function DeleteMsg($conn, $query)
{
    
    $result = mysqli_query($conn, $query);

    if ($result) {        
        echo "deleted";        
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

function SentMsg($conn, $query)
{
    
    $result = mysqli_query($conn, $query);

    if ($result) {        
        echo "sent msg success";        
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

?>