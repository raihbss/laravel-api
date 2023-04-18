<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PHPUnit\TextUI\Configuration\NoCustomCssFileException;

class Invoice extends Model
{
    use HasFactory;

    public function customer(){
        return $this -> belongsTo(Customer::class);
    }
}
