<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    use HasFactory;

    public $timestamps = true;

    protected $fillable = [
        "income_id",
        "number",
        "date",
        "last_change_date",
        "supplier_article",
        "tech_size",
        "barcode",
        "quantity",
        "total_price",
        "date_close",
        "warehouse_name",
        "nm_id"
    ];

    protected $casts = [
        "date" => "date:Y-m-d",
        "last_change_date" => "date:Y-m-d",
    ];
}
