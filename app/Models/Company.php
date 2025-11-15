<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'code',
        'active'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'active' => 'boolean',
    ];

    /**
     * Get the attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'deleted_at',
    ];

    /**
     * Get the users for the company.
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * Get the projects for the company.
     */
    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }

    /**
     * Scope a query to only include active companies.
     */
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    /**
     * Scope a query to only include inactive companies.
     */
    public function scopeInactive($query)
    {
        return $query->where('active', false);
    }

    /**
     * Get the company by code.
     */
    public static function findByCode(string $code): ?self
    {
        return static::where('code', $code)->first();
    }

    /**
     * Check if company has users.
     */
    public function hasUsers(): bool
    {
        return $this->users()->exists();
    }

    /**
     * Check if company has projects.
     */
    public function hasProjects(): bool
    {
        return $this->projects()->exists();
    }

    /**
     * Activate the company.
     */
    public function activate(): void
    {
        $this->update(['active' => true]);
    }

    /**
     * Deactivate the company.
     */
    public function deactivate(): void
    {
        $this->update(['active' => false]);
    }

    /**
     * Get the company's statistics.
     */
    public function getStats(): array
    {
        return [
            'users_count' => $this->users()->count(),
            'projects_count' => $this->projects()->count(),
            'active_projects_count' => $this->projects()->where('state', '!=', 'Finished')->count(),
            'total_data_records' => $this->projects()->withCount('data')->get()->sum('data_count'),
        ];
    }
}
