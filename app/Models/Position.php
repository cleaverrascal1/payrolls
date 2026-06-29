<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Position extends Model
{
    use HasFactory, HasUuids;

    /**
     * The table associated with the model.
     *
     * @var string
     */

    protected $table = 'positions';

    /**
     * The primary key associated with the table.
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
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'basic_salary',
        'sales_target',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'basic_salary' => 'integer',
        'sales_target' => 'integer',
    ];

    /**
     * Get the employees for the position.
     */
    public function employees(): HasMany
    {
        return $this->hasMany(Employee::class);
    }

    /**
     * Get the bonus rules for the position.
     */
    public function bonusRules(): HasMany
    {
        return $this->hasMany(PositionBonusRule::class);
    }

    /**
     * Get the performance bonuses for the position.
     */
    public function performanceBonuses(): HasMany
    {
        return $this->hasMany(PositionPerformanceBonus::class);
    }

    /**
     * Get the penalties for the position.
     */
    public function penalties(): HasMany
    {
        return $this->hasMany(PositionPenalty::class);
    }
}
