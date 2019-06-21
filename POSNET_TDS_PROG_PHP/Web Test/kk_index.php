<?php 
header('Content-Type: text/html; charset=iso-8859-9');
header('Content-Type: text/html; charset=windows-1254');
header('Content-Type: text/html; charset=x-mac-turkish');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>3-D Secure veya Ortak Ödeme Sayfası Uygulama Başlangıç Sayfası</title>
<META HTTP-EQUIV="Content-Type" content="text/html; charset=windows-1254">
<META HTTP-EQUIV="expires" CONTENT="0">
<META HTTP-EQUIV="cache-control" CONTENT="no-cache">
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
</head>
<script language=javascript>
function findObj(n, d) { //v4.0
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=findObj(n,d.layers[i].document);
  if(!x && document.getElementById) x=document.getElementById(n); return x;
}
function check(flag) {
    findObj("ccno").disabled = !flag;
	findObj("expdate").disabled = !flag;
	findObj("cvv").disabled = !flag;
	findObj("ccdata").checked= flag;	
}
function XIDHesapla(){
	var simdi = new Date();
	var yil = new String(simdi.getFullYear());
	yil = yil.slice(2, 4);
	var ay = new String(simdi.getMonth()+1);
	if (ay.length == 1) ay = "0"+ay;
	var gun = new String(simdi.getDate());
	if (gun.length == 1) gun = "0"+gun;
	var sa = new String(simdi.getHours());
	if (sa.length == 1) sa = "0"+sa;
	var dk = new String(simdi.getMinutes());
	if (dk.length == 1) dk = "0"+dk;
	var sn = new String(simdi.getSeconds());
	if (sn.length == 1) sn = "0"+sn;
	
	findObj("XID").value = "YKB_0000"
		+yil+ay+gun+sa+dk+sn;
}
function Init() {
	check(false);
	XIDHesapla();
}
</script>
<body onLoad="Init()">
<blockquote> 
  <blockquote> 
    <div align="center"><font color="#0099ff" size="6" face="Geneva, Arial, Helvetica, sans-serif">3-D 
      Secure veya Ortak Ödeme Sayfası Uygulama Başlangıç Sayfası</font> 
    </div>
    <p><font size="2" face="Geneva, Arial, Helvetica, sans-serif">Bu sayfa, 3-D   
      Secure veya Ortak Ödeme Sayfası kullanmak isteyen üye işyerlerimiz için hazırlanmış bir başlangıç 
      sayfasıdır. Aşağıdaki alanlara gireceğiniz bilgilerle, bir müşterinizin 
      sanal mağazanızdan yaptığı alışverişin detaylarını belirleyeceksiniz.</font></p>
    <p><font size="2" face="Geneva, Arial, Helvetica, sans-serif">Detayları girip 
      Gönder'e bastıktan sonra çıkacak sayfa, sanal müşterinizin sitenizde karşısına 
      çıkacak son sayfaya bir örnektir.</font></p>
  </blockquote>
</blockquote>
<form name="form1" method="post" action="kk_index_son.php">
  <table width="87%" border="1" align="center" cellpadding="1" cellspacing="1" bordercolor="#ffffff">
    <tr bordercolor="#0099ff"> 
      <td width="25%" height="30" bordercolor="#CCCCCC"><font size="2" face="Geneva, Arial, Helvetica, sans-serif"><STRONG>&nbsp;Müşterinizin 
        Adı :</STRONG></font></td>
      <td width="35%" height="30" bordercolor="#CCCCCC"> <font size="2" face="Geneva, Arial, Helvetica, sans-serif"> 
        <input name="custName" id="custName" value="Fatih" size ="25" maxlength="30">
        </font></td>
      <td width="40%" height="30" bordercolor="#CCCCCC"><font size="2" face="Geneva, Arial, Helvetica, sans-serif"><EM>Kredi 
        kartı sahibinin ismi</EM></font></td>
    </tr>
    <tr bordercolor="#0099ff"> 
