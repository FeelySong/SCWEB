<%@ Page language="VB" AutoEventWireup="false" validateRequest="False"%>

<HTML>
<HEAD>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7">
<TITLE>eWebEditor �� ������ʾ��</TITLE>
<META http-equiv=Content-Type content="text/html; charset=gb2312">
<link rel='stylesheet' type='text/css' href='example.css'>
</HEAD>
<BODY>

<p><b>���� �� <a href="default.htm">ʾ����ҳ</a> &gt; ������ʾ��</b></p>
<p>������ʾ����ν��յ����ύ������HTML���룬����ʾ����</p>

<%

Dim sContent1
sContent1 = Request.Form("content1")

Response.Write ("�༭�������£�<br><br>" & sContent1)
Response.Write ("<br><br><p><input type=button value=' ���� ' onclick='history.back()'></p>")

%>

</BODY>
</HTML>