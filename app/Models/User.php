<?php

namespace App\Models;

use DateTime;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Notifications\Notifiable;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable implements Auditable
{
    use HasFactory, Notifiable, Sortable;
    use \OwenIt\Auditing\Auditable;

    use SoftDeletes;

    public $sortable = [
        'name',
        'email',
        'password',
        'phone_number',
        'num_doc_identity',
        'city_id',
        'date_of_birth',
        'flag_admin'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone_number',
        'num_doc_identity',
        'city_id',
        'flag_admin',
        'date_of_birth'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $dates = [
        'date_of_birth',
    ];


    /**
     * @return int
     */
    public function getAge(): int
    {
        return $this->date_of_birth->diff(new DateTime('now'))->y;
    }


    public function city()
    {
        return $this->belongsTo('App\City');
    }
}
