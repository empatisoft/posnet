<?php
    /*
     * posnet_oos.php
     *
     */

    /**
     * @package posnet oos
     */

    define('INTERVALTIMEFORPOSNETTRAN', 2 * 60 * 60 * 1000);

    // Include posnet xml library
    require_once('posnet_oos_xml.php');
    // Include posnet http library
    require_once(POSNET_MODULES_DIR . 'posnet_http'.DIR.'posnet_http.php');
    // Include posnet encryption library
    require_once(POSNET_MODULES_DIR . 'posnet_enc'.DIR.'posnet_enc.php');

    class PosnetOOS {
        
        /**
         * reference for MerchantInfo Class
         * @access private
         */
        var $merchantInfo;

        /**
         * reference for PosnetOOSResponse Class
         * @access private
         */
        var $posnetOOSResponse;

        /**
         * temporary reference for request XML data
         * @access private
         */
        var $strRequestXMLData;

        /**
         * temporary reference for response XML data
         * @access private
         */
        var $strResponseXMLData;

        /**
         * reference for PosnetResponseXML Array
         * @access private
         */
        var $arrayPosnetResponseXML;

        /**
         * xml wenb service url
         * @access private
         */
        
        var $url = "";
        
        /**
         * world point amount
         * @access private
         */
        var $wpAmount = "0";
        
        /**
         * Used for debugging
         * @access protected
         */
        var $debug = 0;

	/**
         * Used for timezone setting
         * @access protected
         */
	var $GMT_TUR = 2;

        /**
         * Constructor
         * @access private
         */
        Function __construct() {
            $this->merchantInfo = new MerchantInfo;
            $this->strRequestXMLData = "";
            $this->strResponseXMLData = "";

            $this->SetPosnetID(POSNETID);
            $this->SetMid(MID);
            $this->SetTid(TID);

            //XML Servisi i�in
            $this->SetURL(XML_SERVICE_URL);
            $this->SetUsername(XML_USERNAME);
            $this->SetPassword(XML_PASSWORD);
            $this->SetKey(XML_KEY);
        }

        /**
         * This function is used to set debug level.
         * @param string $debuglevel
         */
        Function SetDebugLevel($debuglevel) {
            if ($debuglevel > 0)
                $this->debug = 1;
        }

        /**
         * Get & Set OOS Response parameters from XML array according to reqcode
         * @param string $reqcode
         * @access protected
         */
        Function SetResponseParameters($reqcode) {

            if (array_key_exists("posnetResponse", $this->arrayPosnetResponseXML)) {
                if (array_key_exists("approved", $this->arrayPosnetResponseXML['posnetResponse']))
                    $this->posnetOOSResponse->approved = $this->arrayPosnetResponseXML['posnetResponse']['approved'];
                if (array_key_exists("respCode", $this->arrayPosnetResponseXML['posnetResponse']))
                    $this->posnetOOSResponse->errorcode = $this->arrayPosnetResponseXML['posnetResponse']['respCode'];
                if (array_key_exists("respText", $this->arrayPosnetResponseXML['posnetResponse']))
                    $this->posnetOOSResponse->errormessage = $this->arrayPosnetResponseXML['posnetResponse']['respText'];

                //OOS RequestDataResponse
                if ($reqcode == "0") {
                    if (array_key_exists("oosRequestDataResponse", $this->arrayPosnetResponseXML['posnetResponse'])) {
						if(isset($this->arrayPosnetResponseXML['posnetResponse']['oosRequestDataResponse']['data1']))
							$this->posnetOOSResponse->data1 = $this->arrayPosnetResponseXML['posnetResponse']['oosRequestDataResponse']['data1'];
						if(isset($this->arrayPosnetResponseXML['posnetResponse']['oosRequestDataResponse']['data2']))
							$this->posnetOOSResponse->data2 = $this->arrayPosnetResponseXML['posnetResponse']['oosRequestDataResponse']['data2'];
						if(isset($this->arrayPosnetResponseXML['posnetResponse']['oosRequestDataResponse']['sign']))
							$this->posnetOOSResponse->sign = $this->arrayPosnetResponseXML['posnetResponse']['oosRequestDataResponse']['sign'];
                    }
                }
                //OOS ResolveMerchantDataResponse
                else if($reqcode == "1") {
                    if (array_key_exists("oosResolveMerchantDataResponse", $this->arrayPosnetResponseXML['posnetResponse'])) {
						if(isset($this->arrayPosnetResponseXML['posnetResponse']['oosResolveMerchantDataResponse']['xid']))
							$this->posnetOOSResponse->xid = $this->arrayPosnetResponseXML['posnetResponse']['oosResolveMerchantDataResponse']['xid'];
						if(isset($this->arrayPosnetResponseXML['posnetResponse']['oosResolveMerchantDataResponse']['amount']))
                            $this->posnetOOSResponse->amount = $this->arrayPosnetResponseXML['posnetResponse']['oosResolveMerchantDataResponse']['amount'];
						if(isset($this->arrayPosnetResponseXML['posnetResponse']['oosResolveMerchantDataResponse']['currency']))
							$this->posnetOOSResponse->currency = $this->arrayPosnetResponseXML['posnetResponse']['oosResolveMerchantDataResponse']['currency'];
						if(isset($this->arrayPosnetResponseXML['posnetResponse']['oosResolveMerchantDataResponse']['installment']))
							$this->posnetOOSResponse->instcount = $this->arrayPosnetResponseXML['posnetResponse']['oosResolveMerchantDataResponse']['installment'];
						if(isset($this->arrayPosnetResponseXML['posnetResponse']['oosResolveMerchantDataResponse']['point']))
							$this->posnetOOSResponse->totalPoint = $this->arrayPosnetResponseXML['posnetResponse']['oosResolveMerchantDataResponse']['point'];
						if(isset($this->arrayPosnetResponseXML['posnetResponse']['oosResolveMerchantDataResponse']['pointAmount']))
							$this->posnetOOSResponse->totalPointAmount = $this->arrayPosnetResponseXML['posnetResponse']['oosResolveMerchantDataResponse']['pointAmount'];
						if(isset($this->arrayPosnetResponseXML['posnetResponse']['oosResolveMerchantDataResponse']['txStatus']))
							$this->posnetOOSResponse->tds_tx_status = $this->arrayPosnetResponseXML['posnetResponse']['oosResolveMerchantDataResponse']['txStatus'];
						if(isset($this->arrayPosnetResponseXML['posnetResponse']['oosResolveMerchantDataResponse']['mdStatus']))
							$this->posnetOOSResponse->tds_md_status = $this->arrayPosnetResponseXML['posnetResponse']['oosResolveMerchantDataResponse']['mdStatus'];
						if(isset($this->arrayPosnetResponseXML['posnetResponse']['oosResolveMerchantDataResponse']['mdErrorMessage']))
							$this->posnetOOSResponse->tds_md_errormessage = $this->arrayPosnetResponseXML['posnetResponse']['oosResolveMerchantDataResponse']['mdErrorMessage'];
                        if(isset($this->arrayPosnetResponseXML['posnetResponse']['oosResolveMerchantDataResponse']['mac']))
							$this->posnetOOSResponse->mac = $this->arrayPosnetResponseXML['posnetResponse']['oosResolveMerchantDataResponse']['mac'];
                        }
                }
                //OOS Transaction Response Data
                else if($reqcode == "2") {
                    if (array_key_exists("authCode", $this->arrayPosnetResponseXML['posnetResponse']))
					{
						if(isset($this->arrayPosnetResponseXML['posnetResponse']['authCode']))
							$this->posnetOOSResponse->authcode = $this->arrayPosnetResponseXML['posnetResponse']['authCode'];
					} 
                    if (array_key_exists("hostlogkey", $this->arrayPosnetResponseXML['posnetResponse']))
					{
						if(isset($this->arrayPosnetResponseXML['posnetResponse']['hostlogkey']))
							$this->posnetOOSResponse->hostlogkey = $this->arrayPosnetResponseXML['posnetResponse']['hostlogkey'];
                    }
                    if (array_key_exists("mac", $this->arrayPosnetResponseXML['posnetResponse']))
					{
						if(isset($this->arrayPosnetResponseXML['posnetResponse']['mac']))
							$this->posnetOOSResponse->mac = $this->arrayPosnetResponseXML['posnetResponse']['mac'];
					} 
                    //Point Info
                    if (array_key_exists("pointInfo", $this->arrayPosnetResponseXML['posnetResponse'])) {
                        if (array_key_exists("point", $this->arrayPosnetResponseXML['posnetResponse']['pointInfo']))
						{
							if(isset($this->arrayPosnetResponseXML['posnetResponse']['pointInfo']['point']))
								$this->posnetOOSResponse->point = $this->arrayPosnetResponseXML['posnetResponse']['pointInfo']['point'];
						}
                        if (array_key_exists("pointAmount", $this->arrayPosnetResponseXML['posnetResponse']['pointInfo']))
						{
							if(isset($this->arrayPosnetResponseXML['posnetResponse']['pointInfo']['pointAmount']))
								$this->posnetOOSResponse->pointAmount = $this->arrayPosnetResponseXML['posnetResponse']['pointInfo']['pointAmount'];
						}
                        if (array_key_exists("totalPoint", $this->arrayPosnetResponseXML['posnetResponse']['pointInfo']))
						{
							if(isset($this->arrayPosnetResponseXML['posnetResponse']['pointInfo']['totalPoint']))
								$this->posnetOOSResponse->totalPoint = $this->arrayPosnetResponseXML['posnetResponse']['pointInfo']['totalPoint'];
						}
                        if (array_key_exists("totalPointAmount", $this->arrayPosnetResponseXML['posnetResponse']['pointInfo']))
						{
							if(isset($this->arrayPosnetResponseXML['posnetResponse']['pointInfo']['totalPointAmount']))
								$this->posnetOOSResponse->totalPointAmount = $this->arrayPosnetResponseXML['posnetResponse']['pointInfo']['totalPointAmount'];
						}
                    }
                    //Instalment Info
                    if (array_key_exists("instInfo", $this->arrayPosnetResponseXML['posnetResponse'])) {
						if(isset($this->arrayPosnetResponseXML['posnetResponse']['instInfo']['inst1']))
							$this->posnetOOSResponse->instcount = $this->arrayPosnetResponseXML['posnetResponse']['instInfo']['inst1'];
						if(isset($this->arrayPosnetResponseXML['posnetResponse']['instInfo']['amnt1']))
							$this->posnetOOSResponse->instamount = $this->arrayPosnetResponseXML['posnetResponse']['instInfo']['amnt1'];
                    }
                    //VFT Info
                    if (array_key_exists("vftInfo", $this->arrayPosnetResponseXML['posnetResponse'])) {
						if(isset($this->arrayPosnetResponseXML['posnetResponse']['vftInfo']['vftAmount']))
							$this->posnetOOSResponse->vft_amount = $this->arrayPosnetResponseXML['posnetResponse']['vftInfo']['vftAmount'];
						if(isset($this->arrayPosnetResponseXML['posnetResponse']['vftInfo']['vftRate']))
							$this->posnetOOSResponse->vft_rate = $this->arrayPosnetResponseXML['posnetResponse']['vftInfo']['vftRate'];
						if(isset($this->arrayPosnetResponseXML['posnetResponse']['vftInfo']['vftDayCount']))
							$this->posnetOOSResponse->vft_daycount = $this->arrayPosnetResponseXML['posnetResponse']['vftInfo']['vftDayCount'];
                    }
                    //Kontur Info
                    if (array_key_exists("konturInfo", $this->arrayPosnetResponseXML['posnetResponse'])) {
						if(isset($this->arrayPosnetResponseXML['posnetResponse']['konturInfo']['konturAmount']))
							$this->posnetOOSResponse->kontur_amount = $this->arrayPosnetResponseXML['posnetResponse']['konturInfo']['konturAmount'];
                    }
		            //OOS ResolveMerchantDataResponse
                    if (array_key_exists("oosResolveMerchantDataResponse", $this->arrayPosnetResponseXML['posnetResponse'])) {
						if(isset($this->arrayPosnetResponseXML['posnetResponse']['oosResolveMerchantDataResponse']['xid']))
							$this->posnetOOSResponse->xid = $this->arrayPosnetResponseXML['posnetResponse']['oosResolveMerchantDataResponse']['xid'];
						if(isset($this->arrayPosnetResponseXML['posnetResponse']['oosResolveMerchantDataResponse']['amount']))
							$this->posnetOOSResponse->amount = $this->arrayPosnetResponseXML['posnetResponse']['oosResolveMerchantDataResponse']['amount'];
						if(isset($this->arrayPosnetResponseXML['posnetResponse']['oosResolveMerchantDataResponse']['currency']))
							$this->posnetOOSResponse->currency = $this->arrayPosnetResponseXML['posnetResponse']['oosResolveMerchantDataResponse']['currency'];
						if(isset($this->arrayPosnetResponseXML['posnetResponse']['oosResolveMerchantDataResponse']['installment']))
							$this->posnetOOSResponse->instcount = $this->arrayPosnetResponseXML['posnetResponse']['oosResolveMerchantDataResponse']['installment'];
						if(isset($this->arrayPosnetResponseXML['posnetResponse']['oosResolveMerchantDataResponse']['txStatus']))
							$this->posnetOOSResponse->tds_tx_status = $this->arrayPosnetResponseXML['posnetResponse']['oosResolveMerchantDataResponse']['txStatus'];
						if(isset($this->arrayPosnetResponseXML['posnetResponse']['oosResolveMerchantDataResponse']['mdStatus']))
							$this->posnetOOSResponse->tds_md_status = $this->arrayPosnetResponseXML['posnetResponse']['oosResolveMerchantDataResponse']['mdStatus'];
						if(isset($this->arrayPosnetResponseXML['posnetResponse']['oosResolveMerchantDataResponse']['mdErrorMessage']))
							$this->posnetOOSResponse->tds_md_errormessage = $this->arrayPosnetResponseXML['posnetResponse']['oosResolveMerchantDataResponse']['mdErrorMessage'];
                        if(isset($this->arrayPosnetResponseXML['posnetResponse']['oosResolveMerchantDataResponse']['mac']))
							$this->posnetOOSResponse->mac = $this->arrayPosnetResponseXML['posnetResponse']['oosResolveMerchantDataResponse']['mac'];
                    }
                }
            }
        }
        /**
         * Main function for Posnet OOS Transactions. Create XML, connect with HTTP(S),receive and parse XML response
         * @param PosnetOOSRequest $posnetOOSRequest
         * @param string $reqcode
         * @access protected
         */
        Function DoTran($posnetOOSRequest, $reqcode) {

            //set_time_limit(0);

            //Create Posnet Response Class
            $this->posnetOOSResponse = new PosnetOOSResponse();

            //Create Request XML
            $posnetOOSXML = new PosnetOOSXML();

            //Create Posnet HTTP Class
            $posnetHTTPConn = new PosnetHTTPConection($this->url);

            if ($this->debug > 0)
                $posnetHTTPConn->SetDebugLevel($this->debug);

            $this->strRequestXMLData = $posnetOOSXML->CreateXMLForPosnetOOSTransaction($this->merchantInfo,
                $posnetOOSRequest,
                $reqcode);

            if ($this->strRequestXMLData == "") {
                $this->posnetOOSResponse->errorcode = "999";
                $this->posnetOOSResponse->errormessage = "XML Create Error : ".$posnetOOSXML->error;
                return false;
            }

            // Show XML result
            if ($this->debug) {
                echo "<H2><LI>XML creation:</LI</H2>\n<PRE>\n";
                echo HtmlSpecialChars($this->strRequestXMLData);
                echo "</PRE>\n";
            }

            // Send and Receive Data with HTTP
            $this->strResponseXMLData = urldecode($posnetHTTPConn->SendDataAndGetResponse($this->strRequestXMLData));
            if ($this->strResponseXMLData == "") {
                $this->posnetOOSResponse->errorcode = "999";
                $this->posnetOOSResponse->errormessage = "HTTP Connection Error : ".$posnetHTTPConn->error;
                return false;
            }

            if ($this->debug) {
                echo "<H2><LI>Response body:</LI</H2>\n<PRE>\n";
                echo HtmlSpecialChars($this->strResponseXMLData);
                echo "</PRE>\n";
            }

            //Parse Response XML
            $this->arrayPosnetResponseXML = $posnetOOSXML->ParseXMLForPosnetOOSTransaction($this->strResponseXMLData);

            if ($this->debug) {
                echo "<H2><LI>Response XML Array :</LI</H2>\n<PRE>\n";
                print_r ($this->arrayPosnetResponseXML);
                echo "</pre>";
            }

            if (count($this->arrayPosnetResponseXML) == 0) {
                if ($this->debug)
                    echo "<H2><LI>Unable to parse XML !</LI</H2>\n<PRE>\n";
                $this->posnetOOSResponse->errorcode = "999";
                $this->posnetOOSResponse->errormessage = "XML Parse Error : ".$posnetOOSXML->error;
                return false;
            } else {
                $this->SetResponseParameters($reqcode);
                if ($this->GetApprovedCode() == "0")
                    return false;
            }
            return true;
        }

        /**
         * Check sign for the response parameters from YKB Site
         * @param string $merchantData
         * @param string $bankData
         * @param string $sign
         * @param string $key
         * @access protected
         * @return bool
         */
        Function CheckSignForMercSite($merchantData,
            $bankData,
            $sign,
            $key ) {

            if($merchantData == "" || $bankData == "" || $sign == "")
            {
                $this->posnetOOSResponse->errorcode = "444";
                $this->posnetOOSResponse->errormessage = "GECERSIZ DATA ( Merchant Data=".$merchantData." - Bank Data=".$bankData." - Sign=".$sign." )";
                return false;
            }

            $data = $merchantData.$bankData.$key;
            $hash = strtoupper(md5($data));
            if (strcmp($hash, $sign) == 0) {
                return true;
            } else {
                $this->posnetOOSResponse->errorcode = "444";
                $this->posnetOOSResponse->errormessage = "IMZA GECERLI DEGIL (".$hash.")";
                if ($this->debug)
                    echo($this->posnetOOSResponse->errormessage);
                return false;
            }
        }

        /**
         * Check merchant data that is sent from YKB Site
         * @access protected
         * @return bool
         */
        Function CheckMerchantData() {
	    //$timedif = $this->GMT_TUR*3600-(date("Z")-(date("I")*3600));
	    //$now = (time()+$timedif) * 1000;
            $now = time() * 1000;
            $minTime = $now - INTERVALTIMEFORPOSNETTRAN;
            $maxTime = $now + INTERVALTIMEFORPOSNETTRAN;

            if ($this->posnetOOSResponse->trantime < $minTime || $this->posnetOOSResponse->trantime > $maxTime ) {
                $this->posnetOOSResponse->errorcode = "444";
                $this->posnetOOSResponse->errormessage = "ISLEM ZAMANI UYUMSUZ";
                if ($this->debug)
                    echo($this->posnetOOSResponse->errormessage);
                return false;
            }
            if (strcmp($this->posnetOOSResponse->mid, $this->merchantInfo->mid) != 0 || strcmp($this->posnetOOSResponse->tid, $this->merchantInfo->tid) != 0 ) {
                $this->posnetOOSResponse->errorcode = "444";
                $this->posnetOOSResponse->errormessage = "MID TID UYUMSUZ";
                if ($this->debug)
                    echo($this->posnetOOSResponse->errormessage);
                return false;
            }
            return true;
        }

        /* Public methods */

        /**
         * It is used for creating OOS request datas
         * @param string $cardholdername
         * @param string $amount
         * @param string $currency
         * @param string $instnumber
         * @param string $xid
         * @param string $ccno
         * @param string $expdate
         * @param string $cvc
         * @return bool
         */
        Function CreateTranRequestDatas($cardholdername,
            $amount,
            $currency,
            $instnumber,
            $xid,
            $trantype,
            $ccno = "",
            $expdate = "",
            $cvc = "") {

            $posnetOOSRequest = new PosnetOOSRequest();

            if ($ccno == NULL)
                $posnetOOSRequest->ccno = "";
            else
                $posnetOOSRequest->ccno = $ccno;

            if ($expdate == NULL)
                $posnetOOSRequest->expdate = "";
            else
                $posnetOOSRequest->expdate = $expdate;

            if ($cvc == NULL)
                $posnetOOSRequest->cvc = "";
            else
                $posnetOOSRequest->cvc = $cvc;

            $posnetOOSRequest->cardholdername = $cardholdername;
            $posnetOOSRequest->amount = $amount;
            $posnetOOSRequest->currency = $currency;
            $posnetOOSRequest->instnumber = $instnumber;
            $posnetOOSRequest->xid = $xid;
            $posnetOOSRequest->tranType = $trantype;

            return $this->DoTran($posnetOOSRequest, "0");
        }

	/**
         * It is used for creating OOS request datas for Hazirkart Transaction
         * @param string $cardholdername
         * @param string $kontur
         * @param string $currency
         * @param string $xid
         * @param string $ccno
         * @param string $expdate
         * @param string $cvc
         * @return bool
         */
        Function CreateTranRequestDatas_ForHZ($cardholdername,
            $kontur,
            $currency,
            $xid,
            $ccno = "",
            $expdate = "",
            $cvc = "") {

            $posnetOOSRequest = new PosnetOOSRequest();

            if ($ccno == NULL)
                $posnetOOSRequest->ccno = "";
            else
                $posnetOOSRequest->ccno = $ccno;

            if ($expdate == NULL)
                $posnetOOSRequest->expdate = "";
            else
                $posnetOOSRequest->expdate = $expdate;

            if ($cvc == NULL)
                $posnetOOSRequest->cvc = "";
            else
                $posnetOOSRequest->cvc = $cvc;

            $posnetOOSRequest->cardholdername = $cardholdername;
            $posnetOOSRequest->amount = $kontur;
            $posnetOOSRequest->currency = $currency;
            $posnetOOSRequest->instnumber = "00";
            $posnetOOSRequest->xid = $xid;
            $posnetOOSRequest->tranType = "HZKart";

            return $this->DoTran($posnetOOSRequest, "0");
        }

        /**
         * It is used for checking and resolving OOS response datas (merchantData and bankData) from YKB Site
         * By this function, merchant can acquire info about requested transaction by decrypting merchantData
         * @param string $merchantData
         * @param string $bankData
         * @param string $sign
         * @return bool
         */
        Function CheckAndResolveMerchantData($merchantData,
            $bankData,
            $sign) {

            //Create Posnet Response Class
            $this->posnetOOSResponse = new PosnetOOSResponse();

            if (!$this->CheckSignForMercSite($merchantData,
                $bankData,
                $sign,
                $this->merchantInfo->enckey))
            return false;

            //Use MCrypt Library
            if (USEMCRYPTLIBRARY) {

                if (!function_exists("mcrypt_module_open")) {
                    $this->posnetOOSResponse->errormessage = "MCRYPT MODULU YUKLU DEGIL";
                    return false;
                }

                $posnetENC = new PosnetENC();
                //Decrypt Data
                $decryptedData = $posnetENC->Decrypt($merchantData, $this->merchantInfo->enckey);
                $posnetENC->DeInit();

                if ($this->debug)
                    echo ("<br>Decryptyed Data : ".$decryptedData."<BR>");

                if ($decryptedData == "") {
                    $this->posnetOOSResponse->errormessage = $posnetENC->error;
                    return false;
                }

                //Seperate parameters
                list($this->posnetOOSResponse->mid,
                    $this->posnetOOSResponse->tid,
                    $this->posnetOOSResponse->amount,
                    $this->posnetOOSResponse->instcount,
                    $this->posnetOOSResponse->xid,
                    $this->posnetOOSResponse->totalPoint,
                    $this->posnetOOSResponse->totalPointAmount,
                    $this->posnetOOSResponse->weburl,
                    $this->posnetOOSResponse->hostip,
                    $this->posnetOOSResponse->port,
                    $this->posnetOOSResponse->tds_tx_status,
                    $this->posnetOOSResponse->tds_md_status,
                    $this->posnetOOSResponse->tds_md_errormessage,
                    $this->posnetOOSResponse->trantime,
                    $this->posnetOOSResponse->currency ) = explode(";", $decryptedData);

                if (!$this->CheckMerchantData())
                    return false;

                //$this->posnetOOSResponse->errormessage = "SUCCESS";
                return true;
            }
            //Use XML Service
            else
                {
                $posnetOOSRequest = new PosnetOOSRequest();

                $posnetOOSRequest->bankData = $bankData;
                $posnetOOSRequest->merchantData = $merchantData;
                $posnetOOSRequest->sign = $sign;

                $result = $this->DoTran($posnetOOSRequest, "1");
                if($result)
                    $this->posnetOOSResponse->errormessage = "SUCCESS";
                return $result;
            }
        }

        /**
         * @param $str
         * @return string
         */
        Function hashString($str){
            $encodedHash="";
            try{
                $encodedHash = base64_encode(hash('sha256',$str,true));
            }catch (Exception $e){
                echo 'Message: '.$e->getMessage();
            }
			return $encodedHash;
		}
		
		Function getMacFor3DSTransaction($Session){
            $mac ="";
            try{
                $mac = $this->hashString($Session->xid . ";" . $Session->amount . ";" . $Session->currency . ";" . $Session->merchantNo . ";" . $this->hashString( $this->merchantInfo->enckey . ";" . $Session->terminalNo));
            }catch (Exception $e){
                echo 'Message: '.$e->getMessage();
            }
			return $mac;
		}
		
		Function getMacFor3DSResponse($Session){

            $mac ="";
            try{
                $mac = $this->hashString($Session->responseHostlogKey . ";" . $Session->xid . ";" + $Session->amount . ";"
                    . $Session->currency . ";" . $Session->merchantNo . ";"
                    . $this->hashString($this->merchantInfo->enckey . ";" . $Session->terminalNo));
            }catch (Exception $e){
                echo 'Message : '.$e->getMessage();
            }
            return $mac;
		}
		
		Function compareResultMac($mac, $mac2){

			if($mac!=null && $mac2!=null && $mac === $mac2){
				return true;
			}
			return false;
		}
		
        /**
         * It is used for completing OOS transaction
         * @param string $merchantData
         * @param string $bankData
         * @param string $sign
         * @return bool
         */
        Function ConnectAndDoTDSTransaction($merchantData,
            $bankData,
            $sign, $mac) {

            if (!$this->CheckSignForMercSite($merchantData,
                $bankData,
                $sign,
                $this->merchantInfo->enckey))
                return false;

            $posnetOOSRequest = new PosnetOOSRequest();
			$posnetOOSRequest->mac = $mac;
            $posnetOOSRequest->bankData = $bankData;
            $posnetOOSRequest->merchantData = $merchantData;
            $posnetOOSRequest->sign = $sign;
            $posnetOOSRequest->wpAmount = $this->wpAmount;

            return $this->DoTran($posnetOOSRequest, "2");
        }

        /**
         * This function is used to set remote URL of POSNET system.
         * @param string $url
         */
        Function SetURL($url) {
            $this->url = $url;
        }

        /**
         * It is used for setting Posnet ID
         * @param string $strPosnetID
         */
        Function SetPosnetID($strPosnetID) {
            $this->merchantInfo->posnetid = $strPosnetID;
        }

        /**
         * It is used for setting merchant ID
         * @param string $strMid
         */
        Function SetMid($strMid) {
            $this->merchantInfo->mid = $strMid;
        }

        /**
         * It is used for setting terminal ID
         * @param string $strTid
         */
        Function SetTid($strTid) {
            $this->merchantInfo->tid = $strTid;
        }

        /**
         * It is used for setting username for login to posnet web service
         * @param string $strUsername
         */
        Function SetUsername($strUsername) {
            $this->merchantInfo->username = $strUsername;
        }

        /**
         * It is used for setting password for login to posnet web service
         * @param string $strPassword
         */
        Function SetPassword($strPassword) {
            $this->merchantInfo->password = $strPassword;
        }
         
        /**
         * It is used for setting enckey
         * @param string $strKey
         */
        Function SetKey($strKey) {
            $this->merchantInfo->enckey = $strKey;
        }
         
        /**
         * It is used for setting world point usage amount
         * @param string $strWPAmount
         */
        Function SetPointAmount($strWPAmount) {
            if($strWPAmount > 0)
                $this->wpAmount = $strWPAmount;
        }
         
        //Get Methods
         
        /**
         * It is used for getting XML data for response
         * @return string
         */
        Function GetResponseXMLData() {
            return $this->strResponseXMLData;
        }
         
        /**
         * It is used for getting XML data for request
         * @return string
         */
        Function GetRequestXMLData() {
            return $this->strRequestXMLData;
        }
         
        //Response XML Parameters
         
        /**
         * It is used for getting Approved Code
         * 0 --> Not Approved
         * 1 --> Approved
         * @return string
         */
        Function GetApprovedCode() {
            return $this->posnetOOSResponse->approved;
        }

        /**
         * It is used for getting Response Code
         * @return string
         */
        Function GetResponseCode() {
            return $this->posnetOOSResponse->errorcode;
        }

        /**
         * It is used for getting Response Message
         * @return string
         */
        Function GetResponseText() {
            return $this->posnetOOSResponse->errormessage;
        }

        /**
         * It is used for getting Authorization Code for approved transactions
         * @return string
         */
        Function GetAuthcode() {
            return $this->posnetOOSResponse->authcode;
        }

        /**
         * It is used for getting Hostlogkey for approved transactions
         * @return string
         */
        Function GetHostlogkey() {
            return $this->posnetOOSResponse->hostlogkey;
        }

        //OOS Info

        /**
         * It is used for getting data1()
         * @return string
         */
        Function GetData1() {
            return $this->posnetOOSResponse->data1;
        }
         
        /**
         * It is used for getting data2
         * @return string
         */
        Function GetData2() {
            return $this->posnetOOSResponse->data2;
        }
         
        /**
         * It is used for getting oos sign
         * @return string
         */
        Function GetSign() {
            return $this->posnetOOSResponse->sign;
        }
         
        //OOS Merchant Data Info
         
        /**
         * It is used for getting merchant id
         * @return string
         */
        Function GetMid() {
            return $this->posnetOOSResponse->mid;
        }
         
        /**
         * It is used for getting terminal id
         * @return string
         */
        Function GetTid() {
            return $this->posnetOOSResponse->tid;
        }

        /**
         * It is used for getting transaction id
         * @return string
         */
        Function GetXid() {
            return $this->posnetOOSResponse->xid;
        }
         
        /**
         * It is used for getting amount
         * @return string
         */
        Function GetAmount() {
            return $this->posnetOOSResponse->amount;
        }
         
        /**
         * It is used for getting Hazirkart Kontur
         * @return string
         */
        Function GetKontur() {
            return $this->posnetOOSResponse->amount;
        }
	
	/**
         * It is used for getting Hazirkart Kontur Amount
         * @return string
         */
        Function GetKonturAmount() {
            return $this->posnetOOSResponse->kontur_amount;
        }
	
	/**
         * It is used for getting currency
         * @return string
         */
        Function GetCurrency() {
            return $this->posnetOOSResponse->currency;
        }
         
        /**
         * It is used for getting instalment number
         * @return string
         */
        Function GetInstalmentNumber() {
            return $this->posnetOOSResponse->instcount;
        }

        /**
         * It is used for getting each instalment amount
         * @return string
         */
        Function GetInstalmentAmount() {
            return $this->posnetOOSResponse->instamount;
        }

        /**
         * It is used for getting Point for a success transaction
         * @return string
         */
        Function GetPoint() {
            return $this->posnetOOSResponse->point;
        }

        /**
         * It is used for getting Point Amount for a success transaction
         * @return string
         */
        Function GetPointAmount() {
            return $this->posnetOOSResponse->pointAmount;
        }

        /**
         * It is used for getting cardholder available Total Point
         * @return string
         */
        Function GetTotalPoint() {
            return $this->posnetOOSResponse->totalPoint;
        }
         
        /**
         * It is used for getting cardholder available Total Point Amount
         * @return string
         */
        Function GetTotalPointAmount() {
            return $this->posnetOOSResponse->totalPointAmount;
        }

        /**
         * It is used for getting Three D-Secure transaction status
         * @return string
         */
        Function GetTDSTXStatus() {
            return $this->posnetOOSResponse->tds_tx_status;
        }

        /**
         * It is used for getting Three D-Secure transaction code
         * @return string
         */
        Function GetTDSMDStatus() {
            return $this->posnetOOSResponse->tds_md_status;
        }

        /**
         * It is used for getting Three D-Secure transaction message
         * @return string
         */
        Function GetTDSMDErrorMessage() {
            return $this->posnetOOSResponse->tds_md_errormessage;
        }

        /**
         * It is used for getting last error message
         * @return string
         */
        Function GetLastErrorMessage() {
            return $this->posnetOOSResponse->errormessage;
        }
        
        //VFT Info
        
        /**
         * It is used for getting Forward Sale Amount
         * @return string
         */
        Function GetVftAmount() {
            return $this->posnetOOSResponse->vft_amount;
        }

        /**
         * It is used for getting Forward Sale Day Count
         * @return string
         */
        Function GetVftDayCount() {
            return $this->posnetOOSResponse->vft_daycount;
        }

        Function GetMac() {
            return $this->posnetOOSResponse->mac;
        }
    };
?>