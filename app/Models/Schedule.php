<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'subject_id',
        'class_id',
        'teacher_id',
        'day',
        'start_time',
        'end_time',
        'room',
        'semester',
        'academic_year',
        'notes',
    ];

    protected $casts = [
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
    ];

    /**
     * Mata pelajaran
     */
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    /**
     * Kelas
     */
    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    /**
     * Guru pengajar
     */
    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    /**
     * Registrasi untuk jadwal ini
     */
    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }

    /**
     * Scope untuk semester
     */
    public function scopeSemester($query, $semester)
    {
        return $query->where('semester', $semester);
    }

    /**
     * Scope untuk tahun ajaran
     */
    public function scopeAcademicYear($query, $year)
    {
        return $query->where('academic_year', $year);
    }

    /**
     * Scope untuk hari tertentu
     */
    public function scopeDay($query, $day)
    {
        return $query->where('day', $day);
    }

    /**
     * Scope untuk kelas tertentu
     */
    public function scopeForClass($query, $classId)
    {
        return $query->where('class_id', $classId);
    }

    /**
     * Get formatted time range
     */
    public function getTimeRangeAttribute()
    {
        return $this->start_time->format('H:i') . ' - ' . $this->end_time->format('H:i');
    }

    /**
     * Get duration in minutes
     */
    public function getDurationAttribute()
    {
        return $this->start_time->diffInMinutes($this->end_time);
    }
}