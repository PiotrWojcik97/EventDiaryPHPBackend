<?php

// testing if image is loaded from database

header('Access-Control-Allow-Origin: *');
header('Consent-Type: application/json');

include_once '../config/Database.php';

function getImage()
{
    $database = new Database();
    $db = $database->connect();
    
    $query = 
        "SELECT image
        FROM events 
        WHERE id='2';";
    
    $stmt = $db->prepare($query);
    $stmt->execute();

    return $stmt;
}
?>

<?php 
    $result = getImage();
    if($result->rowCount() > 0){ ?> 
    <div class="gallery"> 
        <?php while($row = $result->fetch(PDO::FETCH_ASSOC)){ ?> 
            <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row['image']); ?>" /> 
        <?php } ?> 
    </div> 
<?php }else{ ?> 
    <p class="status error">Image(s) not found...</p> 
<?php } ?>