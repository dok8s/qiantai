<?php
echo "<br>";
?>

<?php
  
function GetIP()
{
if(!empty($_SERVER["HTTP_CLIENT_IP"]))
   $cip = $_SERVER["HTTP_CLIENT_IP"];
else if(!empty($_SERVER["HTTP_X_FORWARDED_FOR"]))
   $cip = $_SERVER["HTTP_X_FORWARDED_FOR"];
else if(!empty($_SERVER["REMOTE_ADDR"]))
   $cip = $_SERVER["REMOTE_ADDR"];
else
   $cip = "�޷���ȡ��";
return $cip;
}
echo "<br>";
?>

��������
<?php
echo "<br>";
?>

<?
error_reporting (E_ERROR | E_WARNING | E_PARSE);
if($HTTP_SERVER_VARS["HTTP_X_FORWARDED_FOR"]) 
{                                              
       $ip = $HTTP_SERVER_VARS["HTTP_X_FORWARDED_FOR"];
      
}                                              
elseif($HTTP_SERVER_VARS["HTTP_CLIENT_IP"])    
{                                              
       $ip = $HTTP_SERVER_VARS["HTTP_CLIENT_IP"];
         
}                                              
elseif ($HTTP_SERVER_VARS["REMOTE_ADDR"])       
{                                              
       $ip = $HTTP_SERVER_VARS["REMOTE_ADDR"];  
            
}                                              
elseif (getenv("HTTP_X_FORWARDED_FOR"))          
{                                              
       $ip = getenv("HTTP_X_FORWARDED_FOR");  
               
}                                              
elseif (getenv("HTTP_CLIENT_IP"))                
{                                              
       $ip = getenv("HTTP_CLIENT_IP");  
                     
}          
                                 
elseif (getenv("REMOTE_ADDR"))                   
{                                              
       $ip = getenv("REMOTE_ADDR"); 
                        
}       
                                    
else                                           
{                                              
       $ip = "Unknown";    
                                 
}                                              
echo "���IP��ַ��:".$ip."<br>";                            
?> 


����������򵥣���
<?php
echo "<br>";
?>

<?
$iipp = $_SERVER["REMOTE_ADDR"];
echo $iipp;
echo "<br>";
?>

�����ģ�
<?php
echo "<br>";
?>

<?php
$user_IP = ($_SERVER["HTTP_VIA"]) ? $_SERVER["HTTP_X_FORWARDED_FOR"] : $_SERVER["REMOTE_ADDR"];
$user_IP = ($user_IP) ? $user_IP : $_SERVER["REMOTE_ADDR"];
echo $user_IP."<br>";
?>

�����壺
<?php
echo "<br>";
?>

<?
function get_real_ip()
{
       $ip=false;
       if(!empty($_SERVER["HTTP_CLIENT_IP"]))
       {
            $ip = $_SERVER["HTTP_CLIENT_IP"];
       }
       if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
       {
            $ips = explode (", ", $_SERVER['HTTP_X_FORWARDED_FOR']);
            if ($ip)
            {
                     array_unshift($ips, $ip); $ip = FALSE;
            }
            for ($i = 0; $i < count($ips); $i++)
            {
                     if (!eregi ("^(10|172\.16|192\.168)\.", $ips[$i]))
                     {
                               $ip = $ips[$i];
                               break;
                     }
            }
       }
       return ($ip ? $ip : $_SERVER['REMOTE_ADDR']);
}
echo get_real_ip();
echo "<br>";
?>

��������
<?php
echo "<br>";
?>

<?
if(getenv('HTTP_CLIENT_IP'))
{
       $onlineip = getenv('HTTP_CLIENT_IP');
}
elseif(getenv('HTTP_X_FORWARDED_FOR'))
{
       $onlineip = getenv('HTTP_X_FORWARDED_FOR');
}
elseif(getenv('REMOTE_ADDR'))
{
       $onlineip = getenv('REMOTE_ADDR');
}
else
{
       $onlineip = $HTTP_SERVER_VARS['REMOTE_ADDR'];
}
echo $onlineip;
echo "<br>";
?>