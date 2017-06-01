<?php
require_once dirname(__FILE__) . '/../Classes/PHPExcel.php';
$objPHPExcel = new PHPExcel();
$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
                             ->setLastModifiedBy("Maarten Balliauw")
                             ->setTitle("Office 2007 XLSX Test Document")
                             ->setSubject("Office 2007 XLSX Test Document")
                             ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
                             ->setKeywords("office 2007 openxml php")
                             ->setCategory("Test result file");

$array = [
            'delivered'     => 10,
            'undelivered'   => 10,
            'uncharged'     => 10,
            'totalSms'      => 10,
            'totalPrice'    => 10,
            'sender'        => [
                'senderA'   => [
                    '01'    => [
                        'd' 	=> 10,
                        'udC' 	=> 10,
                        'udUc' => 10,
                        'ts' 	=> 10,
                        'tsC'	=> 10,
                        'tp' 	=> 10,
                    ],
                    '02'    => [
                        'd' 	=> 10,
                        'udC' 	=> 20,
                        'udUc' => 20,
                        'ts' 	=> 20,
                        'tsC'	=> 20,
                        'tp' 	=> 20,
                    		]
                ],
                'senderB'   => [
                    '01'    => [
                        'd' 	=> 30,
                        'udC' 	=> 30,
                        'udUc' => 30,
                        'ts' 	=> 30,
                        'tsC'	=> 30,
                        'tp' 	=> 30,
                    		],
                    '02'    => [
                        'd' 	=> 40,
                        'udC' 	=> 40,
                        'udUc' => 40,
                        'ts' 	=> 40,
                        'tsC'	=> 40,
                        'tp' 	=> 40,
                    		]
                ],
                'senderX'   => [
                    '01'    => [
                        'd' 	=> 50,
                        'udC' 	=> 50,
                        'udUc'	=> 50,
                        'ts' 	=> 50,
                        'tsC'	=> 50,
                        'tp' 	=> 50,
                    		],
                    '02'    => [
                        'd' 	=> 60,
                        'udC' 	=> 60,
                        'udUc'	=> 60,
                        'ts' 	=> 60,
                        'tsC'	=> 60,
                        'tp' 	=> 60,
                    		]
                ]
            ],
            'operator'      => [
                'operatorA' => [
                    '01'    => [
                        'd' 	=> 10,
                        'udC' 	=> 20,
                        'udUc' => 20,
                        'ts' 	=> 20,
                        'tsC'	=> 20,
                        'tp' 	=> 20,
                    		],
                    '02'    => [
                        'd' 	=> 10,
                        'udC' 	=> 20,
                        'udUc' => 20,
                        'ts' 	=> 20,
                        'tsC'	=> 20,
                        'tp' 	=> 20,
                    		]
                ],
                'operatorB' => [
                    '01'    => [
                        'd' 	=> 10,
                        'udC' 	=> 20,
                        'udUc' => 20,
                        'ts' 	=> 20,
                        'tsC'	=> 20,
                        'tp' 	=> 20,
                    		],
                    '02'    => [
                        'd' 	=> 10,
                        'udC' 	=> 20,
                        'udUc' => 20,
                        'ts' 	=> 20,
                        'tsC'	=> 20,
                        'tp' 	=> 20,
                    ]
                ]
            ]
        ];


$pageWidht  	= 1;
$senderStartrow = 13;
$sheet      	= &$objPHPExcel->setActiveSheetIndex(0);
$senderCount    = count($array['sender']);
$senderColWidth = $senderCount * 6;

foreach($array as $v) {
    $pageWidht = $pageWidht < count($v) ? count($v) : $pageWidht;
}


$pageWidht *= 3;
$lastCol   = chr(65 +$pageWidht -1);
$sheet
    ->setCellValue('A1',  'Last Update Date')       ->setCellValue('B1', date('l, d F Y (H:i)'))		->mergeCells('B1:'  . $lastCol.'1')
    ->setCellValue('A3',  'Delivered')              ->setCellValue('B3', $array['delivered'])			->mergeCells('B3:'  . $lastCol.'3')
    ->setCellValue('A4',  'Undelivered charged')    ->setCellValue('B4', $array['undelivered'])			->mergeCells('B4:'  . $lastCol.'4')
    ->setCellValue('A5',  'undelivered uncharged')  ->setCellValue('B5', $array['uncharged'])			->mergeCells('B5:'  . $lastCol.'5')
    ->setCellValue('A7',  'Total SMS')              ->setCellValue('B7', $array['totalSms'])			->mergeCells('B7:'  . $lastCol.'7')
    ->setCellValue('A8',  'Total Price')            ->setCellValue('B8', $array['totalPrice'])			->mergeCells('B8:'  . $lastCol.'8')
    ->setCellValue('A10', 'Legend')             														->mergeCells('A10:' . $lastCol.'10')
    ->setCellValue('A11', 'D')             			->setCellValue('B11', 'Delivered')					->mergeCells('B11:' . $lastCol.'11')
    ->setCellValue('A12', 'UD_C')             		->setCellValue('B12', 'Undelivered (Charged)')		->mergeCells('B12:' . $lastCol.'12')
    ->setCellValue('A13', 'UD_UC')             		->setCellValue('B13', 'Undelivered (Uncharged)')	->mergeCells('B13:' . $lastCol.'13')
    ->setCellValue('A14', 'TS')             		->setCellValue('B14', 'Total SMS')					->mergeCells('B14:' . $lastCol.'14')
    ->setCellValue('A15', 'TS_C')             		->setCellValue('B15', 'Total SMS Charged')			->mergeCells('B15:' . $lastCol.'15')
    ->setCellValue('A16', 'TP')						->setCellValue('B16', 'Total Price')				->mergeCells('B16:' . $lastCol.'16');
    
    /**
     *  S e t  S u m m a r y   H e a d e r 
     */
