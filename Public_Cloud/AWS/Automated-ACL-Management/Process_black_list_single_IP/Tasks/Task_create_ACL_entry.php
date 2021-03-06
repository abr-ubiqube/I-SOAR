<?php
require_once '/opt/fmc_repository/Process/Reference/Common/common.php';

function list_args()
{
	create_var_def('default', 'Boolean');
	create_var_def('entries.0.rule_number', 'Integer');
	create_var_def('entries.0.egress', 'Boolean');
	create_var_def('entries.0.protocol', 'String');
	create_var_def('entries.0.port_range_from', 'Composite');
	create_var_def('entries.0.port_range_to', 'Composite');
	create_var_def('entries.0.cidr_block', 'String');
	create_var_def('entries.0.rule_action', 'String');
}


$device_id = substr($context['aws_region'], 3);
$micro_service_vars_array = array();
$micro_service_vars_array['network_acl_id'] = $context['network_acl_id'];
$micro_service_vars_array['default'] = $context['default'];
$micro_service_vars_array['entries'] = $context['entries'];

$network_acl_entry = array('network_acl_entry' => array('0' => $micro_service_vars_array));

$response = execute_command_and_verify_response($device_id, CMD_CREATE, $network_acl_entry, "CREATE network_acl_entry");
$response = json_decode($response, true);
if ($response['wo_status'] !== ENDED) {
	$response = prepare_json_response($response['wo_status'], $response['wo_comment'], $context, true);
	echo $response;
	exit;
}

$response = prepare_json_response(ENDED, "network_acl_entry created successfully on the Device $device_id.", $context, true);
echo $response;
?>
