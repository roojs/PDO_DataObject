--TEST--
databaseStructure - postgresql - real databases (not for final test pass)
--FILE--
<?php
require_once 'includes/init.php';

$base_config = PDO_DataObject::config();
 
echo "\n\nREAL DATABASE CONNECT - NOT IN FINAL TEST (postgres)\n";

(new PDO_DataObject())->reset();

PDO_DataObject::config(
    array(
        'schema_location' => false,
        'PDO' => 'PDO',
        'databases' => array(
            'xtuple_db' => 'pgsql://admin:pass4xtuple@localhost/xtuplehk'
        ),
        'tables' => array(
            'accnt' => 'xtuple_db'
        ),
        'proxy' => true,
        'debug' => 0,
        
    )
);



$obj = new PDO_DataObject('accnt');
$obj->PDO();
print_r($obj->databaseStructure());

// fixme - we need to compare this to the output from DB_DataObject...

 
?>
--EXPECT--
REAL DATABASE CONNECT - NOT IN FINAL TEST (postgres)
Array
(
    [acalitem] => Array
        (
            [acalitem_id] => 129
            [acalitem_calhead_id] => 1
            [acalitem_periodstart] => 6
            [acalitem_periodlength] => 1
            [acalitem_name] => 34
        )

    [acalitem__keys] => Array
        (
            [acalitem_id] => xcalitem_xcalitem_id_seq
        )

    [accnt] => Array
        (
            [accnt_id] => 129
            [accnt_number] => 34
            [accnt_descrip] => 34
            [accnt_comments] => 34
            [accnt_profit] => 34
            [accnt_sub] => 34
            [accnt_type] => 130
            [accnt_extref] => 34
            [accnt_company] => 34
            [accnt_closedpost] => 18
            [accnt_forwardupdate] => 18
            [accnt_subaccnttype_code] => 34
            [accnt_curr_id] => 1
            [accnt_active] => 146
            [accnt_name] => 34
            [accnt_code_alt] => 34
            [accnt_descrip_alt] => 34
        )

    [accnt__keys] => Array
        (
            [accnt_id] => accnt_accnt_id_seq
        )

    [addr] => Array
        (
            [addr_id] => 129
            [addr_active] => 18
            [addr_line1] => 34
            [addr_line2] => 34
            [addr_line3] => 34
            [addr_city] => 34
            [addr_state] => 34
            [addr_postalcode] => 34
            [addr_country] => 34
            [addr_notes] => 34
            [addr_number] => 162
        )

    [addr__keys] => Array
        (
            [addr_id] => addr_addr_id_seq
        )

    [alarm] => Array
        (
            [alarm_id] => 129
            [alarm_number] => 162
            [alarm_event] => 146
            [alarm_email] => 146
            [alarm_sysmsg] => 146
            [alarm_trigger] => 2
            [alarm_time] => 2
            [alarm_time_offset] => 1
            [alarm_time_qualifier] => 34
            [alarm_creator] => 34
            [alarm_event_recipient] => 34
            [alarm_email_recipient] => 34
            [alarm_sysmsg_recipient] => 34
            [alarm_source] => 34
            [alarm_source_id] => 1
        )

    [alarm__keys] => Array
        (
            [alarm_id] => alarm_alarm_id_seq
        )

    [apaccnt] => Array
        (
            [apaccnt_id] => 129
            [apaccnt_vendtype_id] => 1
            [apaccnt_vendtype] => 34
            [apaccnt_ap_accnt_id] => 129
            [apaccnt_prepaid_accnt_id] => 1
            [apaccnt_discount_accnt_id] => 1
        )

    [apaccnt__keys] => Array
        (
            [apaccnt_id] => apaccnt_apaccnt_id_seq
        )

    [apapply] => Array
        (
            [apapply_id] => 129
            [apapply_vend_id] => 1
            [apapply_postdate] => 6
            [apapply_username] => 34
            [apapply_source_apopen_id] => 1
            [apapply_source_doctype] => 34
            [apapply_source_docnumber] => 34
            [apapply_target_apopen_id] => 1
            [apapply_target_doctype] => 34
            [apapply_target_docnumber] => 34
            [apapply_journalnumber] => 1
            [apapply_amount] => 1
            [apapply_curr_id] => 1
            [apapply_target_paid] => 1
            [apapply_checkhead_id] => 1
        )

    [apapply__keys] => Array
        (
            [apapply_id] => apapply_apapply_id_seq
        )

    [apcreditapply] => Array
        (
            [apcreditapply_id] => 129
            [apcreditapply_source_apopen_id] => 1
            [apcreditapply_target_apopen_id] => 1
            [apcreditapply_amount] => 1
            [apcreditapply_curr_id] => 1
        )

    [apcreditapply__keys] => Array
        (
            [apcreditapply_id] => apcreditapply_apcreditapply_id_seq
        )

    [apopen] => Array
        (
            [apopen_id] => 129
            [apopen_docdate] => 6
            [apopen_duedate] => 6
            [apopen_terms_id] => 1
            [apopen_vend_id] => 1
            [apopen_doctype] => 2
            [apopen_docnumber] => 34
            [apopen_amount] => 1
            [apopen_notes] => 34
            [apopen_posted] => 18
            [apopen_reference] => 34
            [apopen_invcnumber] => 34
            [apopen_ponumber] => 34
            [apopen_journalnumber] => 1
            [apopen_paid] => 1
            [apopen_open] => 18
            [apopen_username] => 34
            [apopen_discount] => 146
            [apopen_accnt_id] => 1
            [apopen_curr_id] => 1
            [apopen_closedate] => 6
            [apopen_distdate] => 6
            [apopen_void] => 146
            [apopen_curr_rate] => 129
            [apopen_discountable_amount] => 1
            [apopen_status] => 34
        )

    [apopen__keys] => Array
        (
            [apopen_id] => apopen_apopen_id_seq
        )

    [apopentax] => Array
        (
            [taxhist_id] => 129
            [taxhist_parent_id] => 129
            [taxhist_taxtype_id] => 1
            [taxhist_tax_id] => 129
            [taxhist_basis] => 129
            [taxhist_basis_tax_id] => 1
            [taxhist_sequence] => 1
            [taxhist_percent] => 129
            [taxhist_amount] => 129
            [taxhist_tax] => 129
            [taxhist_docdate] => 134
            [taxhist_distdate] => 6
            [taxhist_curr_id] => 1
            [taxhist_curr_rate] => 1
            [taxhist_journalnumber] => 1
        )

    [apopentax__keys] => Array
        (
            [taxhist_id] => taxhist_taxhist_id_seq
        )

    [apselect] => Array
        (
            [apselect_id] => 129
            [apselect_apopen_id] => 129
            [apselect_amount] => 129
            [apselect_bankaccnt_id] => 1
            [apselect_curr_id] => 1
            [apselect_date] => 6
            [apselect_discount] => 129
            [apselect_oldid] => 1
        )

    [apselect__keys] => Array
        (
            [apselect_id] => apselect_apselect_id_seq
        )

    [araccnt] => Array
        (
            [araccnt_id] => 129
            [araccnt_custtype_id] => 1
            [araccnt_custtype] => 34
            [araccnt_freight_accnt_id] => 1
            [araccnt_ar_accnt_id] => 1
            [araccnt_prepaid_accnt_id] => 1
            [araccnt_deferred_accnt_id] => 1
            [araccnt_discount_accnt_id] => 1
        )

    [araccnt__keys] => Array
        (
            [araccnt_id] => araccnt_araccnt_id_seq
        )

    [arapply] => Array
        (
            [arapply_id] => 129
            [arapply_postdate] => 6
            [arapply_cust_id] => 1
            [arapply_source_doctype] => 34
            [arapply_source_docnumber] => 34
            [arapply_target_doctype] => 34
            [arapply_target_docnumber] => 34
            [arapply_fundstype] => 34
            [arapply_refnumber] => 34
            [arapply_applied] => 1
            [arapply_closed] => 18
            [arapply_journalnumber] => 34
            [arapply_source_aropen_id] => 1
            [arapply_target_aropen_id] => 1
            [arapply_username] => 34
            [arapply_curr_id] => 1
            [arapply_distdate] => 134
            [arapply_target_paid] => 1
            [arapply_reftype] => 34
            [arapply_ref_id] => 1
        )

    [arapply__keys] => Array
        (
            [arapply_id] => arapply_arapply_id_seq
        )

    [arcreditapply] => Array
        (
            [arcreditapply_id] => 129
            [arcreditapply_source_aropen_id] => 1
            [arcreditapply_target_aropen_id] => 1
            [arcreditapply_amount] => 1
            [arcreditapply_curr_id] => 1
            [arcreditapply_reftype] => 34
            [arcreditapply_ref_id] => 1
        )

    [arcreditapply__keys] => Array
        (
            [arcreditapply_id] => arcreditapply_arcreditapply_id_seq
        )

    [aropen] => Array
        (
            [aropen_id] => 129
            [aropen_docdate] => 134
            [aropen_duedate] => 134
            [aropen_terms_id] => 1
            [aropen_cust_id] => 1
            [aropen_doctype] => 2
            [aropen_docnumber] => 34
            [aropen_applyto] => 34
            [aropen_ponumber] => 34
            [aropen_amount] => 129
            [aropen_notes] => 34
            [aropen_posted] => 146
            [aropen_salesrep_id] => 1
            [aropen_commission_due] => 1
            [aropen_commission_paid] => 18
            [aropen_ordernumber] => 34
            [aropen_cobmisc_id] => 1
            [aropen_journalnumber] => 1
            [aropen_paid] => 1
            [aropen_open] => 18
            [aropen_username] => 34
            [aropen_rsncode_id] => 1
            [aropen_salescat_id] => 1
            [aropen_accnt_id] => 1
            [aropen_curr_id] => 1
            [aropen_closedate] => 6
            [aropen_distdate] => 6
            [aropen_curr_rate] => 129
            [aropen_discount] => 146
        )

    [aropen__keys] => Array
        (
            [aropen_id] => aropen_aropen_id_seq
        )

    [aropenalloc] => Array
        (
            [aropenalloc_aropen_id] => 129
            [aropenalloc_doctype] => 130
            [aropenalloc_doc_id] => 129
            [aropenalloc_amount] => 129
            [aropenalloc_curr_id] => 1
        )

    [aropenalloc__keys] => Array
        (
            [aropenalloc_aropen_id] => K
            [aropenalloc_doctype] => K
            [aropenalloc_doc_id] => K
        )

    [aropentax] => Array
        (
            [taxhist_id] => 129
            [taxhist_parent_id] => 129
            [taxhist_taxtype_id] => 1
            [taxhist_tax_id] => 129
            [taxhist_basis] => 129
            [taxhist_basis_tax_id] => 1
            [taxhist_sequence] => 1
            [taxhist_percent] => 129
            [taxhist_amount] => 129
            [taxhist_tax] => 129
            [taxhist_docdate] => 134
            [taxhist_distdate] => 6
            [taxhist_curr_id] => 1
            [taxhist_curr_rate] => 1
            [taxhist_journalnumber] => 1
        )

    [aropentax__keys] => Array
        (
            [taxhist_id] => taxhist_taxhist_id_seq
        )

    [asohist] => Array
        (
            [asohist_id] => 129
            [asohist_cust_id] => 1
            [asohist_itemsite_id] => 1
            [asohist_shipdate] => 6
            [asohist_invcdate] => 6
            [asohist_duedate] => 6
            [asohist_promisedate] => 6
            [asohist_ordernumber] => 34
            [asohist_invcnumber] => 34
            [asohist_qtyshipped] => 1
            [asohist_unitprice] => 1
            [asohist_unitcost] => 1
            [asohist_billtoname] => 34
            [asohist_billtoaddress1] => 34
            [asohist_billtoaddress2] => 34
            [asohist_billtoaddress3] => 34
            [asohist_billtocity] => 34
            [asohist_billtostate] => 34
            [asohist_billtozip] => 34
            [asohist_shiptoname] => 34
            [asohist_shiptoaddress1] => 34
            [asohist_shiptoaddress2] => 34
            [asohist_shiptoaddress3] => 34
            [asohist_shiptocity] => 34
            [asohist_shiptostate] => 34
            [asohist_shiptozip] => 34
            [asohist_shipto_id] => 1
            [asohist_shipvia] => 34
            [asohist_salesrep_id] => 1
            [asohist_misc_type] => 2
            [asohist_misc_descrip] => 34
            [asohist_misc_id] => 1
            [asohist_commission] => 1
            [asohist_commissionpaid] => 18
            [asohist_doctype] => 34
            [asohist_orderdate] => 6
            [asohist_imported] => 18
            [asohist_ponumber] => 34
            [asohist_curr_id] => 1
            [asohist_taxtype_id] => 1
            [asohist_taxzone_id] => 1
        )

    [asohist__keys] => Array
        (
            [asohist_id] => asohist_asohist_id_seq
        )

    [asohisttax] => Array
        (
            [taxhist_id] => 129
            [taxhist_parent_id] => 129
            [taxhist_taxtype_id] => 1
            [taxhist_tax_id] => 129
            [taxhist_basis] => 129
            [taxhist_basis_tax_id] => 1
            [taxhist_sequence] => 1
            [taxhist_percent] => 129
            [taxhist_amount] => 129
            [taxhist_tax] => 129
            [taxhist_docdate] => 134
            [taxhist_distdate] => 6
            [taxhist_curr_id] => 1
            [taxhist_curr_rate] => 1
            [taxhist_journalnumber] => 1
        )

    [asohisttax__keys] => Array
        (
            [taxhist_id] => taxhist_taxhist_id_seq
        )

    [atlasmap] => Array
        (
            [atlasmap_id] => 129
            [atlasmap_name] => 162
            [atlasmap_filter] => 162
            [atlasmap_filtertype] => 162
            [atlasmap_atlas] => 162
            [atlasmap_map] => 162
            [atlasmap_headerline] => 146
        )

    [atlasmap__keys] => Array
        (
            [atlasmap_id] => atlasmap_atlasmap_id_seq
        )

    [backup_usr] => Array
        (
            [usr_id] => 1
            [usr_username] => 34
            [usr_propername] => 34
            [usr_passwd] => 34
            [usr_locale_id] => 1
            [usr_initials] => 34
            [usr_agent] => 18
            [usr_active] => 18
            [usr_email] => 34
            [usr_dept_id] => 1
            [usr_shift_id] => 1
            [usr_window] => 34
        )

    [bankaccnt] => Array
        (
            [bankaccnt_id] => 129
            [bankaccnt_name] => 34
            [bankaccnt_descrip] => 34
            [bankaccnt_bankname] => 34
            [bankaccnt_accntnumber] => 34
            [bankaccnt_ar] => 18
            [bankaccnt_ap] => 18
            [bankaccnt_nextchknum] => 1
            [bankaccnt_type] => 2
            [bankaccnt_accnt_id] => 1
            [bankaccnt_check_form_id] => 1
            [bankaccnt_userec] => 18
            [bankaccnt_rec_accnt_id] => 1
            [bankaccnt_curr_id] => 1
            [bankaccnt_notes] => 34
            [bankaccnt_routing] => 162
            [bankaccnt_ach_enabled] => 146
            [bankaccnt_ach_origin] => 162
            [bankaccnt_ach_genchecknum] => 146
            [bankaccnt_ach_leadtime] => 1
            [bankaccnt_ach_lastdate] => 6
            [bankaccnt_ach_lastfileid] => 2
            [bankaccnt_ach_origintype] => 34
            [bankaccnt_ach_originname] => 34
            [bankaccnt_ach_desttype] => 34
            [bankaccnt_ach_fed_dest] => 34
            [bankaccnt_ach_destname] => 34
            [bankaccnt_ach_dest] => 34
        )

    [bankaccnt__keys] => Array
        (
            [bankaccnt_id] => bankaccnt_bankaccnt_id_seq
        )

    [bankadj] => Array
        (
            [bankadj_id] => 129
            [bankadj_bankaccnt_id] => 129
            [bankadj_bankadjtype_id] => 129
            [bankadj_created] => 142
            [bankadj_username] => 162
            [bankadj_date] => 134
            [bankadj_docnumber] => 34
            [bankadj_amount] => 129
            [bankadj_notes] => 34
            [bankadj_sequence] => 1
            [bankadj_posted] => 146
            [bankadj_curr_id] => 1
            [bankadj_curr_rate] => 1
        )

    [bankadj__keys] => Array
        (
            [bankadj_id] => bankadj_bankadj_id_seq
        )

    [bankadjtype] => Array
        (
            [bankadjtype_id] => 129
            [bankadjtype_name] => 162
            [bankadjtype_descrip] => 34
            [bankadjtype_accnt_id] => 129
            [bankadjtype_iscredit] => 146
        )

    [bankadjtype__keys] => Array
        (
            [bankadjtype_id] => bankadjtype_bankadjtype_id_seq
        )

    [bankrec] => Array
        (
            [bankrec_id] => 129
            [bankrec_created] => 142
            [bankrec_username] => 162
            [bankrec_bankaccnt_id] => 1
            [bankrec_opendate] => 6
            [bankrec_enddate] => 6
            [bankrec_openbal] => 1
            [bankrec_endbal] => 1
            [bankrec_posted] => 18
            [bankrec_postdate] => 14
        )

    [bankrec__keys] => Array
        (
            [bankrec_id] => bankrec_bankrec_id_seq
        )

    [bankrecitem] => Array
        (
            [bankrecitem_id] => 129
            [bankrecitem_bankrec_id] => 129
            [bankrecitem_source] => 162
            [bankrecitem_source_id] => 129
            [bankrecitem_cleared] => 18
            [bankrecitem_curr_rate] => 1
            [bankrecitem_amount] => 1
        )

    [bankrecitem__keys] => Array
        (
            [bankrecitem_id] => bankrecitem_bankrecitem_id_seq
        )

    [bomhead] => Array
        (
            [bomhead_id] => 129
            [bomhead_item_id] => 129
            [bomhead_serial] => 1
            [bomhead_docnum] => 34
            [bomhead_revision] => 34
            [bomhead_revisiondate] => 6
            [bomhead_batchsize] => 1
            [bomhead_requiredqtyper] => 1
            [bomhead_rev_id] => 1
        )

    [bomhead__keys] => Array
        (
            [bomhead_id] => bomhead_bomhead_id_seq
        )

    [bomitem] => Array
        (
            [bomitem_id] => 129
            [bomitem_parent_item_id] => 129
            [bomitem_seqnumber] => 1
            [bomitem_item_id] => 129
            [bomitem_qtyper] => 129
            [bomitem_scrap] => 129
            [bomitem_status] => 2
            [bomitem_effective] => 134
            [bomitem_expires] => 134
            [bomitem_createwo] => 146
            [bomitem_issuemethod] => 130
            [bomitem_schedatwooper] => 146
            [bomitem_ecn] => 34
            [bomitem_moddate] => 6
            [bomitem_subtype] => 130
            [bomitem_uom_id] => 129
            [bomitem_rev_id] => 1
            [bomitem_booitem_seq_id] => 1
            [bomitem_char_id] => 1
            [bomitem_value] => 34
            [bomitem_notes] => 34
            [bomitem_ref] => 34
            [bomitem_qtyfxd] => 129
        )

    [bomitem__keys] => Array
        (
            [bomitem_id] => bomitem_bomitem_id_seq
        )

    [bomitemsub] => Array
        (
            [bomitemsub_id] => 129
            [bomitemsub_bomitem_id] => 129
            [bomitemsub_item_id] => 129
            [bomitemsub_uomratio] => 129
            [bomitemsub_rank] => 129
        )

    [bomitemsub__keys] => Array
        (
            [bomitemsub_id] => bomitemsub_bomitemsub_id_seq
        )

    [bomwork] => Array
        (
            [bomwork_id] => 129
            [bomwork_set_id] => 1
            [bomwork_seqnumber] => 1
            [bomwork_item_id] => 1
            [bomwork_item_type] => 2
            [bomwork_qtyper] => 1
            [bomwork_scrap] => 1
            [bomwork_status] => 2
            [bomwork_level] => 1
            [bomwork_parent_id] => 1
            [bomwork_effective] => 6
            [bomwork_expires] => 6
            [bomwork_stdunitcost] => 1
            [bomwork_actunitcost] => 1
            [bomwork_parent_seqnumber] => 1
            [bomwork_createwo] => 18
            [bomwork_issuemethod] => 2
            [bomwork_char_id] => 1
            [bomwork_value] => 34
            [bomwork_notes] => 34
            [bomwork_ref] => 34
            [bomwork_bomitem_id] => 1
            [bomwork_ecn] => 34
            [bomwork_qtyfxd] => 129
            [bomwork_qtyreq] => 129
        )

    [bomwork__keys] => Array
        (
            [bomwork_id] => bomwork_bomwork_id_seq
        )

    [budghead] => Array
        (
            [budghead_id] => 129
            [budghead_name] => 162
            [budghead_descrip] => 34
        )

    [budghead__keys] => Array
        (
            [budghead_id] => budghead_budghead_id_seq
        )

    [budgitem] => Array
        (
            [budgitem_id] => 129
            [budgitem_budghead_id] => 129
            [budgitem_period_id] => 129
            [budgitem_accnt_id] => 129
            [budgitem_amount] => 129
        )

    [budgitem__keys] => Array
        (
            [budgitem_id] => budgitem_budgitem_id_seq
        )

    [calhead] => Array
        (
            [calhead_id] => 129
            [calhead_type] => 2
            [calhead_name] => 34
            [calhead_descrip] => 34
            [calhead_origin] => 2
        )

    [calhead__keys] => Array
        (
            [calhead_id] => calhead_calhead_id_seq
        )

    [cashrcpt] => Array
        (
            [cashrcpt_id] => 129
            [cashrcpt_cust_id] => 129
            [cashrcpt_amount] => 129
            [cashrcpt_fundstype] => 130
            [cashrcpt_docnumber] => 34
            [cashrcpt_bankaccnt_id] => 129
            [cashrcpt_notes] => 34
            [cashrcpt_distdate] => 6
            [cashrcpt_salescat_id] => 1
            [cashrcpt_curr_id] => 1
            [cashrcpt_usecustdeposit] => 146
            [cashrcpt_void] => 146
            [cashrcpt_number] => 34
            [cashrcpt_docdate] => 6
            [cashrcpt_posted] => 146
            [cashrcpt_posteddate] => 6
            [cashrcpt_postedby] => 34
            [cashrcpt_applydate] => 6
            [cashrcpt_discount] => 129
            [cashrcpt_curr_rate] => 129
        )

    [cashrcpt__keys] => Array
        (
            [cashrcpt_id] => cashrcpt_cashrcpt_id_seq
        )

    [cashrcptitem] => Array
        (
            [cashrcptitem_id] => 129
            [cashrcptitem_cashrcpt_id] => 129
            [cashrcptitem_aropen_id] => 129
            [cashrcptitem_amount] => 129
            [cashrcptitem_discount] => 129
            [cashrcptitem_applied] => 18
        )

    [cashrcptitem__keys] => Array
        (
            [cashrcptitem_id] => cashrcptitem_cashrcptitem_id_seq
        )

    [cashrcptmisc] => Array
        (
            [cashrcptmisc_id] => 129
            [cashrcptmisc_cashrcpt_id] => 129
            [cashrcptmisc_accnt_id] => 129
            [cashrcptmisc_amount] => 129
            [cashrcptmisc_notes] => 34
        )

    [cashrcptmisc__keys] => Array
        (
            [cashrcptmisc_id] => cashrcptmisc_cashrcptmisc_id_seq
        )

    [ccard] => Array
        (
            [ccard_id] => 129
            [ccard_seq] => 129
            [ccard_cust_id] => 129
            [ccard_active] => 18
            [ccard_name] => 66
            [ccard_address1] => 66
            [ccard_address2] => 66
            [ccard_city] => 66
            [ccard_state] => 66
            [ccard_zip] => 66
            [ccard_country] => 66
            [ccard_number] => 66
            [ccard_debit] => 18
            [ccard_month_expired] => 66
            [ccard_year_expired] => 66
            [ccard_type] => 130
            [ccard_date_added] => 142
            [ccard_lastupdated] => 142
            [ccard_added_by_username] => 162
            [ccard_last_updated_by_username] => 162
        )

    [ccard__keys] => Array
        (
            [ccard_id] => ccard_ccard_id_seq
        )

    [ccardaud] => Array
        (
            [ccardaud_id] => 129
            [ccardaud_ccard_id] => 1
            [ccardaud_ccard_seq_old] => 1
            [ccardaud_ccard_seq_new] => 1
            [ccardaud_ccard_cust_id_old] => 1
            [ccardaud_ccard_cust_id_new] => 1
            [ccardaud_ccard_active_old] => 18
            [ccardaud_ccard_active_new] => 18
            [ccardaud_ccard_name_old] => 66
            [ccardaud_ccard_name_new] => 66
            [ccardaud_ccard_address1_old] => 66
            [ccardaud_ccard_address1_new] => 66
            [ccardaud_ccard_address2_old] => 66
            [ccardaud_ccard_address2_new] => 66
            [ccardaud_ccard_city_old] => 66
            [ccardaud_ccard_city_new] => 66
            [ccardaud_ccard_state_old] => 66
            [ccardaud_ccard_state_new] => 66
            [ccardaud_ccard_zip_old] => 66
            [ccardaud_ccard_zip_new] => 66
            [ccardaud_ccard_country_old] => 66
            [ccardaud_ccard_country_new] => 66
            [ccardaud_ccard_number_old] => 66
            [ccardaud_ccard_number_new] => 66
            [ccardaud_ccard_debit_old] => 18
            [ccardaud_ccard_debit_new] => 18
            [ccardaud_ccard_month_expired_old] => 66
            [ccardaud_ccard_month_expired_new] => 66
            [ccardaud_ccard_year_expired_old] => 66
            [ccardaud_ccard_year_expired_new] => 66
            [ccardaud_ccard_type_old] => 2
            [ccardaud_ccard_type_new] => 2
            [ccardaud_ccard_last_updated] => 142
            [ccardaud_ccard_last_updated_by_username] => 162
        )

    [ccardaud__keys] => Array
        (
            [ccardaud_id] => ccardaud_ccardaud_id_seq
        )

    [ccbank] => Array
        (
            [ccbank_id] => 129
            [ccbank_ccard_type] => 162
            [ccbank_bankaccnt_id] => 1
        )

    [ccbank__keys] => Array
        (
            [ccbank_id] => ccbank_ccbank_id_seq
        )

    [ccpay] => Array
        (
            [ccpay_id] => 129
            [ccpay_ccard_id] => 1
            [ccpay_cust_id] => 1
            [ccpay_amount] => 129
            [ccpay_auth] => 146
            [ccpay_status] => 130
            [ccpay_type] => 130
            [ccpay_auth_charge] => 130
            [ccpay_order_number] => 34
            [ccpay_order_number_seq] => 1
            [ccpay_r_avs] => 34
            [ccpay_r_ordernum] => 34
            [ccpay_r_error] => 34
            [ccpay_r_approved] => 34
            [ccpay_r_code] => 34
            [ccpay_r_message] => 34
            [ccpay_yp_r_time] => 14
            [ccpay_r_ref] => 34
            [ccpay_yp_r_tdate] => 34
            [ccpay_r_tax] => 34
            [ccpay_r_shipping] => 34
            [ccpay_yp_r_score] => 1
            [ccpay_transaction_datetime] => 142
            [ccpay_by_username] => 162
            [ccpay_curr_id] => 1
            [ccpay_ccpay_id] => 1
        )

    [ccpay__keys] => Array
        (
            [ccpay_id] => ccpay_ccpay_id_seq
        )

    [char] => Array
        (
            [char_id] => 129
            [char_name] => 162
            [char_items] => 18
            [char_options] => 18
            [char_attributes] => 18
            [char_lotserial] => 18
            [char_notes] => 34
            [char_customers] => 18
            [char_crmaccounts] => 18
            [char_addresses] => 18
            [char_contacts] => 18
            [char_opportunity] => 18
            [char_employees] => 18
            [char_mask] => 34
            [char_validator] => 34
            [char_incidents] => 18
            [char_type] => 129
            [char_order] => 129
            [char_search] => 146
        )

    [char__keys] => Array
        (
            [char_id] => char_char_id_seq
        )

    [charass] => Array
        (
            [charass_id] => 129
            [charass_target_type] => 34
            [charass_target_id] => 1
            [charass_char_id] => 1
            [charass_value] => 34
            [charass_default] => 146
            [charass_price] => 129
        )

    [charass__keys] => Array
        (
            [charass_id] => charass_charass_id_seq
        )

    [charopt] => Array
        (
            [charopt_id] => 129
            [charopt_char_id] => 1
            [charopt_value] => 162
            [charopt_order] => 129
        )

    [charopt__keys] => Array
        (
            [charopt_id] => charopt_charopt_id_seq
        )

    [checkhead] => Array
        (
            [checkhead_id] => 129
            [checkhead_recip_id] => 129
            [checkhead_recip_type] => 162
            [checkhead_bankaccnt_id] => 129
            [checkhead_printed] => 146
            [checkhead_checkdate] => 134
            [checkhead_number] => 129
            [checkhead_amount] => 129
            [checkhead_void] => 146
            [checkhead_replaced] => 146
            [checkhead_posted] => 146
            [checkhead_rec] => 146
            [checkhead_misc] => 146
            [checkhead_expcat_id] => 1
            [checkhead_for] => 162
            [checkhead_notes] => 162
            [checkhead_journalnumber] => 1
            [checkhead_curr_id] => 129
            [checkhead_deleted] => 146
            [checkhead_ach_batch] => 34
            [checkhead_curr_rate] => 129
            [checkhead_oldid] => 1
            [checkhead_voided] => 6
        )

    [checkhead__keys] => Array
        (
            [checkhead_id] => checkhead_checkhead_id_seq
        )

    [checkitem] => Array
        (
            [checkitem_id] => 129
            [checkitem_checkhead_id] => 129
            [checkitem_amount] => 129
            [checkitem_discount] => 129
            [checkitem_ponumber] => 34
            [checkitem_vouchernumber] => 34
            [checkitem_invcnumber] => 34
            [checkitem_apopen_id] => 1
            [checkitem_aropen_id] => 1
            [checkitem_docdate] => 6
            [checkitem_curr_id] => 129
            [checkitem_cmnumber] => 34
            [checkitem_ranumber] => 34
            [checkitem_curr_rate] => 1
        )

    [checkitem__keys] => Array
        (
            [checkitem_id] => checkitem_checkitem_id_seq
        )

    [classcode] => Array
        (
            [classcode_id] => 129
            [classcode_code] => 34
            [classcode_descrip] => 34
            [classcode_mfg] => 18
            [classcode_creator] => 34
            [classcode_created] => 14
            [classcode_modifier] => 34
            [classcode_modified] => 14
            [classcode_type] => 34
        )

    [classcode__keys] => Array
        (
            [classcode_id] => classcode_classcode_id_seq
        )

    [cmd] => Array
        (
            [cmd_id] => 129
            [cmd_module] => 162
            [cmd_title] => 162
            [cmd_descrip] => 34
            [cmd_privname] => 34
            [cmd_executable] => 162
            [cmd_name] => 34
        )

    [cmd__keys] => Array
        (
            [cmd_id] => cmd_cmd_id_seq
        )

    [cmdarg] => Array
        (
            [cmdarg_id] => 129
            [cmdarg_cmd_id] => 129
            [cmdarg_order] => 129
            [cmdarg_arg] => 162
        )

    [cmdarg__keys] => Array
        (
            [cmdarg_id] => cmdarg_cmdarg_id_seq
        )

    [cmhead] => Array
        (
            [cmhead_id] => 129
            [cmhead_number] => 34
            [cmhead_posted] => 18
            [cmhead_invcnumber] => 34
            [cmhead_custponumber] => 34
            [cmhead_cust_id] => 1
            [cmhead_docdate] => 6
            [cmhead_shipto_id] => 1
            [cmhead_shipto_name] => 34
            [cmhead_shipto_address1] => 34
            [cmhead_shipto_address2] => 34
            [cmhead_shipto_address3] => 34
            [cmhead_shipto_city] => 34
            [cmhead_shipto_state] => 34
            [cmhead_shipto_zipcode] => 34
            [cmhead_salesrep_id] => 1
            [cmhead_freight] => 1
            [cmhead_misc] => 1
            [cmhead_comments] => 34
            [cmhead_printed] => 18
            [cmhead_billtoname] => 34
            [cmhead_billtoaddress1] => 34
            [cmhead_billtoaddress2] => 34
            [cmhead_billtoaddress3] => 34
            [cmhead_billtocity] => 34
            [cmhead_billtostate] => 34
            [cmhead_billtozip] => 34
            [cmhead_hold] => 18
            [cmhead_commission] => 1
            [cmhead_misc_accnt_id] => 1
            [cmhead_misc_descrip] => 34
            [cmhead_rsncode_id] => 1
            [cmhead_curr_id] => 1
            [cmhead_freighttaxtype_id] => 1
            [cmhead_gldistdate] => 6
            [cmhead_billtocountry] => 34
            [cmhead_shipto_country] => 34
            [cmhead_rahead_id] => 1
            [cmhead_taxzone_id] => 1
            [cmhead_prj_id] => 1
            [cmhead_void] => 18
            [cmhead_billto_cntct_id] => 1
            [cmhead_billto_addr_id] => 1
            [cmhead_location_id] => 1
        )

    [cmhead__keys] => Array
        (
            [cmhead_id] => cmhead_cmhead_id_seq
        )

    [cmheadtax] => Array
        (
            [taxhist_id] => 129
            [taxhist_parent_id] => 129
            [taxhist_taxtype_id] => 1
            [taxhist_tax_id] => 129
            [taxhist_basis] => 129
            [taxhist_basis_tax_id] => 1
            [taxhist_sequence] => 1
            [taxhist_percent] => 129
            [taxhist_amount] => 129
            [taxhist_tax] => 129
            [taxhist_docdate] => 134
            [taxhist_distdate] => 6
            [taxhist_curr_id] => 1
            [taxhist_curr_rate] => 1
            [taxhist_journalnumber] => 1
        )

    [cmheadtax__keys] => Array
        (
            [taxhist_id] => taxhist_taxhist_id_seq
        )

    [cmitem] => Array
        (
            [cmitem_id] => 129
            [cmitem_cmhead_id] => 129
            [cmitem_linenumber] => 129
            [cmitem_itemsite_id] => 129
            [cmitem_qtycredit] => 129
            [cmitem_qtyreturned] => 129
            [cmitem_unitprice] => 129
            [cmitem_comments] => 34
            [cmitem_rsncode_id] => 1
            [cmitem_taxtype_id] => 1
            [cmitem_qty_uom_id] => 129
            [cmitem_qty_invuomratio] => 129
            [cmitem_price_uom_id] => 129
            [cmitem_price_invuomratio] => 129
            [cmitem_raitem_id] => 1
            [cmitem_updateinv] => 146
        )

    [cmitem__keys] => Array
        (
            [cmitem_id] => cmitem_cmitem_id_seq
        )

    [cmitemtax] => Array
        (
            [taxhist_id] => 129
            [taxhist_parent_id] => 129
            [taxhist_taxtype_id] => 1
            [taxhist_tax_id] => 129
            [taxhist_basis] => 129
            [taxhist_basis_tax_id] => 1
            [taxhist_sequence] => 1
            [taxhist_percent] => 129
            [taxhist_amount] => 129
            [taxhist_tax] => 129
            [taxhist_docdate] => 134
            [taxhist_distdate] => 6
            [taxhist_curr_id] => 1
            [taxhist_curr_rate] => 1
            [taxhist_journalnumber] => 1
        )

    [cmitemtax__keys] => Array
        (
            [taxhist_id] => taxhist_taxhist_id_seq
        )

    [cmnttype] => Array
        (
            [cmnttype_id] => 129
            [cmnttype_name] => 162
            [cmnttype_descrip] => 162
            [cmnttype_usedin] => 34
            [cmnttype_sys] => 146
            [cmnttype_editable] => 146
            [cmnttype_order] => 1
        )

    [cmnttype__keys] => Array
        (
            [cmnttype_id] => cmnttype_cmnttype_id_seq
        )

    [cmnttypesource] => Array
        (
            [cmnttypesource_id] => 129
            [cmnttypesource_cmnttype_id] => 1
            [cmnttypesource_source_id] => 1
        )

    [cmnttypesource__keys] => Array
        (
            [cmnttypesource_id] => cmnttypesource_cmnttypesource_id_seq
        )

    [cms_category_type] => Array
        (
            [id] => 129
            [name] => 130
        )

    [cms_category_type__keys] => Array
        (
            [id] => cms_category_type_seq
        )

    [cms_page] => Array
        (
            [id] => 129
            [title] => 130
            [published] => 14
            [body] => 34
            [comments_no] => 129
            [trackbacks_no] => 129
            [extended] => 34
            [has_extended] => 129
            [author_id] => 129
            [category_id] => 129
            [is_draft] => 129
            [updated] => 142
            [created] => 142
            [to_replace_id] => 129
            [page_link] => 130
            [keywords] => 162
            [descriptions] => 130
            [in_rss] => 129
            [parent_id] => 129
            [language] => 130
            [is_attachment] => 1
            [is_menuitem] => 1
            [menu_page_id] => 1
            [template_id] => 1
            [element_id] => 1
            [category_type_id] => 129
            [page_type_id] => 129
            [translation_of_id] => 129
            [is_system_page] => 129
            [is_static] => 129
            [seq_id] => 129
            [category_page_id] => 1
            [is_deleted] => 129
            [extra_css] => 34
            [is_element] => 1
            [tpl_name] => 2
            [target_url] => 130
        )

    [cms_page__keys] => Array
        (
            [id] => cms_page_seq
        )

    [cms_rssaggr] => Array
        (
            [id] => 129
            [extid] => 130
            [published_dt] => 14
            [headline] => 34
            [body] => 34
            [src_id] => 129
            [url] => 162
            [author] => 130
            [source] => 130
            [is_displayed] => 129
        )

    [cms_rssaggr__keys] => Array
        (
            [id] => cms_rssaggr_seq
        )

    [cms_template] => Array
        (
            [id] => 129
            [template] => 130
            [updated] => 142
            [lang] => 130
            [view_name] => 130
        )

    [cms_template__keys] => Array
        (
            [id] => cms_template_seq
        )

    [cms_template_element] => Array
        (
            [id] => 129
            [name] => 130
            [template_id] => 129
        )

    [cms_template_element__keys] => Array
        (
            [id] => cms_template_element_seq
        )

    [cms_templatestr] => Array
        (
            [id] => 129
            [txt] => 162
            [updated] => 142
            [src_id] => 129
            [lang] => 130
            [active] => 129
            [mdsum] => 130
            [template_id] => 129
            [on_table] => 2
            [on_id] => 1
            [on_col] => 2
        )

    [cms_templatestr__keys] => Array
        (
            [id] => cms_templatestr_seq
        )

    [cntct] => Array
        (
            [cntct_id] => 129
            [cntct_crmacct_id] => 1
            [cntct_addr_id] => 1
            [cntct_first_name] => 34
            [cntct_last_name] => 34
            [cntct_honorific] => 34
            [cntct_initials] => 34
            [cntct_active] => 18
            [cntct_phone] => 34
            [cntct_phone2] => 34
            [cntct_fax] => 34
            [cntct_email] => 34
            [cntct_webaddr] => 34
            [cntct_notes] => 34
            [cntct_title] => 34
            [cntct_number] => 162
            [cntct_middle] => 34
            [cntct_suffix] => 34
            [cntct_owner_username] => 34
            [cntct_name] => 34
            [cntct_id_card] => 162
        )

    [cntct__keys] => Array
        (
            [cntct_id] => cntct_cntct_id_seq
        )

    [cntctaddr] => Array
        (
            [cntctaddr_id] => 129
            [cntctaddr_cntct_id] => 1
            [cntctaddr_primary] => 146
            [cntctaddr_addr_id] => 129
            [cntctaddr_type] => 130
        )

    [cntctaddr__keys] => Array
        (
            [cntctaddr_id] => cntctaddr_cntctaddr_id_seq
        )

    [cntctdata] => Array
        (
            [cntctdata_id] => 129
            [cntctdata_cntct_id] => 1
            [cntctdata_primary] => 146
            [cntctdata_text] => 162
            [cntctdata_type] => 130
        )

    [cntctdata__keys] => Array
        (
            [cntctdata_id] => cntctdata_cntctdata_id_seq
        )

    [cntcteml] => Array
        (
            [cntcteml_id] => 129
            [cntcteml_cntct_id] => 1
            [cntcteml_primary] => 146
            [cntcteml_email] => 162
        )

    [cntcteml__keys] => Array
        (
            [cntcteml_id] => cntcteml_cntcteml_id_seq
        )

    [cntctmrgd] => Array
        (
            [cntctmrgd_cntct_id] => 129
            [cntctmrgd_error] => 18
        )

    [cntctmrgd__keys] => Array
        (
            [cntctmrgd_cntct_id] => K
        )

    [cntctsel] => Array
        (
            [cntctsel_cntct_id] => 129
            [cntctsel_target] => 18
            [cntctsel_mrg_crmacct_id] => 18
            [cntctsel_mrg_addr_id] => 18
            [cntctsel_mrg_first_name] => 18
            [cntctsel_mrg_last_name] => 18
            [cntctsel_mrg_honorific] => 18
            [cntctsel_mrg_initials] => 18
            [cntctsel_mrg_phone] => 18
            [cntctsel_mrg_phone2] => 18
            [cntctsel_mrg_fax] => 18
            [cntctsel_mrg_email] => 18
            [cntctsel_mrg_webaddr] => 18
            [cntctsel_mrg_notes] => 18
            [cntctsel_mrg_title] => 18
            [cntctsel_mrg_middle] => 18
            [cntctsel_mrg_suffix] => 18
            [cntctsel_mrg_owner_username] => 18
        )

    [cntctsel__keys] => Array
        (
            [cntctsel_cntct_id] => K
        )

    [cntslip] => Array
        (
            [cntslip_id] => 129
            [cntslip_cnttag_id] => 1
            [cntslip_entered] => 2
            [cntslip_posted] => 18
            [cntslip_number] => 34
            [cntslip_qty] => 1
            [cntslip_comments] => 34
            [cntslip_location_id] => 1
            [cntslip_lotserial] => 34
            [cntslip_lotserial_expiration] => 6
            [cntslip_lotserial_warrpurc] => 6
            [cntslip_username] => 34
        )

    [cntslip__keys] => Array
        (
            [cntslip_id] => cntslip_cntslip_id_seq
        )

    [cobapply] => Array
        (
            [cobapply_id] => 129
            [cobapply_cobmisc_id] => 1
            [cobapply_aropen_id] => 1
            [cobapply_applied] => 18
        )

    [cobapply__keys] => Array
        (
            [cobapply_id] => cobapply_id_seq
        )

    [cobill] => Array
        (
            [cobill_id] => 129
            [cobill_coitem_id] => 1
            [cobill_selectdate] => 2
            [cobill_qty] => 1
            [cobill_invcnum] => 1
            [cobill_toclose] => 18
            [cobill_cobmisc_id] => 1
            [cobill_select_username] => 34
            [cobill_invcitem_id] => 1
            [cobill_taxtype_id] => 1
        )

    [cobill__keys] => Array
        (
            [cobill_id] => cobill_cobill_id_seq
        )

    [cobilltax] => Array
        (
            [taxhist_id] => 129
            [taxhist_parent_id] => 129
            [taxhist_taxtype_id] => 1
            [taxhist_tax_id] => 129
            [taxhist_basis] => 129
            [taxhist_basis_tax_id] => 1
            [taxhist_sequence] => 1
            [taxhist_percent] => 129
            [taxhist_amount] => 129
            [taxhist_tax] => 129
            [taxhist_docdate] => 134
            [taxhist_distdate] => 6
            [taxhist_curr_id] => 1
            [taxhist_curr_rate] => 1
            [taxhist_journalnumber] => 1
        )

    [cobilltax__keys] => Array
        (
            [taxhist_id] => taxhist_taxhist_id_seq
        )

    [cobmisc] => Array
        (
            [cobmisc_id] => 129
            [cobmisc_cohead_id] => 1
            [cobmisc_shipvia] => 34
            [cobmisc_freight] => 1
            [cobmisc_misc] => 1
            [cobmisc_payment] => 1
            [cobmisc_paymentref] => 34
            [cobmisc_notes] => 34
            [cobmisc_shipdate] => 6
            [cobmisc_invcnumber] => 1
            [cobmisc_invcdate] => 6
            [cobmisc_posted] => 18
            [cobmisc_misc_accnt_id] => 1
            [cobmisc_misc_descrip] => 34
            [cobmisc_closeorder] => 18
            [cobmisc_curr_id] => 1
            [cobmisc_invchead_id] => 1
            [cobmisc_taxzone_id] => 1
            [cobmisc_taxtype_id] => 1
            [cobmisc_oldid] => 1
            [cobmisc_rev] => 1
        )

    [cobmisc__keys] => Array
        (
            [cobmisc_id] => cobmisc_cobmisc_id_seq
        )

    [cobmisctax] => Array
        (
            [taxhist_id] => 129
            [taxhist_parent_id] => 129
            [taxhist_taxtype_id] => 1
            [taxhist_tax_id] => 129
            [taxhist_basis] => 129
            [taxhist_basis_tax_id] => 1
            [taxhist_sequence] => 1
            [taxhist_percent] => 129
            [taxhist_amount] => 129
            [taxhist_tax] => 129
            [taxhist_docdate] => 134
            [taxhist_distdate] => 6
            [taxhist_curr_id] => 1
            [taxhist_curr_rate] => 1
            [taxhist_journalnumber] => 1
        )

    [cobmisctax__keys] => Array
        (
            [taxhist_id] => taxhist_taxhist_id_seq
        )

    [cohead] => Array
        (
            [cohead_id] => 129
            [cohead_number] => 34
            [cohead_cust_id] => 129
            [cohead_custponumber] => 34
            [cohead_type] => 2
            [cohead_orderdate] => 6
            [cohead_warehous_id] => 1
            [cohead_shipto_id] => 1
            [cohead_shiptoname] => 34
            [cohead_shiptoaddress1] => 34
            [cohead_shiptoaddress2] => 34
            [cohead_shiptoaddress3] => 34
            [cohead_shiptoaddress4] => 34
            [cohead_shiptoaddress5] => 34
            [cohead_salesrep_id] => 129
            [cohead_terms_id] => 129
            [cohead_origin] => 2
            [cohead_fob] => 34
            [cohead_shipvia] => 34
            [cohead_shiptocity] => 34
            [cohead_shiptostate] => 34
            [cohead_shiptozipcode] => 34
            [cohead_freight] => 129
            [cohead_misc] => 129
            [cohead_imported] => 18
            [cohead_ordercomments] => 34
            [cohead_shipcomments] => 34
            [cohead_shiptophone] => 34
            [cohead_shipchrg_id] => 1
            [cohead_shipform_id] => 129
            [cohead_billtoname] => 34
            [cohead_billtoaddress1] => 34
            [cohead_billtoaddress2] => 34
            [cohead_billtoaddress3] => 34
            [cohead_billtocity] => 34
            [cohead_billtostate] => 34
            [cohead_billtozipcode] => 34
            [cohead_misc_accnt_id] => 1
            [cohead_misc_descrip] => 34
            [cohead_commission] => 1
            [cohead_miscdate] => 6
            [cohead_holdtype] => 2
            [cohead_packdate] => 6
            [cohead_prj_id] => 1
            [cohead_wasquote] => 146
            [cohead_lastupdated] => 142
            [cohead_shipcomplete] => 146
            [cohead_created] => 14
            [cohead_creator] => 34
            [cohead_quote_number] => 34
            [cohead_billtocountry] => 34
            [cohead_shiptocountry] => 34
            [cohead_curr_id] => 1
            [cohead_calcfreight] => 146
            [cohead_shipto_cntct_id] => 1
            [cohead_shipto_cntct_honorific] => 34
            [cohead_shipto_cntct_first_name] => 34
            [cohead_shipto_cntct_middle] => 34
            [cohead_shipto_cntct_last_name] => 34
            [cohead_shipto_cntct_suffix] => 34
            [cohead_shipto_cntct_phone] => 34
            [cohead_shipto_cntct_title] => 34
            [cohead_shipto_cntct_fax] => 34
            [cohead_shipto_cntct_email] => 34
            [cohead_billto_cntct_id] => 1
            [cohead_billto_cntct_honorific] => 34
            [cohead_billto_cntct_first_name] => 34
            [cohead_billto_cntct_middle] => 34
            [cohead_billto_cntct_last_name] => 34
            [cohead_billto_cntct_suffix] => 34
            [cohead_billto_cntct_phone] => 34
            [cohead_billto_cntct_title] => 34
            [cohead_billto_cntct_fax] => 34
            [cohead_billto_cntct_email] => 34
            [cohead_taxzone_id] => 1
            [cohead_taxtype_id] => 1
            [cohead_ophead_id] => 1
            [cohead_status] => 130
            [cohead_display_salesrep_id] => 1
            [cohead_pretax_discount] => 129
            [cohead_posttax_discount] => 129
            [cohead_targetdate] => 6
            [cohead_location_src] => 1
            [cohead_fifo_has_error] => 18
        )

    [cohead__keys] => Array
        (
            [cohead_id] => cohead_cohead_id_seq
        )

    [cohist] => Array
        (
            [cohist_id] => 129
            [cohist_cust_id] => 1
            [cohist_itemsite_id] => 1
            [cohist_shipdate] => 6
            [cohist_shipvia] => 34
            [cohist_ordernumber] => 34
            [cohist_orderdate] => 6
            [cohist_invcnumber] => 34
            [cohist_invcdate] => 6
            [cohist_qtyshipped] => 1
            [cohist_unitprice] => 1
            [cohist_shipto_id] => 1
            [cohist_salesrep_id] => 1
            [cohist_duedate] => 6
            [cohist_imported] => 18
            [cohist_billtoname] => 34
            [cohist_billtoaddress1] => 34
            [cohist_billtoaddress2] => 34
            [cohist_billtoaddress3] => 34
            [cohist_billtocity] => 34
            [cohist_billtostate] => 34
            [cohist_billtozip] => 34
            [cohist_shiptoname] => 34
            [cohist_shiptoaddress1] => 34
            [cohist_shiptoaddress2] => 34
            [cohist_shiptoaddress3] => 34
            [cohist_shiptocity] => 34
            [cohist_shiptostate] => 34
            [cohist_shiptozip] => 34
            [cohist_commission] => 1
            [cohist_commissionpaid] => 18
            [cohist_unitcost] => 1
            [cohist_misc_type] => 2
            [cohist_misc_descrip] => 34
            [cohist_misc_id] => 1
            [cohist_doctype] => 34
            [cohist_promisedate] => 6
            [cohist_ponumber] => 34
            [cohist_curr_id] => 1
            [cohist_sequence] => 1
            [cohist_taxtype_id] => 1
            [cohist_taxzone_id] => 1
        )

    [cohist__keys] => Array
        (
            [cohist_id] => cohist_cohist_id_seq
        )

    [cohisttax] => Array
        (
            [taxhist_id] => 129
            [taxhist_parent_id] => 129
            [taxhist_taxtype_id] => 1
            [taxhist_tax_id] => 129
            [taxhist_basis] => 129
            [taxhist_basis_tax_id] => 1
            [taxhist_sequence] => 1
            [taxhist_percent] => 129
            [taxhist_amount] => 129
            [taxhist_tax] => 129
            [taxhist_docdate] => 134
            [taxhist_distdate] => 6
            [taxhist_curr_id] => 1
            [taxhist_curr_rate] => 1
            [taxhist_journalnumber] => 1
        )

    [cohisttax__keys] => Array
        (
            [taxhist_id] => taxhist_taxhist_id_seq
        )

    [coitem] => Array
        (
            [coitem_id] => 129
            [coitem_cohead_id] => 1
            [coitem_linenumber] => 129
            [coitem_itemsite_id] => 1
            [coitem_status] => 2
            [coitem_scheddate] => 6
            [coitem_promdate] => 6
            [coitem_qtyord] => 129
            [coitem_unitcost] => 129
            [coitem_price] => 129
            [coitem_custprice] => 129
            [coitem_qtyshipped] => 129
            [coitem_order_id] => 1
            [coitem_memo] => 34
            [coitem_imported] => 18
            [coitem_qtyreturned] => 1
            [coitem_closedate] => 2
            [coitem_custpn] => 34
            [coitem_order_type] => 2
            [coitem_close_username] => 34
            [coitem_lastupdated] => 142
            [coitem_substitute_item_id] => 1
            [coitem_created] => 14
            [coitem_creator] => 34
            [coitem_prcost] => 1
            [coitem_qty_uom_id] => 129
            [coitem_qty_invuomratio] => 129
            [coitem_price_uom_id] => 129
            [coitem_price_invuomratio] => 129
            [coitem_warranty] => 146
            [coitem_cos_accnt_id] => 1
            [coitem_qtyreserved] => 129
            [coitem_subnumber] => 129
            [coitem_firm] => 146
            [coitem_taxtype_id] => 1
            [coitem_location_src] => 1
            [coitem_shipto_id] => 1
        )

    [coitem__keys] => Array
        (
            [coitem_id] => coitem_coitem_id_seq
        )

    [comment] => Array
        (
            [comment_id] => 129
            [comment_source_id] => 1
            [comment_date] => 2
            [comment_user] => 34
            [comment_text] => 34
            [comment_cmnttype_id] => 1
            [comment_source] => 34
            [comment_public] => 18
        )

    [comment__keys] => Array
        (
            [comment_id] => comment_comment_id_seq
        )

    [companies] => Array
        (
            [id] => 129
            [code] => 130
            [name] => 2
            [remarks] => 34
            [owner_id] => 129
            [address] => 34
            [tel] => 2
            [fax] => 2
            [email] => 2
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
            [comptype_id] => 1
            [address1] => 34
            [address2] => 34
            [address3] => 34
            [is_system] => 129
        )

    [companies__keys] => Array
        (
            [id] => companies_seq
        )

    [company] => Array
        (
            [company_id] => 129
            [company_number] => 34
            [company_descrip] => 34
            [company_external] => 146
            [company_server] => 34
            [company_port] => 1
            [company_database] => 34
            [company_curr_id] => 1
            [company_yearend_accnt_id] => 1
            [company_gainloss_accnt_id] => 1
            [company_dscrp_accnt_id] => 1
            [company_unrlzgainloss_accnt_id] => 1
        )

    [company__keys] => Array
        (
            [company_id] => company_company_id_seq
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
            [id] => core_curr_rate_seq
        )

    [core_email] => Array
        (
            [id] => 129
            [subject] => 34
            [bodytext] => 34
            [plaintext] => 34
            [name] => 130
            [updated_dt] => 142
            [from_email] => 2
            [from_name] => 2
            [owner_id] => 129
            [is_system] => 129
        )

    [core_email__keys] => Array
        (
            [id] => core_email_seq
        )

    [core_enum] => Array
        (
            [id] => 129
            [etype] => 130
            [name] => 130
            [active] => 129
            [seqid] => 129
            [seqmax] => 129
            [display_name] => 130
            [is_system_enum] => 129
        )

    [core_enum__keys] => Array
        (
            [id] => core_enum_seq
        )

    [core_event_audit] => Array
        (
            [id] => 129
            [event_id] => 129
            [name] => 130
            [old_audit_id] => 129
            [newvalue] => 162
        )

    [core_event_audit__keys] => Array
        (
            [id] => core_event_audit_seq
        )

    [core_locking] => Array
        (
            [id] => 129
            [on_table] => 130
            [on_id] => 129
            [person_id] => 129
            [created] => 14
        )

    [core_locking__keys] => Array
        (
            [id] => core_locking_seq
        )

    [core_notify] => Array
        (
            [id] => 129
            [evtype] => 130
            [recur_id] => 129
            [act_when] => 14
            [act_start] => 14
            [onid] => 129
            [ontable] => 130
            [person_id] => 129
            [msgid] => 130
            [sent] => 14
            [event_id] => 129
            [watch_id] => 129
            [trigger_person_id] => 129
            [trigger_event_id] => 129
            [to_email] => 130
            [person_table] => 130
        )

    [core_notify__keys] => Array
        (
            [id] => core_notify_seq
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
            [last_event_id] => 1
            [method] => 2
            [method_id] => 1
        )

    [core_notify_recur__keys] => Array
        (
            [id] => core_notify_recur_seq
        )

    [core_oauth_access_tokens] => Array
        (
            [id] => 129
            [access_token] => 130
            [client_id] => 130
            [user_id] => 2
            [expires] => 142
            [scope] => 2
        )

    [core_oauth_access_tokens__keys] => Array
        (
            [id] => core_oauth_access_tokens_seq
        )

    [core_oauth_authorization_codes] => Array
        (
            [id] => 129
            [authorization_code] => 130
            [client_id] => 130
            [user_id] => 2
            [redirect_uri] => 2
            [expires] => 142
            [scope] => 2
        )

    [core_oauth_authorization_codes__keys] => Array
        (
            [id] => core_oauth_authorization_codes_seq
        )

    [core_oauth_clients] => Array
        (
            [id] => 129
            [client_id] => 130
            [client_secret] => 130
            [redirect_uri] => 130
            [grant_types] => 2
            [scope] => 2
            [user_id] => 2
        )

    [core_oauth_clients__keys] => Array
        (
            [id] => core_oauth_clients_seq
        )

    [core_oauth_jwt] => Array
        (
            [id] => 129
            [client_id] => 130
            [subject] => 2
            [public_key] => 2
        )

    [core_oauth_jwt__keys] => Array
        (
            [id] => core_oauth_jwt_seq
        )

    [core_oauth_refresh_tokens] => Array
        (
            [id] => 129
            [refresh_token] => 130
            [client_id] => 130
            [user_id] => 2
            [expires] => 142
            [scope] => 2
        )

    [core_oauth_refresh_tokens__keys] => Array
        (
            [id] => core_oauth_refresh_tokens_seq
        )

    [core_oauth_scopes] => Array
        (
            [id] => 129
            [scope] => 34
            [is_default] => 18
        )

    [core_oauth_scopes__keys] => Array
        (
            [id] => core_oauth_scopes_seq
        )

    [core_person_alias] => Array
        (
            [id] => 129
            [person_id] => 2
            [alias] => 130
        )

    [core_person_alias__keys] => Array
        (
            [id] => core_person_alias_seq
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
            [id] => core_person_signup_seq
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
            [id] => core_watch_seq
        )

    [costcat] => Array
        (
            [costcat_id] => 129
            [costcat_code] => 34
            [costcat_descrip] => 34
            [costcat_asset_accnt_id] => 1
            [costcat_liability_accnt_id] => 1
            [costcat_adjustment_accnt_id] => 1
            [costcat_matusage_accnt_id] => 1
            [costcat_purchprice_accnt_id] => 1
            [costcat_laboroverhead_accnt_id] => 1
            [costcat_scrap_accnt_id] => 1
            [costcat_invcost_accnt_id] => 1
            [costcat_wip_accnt_id] => 1
            [costcat_shipasset_accnt_id] => 1
            [costcat_mfgscrap_accnt_id] => 1
            [costcat_transform_accnt_id] => 1
            [costcat_freight_accnt_id] => 1
            [costcat_toliability_accnt_id] => 1
            [costcat_exp_accnt_id] => 1
        )

    [costcat__keys] => Array
        (
            [costcat_id] => costcat_costcat_id_seq
        )

    [costelem] => Array
        (
            [costelem_id] => 129
            [costelem_type] => 34
            [costelem_sys] => 18
            [costelem_po] => 18
            [costelem_active] => 18
            [costelem_exp_accnt_id] => 1
            [costelem_cost_item_id] => 1
        )

    [costelem__keys] => Array
        (
            [costelem_id] => costelem_costelem_id_seq
        )

    [costhist] => Array
        (
            [costhist_id] => 129
            [costhist_item_id] => 1
            [costhist_costelem_id] => 1
            [costhist_type] => 2
            [costhist_date] => 2
            [costhist_oldcost] => 1
            [costhist_newcost] => 1
            [costhist_lowlevel] => 18
            [costhist_oldcurr_id] => 1
            [costhist_newcurr_id] => 1
            [costhist_username] => 34
        )

    [costhist__keys] => Array
        (
            [costhist_id] => costhist_costhist_id_seq
        )

    [costupdate] => Array
        (
            [costupdate_item_id] => 1
            [costupdate_lowlevel_code] => 129
            [costupdate_item_type] => 2
        )

    [country] => Array
        (
            [country_id] => 129
            [country_abbr] => 2
            [country_name] => 34
            [country_curr_abbr] => 2
            [country_curr_name] => 34
            [country_curr_number] => 2
            [country_curr_symbol] => 2
            [country_qt_number] => 1
        )

    [country__keys] => Array
        (
            [country_id] => country_country_id_seq
        )

    [crmacct] => Array
        (
            [crmacct_id] => 129
            [crmacct_number] => 34
            [crmacct_name] => 34
            [crmacct_active] => 18
            [crmacct_type] => 2
            [crmacct_cust_id] => 1
            [crmacct_competitor_id] => 1
            [crmacct_partner_id] => 1
            [crmacct_prospect_id] => 1
            [crmacct_vend_id] => 1
            [crmacct_cntct_id_1] => 1
            [crmacct_cntct_id_2] => 1
            [crmacct_parent_id] => 1
            [crmacct_notes] => 34
            [crmacct_taxauth_id] => 1
            [crmacct_owner_username] => 34
            [crmacct_emp_id] => 1
            [crmacct_salesrep_id] => 1
            [crmacct_usr_username] => 34
        )

    [crmacct__keys] => Array
        (
            [crmacct_id] => crmacct_crmacct_id_seq
        )

    [crmacctsel] => Array
        (
            [crmacctsel_src_crmacct_id] => 129
            [crmacctsel_dest_crmacct_id] => 1
            [crmacctsel_mrg_crmacct_active] => 146
            [crmacctsel_mrg_crmacct_cntct_id_1] => 146
            [crmacctsel_mrg_crmacct_cntct_id_2] => 146
            [crmacctsel_mrg_crmacct_competitor_id] => 146
            [crmacctsel_mrg_crmacct_cust_id] => 146
            [crmacctsel_mrg_crmacct_emp_id] => 146
            [crmacctsel_mrg_crmacct_name] => 146
            [crmacctsel_mrg_crmacct_notes] => 146
            [crmacctsel_mrg_crmacct_owner_username] => 146
            [crmacctsel_mrg_crmacct_parent_id] => 146
            [crmacctsel_mrg_crmacct_partner_id] => 146
            [crmacctsel_mrg_crmacct_prospect_id] => 146
            [crmacctsel_mrg_crmacct_salesrep_id] => 146
            [crmacctsel_mrg_crmacct_taxauth_id] => 146
            [crmacctsel_mrg_crmacct_type] => 146
            [crmacctsel_mrg_crmacct_usr_username] => 146
            [crmacctsel_mrg_crmacct_vend_id] => 146
            [crmacctsel_mrg_crmacct_number] => 146
        )

    [crmacctsel__keys] => Array
        (
            [crmacctsel_src_crmacct_id] => K
        )

    [curr_rate] => Array
        (
            [curr_rate_id] => 129
            [curr_id] => 129
            [curr_rate] => 129
            [curr_effective] => 134
            [curr_expires] => 134
        )

    [curr_rate__keys] => Array
        (
            [curr_rate_id] => curr_rate_curr_rate_id_seq
        )

    [curr_symbol] => Array
        (
            [curr_id] => 129
            [curr_base] => 146
            [curr_name] => 130
            [curr_symbol] => 130
            [curr_abbr] => 130
        )

    [curr_symbol__keys] => Array
        (
            [curr_id] => curr_symbol_curr_id_seq
        )

    [custform] => Array
        (
            [custform_id] => 129
            [custform_custtype_id] => 1
            [custform_custtype] => 34
            [custform_invoice_report_id] => 1
            [custform_creditmemo_report_id] => 1
            [custform_quote_report_id] => 1
            [custform_packinglist_report_id] => 1
            [custform_statement_report_id] => 1
            [custform_sopicklist_report_id] => 1
            [custform_invoice_report_name] => 34
            [custform_creditmemo_report_name] => 34
            [custform_quote_report_name] => 34
            [custform_packinglist_report_name] => 34
            [custform_statement_report_name] => 34
            [custform_sopicklist_report_name] => 34
        )

    [custform__keys] => Array
        (
            [custform_id] => custform_custform_id_seq
        )

    [custgrp] => Array
        (
            [custgrp_id] => 129
            [custgrp_name] => 34
            [custgrp_descrip] => 34
        )

    [custgrp__keys] => Array
        (
            [custgrp_id] => custgrp_custgrp_id_seq
        )

    [custgrpitem] => Array
        (
            [custgrpitem_id] => 129
            [custgrpitem_custgrp_id] => 1
            [custgrpitem_cust_id] => 1
        )

    [custgrpitem__keys] => Array
        (
            [custgrpitem_id] => custgrpitem_custgrpitem_id_seq
        )

    [custinfo] => Array
        (
            [cust_id] => 129
            [cust_active] => 146
            [cust_custtype_id] => 1
            [cust_salesrep_id] => 1
            [cust_commprcnt] => 1
            [cust_name] => 34
            [cust_creditlmt] => 1
            [cust_creditrating] => 34
            [cust_financecharge] => 18
            [cust_backorder] => 146
            [cust_partialship] => 146
            [cust_terms_id] => 1
            [cust_discntprcnt] => 129
            [cust_balmethod] => 130
            [cust_ffshipto] => 146
            [cust_shipform_id] => 1
            [cust_shipvia] => 34
            [cust_blanketpos] => 146
            [cust_shipchrg_id] => 129
            [cust_creditstatus] => 130
            [cust_comments] => 34
            [cust_ffbillto] => 146
            [cust_usespos] => 146
            [cust_number] => 34
            [cust_dateadded] => 6
            [cust_exported] => 18
            [cust_emaildelivery] => 18
            [cust_ediemail] => 34
            [cust_edisubject] => 34
            [cust_edifilename] => 34
            [cust_ediemailbody] => 34
            [cust_autoupdatestatus] => 146
            [cust_autoholdorders] => 146
            [cust_edicc] => 34
            [cust_ediprofile_id] => 1
            [cust_preferred_warehous_id] => 129
            [cust_curr_id] => 1
            [cust_creditlmt_curr_id] => 1
            [cust_cntct_id] => 1
            [cust_corrcntct_id] => 1
            [cust_soemaildelivery] => 18
            [cust_soediemail] => 34
            [cust_soedisubject] => 34
            [cust_soedifilename] => 34
            [cust_soediemailbody] => 34
            [cust_soedicc] => 34
            [cust_soediprofile_id] => 1
            [cust_gracedays] => 1
            [cust_ediemailhtml] => 146
            [cust_soediemailhtml] => 146
            [cust_taxzone_id] => 1
            [cust_passwd] => 130
            [cust_login_email] => 130
            [cust_dob] => 162
            [cust_subscribed] => 146
        )

    [custinfo__keys] => Array
        (
            [cust_id] => cust_cust_id_seq
        )

    [custtype] => Array
        (
            [custtype_id] => 129
            [custtype_code] => 162
            [custtype_descrip] => 162
            [custtype_char] => 146
        )

    [custtype__keys] => Array
        (
            [custtype_id] => custtype_custtype_id_seq
        )

    [dept] => Array
        (
            [dept_id] => 129
            [dept_number] => 162
            [dept_name] => 162
        )

    [dept__keys] => Array
        (
            [dept_id] => dept_dept_id_seq
        )

    [destination] => Array
        (
            [destination_id] => 129
            [destination_name] => 34
            [destination_city] => 34
            [destination_state] => 34
            [destination_comments] => 34
        )

    [destination__keys] => Array
        (
            [destination_id] => destination_destination_id_seq
        )

    [docass] => Array
        (
            [docass_id] => 129
            [docass_source_id] => 129
            [docass_source_type] => 162
            [docass_target_id] => 129
            [docass_target_type] => 162
            [docass_purpose] => 130
        )

    [docass__keys] => Array
        (
            [docass_id] => docass_docass_id_seq
        )

    [dragon_report] => Array
        (
            [id] => 129
            [name] => 162
            [query] => 34
        )

    [dragon_report__keys] => Array
        (
            [id] => dragon_report_id_seq
        )

    [emp] => Array
        (
            [emp_id] => 129
            [emp_code] => 162
            [emp_number] => 162
            [emp_active] => 146
            [emp_cntct_id] => 1
            [emp_warehous_id] => 1
            [emp_mgr_emp_id] => 1
            [emp_wage_type] => 162
            [emp_wage] => 1
            [emp_wage_curr_id] => 1
            [emp_wage_period] => 162
            [emp_dept_id] => 1
            [emp_shift_id] => 1
            [emp_notes] => 34
            [emp_image_id] => 1
            [emp_username] => 34
            [emp_extrate] => 1
            [emp_extrate_period] => 162
            [emp_startdate] => 6
            [emp_name] => 162
        )

    [emp__keys] => Array
        (
            [emp_id] => emp_emp_id_seq
        )

    [empgrp] => Array
        (
            [empgrp_id] => 129
            [empgrp_name] => 162
            [empgrp_descrip] => 162
        )

    [empgrp__keys] => Array
        (
            [empgrp_id] => empgrp_empgrp_id_seq
        )

    [empgrpitem] => Array
        (
            [empgrpitem_id] => 129
            [empgrpitem_empgrp_id] => 129
            [empgrpitem_emp_id] => 129
        )

    [empgrpitem__keys] => Array
        (
            [empgrpitem_id] => empgrpitem_empgrpitem_id_seq
        )

    [events] => Array
        (
            [id] => 129
            [person_name] => 130
            [event_when] => 14
            [action] => 130
            [ipaddr] => 130
            [on_id] => 129
            [on_table] => 130
            [person_id] => 129
            [person_table] => 130
            [remarks] => 34
        )

    [events__keys] => Array
        (
            [id] => events_seq
        )

    [evntlog] => Array
        (
            [evntlog_id] => 129
            [evntlog_evnttime] => 2
            [evntlog_evnttype_id] => 1
            [evntlog_ord_id] => 1
            [evntlog_dispatched] => 2
            [evntlog_action] => 34
            [evntlog_warehous_id] => 1
            [evntlog_number] => 34
            [evntlog_newvalue] => 1
            [evntlog_oldvalue] => 1
            [evntlog_newdate] => 6
            [evntlog_olddate] => 6
            [evntlog_ordtype] => 2
            [evntlog_username] => 34
        )

    [evntlog__keys] => Array
        (
            [evntlog_id] => evntlog_evntlog_id_seq
        )

    [evntnot] => Array
        (
            [evntnot_id] => 129
            [evntnot_evnttype_id] => 1
            [evntnot_warehous_id] => 1
            [evntnot_username] => 34
        )

    [evntnot__keys] => Array
        (
            [evntnot_id] => evntnot_evntnot_id_seq
        )

    [evnttype] => Array
        (
            [evnttype_id] => 129
            [evnttype_name] => 34
            [evnttype_descrip] => 34
            [evnttype_module] => 34
        )

    [evnttype__keys] => Array
        (
            [evnttype_id] => evnttype_evnttype_id_seq
        )

    [expcat] => Array
        (
            [expcat_id] => 129
            [expcat_code] => 34
            [expcat_descrip] => 34
            [expcat_exp_accnt_id] => 1
            [expcat_liability_accnt_id] => 1
            [expcat_active] => 18
            [expcat_purchprice_accnt_id] => 1
            [expcat_freight_accnt_id] => 1
        )

    [expcat__keys] => Array
        (
            [expcat_id] => expcat_expcat_id_seq
        )

    [expense] => Array
        (
            [expense_id] => 129
            [expense_accnt_id] => 1
            [expense_emp_id] => 129
            [expense_number] => 162
            [expense_trandate] => 6
            [expense_created] => 6
            [expense_modified] => 6
            [expense_duedate] => 6
            [expense_memo] => 34
            [expense_comments] => 34
            [expense_status] => 34
            [expense_advance] => 1
            [expense_amount] => 1
            [expense_tax] => 1
            [expense_total] => 1
            [expense_posted] => 18
        )

    [expense__keys] => Array
        (
            [expense_id] => expense_id_seq
        )

    [expitem] => Array
        (
            [expitem_id] => 129
            [expitem_expense_id] => 129
            [expitem_curr_id] => 129
            [expitem_expcat_id] => 129
            [expitem_row] => 129
            [expitem_amount] => 1
            [expitem_amount_fc] => 1
            [expitem_tax] => 1
            [expitem_total] => 1
            [expitem_date] => 6
            [expitem_is_billable] => 1
            [expitem_memo] => 34
        )

    [expitem__keys] => Array
        (
            [expitem_id] => expitem_id_seq
        )

    [file] => Array
        (
            [file_id] => 129
            [file_title] => 162
            [file_stream] => 66
            [file_descrip] => 162
        )

    [file__keys] => Array
        (
            [file_id] => file_file_id_seq
        )

    [filter] => Array
        (
            [filter_id] => 129
            [filter_screen] => 162
            [filter_value] => 162
            [filter_username] => 34
            [filter_name] => 162
            [filter_selected] => 18
        )

    [filter__keys] => Array
        (
            [filter_id] => filter_filter_id_seq
        )

    [flcol] => Array
        (
            [flcol_id] => 129
            [flcol_flhead_id] => 129
            [flcol_name] => 34
            [flcol_descrip] => 34
            [flcol_report_id] => 1
            [flcol_month] => 18
            [flcol_quarter] => 18
            [flcol_year] => 18
            [flcol_showdb] => 18
            [flcol_prcnt] => 18
            [flcol_priortype] => 2
            [flcol_priormonth] => 18
            [flcol_priorquarter] => 18
            [flcol_prioryear] => 2
            [flcol_priorprcnt] => 18
            [flcol_priordiff] => 18
            [flcol_priordiffprcnt] => 18
            [flcol_budget] => 18
            [flcol_budgetprcnt] => 18
            [flcol_budgetdiff] => 18
            [flcol_budgetdiffprcnt] => 18
        )

    [flcol__keys] => Array
        (
            [flcol_id] => flcol_flcol_id_seq
        )

    [flgrp] => Array
        (
            [flgrp_id] => 129
            [flgrp_flhead_id] => 1
            [flgrp_flgrp_id] => 1
            [flgrp_order] => 1
            [flgrp_name] => 34
            [flgrp_descrip] => 34
            [flgrp_subtotal] => 146
            [flgrp_summarize] => 146
            [flgrp_subtract] => 146
            [flgrp_showstart] => 146
            [flgrp_showend] => 146
            [flgrp_showdelta] => 146
            [flgrp_showbudget] => 146
            [flgrp_showstartprcnt] => 146
            [flgrp_showendprcnt] => 146
            [flgrp_showdeltaprcnt] => 146
            [flgrp_showbudgetprcnt] => 146
            [flgrp_prcnt_flgrp_id] => 129
            [flgrp_showdiff] => 146
            [flgrp_showdiffprcnt] => 146
            [flgrp_showcustom] => 146
            [flgrp_showcustomprcnt] => 146
            [flgrp_usealtsubtotal] => 146
            [flgrp_altsubtotal] => 34
        )

    [flgrp__keys] => Array
        (
            [flgrp_id] => flgrp_flgrp_id_seq
        )

    [flhead] => Array
        (
            [flhead_id] => 129
            [flhead_name] => 34
            [flhead_descrip] => 34
            [flhead_showtotal] => 146
            [flhead_showstart] => 146
            [flhead_showend] => 146
            [flhead_showdelta] => 146
            [flhead_showbudget] => 146
            [flhead_showdiff] => 146
            [flhead_showcustom] => 146
            [flhead_custom_label] => 34
            [flhead_usealttotal] => 146
            [flhead_alttotal] => 34
            [flhead_usealtbegin] => 146
            [flhead_altbegin] => 34
            [flhead_usealtend] => 146
            [flhead_altend] => 34
            [flhead_usealtdebits] => 146
            [flhead_altdebits] => 34
            [flhead_usealtcredits] => 146
            [flhead_altcredits] => 34
            [flhead_usealtbudget] => 146
            [flhead_altbudget] => 34
            [flhead_usealtdiff] => 146
            [flhead_altdiff] => 34
            [flhead_type] => 130
            [flhead_active] => 146
            [flhead_sys] => 18
            [flhead_notes] => 34
        )

    [flhead__keys] => Array
        (
            [flhead_id] => flhead_flhead_id_seq
        )

    [flitem] => Array
        (
            [flitem_id] => 129
            [flitem_flhead_id] => 1
            [flitem_flgrp_id] => 1
            [flitem_order] => 1
            [flitem_accnt_id] => 1
            [flitem_showstart] => 18
            [flitem_showend] => 18
            [flitem_showdelta] => 18
            [flitem_showbudget] => 146
            [flitem_subtract] => 146
            [flitem_showstartprcnt] => 146
            [flitem_showendprcnt] => 146
            [flitem_showdeltaprcnt] => 146
            [flitem_showbudgetprcnt] => 146
            [flitem_prcnt_flgrp_id] => 129
            [flitem_showdiff] => 146
            [flitem_showdiffprcnt] => 146
            [flitem_showcustom] => 146
            [flitem_showcustomprcnt] => 146
            [flitem_custom_source] => 2
            [flitem_company] => 34
            [flitem_profit] => 34
            [flitem_number] => 34
            [flitem_sub] => 34
            [flitem_type] => 2
            [flitem_subaccnttype_code] => 34
        )

    [flitem__keys] => Array
        (
            [flitem_id] => flitem_flitem_id_seq
        )

    [flnotes] => Array
        (
            [flnotes_id] => 129
            [flnotes_flhead_id] => 1
            [flnotes_period_id] => 1
            [flnotes_notes] => 34
        )

    [flnotes__keys] => Array
        (
            [flnotes_id] => flnotes_flnotes_id_seq
        )

    [flrpt] => Array
        (
            [flrpt_flhead_id] => 129
            [flrpt_period_id] => 129
            [flrpt_username] => 162
            [flrpt_order] => 129
            [flrpt_level] => 129
            [flrpt_type] => 162
            [flrpt_type_id] => 129
            [flrpt_beginning] => 1
            [flrpt_ending] => 1
            [flrpt_debits] => 1
            [flrpt_credits] => 1
            [flrpt_budget] => 1
            [flrpt_beginningprcnt] => 1
            [flrpt_endingprcnt] => 1
            [flrpt_debitsprcnt] => 1
            [flrpt_creditsprcnt] => 1
            [flrpt_budgetprcnt] => 1
            [flrpt_parent_id] => 1
            [flrpt_diff] => 1
            [flrpt_diffprcnt] => 1
            [flrpt_custom] => 1
            [flrpt_customprcnt] => 1
            [flrpt_altname] => 34
            [flrpt_accnt_id] => 1
            [flrpt_interval] => 2
        )

    [flspec] => Array
        (
            [flspec_id] => 129
            [flspec_flhead_id] => 129
            [flspec_flgrp_id] => 129
            [flspec_order] => 129
            [flspec_name] => 34
            [flspec_type] => 34
            [flspec_showstart] => 146
            [flspec_showend] => 146
            [flspec_showdelta] => 146
            [flspec_showbudget] => 146
            [flspec_subtract] => 146
            [flspec_showstartprcnt] => 146
            [flspec_showendprcnt] => 146
            [flspec_showdeltaprcnt] => 146
            [flspec_showbudgetprcnt] => 146
            [flspec_showdiff] => 146
            [flspec_showdiffprcnt] => 146
            [flspec_prcnt_flgrp_id] => 129
            [flspec_showcustom] => 146
            [flspec_showcustomprcnt] => 146
            [flspec_custom_source] => 2
        )

    [flspec__keys] => Array
        (
            [flspec_id] => flspec_flspec_id_seq
        )

    [form] => Array
        (
            [form_id] => 129
            [form_name] => 34
            [form_descrip] => 34
            [form_report_id] => 1
            [form_key] => 2
            [form_report_name] => 34
        )

    [form__keys] => Array
        (
            [form_id] => form_form_id_seq
        )

    [freightclass] => Array
        (
            [freightclass_id] => 129
            [freightclass_code] => 162
            [freightclass_descrip] => 34
        )

    [freightclass__keys] => Array
        (
            [freightclass_id] => freightclass_freightclass_id_seq
        )

    [glseries] => Array
        (
            [glseries_id] => 129
            [glseries_sequence] => 1
            [glseries_doctype] => 2
            [glseries_docnumber] => 34
            [glseries_accnt_id] => 1
            [glseries_amount] => 1
            [glseries_source] => 34
            [glseries_distdate] => 6
            [glseries_notes] => 34
            [glseries_misc_id] => 1
        )

    [glseries__keys] => Array
        (
            [glseries_id] => glseries_glseries_id_seq
        )

    [gltrans] => Array
        (
            [gltrans_id] => 129
            [gltrans_exported] => 18
            [gltrans_created] => 2
            [gltrans_date] => 134
            [gltrans_sequence] => 1
            [gltrans_accnt_id] => 129
            [gltrans_source] => 34
            [gltrans_docnumber] => 34
            [gltrans_misc_id] => 1
            [gltrans_amount] => 129
            [gltrans_notes] => 34
            [gltrans_journalnumber] => 1
            [gltrans_posted] => 146
            [gltrans_doctype] => 34
            [gltrans_rec] => 146
            [gltrans_username] => 162
            [gltrans_deleted] => 18
        )

    [gltrans__keys] => Array
        (
            [gltrans_id] => gltrans_gltrans_id_seq
        )

    [group_members] => Array
        (
            [id] => 129
            [group_id] => 1
            [user_id] => 129
        )

    [group_members__keys] => Array
        (
            [id] => group_members_seq
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
            [id] => group_rights_seq
        )

    [groups] => Array
        (
            [id] => 129
            [name] => 130
            [type] => 129
            [leader] => 129
        )

    [groups__keys] => Array
        (
            [id] => groups_seq
        )

    [grp] => Array
        (
            [grp_id] => 129
            [grp_name] => 162
            [grp_descrip] => 34
        )

    [grp__keys] => Array
        (
            [grp_id] => grp_grp_id_seq
        )

    [grppriv] => Array
        (
            [grppriv_id] => 129
            [grppriv_grp_id] => 129
            [grppriv_priv_id] => 129
        )

    [grppriv__keys] => Array
        (
            [grppriv_id] => grppriv_grppriv_id_seq
        )

    [hnfc] => Array
        (
            [hnfc_id] => 129
            [hnfc_code] => 34
        )

    [hnfc__keys] => Array
        (
            [hnfc_id] => hnfc_hnfc_id_seq
        )

    [i18n] => Array
        (
            [id] => 129
            [ltype] => 130
            [lkey] => 130
            [inlang] => 130
            [lval] => 130
            [is_active] => 129
        )

    [i18n__keys] => Array
        (
            [id] => i18n_seq
        )

    [image] => Array
        (
            [image_id] => 129
            [image_name] => 34
            [image_descrip] => 34
            [image_data] => 34
        )

    [image__keys] => Array
        (
            [image_id] => image_image_id_seq
        )

    [imageass] => Array
        (
            [imageass_id] => 129
            [imageass_source_id] => 129
            [imageass_source] => 162
            [imageass_image_id] => 129
            [imageass_purpose] => 130
        )

    [imageass__keys] => Array
        (
            [imageass_id] => docass_docass_id_seq
        )

    [images] => Array
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
            [created] => 14
            [imgtype] => 130
            [linkurl] => 130
            [descript] => 162
            [title] => 130
        )

    [images__keys] => Array
        (
            [id] => images_seq
        )

    [incdt] => Array
        (
            [incdt_id] => 129
            [incdt_number] => 129
            [incdt_crmacct_id] => 1
            [incdt_cntct_id] => 1
            [incdt_summary] => 34
            [incdt_descrip] => 34
            [incdt_item_id] => 1
            [incdt_timestamp] => 142
            [incdt_status] => 130
            [incdt_assigned_username] => 34
            [incdt_incdtcat_id] => 1
            [incdt_incdtseverity_id] => 1
            [incdt_incdtpriority_id] => 1
            [incdt_incdtresolution_id] => 1
            [incdt_lotserial] => 34
            [incdt_ls_id] => 1
            [incdt_aropen_id] => 1
            [incdt_owner_username] => 34
            [incdt_recurring_incdt_id] => 1
            [incdt_updated] => 142
            [incdt_prj_id] => 1
            [incdt_public] => 18
        )

    [incdt__keys] => Array
        (
            [incdt_id] => incdt_incdt_id_seq
        )

    [incdtcat] => Array
        (
            [incdtcat_id] => 129
            [incdtcat_name] => 162
            [incdtcat_order] => 1
            [incdtcat_descrip] => 34
            [incdtcat_ediprofile_id] => 1
        )

    [incdtcat__keys] => Array
        (
            [incdtcat_id] => incdtcat_incdtcat_id_seq
        )

    [incdthist] => Array
        (
            [incdthist_id] => 129
            [incdthist_incdt_id] => 129
            [incdthist_change] => 2
            [incdthist_target_id] => 1
            [incdthist_timestamp] => 142
            [incdthist_username] => 162
            [incdthist_descrip] => 34
        )

    [incdthist__keys] => Array
        (
            [incdthist_id] => incdthist_incdthist_id_seq
        )

    [incdtpriority] => Array
        (
            [incdtpriority_id] => 129
            [incdtpriority_name] => 162
            [incdtpriority_order] => 1
            [incdtpriority_descrip] => 34
        )

    [incdtpriority__keys] => Array
        (
            [incdtpriority_id] => incdtpriority_incdtpriority_id_seq
        )

    [incdtresolution] => Array
        (
            [incdtresolution_id] => 129
            [incdtresolution_name] => 162
            [incdtresolution_order] => 1
            [incdtresolution_descrip] => 34
        )

    [incdtresolution__keys] => Array
        (
            [incdtresolution_id] => incdtresolution_incdtresolution_id_seq
        )

    [incdtseverity] => Array
        (
            [incdtseverity_id] => 129
            [incdtseverity_name] => 162
            [incdtseverity_order] => 1
            [incdtseverity_descrip] => 34
        )

    [incdtseverity__keys] => Array
        (
            [incdtseverity_id] => incdtseverity_incdtseverity_id_seq
        )

    [invadj] => Array
        (
            [invadj_id] => 129
            [invadj_transdate] => 6
            [invadj_location_id] => 1
            [invadj_itemsite_id] => 1
            [invadj_qty_by] => 1
            [invadj_posted] => 18
            [invadj_comments] => 34
            [invadj_voids_id] => 129
            [invadj_invdetail_id] => 1
            [invadj_voided_by_id] => 129
            [invadj_invadjgrp_id] => 1
        )

    [invadj__keys] => Array
        (
            [invadj_id] => invadj_id_seq
        )

    [invadjgrp] => Array
        (
            [invadjgrp_id] => 129
            [invadjgrp_name] => 34
            [invadjgrp_transdate] => 6
            [invadjgrp_location_id] => 1
            [invadjgrp_posted] => 146
            [invadjgrp_comments] => 34
            [invadjgrp_void] => 146
        )

    [invadjgrp__keys] => Array
        (
            [invadjgrp_id] => invadjgrp_id_seq
        )

    [invbal] => Array
        (
            [invbal_id] => 129
            [invbal_period_id] => 1
            [invbal_itemsite_id] => 1
            [invbal_qoh_beginning] => 129
            [invbal_qoh_ending] => 129
            [invbal_qty_in] => 129
            [invbal_qty_out] => 129
            [invbal_value_beginning] => 129
            [invbal_value_ending] => 129
            [invbal_value_in] => 129
            [invbal_value_out] => 129
            [invbal_nn_beginning] => 129
            [invbal_nn_ending] => 129
            [invbal_nn_in] => 129
            [invbal_nn_out] => 129
            [invbal_nnval_beginning] => 129
            [invbal_nnval_ending] => 129
            [invbal_nnval_in] => 129
            [invbal_nnval_out] => 129
            [invbal_dirty] => 146
        )

    [invbal__keys] => Array
        (
            [invbal_id] => invbal_invbal_id_seq
        )

    [invchead] => Array
        (
            [invchead_id] => 129
            [invchead_cust_id] => 129
            [invchead_shipto_id] => 1
            [invchead_ordernumber] => 34
            [invchead_orderdate] => 6
            [invchead_posted] => 146
            [invchead_printed] => 146
            [invchead_invcnumber] => 162
            [invchead_invcdate] => 134
            [invchead_shipdate] => 6
            [invchead_ponumber] => 34
            [invchead_shipvia] => 34
            [invchead_fob] => 34
            [invchead_billto_name] => 34
            [invchead_billto_address1] => 34
            [invchead_billto_address2] => 34
            [invchead_billto_address3] => 34
            [invchead_billto_city] => 34
            [invchead_billto_state] => 34
            [invchead_billto_zipcode] => 34
            [invchead_billto_phone] => 34
            [invchead_shipto_name] => 34
            [invchead_shipto_address1] => 34
            [invchead_shipto_address2] => 34
            [invchead_shipto_address3] => 34
            [invchead_shipto_city] => 34
            [invchead_shipto_state] => 34
            [invchead_shipto_zipcode] => 34
            [invchead_shipto_phone] => 34
            [invchead_salesrep_id] => 1
            [invchead_commission] => 129
            [invchead_terms_id] => 1
            [invchead_freight] => 129
            [invchead_misc_amount] => 129
            [invchead_misc_descrip] => 34
            [invchead_misc_accnt_id] => 1
            [invchead_payment] => 1
            [invchead_paymentref] => 34
            [invchead_notes] => 34
            [invchead_billto_country] => 34
            [invchead_shipto_country] => 34
            [invchead_prj_id] => 1
            [invchead_curr_id] => 1
            [invchead_gldistdate] => 6
            [invchead_recurring] => 146
            [invchead_recurring_interval] => 1
            [invchead_recurring_type] => 34
            [invchead_recurring_until] => 6
            [invchead_recurring_invchead_id] => 1
            [invchead_shipchrg_id] => 1
            [invchead_taxzone_id] => 1
            [invchead_void] => 18
            [invchead_oldid] => 1
        )

    [invchead__keys] => Array
        (
            [invchead_id] => invchead_invchead_id_seq
        )

    [invcheadtax] => Array
        (
            [taxhist_id] => 129
            [taxhist_parent_id] => 129
            [taxhist_taxtype_id] => 1
            [taxhist_tax_id] => 129
            [taxhist_basis] => 129
            [taxhist_basis_tax_id] => 1
            [taxhist_sequence] => 1
            [taxhist_percent] => 129
            [taxhist_amount] => 129
            [taxhist_tax] => 129
            [taxhist_docdate] => 134
            [taxhist_distdate] => 6
            [taxhist_curr_id] => 1
            [taxhist_curr_rate] => 1
            [taxhist_journalnumber] => 1
        )

    [invcheadtax__keys] => Array
        (
            [taxhist_id] => taxhist_taxhist_id_seq
        )

    [invcitem] => Array
        (
            [invcitem_id] => 129
            [invcitem_invchead_id] => 129
            [invcitem_linenumber] => 1
            [invcitem_item_id] => 1
            [invcitem_warehous_id] => 1
            [invcitem_custpn] => 34
            [invcitem_number] => 34
            [invcitem_descrip] => 34
            [invcitem_ordered] => 129
            [invcitem_billed] => 129
            [invcitem_custprice] => 1
            [invcitem_price] => 129
            [invcitem_notes] => 34
            [invcitem_salescat_id] => 1
            [invcitem_taxtype_id] => 1
            [invcitem_qty_uom_id] => 1
            [invcitem_qty_invuomratio] => 129
            [invcitem_price_uom_id] => 1
            [invcitem_price_invuomratio] => 129
            [invcitem_coitem_id] => 1
            [invcitem_updateinv] => 18
        )

    [invcitem__keys] => Array
        (
            [invcitem_id] => invcitem_invcitem_id_seq
        )

    [invcitemtax] => Array
        (
            [taxhist_id] => 129
            [taxhist_parent_id] => 129
            [taxhist_taxtype_id] => 1
            [taxhist_tax_id] => 129
            [taxhist_basis] => 129
            [taxhist_basis_tax_id] => 1
            [taxhist_sequence] => 1
            [taxhist_percent] => 129
            [taxhist_amount] => 129
            [taxhist_tax] => 129
            [taxhist_docdate] => 134
            [taxhist_distdate] => 6
            [taxhist_curr_id] => 1
            [taxhist_curr_rate] => 1
            [taxhist_journalnumber] => 1
        )

    [invcitemtax__keys] => Array
        (
            [taxhist_id] => taxhist_taxhist_id_seq
        )

    [invcnt] => Array
        (
            [invcnt_id] => 129
            [invcnt_itemsite_id] => 1
            [invcnt_tagdate] => 2
            [invcnt_cntdate] => 2
            [invcnt_qoh_before] => 1
            [invcnt_qoh_after] => 1
            [invcnt_matcost] => 1
            [invcnt_posted] => 18
            [invcnt_postdate] => 2
            [invcnt_comments] => 34
            [invcnt_priority] => 18
            [invcnt_tagnumber] => 34
            [invcnt_invhist_id] => 1
            [invcnt_location_id] => 1
            [invcnt_cnt_username] => 34
            [invcnt_post_username] => 34
            [invcnt_tag_username] => 34
        )

    [invcnt__keys] => Array
        (
            [invcnt_id] => invcnt_invcnt_id_seq
        )

    [invdetail] => Array
        (
            [invdetail_id] => 129
            [invdetail_transtype] => 2
            [invdetail_invhist_id] => 1
            [invdetail_location_id] => 1
            [invdetail_qty] => 1
            [invdetail_comments] => 34
            [invdetail_qty_before] => 1
            [invdetail_qty_after] => 1
            [invdetail_invcitem_id] => 1
            [invdetail_expiration] => 6
            [invdetail_warrpurc] => 6
            [invdetail_ls_id] => 1
        )

    [invdetail__keys] => Array
        (
            [invdetail_id] => invdetail_invdetail_id_seq
        )

    [invfifo] => Array
        (
            [invfifo_invdetail_id] => 129
            [invfifo_unitcost] => 129
            [invfifo_landedunitcost] => 129
            [invfifo_totalcost] => 129
            [invfifo_qty_before] => 129
            [invfifo_qty_after] => 129
            [invfifo_cost_before] => 129
            [invfifo_cost_after] => 129
            [invfifo_is_estimate] => 146
            [invfifo_recalc_queued] => 146
            [invfifo_vend_id] => 1
            [invfifo_cust_id] => 1
            [invfifo_cohead_id] => 129
            [invfifo_void] => 129
        )

    [invfifopos] => Array
        (
            [invfifopos_itemsite_id] => 129
            [invfifopos_lastadjustment] => 129
            [invfifopos_last_invdetail_id] => 1
        )

    [invhist] => Array
        (
            [invhist_id] => 129
            [invhist_itemsite_id] => 1
            [invhist_transdate] => 2
            [invhist_transtype] => 2
            [invhist_invqty] => 1
            [invhist_invuom] => 34
            [invhist_ordnumber] => 34
            [invhist_docnumber] => 34
            [invhist_qoh_before] => 1
            [invhist_qoh_after] => 1
            [invhist_unitcost] => 1
            [invhist_acct_id] => 1
            [invhist_xfer_warehous_id] => 1
            [invhist_comments] => 34
            [invhist_posted] => 18
            [invhist_imported] => 18
            [invhist_hasdetail] => 18
            [invhist_ordtype] => 34
            [invhist_analyze] => 18
            [invhist_user] => 34
            [invhist_created] => 130
            [invhist_costmethod] => 130
            [invhist_value_before] => 129
            [invhist_value_after] => 129
            [invhist_series] => 1
        )

    [invhist__keys] => Array
        (
            [invhist_id] => invhist_invhist_id_seq
        )

    [invhist_transfer] => Array
        (
            [invhist_transfer_id] => 129
            [invhist_transfer_transdate] => 2
            [invhist_transfer_number] => 34
            [invhist_transfer_from] => 1
            [invhist_transfer_to] => 1
            [invhist_transfer_descrip] => 34
            [invhist_transfer_posted] => 18
            [invhist_transfer_recvgrp_id] => 1
            [invhist_transfer_price] => 34
            [invhist_transfer_salesrep_id] => 1
            [invhist_transfer_void] => 18
            [invhist_transfer_arrivaldate] => 2
            [invhist_transfer_delivery_note] => 34
        )

    [invhist_transfer__keys] => Array
        (
            [invhist_transfer_id] => invhist_transfer_id_seq
        )

    [invhist_transfer_item] => Array
        (
            [invhist_transfer_item_id] => 129
            [invhist_transfer_item_invhist_transfer_id] => 129
            [invhist_transfer_item_itemsite_id] => 129
            [invhist_transfer_item_qty] => 1
            [invhist_transfer_item_line] => 1
            [invhist_transfer_invhist_id] => 1
            [invhist_transfer_item_unit_price] => 1
            [invhist_transfer_item_unit_price_default] => 1
        )

    [invhist_transfer_item__keys] => Array
        (
            [invhist_transfer_item_id] => invhist_transfer_item_id_seq
        )

    [ipsass] => Array
        (
            [ipsass_id] => 129
            [ipsass_ipshead_id] => 129
            [ipsass_cust_id] => 1
            [ipsass_custtype_id] => 1
            [ipsass_custtype_pattern] => 34
            [ipsass_shipto_id] => 1
            [ipsass_shipto_pattern] => 34
        )

    [ipsass__keys] => Array
        (
            [ipsass_id] => ipsass_ipsass_id_seq
        )

    [ipsfreight] => Array
        (
            [ipsfreight_id] => 129
            [ipsfreight_ipshead_id] => 129
            [ipsfreight_qtybreak] => 129
            [ipsfreight_price] => 129
            [ipsfreight_type] => 130
            [ipsfreight_warehous_id] => 1
            [ipsfreight_shipzone_id] => 1
            [ipsfreight_freightclass_id] => 1
            [ipsfreight_shipvia] => 34
        )

    [ipsfreight__keys] => Array
        (
            [ipsfreight_id] => ipsfreight_ipsfreight_id_seq
        )

    [ipshead] => Array
        (
            [ipshead_id] => 129
            [ipshead_name] => 34
            [ipshead_descrip] => 34
            [ipshead_effective] => 6
            [ipshead_expires] => 6
            [ipshead_curr_id] => 129
            [ipshead_updated] => 6
        )

    [ipshead__keys] => Array
        (
            [ipshead_id] => ipshead_ipshead_id_seq
        )

    [ipsitemchar] => Array
        (
            [ipsitemchar_id] => 129
            [ipsitemchar_ipsitem_id] => 129
            [ipsitemchar_char_id] => 129
            [ipsitemchar_value] => 162
            [ipsitemchar_price] => 1
        )

    [ipsitemchar__keys] => Array
        (
            [ipsitemchar_id] => ipsitemchar_ipsitemchar_id_seq
        )

    [ipsiteminfo] => Array
        (
            [ipsitem_id] => 129
            [ipsitem_ipshead_id] => 1
            [ipsitem_item_id] => 1
            [ipsitem_qtybreak] => 129
            [ipsitem_price] => 129
            [ipsitem_qty_uom_id] => 129
            [ipsitem_price_uom_id] => 129
            [ipsitem_discntprcnt] => 129
            [ipsitem_fixedamtdiscount] => 129
        )

    [ipsiteminfo__keys] => Array
        (
            [ipsitem_id] => ipsitem_ipsitem_id_seq
        )

    [ipsprodcat] => Array
        (
            [ipsprodcat_id] => 129
            [ipsprodcat_ipshead_id] => 129
            [ipsprodcat_prodcat_id] => 129
            [ipsprodcat_qtybreak] => 129
            [ipsprodcat_discntprcnt] => 129
            [ipsprodcat_fixedamtdiscount] => 129
        )

    [ipsprodcat__keys] => Array
        (
            [ipsprodcat_id] => ipsprodcat_ipsprodcat_id_seq
        )

    [item] => Array
        (
            [item_id] => 129
            [item_number] => 162
            [item_descrip1] => 162
            [item_descrip2] => 162
            [item_classcode_id] => 129
            [item_picklist] => 146
            [item_comments] => 34
            [item_sold] => 146
            [item_fractional] => 146
            [item_active] => 146
            [item_type] => 130
            [item_prodweight] => 129
            [item_packweight] => 129
            [item_prodcat_id] => 129
            [item_exclusive] => 146
            [item_listprice] => 129
            [item_config] => 18
            [item_extdescrip] => 34
            [item_upccode] => 34
            [item_maxcost] => 129
            [item_inv_uom_id] => 129
            [item_price_uom_id] => 129
            [item_warrdays] => 1
            [item_freightclass_id] => 1
            [item_tax_recoverable] => 146
        )

    [item__keys] => Array
        (
            [item_id] => item_item_id_seq
        )

    [itemalias] => Array
        (
            [itemalias_id] => 129
            [itemalias_item_id] => 129
            [itemalias_number] => 162
            [itemalias_comments] => 34
            [itemalias_usedescrip] => 146
            [itemalias_descrip1] => 34
            [itemalias_descrip2] => 34
        )

    [itemalias__keys] => Array
        (
            [itemalias_id] => itemalias_itemalias_id_seq
        )

    [itemcost] => Array
        (
            [itemcost_id] => 129
            [itemcost_item_id] => 129
            [itemcost_costelem_id] => 129
            [itemcost_lowlevel] => 146
            [itemcost_stdcost] => 129
            [itemcost_posted] => 6
            [itemcost_actcost] => 129
            [itemcost_updated] => 6
            [itemcost_curr_id] => 129
        )

    [itemcost__keys] => Array
        (
            [itemcost_id] => itemcost_itemcost_id_seq
        )

    [itemgrp] => Array
        (
            [itemgrp_id] => 129
            [itemgrp_name] => 34
            [itemgrp_descrip] => 34
        )

    [itemgrp__keys] => Array
        (
            [itemgrp_id] => itemgrp_itemgrp_id_seq
        )

    [itemgrpitem] => Array
        (
            [itemgrpitem_id] => 129
            [itemgrpitem_itemgrp_id] => 1
            [itemgrpitem_item_id] => 1
        )

    [itemgrpitem__keys] => Array
        (
            [itemgrpitem_id] => itemgrpitem_itemgrpitem_id_seq
        )

    [itemloc] => Array
        (
            [itemloc_id] => 129
            [itemloc_itemsite_id] => 129
            [itemloc_location_id] => 129
            [itemloc_qty] => 129
            [itemloc_expiration] => 134
            [itemloc_consolflag] => 18
            [itemloc_ls_id] => 1
            [itemloc_warrpurc] => 6
        )

    [itemloc__keys] => Array
        (
            [itemloc_id] => itemloc_itemloc_id_seq
        )

    [itemlocdist] => Array
        (
            [itemlocdist_id] => 129
            [itemlocdist_itemlocdist_id] => 1
            [itemlocdist_source_type] => 2
            [itemlocdist_source_id] => 1
            [itemlocdist_qty] => 1
            [itemlocdist_series] => 1
            [itemlocdist_invhist_id] => 1
            [itemlocdist_itemsite_id] => 1
            [itemlocdist_reqlotserial] => 18
            [itemlocdist_flush] => 18
            [itemlocdist_expiration] => 6
            [itemlocdist_distlotserial] => 18
            [itemlocdist_warranty] => 6
            [itemlocdist_ls_id] => 1
            [itemlocdist_order_type] => 34
            [itemlocdist_order_id] => 1
        )

    [itemlocdist__keys] => Array
        (
            [itemlocdist_id] => itemlocdist_itemlocdist_id_seq
        )

    [itemlocpost] => Array
        (
            [itemlocpost_id] => 129
            [itemlocpost_itemlocseries] => 1
            [itemlocpost_glseq] => 1
        )

    [itemlocpost__keys] => Array
        (
            [itemlocpost_id] => itemlocpost_itemlocpost_id_seq
        )

    [itemsite] => Array
        (
            [itemsite_id] => 129
            [itemsite_item_id] => 129
            [itemsite_warehous_id] => 1
            [itemsite_qtyonhand] => 129
            [itemsite_reorderlevel] => 129
            [itemsite_ordertoqty] => 129
            [itemsite_cyclecountfreq] => 129
            [itemsite_datelastcount] => 6
            [itemsite_datelastused] => 6
            [itemsite_loccntrl] => 146
            [itemsite_safetystock] => 129
            [itemsite_minordqty] => 129
            [itemsite_multordqty] => 129
            [itemsite_leadtime] => 129
            [itemsite_abcclass] => 2
            [itemsite_issuemethod] => 2
            [itemsite_controlmethod] => 2
            [itemsite_active] => 146
            [itemsite_plancode_id] => 129
            [itemsite_costcat_id] => 129
            [itemsite_eventfence] => 129
            [itemsite_sold] => 146
            [itemsite_stocked] => 146
            [itemsite_freeze] => 146
            [itemsite_location_id] => 129
            [itemsite_useparams] => 146
            [itemsite_useparamsmanual] => 146
            [itemsite_soldranking] => 1
            [itemsite_createpr] => 18
            [itemsite_location] => 34
            [itemsite_location_comments] => 34
            [itemsite_notes] => 34
            [itemsite_perishable] => 146
            [itemsite_nnqoh] => 129
            [itemsite_autoabcclass] => 146
            [itemsite_ordergroup] => 129
            [itemsite_disallowblankwip] => 146
            [itemsite_maxordqty] => 129
            [itemsite_mps_timefence] => 129
            [itemsite_createwo] => 146
            [itemsite_warrpurc] => 146
            [itemsite_autoreg] => 18
            [itemsite_costmethod] => 130
            [itemsite_value] => 129
            [itemsite_ordergroup_first] => 146
            [itemsite_supply_itemsite_id] => 1
            [itemsite_planning_type] => 130
            [itemsite_wosupply] => 146
            [itemsite_posupply] => 146
            [itemsite_lsseq_id] => 1
            [itemsite_cosdefault] => 2
            [itemsite_createsopr] => 18
            [itemsite_createsopo] => 18
            [itemsite_dropship] => 18
        )

    [itemsite__keys] => Array
        (
            [itemsite_id] => itemsite_itemsite_id_seq
        )

    [itemsrc] => Array
        (
            [itemsrc_id] => 129
            [itemsrc_item_id] => 129
            [itemsrc_vend_id] => 129
            [itemsrc_vend_item_number] => 34
            [itemsrc_vend_item_descrip] => 34
            [itemsrc_comments] => 34
            [itemsrc_vend_uom] => 162
            [itemsrc_invvendoruomratio] => 129
            [itemsrc_minordqty] => 129
            [itemsrc_multordqty] => 129
            [itemsrc_leadtime] => 129
            [itemsrc_ranking] => 129
            [itemsrc_active] => 146
            [itemsrc_manuf_name] => 162
            [itemsrc_manuf_item_number] => 162
            [itemsrc_manuf_item_descrip] => 34
            [itemsrc_default] => 18
            [itemsrc_upccode] => 34
        )

    [itemsrc__keys] => Array
        (
            [itemsrc_id] => itemsrc_itemsrc_id_seq
        )

    [itemsrcp] => Array
        (
            [itemsrcp_id] => 129
            [itemsrcp_itemsrc_id] => 129
            [itemsrcp_qtybreak] => 129
            [itemsrcp_price] => 129
            [itemsrcp_updated] => 6
            [itemsrcp_curr_id] => 129
        )

    [itemsrcp__keys] => Array
        (
            [itemsrcp_id] => itemsrcp_itemsrcp_id_seq
        )

    [itemsub] => Array
        (
            [itemsub_id] => 129
            [itemsub_parent_item_id] => 129
            [itemsub_sub_item_id] => 129
            [itemsub_uomratio] => 129
            [itemsub_rank] => 129
        )

    [itemsub__keys] => Array
        (
            [itemsub_id] => itemsub_itemsub_id_seq
        )

    [itemtax] => Array
        (
            [itemtax_id] => 129
            [itemtax_item_id] => 129
            [itemtax_taxtype_id] => 129
            [itemtax_taxzone_id] => 1
        )

    [itemtax__keys] => Array
        (
            [itemtax_id] => itemtax_itemtax_id_seq
        )

    [itemtrans] => Array
        (
            [itemtrans_id] => 129
            [itemtrans_source_item_id] => 1
            [itemtrans_target_item_id] => 1
        )

    [itemtrans__keys] => Array
        (
            [itemtrans_id] => itemtrans_itemtrans_id_seq
        )

    [itemuom] => Array
        (
            [itemuom_id] => 129
            [itemuom_itemuomconv_id] => 129
            [itemuom_uomtype_id] => 129
        )

    [itemuom__keys] => Array
        (
            [itemuom_id] => itemuom_itemuom_id_seq
        )

    [itemuomconv] => Array
        (
            [itemuomconv_id] => 129
            [itemuomconv_item_id] => 129
            [itemuomconv_from_uom_id] => 129
            [itemuomconv_from_value] => 129
            [itemuomconv_to_uom_id] => 129
            [itemuomconv_to_value] => 129
            [itemuomconv_fractional] => 146
        )

    [itemuomconv__keys] => Array
        (
            [itemuomconv_id] => itemuomconv_itemuomconv_id_seq
        )

    [jrnluse] => Array
        (
            [jrnluse_id] => 129
            [jrnluse_date] => 14
            [jrnluse_number] => 1
            [jrnluse_use] => 34
        )

    [jrnluse__keys] => Array
        (
            [jrnluse_id] => jrnluse_jrnluse_id_seq
        )

    [labeldef] => Array
        (
            [labeldef_id] => 129
            [labeldef_name] => 162
            [labeldef_papersize] => 162
            [labeldef_columns] => 129
            [labeldef_rows] => 129
            [labeldef_width] => 129
            [labeldef_height] => 129
            [labeldef_start_offset_x] => 129
            [labeldef_start_offset_y] => 129
            [labeldef_horizontal_gap] => 129
            [labeldef_vertical_gap] => 129
        )

    [labeldef__keys] => Array
        (
            [labeldef_id] => labeldef_labeldef_id_seq
        )

    [labelform] => Array
        (
            [labelform_id] => 129
            [labelform_name] => 34
            [labelform_report_id] => 1
            [labelform_perpage] => 1
            [labelform_report_name] => 34
        )

    [labelform__keys] => Array
        (
            [labelform_id] => labelform_labelform_id_seq
        )

    [lang] => Array
        (
            [lang_id] => 129
            [lang_qt_number] => 1
            [lang_abbr3] => 34
            [lang_abbr2] => 34
            [lang_name] => 162
        )

    [lang__keys] => Array
        (
            [lang_id] => lang_lang_id_seq
        )

    [locale] => Array
        (
            [locale_id] => 129
            [locale_code] => 34
            [locale_descrip] => 34
            [locale_lang_file] => 34
            [locale_dateformat] => 34
            [locale_currformat] => 34
            [locale_qtyformat] => 34
            [locale_comments] => 34
            [locale_qtyperformat] => 34
            [locale_salespriceformat] => 34
            [locale_extpriceformat] => 34
            [locale_timeformat] => 34
            [locale_timestampformat] => 34
            [local_costformat] => 34
            [locale_costformat] => 34
            [locale_purchpriceformat] => 34
            [locale_uomratioformat] => 34
            [locale_intervalformat] => 34
            [locale_lang_id] => 1
            [locale_country_id] => 1
            [locale_error_color] => 34
            [locale_warning_color] => 34
            [locale_emphasis_color] => 34
            [locale_altemphasis_color] => 34
            [locale_expired_color] => 34
            [locale_future_color] => 34
            [locale_curr_scale] => 1
            [locale_salesprice_scale] => 1
            [locale_purchprice_scale] => 1
            [locale_extprice_scale] => 1
            [locale_cost_scale] => 1
            [locale_qty_scale] => 1
            [locale_qtyper_scale] => 1
            [locale_uomratio_scale] => 1
            [locale_percent_scale] => 1
        )

    [locale__keys] => Array
        (
            [locale_id] => locale_locale_id_seq
        )

    [location] => Array
        (
            [location_id] => 129
            [location_warehous_id] => 129
            [location_name] => 162
            [location_descrip] => 34
            [location_restrict] => 18
            [location_netable] => 18
            [location_whsezone_id] => 1
            [location_aisle] => 34
            [location_rack] => 34
            [location_bin] => 34
            [location_cust_id] => 1
            [location_is_default] => 1
        )

    [location__keys] => Array
        (
            [location_id] => location_location_id_seq
        )

    [locbal] => Array
        (
            [locbal_id] => 129
            [locbal_period_id] => 1
            [locbal_location_id] => 1
            [locbal_itemsite_id] => 1
            [locbal_beginning] => 1
            [locbal_ending] => 1
            [locbal_credits] => 1
            [locbal_debits] => 1
        )

    [locbal__keys] => Array
        (
            [locbal_id] => locbal_id_seq
        )

    [loccurbal] => Array
        (
            [loccurbal_id] => 129
            [loccurbal_location_id] => 1
            [loccurbal_itemsite_id] => 1
            [loccurbal_ending] => 1
        )

    [loccurbal__keys] => Array
        (
            [loccurbal_id] => loccurbal_id_seq
        )

    [locitem] => Array
        (
            [locitem_id] => 129
            [locitem_location_id] => 1
            [locitem_item_id] => 1
        )

    [locitem__keys] => Array
        (
            [locitem_id] => locitem_locitem_id_seq
        )

    [metasql] => Array
        (
            [metasql_id] => 129
            [metasql_group] => 34
            [metasql_name] => 34
            [metasql_notes] => 34
            [metasql_query] => 34
            [metasql_lastuser] => 34
            [metasql_lastupdate] => 6
            [metasql_grade] => 129
        )

    [metasql__keys] => Array
        (
            [metasql_id] => metasql_metasql_id_seq
        )

    [metric] => Array
        (
            [metric_id] => 129
            [metric_name] => 34
            [metric_value] => 34
            [metric_module] => 34
        )

    [metric__keys] => Array
        (
            [metric_id] => metric_metric_id_seq
        )

    [metricenc] => Array
        (
            [metricenc_id] => 129
            [metricenc_name] => 34
            [metricenc_value] => 66
            [metricenc_module] => 34
        )

    [metricenc__keys] => Array
        (
            [metricenc_id] => metricenc_metricenc_id_seq
        )

    [mrghist] => Array
        (
            [mrghist_cntct_id] => 129
            [mrghist_table] => 162
            [mrghist_pkey_col] => 162
            [mrghist_pkey_id] => 129
            [mrghist_cntct_col] => 162
        )

    [mrghist__keys] => Array
        (
            [mrghist_cntct_id] => K
            [mrghist_table] => K
            [mrghist_pkey_col] => K
            [mrghist_pkey_id] => K
            [mrghist_cntct_col] => K
        )

    [mrgundo] => Array
        (
            [mrgundo_base_schema] => 34
            [mrgundo_base_table] => 34
            [mrgundo_base_id] => 1
            [mrgundo_schema] => 34
            [mrgundo_table] => 34
            [mrgundo_pkey_col] => 34
            [mrgundo_pkey_id] => 1
            [mrgundo_col] => 34
            [mrgundo_value] => 34
            [mrgundo_type] => 34
        )

    [msg] => Array
        (
            [msg_id] => 129
            [msg_posted] => 2
            [msg_scheduled] => 2
            [msg_text] => 34
            [msg_expires] => 2
            [msg_username] => 34
        )

    [msg__keys] => Array
        (
            [msg_id] => msg_msg_id_seq
        )

    [msguser] => Array
        (
            [msguser_id] => 129
            [msguser_msg_id] => 1
            [msguser_viewed] => 2
            [msguser_username] => 34
        )

    [msguser__keys] => Array
        (
            [msguser_id] => msguser_msguser_id_seq
        )

    [netsuite_balance] => Array
        (
            [id] => 129
            [period_id] => 1
            [accnt_id] => 1
            [beginning] => 1
            [ending] => 1
            [hkd_beginning] => 1
            [hkd_ending] => 1
            [curr_id] => 1
            [base_beginning] => 1
            [base_ending] => 1
            [base_close] => 1
        )

    [netsuite_balance__keys] => Array
        (
            [id] => netsuite_balance_id_seq
        )

    [netsuite_stock] => Array
        (
            [id] => 129
            [trans_date] => 6
            [curr_id] => 1
            [location_id] => 1
            [item_id] => 1
            [qty] => 1
            [txref] => 34
            [txtype] => 34
            [amount] => 1
            [amount_hkd] => 1
            [txline] => 1
        )

    [netsuite_stock__keys] => Array
        (
            [id] => netsuite_stock_id_seq
        )

    [obsolete_tax] => Array
        (
            [tax_id] => 129
            [tax_code] => 34
            [tax_descrip] => 34
            [tax_ratea] => 1
            [tax_sales_accnt_id] => 1
            [tax_freight] => 146
            [tax_cumulative] => 146
            [tax_rateb] => 1
            [tax_salesb_accnt_id] => 1
            [tax_ratec] => 1
            [tax_salesc_accnt_id] => 1
        )

    [obsolete_tax__keys] => Array
        (
            [tax_id] => tax_tax_id_seq
        )

    [office] => Array
        (
            [id] => 129
            [company_id] => 129
            [name] => 130
            [address] => 34
            [address2] => 34
            [address3] => 34
            [phone] => 130
            [fax] => 130
            [email] => 130
            [role] => 130
            [country] => 2
            [display_name] => 2
        )

    [office__keys] => Array
        (
            [id] => office_seq
        )

    [ophead] => Array
        (
            [ophead_id] => 129
            [ophead_name] => 162
            [ophead_crmacct_id] => 1
            [ophead_owner_username] => 34
            [ophead_opstage_id] => 1
            [ophead_opsource_id] => 1
            [ophead_optype_id] => 1
            [ophead_probability_prcnt] => 1
            [ophead_amount] => 1
            [ophead_target_date] => 6
            [ophead_actual_date] => 6
            [ophead_notes] => 34
            [ophead_curr_id] => 1
            [ophead_active] => 18
            [ophead_cntct_id] => 1
            [ophead_username] => 34
            [ophead_start_date] => 6
            [ophead_assigned_date] => 6
            [ophead_priority_id] => 1
            [ophead_number] => 162
        )

    [ophead__keys] => Array
        (
            [ophead_id] => ophead_ophead_id_seq
        )

    [opsource] => Array
        (
            [opsource_id] => 129
            [opsource_name] => 162
            [opsource_descrip] => 34
        )

    [opsource__keys] => Array
        (
            [opsource_id] => opsource_opsource_id_seq
        )

    [opstage] => Array
        (
            [opstage_id] => 129
            [opstage_name] => 162
            [opstage_descrip] => 34
            [opstage_order] => 129
            [opstage_opinactive] => 18
        )

    [opstage__keys] => Array
        (
            [opstage_id] => opstage_opstage_id_seq
        )

    [optype] => Array
        (
            [optype_id] => 129
            [optype_name] => 162
            [optype_descrip] => 34
        )

    [optype__keys] => Array
        (
            [optype_id] => optype_optype_id_seq
        )

    [orderseq] => Array
        (
            [orderseq_id] => 129
            [orderseq_name] => 34
            [orderseq_number] => 1
            [orderseq_table] => 34
            [orderseq_numcol] => 34
        )

    [orderseq__keys] => Array
        (
            [orderseq_id] => orderseq_orderseq_id_seq
        )

    [pack] => Array
        (
            [pack_id] => 129
            [pack_head_id] => 129
            [pack_head_type] => 162
            [pack_shiphead_id] => 1
            [pack_printed] => 146
        )

    [pack__keys] => Array
        (
            [pack_id] => pack_pack_id_seq
        )

    [payaropen] => Array
        (
            [payaropen_ccpay_id] => 129
            [payaropen_aropen_id] => 129
            [payaropen_amount] => 129
            [payaropen_curr_id] => 1
        )

    [payaropen__keys] => Array
        (
            [payaropen_ccpay_id] => K
            [payaropen_aropen_id] => K
        )

    [payco] => Array
        (
            [payco_ccpay_id] => 129
            [payco_cohead_id] => 129
            [payco_amount] => 129
            [payco_curr_id] => 1
        )

    [period] => Array
        (
            [period_id] => 129
            [period_start] => 6
            [period_end] => 6
            [period_closed] => 18
            [period_freeze] => 18
            [period_initial] => 18
            [period_name] => 34
            [period_yearperiod_id] => 1
            [period_quarter] => 1
            [period_number] => 129
        )

    [period__keys] => Array
        (
            [period_id] => period_period_id_seq
        )

    [person] => Array
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
            [remarks] => 34
            [lang] => 2
            [country] => 2
            [email] => 130
            [phone] => 130
            [phone_mobile] => 130
            [phone_direct] => 130
            [fax] => 130
            [alt_email] => 2
            [office_id] => 1
            [company_id] => 1
            [owner_id] => 129
            [active] => 129
            [project_id] => 1
            [passwd] => 130
            [no_reset_sent] => 1
            [deleted_by] => 129
            [deleted_dt] => 14
            [name_facebook] => 2
            [url_blog] => 2
            [url_twitter] => 2
            [linkedin_id] => 2
            [url_linkedin] => 2
            [url_google_plus] => 162
            [url_blog2] => 162
            [url_blog3] => 162
            [countries] => 130
            [action_type] => 2
            [point_score] => 129
            [authorize_md5] => 162
            [post_code] => 130
        )

    [person__keys] => Array
        (
            [id] => person_seq
        )

    [pkgdep] => Array
        (
            [pkgdep_id] => 129
            [pkgdep_pkghead_id] => 129
            [pkgdep_parent_pkghead_id] => 129
        )

    [pkgdep__keys] => Array
        (
            [pkgdep_id] => pkgdep_pkgdep_id_seq
        )

    [pkghead] => Array
        (
            [pkghead_id] => 129
            [pkghead_name] => 162
            [pkghead_descrip] => 34
            [pkghead_version] => 162
            [pkghead_developer] => 162
            [pkghead_notes] => 34
            [pkghead_created] => 2
            [pkghead_updated] => 2
            [pkghead_indev] => 146
        )

    [pkghead__keys] => Array
        (
            [pkghead_id] => pkghead_pkghead_id_seq
        )

    [pkgitem] => Array
        (
            [pkgitem_id] => 129
            [pkgitem_pkghead_id] => 1
            [pkgitem_type] => 34
            [pkgitem_item_id] => 129
            [pkgitem_name] => 162
            [pkgitem_descrip] => 34
        )

    [pkgitem__keys] => Array
        (
            [pkgitem_id] => pkgitem_pkgitem_id_seq
        )

    [plancode] => Array
        (
            [plancode_id] => 129
            [plancode_code] => 34
            [plancode_name] => 34
            [plancode_mpsexplosion] => 2
            [plancode_consumefcst] => 18
            [plancode_mrpexcp_resched] => 18
            [plancode_mrpexcp_delete] => 18
        )

    [plancode__keys] => Array
        (
            [plancode_id] => plancode_plancode_id_seq
        )

    [pohead] => Array
        (
            [pohead_id] => 129
            [pohead_status] => 2
            [pohead_number] => 34
            [pohead_orderdate] => 6
            [pohead_vend_id] => 1
            [pohead_fob] => 34
            [pohead_shipvia] => 34
            [pohead_comments] => 34
            [pohead_freight] => 1
            [pohead_printed] => 18
            [pohead_terms_id] => 1
            [pohead_warehous_id] => 1
            [pohead_vendaddr_id] => 1
            [pohead_agent_username] => 34
            [pohead_curr_id] => 1
            [pohead_saved] => 146
            [pohead_taxzone_id] => 1
            [pohead_taxtype_id] => 1
            [pohead_dropship] => 18
            [pohead_vend_cntct_id] => 1
            [pohead_vend_cntct_honorific] => 34
            [pohead_vend_cntct_first_name] => 34
            [pohead_vend_cntct_middle] => 34
            [pohead_vend_cntct_last_name] => 34
            [pohead_vend_cntct_suffix] => 34
            [pohead_vend_cntct_phone] => 34
            [pohead_vend_cntct_title] => 34
            [pohead_vend_cntct_fax] => 34
            [pohead_vend_cntct_email] => 34
            [pohead_vendaddress1] => 34
            [pohead_vendaddress2] => 34
            [pohead_vendaddress3] => 34
            [pohead_vendcity] => 34
            [pohead_vendstate] => 34
            [pohead_vendzipcode] => 34
            [pohead_vendcountry] => 34
            [pohead_shipto_cntct_id] => 1
            [pohead_shipto_cntct_honorific] => 34
            [pohead_shipto_cntct_first_name] => 34
            [pohead_shipto_cntct_middle] => 34
            [pohead_shipto_cntct_last_name] => 34
            [pohead_shipto_cntct_suffix] => 34
            [pohead_shipto_cntct_phone] => 34
            [pohead_shipto_cntct_title] => 34
            [pohead_shipto_cntct_fax] => 34
            [pohead_shipto_cntct_email] => 34
            [pohead_shiptoddress_id] => 1
            [pohead_shiptoaddress1] => 34
            [pohead_shiptoaddress2] => 34
            [pohead_shiptoaddress3] => 34
            [pohead_shiptocity] => 34
            [pohead_shiptostate] => 34
            [pohead_shiptozipcode] => 34
            [pohead_shiptocountry] => 34
            [pohead_cohead_id] => 1
            [pohead_released] => 6
            [pohead_has_error] => 1
            [pohead_location_id] => 1
            [pohead_bg_va] => 34
            [pohead_bg_arrival_est_day] => 6
            [pohead_bg_available_est_day] => 6
            [pohead_bg_available_latest_day] => 6
            [pohead_last_updated] => 6
            [pohead_notes] => 34
        )

    [pohead__keys] => Array
        (
            [pohead_id] => pohead_pohead_id_seq
        )

    [poitem] => Array
        (
            [poitem_id] => 129
            [poitem_status] => 2
            [poitem_pohead_id] => 1
            [poitem_linenumber] => 1
            [poitem_duedate] => 6
            [poitem_wohead_id] => 1
            [poitem_itemsite_id] => 1
            [poitem_vend_item_descrip] => 34
            [poitem_vend_uom] => 34
            [poitem_invvenduomratio] => 1
            [poitem_qty_ordered] => 129
            [poitem_qty_received] => 129
            [poitem_qty_returned] => 129
            [poitem_qty_vouchered] => 129
            [poitem_unitprice] => 1
            [poitem_vend_item_number] => 34
            [poitem_comments] => 34
            [poitem_qty_toreceive] => 1
            [poitem_expcat_id] => 1
            [poitem_itemsrc_id] => 1
            [poitem_freight] => 129
            [poitem_freight_received] => 129
            [poitem_freight_vouchered] => 129
            [poitem_soitem_id] => 1
            [poitem_prj_id] => 1
            [poitem_stdcost] => 1
            [poitem_bom_rev_id] => 1
            [poitem_boo_rev_id] => 1
            [poitem_manuf_name] => 34
            [poitem_manuf_item_number] => 34
            [poitem_manuf_item_descrip] => 34
            [poitem_taxtype_id] => 1
            [poitem_tax_recoverable] => 146
            [poitem_rlsd_duedate] => 6
            [poitem_location_id] => 1
        )

    [poitem__keys] => Array
        (
            [poitem_id] => poitem_poitem_id_seq
        )

    [poreject] => Array
        (
            [poreject_id] => 129
            [poreject_date] => 2
            [poreject_ponumber] => 34
            [poreject_itemsite_id] => 1
            [poreject_vend_id] => 1
            [poreject_vend_item_number] => 34
            [poreject_vend_item_descrip] => 34
            [poreject_vend_uom] => 34
            [poreject_qty] => 1
            [poreject_posted] => 18
            [poreject_rjctcode_id] => 1
            [poreject_poitem_id] => 1
            [poreject_invoiced] => 18
            [poreject_vohead_id] => 1
            [poreject_agent_username] => 34
            [poreject_voitem_id] => 1
            [poreject_value] => 1
            [poreject_trans_username] => 34
            [poreject_oldid] => 1
        )

    [poreject__keys] => Array
        (
            [poreject_id] => poreject_poreject_id_seq
        )

    [potype] => Array
        (
            [potype_id] => 129
            [potype_name] => 34
            [potype_descrip] => 34
        )

    [potype__keys] => Array
        (
            [potype_id] => potype_potype_id_seq
        )

    [pr] => Array
        (
            [pr_id] => 129
            [pr_number] => 1
            [pr_subnumber] => 1
            [pr_status] => 2
            [pr_order_type] => 2
            [pr_order_id] => 1
            [pr_poitem_id] => 1
            [pr_duedate] => 6
            [pr_itemsite_id] => 1
            [pr_qtyreq] => 1
            [pr_prj_id] => 1
            [pr_releasenote] => 34
            [pr_createdate] => 14
        )

    [pr__keys] => Array
        (
            [pr_id] => pr_pr_id_seq
        )

    [prftcntr] => Array
        (
            [prftcntr_id] => 129
            [prftcntr_number] => 34
            [prftcntr_descrip] => 34
        )

    [prftcntr__keys] => Array
        (
            [prftcntr_id] => prftcntr_prftcntr_id_seq
        )

    [priv] => Array
        (
            [priv_id] => 129
            [priv_module] => 34
            [priv_name] => 34
            [priv_descrip] => 34
            [priv_seq] => 1
        )

    [priv__keys] => Array
        (
            [priv_id] => priv_priv_id_seq
        )

    [prj] => Array
        (
            [prj_id] => 129
            [prj_number] => 162
            [prj_name] => 162
            [prj_descrip] => 34
            [prj_status] => 130
            [prj_so] => 18
            [prj_wo] => 18
            [prj_po] => 18
            [prj_owner_username] => 34
            [prj_start_date] => 6
            [prj_due_date] => 6
            [prj_assigned_date] => 6
            [prj_completed_date] => 6
            [prj_username] => 34
            [prj_recurring_prj_id] => 1
        )

    [prj__keys] => Array
        (
            [prj_id] => prj_prj_id_seq
        )

    [prjtask] => Array
        (
            [prjtask_id] => 129
            [prjtask_number] => 162
            [prjtask_name] => 162
            [prjtask_descrip] => 34
            [prjtask_prj_id] => 129
            [prjtask_anyuser] => 18
            [prjtask_status] => 130
            [prjtask_hours_budget] => 129
            [prjtask_hours_actual] => 129
            [prjtask_exp_budget] => 129
            [prjtask_exp_actual] => 129
            [prjtask_owner_username] => 34
            [prjtask_start_date] => 6
            [prjtask_due_date] => 6
            [prjtask_assigned_date] => 6
            [prjtask_completed_date] => 6
            [prjtask_username] => 34
        )

    [prjtask__keys] => Array
        (
            [prjtask_id] => prjtask_prjtask_id_seq
        )

    [prjtaskuser] => Array
        (
            [prjtaskuser_id] => 129
            [prjtaskuser_prjtask_id] => 1
            [prjtaskuser_username] => 34
        )

    [prjtaskuser__keys] => Array
        (
            [prjtaskuser_id] => prjtaskuser_prjtaskuser_id_seq
        )

    [prodcat] => Array
        (
            [prodcat_id] => 129
            [prodcat_code] => 34
            [prodcat_descrip] => 34
        )

    [prodcat__keys] => Array
        (
            [prodcat_id] => prodcat_prodcat_id_seq
        )

    [projectdirectory] => Array
        (
            [id] => 129
            [project_id] => 129
            [person_id] => 129
            [ispm] => 129
            [role] => 130
            [company_id] => 129
            [office_id] => 129
        )

    [projectdirectory__keys] => Array
        (
            [id] => projectdirectory_seq
        )

    [projects] => Array
        (
            [id] => 129
            [name] => 130
            [remarks] => 34
            [owner_id] => 1
            [code] => 130
            [active] => 1
            [type] => 130
            [client_id] => 129
            [team_id] => 129
            [file_location] => 130
            [open_date] => 6
            [open_by] => 129
            [updated_dt] => 142
            [countries] => 130
            [languages] => 130
            [agency_id] => 129
        )

    [projects__keys] => Array
        (
            [id] => projects_seq
        )

    [prospect] => Array
        (
            [prospect_id] => 129
            [prospect_active] => 146
            [prospect_number] => 162
            [prospect_name] => 162
            [prospect_cntct_id] => 1
            [prospect_comments] => 34
            [prospect_created] => 134
            [prospect_salesrep_id] => 1
            [prospect_warehous_id] => 1
            [prospect_taxzone_id] => 1
        )

    [prospect__keys] => Array
        (
            [prospect_id] => cust_cust_id_seq
        )

    [qryhead] => Array
        (
            [qryhead_id] => 129
            [qryhead_name] => 34
            [qryhead_descrip] => 34
            [qryhead_notes] => 34
            [qryhead_username] => 162
            [qryhead_updated] => 134
        )

    [qryhead__keys] => Array
        (
            [qryhead_id] => qryhead_qryhead_id_seq
        )

    [qryitem] => Array
        (
            [qryitem_id] => 129
            [qryitem_qryhead_id] => 129
            [qryitem_name] => 162
            [qryitem_order] => 129
            [qryitem_src] => 162
            [qryitem_group] => 34
            [qryitem_detail] => 162
            [qryitem_notes] => 162
            [qryitem_username] => 162
            [qryitem_updated] => 134
        )

    [qryitem__keys] => Array
        (
            [qryitem_id] => qryitem_qryitem_id_seq
        )

    [quhead] => Array
        (
            [quhead_id] => 129
            [quhead_number] => 34
            [quhead_cust_id] => 129
            [quhead_quotedate] => 6
            [quhead_shipto_id] => 1
            [quhead_shiptoname] => 34
            [quhead_shiptoaddress1] => 34
            [quhead_shiptoaddress2] => 34
            [quhead_shiptoaddress3] => 34
            [quhead_shiptocity] => 34
            [quhead_shiptostate] => 34
            [quhead_shiptozipcode] => 34
            [quhead_shiptophone] => 34
            [quhead_salesrep_id] => 1
            [quhead_terms_id] => 1
            [quhead_origin] => 2
            [quhead_freight] => 1
            [quhead_ordercomments] => 34
            [quhead_shipcomments] => 34
            [quhead_billtoname] => 34
            [quhead_billtoaddress1] => 34
            [quhead_billtoaddress2] => 34
            [quhead_billtoaddress3] => 34
            [quhead_billtocity] => 34
            [quhead_billtostate] => 34
            [quhead_billtozip] => 34
            [quhead_commission] => 1
            [quhead_custponumber] => 34
            [quhead_fob] => 34
            [quhead_shipvia] => 34
            [quhead_warehous_id] => 1
            [quhead_packdate] => 6
            [quhead_prj_id] => 1
            [quhead_misc] => 129
            [quhead_misc_accnt_id] => 1
            [quhead_misc_descrip] => 34
            [quhead_billtocountry] => 34
            [quhead_shiptocountry] => 34
            [quhead_curr_id] => 1
            [quhead_imported] => 18
            [quhead_expire] => 6
            [quhead_calcfreight] => 146
            [quhead_shipto_cntct_id] => 1
            [quhead_shipto_cntct_honorific] => 34
            [quhead_shipto_cntct_first_name] => 34
            [quhead_shipto_cntct_middle] => 34
            [quhead_shipto_cntct_last_name] => 34
            [quhead_shipto_cntct_suffix] => 34
            [quhead_shipto_cntct_phone] => 34
            [quhead_shipto_cntct_title] => 34
            [quhead_shipto_cntct_fax] => 34
            [quhead_shipto_cntct_email] => 34
            [quhead_billto_cntct_id] => 1
            [quhead_billto_cntct_honorific] => 34
            [quhead_billto_cntct_first_name] => 34
            [quhead_billto_cntct_middle] => 34
            [quhead_billto_cntct_last_name] => 34
            [quhead_billto_cntct_suffix] => 34
            [quhead_billto_cntct_phone] => 34
            [quhead_billto_cntct_title] => 34
            [quhead_billto_cntct_fax] => 34
            [quhead_billto_cntct_email] => 34
            [quhead_taxzone_id] => 1
            [quhead_taxtype_id] => 1
            [quhead_ophead_id] => 1
            [quhead_status] => 34
        )

    [quhead__keys] => Array
        (
            [quhead_id] => quhead_quhead_id_seq
        )

    [quitem] => Array
        (
            [quitem_id] => 129
            [quitem_quhead_id] => 1
            [quitem_linenumber] => 1
            [quitem_itemsite_id] => 1
            [quitem_scheddate] => 6
            [quitem_qtyord] => 1
            [quitem_unitcost] => 1
            [quitem_price] => 1
            [quitem_custprice] => 1
            [quitem_memo] => 34
            [quitem_custpn] => 34
            [quitem_createorder] => 18
            [quitem_order_warehous_id] => 1
            [quitem_item_id] => 1
            [quitem_prcost] => 1
            [quitem_imported] => 18
            [quitem_qty_uom_id] => 129
            [quitem_qty_invuomratio] => 129
            [quitem_price_uom_id] => 129
            [quitem_price_invuomratio] => 129
            [quitem_promdate] => 6
            [quitem_taxtype_id] => 1
            [quitem_dropship] => 18
            [quitem_itemsrc_id] => 1
        )

    [quitem__keys] => Array
        (
            [quitem_id] => quitem_quitem_id_seq
        )

    [rcalitem] => Array
        (
            [rcalitem_id] => 129
            [rcalitem_calhead_id] => 1
            [rcalitem_offsettype] => 2
            [rcalitem_offsetcount] => 1
            [rcalitem_periodtype] => 2
            [rcalitem_periodcount] => 1
            [rcalitem_name] => 34
        )

    [rcalitem__keys] => Array
        (
            [rcalitem_id] => xcalitem_xcalitem_id_seq
        )

    [recur] => Array
        (
            [recur_id] => 129
            [recur_parent_id] => 129
            [recur_parent_type] => 162
            [recur_period] => 162
            [recur_freq] => 129
            [recur_start] => 2
            [recur_end] => 2
            [recur_max] => 1
            [recur_data] => 34
        )

    [recur__keys] => Array
        (
            [recur_id] => recur_recur_id_seq
        )

    [recurtype] => Array
        (
            [recurtype_id] => 129
            [recurtype_type] => 162
            [recurtype_table] => 162
            [recurtype_donecheck] => 162
            [recurtype_schedcol] => 162
            [recurtype_limit] => 34
            [recurtype_copyfunc] => 162
            [recurtype_copyargs] => 130
            [recurtype_delfunc] => 34
        )

    [recurtype__keys] => Array
        (
            [recurtype_id] => recurtype_recurtype_id_seq
        )

    [recv] => Array
        (
            [recv_id] => 129
            [recv_order_type] => 162
            [recv_order_number] => 162
            [recv_orderitem_id] => 129
            [recv_agent_username] => 34
            [recv_itemsite_id] => 1
            [recv_vend_id] => 1
            [recv_vend_item_number] => 34
            [recv_vend_item_descrip] => 34
            [recv_vend_uom] => 34
            [recv_purchcost] => 1
            [recv_purchcost_curr_id] => 1
            [recv_duedate] => 6
            [recv_qty] => 1
            [recv_recvcost] => 1
            [recv_recvcost_curr_id] => 1
            [recv_freight] => 1
            [recv_freight_curr_id] => 1
            [recv_date] => 2
            [recv_value] => 1
            [recv_posted] => 146
            [recv_invoiced] => 146
            [recv_vohead_id] => 1
            [recv_voitem_id] => 1
            [recv_trans_usr_name] => 162
            [recv_notes] => 34
            [recv_gldistdate] => 6
            [recv_splitfrom_id] => 1
            [recv_rlsd_duedate] => 6
            [recv_oldid] => 34
            [recv_recvgrp_id] => 1
        )

    [recv__keys] => Array
        (
            [recv_id] => recv_recv_id_seq
        )

    [recvgrp] => Array
        (
            [recvgrp_id] => 129
            [recvgrp_number] => 162
            [recvgrp_landed_cost] => 1
            [recvgrp_landed_method] => 34
            [recvgrp_date] => 6
            [recvgrp_pohead_id] => 1
            [recvgrp_landed_curr_id] => 1
            [recvgrp_location_id] => 1
            [recvgrp_void] => 1
            [recvgrp_receipt_number] => 34
        )

    [recvgrp__keys] => Array
        (
            [recvgrp_id] => recvgrp_id_seq
        )

    [recvgrpland] => Array
        (
            [recvgrpland_id] => 129
            [recvgrpland_vohead_id] => 1
            [recvgrpland_recvgrp_id] => 1
            [recvgrpland_curr_id] => 1
            [recvgrpland_cost] => 1
            [recvgrpland_method] => 34
            [recvgrpland_glseries] => 1
        )

    [recvgrpland__keys] => Array
        (
            [recvgrpland_id] => recvgrpland_id_seq
        )

    [report] => Array
        (
            [report_id] => 129
            [report_name] => 34
            [report_sys] => 18
            [report_source] => 34
            [report_descrip] => 34
            [report_grade] => 129
            [report_loaddate] => 14
        )

    [report__keys] => Array
        (
            [report_id] => report_report_id_seq
        )

    [rjctcode] => Array
        (
            [rjctcode_id] => 129
            [rjctcode_code] => 34
            [rjctcode_descrip] => 34
        )

    [rjctcode__keys] => Array
        (
            [rjctcode_id] => rjctcode_rjctcode_id_seq
        )

    [rsncode] => Array
        (
            [rsncode_id] => 129
            [rsncode_code] => 162
            [rsncode_descrip] => 34
            [rsncode_doctype] => 34
        )

    [rsncode__keys] => Array
        (
            [rsncode_id] => rsncode_rsncode_id_seq
        )

    [sale] => Array
        (
            [sale_id] => 129
            [sale_name] => 34
            [sale_descrip] => 34
            [sale_ipshead_id] => 1
            [sale_startdate] => 6
            [sale_enddate] => 6
        )

    [sale__keys] => Array
        (
            [sale_id] => sale_sale_id_seq
        )

    [salesaccnt] => Array
        (
            [salesaccnt_id] => 129
            [salesaccnt_custtype_id] => 1
            [salesaccnt_prodcat_id] => 1
            [salesaccnt_warehous_id] => 1
            [salesaccnt_sales_accnt_id] => 1
            [salesaccnt_credit_accnt_id] => 1
            [salesaccnt_cos_accnt_id] => 1
            [salesaccnt_custtype] => 34
            [salesaccnt_prodcat] => 34
            [salesaccnt_returns_accnt_id] => 1
            [salesaccnt_cor_accnt_id] => 1
            [salesaccnt_cow_accnt_id] => 1
        )

    [salesaccnt__keys] => Array
        (
            [salesaccnt_id] => salesaccnt_salesaccnt_id_seq
        )

    [salescat] => Array
        (
            [salescat_id] => 129
            [salescat_active] => 18
            [salescat_name] => 34
            [salescat_descrip] => 34
            [salescat_sales_accnt_id] => 1
            [salescat_prepaid_accnt_id] => 1
            [salescat_ar_accnt_id] => 1
        )

    [salescat__keys] => Array
        (
            [salescat_id] => salescat_salescat_id_seq
        )

    [salesforecast] => Array
        (
            [salesforecast_id] => 129
            [salesforecast_itemsite_id] => 1
            [salesforecast_period_id] => 1
            [salesforecast_qty] => 1
            [salesforecast_updated_by] => 1
            [salesforecast_cust_id] => 1
            [salesforecast_is_all_buyers] => 18
            [salesforecast_sum] => 1
            [salesforecast_requests] => 1
        )

    [salesforecast__keys] => Array
        (
            [salesforecast_id] => salesforecast_id_seq
        )

    [salesrep] => Array
        (
            [salesrep_id] => 129
            [salesrep_active] => 18
            [salesrep_number] => 34
            [salesrep_name] => 34
            [salesrep_commission] => 1
            [salesrep_method] => 2
            [salesrep_emp_id] => 1
        )

    [salesrep__keys] => Array
        (
            [salesrep_id] => salesrep_salesrep_id_seq
        )

    [script] => Array
        (
            [script_id] => 129
            [script_name] => 162
            [script_order] => 129
            [script_enabled] => 146
            [script_source] => 162
            [script_notes] => 34
        )

    [script__keys] => Array
        (
            [script_id] => script_script_id_seq
        )

    [sequence] => Array
        (
            [sequence_value] => 1
        )

    [shift] => Array
        (
            [shift_id] => 129
            [shift_number] => 162
            [shift_name] => 162
        )

    [shift__keys] => Array
        (
            [shift_id] => shift_shift_id_seq
        )

    [shipchrg] => Array
        (
            [shipchrg_id] => 129
            [shipchrg_name] => 34
            [shipchrg_descrip] => 34
            [shipchrg_custfreight] => 18
            [shipchrg_handling] => 2
        )

    [shipchrg__keys] => Array
        (
            [shipchrg_id] => shipchrg_shipchrg_id_seq
        )

    [shipdata] => Array
        (
            [shipdata_cohead_number] => 162
            [shipdata_cosmisc_tracknum] => 162
            [shipdata_cosmisc_packnum_tracknum] => 162
            [shipdata_weight] => 1
            [shipdata_base_freight] => 1
            [shipdata_total_freight] => 1
            [shipdata_shipper] => 34
            [shipdata_billing_option] => 34
            [shipdata_package_type] => 34
            [shipdata_void_ind] => 130
            [shipdata_lastupdated] => 142
            [shipdata_shiphead_number] => 34
            [shipdata_base_freight_curr_id] => 1
            [shipdata_total_freight_curr_id] => 1
        )

    [shipdata__keys] => Array
        (
            [shipdata_cohead_number] => K
            [shipdata_cosmisc_tracknum] => K
            [shipdata_cosmisc_packnum_tracknum] => K
            [shipdata_void_ind] => K
        )

    [shipdatasum] => Array
        (
            [shipdatasum_cohead_number] => 162
            [shipdatasum_cosmisc_tracknum] => 162
            [shipdatasum_cosmisc_packnum_tracknum] => 162
            [shipdatasum_weight] => 1
            [shipdatasum_base_freight] => 1
            [shipdatasum_total_freight] => 1
            [shipdatasum_shipper] => 34
            [shipdatasum_billing_option] => 34
            [shipdatasum_package_type] => 34
            [shipdatasum_lastupdated] => 142
            [shipdatasum_shipped] => 18
            [shipdatasum_shiphead_number] => 34
            [shipdatasum_base_freight_curr_id] => 1
            [shipdatasum_total_freight_curr_id] => 1
        )

    [shipdatasum__keys] => Array
        (
            [shipdatasum_cohead_number] => K
            [shipdatasum_cosmisc_tracknum] => K
            [shipdatasum_cosmisc_packnum_tracknum] => K
        )

    [shipform] => Array
        (
            [shipform_id] => 129
            [shipform_name] => 162
            [shipform_report_id] => 1
            [shipform_report_name] => 34
        )

    [shipform__keys] => Array
        (
            [shipform_id] => shipform_shipform_id_seq
        )

    [shiphead] => Array
        (
            [shiphead_id] => 129
            [shiphead_order_id] => 129
            [shiphead_order_type] => 162
            [shiphead_number] => 162
            [shiphead_shipvia] => 34
            [shiphead_freight] => 129
            [shiphead_freight_curr_id] => 129
            [shiphead_notes] => 34
            [shiphead_shipped] => 146
            [shiphead_shipdate] => 6
            [shiphead_shipchrg_id] => 1
            [shiphead_shipform_id] => 1
            [shiphead_sfstatus] => 130
            [shiphead_tracknum] => 34
            [shiphead_delivery_note] => 34
            [shiphead_location_id] => 1
            [shiphead_shipto_id] => 1
            [shiphead_rev] => 1
        )

    [shiphead__keys] => Array
        (
            [shiphead_id] => shiphead_shiphead_id_seq
        )

    [shipitem] => Array
        (
            [shipitem_id] => 129
            [shipitem_orderitem_id] => 129
            [shipitem_shiphead_id] => 129
            [shipitem_qty] => 129
            [shipitem_shipped] => 146
            [shipitem_shipdate] => 2
            [shipitem_transdate] => 2
            [shipitem_trans_username] => 34
            [shipitem_invoiced] => 146
            [shipitem_invcitem_id] => 1
            [shipitem_value] => 1
            [shipitem_invhist_id] => 1
        )

    [shipitem__keys] => Array
        (
            [shipitem_id] => shipitem_shipitem_id_seq
        )

    [shiptoinfo] => Array
        (
            [shipto_id] => 129
            [shipto_cust_id] => 129
            [shipto_name] => 34
            [shipto_salesrep_id] => 1
            [shipto_comments] => 34
            [shipto_shipcomments] => 34
            [shipto_shipzone_id] => 1
            [shipto_shipvia] => 34
            [shipto_commission] => 129
            [shipto_shipform_id] => 1
            [shipto_shipchrg_id] => 1
            [shipto_active] => 146
            [shipto_default] => 18
            [shipto_num] => 34
            [shipto_ediprofile_id] => 1
            [shipto_cntct_id] => 1
            [shipto_addr_id] => 1
            [shipto_taxzone_id] => 1
        )

    [shiptoinfo__keys] => Array
        (
            [shipto_id] => shipto_shipto_id_seq
        )

    [shipvia] => Array
        (
            [shipvia_id] => 129
            [shipvia_code] => 34
            [shipvia_descrip] => 34
        )

    [shipvia__keys] => Array
        (
            [shipvia_id] => shipvia_shipvia_id_seq
        )

    [shipzone] => Array
        (
            [shipzone_id] => 129
            [shipzone_name] => 34
            [shipzone_descrip] => 34
        )

    [shipzone__keys] => Array
        (
            [shipzone_id] => shipzone_shipzone_id_seq
        )

    [shop_category_member] => Array
        (
            [id] => 129
            [category_id] => 129
            [product_id] => 129
            [display_order] => 1
        )

    [shop_category_member__keys] => Array
        (
            [id] => shop_category_member_seq
        )

    [shop_order] => Array
        (
            [id] => 129
            [purchased] => 142
            [customer_id] => 129
            [state] => 162
            [total_value] => 129
            [total_qty] => 1
            [currency] => 2
            [refund_details] => 130
            [notes] => 162
            [pay_confirm_code] => 130
            [acknowledged] => 142
            [acknowledged_by] => 129
            [dispatched] => 142
            [dispatched_by] => 129
            [vat] => 129
            [shippingtype_id] => 1
            [shipping_cost] => 1
        )

    [shop_order__keys] => Array
        (
            [id] => shop_order_seq
        )

    [shop_order_item] => Array
        (
            [id] => 129
            [order_id] => 129
            [purchased] => 142
            [product_id] => 129
            [productitem_id] => 129
            [qty] => 129
            [unit_price] => 129
            [price_total] => 129
            [gift_wrapped] => 129
            [currency] => 130
            [discount] => 129
        )

    [shop_order_item__keys] => Array
        (
            [id] => shop_order_item_seq
        )

    [shop_product] => Array
        (
            [id] => 129
            [name] => 130
            [sku] => 130
            [price] => 129
            [shortdesc] => 162
            [description] => 162
            [visible] => 129
            [itemtypes] => 130
            [category_id] => 129
            [currency] => 130
            [vender_url] => 130
            [supplier_id] => 129
            [display_order] => 1
            [is_bulky] => 1
            [is_delivered] => 1
            [translation_of_id] => 129
            [language] => 130
            [keywords] => 162
        )

    [shop_product__keys] => Array
        (
            [id] => shop_product_seq
        )

    [shop_product_item_vars] => Array
        (
            [id] => 129
            [productitem_id] => 1
            [varvalue_id] => 1
        )

    [shop_product_item_vars__keys] => Array
        (
            [id] => shop_product_item_vars_seq
        )

    [shop_shipping] => Array
        (
            [id] => 129
            [name] => 2
            [description] => 34
        )

    [shop_shipping__keys] => Array
        (
            [id] => shop_shipping_seq
        )

    [shop_shipping_countries] => Array
        (
            [id] => 129
            [shipping_id] => 129
            [country] => 130
        )

    [shop_shipping_countries__keys] => Array
        (
            [id] => shop_shipping_countries_seq
        )

    [shop_shipping_type] => Array
        (
            [id] => 129
            [shipping_id] => 129
            [max_qty] => 129
            [price] => 129
            [visible] => 129
            [country] => 130
            [min_value] => 129
            [priceb] => 129
            [min_weight] => 129
            [max_weight] => 129
            [price_per_kg] => 129
        )

    [shop_shipping_type__keys] => Array
        (
            [id] => shop_shipping_type_seq
        )

    [shop_stockist] => Array
        (
            [id] => 129
            [name] => 130
            [is_active] => 129
            [country] => 130
            [content] => 162
        )

    [shop_stockist__keys] => Array
        (
            [id] => shop_stockist_seq
        )

    [shop_var_values] => Array
        (
            [id] => 129
            [type] => 162
            [value] => 130
            [rgb] => 130
            [title] => 2
        )

    [shop_var_values__keys] => Array
        (
            [id] => shop_var_values_seq
        )

    [shop_vendor] => Array
        (
            [id] => 129
            [name] => 130
            [url] => 130
            [description] => 162
        )

    [shop_vendor__keys] => Array
        (
            [id] => shop_vendor_seq
        )

    [shop_vendor_category] => Array
        (
            [id] => 129
            [category_id] => 129
            [vendor_id] => 129
            [url] => 130
            [description] => 130
        )

    [shop_vendor_category__keys] => Array
        (
            [id] => shop_vendor_category_seq
        )

    [sitetype] => Array
        (
            [sitetype_id] => 129
            [sitetype_name] => 162
            [sitetype_descrip] => 34
        )

    [sitetype__keys] => Array
        (
            [sitetype_id] => sitetype_sitetype_id_seq
        )

    [sltrans] => Array
        (
            [sltrans_id] => 129
            [sltrans_created] => 2
            [sltrans_date] => 134
            [sltrans_sequence] => 1
            [sltrans_accnt_id] => 129
            [sltrans_source] => 34
            [sltrans_docnumber] => 34
            [sltrans_misc_id] => 1
            [sltrans_amount] => 129
            [sltrans_notes] => 34
            [sltrans_journalnumber] => 1
            [sltrans_posted] => 146
            [sltrans_doctype] => 34
            [sltrans_username] => 162
            [sltrans_gltrans_journalnumber] => 1
            [sltrans_rec] => 146
        )

    [sltrans__keys] => Array
        (
            [sltrans_id] => sltrans_sltrans_id_seq
        )

    [source] => Array
        (
            [source_id] => 129
            [source_module] => 34
            [source_name] => 34
            [source_descrip] => 34
        )

    [source__keys] => Array
        (
            [source_id] => source_source_id_seq
        )

    [state] => Array
        (
            [state_id] => 129
            [state_name] => 34
            [state_abbr] => 34
            [state_country_id] => 1
        )

    [state__keys] => Array
        (
            [state_id] => state_state_id_seq
        )

    [status] => Array
        (
            [status_id] => 129
            [status_type] => 162
            [status_code] => 130
            [status_name] => 34
            [status_seq] => 1
            [status_color] => 34
        )

    [status__keys] => Array
        (
            [status_id] => status_status_id_seq
        )

    [stdjrnl] => Array
        (
            [stdjrnl_id] => 129
            [stdjrnl_name] => 162
            [stdjrnl_descrip] => 34
            [stdjrnl_notes] => 34
        )

    [stdjrnl__keys] => Array
        (
            [stdjrnl_id] => stdjrnl_stdjrnl_id_seq
        )

    [stdjrnlgrp] => Array
        (
            [stdjrnlgrp_id] => 129
            [stdjrnlgrp_name] => 34
            [stdjrnlgrp_descrip] => 34
        )

    [stdjrnlgrp__keys] => Array
        (
            [stdjrnlgrp_id] => stdjrnlgrp_stdjrnlgrp_id_seq
        )

    [stdjrnlgrpitem] => Array
        (
            [stdjrnlgrpitem_id] => 129
            [stdjrnlgrpitem_stdjrnl_id] => 1
            [stdjrnlgrpitem_toapply] => 1
            [stdjrnlgrpitem_applied] => 1
            [stdjrnlgrpitem_effective] => 6
            [stdjrnlgrpitem_expires] => 6
            [stdjrnlgrpitem_stdjrnlgrp_id] => 1
        )

    [stdjrnlgrpitem__keys] => Array
        (
            [stdjrnlgrpitem_id] => stdjrnlgrpitem_stdjrnlgrpitem_id_seq
        )

    [stdjrnlitem] => Array
        (
            [stdjrnlitem_id] => 129
            [stdjrnlitem_stdjrnl_id] => 129
            [stdjrnlitem_accnt_id] => 129
            [stdjrnlitem_amount] => 129
            [stdjrnlitem_notes] => 34
        )

    [stdjrnlitem__keys] => Array
        (
            [stdjrnlitem_id] => stdjrnlitem_stdjrnlitem_id_seq
        )

    [subaccnt] => Array
        (
            [subaccnt_id] => 129
            [subaccnt_number] => 34
            [subaccnt_descrip] => 34
        )

    [subaccnt__keys] => Array
        (
            [subaccnt_id] => subaccnt_subaccnt_id_seq
        )

    [subaccnttype] => Array
        (
            [subaccnttype_id] => 129
            [subaccnttype_accnt_type] => 130
            [subaccnttype_code] => 162
            [subaccnttype_descrip] => 34
        )

    [subaccnttype__keys] => Array
        (
            [subaccnttype_id] => subaccnttype_subaccnttype_id_seq
        )

    [tax] => Array
        (
            [tax_id] => 129
            [tax_code] => 34
            [tax_descrip] => 34
            [tax_sales_accnt_id] => 1
            [tax_taxclass_id] => 1
            [tax_taxauth_id] => 1
            [tax_basis_tax_id] => 1
        )

    [tax__keys] => Array
        (
            [tax_id] => tax_tax_id_seq
        )

    [taxass] => Array
        (
            [taxass_id] => 129
            [taxass_taxzone_id] => 1
            [taxass_taxtype_id] => 1
            [taxass_tax_id] => 129
        )

    [taxass__keys] => Array
        (
            [taxass_id] => taxass_taxass_id_seq
        )

    [taxauth] => Array
        (
            [taxauth_id] => 129
            [taxauth_code] => 162
            [taxauth_name] => 34
            [taxauth_extref] => 34
            [taxauth_addr_id] => 1
            [taxauth_curr_id] => 1
            [taxauth_county] => 34
            [taxauth_accnt_id] => 1
        )

    [taxauth__keys] => Array
        (
            [taxauth_id] => taxauth_taxauth_id_seq
        )

    [taxclass] => Array
        (
            [taxclass_id] => 129
            [taxclass_code] => 34
            [taxclass_descrip] => 34
            [taxclass_sequence] => 1
        )

    [taxclass__keys] => Array
        (
            [taxclass_id] => taxclass_taxclass_id_seq
        )

    [taxhist] => Array
        (
            [taxhist_id] => 129
            [taxhist_parent_id] => 129
            [taxhist_taxtype_id] => 1
            [taxhist_tax_id] => 129
            [taxhist_basis] => 129
            [taxhist_basis_tax_id] => 1
            [taxhist_sequence] => 1
            [taxhist_percent] => 129
            [taxhist_amount] => 129
            [taxhist_tax] => 129
            [taxhist_docdate] => 134
            [taxhist_distdate] => 6
            [taxhist_curr_id] => 1
            [taxhist_curr_rate] => 1
            [taxhist_journalnumber] => 1
        )

    [taxhist__keys] => Array
        (
            [taxhist_id] => taxhist_taxhist_id_seq
        )

    [taxrate] => Array
        (
            [taxrate_id] => 129
            [taxrate_tax_id] => 129
            [taxrate_percent] => 129
            [taxrate_curr_id] => 1
            [taxrate_amount] => 129
            [taxrate_effective] => 6
            [taxrate_expires] => 6
        )

    [taxrate__keys] => Array
        (
            [taxrate_id] => taxrate_taxrate_id_seq
        )

    [taxreg] => Array
        (
            [taxreg_id] => 129
            [taxreg_rel_id] => 129
            [taxreg_rel_type] => 2
            [taxreg_taxauth_id] => 1
            [taxreg_number] => 162
            [taxreg_taxzone_id] => 1
            [taxreg_effective] => 6
            [taxreg_expires] => 6
            [taxreg_notes] => 34
        )

    [taxreg__keys] => Array
        (
            [taxreg_id] => taxreg_taxreg_id_seq
        )

    [taxtype] => Array
        (
            [taxtype_id] => 129
            [taxtype_name] => 162
            [taxtype_descrip] => 34
            [taxtype_sys] => 146
        )

    [taxtype__keys] => Array
        (
            [taxtype_id] => taxtype_taxtype_id_seq
        )

    [taxzone] => Array
        (
            [taxzone_id] => 129
            [taxzone_code] => 34
            [taxzone_descrip] => 34
        )

    [taxzone__keys] => Array
        (
            [taxzone_id] => taxzone_taxzone_id_seq
        )

    [terms] => Array
        (
            [terms_id] => 129
            [terms_code] => 34
            [terms_descrip] => 34
            [terms_type] => 2
            [terms_duedays] => 1
            [terms_discdays] => 1
            [terms_discprcnt] => 1
            [terms_cutoffday] => 1
            [terms_ap] => 18
            [terms_ar] => 18
        )

    [terms__keys] => Array
        (
            [terms_id] => terms_terms_id_seq
        )

    [todoitem] => Array
        (
            [todoitem_id] => 129
            [todoitem_name] => 162
            [todoitem_description] => 34
            [todoitem_incdt_id] => 1
            [todoitem_creator_username] => 162
            [todoitem_status] => 2
            [todoitem_active] => 146
            [todoitem_start_date] => 6
            [todoitem_due_date] => 6
            [todoitem_assigned_date] => 6
            [todoitem_completed_date] => 6
            [todoitem_seq] => 129
            [todoitem_notes] => 34
            [todoitem_crmacct_id] => 1
            [todoitem_ophead_id] => 1
            [todoitem_owner_username] => 34
            [todoitem_priority_id] => 1
            [todoitem_username] => 34
            [todoitem_recurring_todoitem_id] => 1
            [todoitem_cntct_id] => 1
        )

    [todoitem__keys] => Array
        (
            [todoitem_id] => todoitem_todoitem_id_seq
        )

    [translations] => Array
        (
            [id] => 129
            [module] => 130
            [tfile] => 130
            [tlang] => 130
            [tkey] => 130
            [tval] => 34
        )

    [translations__keys] => Array
        (
            [id] => translations_seq
        )

    [trgthist] => Array
        (
            [trgthist_src_cntct_id] => 129
            [trgthist_trgt_cntct_id] => 129
            [trgthist_col] => 162
            [trgthist_value] => 162
        )

    [trialbal] => Array
        (
            [trialbal_id] => 129
            [trialbal_period_id] => 1
            [trialbal_accnt_id] => 1
            [trialbal_beginning] => 1
            [trialbal_ending] => 1
            [trialbal_credits] => 1
            [trialbal_debits] => 1
            [trialbal_dirty] => 18
            [trialbal_yearend] => 129
        )

    [trialbal__keys] => Array
        (
            [trialbal_id] => trialbal_trialbal_id_seq
        )

    [uiform] => Array
        (
            [uiform_id] => 129
            [uiform_name] => 162
            [uiform_order] => 129
            [uiform_enabled] => 146
            [uiform_source] => 162
            [uiform_notes] => 34
        )

    [uiform__keys] => Array
        (
            [uiform_id] => uiform_uiform_id_seq
        )

    [uom] => Array
        (
            [uom_id] => 129
            [uom_name] => 34
            [uom_descrip] => 34
            [uom_item_weight] => 146
        )

    [uom__keys] => Array
        (
            [uom_id] => uom_uom_id_seq
        )

    [uomconv] => Array
        (
            [uomconv_id] => 129
            [uomconv_from_uom_id] => 129
            [uomconv_from_value] => 129
            [uomconv_to_uom_id] => 129
            [uomconv_to_value] => 129
            [uomconv_fractional] => 146
        )

    [uomconv__keys] => Array
        (
            [uomconv_id] => uomconv_uomconv_id_seq
        )

    [uomtype] => Array
        (
            [uomtype_id] => 129
            [uomtype_name] => 162
            [uomtype_descrip] => 34
            [uomtype_multiple] => 146
        )

    [uomtype__keys] => Array
        (
            [uomtype_id] => uomtype_uomtype_id_seq
        )

    [urlinfo] => Array
        (
            [url_id] => 129
            [url_title] => 162
            [url_url] => 162
        )

    [urlinfo__keys] => Array
        (
            [url_id] => urlinfo_url_id_seq
        )

    [usr_bak] => Array
        (
            [usr_id] => 129
            [usr_username] => 162
            [usr_propername] => 34
            [usr_passwd] => 34
            [usr_locale_id] => 129
            [usr_initials] => 34
            [usr_agent] => 146
            [usr_active] => 146
            [usr_email] => 34
            [usr_window] => 34
        )

    [usr_bak__keys] => Array
        (
            [usr_id] => usr_usr_id_seq
        )

    [usrgrp] => Array
        (
            [usrgrp_id] => 129
            [usrgrp_grp_id] => 129
            [usrgrp_username] => 162
        )

    [usrgrp__keys] => Array
        (
            [usrgrp_id] => usrgrp_usrgrp_id_seq
        )

    [usrpref] => Array
        (
            [usrpref_id] => 129
            [usrpref_name] => 34
            [usrpref_value] => 34
            [usrpref_username] => 34
        )

    [usrpref__keys] => Array
        (
            [usrpref_id] => usrpref_usrpref_id_seq
        )

    [usrpriv] => Array
        (
            [usrpriv_id] => 129
            [usrpriv_priv_id] => 1
            [usrpriv_username] => 34
        )

    [usrpriv__keys] => Array
        (
            [usrpriv_id] => usrpriv_usrpriv_id_seq
        )

    [vendaddrinfo] => Array
        (
            [vendaddr_id] => 129
            [vendaddr_vend_id] => 1
            [vendaddr_code] => 34
            [vendaddr_name] => 34
            [vendaddr_comments] => 34
            [vendaddr_cntct_id] => 1
            [vendaddr_addr_id] => 1
            [vendaddr_taxzone_id] => 1
        )

    [vendaddrinfo__keys] => Array
        (
            [vendaddr_id] => vendaddr_vendaddr_id_seq
        )

    [vendinfo] => Array
        (
            [vend_id] => 129
            [vend_name] => 34
            [vend_lastpurchdate] => 6
            [vend_active] => 18
            [vend_po] => 18
            [vend_comments] => 34
            [vend_pocomments] => 34
            [vend_number] => 34
            [vend_1099] => 18
            [vend_exported] => 18
            [vend_fobsource] => 2
            [vend_fob] => 34
            [vend_terms_id] => 1
            [vend_shipvia] => 34
            [vend_vendtype_id] => 1
            [vend_qualified] => 18
            [vend_ediemail] => 34
            [vend_ediemailbody] => 34
            [vend_edisubject] => 34
            [vend_edifilename] => 34
            [vend_accntnum] => 34
            [vend_emailpodelivery] => 18
            [vend_restrictpurch] => 18
            [vend_edicc] => 34
            [vend_curr_id] => 1
            [vend_cntct1_id] => 1
            [vend_cntct2_id] => 1
            [vend_addr_id] => 1
            [vend_match] => 146
            [vend_ach_enabled] => 146
            [vend_ach_accnttype] => 34
            [vend_ach_use_vendinfo] => 146
            [vend_ach_indiv_number] => 162
            [vend_ach_indiv_name] => 162
            [vend_ediemailhtml] => 146
            [vend_ach_routingnumber] => 194
            [vend_ach_accntnumber] => 194
            [vend_taxzone_id] => 1
            [vend_accnt_id] => 1
            [vend_expcat_id] => 1
            [vend_tax_id] => 1
        )

    [vendinfo__keys] => Array
        (
            [vend_id] => vend_vend_id_seq
        )

    [vendtype] => Array
        (
            [vendtype_id] => 129
            [vendtype_code] => 162
            [vendtype_descrip] => 34
        )

    [vendtype__keys] => Array
        (
            [vendtype_id] => vendtype_vendtype_id_seq
        )

    [vodist] => Array
        (
            [vodist_id] => 129
            [vodist_poitem_id] => 1
            [vodist_vohead_id] => 1
            [vodist_costelem_id] => 1
            [vodist_accnt_id] => 1
            [vodist_amount] => 1
            [vodist_qty] => 1
            [vodist_expcat_id] => 1
            [vodist_tax_id] => 1
            [vodist_discountable] => 146
            [vodist_notes] => 34
            [vodist_orig_id] => 1
        )

    [vodist__keys] => Array
        (
            [vodist_id] => vodist_vodist_id_seq
        )

    [vohead] => Array
        (
            [vohead_id] => 129
            [vohead_number] => 34
            [vohead_pohead_id] => 1
            [vohead_posted] => 18
            [vohead_duedate] => 6
            [vohead_invcnumber] => 34
            [vohead_amount] => 1
            [vohead_docdate] => 6
            [vohead_1099] => 18
            [vohead_distdate] => 6
            [vohead_reference] => 34
            [vohead_terms_id] => 1
            [vohead_vend_id] => 1
            [vohead_curr_id] => 1
            [vohead_adjtaxtype_id] => 1
            [vohead_freighttaxtype_id] => 1
            [vohead_gldistdate] => 6
            [vohead_misc] => 18
            [vohead_taxzone_id] => 1
            [vohead_taxtype_id] => 1
            [vohead_notes] => 34
            [vohead_recurring_vohead_id] => 1
            [vohead_oldid] => 1
        )

    [vohead__keys] => Array
        (
            [vohead_id] => vohead_vohead_id_seq
        )

    [voheadtax] => Array
        (
            [taxhist_id] => 129
            [taxhist_parent_id] => 129
            [taxhist_taxtype_id] => 1
            [taxhist_tax_id] => 129
            [taxhist_basis] => 129
            [taxhist_basis_tax_id] => 1
            [taxhist_sequence] => 1
            [taxhist_percent] => 129
            [taxhist_amount] => 129
            [taxhist_tax] => 129
            [taxhist_docdate] => 134
            [taxhist_distdate] => 6
            [taxhist_curr_id] => 1
            [taxhist_curr_rate] => 1
            [taxhist_journalnumber] => 1
        )

    [voheadtax__keys] => Array
        (
            [taxhist_id] => taxhist_taxhist_id_seq
        )

    [voitem] => Array
        (
            [voitem_id] => 129
            [voitem_vohead_id] => 1
            [voitem_poitem_id] => 1
            [voitem_close] => 18
            [voitem_qty] => 1
            [voitem_freight] => 129
            [voitem_taxtype_id] => 1
        )

    [voitem__keys] => Array
        (
            [voitem_id] => voitem_voitem_id_seq
        )

    [voitemtax] => Array
        (
            [taxhist_id] => 129
            [taxhist_parent_id] => 129
            [taxhist_taxtype_id] => 1
            [taxhist_tax_id] => 129
            [taxhist_basis] => 129
            [taxhist_basis_tax_id] => 1
            [taxhist_sequence] => 1
            [taxhist_percent] => 129
            [taxhist_amount] => 129
            [taxhist_tax] => 129
            [taxhist_docdate] => 134
            [taxhist_distdate] => 6
            [taxhist_curr_id] => 1
            [taxhist_curr_rate] => 1
            [taxhist_journalnumber] => 1
        )

    [voitemtax__keys] => Array
        (
            [taxhist_id] => taxhist_taxhist_id_seq
        )

    [whsezone] => Array
        (
            [whsezone_id] => 129
            [whsezone_warehous_id] => 129
            [whsezone_name] => 162
            [whsezone_descrip] => 34
        )

    [whsezone__keys] => Array
        (
            [whsezone_id] => whsezone_whsezone_id_seq
        )

    [whsinfo] => Array
        (
            [warehous_id] => 129
            [warehous_code] => 34
            [warehous_descrip] => 34
            [warehous_fob] => 34
            [warehous_active] => 18
            [warehous_counttag_prefix] => 34
            [warehous_counttag_number] => 1
            [warehous_bol_prefix] => 34
            [warehous_bol_number] => 1
            [warehous_shipping] => 18
            [warehous_useslips] => 18
            [warehous_usezones] => 18
            [warehous_aislesize] => 1
            [warehous_aislealpha] => 18
            [warehous_racksize] => 1
            [warehous_rackalpha] => 18
            [warehous_binsize] => 1
            [warehous_binalpha] => 18
            [warehous_locationsize] => 1
            [warehous_locationalpha] => 18
            [warehous_enforcearbl] => 18
            [warehous_default_accnt_id] => 1
            [warehous_shipping_commission] => 1
            [warehous_cntct_id] => 1
            [warehous_addr_id] => 1
            [warehous_transit] => 146
            [warehous_shipform_id] => 1
            [warehous_shipvia_id] => 1
            [warehous_shipcomments] => 34
            [warehous_costcat_id] => 1
            [warehous_sitetype_id] => 1
            [warehous_taxzone_id] => 1
            [warehous_sequence] => 129
        )

    [whsinfo__keys] => Array
        (
            [warehous_id] => warehous_warehous_id_seq
        )

    [wo] => Array
        (
            [wo_id] => 129
            [wo_number] => 1
            [wo_subnumber] => 1
            [wo_status] => 2
            [wo_itemsite_id] => 1
            [wo_startdate] => 6
            [wo_duedate] => 6
            [wo_ordtype] => 2
            [wo_ordid] => 1
            [wo_qtyord] => 1
            [wo_qtyrcv] => 1
            [wo_adhoc] => 18
            [wo_itemcfg_series] => 1
            [wo_imported] => 18
            [wo_wipvalue] => 1
            [wo_postedvalue] => 1
            [wo_prodnotes] => 34
            [wo_prj_id] => 1
            [wo_priority] => 129
            [wo_brdvalue] => 1
            [wo_bom_rev_id] => 1
            [wo_boo_rev_id] => 1
            [wo_cosmethod] => 2
            [wo_womatl_id] => 1
            [wo_username] => 34
        )

    [wo__keys] => Array
        (
            [wo_id] => wo_wo_id_seq
        )

    [womatl] => Array
        (
            [womatl_id] => 129
            [womatl_wo_id] => 1
            [womatl_itemsite_id] => 1
            [womatl_qtyper] => 129
            [womatl_scrap] => 129
            [womatl_qtyreq] => 129
            [womatl_qtyiss] => 129
            [womatl_qtywipscrap] => 129
            [womatl_lastissue] => 6
            [womatl_lastreturn] => 6
            [womatl_cost] => 1
            [womatl_picklist] => 18
            [womatl_status] => 2
            [womatl_imported] => 18
            [womatl_createwo] => 18
            [womatl_issuemethod] => 2
            [womatl_wooper_id] => 1
            [womatl_bomitem_id] => 1
            [womatl_duedate] => 6
            [womatl_schedatwooper] => 18
            [womatl_uom_id] => 129
            [womatl_notes] => 34
            [womatl_ref] => 34
            [womatl_scrapvalue] => 1
            [womatl_qtyfxd] => 129
        )

    [womatl__keys] => Array
        (
            [womatl_id] => womatl_womatl_id_seq
        )

    [womatlpost] => Array
        (
            [womatlpost_id] => 129
            [womatlpost_womatl_id] => 1
            [womatlpost_invhist_id] => 1
        )

    [womatlpost__keys] => Array
        (
            [womatlpost_id] => womatlpost_womatlpost_id_seq
        )

    [womatlvar] => Array
        (
            [womatlvar_id] => 129
            [womatlvar_number] => 1
            [womatlvar_subnumber] => 1
            [womatlvar_posted] => 6
            [womatlvar_parent_itemsite_id] => 1
            [womatlvar_component_itemsite_id] => 1
            [womatlvar_qtyord] => 1
            [womatlvar_qtyrcv] => 1
            [womatlvar_qtyiss] => 1
            [womatlvar_qtyper] => 1
            [womatlvar_scrap] => 1
            [womatlvar_wipscrap] => 1
            [womatlvar_bomitem_id] => 1
            [womatlvar_ref] => 34
            [womatlvar_notes] => 34
            [womatlvar_qtyfxd] => 129
        )

    [womatlvar__keys] => Array
        (
            [womatlvar_id] => womatlvar_womatlvar_id_seq
        )

    [xsltmap] => Array
        (
            [xsltmap_id] => 129
            [xsltmap_name] => 162
            [xsltmap_doctype] => 162
            [xsltmap_system] => 162
            [xsltmap_import] => 162
            [xsltmap_export] => 162
        )

    [xsltmap__keys] => Array
        (
            [xsltmap_id] => xsltmap_xsltmap_id_seq
        )

    [yearperiod] => Array
        (
            [yearperiod_id] => 129
            [yearperiod_start] => 134
            [yearperiod_end] => 134
            [yearperiod_closed] => 146
        )

    [yearperiod__keys] => Array
        (
            [yearperiod_id] => yearperiod_yearperiod_id_seq
        )

)