function insertSummaryByCategory($type ,&$sheet, &$data, $startRow) {

	if(!empty($data)) {
		$center = ['alignment' => [
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
						'vertical' 	 => PHPExcel_Style_Alignment::VERTICAL_CENTER,
					]			
				];
	
		$colWidth = count($data) *6;
		$lastCol  = chr(65 +$colWidth);
		
		$sheet
			->setCellValue('A'.$startRow, 'Date') ->mergeCells('A'.$startRow.':A'.($startRow +2))
			->setCellValue('B'.$startRow, $type)  ->mergeCells('B'.$startRow.':'.$lastCol.$startRow);
		
// 		$startRow++;
		$i = 0;
		foreach($data as $sender => $traffics) {
			$startCol = chr(65 +($i++ *6) +1);		
			$endCol   = chr(65 +($i   *6));
			$col      = [
					'd' 	=> chr(ord($startCol)),
					'udC' 	=> chr(ord($startCol) +1),
					'udUc' 	=> chr(ord($startCol) +2),
					'ts' 	=> chr(ord($startCol) +3),
					'tsC' 	=> chr(ord($startCol) +4),
					'tp' 	=> chr(ord($startCol) +5),
			];
			echo json_encode(compact('startCol','endCol','col')).PHP_EOL;
			$sheet
				->setCellValue($startCol   . ($startRow +1), $sender) 	->mergeCells($startCol.($startRow +1).':'.$endCol.($startRow +1))
				->setCellValue($col['d']   . ($startRow +2), 'D')
				->setCellValue($col['udC'] . ($startRow +2), 'UD_C')
				->setCellValue($col['udUc']. ($startRow +2), 'UD_UC')
				->setCellValue($col['ts']  . ($startRow +2), 'TS')
				->setCellValue($col['tsC'] . ($startRow +2), 'TS_C')
				->setCellValue($col['tp']  . ($startRow +2), 'TP');
			
	/**
	 *  D u m p   s u m m a r y   d a t a
	 */
			$iterator = $startRow +2;
			foreach($traffics as $date => $traffic) {
// 			die(json_encode($traffic, 192));
				echo json_encode($col).PHP_EOL;
				echo json_encode($traffic).PHP_EOL.'-------'.PHP_EOL;
				$sheet
					->setCellValue('A' . ++$iterator, $date)	
					->setCellValue($col['d']   . $iterator,   $traffic['d'])
					->setCellValue($col['udC'] . $iterator,   $traffic['udC'])
					->setCellValue($col['udUc']. $iterator,   $traffic['udUc'])
					->setCellValue($col['ts']  . $iterator,   $traffic['tsC'])
					->setCellValue($col['tsC'] . $iterator,   $traffic['ts'])
					->setCellValue($col['tp']  . $iterator,   $traffic['tp']);
			}
		
			$sheet->getStyle('A'.$startRow.':'.$lastCol.($startRow +1))->applyFromArray($center);
	/**
	 *  E n d   o f   d u m p   s u m m a r y   d a t a
	 */
			
		}
	}
	/**
	 *  E n d   o f    Se  t   S u m m a r y   H e a d e r
	 */

}

$startRow = 18;
insertSummaryByCategory('SENDER',   $sheet, $array['sender'],   $startRow);
insertSummaryByCategory('OPERATOR', $sheet, $array['operator'], $startRow +35);






// foreach ($array as $senders) {
//     foreach ($senders as $sender) {
//         $i = 2;
//         foreach ($sender as $date) {

//             $objPHPExcel
//                 ->getActiveSheet()
//                     ->setCellValue('A' . $i, "FName $i")
//                     ->setCellValue('B' . $i, "LName $i")
//                     ->setCellValue('C' . $i, "PhoneNo $i")
//                     ->setCellValue('D' . $i, "FaxNo $i")
//                     ->setCellValue('E' . $i, true);
//         }
//     }
// }

// $objPHPExcel->getActiveSheet()->getStyle('C5:R95')->applyFromArray(
//     array('fill'    => array(
//                                 'type'      => PHPExcel_Style_Fill::FILL_SOLID,
//                                 'color'     => array('argb' => 'FFFFFF00')
//                             ),
//          )
//     );

// $objPHPExcel->getActiveSheet()->mergeCells('A1:C1');
    foreach (range('A', $sheet->getHighestDataColumn()) as $col) {
    	$sheet->getColumnDimension($col)->setAutoSize(true);
    }
    
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('test/test'.date('YmdHis').'.xlsx');