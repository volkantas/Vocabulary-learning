<?php
session_start();
include("class/JsonReturn.class.php");
require_once 'class/excel_reader2.php';
require_once 'class/Config.php';
$cnf                    = new Config();
$return                 = new JsonReturn();
$data                   = new Spreadsheet_Excel_Reader($cnf->getExcelPath(),true,"UTF-8");
$rowCount               = $data->rowcount($sheet_index=0);
$answers                = array();
$questionID             = null;
if(!isset($_SESSION['questionPossibility'])){
    $_SESSION['questionPossibility']  = range(1,$rowCount);
}
if(isset($_POST["unwantedID"]) && $_POST["unwantedID"] != null){
    removeQuestionFromList($_POST["unwantedID"]);
}
if(sizeof($_SESSION['questionPossibility'])<1){
    unset($_SESSION['questionPossibility']);
    $return->setMessage('Soruların hepsini cevapladın. Sayfayı yenilediğinde tekrar görebileceksin.');
    $return->fail();
}
while(isQuestionNull($questionID)){
    $questionID = pickRandomQuestionID($rowCount);
}

$return->addValue("id",$questionID);
$return->addValue("questionText",$data->val($questionID,1));
array_push($answers,array("id"=>$questionID,"text"=>$data->val($questionID,2)));

while(sizeof($answers)<$cnf->getNumberOfAnswer()){
    $randomID   =pickRandomAnswerID($rowCount);
    $flag       = false;
    foreach($answers as $answer)
    {
        if($randomID == $answer["id"])
        {
            $flag = true;
            break;
        }
    }
    if(!$flag && !isQuestionNull($randomID)){
        array_push($answers,array("id"=>$randomID,"text"=>$data->val($randomID,2)));
    }
}
$return->addValue("answers",$answers);
$return->addValue("countQuestionLeft",countQuestionLeft());
$return->addValue("totalRowInExcel",$rowCount);
$return->success();

function pickRandomQuestionID(){
    shuffle($_SESSION['questionPossibility']);
    return $_SESSION['questionPossibility'][0];
}

function pickRandomAnswerID($rowCount){
    return rand(1,$rowCount);
}

function isQuestionNull($id=null){
    global $data;
    if($data->val($id,1)=="" || $id==null){
        return true;
    }else{
        return false;
    }
}

function removeQuestionFromList($id){
    $_SESSION['questionPossibility'] = array_diff($_SESSION['questionPossibility'],array($id));
}

function countQuestionLeft(){
    return sizeof($_SESSION['questionPossibility']);
}