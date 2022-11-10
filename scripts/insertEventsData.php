<?php

header('Access-Control-Allow-Origin: *');
header('Consent-Type: application/json');

include_once '../config/Database.php';

$database = new Database();
$db = $database->connect();

$image_dog_vacations_content = addslashes(file_get_contents('../db_images/lablador_vacations_4x3.jpg'));
$image_dog_human_content = addslashes(file_get_contents('../db_images/lablador_human_4x3.jpg'));
$image_baby_shaving_content = addslashes(file_get_contents('../db_images/baby_shaving_4x3.jpg'));
$image_baby_party_content = addslashes(file_get_contents('../db_images/baby_party_4x3.jpg'));
$image_baby_cleaning_content = addslashes(file_get_contents('../db_images/baby_cleaning_4x3.jpg'));
$image_woman_content = addslashes(file_get_contents('../db_images/woman_yoga_face_4x3.jpg'));

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
        'Bali Vacations', 
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
        '$image_dog_human_content'),
        ('4',
        '4', 
        'Party Preparation', 
        '2022-11-03T12:00:00', 
        '2022-11-03T13:00:00', 
        'Bath, shave before my second birthday.',
        'I need to look like a god on my party. So I''ll take a shower, shave myself, use perfumes', 
        '$image_baby_shaving_content'),
        ('4',
        '3', 
        'Party', 
        '2022-11-03T13:30:00', 
        '2022-11-03T17:00:00', 
        'Party time!',
        'Everyone is invited in the neighbor. For sure I''ll receive nice presents.', 
        '$image_baby_party_content'),
        ('4',
        '5', 
        'Cleaning', 
        '2022-11-03T17:00:00', 
        '2022-11-03T19:00:00', 
        'Cleaning after the party.',
        'Poor me that I need to cleanup this whole mess.', 
        '$image_baby_cleaning_content'),
        ('5',
        '5', 
        'Face Yoga', 
        '2022-11-03T13:30:00', 
        '2022-11-03T17:00:00', 
        'I''m attending yoga-face classes.',
        'My face will look beautiful after that classes. ( even better than now :)  )', 
        '$image_woman_content');";

$stmt = $db->prepare($query);
$stmt->execute();

return $stmt;