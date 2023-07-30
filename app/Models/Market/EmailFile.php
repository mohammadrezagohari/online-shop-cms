<?php

namespace App\Models\Market;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Market\EmailFile
 *
 * @property int $id
 * @property int $public_mail_id
 * @property string $file_path
 * @property int $file_size
 * @property string $file_type
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|EmailFile newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmailFile newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmailFile onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|EmailFile query()
 * @method static \Illuminate\Database\Eloquent\Builder|EmailFile whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailFile whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailFile whereFilePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailFile whereFileSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailFile whereFileType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailFile whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailFile wherePublicMailId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailFile whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailFile whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailFile withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|EmailFile withoutTrashed()
 * @mixin \Eloquent
 */
class EmailFile extends Model
{
    use HasFactory,SoftDeletes;
    protected $table="public_email_file";
    protected $guarded=["id"];

}
