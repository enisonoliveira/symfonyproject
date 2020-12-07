<?
session_start();

include 'adodb5/adodb.inc.php';
include 'adodb5/adodb-errorhandler.inc.php';
$db = newADOConnection('mysqli');
include 'adodb5/connect.php';

// $db->connect('', 'decjllec_root', 'a$R=n#Z+~LAj', 'decjllec_central') or die("ERROR CONNECT " . $db);

?>

<!doctype html>
<html lang="pt">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>  
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
	
    <title>Município de Blumenau - SC</title>
  </head>
  
 

<body>  

<br />
<center>
<h2>Município de Blumenau - SC / Módulo de Importações</h2>
<?

// $sql = "select count(usuario) as count, DATE_FORMAT(MAX(dh_atualizacao), '%d/%m/%Y %H:%i:%s') as max from log_acessos where usuario = '".$_SESSION['usuario']."' and sucesso_login = 'S'";
// $ar = $db->getRow($sql);

// echo "<span style='font-size:14px;'>Quantidades de acessos válidos: ".$ar['count'].'<br />';
// echo "Último acesso: ".$ar['max'].'</span>';

// echo $ar['count'];
// print_r($ar);


if ( !empty($_FILES) ){	

	$target_dir = "uploads/";
	

	if(isset($_FILES['fileRubricas']['name'])) {
		// echo $_FILES['fileRubricas']['name'];
		 // var_dump($_FILES['fileServidores']['name']);
		 
		if( !empty($_FILES['fileRubricas']['name'])) {			
			
			$target_file = $target_dir . basename($_FILES["fileRubricas"]["name"]);
			
			if (move_uploaded_file($_FILES["fileRubricas"]["tmp_name"], $target_file)) {
				 // echo "The file ". basename( $_FILES["fileRubricas"]["name"]). " has been uploaded.";
			} else {
				 // echo "Sorry, there was an error uploading your file.";
			}
			
			$sql = "insert into sy_arquivos (nome, path, tamanho) values ('".$_FILES['fileRubricas']['name']."', '$target_file', '".filesize($target_file)."')";		 
			$result = $db->execute($sql);			

			$ar = $db->getCol("select max(CodArquivo) as CodArquivo from sy_arquivos");
			
			$sql = "
			LOAD DATA LOCAL INFILE '$target_file' 	
			 INTO TABLE sy_rubricas 
			 CHARACTER SET latin1
			 FIELDS TERMINATED BY '|'
			 IGNORE 1 LINES
			 (Codigo, Descricao, tp_rubrica, valor, inss, fgts, @dt_ini, @dt_fim, CodArquivo)
			 SET dt_ini = STR_TO_DATE(@dt_ini,'%d/%m/%y')
				,dt_fim = STR_TO_DATE(@dt_fim,'%d/%m/%y')
				,CodArquivo = ".$ar[0];	 
			 
			 $result = $db->execute($sql);	
			 
			$sql = "update sy_arquivos set nr_linhas = (select count(id) 
															from sy_rubricas 
															where CodArquivo = '".$ar[0]."') 
											, nr_novas_linhas = (
											select (select count(codigo) from sy_rubricas where CodArquivo = '".$ar[0]."') -  
				(select count(codigo) from sy_rubricas where CodArquivo = ".$ar[0]."-1)

											)				
											
							where CodArquivo = '".$ar[0]."'";			
			$result = $db->execute($sql);	
			
			$arr = $db->getRow("select nome
									, nr_linhas
									, nr_novas_linhas
									, DATE_FORMAT(dh_importacao, '%d/%m/%Y %H:%i:%S') as dh_importacao 
						from sy_arquivos 
						where CodArquivo = '".$ar[0]."'");		
						
			// echo $arr['nr_novas_linhas'];
			$msg = "<div class='alert alert-primary' role='alert'>
						<b>Log de importação</b><br />
					  Nome do arquivo: ".$arr['nome']."<br />
					  Linhas totais: ".$arr['nr_linhas']."<br />
					  Novas linhas importadas: ".$arr['nr_novas_linhas']."<br />
					  Data de Hora da Importação: ".$arr['dh_importacao']."
					</div>";
					// echo $sql
					// var_dump($arr);

		}		
		
		if(!empty($_FILES['fileServidores']['name'])) {					
			
			$target_file = $target_dir . basename($_FILES["fileServidores"]["name"]);	
			
			if (move_uploaded_file($_FILES["fileServidores"]["tmp_name"], $target_file)) {
				 // echo "The file ". basename( $_FILES["fileRubricas"]["name"]). " has been uploaded.";
			} else {
				 // echo "Sorry, there was an error uploading your file.";
			}
			
			$sql = "
			LOAD DATA LOCAL INFILE '$target_file' 	
			 INTO TABLE sy_servidores
			 CHARACTER SET latin1
			 FIELDS TERMINATED BY '|'			 
			 IGNORE 1 LINES
			 (Codigo,Matricula,Nome,@Data_Admissao,Numero_CTPS,Serie_CTPS,Categoria_Servidor,Numero_PIS_PASEP)
			 SET Data_Admissao = STR_TO_DATE(@Data_Admissao,'%d/%m/%y');";
			 
			 $result = $db->execute($sql);
		}
		if(!empty($_FILES['fileSefip']['name'])) {
			
			$target_file = $target_dir . basename($_FILES["fileSefip"]["name"]);
			
			if (move_uploaded_file($_FILES["fileSefip"]["tmp_name"], $target_file)) {
				 // echo "The file ". basename( $_FILES["fileRubricas"]["name"]). " has been uploaded.";
			} else {
				 // echo "Sorry, there was an error uploading your file.";
			}
			
			$sql = "insert into sy_arquivos (nome, path, tamanho) values ('".$_FILES['fileSefip']['name']."', '$target_file', '".filesize($target_file)."')";		 
			$result = $db->execute($sql);			
			$ar = $db->getCol("select max(CodArquivo) as CodArquivo from sy_arquivos");
			
			$sql = "LOAD DATA LOCAL INFILE '$target_file' 
						INTO TABLE temp";		 
			 $result = $db->execute($sql);
			 
			 $sql = "insert into sefip_v83_reg15_informacoes_codigo_de_recolhimento (Tipo_de_Registro, Tipo_de_Inscricao_Empresa, Inscricao_da_Empresa, Reservado_01, Codigo_Recolhimento, CodArquivo)
					select SUBSTRING(um,1,2)
					      ,SUBSTRING(um,3,1)
						  ,SUBSTRING(um,4,14)
						  ,SUBSTRING(um,18,36)					
						  ,SUBSTRING(um,54,4)	
							,".$ar[0]."
					from temp
					where left(um,2) = '15'";					
			$result = $db->execute($sql);
			
			 $sql = "insert into sefip_v83_reg30_registro_do_trabalhador (Tipo_Registro	
																		, Tipo_de_Inscricao_Empresa
																		 , Inscricao_da_Empresa
																		 ,	Tipo_de_Inscricao_Tomador_obra_de_const_Civil
																		 ,	Inscricao_Tomador_obra_de_const_civil
																		 ,	PIS_PASEP_CI
																		 ,	Data_Admissao
																		 ,	Categoria_Trabalhador
																		 ,Nome_Trabalhador
																		 ,Matricula_do_Empregado
																		 ,Numero_CTPS	
																		 ,Serie_CTPS
																		 ,Data_Opcao
																		 ,Data_Nascimento
																		 ,CBO	
																		 ,Remuneracao_sem_13_Salario
																		 ,Remuneracao_13_Salario
																		 ,Classe_de_Contribuicao
																		 ,Remuneracao_base_de_calculo_da_contribuicao_previdenciaria	
																		 ,Valor_Descontado_do_Segurado	
																		 ,Remuneracao_base_calculo_contrib_previdenciaria_rescisao	
																		 ,CodArquivo)
														
					select SUBSTRING(um,1,2)
					      ,SUBSTRING(um,3,1)
						  ,SUBSTRING(um,4,14)
						  ,SUBSTRING(um,18,1)					
						  ,SUBSTRING(um,19,14)					
						  ,SUBSTRING(um,33,11)					
						  ,SUBSTRING(um,44,8)					
						  ,SUBSTRING(um,52,2)					
						  ,SUBSTRING(um,54,70)					
						  ,SUBSTRING(um,124,11)					
						  ,SUBSTRING(um,135,7)					
						  ,SUBSTRING(um,142,5)					
						  ,SUBSTRING(um,147,8)					
						  ,SUBSTRING(um,155,8)					
						  ,SUBSTRING(um,163,5)									
						  , SUBSTRING(um,169,14)			
						  , SUBSTRING(um,184,14)				
						  ,SUBSTRING(um,198,2)					
						  , SUBSTRING(um,201,14) 					
						  , SUBSTRING(um,216,14) 
						  , SUBSTRING(um,230,14) 
							,".$ar[0]."
					from temp
					where left(um,2) = '30'";					
			  $result = $db->execute($sql);
			  
			$sql = "update sy_arquivos set nr_linhas = (select count(*) 
															from sefip_v83_reg30_registro_do_trabalhador 
															where CodArquivo = '".$ar[0]."') 
											, nr_novas_linhas = (
											select (select count(*) from sefip_v83_reg30_registro_do_trabalhador where CodArquivo = '".$ar[0]."') -  
				(select count(*) from sefip_v83_reg30_registro_do_trabalhador where CodArquivo = ".$ar[0]."-1)

											)		
							where CodArquivo = '".$ar[0]."'";			
			$result = $db->execute($sql);
			// echo $sql;
			
			$sql = "delete from temp";
			$result = $db->execute($sql);
			
			$arr = $db->getRow("select nome
									, nr_linhas
									, nr_novas_linhas
									, DATE_FORMAT(dh_importacao, '%d/%m/%Y %H:%i:%S') as dh_importacao 
						from sy_arquivos 
						where CodArquivo = '".$ar[0]."'");		
						
			// echo $arr['nr_novas_linhas'];
			$msg = "<div class='alert alert-primary' role='alert'>
						<b>Log de importação</b><br />
					  Nome do arquivo: ".$arr['nome']."<br />
					  Linhas totais: ".$arr['nr_linhas']."<br />
					  Novas linhas importadas: ".$arr['nr_novas_linhas']."<br />
					  Data de Hora da Importação: ".$arr['dh_importacao']."
					</div>";
					// echo $sql
					// var_dump($arr);

		}
		
		if(!empty($_FILES['fileCompensacao']['name'])) {
			$target_file = $target_dir . basename($_FILES["fileCompensacao"]["name"]);
			$file=$_FILES["fileCompensacao"]["name"];
		}
		
		// echo 'oi';
	}
	

	// echo $target_file;
	

}

