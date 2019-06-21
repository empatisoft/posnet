<?php
    /*
     * posnet_oos_struct.php
     *
     */

     /**
     * @package posnet oos
     */
	class Session {
		
		var $merchantNo;
		/**
         * Sign of parameters
         * @var string
         */
		var $terminalNo;
		/**
         * Sign of parameters
         * @var string
         */
		var $amount;
		/**
         * Sign of parameters
         * @var string
         */
		var $currency;
		/**
         * Sign of parameters
         * @var string
         */
		var $xid;
		/**
         * Sign of parameters
         * @var string
         */
		var $responseHostlogKey;
	}
    /**
     * It is used for a template class for merchant info
     */
    class MerchantInfo {
        /**
         * Posnet ID (1 - 6 char)
         * @var string
         */
        var $posnetid = "";
        /**
         * Merchant ID (10 char)
         * @var string
         */
        var $mid = "";
        /**
         * Terminal ID (8 char)
         * @var string
         */
        var $tid = "";
        /**
         * Username (8 char) for being used to login Posnet XML Service
         * @var string
         */
        var $username = "";
        /**
         * Password (8 char) for being used to login Posnet XML Service
         * @var string
         */
        var $password = "";
         /**
         * @var string
         */
        var $enckey = "";
    };
     
     
    /**
     * It is used for a template class for transaction requests
     */
    class PosnetOOSRequest {
        /**
         * Creditcard number (16-19 char)
         * @var string
         */
        var $ccno; // min 16 char, max 21 char
        /**
         * Expire date of the credit card (4 chars). 2 Digits year, 2 digits month (YYMM).
         * e.g. 0712
         * @var string
         */
        var $expdate;
        /**
         * CVC(3 chars) of the credit card. "XXX" can be specified in test environment.
         * @var string
         */
        var $cvc;
        /**
         * XID(20 chars). Distinguishes this transaction from the others.
         * Should be different in each authorization or sale transaction.
         * Can be alpha-numeric. To specify a distinct one in each authorization,
         * e.g. 67000000670104031615
         * @var string
         */
        var $xid;
        /**
         * Transaction amount (1-12 chars) in YKr (100 YTLs) (12 chars). Last 2 digits are always assumed to be YKr.
         * Should contain no thousands or decimal separator.
         * e.g. 10 YTL : 1000
         * e.g. 1.015,16 YTL : 101516
         * @var string
         */
        var $amount;
        /**
         * Curency Code (2 chars) for a transaction request
         * e.g. : YT
         * @var string
         */
        var $currency;
        /**
         * Instalment number (2 chars). Specifies number of instalments.
         * If no instalment will be made, 0 should be specified.
         * e.g. : 03
         * @var string
         */
        var $instnumber;
        /**
         * Type of a transaction.
         * e.g. : Auth or Sale
         * @var string
         */
        var $trantype;
        /**
         * CardHolder Name (1 - 50 chars)
         * e.g. : XXXX YYYYYYY
         * @var string
         */
        var $cardholdername;

        /**
         * BankData
         * @var string
         */
        var $bankData = "";
        /**
         * Merchant Data
         * @var string
         */
        var $merchantData = "";
        /**
         * Sign of parameters
         * @var string
         */
        var $sign = "";
		 /**
         * Sign of parameters
         * @var string
         */
		var $mac = "";
    };

    /**
     * It is used for a template class for oos transaction responses
     */
    class PosnetOOSResponse {
        /**
         * Result of transaction (1 char). Shows if the transaction was approved.
         *  '0�: Approved
         *  �1�: Not approved
         *  �2�: Approved just before a time
         * @var string
         */
        var $approved;
        /**
         * Response Code (1 - 4 chars). Error code if transaction is not approved.
         * It is recommended to check this parameter rather than Responsetext.
         * Because error codes don't change, but error descriptions do.
         * You can display your own error message for common errors
         * (such as wrong expire date) by checking this parameter.
         * @var string
         */
        var $errorcode;
        /**
         * Response Text (1 - 50 chars). Short description of the error if transaction is not approved.
         * @var string
         */
        var $errormessage;
        /**
         * data1 is used for redirecting to YKB Site
         * @var string
         */
        var $data1;
        /**
         * data2 is used for redirecting to YKB Site with CreditCard Parameters
         * @var string
         */
        var $data2;
        /**
         * sign
         * @var string
         */
        var $sign;

        /**
         * Merchant ID (10 char)
         * @var string
         */
        var $mid = "";
        /**
         * Terminal ID (8 char)
         * @var string
         */
        var $tid = "";
        /**
         * Hostlogkey (18 chars) returned from authorization or sale transaction.
         * This value will be used in the reversal or capture of this transaction. * @var string
         * @var string
         */
        var $hostlogkey = "";
        /**
         * Authorization code (6 chars) returned from authorization or sale transaction.
         * This value will be used in the reversal or capture of this transaction.
         * @var string
         */
        var $authcode = "";

        /**
         * Instalment number (2 chars).
         * @var string
         */
        var $instcount = "";
        /**
         * Amount (1-12 chars) of each instalment.
         * @var string
         */
        var $instamount = "";

        /**
         * WorldPoints (8 chars) gained from this transaction.
         * @var string
         */
        var $point = "";
        /**
         * YTL equivalent (12 chars) of  WorldPoints gained from this transaction.
         * @var string
         */
        var $pointAmount = "";
        /**
         * WorldPoints (8 chars) the card holder has.
         * @var string
         */
        var $totalPoint = "";
        /**
         * YTL equivalent (12 chars) of  WorldPoints the card holder has.
         * @var string
         */
        var $totalPointAmount ="";
        /**
         * XID(20 chars). Distinguishes this transaction from the others.
         * Should be different in each authorization, sale or bonus usage transaction.
         * Can be alpha-numeric.
         * e.g. YKB_0000050228175132
         * @var string
         */
        var $xid = "";
        /**
         * Transaction amount (1-12 chars) in YKr (100 YTLs) (12 chars). Last 2 digits are always assumed to be YKr.
         * Should contain no thousands or decimal separator.
         * e.g. 10 YTL : 1000
         * e.g. 1.015,16 YTL : 101516
         * @var string
         */
        var $amount = "";
        /**
         * Curency Code (2 chars) for a transaction request
         * e.g. : YT
         * @var string
         */
        var $currency = "";
        /**
         * Web URL of XML Service (not used)
         * @var string
         */
        var $weburl;
        /**
         * Server IP  (not used)
         * @var string
         */
        var $hostip;
        /**
         * Server port  (not used)
         * @var string
         */
        var $port;
        /**
         * ThreeD Secure transaction status
         * @var string
         */
        var $tds_tx_status;
        /**
         * ThreeD Secure result code
         * @var string
         */
        var $tds_md_status;
        /**
         * ThreeD Secure error message
         * @var string
         */
        var $tds_md_errormessage;
        /**
         * Amount (1-12 chars) of vade applied to vft transaction.
         * @var string
         */
        var $vft_amount;
        /**
         * Interest Rate (6 chars) for vft transaction.
         * @var string
         */
        var $vft_rate;
        /**
         * VFT Day Count (4 chars) is the difference between first instalment payment date
         * and transaction date.
         * @var string
         */
        var $vft_daycount;
        /**
         * Tran time
         * @var string
         */
        var $trantime;
        /**
         * Kontur amount (1-12 chars) in YKr (100 YTLs) (12 chars). Last 2 digits are always assumed to be YKr.
         * Should contain no thousands or decimal separator.
         * e.g. 10 YTL : 1000
         * e.g. 1.015,16 YTL : 101516
         * @var string
         */
        var $kontur_amount = "";
        
		var $mac = "";

        function __construct() {
            $this->Init();
        }

        /**
         * Initialize parameters
         * @access protected
         */
        function Init() {
            $this->approved = "0";
            $this->errorcode = "";
            $this->errormessage = "";

            $this->data1 = "";
            $this->data2 = "";
            $this->sign = "";

            $this->weburl = "";
            $this->hostip = "";
            $this->port = "";

            $this->tds_tx_status = "";
            $this->tds_md_status = "";
            $this->tds_md_errormessage = "";

            $this->trantime = "";
        }
    };
?>
