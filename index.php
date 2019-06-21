<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

define('DIR', DIRECTORY_SEPARATOR);
define('ROOT', $_SERVER['DOCUMENT_ROOT'].DIR);

require_once ROOT.'Payment.php';

$payment = new Payment();

echo '<pre>';
print_r(
    $payment->createTransaction(
        array(
            'KART_SAHIBI' => 'ONUR KAYA',
            'TUTAR' => 100,
            'PARA_BIRIMI' => 'YT',
            'TAKSIT_SAYISI' => '00',
            'SIPARIS_NO' => substr(hash('sha256', uniqid()),0,20),
            'ISLEM_TIPI' => 'Sale',
            'KART_NUMARASI' => '4506347022052795',
            'SON_KULLANIM_TARIHI' => '2002',
            'GUVENLIK_KODU' => '000'
        )
    )
);