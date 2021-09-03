<?php

namespace Modules\Customer\Entities;

use Illuminate\Database\Eloquent\Model;

class IPayTransactionLog extends Model
{
    
    protected $primaryKey = 'id'; 
    
    protected $table = 'ipay_transaction_logs';
    
    protected $fillable = ['ipay_id', 'transaction_code', 'status',
     'invoice_hashed', 'browser_id_qwh', 'browser_id_afd', 'browser_id_poi',
      'browser_id_uyt', 'browser_id_ifd', 'browser_id_agt', 'amount_sent',
       'custom_p1', 'custom_p2', 'custom_p3', 'custom_p4', 'customer_name',
        'msisdn'];
    
    
}