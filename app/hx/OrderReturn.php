<?php
header("Content-type:text/html; charset=gb2312"); 

//----------------------------------------------------
//  ��������
//  Receive the data
//----------------------------------------------------
$billno = $_GET['billno'];
$amount = $_GET['amount'];
$mydate = $_GET['date'];
$succ = $_GET['succ'];
$msg = $_GET['msg'];
$attach = $_GET['attach'];
$ipsbillno = $_GET['ipsbillno'];
$retEncodeType = $_GET['retencodetype'];
$currency_type = $_GET['Currency_type'];
$signature = $_GET['signature'];

//'----------------------------------------------------
//'   Md5ժҪ��֤
//'   verify  md5
//'----------------------------------------------------

//RetEncodeType����Ϊ17��MD5ժҪ����ǩ����ʽ��
//���׷��ؽӿ�MD5ժҪ��֤��������Ϣ���£�
//billno+��������š�+currencytype+�����֡�+amount+��������+date+���������ڡ�+succ+���ɹ���־��+ipsbillno+��IPS������š�+retencodetype +�����׷���ǩ����ʽ��+���̻��ڲ�֤�顿
//��:(billno000001000123currencytypeRMBamount13.45date20031205succYipsbillnoNT2012082781196443retencodetype17GDgLwwdK270Qj1w4xho8lyTpRQZV9Jm5x4NwWOTThUa4fMhEBK9jOXFrKRT6xhlJuU2FEa89ov0ryyjfJuuPkcGzO5CeVx5ZIrkkt1aBlZV36ySvHOMcNv8rncRiy3DQ)

//���ز����Ĵ���Ϊ��
//billno + mercode + amount + date + succ + msg + ipsbillno + Currecny_type + retencodetype + attach + signature + bankbillno
//ע2����RetEncodeType=17ʱ��ժҪ������ȫת��Сд�ַ���������֤��ʱ�������ɵ�Md5ժҪ��ת��Сд�������Ƚ�
$content = 'billno'.$billno.'currencytype'.$currency_type.'amount'.$amount.'date'.$mydate.'succ'.$succ.'ipsbillno'.$ipsbillno.'retencodetype'.$retEncodeType;
//���ڸ��ֶ��з����̻���½merchant.ips.com.cn���ص�֤��
$cert = 'GDgLwwdK270Qj1w4xho8lyTpRQZV9Jm5x4NwWOTThUa4fMhEBK9jOXFrKRT6xhlJuU2FEa89ov0ryyjfJuuPkcGzO5CeVx5ZIrkkt1aBlZV36ySvHOMcNv8rncRiy3DQ';
$signature_1ocal = md5($content . $cert);

if ($signature_1ocal == $signature)
{
	//----------------------------------------------------
	//  �жϽ����Ƿ�ɹ�
	//  See the successful flag of this transaction
	//----------------------------------------------------
	if ($succ == 'Y')
	{
		/**----------------------------------------------------
		*�ȽϷ��صĶ����źͽ���������ݿ��еĽ���Ƿ����
		*compare the billno and amount from ips with the data recorded in your datebase
		*----------------------------------------------------
		
		if(����)
			echo "��IPS���ص����ݺͱ��ؼ�¼�Ĳ����ϣ�ʧ�ܣ�"
			exit
		else
			'----------------------------------------------------
			'���׳ɹ��������������ݿ�
			'The transaction is successful. update your database.
			'----------------------------------------------------
		end if
		**/
		echo '���׳ɹ�';
	}
	else
	{
		echo '����ʧ�ܣ�';
		exit;
	}
}
else
{
	echo 'ǩ������ȷ��';
	exit;
}
?>