<td height="30" bordercolor="#CCCCCC"><font size="2" face="Geneva, Arial, Helvetica, sans-serif">&nbsp;<STRONG>Sipariş 
        No :</STRONG></font></td>
      <td height="30" bordercolor="#CCCCCC"> <font size="2" face="Geneva, Arial, Helvetica, sans-serif"> 
        <input name="XID" id="XID" size="25" maxlength="20" >
        </font></td>
      <td height="30" bordercolor="#CCCCCC"><font size="2" face="Geneva, Arial, Helvetica, sans-serif"><EM>Herbir 
        alışveriş işlemi için Üye İşyeri tarafından oluşturulan 20 karakterli 
        alfa-numerik sipariş numarası</EM></font></td>
    </tr>
    <tr bordercolor="#0099ff"> 
<td height="30" bordercolor="#CCCCCC"><font size="2" face="Geneva, Arial, Helvetica, sans-serif">&nbsp;<STRONG>Üye 
        İşyeri No :</STRONG></font></td>
      <td height="30" bordercolor="#CCCCCC"><FONT face=Arial 
      size=2>&nbsp;&nbsp;"posnet_oos_config.php" dosyasına bakınız.</FONT></td>
      <td height="30" bordercolor="#CCCCCC"><font size="2" face="Geneva, Arial, Helvetica, sans-serif"><EM>10 
        karakterli Üye İşyeri Numarası</EM></font></td>
    </tr>
    <tr bordercolor="#0099ff"> 
<td height="30" bordercolor="#CCCCCC"><font size="2" face="Geneva, Arial, Helvetica, sans-serif"><STRONG>&nbsp;Terminal 
        No :</STRONG></font></td>
      <td height="30" bordercolor="#CCCCCC"> <font size="2" face="Geneva, Arial, Helvetica, sans-serif">&nbsp;&nbsp;"posnet_oos_config.php" 
        dosyasına bakınız. </font></td>
      <td height="30" bordercolor="#CCCCCC"><font size="2" face="Geneva, Arial, Helvetica, sans-serif"><EM>8 
        karakter li Üye İşyeri Terminal Numarası</EM></font></td>
    </tr>
    <tr bordercolor="#0099ff"> 
<td height="30" bordercolor="#CCCCCC"><font size="2" face="Geneva, Arial, Helvetica, sans-serif"><STRONG>&nbsp;Posnet 
        ID :</STRONG></font></td>
      <td height="30" bordercolor="#CCCCCC"> <font size="2" face="Geneva, Arial, Helvetica, sans-serif">&nbsp;&nbsp;"posnet_oos_config.php" 
        dosyasına bakınız. </font></td>
      <td height="30" bordercolor="#CCCCCC"><font size="2" face="Geneva, Arial, Helvetica, sans-serif"><EM>Üye 
        İşyeri Posnet Numarası</EM></font></td>
    </tr>
    <tr bordercolor="#0099ff"> 
<td rowspan="3" valign="top" bordercolor="#CCCCCC"><font size="2" face="Geneva, Arial, Helvetica, sans-serif"> 
<input name="ccdata" type="checkbox" value="1" onClick="check(this.checked)">
        <STRONG> Kredi kartı Bilgileri :</STRONG></font></td>
      <td height="30" bordercolor="#CCCCCC"> <font size="2" face="Geneva, Arial, Helvetica, sans-serif"> 
        &nbsp;KK No : 
        <input name="ccno" id="ccno" value="4506347022052795" size="22" maxlength="16" >
        </font></td>
      <td height="30" bordercolor="#CCCCCC"><font size="2" face="Geneva, Arial, Helvetica, sans-serif"><EM>Kredi 
        Kartı Numarası</EM></font></td>
    </tr>
    <tr bordercolor="#0099ff"> 
      <td height="30" bordercolor="#CCCCCC"> <font size="2" face="Geneva, Arial, Helvetica, sans-serif">&nbsp;SKT 
        :&nbsp;&nbsp;&nbsp; 
        <input name="expdate" id="expdate" value="2002" size="6" maxlength="4" >
        </font></td>
      <td height="30" bordercolor="#CCCCCC"><font size="2" face="Geneva, Arial, Helvetica, sans-serif"><EM>Kredi 
        Kartı Son Kullanma Tarihi (YYAA)</EM></font></td>
    </tr>
    <tr bordercolor="#0099ff"> 
      <td height="30" bordercolor="#CCCCCC"> <font size="2" face="Geneva, Arial, Helvetica, sans-serif"> 
        &nbsp;CVV2 :&nbsp; 
