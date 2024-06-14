<?php

namespace Tests\Unit\App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tests\Unit\App\Models\Contracts\ModelTestCase;

class UserTest extends ModelTestCase
{
    protected function model() : Model
    {
        return new User();
    }

    protected function expectedTableName() : string
    {
        return 'users';
    }

    protected function expectedTraits() : array
    {
        return [
            HasFactory::class,
            Notifiable::class,
            HasApiTokens::class,
        ];
    }

    protected function expectedFillable() : array
    {
        return [
            'name',
            'email',
            'password',
        ];
    }

    protected function expectedHidden() : array
    {
        return [
            'password',
            'remember_token',
        ];
    }

    protected function expectedCasts() : array
    {
        return [
            ...$this->defaultCasts(),
            'email_verified_at' => 'datetime:Y-m-d H:i:s',
            'password' => 'hashed',
        ];
    }
}