?>



</center>
<br />

	<div class="container" >
	
	<? echo $msg; ?>
	
	<nav aria-label="breadcrumb" style="width:250px;">
	  <ol class="breadcrumb">
		<li class="breadcrumb-item" aria-current="page"><a href="../inicial.php">Inicial</a></li>
		<li class="breadcrumb-item" aria-current="page">Importações</li>
	  </ol>
	</nav>
	
	<hr />
	
	<form action="importacoes.php" method="POST" enctype="multipart/form-data">
		<b>Rubricas / Folha: </b>
		<div class="custom-file">
		  <input type="file" class="custom-file-input" name="fileRubricas" style="width:500px;">
		  <label class="custom-file-label" for="customFile" style="width:500px;">Selecione o arquivo de rubricas / folha</label>
		  <button type="submit" class="btn btn-primary">Importar Rubricas</button>		
			<button type="button" class="btn btn-info" data-toggle="modal" data-target="#modalRubricas">Modelo de Layout de Rubricas / Folha</button>
		</div>
	
	<br />
	
	<hr />
		
	<b>Servidores: </b>
	<div class="custom-file">
	  <input type="file" class="custom-file-input" name="fileServidores" style="width:500px;">
	  <label class="custom-file-label" for="customFile" style="width:500px;">Selecione o arquivo com os servidores</label>
	  <button type="submit" class="btn btn-primary">Importar Servidores</button>
	  <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modalServidores">Modelo de Layout de Servidores</button>
	</div>

	<br />
	
	<hr />
		
		<b>Arquivo SEFIP: </b>
		<div class="custom-file">
		  <input type="file" class="custom-file-input" name="fileSefip" style="width:500px;">
		  <label class="custom-file-label" for="customFile" style="width:500px;">Selecione o arquivo SEFIP</label>
		  <button type="submit" class="btn btn-primary">Importar SEFIP</button>
		</div>		
	
	<br />	
	<hr />
	
	<br /><br />
	
	<b>Arquivo de pedidos de Compensação:&nbsp&nbsp&nbsp</b>
	  	  <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalPERDCOMP">Clique para visualizar o modelo de compensação da PERDCOMP</button>
		 <a href="perdcomp.txt" download="perdcomp.txt" onclick="this.href='perdcomp.txt'>
		  <button type="button" class="btn btn-success" onclick="window.location.href='perdcomp.txt'" >Clique para fazer o Download do Registro</button>
	</a>
	</form>
			
	<br /><br />
	
	<hr />
	
	<button type="button" class="btn btn-lg btn-danger" onclick="location.href='../inicial.php'">
	 <span class="fa fa-backward" aria-hidden="true"></span>&nbsp&nbsp&nbspVoltar
	 </button>	
	 
	 <br /><br />
	
	</div>
	
	<div class="modal fade" id="modalRubricas" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog" style="max-width:800px" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title" id="exampleModalLabel">Modelo de Layout de Rubricas (TXT)</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div class="modal-body">
