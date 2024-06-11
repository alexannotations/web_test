	<!-- Program: mysqlsend.php 
		Programa para enviar consultas en SQL a MySQL Server
		y mostrar los resultados
		Del Libro PHP y MySQL para Dummys PHP 5
		Version actualizada a mysqli
		Presenta varias vulnerabilidades
	-->
<html>
	<head>
		<title>Enviar consultas</title>
                <meta charset="utf-8">
                <meta name="viewport" content="width=device-width">
	</head>

	<body>
	
		<?php
			$host="localhost";
			$user="root";
			$password="";

			date_default_timezone_set('America/Mexico_City');
			/*cambia el charset para mostrar acentos de UTF-8 a ISO*/
			header('Content-Type: text/html; charset=iso-8859-1');
			/*Seccion qie ejecuta la consulta*/

		if(@$_GET['form'] == "yes")
		{
			$conexion = mysqli_connect($host,$user,$password);
			mysqli_select_db($conexion, $_POST['database']);
			$query = stripSlashes($_POST['query']);
			$result = mysqli_query($conexion, $query);
			echo "Base de Datos Seleccionada: <b>{$_POST['database']}</b><br>
				 Consulta: <b>$query</b><h3>Resultados</h3><hr>";
			if($result == false)
				echo "<b> Error ".mysqli_errno($conexion).": ".mysqli_error($conexion).
					 "</b>";
			elseif (@mysqli_num_rows ($result) == 0)
				echo("<b>Consulta Completada. NO se encontraron resultados.
						</b><br>");
			else
			{
			 echo "<table border='1'>
			  <thead>
			   <tr>";
			   $field_name = mysqli_fetch_fields ($result);	// tenemos un array asociativo de objetos con atributos (clave -> valor)
			   foreach ($field_name as $field) {
				echo "<th> $field->name </th>";
			   }
				echo " </tr>
					  </thead>
					 <tbody>";
						for ($i = 0; $i < mysqli_num_rows($result); $i++)
						{
						echo "<tr>";
						 $row = mysqli_fetch_row($result);
						 for($j = 0;$j < mysqli_num_fields($result);$j++)
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
		     <td align="right"><b> Escriba el nombre de la base de datos </b></td>
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