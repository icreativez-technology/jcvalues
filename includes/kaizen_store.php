<?php
session_start();
include('functions.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if ($_SESSION['usuario']) {
		$email = $_SESSION['usuario'];
		$sql = "SELECT * From Basic_Employee Where Email = '$email'";
		$fetch = mysqli_query($con, $sql);
		$userInfo = mysqli_fetch_assoc($fetch);
		$userId = $userInfo['Id_employee'];
		$team_leader_id = $_POST["team_leader_id"];
		$plant_id = $_POST["plant_id"];
		$product_group_id = $_POST["product_group_id"];
		$department_id = $_POST["department_id"];
		$category_id = $_POST["category_id"];
		$focus_area_id = $_POST["focus_area_id"];
		$process_id = $_POST["process_id"];
		$kaizen_type_id = $_POST["kaizen_type_id"];
		$theme_of_kaizen = $_POST["theme_of_kaizen"];
		$before_improvement = $_POST["before_improvement"];
		$after_improvement = $_POST["after_improvement"];
		$expenditure = $_POST["expenditure"];
		$direct_savings = $_POST["direct_savings"];
		$indirect_savings = $_POST["indirect_savings"];
		$total_expenditure = $_POST["total_expenditure"];
		$total_direct_savings = $_POST["total_direct_savings"];
		$total_indirect_savings = $_POST["total_indirect_savings"];
		$final_monetary_gain = $_POST["final_monetary_gain"];
		$team_members = $_POST["team_members"];
		$prefix = "KZN-";
		$kaizenIdSql = "SELECT kaizen.kaizen_id FROM kaizen order by id DESC LIMIT 1";
		$kaizenIdConnect = mysqli_query($con, $kaizenIdSql);
		$kaizenIdInfo = mysqli_fetch_assoc($kaizenIdConnect);
		$kaizenId = (isset($kaizenIdInfo['kaizen_id'])) ? $kaizenIdInfo['kaizen_id'] : null;
		$length = 4;
		if (!$kaizenId) {
			$og_length = $length - 1;
			$last_number = '1';
		} else {
			$code = substr($kaizenId, strlen($prefix));
			$increment_last_number = ((int)$code) + 1;
			$last_number_length = strlen($increment_last_number);
			$og_length = $length - $last_number_length;
			$last_number = $increment_last_number;
		}
		$zeros = "";
		for ($i = 0; $i < $og_length; $i++) {
			$zeros .= "0";
		}
		$kaizen_id = $prefix . $zeros . $last_number;
		$kaizenAddSql = "INSERT INTO kaizen (kaizen_id, team_leader_id, plant_id, product_group_id, department_id, category_id, focus_area_id, process_id, kaizen_type_id, theme_of_kaizen, before_improvement, after_improvement, expenditure, direct_savings, indirect_savings, total_expenditure, total_direct_savings, total_indirect_savings, final_monetary_gain, created_by) VALUES ('$kaizen_id', '$team_leader_id', '$plant_id', '$product_group_id', '$department_id', '$category_id', '$focus_area_id', '$process_id', '$kaizen_type_id', '$theme_of_kaizen', '$before_improvement', '$after_improvement', '$expenditure', '$direct_savings', '$indirect_savings', '$total_expenditure', '$total_direct_savings', '$total_indirect_savings', '$final_monetary_gain', '$userId')";
		$kaizenAddResult = mysqli_query($con, $kaizenAddSql);
		$addedKaizenId = mysqli_insert_id($con);
		foreach ($team_members as $key => $memberId) {
			$addMemberSql = "INSERT INTO kaizen_team_members (kaizen_id, member_id) VALUES ('$addedKaizenId', '$memberId')";
			$addMemberSqlConnect = mysqli_query($con, $addMemberSql);
		}
		echo "<script type='text/javascript'>alert('Success!');</script>";
		header("Location: ../kaizen_view_list.php");
	} else {
		$msg = "¡¡You are not logged in, connect to be able to add correctly!!";
		echo "<script type='text/javascript'>alert('$msg');</script>";
	}
} else {
	echo "<script type='text/javascript'>alert('Try again');</script>";
}
