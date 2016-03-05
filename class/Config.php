<?php
class Config {
    private $numberOfAnswer     = 4;
    private $excelPath          = "english_word.xls";
    public function getNumberOfAnswer(){
        return $this->numberOfAnswer;
    }
    public function getExcelPath(){
        return $this->excelPath;
    }
}

