<?php

namespace App\Models;

use App\Models\Market\Article;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Market\Copan;
use App\Models\Market\Order;
use App\Models\Market\Payment;
use App\Models\Market\Product;
use App\Models\Market\Transaction;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
// use Laravel\Cashier\Billable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;


/**
 * App\Models\User
 *
 * @property int $id
 * @property int $avatar 0 => women, 1 => men
 * @property string|null $email
 * @property string $mobile
 * @property mixed|null $password
 * @property string|null $national_code
 * @property string|null $first_name
 * @property string|null $last_name
 * @property string|null $profile_photo_path avatar
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string|null $mobile_verified_at
 * @property int $activation 0 => inactive, 1 => active
 * @property string|null $activation_date
 * @property int $user_type 0 => user, 1 => admin
 * @property int $status
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Otp> $Otps
 * @property-read int|null $otps_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Address> $addresses
 * @property-read int|null $addresses_count
 * @property-read mixed $accesstoken
 * @property-read mixed $full_name
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Order> $orders
 * @property-read int|null $orders_count
 * @property-read \App\Models\Otp|null $otp
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Payment> $payments
 * @property-read int|null $payments_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Product> $products
 * @property-read int|null $products_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereActivation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereActivationDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereMobileVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereNationalCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereProfilePhotoPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUserType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|User withoutTrashed()
 * @property-read int|null $transactions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Role> $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Transaction> $transactions
 * @method static \Illuminate\Database\Eloquent\Builder|User permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|User role($roles, $guard = null)
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Copan> $copans
 * @property-read int|null $copans_count
 * @mixin \Eloquent
 */
class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes , HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'avatar',
        'email',
        'mobile',
        'password',
        'national_code',
        'first_name',
        'last_name',
        'profile_photo_path',
        'email_verified_at',
        'mobile_verified_at',
        'activation',
        'user_type',
        'status'

    ];



    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];




    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function getAccesstokenAttribute()
    {
        return $this->createToken("auth_token")->plainTextToken;
    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }


    public function otp(): HasOne
    {
        return $this->hasOne(Otp::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function transactions():BelongsToMany
    {
        return $this->belongsToMany(Transaction::class);
    }


    public function whereEmailNotNull()
    {
        return $this->where('email','!=',null)->get();
    }


    public function Otps(): HasMany
    {
        return $this->hasMany(Otp::class);
    }


    public function copans():BelongsToMany
    {
        return $this->belongsToMany(Copan::class);
    }


    public function scopeWhereStatus($query,$status){

        return $query->where('status','=',$status);
    }

    public function scopeWhereMobile($query,$mobile){

        return $query->where('mobile','like',"%{$mobile}%");
    }


    public function scopeWhereNationalCode($query,$national_code){

        return $query->where('national_code','like',"%{$national_code}%");
    }


    public function scopeWhereFirstName($query,$first_name){

        return $query->where('first_name','like',"%{$first_name}%");
    }


    public function scopeWhereLastName($query,$last_name){

        return $query->where('last_name','like',"%{$last_name}%");
    }


    public function scopeWhereUserType($query,$user_type){

        return $query->where('user_type','=',"%{$user_type}%");
    }

    public function customProducts()
{
    return $this->belongsToMany(Product::class, 'custom_product_user');
}







}
