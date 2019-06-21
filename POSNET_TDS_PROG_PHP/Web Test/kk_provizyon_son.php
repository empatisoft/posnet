<?php
	error_reporting(E_ALL ^ (E_WARNING | E_NOTICE));//Warninglerin ya da Noticelerin gosterilmesini engeller.
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
    
	$posnetOOS = new PosnetOOS();
    //$posnetOOS->SetDebugLevel(1);

    $merchantPacket = $POST['MerchantPacket'];
    $bankPacket = $POST['BankPacket'];
    $sign = $POST['Sign'];
    
    $posnetOOS->SetMid(MID);
    $posnetOOS->SetTid(TID);

    //XML Servisi için
    $posnetOOS->SetURL(XML_SERVICE_URL);
    $posnetOOS->SetUsername('USERNAME');
    $posnetOOS->SetPassword('PASSWORD');
    $posnetOOS->SetKey(ENCKEY);

		if (array_key_exists("WPAmount", $POST))
        $posnetOOS->SetPointAmount($POST['WPAmount']);
    
    if(!$posnetOOS->ConnectAndDoTDSTransaction($merchantPacket,
        $bankPacket,
        $sign
         ))
    {
        //echo("Ýþlem gerçekleþtirilemedi.<br>");
        //echo("Hata : ".$posnetOOS->GetLastErrorMessage());
    }
?>
<html>
<head>
<title>Üye Ýþyeri Kredi Kartý Ýþlemi Sonuç Sayfasý</title>
<META HTTP-EQUIV="expires" CONTENT="0">
<META HTTP-EQUIV="cache-control" CONTENT="no-cache">
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<META HTTP-EQUIV="Content-Type" content="text/html; charset=windows-1254">
</head>
<body>
<blockquote> 
  <p align="center"><font color="#0099FF" size="6" face="Geneva, Arial, Helvetica, sans-serif">Üye 
    Ýþyeri Kredi Kartý Ýþlemi Sonuç Sayfasý;</font></p>
</blockquote>
<table width="60%" border="1" align="center" cellpadding="1" cellspacing="1" bordercolor="#ffffff">
  <tr bordercolor="#0099ff"> 
    <td height="30" colspan="2" bordercolor="#CCCCCC"><font size="2" face="Geneva, Arial, Helvetica, sans-serif">&nbsp;<strong>Posnet 
      Ýþlem Sonucu Bilgileri : </strong></font></td>
  </tr>
  <tr valign="center" bordercolor="#0099ff"> 
    <td width="50%" height="30" bordercolor="#CCCCCC"> <p><font size="2" face="Geneva, Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;Onay 
        Bilgisi : </font></p></td>
    <td width="50%" height="30" bordercolor="#CCCCCC"> <font size="2" face="Geneva, Arial, Helvetica, sans-serif">&nbsp;<?php echo($posnetOOS->GetApprovedCode());?>
      </font></td>
  </tr>
  <tr valign="center" bordercolor="#0099ff"> 
    <td height="30" bordercolor="#CCCCCC"> <p><font size="2" face="Geneva, Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;Onay 
        Kodu : </font></p></td>
    <td height="30" bordercolor="#CCCCCC"> <font size="2" face="Geneva, Arial, Helvetica, sans-serif">&nbsp;<?php echo($posnetOOS->GetAuthcode());?>
      </font></td>
  </tr>
  <tr valign="center" bordercolor="#0099ff"> 
    <td height="30" bordercolor="#CCCCCC"> <p><font size="2" face="Geneva, Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;YKB 
        Referans Numarasý : </font></p></td>
    <td height="30" bordercolor="#CCCCCC"> <font size="2" face="Geneva, Arial, Helvetica, sans-serif">&nbsp;<?php echo($posnetOOS->GetHostlogkey());?>
      </font></td>
  </tr>
  <tr valign="center" bordercolor="#0099ff">
    <td height="30" bordercolor="#CCCCCC"> <p><font size="2" face="Geneva, Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;Hata
        Kodu : </font></p></td>
    <td height="30" bordercolor="#CCCCCC"> <font size="2" face="Geneva, Arial, Helvetica, sans-serif">&nbsp;<?php echo($posnetOOS->GetResponseCode());?>
      </font></td>
  </tr>
  <tr valign="center" bordercolor="#0099ff">
    <td height="30" bordercolor="#CCCCCC"> <p><font size="2" face="Geneva, Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;Hata
        Mesajý : </font></p></td>
    <td height="30" bordercolor="#CCCCCC"> <font size="2" face="Geneva, Arial, Helvetica, sans-serif">&nbsp;<?php echo($posnetOOS->GetResponseText());?>
      </font></td>
  </tr>
