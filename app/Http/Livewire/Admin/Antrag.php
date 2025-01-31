<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Application;
use App\Models\User;
use App\Models\Address;
use App\Models\Education;
use App\Models\Account;
use App\Models\Parents;
use App\Models\Sibling;

class Antrag extends Component
{
    public $application;
    public $user;
    public $address;
    public $abweichendeAddress;
    public $education;
    public $account;
    public $parents;
    public $siblings;


    public function mount($application_id) 
    {
        $this->application = Application::where('id', $application_id)->first();
        $this->user = User::where('id',$this->application->user_id)->first();
        $this->address = Address::where('user_id', $this->user->id)
            ->where('isWochenaufenthalt', 0)    
            ->first();
        $this->abweichendeAddress = Address::where('user_id', $this->user->id)
            ->where('isWochenaufenthalt', 1)
            ->first();
        $this->education = Education::where('application_id', $application_id)->first();
        $this->account = Account::where('application_id', $application_id)->first();
        $this->parents = Parents::where('user_id', $this->user->id)->get();
        $this->siblings = Sibling::where('user_id', $this->user->id)->get();
        
    }
    public function render()
    {
        return view('livewire.admin.antrag')
            ->layout(\App\View\Components\Layouts\AdminDashboard::class);
    }
}
