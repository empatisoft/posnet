<?php
	header('Content-Type: text/html; charset=iso-8859-9');
	header('Content-Type: text/html; charset=windows-1254');
	header('Content-Type: text/html; charset=x-mac-turkish');

    /**
     * @package posnet oostest
     */

    //Include POSNETOOS Class
    require_once('posnet_oos_config.php');
	require_once(dirname(__DIR__).'/Posnet Modules/Posnet OOS/posnet_oos.php');
	
	$POST;
	if ((floatval(phpversion()) >= 5) && ((ini_get('register_long_arrays') == '0') || (ini_get('register_long_arrays') == '')))
	{
	  $POST =& $_POST;
	} 
	else 
	{
	  $POST =& $HTTP_POST_VARS;
	}
    
    //�ye i�yeri Bilgileri
    $mid = MID;
    $tid = TID;
    $posnetid = POSNETID;
    $ykbOOSURL = OOS_TDS_SERVICE_URL;//http://setmpos.ykb.com/3DSWebService/YKBPaymentService
    $xmlServiceURL = XML_SERVICE_URL;//http://setmpos.ykb.com/PosnetWebService/XML
	
    //��lem Bilgileri
    /*
    Bu bilgiler bir �nceki sayfadan al�nmaktad�r.Ancak bu bilgilerin
    session'dan al�nmas� sistemin daha g�venli olmas�n� sa�l�yacakt�r.
    */
    $xid = $POST['XID'];
    $instnumber = $POST['instalment'];
    $amount = $POST['amount'];
    $currencycode = $POST['currency'];
    $custName = $POST['custName'];
    $trantype = $POST['tranType'];
    $vftCode = $POST['vftCode'];
	$openANewWindow = $POST['openANewWindow'];

    //E�er ki kredi kart� bilgileri �ye i�yeri sayfas�nda al�nacak ise
    if(array_key_exists("ccdata", $POST))
    {
        $ccdataisexist = true;
        $ccno = $POST['ccno'];
        $expdate = $POST['expdate'];
        $cvc = $POST['cvv'];
    }
    else
        $ccdataisexist = false;

    $posnetOOS = new PosnetOOS;
    //$posnetOOS->SetDebugLevel(1);

    $posnetOOS->SetPosnetID($posnetid);
    $posnetOOS->SetMid($mid);
    $posnetOOS->SetTid($tid);

    //XML Servisi i�in
    $posnetOOS->SetURL($xmlServiceURL);
    $posnetOOS->SetUsername('USERNAME');
    $posnetOOS->SetPassword('PASSWORD');

    if($ccdataisexist)
    {
        //E�er ki kredi kart� bilgileri �ye i�yeri sayfas�nda al�nacak ise
        if(!$posnetOOS->CreateTranRequestDatas($custName,
                                        $amount,
                                        $currencycode,
                                        $instnumber,
                                        $xid,
                                        $trantype,
                                        $ccno,
                                        $expdate,
                                        $cvc
                                        ))
        {
            echo("PosnetData'lari olusturulamadi.<br>".
                        "Data1 = ".$posnetOOS->GetData1()."<br>".
                        "Data2 = ".$posnetOOS->GetData2()."<br>".
                        "XML Response Data = ".$posnetOOS->GetResponseXMLData()
                );
            echo("Error Code : ".$posnetOOS->GetResponseCode());
            echo("<br>");
            echo("Error Text : ".$posnetOOS->GetResponseText());
        }
    }
    else
    {
        //Kart Bilgilerinin OOS sisteminde girilmesi isteniyor ise
        if(!$posnetOOS->CreateTranRequestDatas($custName,
                                        $amount,
                                        $currencycode,
                                        $instnumber,
                                        $xid,
                                        $trantype
                                        ))
        {
            echo("<html>");
            echo("PosnetData'lari olusturulamadi.<br>".
                       "Data1 = ".$posnetOOS->GetData1()."<br>".
                       "Data2 = ".$posnetOOS->GetData2()."<br>".
                       "XML Response Data = ".$posnetOOS->GetResponseXMLData()
                );
            echo("Error Code : ".$posnetOOS->GetResponseCode());
            echo("<br>");
            echo("Error Text : ".$posnetOOS->GetResponseText());
            echo("</html>");
            return;
        }
    }
?>
<html>
<head>
<title>3-D Secure veya Ortak �deme Sayfas� Uygulama Ba�lang�� Sayfas�</title>
<META HTTP-EQUIV="Content-Type" content="text/html; charset=windows-1254">
<META HTTP-EQUIV="expires" CONTENT="0">
<META HTTP-EQUIV="cache-control" CONTENT="no-cache">
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<script language="JavaScript" src="https://www.posnet.ykb.com/3DSWebService/scriptler/posnet.js"></script>
<script language="JavaScript" type="text/JavaScript">
function submitFormEx(Form, OpenNewWindowFlag, WindowName) {
    	submitForm(Form, OpenNewWindowFlag, WindowName)
    	Form.submit();
}
</script>

