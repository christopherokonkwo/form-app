<?php

namespace App\Models;

use App\Mail\IncidentReported;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Mail;

class IncidentReport extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'user_id',
        'name',
        'phone',
        'location',
        'machine_number',
        'machine_type',
        'incident_detail_option',
        'incident_details',
        'additional_notes',
        'recieved_by',
        'reported_by',
        'assigned_to',
        'assigned_at',
        'status',
    ];

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The number of models to return for pagination.
     *
     * @var int
     */
    protected $perPage = 10;

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::created(function ($incidentReport) {
            Mail::to([
                    'xtopherc43@gmail.com',
                    // 'maxwelnzekwe@gmail.com',
                    'it@promatic.ng',
                ])
                ->send(new IncidentReported($incidentReport));
        });
    }

    public function assignedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
