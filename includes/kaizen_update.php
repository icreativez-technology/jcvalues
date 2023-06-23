<?php
session_start();
include('functions.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if ($_SESSION['usuario']) {
		$kaizenId = $_POST["kaizenId"];
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
		$kaizenUpdateSql = "UPDATE kaizen SET team_leader_id = '$team_leader_id', plant_id = '$plant_id', product_group_id = '$product_group_id', department_id = '$department_id', category_id = '$category_id', focus_area_id = '$focus_area_id', process_id = '$process_id', kaizen_type_id = '$kaizen_type_id', theme_of_kaizen = '$theme_of_kaizen', before_improvement = '$before_improvement', after_improvement = '$after_improvement', expenditure = '$expenditure',  direct_savings = '$direct_savings',  indirect_savings = '$indirect_savings', total_expenditure = '$total_expenditure', total_direct_savings = '$total_direct_savings', total_indirect_savings = '$total_indirect_savings', final_monetary_gain = '$final_monetary_gain' WHERE id = '$kaizenId'";
		$kaizenUpdateResult = mysqli_query($con, $kaizenUpdateSql);
		$deleteTeamMembersSql = "UPDATE kaizen_team_members SET is_deleted = 1 WHERE kaizen_id = '$kaizenId'";
		$deleteTeamMembersSqlResult = mysqli_query($con, $deleteTeamMembersSql);
		foreach ($team_members as $key => $memberId) {
			$isExists = "SELECT id FROM kaizen_team_members WHERE kaizen_id = '$kaizenId' AND member_id = '$memberId'";
			$result = mysqli_query($con, $isExists);
			if ($result->num_rows == 0) {
				$addMemberSql = "INSERT INTO kaizen_team_members (kaizen_id, member_id) VALUES ('$kaizenId', '$memberId')";
				$addMemberSqlResult = mysqli_query($con, $addMemberSql);
			} else {
				$updateMemberSql = "UPDATE kaizen_team_members SET is_deleted = 0 WHERE kaizen_id = '$kaizenId' AND member_id = '$memberId'";
				$updateMemberSqlResult = mysqli_query($con, $updateMemberSql);
			}
		}
		echo "<script type='text/javascript'>alert('Success!');</script>";
		header("Location: ../kaizen_detail_edit.php?id=$kaizenId");
	} else {
		$msg = "¡¡You are not logged in, connect to be able to add correctly!!";
		echo "<script type='text/javascript'>alert('$msg');</script>";
	}
} else {
	echo "<script type='text/javascript'>alert('Try again');</script>";
}
