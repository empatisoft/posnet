<?php
	error_reporting(0);//Warninglerin ya da Noticelerin gosterilmesini engeller.
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
    
    $merchantPacket = $POST['MerchantPacket'];
    $bankPacket = $POST['BankPacket'];
    $sign = $POST['Sign'];
	$tranType = $POST['TranType'];

    $posnetOOS = new PosnetOOS();

    //$posnetOOS->SetDebugLevel(1);
    
    $posnetOOS->SetMid(MID);
    $posnetOOS->SetTid(TID);

    //XML Servisi i�in (MCrypt Library 'si kullan�lamad��� zaman gerekli)
    $posnetOOS->SetURL(XML_SERVICE_URL);
    $posnetOOS->SetUsername('USERNAME');
    $posnetOOS->SetPassword('PASSWORD');
    $posnetOOS->SetKey(ENCKEY);

	if(!$posnetOOS->CheckAndResolveMerchantData($merchantPacket,
        $bankPacket,
        $sign
         ))
    {
        echo("Merchant Datas� ��z�mlenemedi.<br>");
        echo("Hata : ".$posnetOOS->GetLastErrorMessage());
    }
	else
		$availablePoint = $posnetOOS->GetTotalPointAmount();
	
	// 3d i�lem b�t�nl��� kontrol� i�in, i�yeri taraf�ndan i�lem �zelinde �retilen XID ve amount ile   
	// CheckAndResolveMerchantData sonras� 
	// posnetOOS->GetXID();
	// posnetOOS->GetAmount();
	// metodlar� ile elde edilen XID ve amount bilgilerinin birebir ayn� oldu�u bu noktada mutlaka i� yeri taraf�ndan kontrol edilmelidir.
	
