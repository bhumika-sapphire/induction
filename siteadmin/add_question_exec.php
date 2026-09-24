<?php
require_once("../includes/startup.php");
require_once('authenticate.php');
$err = false;
$add_question = array();

   $add_question["topic_id"] = str_prepare($_POST["topic_id"]);
   $add_question["chapter_id"] = str_prepare($_POST["chapter_id"]);
   $add_question["question_text"] = str_prepare($_POST["question_text"]);
   $add_question["correct_answer"] = ($_POST["correct_answer"]);
   $add_question["option1"] = str_prepare($_POST["option1"]);
   $add_question["option2"] = str_prepare($_POST["option2"]);
   $add_question["option3"] = str_prepare($_POST["option3"]);
   $add_question["option4"] = str_prepare($_POST["option4"]);
   if(isset($_POST["is_active"]) && $_POST["is_active"])
	{
		$add_question["is_active"] = 1;
	}
	else
	{
		$add_question["is_active"] = 0;
	}
   
   $add_question_insert = $conn->Autoexecute("question_bank_master",$add_question, "INSERT", true, false, MAGIC_QUOTES);
      
   
if($add_question_insert)
{
	setMsg("Question added successfully");
    header("location: manage_question.php");
    exit();
}	
else
{
	setMsg("Error! Question could not be added.");
   header("location: manage_question.php");
    exit();
} 

?>