<HTML>
<HEAD>
<TITLE>Posnet Encryption Test</TITLE>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=iso-8859-1">
</HEAD>
<?php

    //Include POSNET Enc Class
    require_once(dirname(__DIR__).'Posnet Modules/Posnet ENC/posnet_enc.php');

    $data = "deneme123";
	$result = "";

    $posnetENC = new PosnetENC();

    $encryptedData = $posnetENC->Encrypt($data, "abc");

    $decryptedData = $posnetENC->Decrypt($encryptedData, "abc");
    
    if(strcmp($data, $decryptedData) == 0)
        $result = "Encryption/Decryption is OK.";
    else
        $result = "Encryption/Decryption error !!!!";

    $posnetENC->DeInit();
?>
<BODY>
<P><FONT COLOR="#0000FF" SIZE="5">Encryption/Decryption Test :</FONT></P>
<P><EM><STRONG>Encrypted Data :</STRONG> </EM> <? echo($encryptedData); ?> </P>
<P><EM><STRONG>Decrypted Data :</STRONG> </EM> <? echo($decryptedData); ?> </P>
<P><EM><STRONG>Result :</STRONG> </EM> <? echo($result); ?> </P>
</BODY>
</HTML>

