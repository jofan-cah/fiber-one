<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Str;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

class UsersTable extends LivewireDatatable
{

    public $model = \App\Models\User::class;
    public function columns()
    {
        return [
            Column::name('user_id')->label('ID')->hide(),
            Column::name('full_name')->label('Nama Panjang')->searchable(),
            Column::name('email')->label('Email'),
            Column::callback(['user_id'], function ($user_id) {
                return view('livewire.actionUser', ['user_id' => $user_id, 'user' => 1]);
            })->label('Action')->alignCenter()->maxWidth('6rem'),
        ];
    }
}
