<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Atributele care pot fi completate în masă.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // rol: principal, secundar, vizualizare
    ];

    /**
     * Atributele ascunse la serializare.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Atributele castate automat.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed', // hash automat
    ];

    /**
     * Verifică dacă utilizatorul este admin principal.
     */
    public function isPrincipal()
    {
        return $this->role === 'principal';
    }

    /**
     * Verifică dacă utilizatorul este admin secundar.
     */
    public function isSecundar()
    {
        return $this->role === 'secundar';
    }

    /**
     * Verifică dacă utilizatorul poate vizualiza datele.
     */
    public function canView()
    {
        return in_array($this->role, ['principal','secundar','vizualizare']);
    }
}
