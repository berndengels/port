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
		[ 'id' => '38', 'name' => 'confirm Registration', 'guard_name' => 'admin', 'created_at' => '2021-10-20 12:11:54', 'updated_at' => '2021-10-20 12:11:54'],
		[ 'id' => '39', 'name' => 'read ProfileMenu', 'guard_name' => 'customer', 'created_at' => '2021-11-09 18:38:30', 'updated_at' => '2021-11-09 18:38:30'],
		[ 'id' => '40', 'name' => 'write Boat', 'guard_name' => 'customer', 'created_at' => '2021-11-09 18:39:39', 'updated_at' => '2021-11-09 18:39:39'],
		[ 'id' => '41', 'name' => 'read BoatDates', 'guard_name' => 'customer', 'created_at' => '2021-11-09 18:40:41', 'updated_at' => '2021-11-09 18:40:41'],
		[ 'id' => '42', 'name' => 'read ServiceMenu', 'guard_name' => 'admin', 'created_at' => '2021-11-10 14:21:29', 'updated_at' => '2021-11-10 15:03:47'],
		[ 'id' => '43', 'name' => 'read ServiceMenu', 'guard_name' => 'customer', 'created_at' => '2021-11-10 14:21:49', 'updated_at' => '2021-11-10 15:04:28'],
		[ 'id' => '44', 'name' => 'read Service', 'guard_name' => 'admin', 'created_at' => '2021-11-10 14:22:09', 'updated_at' => '2021-11-10 14:22:09'],
		[ 'id' => '45', 'name' => 'write Service', 'guard_name' => 'admin', 'created_at' => '2021-11-10 14:22:18', 'updated_at' => '2021-11-10 14:22:18'],
		[ 'id' => '46', 'name' => 'read ServiceCategory', 'guard_name' => 'admin', 'created_at' => '2021-11-10 14:22:28', 'updated_at' => '2021-11-10 14:22:28'],
		[ 'id' => '47', 'name' => 'write ServiceCategory', 'guard_name' => 'admin', 'created_at' => '2021-11-10 14:22:37', 'updated_at' => '2021-11-10 14:22:37'],
		[ 'id' => '48', 'name' => 'read Material', 'guard_name' => 'admin', 'created_at' => '2021-11-10 14:22:45', 'updated_at' => '2021-11-10 14:22:45'],
		[ 'id' => '49', 'name' => 'write Material', 'guard_name' => 'admin', 'created_at' => '2021-11-10 14:22:54', 'updated_at' => '2021-11-10 14:22:54'],
		[ 'id' => '50', 'name' => 'read MaterialCategory', 'guard_name' => 'admin', 'created_at' => '2021-11-10 14:23:03', 'updated_at' => '2021-11-10 14:23:03'],
		[ 'id' => '51', 'name' => 'write MaterialCategory', 'guard_name' => 'admin', 'created_at' => '2021-11-10 14:23:13', 'updated_at' => '2021-11-10 14:23:13'],
		[ 'id' => '52', 'name' => 'read Service', 'guard_name' => 'customer', 'created_at' => '2021-11-10 14:23:38', 'updated_at' => '2021-11-10 14:23:38'],
		[ 'id' => '53', 'name' => 'read ServiceRequest', 'guard_name' => 'admin', 'created_at' => '2021-11-10 14:32:06', 'updated_at' => '2021-11-10 14:32:06'],
		[ 'id' => '54', 'name' => 'write ServiceRequest', 'guard_name' => 'admin', 'created_at' => '2021-11-10 14:32:18', 'updated_at' => '2021-11-10 14:32:18'],
		[ 'id' => '55', 'name' => 'read ServiceRequest', 'guard_name' => 'customer', 'created_at' => '2021-11-10 14:32:37', 'updated_at' => '2021-11-10 14:32:37'],
		[ 'id' => '56', 'name' => 'write ServiceRequest', 'guard_name' => 'customer', 'created_at' => '2021-11-10 14:32:51', 'updated_at' => '2021-11-10 14:32:51'],
		[ 'id' => '59', 'name' => 'read ConfigSaisonDates', 'guard_name' => 'admin', 'created_at' => '2021-11-27 23:40:03', 'updated_at' => '2021-11-30 01:08:05'],
		[ 'id' => '60', 'name' => 'write ConfigSaisonDates', 'guard_name' => 'admin', 'created_at' => '2021-11-27 23:40:24', 'updated_at' => '2021-11-30 01:08:31'],
		[ 'id' => '61', 'name' => 'read SettingsMenu', 'guard_name' => 'admin', 'created_at' => '2021-11-27 23:41:51', 'updated_at' => '2021-11-27 23:41:51'],
		[ 'id' => '62', 'name' => 'read ConfigBoatPrice', 'guard_name' => 'admin', 'created_at' => '2021-11-30 21:04:53', 'updated_at' => '2021-11-30 21:04:53'],
		[ 'id' => '63', 'name' => 'write ConfigBoatPrice', 'guard_name' => 'admin', 'created_at' => '2021-11-30 21:05:07', 'updated_at' => '2021-11-30 21:05:07'],
		[ 'id' => '64', 'name' => 'read ConfigDailyPrice', 'guard_name' => 'admin', 'created_at' => '2021-11-30 21:05:37', 'updated_at' => '2021-11-30 21:05:37'],
		[ 'id' => '65', 'name' => 'write ConfigDailyPrice', 'guard_name' => 'admin', 'created_at' => '2021-11-30 21:05:48', 'updated_at' => '2021-11-30 21:05:48'],
		[ 'id' => '66', 'name' => 'read ConfigEntity', 'guard_name' => 'admin', 'created_at' => '2021-11-30 21:06:02', 'updated_at' => '2021-11-30 21:06:02'],
		[ 'id' => '67', 'name' => 'write ConfigEntity', 'guard_name' => 'admin', 'created_at' => '2021-11-30 21:06:13', 'updated_at' => '2021-11-30 21:06:13'],
		[ 'id' => '68', 'name' => 'read ConfigPriceComponent', 'guard_name' => 'admin', 'created_at' => '2021-11-30 21:06:29', 'updated_at' => '2021-11-30 21:06:29'],
		[ 'id' => '69', 'name' => 'write ConfigPriceComponent', 'guard_name' => 'admin', 'created_at' => '2021-11-30 21:06:50', 'updated_at' => '2021-11-30 21:06:50'],
		[ 'id' => '70', 'name' => 'read ConfigPriceType', 'guard_name' => 'admin', 'created_at' => '2021-11-30 21:07:28', 'updated_at' => '2021-11-30 21:07:28'],
		[ 'id' => '71', 'name' => 'write ConfigPriceType', 'guard_name' => 'admin', 'created_at' => '2021-11-30 21:07:39', 'updated_at' => '2021-11-30 21:07:39'],
		[ 'id' => '72', 'name' => 'read ConfigService', 'guard_name' => 'admin', 'created_at' => '2021-11-30 21:07:53', 'updated_at' => '2021-11-30 21:07:53'],
		[ 'id' => '73', 'name' => 'write ConfigService', 'guard_name' => 'admin', 'created_at' => '2021-11-30 21:08:04', 'updated_at' => '2021-11-30 21:08:04'],
		[ 'id' => '74', 'name' => 'read Offer', 'guard_name' => 'admin', 'created_at' => '2022-03-13 11:02:57', 'updated_at' => '2022-03-13 11:02:57'],
		[ 'id' => '75', 'name' => 'write Offer', 'guard_name' => 'admin', 'created_at' => '2022-03-13 11:03:23', 'updated_at' => '2022-03-13 11:03:23'],
		[ 'id' => '76', 'name' => 'read Houseboat', 'guard_name' => 'admin', 'created_at' => '2022-03-13 16:25:45', 'updated_at' => '2022-03-13 16:25:45'],
		[ 'id' => '77', 'name' => 'write Houseboat', 'guard_name' => 'admin', 'created_at' => '2022-03-13 16:25:59', 'updated_at' => '2022-03-13 16:25:59'],
		[ 'id' => '78', 'name' => 'read HouseboatDates', 'guard_name' => 'admin', 'created_at' => '2022-03-13 16:27:07', 'updated_at' => '2022-03-13 16:27:07'],
		[ 'id' => '79', 'name' => 'write HouseboatDates', 'guard_name' => 'admin', 'created_at' => '2022-03-13 16:27:22', 'updated_at' => '2022-03-13 16:27:22'],
		[ 'id' => '80', 'name' => 'read HouseboatModel', 'guard_name' => 'admin', 'created_at' => '2022-03-13 16:27:38', 'updated_at' => '2022-03-13 16:27:38'],
		[ 'id' => '81', 'name' => 'write HouseboatModel', 'guard_name' => 'admin', 'created_at' => '2022-03-13 16:27:56', 'updated_at' => '2022-03-13 16:27:56'],
		[ 'id' => '82', 'name' => 'read HouseboatsMenu', 'guard_name' => 'admin', 'created_at' => '2022-03-13 16:34:04', 'updated_at' => '2022-03-13 17:50:35'],
		[ 'id' => '83', 'name' => 'read ConfigSaisonRent', 'guard_name' => 'admin', 'created_at' => '2022-04-03 13:21:21', 'updated_at' => '2022-04-03 13:21:21'],
		[ 'id' => '84', 'name' => 'write ConfigSaisonRent', 'guard_name' => 'admin', 'created_at' => '2022-04-03 13:21:39', 'updated_at' => '2022-04-03 13:21:39'],
		[ 'id' => '85', 'name' => 'read ConfigSaisonRentDates', 'guard_name' => 'admin', 'created_at' => '2022-04-03 13:21:49', 'updated_at' => '2022-04-03 13:21:49'],
		[ 'id' => '86', 'name' => 'write ConfigSaisonRentDates', 'guard_name' => 'admin', 'created_at' => '2022-04-03 13:22:00', 'updated_at' => '2022-04-03 13:22:00'],
		[ 'id' => '89', 'name' => 'read Berth', 'guard_name' => 'admin', 'created_at' => '2022-06-25 13:56:35', 'updated_at' => '2022-06-25 13:56:35'],
		[ 'id' => '90', 'name' => 'write Berth', 'guard_name' => 'admin', 'created_at' => '2022-06-25 13:56:47', 'updated_at' => '2022-06-25 13:56:47'],
		[ 'id' => '91', 'name' => 'read HouseboatOwner', 'guard_name' => 'admin', 'created_at' => '2022-06-25 13:56:58', 'updated_at' => '2022-06-25 13:56:58'],
		[ 'id' => '92', 'name' => 'write HouseboatOwner', 'guard_name' => 'admin', 'created_at' => '2022-06-25 13:57:14', 'updated_at' => '2022-06-25 13:57:14'],
		[ 'id' => '93', 'name' => 'read Dock', 'guard_name' => 'admin', 'created_at' => '2022-07-01 11:52:04', 'updated_at' => '2023-01-03 20:11:49'],
		[ 'id' => '95', 'name' => 'write Dock', 'guard_name' => 'admin', 'created_at' => '2022-07-01 12:15:29', 'updated_at' => '2023-01-03 20:12:06'],
		[ 'id' => '96', 'name' => 'read ConfigSettings', 'guard_name' => 'admin', 'created_at' => '2022-07-12 18:43:51', 'updated_at' => '2022-07-12 18:43:51'],
		[ 'id' => '97', 'name' => 'write ConfigSettings', 'guard_name' => 'admin', 'created_at' => '2022-07-12 18:43:59', 'updated_at' => '2022-07-12 18:43:59'],
		[ 'id' => '98', 'name' => 'read ConfigHoliday', 'guard_name' => 'admin', 'created_at' => '2022-11-26 01:53:38', 'updated_at' => '2022-11-26 01:53:38'],
		[ 'id' => '99', 'name' => 'write ConfigHoliday', 'guard_name' => 'admin', 'created_at' => '2022-11-26 01:54:35', 'updated_at' => '2022-11-26 01:54:35'],
		[ 'id' => '100', 'name' => 'read Rentable', 'guard_name' => 'admin', 'created_at' => '2022-12-29 17:54:35', 'updated_at' => '2022-12-29 17:54:35'],
		[ 'id' => '101', 'name' => 'write Rentable', 'guard_name' => 'admin', 'created_at' => '2022-12-29 17:54:47', 'updated_at' => '2022-12-29 17:54:47'],
		[ 'id' => '102', 'name' => 'read Apartment', 'guard_name' => 'admin', 'created_at' => '2022-12-29 17:55:29', 'updated_at' => '2022-12-29 17:55:29'],
		[ 'id' => '103', 'name' => 'write Apartment', 'guard_name' => 'admin', 'created_at' => '2022-12-29 17:55:37', 'updated_at' => '2022-12-29 17:55:37'],
		[ 'id' => '104', 'name' => 'read ApartmentModel', 'guard_name' => 'admin', 'created_at' => '2022-12-29 17:55:43', 'updated_at' => '2022-12-29 17:55:43'],
		[ 'id' => '105', 'name' => 'write ApartmentModel', 'guard_name' => 'admin', 'created_at' => '2022-12-29 17:55:51', 'updated_at' => '2022-12-29 17:55:51'],
		[ 'id' => '106', 'name' => 'read House', 'guard_name' => 'admin', 'created_at' => '2022-12-29 17:56:03', 'updated_at' => '2022-12-29 17:56:03'],
		[ 'id' => '107', 'name' => 'write House', 'guard_name' => 'admin', 'created_at' => '2022-12-29 17:56:14', 'updated_at' => '2022-12-29 17:56:14'],
		[ 'id' => '108', 'name' => 'read HouseModel', 'guard_name' => 'admin', 'created_at' => '2022-12-29 17:56:25', 'updated_at' => '2022-12-29 17:56:25'],
		[ 'id' => '109', 'name' => 'write HouseModel', 'guard_name' => 'admin', 'created_at' => '2022-12-29 17:56:56', 'updated_at' => '2022-12-29 17:56:56'],
		[ 'id' => '110', 'name' => 'read RentalsMenu', 'guard_name' => 'admin', 'created_at' => '2022-12-30 17:40:09', 'updated_at' => '2022-12-30 17:43:56'],
		[ 'id' => '111', 'name' => 'write Customer', 'guard_name' => 'customer', 'created_at' => '2023-01-07 01:24:27', 'updated_at' => '2023-01-07 01:24:27'],
		[ 'id' => '112', 'name' => 'read Rentable', 'guard_name' => 'customer', 'created_at' => '2023-01-07 01:41:40', 'updated_at' => '2023-01-07 01:41:40'],
		[ 'id' => '113', 'name' => 'write Rentable', 'guard_name' => 'customer', 'created_at' => '2023-01-07 01:41:56', 'updated_at' => '2023-01-07 01:41:56'],
		[ 'id' => '114', 'name' => 'read AccessLog', 'guard_name' => 'admin', 'created_at' => '2023-02-01 18:42:17', 'updated_at' => '2023-02-01 18:42:17']
	];
}
