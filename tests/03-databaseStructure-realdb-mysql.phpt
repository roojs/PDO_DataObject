--TEST--
databaseStructure - mysql - real databases - (not really needed to pass..)
--FILE--
<?php
require_once 'includes/init.php';
 $base_config = PDO_DataObject::config();

 

// -- normally disabled - used to geenrate the test data...
 
echo "\n\nREAL DATABASE CONNECT - NOT IN FINAL TEST\n";

(new PDO_DataObject())->reset();



PDO_DataObject::config(
    array(
        'schema_location' => false,
        'PDO' => 'PDO',
        'databases' => array(
            'hebe' => 'mysql://root:@localhost/hebe'
        ),
        'proxy' => true,
        'debug' => 0,
        
    )
);

$obj = new PDO_DataObject('hebe/account_transaction');
$obj->PDO();
print_r($obj->databaseStructure('hebe'));
 

?>
--EXPECT--
REAL DATABASE CONNECT - NOT IN FINAL TEST
Array
(
    [Companies] => Array
        (
            [id] => 129
            [code] => 130
            [name] => 130
            [remarks] => 162
            [owner_id] => 129
            [address] => 162
            [tel] => 130
            [fax] => 130
            [email] => 130
            [isOwner] => 129
            [logo_id] => 129
            [background_color] => 130
            [comptype] => 130
            [url] => 130
            [main_office_id] => 129
            [created_by] => 129
            [created_dt] => 142
            [updated_by] => 129
            [updated_dt] => 142
            [passwd] => 130
            [dispatch_port] => 130
            [province] => 130
            [country] => 130
            [crm_industry_id] => 129
            [comptype_id] => 129
            [address1] => 162
            [address2] => 162
            [address3] => 162
            [is_system] => 129
        )

    [Companies__keys] => Array
        (
            [id] => N
        )

    [Events] => Array
        (
            [id] => 129
            [person_name] => 130
            [event_when] => 142
            [action] => 130
            [ipaddr] => 130
            [on_id] => 129
            [on_table] => 130
            [person_id] => 129
            [person_table] => 130
            [remarks] => 162
            [dupe_id] => 129
        )

    [Events__keys] => Array
        (
            [id] => N
        )

    [Groups] => Array
        (
            [id] => 129
            [name] => 130
            [type] => 129
            [leader] => 129
        )

    [Groups__keys] => Array
        (
            [id] => N
        )

    [Hebe_bill_message] => Array
        (
            [id] => 129
            [billm] => 134
            [member_id] => 129
            [billmsg] => 162
            [dayofmonth] => 129
            [is_approved] => 129
            [approved_date] => 134
        )

    [Hebe_bill_message__keys] => Array
        (
            [id] => N
        )

    [Images] => Array
        (
            [id] => 129
            [filename] => 130
            [ontable] => 130
            [onid] => 129
            [mimetype] => 130
            [width] => 129
            [height] => 129
            [filesize] => 129
            [displayorder] => 129
            [language] => 130
            [parent_image_id] => 129
            [created] => 142
            [imgtype] => 130
            [linkurl] => 130
            [descript] => 162
            [title] => 130
            [no_of_pages] => 129
            [is_deleted] => 129
        )

    [Images__keys] => Array
        (
            [id] => N
        )

    [Office] => Array
        (
            [id] => 129
            [company_id] => 129
            [name] => 130
            [address] => 162
            [phone] => 130
            [fax] => 130
            [email] => 130
            [role] => 130
            [address2] => 162
            [address3] => 162
            [country] => 130
            [display_name] => 130
        )

    [Office__keys] => Array
        (
            [id] => N
        )

    [Person] => Array
        (
            [id] => 129
            [office_id] => 129
            [name] => 130
            [phone] => 130
            [fax] => 130
            [email] => 130
            [company_id] => 129
            [role] => 130
            [active] => 129
            [remarks] => 162
            [passwd] => 130
            [owner_id] => 129
            [lang] => 130
            [no_reset_sent] => 129
            [action_type] => 130
            [project_id] => 129
            [deleted_by] => 129
            [deleted_dt] => 142
            [firstname] => 130
            [lastname] => 130
            [honor] => 130
            [firstname_alt] => 130
            [lastname_alt] => 130
            [chosen_title] => 162
            [country] => 130
            [birth_date] => 134
            [phone_mobile] => 130
            [phone_direct] => 130
            [alt_email] => 130
            [name_facebook] => 130
            [url_blog] => 130
            [url_twitter] => 130
            [linkedin_id] => 130
            [url_linkedin] => 130
            [url_google_plus] => 162
            [url_blog2] => 162
            [url_blog3] => 162
            [countries] => 130
            [point_score] => 129
            [authorize_md5] => 130
            [post_code] => 130
            [oath_key] => 130
        )

    [Person__keys] => Array
        (
            [id] => N
        )

    [ProjectDirectory] => Array
        (
            [id] => 129
            [project_id] => 129
            [person_id] => 129
            [ispm] => 129
            [role] => 130
            [company_id] => 129
            [office_id] => 129
        )

    [ProjectDirectory__keys] => Array
        (
            [id] => N
        )

    [Projects] => Array
        (
            [id] => 129
            [name] => 130
            [remarks] => 162
            [owner_id] => 129
            [code] => 130
            [active] => 129
            [type] => 130
            [client_id] => 129
            [team_id] => 129
            [file_location] => 130
            [open_date] => 134
            [open_by] => 129
            [updated_dt] => 142
            [countries] => 130
            [languages] => 130
            [agency_id] => 129
        )

    [Projects__keys] => Array
        (
            [id] => N
        )

    [account_code] => Array
        (
            [id] => 129
            [name] => 130
            [description] => 130
            [cost_center] => 129
            [accpac] => 130
            [accpac_out] => 130
            [is_active] => 129
        )

    [account_code__keys] => Array
        (
            [id] => N
        )

    [account_month] => Array
        (
            [id] => 129
            [member] => 129
            [month] => 134
            [value] => 129
        )

    [account_month__keys] => Array
        (
            [id] => N
        )

    [account_transaction] => Array
        (
            [id] => 129
            [member] => 129
            [at_date] => 134
            [voucher_number] => 130
            [chit_number] => 130
            [cheque_number] => 130
            [reverse_id] => 129
            [account_code] => 129
            [value] => 129
            [description_old] => 130
            [sequence_no] => 129
            [ts] => 384
            [description] => 130
            [at_time] => 138
            [boat_id] => 129
            [event_id] => 129
        )

    [account_transaction__keys] => Array
        (
            [id] => N
        )

    [autopay_records] => Array
        (
            [id] => 129
            [member] => 129
            [amount] => 129
            [rejected] => 129
            [month_start] => 134
            [amount_due] => 129
        )

    [autopay_records__keys] => Array
        (
            [id] => N
        )

    [autopay_status] => Array
        (
            [id] => 129
            [month_start] => 134
            [status] => 129
            [failures] => 129
        )

    [autopay_status__keys] => Array
        (
            [id] => N
        )

    [boat_owners] => Array
        (
            [id] => 129
            [boat_id] => 129
            [boat_owner_id] => 129
        )

    [boat_owners__keys] => Array
        (
            [id] => N
        )

    [boats] => Array
        (
            [id] => 129
            [name] => 130
            [length] => 129
            [draught] => 129
            [breath] => 129
            [weight] => 130
            [boat_type] => 130
            [sailboat_number] => 130
            [colour] => 130
            [insurer] => 130
            [insurance_expire] => 134
            [licence_expire] => 134
            [remarks] => 130
            [registration_id] => 130
            [owner] => 129
            [has_pa] => 129
            [has_contract] => 129
        )

    [boats__keys] => Array
        (
            [id] => N
        )

    [carpark] => Array
        (
            [id] => 129
            [member_id] => 129
            [arrive] => 142
            [depart] => 142
            [departed] => 129
            [cardid] => 130
            [imported] => 129
            [inid] => 129
            [outid] => 129
            [cost] => 129
            [discount_minutes] => 129
            [discount_amount] => 129
            [evening_discount] => 129
            [dependant_id] => 129
            [transaction_id] => 129
            [discount_transaction_id] => 129
            [updated_dt] => 142
        )

    [carpark__keys] => Array
        (
            [id] => N
        )

    [carpark_archive] => Array
        (
            [id] => 129
            [member_id] => 129
            [arrive] => 142
            [depart] => 142
            [departed] => 129
            [cardid] => 130
            [imported] => 129
            [inid] => 129
            [outid] => 129
            [cost] => 129
            [discount_minutes] => 129
            [discount_amount] => 129
            [evening_discount] => 129
            [dependant_id] => 129
            [transaction_id] => 129
            [discount_transaction_id] => 129
            [updated_dt] => 142
        )

    [carpark_archive__keys] => Array
        (
            [id] => N
        )

    [carparklog] => Array
        (
            [transdate] => 142
            [doorid] => 129
            [userid] => 129
            [accesstype] => 129
            [cardid] => 130
            [accesslog] => 130
            [processed] => 129
            [id] => 129
        )

    [carparklog__keys] => Array
        (
            [id] => N
        )

    [committee] => Array
        (
            [id] => 129
            [name] => 130
            [short_code] => 130
        )

    [committee__keys] => Array
        (
            [id] => N
        )

    [committee_members] => Array
        (
            [id] => 129
            [committee_active] => 129
            [member] => 129
            [post] => 129
        )

    [committee_members__keys] => Array
        (
            [id] => N
        )

    [committee_post] => Array
        (
            [id] => 129
            [name] => 130
        )

    [committee_post__keys] => Array
        (
            [id] => N
        )

    [committees_active] => Array
        (
            [id] => 129
            [start_date] => 134
            [committee] => 129
        )

    [committees_active__keys] => Array
        (
            [id] => N
        )

    [core_company] => Array
        (
            [id] => 129
            [code] => 130
            [name] => 130
            [remarks] => 162
            [owner_id] => 129
            [address] => 162
            [tel] => 130
            [fax] => 130
            [email] => 130
            [logo_id] => 129
            [background_color] => 130
            [url] => 130
            [main_office_id] => 129
            [created_by] => 129
            [created_dt] => 142
            [updated_by] => 129
            [updated_dt] => 142
            [passwd] => 130
            [dispatch_port] => 130
            [province] => 130
            [country] => 130
            [comptype] => 130
            [comptype_id] => 129
            [address1] => 162
            [address2] => 162
            [address3] => 162
            [is_system] => 129
            [crm_industry_id] => 129
            [deleted_by] => 129
            [deleted_dt] => 142
        )

    [core_company__keys] => Array
        (
            [id] => N
        )

    [core_curr_rate] => Array
        (
            [id] => 129
            [curr] => 130
            [rate] => 129
            [from_dt] => 142
            [to_dt] => 142
        )

    [core_curr_rate__keys] => Array
        (
            [id] => N
        )

    [core_domain] => Array
        (
            [id] => 129
            [domain] => 130
        )

    [core_domain__keys] => Array
        (
            [id] => N
        )

    [core_email] => Array
        (
            [id] => 129
            [subject] => 162
            [bodytext] => 162
            [plaintext] => 162
            [name] => 130
            [updated_dt] => 142
            [from_email] => 130
            [from_name] => 130
            [owner_id] => 129
            [is_system] => 129
            [active] => 129
            [bcc_group_id] => 129
            [test_class] => 130
            [to_group_id] => 129
            [use_file] => 130
            [description] => 130
        )

    [core_email__keys] => Array
        (
            [id] => N
        )

    [core_enum] => Array
        (
            [id] => 129
            [etype] => 130
            [name] => 130
            [active] => 129
            [seqid] => 129
            [seqmax] => 129
            [display_name] => 162
            [is_system_enum] => 129
        )

    [core_enum__keys] => Array
        (
            [id] => N
        )

    [core_event_audit] => Array
        (
            [id] => 129
            [event_id] => 129
            [name] => 130
            [old_audit_id] => 129
            [newvalue] => 194
        )

    [core_event_audit__keys] => Array
        (
            [id] => N
        )

    [core_event_audit_archive] => Array
        (
            [id] => 129
            [event_id] => 129
            [name] => 130
            [old_audit_id] => 129
            [newvalue] => 194
        )

    [core_event_audit_archive__keys] => Array
        (
            [id] => N
        )

    [core_events_archive] => Array
        (
            [id] => 129
            [person_name] => 130
            [event_when] => 142
            [action] => 130
            [ipaddr] => 130
            [on_id] => 129
            [on_table] => 130
            [person_id] => 129
            [remarks] => 162
            [person_table] => 130
            [dupe_id] => 129
        )

    [core_events_archive__keys] => Array
        (
            [id] => N
        )

    [core_group] => Array
        (
            [id] => 129
            [name] => 130
            [type] => 129
            [leader] => 129
            [is_system] => 129
            [display_name] => 130
        )

    [core_group__keys] => Array
        (
            [id] => N
        )

    [core_group_member] => Array
        (
            [id] => 129
            [group_id] => 129
            [user_id] => 129
        )

    [core_group_member__keys] => Array
        (
            [id] => N
        )

    [core_group_right] => Array
        (
            [id] => 129
            [rightname] => 130
            [group_id] => 129
            [accessmask] => 130
        )

    [core_group_right__keys] => Array
        (
            [id] => N
        )

    [core_holiday] => Array
        (
            [id] => 129
            [holiday_date] => 134
            [country] => 130
        )

    [core_holiday__keys] => Array
        (
            [id] => N
        )

    [core_ip_access] => Array
        (
            [id] => 129
            [ip] => 130
            [created_dt] => 142
            [status] => 129
            [authorized_by] => 129
            [authorized_key] => 130
            [email] => 130
            [expire_dt] => 134
            [user_agent] => 130
            [updated_by] => 129
        )

    [core_ip_access__keys] => Array
        (
            [id] => N
        )

    [core_locking] => Array
        (
            [id] => 129
            [on_table] => 130
            [on_id] => 129
            [person_id] => 129
            [created] => 142
        )

    [core_locking__keys] => Array
        (
            [id] => N
        )

    [core_notify] => Array
        (
            [id] => 129
            [evtype] => 130
            [recur_id] => 129
            [act_when] => 142
            [act_start] => 142
            [onid] => 129
            [ontable] => 130
            [person_id] => 129
            [msgid] => 130
            [sent] => 142
            [event_id] => 129
            [watch_id] => 129
            [trigger_person_id] => 129
            [trigger_event_id] => 129
            [to_email] => 130
            [person_table] => 130
            [domain_id] => 129
            [is_open] => 129
            [crm_person_id] => 129
            [members_id] => 129
        )

    [core_notify__keys] => Array
        (
            [id] => N
        )

    [core_notify_recur] => Array
        (
            [id] => 129
            [person_id] => 129
            [dtstart] => 142
            [dtend] => 142
            [max_applied_dt] => 142
            [updated_dt] => 142
            [last_applied_dt] => 142
            [tz] => 130
            [freq] => 130
            [freq_day] => 162
            [freq_hour] => 162
            [onid] => 129
            [ontable] => 130
            [last_event_id] => 129
            [method] => 130
            [method_id] => 129
        )

    [core_notify_recur__keys] => Array
        (
            [id] => N
        )

    [core_office] => Array
        (
            [id] => 129
            [company_id] => 129
            [name] => 130
            [address] => 162
            [address2] => 162
            [address3] => 162
            [phone] => 130
            [fax] => 130
            [email] => 130
            [role] => 130
            [country] => 130
            [display_name] => 130
        )

    [core_office__keys] => Array
        (
            [id] => N
        )

    [core_person] => Array
        (
            [id] => 129
            [name] => 130
            [honor] => 130
            [firstname] => 130
            [lastname] => 130
            [firstname_alt] => 130
            [lastname_alt] => 130
            [chosen_title] => 162
            [role] => 130
            [remarks] => 162
            [lang] => 130
            [country] => 130
            [birth_date] => 134
            [email] => 130
            [phone] => 130
            [phone_mobile] => 130
            [phone_direct] => 130
            [fax] => 130
            [alt_email] => 130
            [office_id] => 129
            [company_id] => 129
            [owner_id] => 129
            [active] => 129
            [project_id] => 129
            [passwd] => 130
            [no_reset_sent] => 129
            [deleted_by] => 129
            [deleted_dt] => 142
            [name_facebook] => 130
            [url_blog] => 130
            [url_twitter] => 130
            [linkedin_id] => 130
            [url_linkedin] => 130
            [url_google_plus] => 162
            [url_blog2] => 162
            [url_blog3] => 162
            [countries] => 130
            [action_type] => 130
            [point_score] => 129
            [authorize_md5] => 130
            [post_code] => 130
            [crm_lead_percentage] => 129
            [crm_updated_action_id] => 129
            [crm_created_action_id] => 129
            [crm_type_id] => 129
            [crm_location_covered_id] => 129
            [crm_current_relationship_id] => 129
            [crm_is_unsubscribed] => 129
            [crm_is_private] => 129
            [crm_role_function_id] => 129
            [crm_is_primary_contact] => 129
            [crm_contact_again_notify_id] => 129
            [crm_is_decision_maker] => 129
            [crm_source_id] => 129
            [crm_smtp_reject_id] => 129
            [crm_smtp_server_id] => 129
            [crm_country_id] => 129
            [crm_city_id] => 129
            [crm_division_id] => 129
            [crm_country] => 162
            [crm_city] => 162
            [crm_division] => 162
            [updated_dt] => 134
            [oath_key] => 130
        )

    [core_person__keys] => Array
        (
            [id] => N
        )

    [core_person_alias] => Array
        (
            [id] => 129
            [person_id] => 130
            [alias] => 130
        )

    [core_person_alias__keys] => Array
        (
            [id] => N
        )

    [core_person_settings] => Array
        (
            [id] => 129
            [person_id] => 129
            [scope] => 130
            [data] => 162
        )

    [core_person_settings__keys] => Array
        (
            [id] => N
        )

    [core_person_signup] => Array
        (
            [id] => 129
            [name] => 130
            [honor] => 130
            [firstname] => 130
            [lastname] => 130
            [firstname_alt] => 130
            [lastname_alt] => 130
            [email] => 130
            [verify_key] => 130
            [created_dt] => 142
            [company_name] => 162
            [person_type] => 162
            [person_id] => 129
            [person_table] => 162
            [inviter_id] => 129
            [crm_mailing_list_id] => 129
            [phone] => 130
        )

    [core_person_signup__keys] => Array
        (
            [id] => N
        )

    [core_project] => Array
        (
            [id] => 129
            [name] => 130
            [remarks] => 162
            [owner_id] => 129
            [code] => 130
            [active] => 129
            [type] => 130
            [client_id] => 129
            [team_id] => 129
            [file_location] => 130
            [open_date] => 134
            [open_by] => 129
            [updated_dt] => 142
            [countries] => 130
            [languages] => 130
            [agency_id] => 129
        )

    [core_project__keys] => Array
        (
            [id] => N
        )

    [core_setting] => Array
        (
            [id] => 129
            [module] => 130
            [name] => 130
            [description] => 130
            [val] => 194
            [updated_dt] => 134
            [is_encrypt] => 129
            [is_valid] => 129
        )

    [core_setting__keys] => Array
        (
            [id] => N
        )

    [core_template] => Array
        (
            [id] => 129
            [template] => 130
            [updated] => 142
            [lang] => 130
            [view_name] => 130
            [filetype] => 130
            [is_deleted] => 129
        )

    [core_template__keys] => Array
        (
            [id] => N
        )

    [core_template_element] => Array
        (
            [id] => 129
            [name] => 130
            [template_id] => 129
        )

    [core_template_element__keys] => Array
        (
            [id] => N
        )

    [core_templatestr] => Array
        (
            [id] => 129
            [txt] => 162
            [updated] => 142
            [src_id] => 129
            [lang] => 130
            [active] => 129
            [mdsum] => 130
            [template_id] => 129
            [on_table] => 130
            [on_id] => 129
            [on_col] => 130
        )

    [core_templatestr__keys] => Array
        (
            [id] => N
        )

    [core_watch] => Array
        (
            [id] => 129
            [ontable] => 130
            [onid] => 129
            [person_id] => 129
            [event] => 130
            [medium] => 130
            [active] => 129
        )

    [core_watch__keys] => Array
        (
            [id] => N
        )

    [cost_centers] => Array
        (
            [id] => 129
            [short_name] => 130
            [name] => 130
            [is_active] => 129
        )

    [cost_centers__keys] => Array
        (
            [id] => N
        )

    [crm_action] => Array
        (
            [id] => 129
            [person_id] => 129
            [staff_id] => 129
            [notes] => 162
            [action_type_id] => 129
            [action_dt] => 142
            [crm_service_id] => 129
            [original_id] => 129
            [superseeded_by_id] => 129
            [parent_id] => 129
            [crm_service_interest_id] => 129
            [contact_again_notify_id] => 129
        )

    [crm_action__keys] => Array
        (
            [id] => N
        )

    [crm_business_focus] => Array
        (
            [id] => 129
            [company_id] => 129
            [focus_id] => 129
        )

    [crm_business_focus__keys] => Array
        (
            [id] => N
        )

    [crm_interest] => Array
        (
            [id] => 129
            [onid] => 129
            [ontable] => 130
            [interest_id] => 129
            [created_dt] => 142
        )

    [crm_interest__keys] => Array
        (
            [id] => N
        )

    [crm_location_covered] => Array
        (
            [id] => 129
            [person_id] => 129
            [location_id] => 129
        )

    [crm_location_covered__keys] => Array
        (
            [id] => N
        )

    [crm_mailing_list] => Array
        (
            [id] => 129
            [name] => 130
            [no_members] => 129
            [owner_id] => 129
            [filter_criteria_type] => 130
            [filter_country] => 130
            [filter_company_type] => 130
            [filter_region] => 130
            [filter_lang] => 130
            [filter_industry] => 130
            [filter_business_focus] => 130
            [filter_interest] => 130
            [filter_customer] => 130
            [filter_role_function] => 130
            [filter_custom] => 130
            [filter_before_update_dt] => 130
            [filter_after_update_dt] => 130
            [exclude_country] => 130
            [exclude_company_type] => 130
            [exclude_region] => 130
            [exclude_lang] => 130
            [exclude_industry] => 130
            [exclude_business_focus] => 130
            [exclude_interest] => 130
            [exclude_customer] => 130
            [exclude_role_function] => 130
            [exclude_custom] => 130
            [redirect_url] => 162
        )

    [crm_mailing_list__keys] => Array
        (
            [id] => N
        )

    [crm_mailing_list_click] => Array
        (
            [id] => 129
            [person_id] => 129
            [message_id] => 129
            [link_id] => 129
            [qty] => 129
            [first_dt] => 142
            [last_dt] => 142
        )

    [crm_mailing_list_click__keys] => Array
        (
            [id] => N
        )

    [crm_mailing_list_link] => Array
        (
            [id] => 129
            [url] => 162
        )

    [crm_mailing_list_link__keys] => Array
        (
            [id] => N
        )

    [crm_mailing_list_member] => Array
        (
            [id] => 129
            [person_id] => 129
            [mailing_list_id] => 129
            [is_active] => 129
            [on_table] => 130
            [on_id] => 129
            [created_event_id] => 129
            [queue_id] => 129
            [hebe_member_id] => 129
        )

    [crm_mailing_list_member__keys] => Array
        (
            [id] => N
        )

    [crm_mailing_list_message] => Array
        (
            [id] => 129
            [subject] => 162
            [bodytext] => 162
            [plaintext] => 162
            [name] => 130
            [updated_dt] => 142
            [from_email] => 130
            [from_name] => 130
            [owner_id] => 129
            [active] => 129
            [updated_by] => 129
            [created_dt] => 142
            [created_by] => 129
            [to_group_id] => 129
            [bcc_group_id] => 129
        )

    [crm_mailing_list_message__keys] => Array
        (
            [id] => N
        )

    [crm_mailing_list_queue] => Array
        (
            [id] => 129
            [message_id] => 129
            [status_id] => 129
            [when_dt] => 142
            [notify_generated] => 129
            [mailing_list_id] => 130
            [exclude_person_id] => 130
            [owner_id] => 129
            [est_rcpts] => 129
        )

    [crm_mailing_list_queue__keys] => Array
        (
            [id] => N
        )

    [crm_person] => Array
        (
            [id] => 129
            [name] => 130
            [honor] => 130
            [firstname] => 130
            [lastname] => 130
            [firstname_alt] => 130
            [lastname_alt] => 130
            [chosen_title] => 162
            [role] => 130
            [remarks] => 162
            [lang] => 130
            [country] => 130
            [birth_date] => 134
            [email] => 130
            [phone] => 130
            [phone_mobile] => 130
            [phone_direct] => 130
            [fax] => 130
            [alt_email] => 130
            [office_id] => 129
            [company_id] => 129
            [owner_id] => 129
            [active] => 129
            [project_id] => 129
            [passwd] => 130
            [no_reset_sent] => 129
            [deleted_by] => 129
            [deleted_dt] => 142
            [name_facebook] => 130
            [url_blog] => 130
            [url_twitter] => 130
            [linkedin_id] => 130
            [url_linkedin] => 130
            [url_google_plus] => 162
            [url_blog2] => 162
            [url_blog3] => 162
            [countries] => 130
            [action_type] => 130
            [point_score] => 129
            [authorize_md5] => 130
            [crm_lead_percentage] => 129
            [crm_updated_action_id] => 129
            [crm_created_action_id] => 129
            [crm_type_id] => 129
            [crm_location_covered_id] => 129
            [crm_current_relationship_id] => 129
            [crm_is_unsubscribed] => 129
            [crm_is_private] => 129
            [crm_role_function_id] => 129
            [crm_is_primary_contact] => 129
            [crm_contact_again_notify_id] => 129
            [crm_is_decision_maker] => 129
            [crm_source_id] => 129
            [crm_smtp_reject_id] => 129
            [crm_smtp_server_id] => 129
            [crm_country_id] => 129
            [crm_city_id] => 129
            [crm_division_id] => 129
            [crm_country] => 162
            [crm_city] => 162
            [crm_division] => 162
            [crm_contact_again_notify_date] => 142
            [updated_dt] => 134
            [crm_industry_id] => 129
            [crm_honor] => 130
            [crm_last_smtp_reject] => 129
            [post_code] => 130
            [oath_key] => 130
        )

    [crm_person__keys] => Array
        (
            [id] => N
        )

    [crm_person_interest] => Array
        (
            [id] => 129
            [person_id] => 129
            [interest_id] => 129
            [created_dt] => 142
        )

    [crm_person_interest__keys] => Array
        (
            [id] => N
        )

    [crm_person_relation] => Array
        (
            [id] => 129
            [staff_id] => 129
            [person_id] => 129
        )

    [crm_person_relation__keys] => Array
        (
            [id] => N
        )

    [crm_service_interest] => Array
        (
            [id] => 129
            [person_id] => 129
            [crm_service_id] => 129
            [is_customer] => 129
            [started_dt] => 142
            [created_by] => 129
            [updated_dt] => 142
            [is_interested] => 129
            [expires_dt] => 142
            [probability] => 129
            [est_value] => 129
            [est_closing] => 134
        )

    [crm_service_interest__keys] => Array
        (
            [id] => N
        )

    [crm_smtp_reject] => Array
        (
            [id] => 129
            [code] => 129
            [error_msg] => 162
            [match_id] => 129
        )

    [crm_smtp_reject__keys] => Array
        (
            [id] => N
        )

    [crm_smtp_reject_match] => Array
        (
            [id] => 129
            [name] => 130
            [match_regex] => 162
            [is_failure] => 129
        )

    [crm_smtp_reject_match__keys] => Array
        (
            [id] => N
        )

    [dependants] => Array
        (
            [id] => 129
            [member] => 129
            [title] => 130
            [name] => 130
            [sex] => 130
            [birth_date] => 134
            [cansign] => 130
            [spouse] => 129
            [card_no_old] => 130
            [card_issued] => 134
            [telephone] => 130
            [card_no] => 130
            [hkid] => 130
            [crew_id] => 130
            [expiry_date] => 134
        )

    [dependants__keys] => Array
        (
            [id] => N
        )

    [group_members] => Array
        (
            [id] => 129
            [group_id] => 129
            [user_id] => 129
        )

    [group_members__keys] => Array
        (
            [id] => N
        )

    [group_rights] => Array
        (
            [id] => 129
            [rightname] => 130
            [group_id] => 129
            [accessmask] => 130
        )

    [group_rights__keys] => Array
        (
            [id] => N
        )

    [hebe_member_obligation] => Array
        (
            [id] => 129
            [member_id] => 129
            [member_obligation_type_id] => 129
        )

    [hebe_member_obligation__keys] => Array
        (
            [id] => N
        )

    [hebe_obligations_history] => Array
        (
            [id] => 129
            [obligation_id] => 129
            [member_id] => 129
            [when_dt] => 134
            [notes] => 162
        )

    [hebe_obligations_history__keys] => Array
        (
            [id] => N
        )

    [hebe_report] => Array
        (
            [id] => 129
            [report_table] => 130
            [report_name] => 130
            [filters] => 162
            [columns] => 162
        )

    [hebe_report__keys] => Array
        (
            [id] => N
        )

    [i18n] => Array
        (
            [id] => 129
            [ltype] => 130
            [lkey] => 130
            [inlang] => 130
            [lval] => 130
            [is_active] => 129
            [is_prefer] => 129
        )

    [i18n__keys] => Array
        (
            [id] => N
        )

    [mail_queue] => Array
        (
            [id] => 129
            [create_time] => 142
            [time_to_send] => 142
            [sent_time] => 142
            [id_user] => 129
            [ip] => 130
            [sender] => 130
            [recipient] => 130
            [headers] => 162
            [body] => 162
            [try_sent] => 129
            [delete_after_send] => 129
        )

    [mail_queue_seq] => Array
        (
            [id] => 129
        )

    [mail_queue_seq__keys] => Array
        (
            [id] => N
        )

    [member_address] => Array
        (
            [id] => 129
            [address_type] => 130
            [profession] => 130
            [company_name] => 130
            [address] => 162
            [tel] => 130
            [fax] => 130
            [mobile] => 130
            [member] => 129
            [email] => 130
            [email_secondary] => 130
        )

    [member_address__keys] => Array
        (
            [id] => N
        )

    [member_bill] => Array
        (
            [id] => 129
            [billm] => 134
            [member_id] => 129
            [billmsg] => 162
            [dayofmonth] => 129
            [is_approved] => 129
            [approved_date] => 134
            [email_day] => 129
            [email_hour] => 129
            [opening_balance] => 129
            [no_transactions] => 129
            [email_notify_id] => 129
        )

    [member_bill__keys] => Array
        (
            [id] => N
        )

    [member_deposit_transaction] => Array
        (
            [id] => 129
            [member_id] => 129
            [transaction_dt] => 134
            [amount] => 129
            [reservation_id] => 129
            [transaction_id] => 129
            [create_event_id] => 129
            [delete_event_id] => 129
        )

    [member_deposit_transaction__keys] => Array
        (
            [id] => N
        )

    [member_fb_cost] => Array
        (
            [member_id] => 129
            [start_status] => 130
            [end_status] => 134
            [start_cost] => 130
            [end_cost] => 134
            [month_cost] => 129
        )

    [member_history] => Array
        (
            [id] => 129
            [member] => 129
            [changed_date] => 134
            [to_status] => 129
            [notes] => 130
            [resign_reason_id] => 129
            [end_date] => 134
        )

    [member_history__keys] => Array
        (
            [id] => N
        )

    [member_history_current] => Array
        (
            [member] => 129
            [changed_date] => 134
            [end_date] => 134
            [to_status] => 129
            [to_status_name] => 130
            [to_status_short_name] => 130
        )

    [member_history_status] => Array
        (
            [member] => 129
            [start_d] => 130
            [end_d] => 134
            [status] => 129
        )

    [member_history_typecost_fb] => Array
        (
            [member_type] => 129
            [food_min] => 129
            [start_d] => 134
            [end_d] => 134
        )

    [member_long_term_parking] => Array
        (
            [id] => 129
            [member_id] => 129
            [is_active] => 129
            [start_date] => 134
            [is_ceased] => 129
            [ceased_date] => 134
            [price] => 129
            [notes] => 162
        )

    [member_long_term_parking__keys] => Array
        (
            [id] => N
        )

    [member_obligation] => Array
        (
            [id] => 129
            [member_id] => 129
            [member_obligation_type_id] => 129
        )

    [member_obligation__keys] => Array
        (
            [id] => N
        )

    [member_obligation_type] => Array
        (
            [id] => 129
            [name] => 130
        )

    [member_obligation_type__keys] => Array
        (
            [id] => N
        )

    [member_privaliges] => Array
        (
            [id] => 129
            [name] => 130
        )

    [member_privaliges__keys] => Array
        (
            [id] => N
        )

    [member_registered_cars] => Array
        (
            [id] => 129
            [member_id] => 129
            [registration_number] => 130
            [color] => 130
            [brand] => 130
            [model] => 130
            [reference] => 130
            [active] => 129
        )

    [member_registered_cars__keys] => Array
        (
            [id] => N
        )

    [member_status] => Array
        (
            [id] => 129
            [name] => 130
            [short_name] => 130
        )

    [member_status__keys] => Array
        (
            [id] => N
        )

    [member_type_history] => Array
        (
            [id] => 129
            [member_id] => 129
            [member_type_id] => 129
            [changed_dt] => 134
            [endorsed_by_gc_dt] => 134
            [proposer] => 129
            [seconder] => 129
            [notes] => 162
        )

    [member_type_history__keys] => Array
        (
            [id] => N
        )

    [member_typecost] => Array
        (
            [id] => 129
            [member_type] => 129
            [start_date] => 134
            [join_fee] => 129
            [month_fee] => 129
            [privaliges] => 130
            [notes] => 162
            [approved] => 130
            [food_min] => 129
            [building_levy_fee] => 129
            [voting_rights] => 129
        )

    [member_typecost__keys] => Array
        (
            [id] => N
        )

    [member_typecost_old] => Array
        (
            [id] => 129
            [member_type] => 129
            [start_date] => 134
            [join_fee] => 129
            [month_fee] => 129
            [privaliges] => 130
            [notes] => 162
            [approved] => 130
            [food_min] => 129
            [building_levy_fee] => 129
        )

    [member_typecost_old__keys] => Array
        (
            [id] => N
        )

    [member_types] => Array
        (
            [id] => 129
            [charge_code] => 130
            [name] => 130
        )

    [member_types__keys] => Array
        (
            [id] => N
        )

    [members] => Array
        (
            [id] => 129
            [code] => 130
            [member_type] => 129
            [status] => 129
            [card_no] => 130
            [card_issued] => 134
            [title] => 130
            [name] => 130
            [name_zh] => 130
            [sex] => 130
            [birth_date] => 134
            [hkid] => 130
            [passport] => 130
            [nationality] => 130
            [children] => 129
            [correspond] => 129
            [married] => 130
            [email_bills] => 130
            [email_promo] => 130
            [image] => 130
            [proposer] => 129
            [seconder] => 129
            [applied] => 134
            [application_number] => 129
            [remarks] => 130
            [use_autopay] => 130
            [bank] => 130
            [account] => 130
            [limit_amount] => 129
            [account_name] => 130
            [bill_address] => 130
            [outstanding] => 129
            [year_total] => 129
            [month_total] => 129
            [brought_forward] => 129
            [hkarea] => 130
            [last_payment_due] => 134
            [join_date] => 134
            [deposit_note] => 130
            [has_wireless] => 129
            [manager_name] => 130
            [policy_number] => 130
            [expiry_date] => 134
            [tel] => 130
            [bill_lang] => 130
            [parent_id] => 129
            [email_jebe] => 130
        )

    [members__keys] => Array
        (
            [id] => N
        )

    [person] => Array
        (
            [id] => 129
            [username] => 130
            [password] => 130
            [usertype] => 129
            [email] => 130
        )

    [person__keys] => Array
        (
            [id] => N
        )

    [pga_diagrams] => Array
        (
            [diagramname] => 130
            [diagramtables] => 162
            [diagramlinks] => 162
        )

    [pga_forms] => Array
        (
            [formname] => 130
            [formsource] => 162
        )

    [pga_graphs] => Array
        (
            [graphname] => 130
            [graphsource] => 162
            [graphcode] => 162
        )

    [pga_images] => Array
        (
            [imagename] => 130
            [imagesource] => 162
        )

    [pga_layout] => Array
        (
            [tablename] => 130
            [nrcols] => 129
            [colnames] => 162
            [colwidth] => 162
        )

    [pga_queries] => Array
        (
            [queryname] => 130
            [querytype] => 130
            [querycommand] => 162
            [querytables] => 162
            [querylinks] => 162
            [queryresults] => 162
            [querycomments] => 162
        )

    [pga_reports] => Array
        (
            [reportname] => 130
            [reportsource] => 162
            [reportbody] => 162
            [reportprocs] => 162
            [reportoptions] => 162
        )

    [pga_scripts] => Array
        (
            [scriptname] => 130
            [scriptsource] => 162
        )

    [rental_code_history] => Array
        (
            [id] => 129
            [rental_code_id] => 129
            [cost] => 129
            [since_date] => 134
        )

    [rental_code_history__keys] => Array
        (
            [id] => N
        )

    [rental_codes] => Array
        (
            [id] => 129
            [charge_code] => 130
            [rental_type] => 130
            [description] => 130
            [cost] => 129
            [cost_center] => 129
            [is_active] => 129
            [since_date] => 134
        )

    [rental_codes__keys] => Array
        (
            [id] => N
        )

    [rental_items] => Array
        (
            [id] => 129
            [rental_type] => 130
            [item_name] => 130
            [rental] => 129
            [remarks] => 130
            [location] => 130
            [available] => 134
            [default_code] => 129
            [is_rentable] => 129
            [proposed_reservation_id] => 129
            [proposed_reservation_sent] => 134
        )

    [rental_items__keys] => Array
        (
            [id] => N
        )

    [rentals] => Array
        (
            [start_date] => 134
            [ceased] => 134
            [rental_item] => 129
            [active] => 130
            [id] => 129
            [rental_code] => 129
            [renter] => 129
            [boat] => 129
            [boat_registration] => 130
            [is_temporary] => 129
            [deposit_tx_id] => 129
            [refund_tx_id] => 129
        )

    [rentals__keys] => Array
        (
            [id] => N
        )

    [reservations] => Array
        (
            [id] => 129
            [rental_code] => 129
            [renter] => 129
            [require_date] => 134
            [request_date] => 134
            [notes] => 130
            [has_paid] => 129
            [deposit_paid] => 129
            [boat_name] => 130
            [is_withdrawn] => 129
            [rental_id] => 129
            [positions] => 129
            [deposit_paid_dt] => 134
            [deposit_tx_id] => 129
            [refund_tx_id] => 129
        )

    [reservations__keys] => Array
        (
            [id] => N
        )

    [settings] => Array
        (
            [id] => 129
            [key] => 130
            [val] => 130
        )

    [settings__keys] => Array
        (
            [id] => N
        )

    [translations] => Array
        (
            [id] => 129
            [module] => 130
            [tfile] => 130
            [tlang] => 130
            [tkey] => 130
            [tval] => 162
        )

    [translations__keys] => Array
        (
            [id] => N
        )

    [waiting_list] => Array
        (
            [id] => 129
            [list_status] => 130
            [member_type] => 129
            [title] => 130
            [name] => 130
            [name_zh] => 130
            [sex] => 130
            [birth_date] => 134
            [hkid] => 130
            [passport] => 130
            [nationality] => 130
            [children] => 129
            [correspond] => 129
            [married] => 130
            [mail_bills] => 130
            [mail_promo] => 130
            [image] => 130
            [proposer] => 129
            [seconder] => 129
            [applied] => 134
            [remarks] => 130
            [application_number] => 129
            [deposit] => 129
        )

    [waiting_list__keys] => Array
        (
            [id] => N
        )

    [waiting_list_address] => Array
        (
            [id] => 129
            [address_type] => 130
            [profession] => 130
            [company_name] => 130
            [address] => 130
            [tel] => 130
            [fax] => 130
            [mobile] => 130
            [member] => 129
            [email] => 130
        )

    [waiting_list_address__keys] => Array
        (
            [id] => N
        )

    [waiting_list_dependants] => Array
        (
            [id] => 129
            [member] => 129
            [title] => 130
            [name] => 130
            [sex] => 130
            [birth_date] => 134
            [cansign] => 130
            [spouse] => 130
            [card_no] => 130
            [card_issued] => 134
            [telephone] => 130
        )

    [waiting_list_dependants__keys] => Array
        (
            [id] => N
        )

)