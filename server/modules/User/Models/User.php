<?php

namespace Modules\User\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{

    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'company_name',
        'legal_form_id',
        'country_id',
        'sector_id',
        'annual_revenue',
        'number_of_employees',
        'number_of_locations',
        'reporting_period',
        'parent_company_id',
        'is_subsidiary',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'annual_revenue' => 'decimal:2',
            'is_subsidiary' => 'boolean',
        ];
    }

    /**
     * Send the password reset notification.
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new \Modules\Auth\Notifications\CustomResetPasswordNotification($token, $this->email));
    }

    /**
     * Get the country associated with this company.
     */
    public function country()
    {
        return $this->belongsTo(\Modules\Country\Models\Country::class);
    }

    /**
     * Get the sector associated with this company.
     */
    public function sector()
    {
        return $this->belongsTo(\Modules\Sector\Models\Sector::class);
    }

    /**
     * Get the legal form of this company.
     */
    public function legalForm()
    {
        return $this->belongsTo(\Modules\Framework\Models\LegalForm::class);
    }

    /**
     * Get the parent company if this is a subsidiary.
     */
    public function parentCompany()
    {
        return $this->belongsTo(User::class, 'parent_company_id');
    }

    /**
     * Get all subsidiaries of this company.
     */
    public function subsidiaries()
    {
        return $this->hasMany(User::class, 'parent_company_id');
    }

    /**
     * Get all reports for this company.
     */
    public function reports()
    {
        return $this->hasMany(\Modules\Reports\Models\Report::class);
    }
}
