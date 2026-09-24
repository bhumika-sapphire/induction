<?php
require("includes/startup.php");

$data = array();
$arr1 = array();
$arr2 = array();
$arr_v = array();
$tt = array();
$correct_ctr = 0;

$total_questions=CHAPTER_TEST_QUESTIONS;

for($i = 1;$i<=$total_questions; $i++){
	if(isset($_POST['question_'.$i])){
		$arr1 = explode("_",$_POST['question_'.$i]);
		$exec = $conn->Execute('select topic_id,correct_answer from question_bank_master where question_id='.$arr1[0]);
		$row = $exec->FetchRow();
	
		if($row['correct_answer']==$arr1[1]){
			$is_correct = 1;
			$correct_ctr++;
		}else{
			$is_correct = 0;
		}
		
		$data = array('question_id'=>$arr1[0],'answer_option'=>$arr1[1],'chapter_test_id'=>$_POST['chapter_test_id'],'is_correct'=>$is_correct);
		$test_ins = $conn->Autoexecute(TABLE_PREFIX."user_chapter_test_details",$data,"INSERT",true,false, MAGIC_QUOTES);
		$arr_v[] = $arr1[0];
	}
}

$arr2 = explode(",",$_POST['questions']);

foreach($arr2 as $question_id){
	if(!in_array($question_id,$arr_v)){
		$data = array('question_id'=>$question_id,'answer_option'=>0,'chapter_test_id'=>$_POST['chapter_test_id'],'is_correct'=>0);
		$test_ins = $conn->Autoexecute(TABLE_PREFIX."user_chapter_test_details",$data,"INSERT",true,false, MAGIC_QUOTES);
	}
}

if($test_ins)
{
	$tt["time_taken"] = str_prepare($_POST['time_taken']);
	$tt["total_questions"] = count($arr_v);
	$tt["correct_answers"] = $correct_ctr;
	
	if((($correct_ctr*100)/count($arr_v)) >= CHAPTER_TEST_PASS)
	{
		$tt["is_pass"] = 1;
	}
	
	$update_time_test_ins = $conn->Autoexecute("user_chapter_test_master",$tt,"UPDATE","chapter_test_id= ".$conn->qstr($_POST['chapter_test_id']),true,false,MAGIC_QUOTES);
	
	$sql = "Select chapter_id FROM chapter_master cm WHERE topic_id=".$_POST['topic_id']." AND cm.chapter_id NOT IN (SELECT chapter_id FROM user_chapter_test_master WHERE user_id=".$_SESSION[SESSION_PREFIX.'USER_ID']." AND is_pass=1 AND topic_id=".$_POST['topic_id'].")";
	$test = $conn->Execute($sql);
	if($test->RowCount() == 0)
	{
		$sql = "UPDATE user_topics set topic_completed=1 WHERE user_id=".$_SESSION[SESSION_PREFIX.'USER_ID']." AND topic_id=".$_POST['topic_id'];
		$res = $conn->Execute($sql);
	}
	
	setMsg("Test saved successfully");
    header("location: chapter_test_result.php?chapter_test_id=".$_POST['chapter_test_id']."&topic_id=".$_POST['topic_id']);
    exit();
}	
else
{
	print 'error';
	
}

//print_r($data);



?>