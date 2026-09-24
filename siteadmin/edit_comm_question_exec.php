<?php
require_once("../includes/startup.php");
require_once('authenticate.php');
$err = false;
$add_question = array();

   $question_id = str_prepare($_POST["question_id"]);
   $add_question["topic_id"] = str_prepare($_POST["topic_id"]);
   $add_question["chapter_id"] = str_prepare($_POST["chapter_id"]);
   $add_question["comm_audio_id"] = str_prepare($_POST["audio_id"]);
   $add_question["correct_answer"] = ($_POST["correct_answer"]);
   $add_question["question_title"] = ($_POST["question_title"]);
   $add_question["option1"] = str_prepare($_POST["material_text_option1"]);
   $add_question["option2"] = str_prepare($_POST["material_text_option2"]);
   $add_question["option3"] = str_prepare($_POST["material_text_option3"]);
   $add_question["option4"] = str_prepare($_POST["material_text_option4"]);
   if(isset($_POST["is_active"]) && $_POST["is_active"])
	{
		$add_question["is_active"] = 1;
	}
	else
	{
		$add_question["is_active"] = 0;
	}
	
   
   $edit_question_update = $conn->Autoexecute("comm_question_bank_master",$add_question, "UPDATE", "question_id= ".$conn->qstr($_POST["question_id"]),true,false,MAGIC_QUOTES);
      
   
if($edit_question_update)
{
	setMsg("Question updated successfully");
    header("location: manage_comm_question.php");
    exit();
}	
else
{
	setMsg("Error! Question could not be updated.");
   header("location: manage_comm_question.php");
    exit();
} 

?>