Código|Nome da Rubrica|Tipo de Rubrica|Valores|INSS|FGTS|Data Inicial|Data Final <br />
1|SALÁRIO|P|3000000,00|S|S|01/01/2017|01/01/2018<br />
7|ADICIONAL TEMPO DE SERVIÇO|P|340133,00|S|S|01/01/2017|01/01/2018<br />
12|HORAS EXTRAS 50%|P|246985,00|S|S|01/01/2017|01/01/2018<br />
26|1/3 FÉRIAS CONSTITUCIONAL|P|166666,67|S|S|01/01/2017|01/01/2018<br />
29|ADICIONAL INSALUBRIDADE|P|41666,67|S|S|01/01/2017|01/01/2018
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
		  </div>
		</div>
	  </div>
	</div>
	
	
	
	<div class="modal fade" id="modalServidores" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div  style="max-width:800px" class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title" id="exampleModalLabel">Modelo de Layout de Servidores (TXT)</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div class="modal-body">
codigo| matricula| nome| dt_admissao| numero_Ctps| serie_ctps| categoria_servidor| numero_pis<br />
1|1|JOSE CARLOS MARIANO DE SOUZA|25/04/1952|0013269|00338|01|13208253299<br />
2|2|FRANCISCO ANTONIO DUTRA|07/07/1953|0037215|00058|01|13209619580<br />
3|3|JOAO CARLOS DE GOUVEA|01/08/1953|0027060|00338|01|13210946298<br />
4|4|JOSE RICARDO FERREIRA|22/03/1952|0019437|00296|01|13214430296
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
		  </div>
		</div>
	  </div>
	</div>
	
