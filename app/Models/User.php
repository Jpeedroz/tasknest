<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'lembretes_email',
        'lembrete_dias_padrao',
    ];

    /** Valores padrão (iguais aos do banco) para usuários recém-criados. */
    protected $attributes = [
        'lembretes_email' => true,
        'lembrete_dias_padrao' => 1,
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'lembretes_email' => 'boolean',
            'lembrete_dias_padrao' => 'integer',
        ];
    }

    /**
     * Get the tarefas for the user.
     */
    public function tarefas()
    {
        return $this->hasMany(\App\Models\Tarefa::class);
    }
}
