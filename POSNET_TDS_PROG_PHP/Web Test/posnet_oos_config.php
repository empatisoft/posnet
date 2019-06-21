<?php
	error_reporting(E_ALL ^ (E_WARNING | E_NOTICE));//Warninglerin ya da Noticelerin gosterilmesini engeller.
    /*
     * posnet_oos_config.php
     *
     */

    /**
     * @package posnet oos
     */

    //Configuration parameters
    define('MID', '6797752273');
    define('TID', '67011690');
    define('POSNETID', '11030');
    define('ENCKEY', '10,10,10,10,10,10,10,10');
    
    //Posnet Sistemi ile ilgili parametreler
    
    //OOS/TDS sisteminin web adresi
    define('OOS_TDS_SERVICE_URL', 'https://setmpos.ykb.com/3DSWebService/YKBPaymentService');
    //Posnet XML Servisinin web adresi
    define('XML_SERVICE_URL', 'https://setmpos.ykb.com/PosnetWebService/XML');
	
	define('LOCALHOST','http://localhost:7070/Web%20Test/kk_provizyon.php');//localhost port bilgisi degistirilmis ise, :80 degerini guncelleyiniz.
        
    define('USEMCRYPTLIBRARY', true);
?>