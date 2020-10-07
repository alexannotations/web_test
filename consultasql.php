	<!-- Program: mysqlsend.php 
		Programa para enviar consultas en SQL a MySQL Server
		y mostrar los resultados
		Del Libro PHP y MySQL para Dummys
		Para PHP 5
	-->
<html>
	<head>
		<title>Enviar consultas a CSP</title>
                <meta charset="utf-8">
                <meta name="viewport" content="width=device-width">
	</head>

	<body>
	
		<?php
			$host="localhost";
			$user="escriba_su_usuario";
			$password="escriba_su_contraseña";
                        /*cambia el charset para mostrar acentos de UTF-8 a ISO*/
                        header('Content-Type: text/html; charset=iso-8859-1');
			/*Seccion qie ejecuta la consulta*/

		if(@$_GET['form'] == "yes")
		{
			mysql_connect($host,$user,$password);
			mysql_select_db($_POST['database']);
			$query = stripSlashes($_POST['query']);
			$result = mysql_query($query);
			echo "Base de Datos Seleccionada: <b>{$_POST['database']}</b><br>
				 Consulta: <b>$query</b><h3>Resultados</h3><hr>";
			if($result == 0)
				echo "<b> Error ".mysql_errno().": ".mysql_error().
					 "</b>";
			elseif (@mysql_num_rows ($result) == 0)
				echo("<b>Consulta Completada. NO se encontraron resultados.
						</b><br>");
			else
			{
			 echo "<table border='1'>
			  <thead>
			   <tr>";
			    for($i = 0;$i < mysql_num_fields($result);$i++)
				{
				echo  "<th>".mysql_field_name($result,$i).
					 "</th>";
				}
				echo " </tr>
					  </thead>
					 <tbody>";
						for ($i = 0; $i < mysql_num_rows($result); $i++)
						{
						echo "<tr>";
						 $row = mysql_fetch_row($result);
						 for($j = 0;$j < mysql_num_fields($result);$j++)
						 {
						 	echo ("<td>" . $row[$j] . "</td>");
						 }
						echo "<tr>";
					  	}
			echo "</tbody>
				  </table>";
			} //end else
			echo "
			<hr><br>
			<form action=\"{$_SERVER['PHP_SELF']}\"method=\"POST\">
			  <input type='hidden' name='query' value='$query'>
			  <input type='hidden' name='database'
			  		 value={$_POST['database']}>
			  <input type='submit' name=\"queryButton\"
					 value=\"Nueva Consulta\">
			  <input type='submit' name=\"queryButton\"
			  		 value=\"Editar Consulta\">
			</form>";
		   unset($form);
		   exit();
		} // end if form = yes
		
		/*Section that requests user input of query */
		@$query=stripSlashes($_POST['query']);
		if (@$_POST['queryButton'] !="Editar Consulta")
		{
			$query = " ";
		}
		?>		
		
		<form action="<?php echo  $_SERVER['PHP_SELF'] ?>?form=yes"
			  method="POST">
		  <table>
		   <tr>
		     <td align=right><b> Escriba el nombre de la base de datos </b></td>
			 <td><input type="text" name="database"
			 			value=<?php echo @$_POST['database'] ?> ></td>
			 </tr>
			 <tr>
			 <td align="right" valign="top">
			 		<b> Escriba su consulta en SQL</b></td>
			 <td><textarea name="query" cols="60"
			 				rows="10"><?php echo $query ?></textarea>
			 </td>
			 
			 </tr>
			 	<tr>
				  <td colspan="2" aling="center"><input type="submit"
				  		value="Enviar Consulta"></td>
				</tr>
			 </table>
		</form>
		
	</body>
</html>