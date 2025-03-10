<?php

namespace App\Models;

use App\ValueObjects\SpellSlot as SpellSlotValue;
use Illuminate\Database\Eloquent\Model;

class SpellSlot extends Model
{
    protected $fillable = [
        'level',
        'school',
        'origin',
        'type',
        'counter_data'
    ];

    protected $casts = [
        'counter_data' => 'json',
        'level' => 'integer'
    ];

    // Convert to value object
    public function toValueObject(): SpellSlotValue
    {
        return SpellSlotValue::fromArray([
            'counter' => $this->counter_data,
            'level' => $this->level,
            'school' => $this->school,
            'origin' => $this->origin,
            'type' => $this->type
        ]);
    }

    // Create from value object
    public static function fromValueObject(SpellSlotValue $spellSlot): self
    {
        $data = $spellSlot->jsonSerialize();
        return new self([
            'level' => $data['level'],
            'school' => $data['school'],
            'origin' => $data['origin'],
            'type' => $data['type'],
            'counter_data' => $data['counter']
        ]);
    }

    public function scopeByLevel($query, int $level)
    {
        return $query->where('level', $level);
    }

    public function scopeBySchool($query, string $school)
    {
        return $query->where('school', $school);
    }

    public function scopeByType($query, string $type)
    {
        return $query->where('type', $type);
    }
}
