
<?php

return [
    // set your mpesa config information
    'key' => env('MPESA_KEY',''),
    'secret' => env('MPESA_SECRET',''),
    'token_url' => env('MPESA_TOKEN_URL',''),
    'c2b_url' => env('MPESA_C2B_URL',''),
    'certificate_path' => env('MPESA_CERTIFICATE_PATH',''),
    'initiator_name' => env('MPESA_INITIATOR_NAME',''),
    'initiator_pass' => env('MPESA_INITIATOR_PASS',''),
    'c2b_paybill' => env('MPESA_C2B_PAYBILL',''),
    'c2b_validation_url' => env('MPESA_C2B_VALIDATION_URL',''),
    'c2b_confirmation_url' => env('MPESA_C2B_CONFIRMATION_URL',''),
    'c2b_sim_paybill' => env('MPESA_C2B_SIM_PAYBILL',''),
    'c2b_sim_amount' => env('MPESA_C2B_SIM_AMOUNT',''),
    'c2b_sim_msisdn' => env('MPESA_C2B_SIM_MSISDN',''),
    'c2b_sim_ref' => env('MPESA_C2B_SIM_REF',''),
    'b2c_timeout_url' => env('MPESA_B2C_TIMEOUT_URL',''),
    'b2c_response_url' => env('MPESA_B2C_RESPONSE_URL',''),
    'b2c_paybill' => env('MPESA_B2C_PAYBILL',''),
    'b2c_message' => env('MPESA_B2C_MESSAGE',''),
    'b2c_remarks' => env('MPESA_B2C_REMARKS',''),
    'error_logfile' => env('MPESA_INFO_LOGFILE',''),
    'error_logfile' => env('MPESA_ERROR_LOGFILE',''),
];