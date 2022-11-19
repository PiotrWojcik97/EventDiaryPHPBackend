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
        short_description, 
        long_description, 
        image,
        image_description) 
    VALUES
        ('3',
        '4', 
        'Bali Vacations',
        'I''m going on vacations!',
        'Kid is throwing a party at my place. I don''t wanna be there at that time- perfect time for a vacations!', 
        '$image_dog_vacations_content',
        'dog sitting in a suitcase'),
        ('3',
        '1', 
        'Time with John',
        'I''m spending time with John.',
        'John is coming to my flat. I''ll spend some time with him and teach him giving a hand. Also I''ll eat some snacks during that :)', 
        '$image_dog_human_content',
        'dog giving paw to the man'),
        ('4',
        '4', 
        'Party Preparation',
        'Bath, shave before my second birthday.',
        'I need to look like a god on my party. So I''ll take a shower, shave myself, use perfumes', 
        '$image_baby_shaving_content',
        'baby shaving himself'),
        ('4',
        '3', 
        'Party',
        'Party time!',
        'Everyone is invited in the neighbor. For sure I''ll receive nice presents.', 
        '$image_baby_party_content',
        'baby having a party'),
        ('4',
        '5', 
        'Cleaning',
        'Cleaning after the party.',
        'Poor me that I need to cleanup this whole mess.', 
        '$image_baby_cleaning_content',
        'baby washing plate in a sink'),
        ('5',
        '5', 
        'Face Yoga',
        'I''m attending yoga-face classes.',
        'I''be doing so many face exercises there.', 
        '$image_woman_content',
        'woman with odd face expression');";

$stmt = $db->prepare($query);
$stmt->execute();

return $stmt;