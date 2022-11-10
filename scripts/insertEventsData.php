<?php

header('Access-Control-Allow-Origin: *');
header('Consent-Type: application/json');

include_once '../config/Database.php';

$database = new Database();
$db = $database->connect();

$image_dog_vacations_content = addslashes(file_get_contents('../db_images/lablador_vacations_4x3.jpg'));
$image_dog_human_content = addslashes(file_get_contents('../db_images/lablador_human_4x3.jpg'));

$query =
    "INSERT INTO events (
        user_id, 
        type_id, 
        name, 
        start_time, 
        end_time, 
        short_description, 
        long_description, 
        image) 
    VALUES
        ('3',
        '4', 
        'Bali vacations', 
        '2022-11-02T01:01:00', 
        '2022-11-05T14:59:00', 
        'I''m going on vacations!',
        'Kid is throwing a party at my place. I don''t wanna be there at that time- perfect time for a vacations!', 
        '$image_dog_vacations_content'),
        ('3',
        '1', 
        'Time with John', 
        '2022-11-01T12:00:00', 
        '2022-11-01T16:00:00', 
        'I''m spending time with John.',
        'John is coming to my flat. I''ll spend some time with him and teach him giving a hand. Also I''ll eat some snacks during that :)', 
        '$image_dog_human_content');";

$stmt = $db->prepare($query);
$stmt->execute();

return $stmt;