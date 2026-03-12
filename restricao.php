<?
session_start();

if(!isset($_SESSION['idVoluntario'])){
    header("Location: ./pages/loginFake.html");
    exit;
}
?>