</table>
<table width="60%" border="1" align="center" cellpadding="1" cellspacing="1" bordercolor="#ffffff">
  <tr bordercolor="#0099ff"> 
    <td height="30" colspan="2" bordercolor="#CCCCCC"><font size="2" face="Geneva, Arial, Helvetica, sans-serif">&nbsp;<strong>Posnet 
      Puan Bilgileri : </strong></font></td>
  </tr>
  <tr valign="center" bordercolor="#0099ff">
    <td WIDTH="50%" height="30" bordercolor="#CCCCCC"> 
<p><font size="2" face="Geneva, Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;Kazanýlan
        Puan : </font></p></td>
    <td WIDTH="50%" height="30" bordercolor="#CCCCCC"> <font size="2" face="Geneva, Arial, Helvetica, sans-serif">&nbsp;<?php echo($posnetOOS->GetPoint());?> 
      </font></td>
  </tr>
  <tr valign="center" bordercolor="#0099ff">
    <td height="30" bordercolor="#CCCCCC"><font size="2" face="Geneva, Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;Kazanýlan 
      Puan Tutarý (x100) : </font></td>
    <td height="30" bordercolor="#CCCCCC"><font size="2" face="Geneva, Arial, Helvetica, sans-serif">&nbsp;<?php echo($posnetOOS->GetPointAmount());?>
      </font></td>
  </tr>
  <tr valign="center" bordercolor="#0099ff">
    <td height="30" bordercolor="#CCCCCC"> <p><font size="2" face="Geneva, Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;Toplam
        Puan : </font></p></td>
    <td height="30" bordercolor="#CCCCCC"> <font size="2" face="Geneva, Arial, Helvetica, sans-serif">&nbsp;<?php echo($posnetOOS->GetTotalPoint());?>
      </font></td>
  </tr>
  <tr valign="center" bordercolor="#0099ff">
    <td height="30" bordercolor="#CCCCCC"> <p><font size="2" face="Geneva, Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;Toplam
    Puan Tutarý (x100) : </font></p></td>
    <td height="30" bordercolor="#CCCCCC"> <font size="2" face="Geneva, Arial, Helvetica, sans-serif">&nbsp;<?php echo($posnetOOS->GetTotalPointAmount());?>
      </font></td>
  </tr>
</table>
<table width="60%" border="1" align="center" cellpadding="1" cellspacing="1" bordercolor="#ffffff">
  <tr bordercolor="#0099ff"> 
    <td height="30" colspan="2" bordercolor="#CCCCCC"><font size="2" face="Geneva, Arial, Helvetica, sans-serif">&nbsp;<strong>Posnet 
      Taksit Bilgileri : </strong></font></td>
  </tr>
  <tr valign="center" bordercolor="#0099ff"> 
    <td WIDTH="50%" height="30" bordercolor="#CCCCCC"> 
<p><font size="2" face="Geneva, Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;Taksit 
        Sayýsý : </font></p></td>
    <td WIDTH="50%" height="30" bordercolor="#CCCCCC"> <font size="2" face="Geneva, Arial, Helvetica, sans-serif">&nbsp;<?php echo($posnetOOS->GetInstalmentNumber());?> 
      </font></td>
  </tr>
  <tr valign="center" bordercolor="#0099ff">
    <td height="30" bordercolor="#CCCCCC"> <p><font size="2" face="Geneva, Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;Taksit
    Tutarý (x100) : </font></p></td>
    <td height="30" bordercolor="#CCCCCC"> <font size="2" face="Geneva, Arial, Helvetica, sans-serif">&nbsp;<?php echo($posnetOOS->GetInstalmentAmount());?>
      </font></td>
  </tr>
</table>
<table width="60%" border="1" align="center" cellpadding="1" cellspacing="1" bordercolor="#ffffff">
  <tr bordercolor="#0099ff"> 
    <td height="30" colspan="2" bordercolor="#CCCCCC"><font size="2" face="Geneva, Arial, Helvetica, sans-serif">&nbsp;<strong>Posnet 
      VFT Bilgileri : </strong></font></td>
  </tr>
  <tr valign="center" bordercolor="#0099ff"> 
    <td width="50%" height="30" bordercolor="#CCCCCC"> <p><font size="2" face="Geneva, Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;Vade 
    Tutarý (x100): </font></p></td>
    <td width="50%" height="30" bordercolor="#CCCCCC"> <font size="2" face="Geneva, Arial, Helvetica, sans-serif">&nbsp;<?php echo($posnetOOS->GetVftAmount());?>
      </font></td>
  </tr>
  <tr valign="center" bordercolor="#0099ff"> 
    <td height="30" bordercolor="#CCCCCC"> <p><font size="2" face="Geneva, Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;Vade 
        Gün Sayýsý : </font></p></td>
    <td height="30" bordercolor="#CCCCCC"> <font size="2" face="Geneva, Arial, Helvetica, sans-serif">&nbsp;<?php echo($posnetOOS->GetVftDayCount());?>
      </font></td>
  </tr>
</table>
<P>&nbsp;</P>
</body>
</html>