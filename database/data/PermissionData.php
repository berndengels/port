<?php
namespace Database\Data;

class PermissionData
{
    /**
    * @var array $data
    */
    public static $data =  [
		[ 'id' => '1', 'name' => 'write Caravan', 'guard_name' => 'admin', 'created_at' => '2021-09-29 22:22:59', 'updated_at' => '2021-09-30 12:51:44'],
		[ 'id' => '2', 'name' => 'read Caravan', 'guard_name' => 'admin', 'created_at' => '2021-09-29 22:26:25', 'updated_at' => '2021-09-30 12:51:57'],
		[ 'id' => '3', 'name' => 'read CaravanDates', 'guard_name' => 'admin', 'created_at' => '2021-09-30 12:55:49', 'updated_at' => '2021-09-30 12:55:49'],
		[ 'id' => '4', 'name' => 'write CaravanDates', 'guard_name' => 'admin', 'created_at' => '2021-09-30 12:56:05', 'updated_at' => '2021-09-30 12:56:05'],
		[ 'id' => '5', 'name' => 'read Page', 'guard_name' => 'admin', 'created_at' => '2021-09-30 12:57:05', 'updated_at' => '2021-09-30 12:57:05'],
		[ 'id' => '6', 'name' => 'write Page', 'guard_name' => 'admin', 'created_at' => '2021-09-30 12:57:12', 'updated_at' => '2021-09-30 12:57:12'],
		[ 'id' => '7', 'name' => 'read User', 'guard_name' => 'admin', 'created_at' => '2021-09-30 13:00:12', 'updated_at' => '2021-09-30 13:00:12'],
		[ 'id' => '8', 'name' => 'write User', 'guard_name' => 'admin', 'created_at' => '2021-09-30 13:00:23', 'updated_at' => '2021-09-30 13:00:23'],
		[ 'id' => '9', 'name' => 'read Role', 'guard_name' => 'admin', 'created_at' => '2021-09-30 13:00:32', 'updated_at' => '2021-09-30 13:00:32'],
		[ 'id' => '10', 'name' => 'write Role', 'guard_name' => 'admin', 'created_at' => '2021-09-30 13:00:42', 'updated_at' => '2021-09-30 13:00:42'],
		[ 'id' => '11', 'name' => 'read Permission', 'guard_name' => 'admin', 'created_at' => '2021-09-30 13:00:51', 'updated_at' => '2021-09-30 13:00:51'],
		[ 'id' => '12', 'name' => 'write Permission', 'guard_name' => 'admin', 'created_at' => '2021-09-30 13:00:59', 'updated_at' => '2021-09-30 13:00:59'],
		[ 'id' => '13', 'name' => 'read Country', 'guard_name' => 'admin', 'created_at' => '2021-09-30 13:01:12', 'updated_at' => '2021-09-30 13:01:12'],
		[ 'id' => '14', 'name' => 'write Country', 'guard_name' => 'admin', 'created_at' => '2021-09-30 13:01:22', 'updated_at' => '2021-09-30 13:01:22'],
		[ 'id' => '15', 'name' => 'read CaravansMenu', 'guard_name' => 'admin', 'created_at' => '2021-09-30 14:36:07', 'updated_at' => '2021-09-30 14:36:07'],
		[ 'id' => '16', 'name' => 'read PermissionsMenu', 'guard_name' => 'admin', 'created_at' => '2021-09-30 14:36:45', 'updated_at' => '2021-09-30 14:36:45'],
		[ 'id' => '17', 'name' => 'read InfoMenu', 'guard_name' => 'admin', 'created_at' => '2021-09-30 14:37:09', 'updated_at' => '2021-09-30 14:37:09'],
		[ 'id' => '18', 'name' => 'read ContentMenu', 'guard_name' => 'admin', 'created_at' => '2021-10-02 12:41:31', 'updated_at' => '2021-10-02 12:49:13'],
		[ 'id' => '19', 'name' => 'read Widget', 'guard_name' => 'admin', 'created_at' => '2021-10-02 12:42:38', 'updated_at' => '2021-10-02 12:42:38'],
		[ 'id' => '20', 'name' => 'write Widget', 'guard_name' => 'admin', 'created_at' => '2021-10-02 12:42:46', 'updated_at' => '2021-10-02 12:42:46'],
		[ 'id' => '21', 'name' => 'read CustomersMenu', 'guard_name' => 'admin', 'created_at' => '2021-10-03 17:28:20', 'updated_at' => '2021-10-03 17:28:20'],
		[ 'id' => '22', 'name' => 'read BoatsMenu', 'guard_name' => 'admin', 'created_at' => '2021-10-03 17:28:42', 'updated_at' => '2021-10-03 17:28:42'],
		[ 'id' => '23', 'name' => 'read Customer', 'guard_name' => 'admin', 'created_at' => '2021-10-03 17:28:59', 'updated_at' => '2021-10-03 17:28:59'],
		[ 'id' => '24', 'name' => 'write Customer', 'guard_name' => 'admin', 'created_at' => '2021-10-03 17:29:07', 'updated_at' => '2021-10-03 17:29:07'],
		[ 'id' => '25', 'name' => 'read Boat', 'guard_name' => 'admin', 'created_at' => '2021-10-03 17:29:13', 'updated_at' => '2021-10-03 17:29:13'],
		[ 'id' => '26', 'name' => 'write Boat', 'guard_name' => 'admin', 'created_at' => '2021-10-03 17:29:19', 'updated_at' => '2021-10-03 17:29:19'],
		[ 'id' => '27', 'name' => 'read BoatMenu', 'guard_name' => 'customer', 'created_at' => '2021-10-04 18:12:22', 'updated_at' => '2021-10-04 18:13:21'],
		[ 'id' => '28', 'name' => 'read Boat', 'guard_name' => 'customer', 'created_at' => '2021-10-04 18:26:46', 'updated_at' => '2021-10-04 18:26:46'],
		[ 'id' => '29', 'name' => 'read Customer', 'guard_name' => 'customer', 'created_at' => '2021-10-04 18:27:14', 'updated_at' => '2021-10-04 18:27:14'],
		[ 'id' => '30', 'name' => 'read CustomersMenu', 'guard_name' => 'customer', 'created_at' => '2021-10-04 18:27:46', 'updated_at' => '2021-10-04 18:27:46'],
		[ 'id' => '31', 'name' => 'read Routes', 'guard_name' => 'admin', 'created_at' => '2021-10-04 18:50:06', 'updated_at' => '2021-10-04 18:50:06'],
		[ 'id' => '32', 'name' => 'read BoatDates', 'guard_name' => 'admin', 'created_at' => '2021-10-10 22:17:04', 'updated_at' => '2021-10-10 22:17:04'],
		[ 'id' => '33', 'name' => 'write BoatDates', 'guard_name' => 'admin', 'created_at' => '2021-10-10 22:17:11', 'updated_at' => '2021-10-10 22:17:11'],
		[ 'id' => '34', 'name' => 'read BoatGuest', 'guard_name' => 'admin', 'created_at' => '2021-10-10 22:17:20', 'updated_at' => '2021-10-10 22:17:20'],
		[ 'id' => '35', 'name' => 'write BoatGuest', 'guard_name' => 'admin', 'created_at' => '2021-10-10 22:17:28', 'updated_at' => '2021-10-10 22:17:28'],
		[ 'id' => '36', 'name' => 'read BoatGuestDates', 'guard_name' => 'admin', 'created_at' => '2021-10-10 22:17:37', 'updated_at' => '2021-10-10 22:17:37'],
		[ 'id' => '37', 'name' => 'write BoatGuestDates', 'guard_name' => 'admin', 'created_at' => '2021-10-10 22:17:44', 'updated_at' => '2021-10-10 22:17:44'],
		[ 'id' => '38', 'name' => 'confirm Registration', 'guard_name' => 'admin', 'created_at' => '2021-10-20 12:11:54', 'updated_at' => '2021-10-20 12:11:54']
	];
}
