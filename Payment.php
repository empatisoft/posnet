<?php
/**
 * Class Payment
 *
 * Yapı Kredi 3D Ödeme Sınıfı
 *
 * Onur KAYA
 * empatisoft@gmail.com
 */

define('MID', '6797752273');
define('TID', '67011690');
define('POSNETID', '11030');
define('ENCKEY', '10,10,10,10,10,10,10,10');
define('OOS_TDS_SERVICE_URL', 'https://setmpos.ykb.com/3DSWebService/YKBPaymentService');
define('XML_SERVICE_URL', 'https://setmpos.ykb.com/PosnetWebService/XML');
define('LOCALHOST', 'http://localhost:7070/Web%20Test/kk_provizyon.php');
define('USEMCRYPTLIBRARY', false);
define('XML_USERNAME', '');
define('XML_PASSWORD', '');
define('XML_KEY', '');
define('POSNET_MODULES_DIR', ROOT.'vendor'.DIR.'posnet'.DIR);

class Payment {

    public function __construct()
    {

    }

    /**
     * @param $data
     * @return array
     *
     * Parametreler array olarak gönderilir.
     */
    public function createTransaction($data) {

        /**
         * Kart Sahibi
         */
        $cardholdername = isset($data['KART_SAHIBI']) ? $data['KART_SAHIBI'] : NULL;

        /**
         * Sipariş tutarı
         */
        $amount = isset($data['TUTAR']) ? $data['TUTAR'] : 0;

        /**
         * Para Birimi: YT, US, EU
         */
        $currency = isset($data['PARA_BIRIMI']) ? $data['PARA_BIRIMI'] : 'YT';

        /**
         * Taksit Sayısı: Peşin işlemler için 00
         */
        $instnumber = isset($data['TAKSIT_SAYISI']) ? $data['TAKSIT_SAYISI'] : 00;

        /**
         * Sipariş numarası: 20 karakter olmalı
         */
        $xid = isset($data['SIPARIS_NO']) ? $data['SIPARIS_NO'] : NULL;

        /**
         * İşlem Tipi
         *
         * Sale -> Satış
         * Auth -> Provizyon
         * WP -> World Puan Kullanım
         * SaleWP -> Satış ve World Puan Kullanım
         * Vft -> Vade Farklı Satış

         */
        $trantype = isset($data['ISLEM_TIPI']) ? $data['ISLEM_TIPI'] : 'Sale';

        /**
         * Kart Numarası
         */
        $ccno = isset($data['KART_NUMARASI']) ? $data['KART_NUMARASI'] : NULL;

        /**
         * Son kullanım tarihi: YYAA, Örnek: 1906 -> Haziran 2019
         */
        $expdate = isset($data['SON_KULLANIM_TARIHI']) ? $data['SON_KULLANIM_TARIHI'] : NULL;

        /**
         * Kart güvenlik numarası
         */
        $cvc = isset($data['GUVENLIK_KODU']) ? $data['GUVENLIK_KODU'] : NULL;

        /**
         * Pos sınıfı çağrılıyor ve işlem oluşturuluyor.
         */
        require_once ROOT.'vendor'.DIR.'posnet'.DIR.'posnet_oos'.DIR.'posnet_oos.php';

        $oos = new PosnetOOS();
        $transaction = $oos->CreateTranRequestDatas($cardholdername, $amount, $currency, $instnumber, $xid, $trantype, $ccno, $expdate, $cvc);

        /**
         * İşlem başarıyla döndürüldü.
         */
        if($transaction == true) {
            $result = array(
                'success' => false,
                'message' => 'Hata oluştu',
                'data_1' => $oos->GetData1(),
                'data_2' => $oos->GetData2(),
                'response' => $oos->GetResponseXMLData(),
                'error_code' => NULL,
                'error_text' => NULL,
                'digest' => $oos->GetSign()
            );
        } else {
            $result = array(
                'success' => false,
                'message' => 'Hata oluştu',
                'data_1' => $oos->GetData1(),
                'data_2' => $oos->GetData2(),
                'response' => $oos->GetResponseXMLData(),
                'error_code' => $oos->GetResponseCode(),
                'error_text' => $oos->GetResponseText(),
                'digest' => NULL
            );
        }

        return $result;
    }



}