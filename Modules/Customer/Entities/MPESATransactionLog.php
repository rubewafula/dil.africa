<?php

namespace Modules\Customer\Entities;

use Illuminate\Database\Eloquent\Model;

class MPESATransactionLog extends Model
{
    
    protected $primaryKey = 'id'; 
    
    protected $table = 'mpesa_transaction_logs';
    
    protected $fillable = ['transaction_type', 'transaction_id', 'transaction_time',
     'transaction_amount', 'business_code', 'bill_ref_no', 'invoice_number',
      'org_account_balance', 'third_party_trans_id', 'msisdn', 'first_name',
       'middle_name', 'last_name'];
    
    
}