<div class="modal fade" id="modalPERDCOMP" tabindex="-1" style="overflow-y:auto; overflow-x:auto;" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div  style="max-width:1000px; overflow-y:auto; overflow-x:auto;" class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title" id="exampleModalLabel">Modelo do Registro S15 (Compensação) da PERDCOMP</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div style="overflow-y:auto; overflow-x:auto;" class="modal-body">
<style type="text/css">
	table.tableizer-table {
		font-size: 12px;
		border: 1px solid #CCC; 
		font-family: Arial, Helvetica, sans-serif;
	} 
	.tableizer-table td {
		padding: 4px;
		margin: 3px;
		border: 1px solid #CCC;
	}
	.tableizer-table th {
		background-color: #104E8B; 
		color: #FFF;
		font-weight: bold;
	}
</style>
<table class="tableizer-table">
<thead><tr class="tableizer-firstrow"><th>TIPO</th><th>RESERVADO</th><th>TIPO_CONTRIBUINTE</th><th>CNPJ_CPF</th><th>TIPO_DOCUMENTO</th><th>PERDCOMP_RETIFICADOR</th><th>DATA_TRANSMISSAO</th><th>CRED_ORIUNDO_ACAO_JUD</th><th>TIPO_CREDITO</th><th>INF_PROCESSO_ADM_ANTERIOR</th><th>NUMERO_PROCESSO</th><th>NATUREZA</th><th>INF_OUTRO_PERDCOMP</th><th>NUM_PERDCOMP_INICIAL</th><th>NUM_ULTIMO_PERDCOMP</th><th>CREDITO_SUCEDIDA</th><th>CNPJ</th><th>SITUACAO_ESPECIAL</th><th>DATA_EVENTO</th><th>PERCENTUAL</th><th>SITUACAO_ESP_TIT_CRED</th><th>EVENTO_TIT_CRED</th><th>BENEF_ALEM_CONTRIB</th><th>DATA_ALVARA_JUD</th><th>CNPJ_ESTAB_DETENTOR_CRED_MATRIC_CEI_DETENTOR_CRED_NUM_IDENT_TRAB</th><th>ANO_COMPETENCIA</th><th>MES_COMPETENCIA</th><th>RECOLHIMENTO_EFET_MATRIC_CEI_PJ</th><th>MATRIC_CEI_PJ</th><th>VLR_ORIG_CRED_INICIAL</th><th>VLR_ORIG_CRED_UTIL_COMPENSACOES</th><th>VLR_ORIG_CRED_DISP_RESTITUICAO</th><th>VLR_ORIG_CRED_SUCESSORA</th><th>VLR_ORIG_CRED_UTIL_COMP_SUCESSORA</th><th>VLR_PEDIDO_RESTIT_PJ</th><th>CRED_ORIG_DT_TRANSMISSAO_PJ</th><th>SELIC_ACUM</th><th>CRED_ATUALIZADO</th><th>TOTAL_CRED_ORIG_UTIL_DOC</th><th>SALDO_CRED_ORIG</th><th>VLR_PED_RESTITUICAO_PF</th><th>CATEG_SEGURADO</th><th>JUSTIF_PEDIDO</th><th>REQUERENTE_EMPREGADOR_DOM</th><th>CPF_EMPREGADO</th><th>DDD_TELEFONE</th><th>TELEFONE</th><th>NUM_BENEFICIO</th></tr></thead><tbody>
 <tr><td>S15</td><td>00001</td><td>01</td><td>50245954000100</td><td>01</td><td>0</td><td>01/01/2016 00:00:00</td><td>00</td><td>00</td><td>0</td><td>00000000000000001</td><td>00</td><td>0</td><td>000000000000000000000000</td><td>000000000000000000000000</td><td>0</td><td>50245954000100</td><td>00</td><td>01/01/2016 00:00:00</td><td>861,22</td><td>0</td><td>00</td><td>0</td><td>01/01/2016 00:00:00</td><td>00000000000000</td><td>0000</td><td>00</td><td>0</td><td>000000000000</td><td>861,22</td><td>861,22</td><td>861,22</td><td>861,22</td><td>861,22</td><td>861,22</td><td>861,22</td><td>861,22</td><td>861,22</td><td>861,22</td><td>861,22</td><td>861,22</td><td>00</td><td>00</td><td>0</td><td>50245954000100</td><td>0000</td><td>000000000</td><td>0000000000</td></tr>
 <tr><td>S15</td><td>00001</td><td>01</td><td>50245954000101</td><td>01</td><td>0</td><td>02/01/2016 00:00:00</td><td>00</td><td>00</td><td>0</td><td>00000000000000002</td><td>00</td><td>0</td><td>000000000000000000000000</td><td>000000000000000000000000</td><td>0</td><td>50245954000101</td><td>00</td><td>02/01/2016 00:00:00</td><td>862,22</td><td>0</td><td>00</td><td>0</td><td>02/01/2016 00:00:00</td><td>00000000000000</td><td>0000</td><td>00</td><td>0</td><td>000000000000</td><td>100,00</td><td>100,00</td><td>100,00</td><td>100,00</td><td>100,00</td><td>100,00</td><td>100,00</td><td>100,00</td><td>100,00</td><td>100,00</td><td>100,00</td><td>100,00</td><td>00</td><td>00</td><td>0</td><td>50245954000101</td><td>0000</td><td>000000000</td><td>0000000000</td></tr>
 <tr><td>S15</td><td>00001</td><td>01</td><td>50245954000102</td><td>01</td><td>0</td><td>03/01/2016 00:00:00</td><td>00</td><td>00</td><td>0</td><td>00000000000000003</td><td>00</td><td>0</td><td>000000000000000000000000</td><td>000000000000000000000000</td><td>0</td><td>50245954000102</td><td>00</td><td>03/01/2016 00:00:00</td><td>863,22</td><td>0</td><td>00</td><td>0</td><td>03/01/2016 00:00:00</td><td>00000000000000</td><td>0000</td><td>00</td><td>0</td><td>000000000000</td><td>500,00</td><td>500,00</td><td>500,00</td><td>500,00</td><td>500,00</td><td>500,00</td><td>500,00</td><td>500,00</td><td>500,00</td><td>500,00</td><td>500,00</td><td>500,00</td><td>00</td><td>00</td><td>0</td><td>50245954000102</td><td>0000</td><td>000000000</td><td>0000000000</td></tr>
 <tr><td>S15</td><td>00001</td><td>01</td><td>50245954000103</td><td>01</td><td>0</td><td>04/01/2016 00:00:00</td><td>00</td><td>00</td><td>0</td><td>00000000000000004</td><td>00</td><td>0</td><td>000000000000000000000000</td><td>000000000000000000000000</td><td>0</td><td>50245954000103</td><td>00</td><td>04/01/2016 00:00:00</td><td>864,22</td><td>0</td><td>00</td><td>0</td><td>04/01/2016 00:00:00</td><td>00000000000000</td><td>0000</td><td>00</td><td>0</td><td>000000000000</td><td>20.000,00</td><td>20.000,00</td><td>20.000,00</td><td>20.000,00</td><td>20.000,00</td><td>20.000,00</td><td>20.000,00</td><td>20.000,00</td><td>20.000,00</td><td>20.000,00</td><td>20.000,00</td><td>20.000,00</td><td>00</td><td>00</td><td>0</td><td>50245954000103</td><td>0000</td><td>000000000</td><td>0000000000</td></tr>
 <tr><td>S15</td><td>00001</td><td>01</td><td>50245954000104</td><td>01</td><td>0</td><td>05/01/2016 00:00:00</td><td>00</td><td>00</td><td>0</td><td>00000000000000005</td><td>00</td><td>0</td><td>000000000000000000000000</td><td>000000000000000000000000</td><td>0</td><td>50245954000104</td><td>00</td><td>05/01/2016 00:00:00</td><td>865,22</td><td>0</td><td>00</td><td>0</td><td>05/01/2016 00:00:00</td><td>00000000000000</td><td>0000</td><td>00</td><td>0</td><td>000000000000</td><td>7.500,00</td><td>7.500,00</td><td>7.500,00</td><td>7.500,00</td><td>7.500,00</td><td>7.500,00</td><td>7.500,00</td><td>7.500,00</td><td>7.500,00</td><td>7.500,00</td><td>7.500,00</td><td>7.500,00</td><td>00</td><td>00</td><td>0</td><td>50245954000104</td><td>0000</td><td>000000000</td><td>0000000000</td></tr>
 <tr><td>S15</td><td>00001</td><td>01</td><td>50245954000105</td><td>01</td><td>0</td><td>06/01/2016 00:00:00</td><td>00</td><td>00</td><td>0</td><td>00000000000000006</td><td>00</td><td>0</td><td>000000000000000000000000</td><td>000000000000000000000000</td><td>0</td><td>50245954000105</td><td>00</td><td>06/01/2016 00:00:00</td><td>866,22</td><td>0</td><td>00</td><td>0</td><td>06/01/2016 00:00:00</td><td>00000000000000</td><td>0000</td><td>00</td><td>0</td><td>000000000000</td><td>954,00</td><td>954,00</td><td>954,00</td><td>954,00</td><td>954,00</td><td>954,00</td><td>954,00</td><td>954,00</td><td>954,00</td><td>954,00</td><td>954,00</td><td>954,00</td><td>00</td><td>00</td><td>0</td><td>50245954000105</td><td>0000</td><td>000000000</td><td>0000000000</td></tr>
 <tr><td>S15</td><td>00001</td><td>01</td><td>50245954000106</td><td>01</td><td>0</td><td>07/01/2016 00:00:00</td><td>00</td><td>00</td><td>0</td><td>00000000000000007</td><td>00</td><td>0</td><td>000000000000000000000000</td><td>000000000000000000000000</td><td>0</td><td>50245954000106</td><td>00</td><td>07/01/2016 00:00:00</td><td>867,22</td><td>0</td><td>00</td><td>0</td><td>07/01/2016 00:00:00</td><td>00000000000000</td><td>0000</td><td>00</td><td>0</td><td>000000000000</td><td>861,22</td><td>861,22</td><td>861,22</td><td>861,22</td><td>861,22</td><td>861,22</td><td>861,22</td><td>861,22</td><td>861,22</td><td>861,22</td><td>861,22</td><td>861,22</td><td>00</td><td>00</td><td>0</td><td>50245954000106</td><td>0000</td><td>000000000</td><td>0000000000</td></tr>
 <tr><td>S15</td><td>00001</td><td>01</td><td>50245954000107</td><td>01</td><td>0</td><td>08/01/2016 00:00:00</td><td>00</td><td>00</td><td>0</td><td>00000000000000008</td><td>00</td><td>0</td><td>000000000000000000000000</td><td>000000000000000000000000</td><td>0</td><td>50245954000107</td><td>00</td><td>08/01/2016 00:00:00</td><td>868,22</td><td>0</td><td>00</td><td>0</td><td>08/01/2016 00:00:00</td><td>00000000000000</td><td>0000</td><td>00</td><td>0</td><td>000000000000</td><td>861,22</td><td>861,22</td><td>861,22</td><td>861,22</td><td>861,22</td><td>861,22</td><td>861,22</td><td>861,22</td><td>861,22</td><td>861,22</td><td>861,22</td><td>861,22</td><td>00</td><td>00</td><td>0</td><td>50245954000107</td><td>0000</td><td>000000000</td><td>0000000000</td></tr>
</tbody></table>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
		  </div>
		</div>
	  </div>
	</div>

  </body>
</html>


