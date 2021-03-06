<?php

namespace App\config;

use App\src\Controller\AuthController;
use App\src\Controller\CustomerController;
use App\src\Controller\InvoiceController;
use App\src\Controller\UserController;

class Router
{
    private $customerController;
    private $invoiceController;
    private $authController;
    private $userController;

    public function __construct()
    {
        $this->customerController = new CustomerController();
        $this->invoiceController = new InvoiceController();
        $this->authController = new AuthController();
        $this->userController = new UserController();
    }

    public function run()
    {
        session_start();
        if (!isset($_SESSION['id'])) {
            if ($_GET['route'] !== "auth/register" || $_GET['route'] === "auth/login") {
                $this->authController->login($_POST);
            } else {
                $this->authController->login($_POST);
            }
        }

        if (isset($_GET['route'])) {
            if ($_GET['route'] === "fixtures") {
                $this->customerController->loadFixtures();
                $this->invoiceController->loadFixtures();
            } elseif ($_GET['route'] === "dashboard") {
                $this->invoiceController->showInvoices();
            } elseif ($_GET['route'] === "customers") {
                $this->customerController->showCustomers();
            } elseif ($_GET['route'] === "invoices/add") {
                $this->invoiceController->newInvoice($_POST);
            } elseif ($_GET['route'] === "customers/add") {
                $this->customerController->formCustomer($_POST);
            } elseif ($_GET['route'] === "customers/edit") {
                $this->customerController->formCustomer($_POST, $_GET);
            } elseif ($_GET['route'] === "customers/delete") {
                $this->customerController->deleteCustomer($_GET);
            } elseif ($_GET['route'] === "auth/register") {
                $this->authController->register($_POST);
            } elseif ($_GET['route'] === "auth/logout") {
                $this->authController->logout();
            } elseif ($_GET['route'] === "user/account") {
                $this->userController->account($_POST);
            } elseif ($_GET['route'] === "invoices/delete") {
                $this->invoiceController->delete($_GET);
            } elseif ($_GET['route'] === "invoices/getjson") {
                $this->invoiceController->getInvoicesJson();
            } else {
                // 404
            }
        } else {
            $this->invoiceController->showInvoices();
        }
    }
}
