<?php

namespace App\Http\Livewire\User;
use App\Models\Country;
use App\Models\User;

use Livewire\Component;

class Profile extends Component
{
    public User $user;
    public $successUser = false;
    public $successPassword = false;
    public $password_confirmation;

    protected $rules = [
        'user.firstname' => 'required',
        'user.lastname' => 'required',
        'user.email' => 'required',
        'user.birthday' => 'nullable', 
        'user.salutation' => 'nullable',
        'user.nationality' => 'nullable',
        'user.telefon' => 'nullable',
        'user.mobile' => 'nullable',
        'user.sozVersNr' => 'nullable',
        'user.birthday' => 'nullable',
        'user.inCHsince' => 'nullable',
        'user.bewilligung' => 'nullable',
        'user.password' => 'nullable',
        'password_confirmation' => 'nullable',
    ];

    public function mount()
    {
        $this->user = auth()->user();
       
    }

    public function updateUser ()
    {
        $this->validate();
        $this->user->save(); 
        $this->successUser = true;
    }

    public function render()
    {
        $countries = Country::all();
        return view('livewire.user.profile', compact('countries'))
            ->layout(\App\View\Components\Layouts\UserDashboard::class);
    }
}