<input name="cvv" id="cvv" value="000" size="5" maxlength="3" >
        </font></td>
      <td height="30" bordercolor="#CCCCCC"><font size="2" face="Geneva, Arial, Helvetica, sans-serif"><EM>Kredi 
        Kartı CVV2 Numarası</EM></font></td>
    </tr>
    <tr bordercolor="#0099ff"> 
<td height="30" bordercolor="#CCCCCC"><font size="2" face="Geneva, Arial, Helvetica, sans-serif">&nbsp;<STRONG>Tutar 
        (x100)&nbsp;:</STRONG></font></td>
      <td height="30" bordercolor="#CCCCCC"> <font size="2" face="Geneva, Arial, Helvetica, sans-serif"> 
        <input name="amount" id="amount" value="5696" maxlength="13" >
        </font></td>
      <td height="30" bordercolor="#CCCCCC"><font size="2" face="Geneva, Arial, Helvetica, sans-serif"><EM>Alışveriş 
        tutarı (14,8 TL için 1480 giriniz.)</EM></font></td>
    </tr>
    <tr bordercolor="#0099ff"> 
<td height="30" bordercolor="#CCCCCC"><font size="2" face="Geneva, Arial, Helvetica, sans-serif"> 
        &nbsp;<STRONG>Para Birimi :</STRONG></font></td>
      <td height="30" bordercolor="#CCCCCC"> <font size="2" face="Geneva, Arial, Helvetica, sans-serif"> 
        <select name="currency" id="tranType0">
          <option value="TL" selected>TL</option>
          <option value="US">US</option>
          <option value="EU">EU</option>
        </select>
        </font></td>
      <td height="30" bordercolor="#CCCCCC"> <font face="Geneva, Arial, Helvetica, sans-serif" size="2"><EM>Para 
        Birimi</EM></font></td>
    </tr>
    <tr bordercolor="#0099ff"> 
<td height="30" bordercolor="#CCCCCC"><font size="2" face="Geneva, Arial, Helvetica, sans-serif">&nbsp;<STRONG>Taksit 
        sayısı :</STRONG></font></td>
      <td height="30" bordercolor="#CCCCCC"> <font size="2" face="Geneva, Arial, Helvetica, sans-serif"> 
        <input name="instalment" id="instalment" value="00" size="2" maxlength="2" >
        </font></td>
      <td height="30" bordercolor="#CCCCCC"><font size="2" face="Geneva, Arial, Helvetica, sans-serif"><EM>Taksit 
        Sayısı</EM></font></td>
    </tr>
    <tr bordercolor="#0099ff"> 
<td height="30" bordercolor="#CCCCCC"><font size="2" face="Geneva, Arial, Helvetica, sans-serif">&nbsp;<STRONG>İşlem 
        Tipi :</STRONG></font></td>
      <td height="30" bordercolor="#CCCCCC"> <font size="2" face="Geneva, Arial, Helvetica, sans-serif"> 
        <select name="tranType" id="tranType">
          <option value="Auth">Provizyon</option>
          <option value="Sale" selected>Satış</option>
          <option value="WP">Puan</option>
          <option value="SaleWP">Puan + Satış</option>
          <option value="Vft">Vade Farklı Satış</option>
        </select>
        </font></td>
      <td height="30" bordercolor="#CCCCCC"><font size="2" face="Geneva, Arial, Helvetica, sans-serif"><EM>Yapılması 
        istenilen işlem tipi</EM></font></td>
    </tr>
    <tr bordercolor="#0099ff"> 