?>
<html>
<head>
<title>�ye ��yeri Kredi Kart� ��lemi Ba�lang�� Sayfas�</title>
<META HTTP-EQUIV="expires" CONTENT="0">
<META HTTP-EQUIV="cache-control" CONTENT="no-cache">
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<META HTTP-EQUIV="Content-Type" content="text/html; charset=windows-1254">
</head>
<body>
<blockquote>
  <form name="form1" method="post" action="kk_provizyon_son.php">
    <div align="center"> 
      <blockquote>
        <p align="center"><font color="#0099ff" size="6" face="Geneva, Arial, Helvetica, sans-serif">�ye 
          ��yeri Kredi Kart� ��lemi Ba�lang�� Sayfas�;</font></p>
        <p align="center"> <font size="2" face="Geneva, Arial, Helvetica, sans-serif"> 
          <input name="MerchantPacket" type="hidden" value="<?php echo($merchantPacket); ?>">
          <input name="BankPacket" type="hidden" value="<?php echo($bankPacket); ?>">
          <input name="Sign" type="hidden" value="<?php echo($sign); ?>">
          </font> </p>
      </blockquote>
      <table width="54%" height="197" border="1" align="center" cellpadding="1" cellspacing="1" bordercolor="#ffffff">
        <tr bordercolor="#0099ff"> 
          <td height="30" colspan="2" bordercolor="#CCCCCC"><font size="2" face="Geneva, Arial, Helvetica, sans-serif"><strong>&nbsp;Al��veri� 
            Bilgileri : </strong></font></td>
        </tr>
        <tr valign="center" bordercolor="#0099ff">
          <td width="51%" height="31" bordercolor="#CCCCCC"> <p><font size="2" face="Geneva, Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;Sipari�
              Numaras� : </font></p></td>
          <td width="49%" height="31" bordercolor="#CCCCCC"> <font size="2" face="Geneva, Arial, Helvetica, sans-serif">&nbsp;
            <?php echo($posnetOOS->GetXid());?> </font></td>
        </tr>
        <tr valign="center" bordercolor="#0099ff">
          <td height="30" bordercolor="#CCCCCC"> <p><font size="2" face="Geneva, Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;��lem
          Tutar� (x100) : </font></p></td>
          <td height="30" bordercolor="#CCCCCC"> <font size="2" face="Geneva, Arial, Helvetica, sans-serif">&nbsp;
            <?php echo($posnetOOS->GetAmount());?> </font></td>
        </tr>
        <tr valign="center" bordercolor="#0099ff">
          <td height="30" bordercolor="#CCCCCC"> <p><font size="2" face="Geneva, Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;Para
              Birimi : </font></p></td>
          <td height="30" bordercolor="#CCCCCC"> <font size="2" face="Geneva, Arial, Helvetica, sans-serif">&nbsp;
            <?php echo($posnetOOS->GetCurrency());?> </font></td>
        </tr>
        <tr valign="center" bordercolor="#0099ff">
          <td height="30" bordercolor="#CCCCCC"> <p><font size="2" face="Geneva, Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;Taksit
              Say�s� : </font></p></td>
          <td height="30" bordercolor="#CCCCCC"> <font size="2" face="Geneva, Arial, Helvetica, sans-serif">&nbsp;
            <?php echo($posnetOOS->GetInstalmentNumber());?> </font></td>
        </tr>
        <tr valign="center" bordercolor="#0099ff"> 
          <td height="30" bordercolor="#CCCCCC"> <p><font size="2" face="Geneva, Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;Posnet 
              Hata Mesaj� :</font></p></td>
          <td height="30" BORDERCOLOR="#CCCCCC"> <font size="2" face="Geneva, Arial, Helvetica, sans-serif">&nbsp; 
            <?php echo($posnetOOS->GetLastErrorMessage());?> </font></td>
        </tr>
      </table>
      <table width="54%" border="1" align="center" cellpadding="1" cellspacing="1" bordercolor="#ffffff">
        <tr bordercolor="#0099ff"> 
          <td height="30" colspan="2" bordercolor="#CCCCCC"><font size="2" face="Geneva, Arial, Helvetica, sans-serif">&nbsp;<strong>Posnet 
            Puan Bilgileri : </strong></font></td>
        </tr>
        <tr valign="center" bordercolor="#0099ff"> 
          <td WIDTH="55%" height="30" bordercolor="#CCCCCC"> <p><font size="2" face="Geneva, Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;Kullan�labilir 
              Toplam Puan : </font></p></td>
          <td WIDTH="45%" height="30" bordercolor="#CCCCCC"> <font size="2" face="Geneva, Arial, Helvetica, sans-serif">&nbsp;<?php echo($posnetOOS->getTotalPoint());?> 
            </font></td>
        </tr>
        <tr valign="center" bordercolor="#0099ff"> 
          <td height="30" bordercolor="#CCCCCC"> <p><font size="2" face="Geneva, Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;Kullan�labilir 
          Toplam Puan Tutar�&nbsp;(x100) : </font></p></td>
          <td height="30" bordercolor="#CCCCCC"> <font size="2" face="Geneva, Arial, Helvetica, sans-serif">&nbsp;<?php echo($posnetOOS->getTotalPointAmount());?> 
            </font></td>
        </tr>
        <tr valign="center" bordercolor="#0099ff">
          <td height="30" bordercolor="#CCCCCC"><font size="2" face="Geneva, Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;Kullan�lacak 
            Puan &nbsp;(x100) : </font></td>
          <td height="30" bordercolor="#CCCCCC"><font size="2" face="Geneva, Arial, Helvetica, sans-serif">&nbsp;
            <INPUT NAME="WPAmount" TYPE="text" ID="WPAmount" <?php if ($tranType == null || $tranType != "SaleWP" || $availablePoint < 0) {echo 'VALUE="0" SIZE="10" MAXLENGTH="10" DISABLED';} else {echo 'VALUE="200"';}?>>
            </font></td>
        </tr>
      </table>
      <table width="54%" height="132" border="1" align="center" cellpadding="1" cellspacing="1" bordercolor="#ffffff">
        <tr bordercolor="#0099ff"> 
          <td height="30" colspan="2" bordercolor="#CCCCCC"><font size="2" face="Geneva, Arial, Helvetica, sans-serif"><strong>&nbsp;3D 
            - Secure Bilgileri : </strong></font></td>
        </tr>
        <tr valign="center" bordercolor="#0099ff">
          <td height="30" bordercolor="#CCCCCC"> <p><font size="2" face="Geneva, Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;3D
              - Secure Onay Stat�s� : </font></p></td>
          <td height="30" bordercolor="#CCCCCC"> <font size="2" face="Geneva, Arial, Helvetica, sans-serif">&nbsp;
            <?php echo($posnetOOS->GetTDSTXStatus());?> </font></td>
        </tr>
        <tr valign="center" bordercolor="#0099ff">
          <td height="30" bordercolor="#CCCCCC"> <p><font size="2" face="Geneva, Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;3D
              - Secure Hata Kodu :</font></p></td>
          <td height="30" bordercolor="#CCCCCC"> <font size="2" face="Geneva, Arial, Helvetica, sans-serif">&nbsp;
            <?php echo($posnetOOS->GetTDSMDStatus());?> </font></td>
        </tr>
        <tr valign="center" bordercolor="#0099ff">
          <td height="30" bordercolor="#CCCCCC"> <p><font size="2" face="Geneva, Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;3D
              - Secure Hata Mesaj� :</font></p></td>
          <td height="30" bordercolor="#CCCCCC"> <font size="2" face="Geneva, Arial, Helvetica, sans-serif">&nbsp;
            <?php echo($posnetOOS->GetTDSMDErrorMessage());?> </font></td>
        </tr>
      </table>
      <blockquote> 
        <p align="center"> 
          <input name="Submit" type="submit" value="��leme Devam Et >>">
        </p>
      </blockquote>
    </div>
  </form>
  <p align="justify"> </p>
</blockquote>
</body>
</html>