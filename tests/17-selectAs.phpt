--TEST--
selectAs test
--FILE--
<?php
require_once 'includes/init.php';
PDO_DataObject::debugLevel(1);
PDO_DataObject::config(array(
        'class_location' => __DIR__.'/includes/sample_classes/DataObjects_',
        'database' => 'mysql://user:pass@localhost/gettest'
));
 

echo "\n\n--------\n";
echo "selectAs default\n" ;

$company = PDO_DataObject::factory('Companies');
$company->selectAs();
echo "resulting query: " . $company->toSelectSQL();


echo "\n\n--------\n";
echo "selectAs formated\n" ;

$company = PDO_DataObject::factory('Companies');
$company->selectAs('Events', 'event_id_%s');
echo "resulting query: " . $company->toSelectSQL();



echo "\n\n--------\n";
echo "selectAs formated and renamed\n" ;

$company = PDO_DataObject::factory('Companies');
$company->selectAs('Events', 'event_id_%s', 'join_event_id_id');
echo "resulting query: " . $company->toSelectSQL();


echo "\n\n--------\n";
echo "selectAs listed columns\n" ;

$company = PDO_DataObject::factory('Companies');
$company->selectAs(array('first','second'), 'event_id_%s', 'join_event_id_id');
echo "resulting query: " . $company->toSelectSQL();



echo "\n\n--------\n";
echo "selectAs from object\n" ;

$company = PDO_DataObject::factory('Companies');
$events = PDO_DataObject::factory('Events');

$company->selectAs($events, 'event_id_%s', 'join_event_id_id');
echo "resulting query: " . $company->toSelectSQL();



echo "\n\n--------\n";
echo "selectAs with mix \n" ;

$company = PDO_DataObject::factory('Companies');
$company->selectAs();
$company->selectAs(array('first','second'), 'event_id_%s', 'join_event_id_id');
echo "resulting query: " . $company->toSelectSQL();


echo "\n\n--------\n";
echo "selectAs with mix select\n" ;

$company = PDO_DataObject::factory('Companies');
$company->select('a,b,c');
$company->selectAs();
echo "resulting query: " . $company->toSelectSQL();





?>
--EXPECT--
--------
selectAs default
__construct==["mysql:dbname=gettest;host=localhost","user","pass",[]]
setAttribute==[3,2]
PDO_DataObject   : databaseStructure       : CALL:[]
resulting query: SELECT Companies.id as id
 ,  Companies.code as code
 ,  Companies.name as name
 ,  Companies.remarks as remarks
 ,  Companies.owner_id as owner_id
 ,  Companies.address as address
 ,  Companies.tel as tel
 ,  Companies.fax as fax
 ,  Companies.email as email
 ,  Companies.isOwner as isOwner
 ,  Companies.logo_id as logo_id
 ,  Companies.background_color as background_color
 ,  Companies.comptype as comptype
 ,  Companies.url as url
 ,  Companies.main_office_id as main_office_id
 ,  Companies.created_by as created_by
 ,  Companies.created_dt as created_dt
 ,  Companies.updated_by as updated_by
 ,  Companies.updated_dt as updated_dt
 ,  Companies.passwd as passwd
 ,  Companies.dispatch_port as dispatch_port
 ,  Companies.province as province
 ,  Companies.country as country
 FROM   Companies 


--------
selectAs formated
resulting query: SELECT Events.id as event_id_id
 ,  Events.person_name as event_id_person_name
 ,  Events.event_when as event_id_event_when
 ,  Events.action as event_id_action
 ,  Events.ipaddr as event_id_ipaddr
 ,  Events.on_id as event_id_on_id
 ,  Events.on_table as event_id_on_table
 ,  Events.person_id as event_id_person_id
 ,  Events.person_table as event_id_person_table
 ,  Events.remarks as event_id_remarks
 FROM   Companies 


--------
selectAs formated and renamed
resulting query: SELECT join_event_id_id.id as event_id_id
 ,  join_event_id_id.person_name as event_id_person_name
 ,  join_event_id_id.event_when as event_id_event_when
 ,  join_event_id_id.action as event_id_action
 ,  join_event_id_id.ipaddr as event_id_ipaddr
 ,  join_event_id_id.on_id as event_id_on_id
 ,  join_event_id_id.on_table as event_id_on_table
 ,  join_event_id_id.person_id as event_id_person_id
 ,  join_event_id_id.person_table as event_id_person_table
 ,  join_event_id_id.remarks as event_id_remarks
 FROM   Companies 


--------
selectAs listed columns
resulting query: SELECT join_event_id_id.first as event_id_first
 ,  join_event_id_id.second as event_id_second
 FROM   Companies 


--------
selectAs from object
resulting query: SELECT join_event_id_id.id as event_id_id
 ,  join_event_id_id.person_name as event_id_person_name
 ,  join_event_id_id.event_when as event_id_event_when
 ,  join_event_id_id.action as event_id_action
 ,  join_event_id_id.ipaddr as event_id_ipaddr
 ,  join_event_id_id.on_id as event_id_on_id
 ,  join_event_id_id.on_table as event_id_on_table
 ,  join_event_id_id.person_id as event_id_person_id
 ,  join_event_id_id.person_table as event_id_person_table
 ,  join_event_id_id.remarks as event_id_remarks
 FROM   Companies 


--------
selectAs with mix 
resulting query: SELECT Companies.id as id
 ,  Companies.code as code
 ,  Companies.name as name
 ,  Companies.remarks as remarks
 ,  Companies.owner_id as owner_id
 ,  Companies.address as address
 ,  Companies.tel as tel
 ,  Companies.fax as fax
 ,  Companies.email as email
 ,  Companies.isOwner as isOwner
 ,  Companies.logo_id as logo_id
 ,  Companies.background_color as background_color
 ,  Companies.comptype as comptype
 ,  Companies.url as url
 ,  Companies.main_office_id as main_office_id
 ,  Companies.created_by as created_by
 ,  Companies.created_dt as created_dt
 ,  Companies.updated_by as updated_by
 ,  Companies.updated_dt as updated_dt
 ,  Companies.passwd as passwd
 ,  Companies.dispatch_port as dispatch_port
 ,  Companies.province as province
 ,  Companies.country as country
 ,  join_event_id_id.first as event_id_first
 ,  join_event_id_id.second as event_id_second
 FROM   Companies 


--------
selectAs with mix select
resulting query: SELECT a,b,c ,  Companies.id as id
 ,  Companies.code as code
 ,  Companies.name as name
 ,  Companies.remarks as remarks
 ,  Companies.owner_id as owner_id
 ,  Companies.address as address
 ,  Companies.tel as tel
 ,  Companies.fax as fax
 ,  Companies.email as email
 ,  Companies.isOwner as isOwner
 ,  Companies.logo_id as logo_id
 ,  Companies.background_color as background_color
 ,  Companies.comptype as comptype
 ,  Companies.url as url
 ,  Companies.main_office_id as main_office_id
 ,  Companies.created_by as created_by
 ,  Companies.created_dt as created_dt
 ,  Companies.updated_by as updated_by
 ,  Companies.updated_dt as updated_dt
 ,  Companies.passwd as passwd
 ,  Companies.dispatch_port as dispatch_port
 ,  Companies.province as province
 ,  Companies.country as country
 FROM   Companies

