<?php

session_start();

echo $_SESSION['user_id'] ?? 'No user_id found in session';
echo '<br>';
echo $_SESSION['user_type'] ?? 'No user_type found in session';
echo '<br>';
