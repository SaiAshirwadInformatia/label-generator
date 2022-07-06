<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Support\Str;
use Livewire\Component;

class UserForm extends Component
{
    public User $user;

    protected array $rules = [
        'user.name'    => 'required',
        'user.email'   => 'required|email',
        'user.company' => 'nullable',
        'user.level'   => 'required',
    ];

    public function render()
    {
        return view('livewire.user-form', [
            'levels' => [
                'user'  => 'User',
                'admin' => 'Admin',
            ],
        ]);
    }

    public function submitForm()
    {
        if (!$this->user->password) {
            $this->user->password = Str::random();
        }
        $this->validate();

        $this->user->save();

        session()->flash('success', 'User details saved successfully');

        return redirect()->route('users.index');
    }
}
