<?php

//引入PHPExcel核心
require(FRAMEWORK_PATH . 'libraries/PHPExcel/PHPExcel.php');
/**
 * Excel表操作（导出）
 */
class Excel{

    /**
     * 设置表格标题、表头（注意：列仅A-Z）
     * @param $sheet 工作sheet
     * @param $sheetName 工作簿名
     * @param $title 表格标题，可不填写
     * @param $header 表头标题集合
     * @return int 下一行位置Index
     */
    protected function header($sheet, $sheetName, $title, $header){
        $sheet->setTitle($sheetName); //标题
        //设置标题
        if($title) {
            $a = 'A';
            for($i=1; $i<count($header); $i++){$a++;} //计算合并最后位置
            $sheet->mergeCells("A1:".$a."1"); //合并单元格
            $sheet->getStyle('A1')->getAlignment() //居中
                ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER)
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $sheet->setCellValue("A1", $title);
        }
        //设置列名
        $col = 'A';
        foreach($header as $name){
            $sheet->setCellValue($col.($title ? "2" : "1"), $name);
            $col++;
        }
        return $title ? 3 : 2;
    }

    /**
     * 写入导出的数据
     * @param $sheet 工作sheet
     * @param $index 下一个写入记录的位置
     * @param $data 所有数据
     * @param $total 合计位置，1开始
     */
    protected function writeData($sheet, $index, $data, $total){
        $sum = array(); //记录$total位置的和
        $total = "," . $total . ",";
        foreach($data as $row){ //行
            $col = 'A';
            $loc = 1;
            foreach($row as $cell){ //单元格
                if(strpos($total, "".$loc) !== false){
                    if(isset($sum[$loc])){
                        $sum[$loc] += floatval($cell);
                    }else{
                        $sum[$loc] = floatval($cell);
                    }
                }
                $sheet->setCellValue($col.$index, $cell);
                $col++; //列+1
                $loc++; //位置+1
            }
            $index++; //行+1
        }
        //合计行
        if($total && count($sum) > 0){
            foreach($sum as $key => $value){
                $col = 'A';
                for($i=1; $i<$key; $i++){$col++;}
                $sheet->setCellValue($col.$index, $value);
            }
            $sheet->setCellValue("A".$index, "合计");
        }
    }

    /**
     * 开始下载Excel文件
     * @param $phpExcel PHPExcel实体
     * @param $fileName 文件名
     */
    private function execDownExcel($phpExcel, $fileName){
        //设置头信息
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $fileName .'.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($phpExcel, 'Excel5');
        $objWriter->save('php://output');
    }

    /**
     * Excel表导出功能
     * @param $fileName 导出时文件命名
     * @param $title 表格标题，第一行，为空时无
     * @param $header 表头，查询SQL中select内容需与此一致
     * @param $data 数据
     * @param $total 需合计的列，从1开始
     */
    public function export($fileName, $title, $header, $data, $total=""){
        $phpExcel = new PHPExcel(); //生成excel核心组件
        $phpExcel->setActiveSheetIndex(0); //设置序号
        $index = $this->header($phpExcel->getActiveSheet(),
            $fileName, $title, $header); //构建工作簿
        $this->writeData($phpExcel->getActiveSheet(), $index, $data, $total);
        $this->execDownExcel($phpExcel, $fileName);
    }
}

