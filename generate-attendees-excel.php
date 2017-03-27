<?php

/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('UTC');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "timereservationdb";

 
$date_filename = strtotime(date('Y-m-d H:i:s'));


$conn = mysqli_connect($servername, $username, $password,$dbname);


$qryReservationResult = mysqli_query($conn,"SELECT a.lastname,a.firstname,a.emailaddress,a.phone, if (b.slots is null, 'NO SCHEDULE', b.slots) as scheds
									FROM participants a
									LEFT JOIN schedules b 
									ON a.schedule = b.id
									GROUP BY a.emailaddress
									ORDER BY a.lastname;");


/**
 * PHPExcel
 *
 * Copyright (c) 2006 - 2015 PHPExcel
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @category   PHPExcel
 * @package    PHPExcel
 * @copyright  Copyright (c) 2006 - 2015 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt	LGPL
 * @version    ##VERSION##, ##DATE##
 */



// if (PHP_SAPI == 'cli')
// 	die('This example should only be run from a Web Browser');

/** Include PHPExcel */
require_once dirname(__FILE__) . '/PHPExcel-1.8/Classes/PHPExcel.php';
// require_once dirname(__FILE__) . '\PHPExcel-1.8\Classes\PHPExcel.php';

// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// Add some data
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'LAST NAME')
            ->setCellValue('B1', 'FIRST NAME')
            ->setCellValue('C1', 'EMAIL ADDRESS')
            ->setCellValue('D1', 'PHONE')
            ->setCellValue('E1', 'SCHEDULE');
$count = 2;
while($row = mysqli_fetch_assoc($qryReservationResult)){

$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$count, htmlspecialchars($row['lastname']))
            ->setCellValue('B'.$count, htmlspecialchars($row['firstname']))
            ->setCellValue('C'.$count, htmlspecialchars($row['emailaddress']))
            ->setCellValue('D'.$count, htmlspecialchars($row['phone']))
            ->setCellValue('E'.$count, htmlspecialchars($row['scheds']));	

	$count++;
}

// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('Simple');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);



// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="attendees_result_'.$date_filename.'.xls"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;
