<?
	session_start(); 
	session_destroy();
	header("location:../index.php"); // Re-direct to index.php
?>