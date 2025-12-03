<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class client extends Model
{
    use HasFactory;
    protected $table = 'clients';
    protected $fillable = [
        'full_name',
        'official_email',
        'personal_email',
        'official_contact_name',
        'personal_contact_name',
        'city',
        'full_address',
        'company_name',
        'company_website_url',
    ];
}