</head>
<body>
<blockquote> 
  <blockquote>
    <p align="center"><font color="#0099FF" size="6" face="Geneva, Arial, Helvetica, sans-serif">Al��veri�i 
      Sonland�r, ��lem bilgilerini YKB' ye g�nder !</font></p>
  </blockquote>
</blockquote>
<form name="formName" method="post" action="<?php echo $ykbOOSURL; ?>" target="YKBWindow">
  <div align="center"> 
    <table width="44%" border="1" align="center" cellpadding="1" cellspacing="1" bordercolor="#FFFFFF">
      <tr bordercolor="#0099FF"> 
        <td height="28" bordercolor="#CCCCCC"><font size="2" face="Geneva, Arial, Helvetica, sans-serif">Sipari� 
          Numaras� :</font></td>
        <td height="28" bordercolor="#CCCCCC"><font size="2" face="Geneva, Arial, Helvetica, sans-serif">&nbsp;<?php echo $xid; ?></font></td>
      </tr>
      <tr bordercolor="#0099FF"> 
        <td height="28" bordercolor="#CCCCCC"><font size="2" face="Geneva, Arial, Helvetica, sans-serif">Toplam 
          tutar (x100) :</font></td>
        <td height="28" bordercolor="#CCCCCC"><font size="2" face="Geneva, Arial, Helvetica, sans-serif">&nbsp;<?php echo $amount; ?></font></td>
      </tr>
      <tr BORDERCOLOR="#0099ff">
        <td height="28" bordercolor="#CCCCCC"><font size="2" face="Geneva, Arial, Helvetica, sans-serif">Para 
          Birimi  :</font></td>
        <td height="28" bordercolor="#CCCCCC"><font size="2" face="Geneva, Arial, Helvetica, sans-serif">&nbsp;<?php echo $currencycode; ?></font></td>
      </tr>
      <tr bordercolor="#0099FF">
        <td width="46%" height="28" bordercolor="#CCCCCC"><font size="2" face="Geneva, Arial, Helvetica, sans-serif">Taksit
          say�s� :</font></td>
        <td width="54%" height="28" bordercolor="#CCCCCC"><font size="2" face="Geneva, Arial, Helvetica, sans-serif">&nbsp;<?php echo $instnumber; ?></font></td>
      </tr>
    </table>
    <p> <font size="2">
      <input name="posnetData" type="hidden" id="posnetData" value="<?php echo $posnetOOS->GetData1(); ?>">
      <input name="posnetData2" type="hidden" id="posnetData2" value="<?php echo $posnetOOS->GetData2(); ?>">
      <input name="mid" type="hidden" id="mid" value="<?php echo $mid; ?>">
      <input name="posnetID" type="hidden" id="posnetID" value="<?php echo $posnetid; ?>">
      <input name="digest" type="hidden" id="sign" value="<?php echo $posnetOOS->GetSign(); ?>">
      <input name="vftCode" type="hidden" id="vftCode" value="<?php echo $vftCode; ?>">
      <input name="merchantReturnURL" type="hidden" id="merchantReturnURL" value="<?php echo LOCALHOST;?>"><!--http://localhost:8081/Web%20Test/kk_provizyon.php-->
      <!-- <input name="koiCode" type="hidden" id="koiCode" value="2"> -->
      
      <!-- Static Parameters -->
      <input name="lang" type="hidden" id="lang" value="tr">
      <input name="url" type="hidden" id="url" value="">
      <input name="openANewWindow" type="hidden" id="openANewWindow" value="0">
      </font></p>
    <p>
      <input name="imageField" type="image" onClick="submitFormEx(formName, <?php echo $openANewWindow; ?>, 'YKBWindow');this.disabled=true;" SRC="images/button_odeme_yap.gif"  width="67" height="20" border="0">
      &nbsp;<A HREF="javascript:formName.submit()" onClick="submitFormEx(formName, <?php echo $openANewWindow; ?>, 'YKBWindow');this.disabled=true;"><FONT FACE="Geneva, Arial, Helvetica, sans-serif"><STRONG>�deme Yap</STRONG></FONT></A> <FONT SIZE="2">
      &nbsp;<input type="submit" name="Submit" value="�deme Yap" onClick="submitFormEx(formName, <?php echo $openANewWindow; ?>, 'YKBWindow');this.disabled=true;">
      </FONT></p>
  </div>
  <div align="center"> <font size="2"> 
    <input type="button" name="Back" value="Vazge�" onClick="history.back()">
    </font></div>

</form>
</body>
</html>