<td height="30" bordercolor="#CCCCCC"><font size="2" face="Geneva, Arial, Helvetica, sans-serif">&nbsp;<STRONG>VFT 
        Kampanya Kodu :</STRONG></font></td>
      <td height="30" bordercolor="#CCCCCC"> <font size="2" face="Geneva, Arial, Helvetica, sans-serif"> 
        <input name="vftCode" id="vftCode" value="K001" SIZE="8" maxlength="4" >
        </font></td>
      <td height="30" bordercolor="#CCCCCC"><font size="2" face="Geneva, Arial, Helvetica, sans-serif"><EM>Yapılması 
        istenilen kampanya kodu</EM></font></td>
    </tr>
    <tr bordercolor="#0099ff"> 
<td height="30" bordercolor="#CCCCCC"> 
<P><font size="2" face="Geneva, Arial, Helvetica, sans-serif">&nbsp;<STRONG>Yeni 
          bir sayfa aç / Mevcut Sayfadan devam et :</STRONG></font></P></td>
      <td height="30" bordercolor="#CCCCCC"> <font size="2" face="Geneva, Arial, Helvetica, sans-serif"> 
        <select name="openANewWindow" id="openANewWindow">
          <OPTION VALUE="true">Yeni bir sayfa aç</OPTION>
          <OPTION VALUE="false" SELECTED>Mevcut Sayfadan devam et</OPTION>
        </select>
        </font></td>
      <td height="30" bordercolor="#CCCCCC"><font size="2" face="Geneva, Arial, Helvetica, sans-serif"><EM>YKB 
        OOS' nın yeni bir pencerede açılmasını mı, yoksa mevcut sayfadan devam 
        etmesini mi belirten bir değerdir. Bir sonraki sayfadaki Java Script fonksiyonunun 
        değerini değiştirir.</EM></font></td>
    </tr>
    <tr bordercolor="#0099ff"> 
<td height="30" bordercolor="#CCCCCC"><font size="2" face="Geneva, Arial, Helvetica, sans-serif"><STRONG>&nbsp;YKB 
        URL : </STRONG></font></td>
      <td height="30" bordercolor="#CCCCCC"> <font size="2" face="Geneva, Arial, Helvetica, sans-serif">&nbsp;&nbsp;"posnet_oos_config.php" 
        dosyasına bakınız. </font></td>
      <td height="30" bordercolor="#CCCCCC"><font size="2" face="Geneva, Arial, Helvetica, sans-serif"><EM>Son 
        sayfanızı yollayacağınız YKB URL'si. Son sayfayı bu URL'ye yolladıktan 
        sonra alışveriş tamamlama sayfanıza bu müşterinin gelmesini bekleyeceksiniz.</EM></font></td>
    </tr>
    <tr bordercolor="#0099ff"> 
<td height="30" bordercolor="#CCCCCC"><font size="2" face="Geneva, Arial, Helvetica, sans-serif"> 
        <STRONG>&nbsp;PYE Anahtarı :</STRONG></font></td>
      <td height="30" bordercolor="#CCCCCC"> <font size="2" face="Geneva, Arial, Helvetica, sans-serif">&nbsp;&nbsp;"posnet_oos_config.php" 
        dosyasına bakınız. </font></td>
      <td height="30" bordercolor="#CCCCCC"><font size="2" face="Geneva, Arial, Helvetica, sans-serif"><EM>Posnet 
        Yönetici Ekranları (PYE) içindeki "Anahtar Yarat" linkine tıklayarak yaratılan 
        anahtar bilginiz.</EM></font></td>
    </tr>
  </table>
  <p align="center">
    <input type="submit" name="Submit" value="Gönder">
  </p>
</form>
<p>&nbsp;</p>
</body>
</html>