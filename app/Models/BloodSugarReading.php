<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BloodSugarReading extends Model
{
    use HasFactory;

    protected $fillable = ['level', 'meal_context', 'notes'];

    protected $casts = [
        'level' => 'decimal:2',
    ];

    /**
     * Get the status based on blood sugar level and meal context.
     * Values in mg/dL
     */
    public function getStatusAttribute(): string
    {
        $level = (float) $this->level;

        return match($this->meal_context) {
            'fasting', 'before_meal' => match(true) {
                $level < 70  => 'low',
                $level <= 99 => 'normal',
                $level <= 125 => 'elevated',
                default      => 'high',
            },
            'after_meal' => match(true) {
                $level < 70  => 'low',
                $level <= 139 => 'normal',
                $level <= 199 => 'elevated',
                default       => 'high',
            },
            'bedtime' => match(true) {
                $level < 100 => 'low',
                $level <= 140 => 'normal',
                default       => 'high',
            },
            default => match(true) {  // random
                $level < 70  => 'low',
                $level <= 140 => 'normal',
                $level <= 199 => 'elevated',
                default       => 'high',
            },
        };
    }

    /**
     * Get a suggestion based on status and meal context.
     */
    public function getSuggestionAttribute(): string
    {
        return match($this->status) {
            'low' => match($this->meal_context) {
                'fasting'     => 'Your fasting glucose is low. Eat a small snack with carbs (e.g., fruit or crackers) and recheck in 15 minutes. Consult your doctor if this happens often.',
                'before_meal' => 'Blood sugar is low before eating. Have your meal soon or take a small fast-acting carb snack. Avoid skipping meals.',
                'after_meal'  => 'Unusual to have low sugar after eating. Consider checking your medication dosage with your doctor.',
                'bedtime'     => 'Bedtime glucose is low — risk of overnight hypoglycemia. Have a small snack (e.g., peanut butter on crackers) and consult your doctor.',
                default       => 'Your blood sugar is low. Consume 15g of fast-acting carbs (e.g., juice, glucose tablets) and recheck in 15 minutes.',
            },
            'normal' => 'Great job! Your blood sugar is in the normal range. Keep maintaining a balanced diet, regular exercise, and proper hydration.',
            'elevated' => match($this->meal_context) {
                'fasting'     => 'Fasting glucose is slightly elevated (pre-diabetic range). Reduce refined carbs, increase fiber intake, and consider a morning walk. Follow up with your doctor.',
                'after_meal'  => 'Post-meal glucose is a bit high. Try reducing portion sizes, choosing lower-GI foods, and taking a 10–15 min walk after meals.',
                default       => 'Blood sugar is slightly elevated. Monitor your diet, avoid sugary drinks, and stay active. Track this trend and consult your doctor.',
            },
            'high' => match($this->meal_context) {
                'fasting'     => 'Fasting glucose is significantly high. This may indicate poor overnight control. Contact your doctor promptly — medication adjustment may be needed.',
                'after_meal'  => 'Post-meal glucose is dangerously high. Avoid high-carb and sugary foods. If you use insulin, check your dosage timing with your doctor immediately.',
                'bedtime'     => 'Bedtime glucose is very high. Avoid late-night carbs and contact your healthcare provider about your evening management plan.',
                default       => 'Blood sugar is critically high. Drink water, avoid carbohydrates, and seek medical attention if you feel unwell (headache, fatigue, nausea).',
            },
            default => 'Monitor your levels regularly and consult your healthcare provider.',
        };
    }

    /**
     * Status badge color classes for Tailwind.
     */
    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'low'      => 'bg-blue-100 text-blue-800 border-blue-300',
            'normal'   => 'bg-green-100 text-green-800 border-green-300',
            'elevated' => 'bg-yellow-100 text-yellow-800 border-yellow-300',
            'high'     => 'bg-red-100 text-red-800 border-red-300',
            default    => 'bg-gray-100 text-gray-800 border-gray-300',
        };
    }

    /**
     * Status icon.
     */
    public function getStatusIconAttribute(): string
    {
        return match($this->status) {
            'low'      => '🔵',
            'normal'   => '🟢',
            'elevated' => '🟡',
            'high'     => '🔴',
            default    => '⚪',
        };
    }

    public function getMealContextLabelAttribute(): string
    {
        return match($this->meal_context) {
            'fasting'     => 'Fasting',
            'before_meal' => 'Before Meal',
            'after_meal'  => 'After Meal',
            'bedtime'     => 'Bedtime',
            'random'      => 'Random',
            default       => ucfirst($this->meal_context),
        };
    }
}