<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Notifications\Notifiable;

class CompanyInfo extends Model implements Auditable
{
    use HasFactory, Notifiable, \OwenIt\Auditing\Auditable;

    /**
     * @param $notification
     * @return array
     */
    public function routeNotificationForMail($notification)
    {
        return [$this->email => $this->website_name];
    }

    protected $fillable = [
        'logo_src', 'logo_small_src', 'logo_alt', 'root_url', 'website_name', 'tagline',
        'fax', 'phone', 'email', 'web', 'facebook', 'linkedin', 'company_summary', 'open_days', 'duration'
    ];
}
