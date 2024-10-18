<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'department',
        'myhashi', // Add the new column to the fillable array
    ];

    // Mutator to hash and set the value of 'myhashi' column
    public function setMyhashiAttribute($value)
    {
        $this->attributes['myhashi'] = hash('sha256', $value);
    }

    // Override save method to ensure 'myhashi' is hashed before saving
    public function save(array $options = [])
    {
        $this->myhashi = $this->name . $this->description . $this->department;
        parent::save($options);
    }
}
