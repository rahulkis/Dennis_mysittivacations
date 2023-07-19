<?php
session_start();
unset($_SESSION);
unset($_SESSION['city_name']);
echo $_SESSION['city_name'];