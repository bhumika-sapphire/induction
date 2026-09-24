<?php
require("includes/startup.php");
$user_id=($_SESSION[SESSION_PREFIX.'USER_ID']);
$data = array();
$arr1 = array();
$arr2 = array();
$arr_v = array();
$tt = array();
$correct_ctr = 0;

$topic_id=$_POST['topic_id'];

for($i = 1;$i<=FINAL_TEST_QUESTIONS; $i++){
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
		
		$data = array('question_id'=>$arr1[0],'answer_option'=>$arr1[1],'final_test_id'=>$_POST['final_test_id'],'is_correct'=>$is_correct);
		$test_ins = $conn->Autoexecute(TABLE_PREFIX."user_final_test_details",$data,"INSERT",true,false, MAGIC_QUOTES);
		$arr_v[] = $arr1[0];
	}
}

$arr2 = explode(",",$_POST['questions']);

foreach($arr2 as $question_id){
	if(!in_array($question_id,$arr_v)){
		$data = array('question_id'=>$question_id,'answer_option'=>0,'final_test_id'=>$_POST['final_test_id'],'is_correct'=>0);
		$test_ins = $conn->Autoexecute(TABLE_PREFIX."user_final_test_details",$data,"INSERT",true,false, MAGIC_QUOTES);
	}
}

if($test_ins)
{
	$tt["time_taken"] = str_prepare($_POST['time_taken']);
	$tt["total_questions"] = count($arr_v);
	$tt["correct_answers"] = $correct_ctr;
	
	if((($correct_ctr*100)/count($arr_v)) >= FINAL_TEST_PASS)
	{
		

		$tt["is_pass"] = 1;
	}
	else
	{
		$tt["is_pass"] = 0;
	}
	
	$tt["topic_id"]=$topic_id;
	
	$update_time_test_ins = $conn->Autoexecute("user_final_test_master",$tt,"UPDATE","final_test_id= ".$conn->qstr($_POST['final_test_id']),true,false,MAGIC_QUOTES);
	
	$again_btn_hide_show = $conn->Execute("UPDATE user_request SET request_status = 'Used',final_test_id=".$_POST['final_test_id']." where request_status='Approved' AND user_id='".$user_id."'");
	
	
//	setMsg("Test saved successfully");
    header("location: final_test_result.php?final_test_id=".$_POST['final_test_id']);
    exit();
}	
else
{
	print 'Error';
	
}

//print_r($data);



?>