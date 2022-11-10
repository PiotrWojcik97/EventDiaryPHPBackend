<?php
// Run this script in case of creating whole database with sample data.
// Note that this database must not exist before.


// Include orders matters.
include_once './createDatabase.php';
include_once './createUsersTable.php';
include_once './createTypesTable.php';
include_once './createEventsTable.php';
include_once './insertUsersData.php';
include_once './insertTypesData.php';
include_once './insertEventsData.php';

echo 'success';
