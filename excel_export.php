<?php ob_start();
	
//------------------------------------------------------------------------------------------------------------------
// EXPORT TO EXCEL	
//------------------------------------------------------------------------------------------------------------------
// To call the excel export use: http://www.website.nl/export?pass=excel123&table=tbl_table

// Set allowed tables(Change to set allowed tables) / password / path to core 
$tableArray = array('tbl_table');
$password 	= 'excel123';
$corePath	= $_SERVER['DOCUMENT_ROOT'] . '/_core/core.config.php';
		
// Require some stuff
require_once($corePath);

if ($_GET['pass'] == $password) {

	if (Validator::match_if_set('parameter',$_GET['table']) && in_array($_GET['table'], $tableArray)) {
		
		// Instantiate the process notification handler, for errors and success notification (singleton)
		$process = Process::instantiate();
		
		// CONNECT: to database and instantiate $db object using singleton patern
		$db = Db::instantiate();
	
		// USE: DataSet to get data
		$structureRes = $db->query('
			DESCRIBE '. $_GET['table'] 
		);
		$dataRes = $db->query('
			SELECT t.*
			FROM '. $_GET['table'] .' AS t 
			ORDER BY t.id DESC
		');
	
		// PROCESS: data
		$tableHeads = NULL;
		$tableColumns = array();
		while ($row = $structureRes->fetch_assoc()) {
			$tableHeads .= '<th>' . $row['Field'] . '</th>';
			$tableColumns[] = $row['Field']; 
		}
		$tableHeads = '<tr>'. $tableHeads .'</tr>';
		
		
		// PROCESS: data
		$tableRows = NULL;
		while ($row = $dataRes->fetch_assoc()) {
			$tableData = NULL;
			foreach ($tableColumns as $column) {
				$tableData .= '<td>' . $row[$column] . '</td>';
			}
			$tableRows .= '<tr>'. $tableData .'</tr>';
			
		}
		//die($tableRows);
		
		$fileContent = '
			<html>
				<head>
					<style>
					<!--
					
					-->
					</style>
				</head>
				<body>
					<table border="1" cellpadding="5px" cellspacing="0">
						<tbody>' . 
							$tableHeads .
							$tableRows . '			  
						</tbody>
					</table>
				</body>
			</html>
		';
		
		$excelFileName = str_replace(' ', '_', date('Y-m-d H_i_s', time())) . '.aanmeldingen.xls';
		ob_clean();
		header("Content-Type: application/vnd.ms-excel"); 
		header("Content-Disposition: attachment; filename=$excelFileName");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Pragma: no-cache"); 
		header("Expires: 0"); 
		
		print "$header\n$fileContent";
		exit;

	} else {
		die('Deze tabel mag niet uitgelezen worden');	
	}
}
?>