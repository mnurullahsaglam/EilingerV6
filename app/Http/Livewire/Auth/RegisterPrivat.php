<?php

namespace App\Http\Livewire\Auth;

use App\Http\Traits\AddressUpdateTrait;
use App\Http\Traits\UserUpdateTrait;
use App\Models\User;
use App\Models\Address;
use App\Models\Country;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Validation\Rules\Password;


class RegisterPrivat extends Component
{
    use UserUpdateTrait, AddressUpdateTrait;
    
    public $terms = false;

    public function rules() {
        return [
            'username' => 'required|unique:users,username',
            'telefon' => 'nullable',
            'mobile' => 'nullable',
            'salutation' => 'required',
            'firstname' => 'required|min:2',
            'lastname' => 'required|min:2',
            'email' => 'required|email|unique:users,email',
            'password' => [
                'required',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised()
            ],
            'password_confirmation' => 'required|same:password',
            'street' => 'required|min:3',
            'number' => 'nullable',
            'plz' => 'required|min:4',
            'town' => 'required|min:3',
            'country' => 'required',
            'terms' =>'accepted',
        ];
    }

    protected $messages = [
        //User
        'username.unique' => 'Dieser Benutzername ist bereits vergeben',
        'nameInst.unique' => 'Ihre Organisation ist bereits registriert',
        'emailInst.unique' => 'Diese Email ihrer Organisation ist bereits registriert',

        //Address
        'plz' => 'Postleitzahl ist eine vierstellige Zahl',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function registerPrivat()
    {
        $this->validate();

        $user = User::create([
            'username' => $this->username,
            'type' => 'nat',
            'password' => Hash::make($this->password),
            'salutation' => $this->salutation,
            'website' => $this->website,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'telefon' => $this->telefon,
            'mobile' => $this->mobile,
            'email' => $this->email,
        ]);

        $address = Address::create([
            'user_id' => $user->id,
            'street' => $this->street,
            'number' => $this->number,
            'plz' => $this->plz,
            'town' => $this->town,
            'country' => $this->country,
        ]);
        event(new Registered($user));
        Auth::login($user);
        return redirect('verify-email');
    }


    public function mount()
    {
        $this->model = User::class;
        request()->session()->forget('valid-username');
        request()->session()->forget('valid-nameInst');
        request()->session()->forget('valid-emailInst');
        
        $this->model = Address::class;
        request()->session()->forget('valid-street');
        request()->session()->forget('valid-number');
        request()->session()->forget('valid-plz');
        request()->session()->forget('valid-town');
    }

    public function render()
    {
        $countries = Country::all();
        return view('livewire.auth.register_privat', compact('countries'))
            ->layout(\App\View\Components\Layouts\Eilinger::class);
            
    }
}