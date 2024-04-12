<?php 

		$tipoAcss = $_POST['tipoAcss'];
  		$login = $_POST['login'];
  		$entrar = $_POST['entrar'];
  		$senha = md5($_POST['senha']);
  		$connect = mysqli_connect('localhost','root','');
  		//$db = mysql_select_db('manutencao');
  		
  		
    		if (isset($entrar)) {        
                
          if (($tipoAcss == 'administrador')&&($senha == '202cb962ac59075b964b07152d234b70')&&($login == 'root@root'))   {
          	
          	echo"<script language='javascript' type='text/javascript'>alert(' Login e/ou senha incorretos - professor');window.location.href='index.php';</script>";
            setcookie("tipoAcss",$tipoAcss,(time() + (600)));        
          	setcookie("login",$login,(time() + (600)));
          	header("Location:index.html");        	   
        }
    }
?> 