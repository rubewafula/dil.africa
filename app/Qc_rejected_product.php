<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Qc_rejected_product extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'qc_rejected_products';

    /**
    * The database primary key value.
    *
    * @var string
    */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['product_id', 'reviewed_by', 'rejection_comment', 'status'];

    
    public function product()
    {
        return $this->BelongsTo('Modules\Customer\Entities\Product');
    }
    
    
}