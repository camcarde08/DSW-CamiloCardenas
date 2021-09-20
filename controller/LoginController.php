<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of LogingController
 *
 * @author hruge
 */
class LoginController {

    function login() {

        if (isset($_POST['username']) && isset($_POST['password'])) {

            $dbClass = new DbClass();
            $dbClass->conexion();
            $dbClass->login($_POST['username'], $_POST['password']);
            if ($_SESSION['logued']) {
                $loginModel = new LoginModelClass();
                $loginModel->paintWelcomePage();
            } else {
                $loginModel = new LoginModelClass();
                $loginModel->paintFailLogingPage();
            }
        } else {
            if ($_SESSION['logued'] == true) {
                $loginModel = new LoginModelClass();
                $loginModel->paintWelcomePage();
            } else {
                $loginModel = new LoginModelClass();
                $loginModel->paintLogingPage();
            }
        }
    }

    function login2() {

        if (isset($_POST['username']) && isset($_POST['password'])) {

            $dbClass = new DbClass();
            $dbClass->conexion();
            return $dbClass->login2($_POST['username'], $_POST['password']);
        } else {
            return false;
        }
    }

}
