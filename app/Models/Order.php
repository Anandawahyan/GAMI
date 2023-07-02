<?php

namespace App\Models;

Use App\Traits\Uuids;
// use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Order extends Model
{
    use HasFactory;
    use Uuids;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'orders';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    // protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'buyer_id',
        'discount_id',
        'order_date',
        'total_amount',
        'ongkir',
        'status_id',
        'est_arrival_date',
        'id_alamat',
        'snap_token'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }

    public function discount()
    {
        return $this->belongsTo(Discount::class, 'discount_id');
    }

    public function alamat()
    {
        return $this->belongsTo(Alamat::class, 'id_alamat');
    }
}
