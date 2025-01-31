<?php

namespace App\Http\Livewire\User;

use Livewire\Component;
use App\Models\Application;

class Antraege extends Component
{
    public $showModal = false;
    public $name;
    public $bereich;
    public $form;

    protected $rules = [
        'name' => 'required',
        'bereich' => 'required',
        'form' => 'required',
    ];

    public function render()
    {
        $applications = Application::where ('user_id', auth()->user()->id)->get();
        return view('livewire.user.antraege', [
            'applications' => $applications
        ])
            ->layout(\App\View\Components\Layouts\UserDashboard::class);
    }

    public function addApplication() 
    {
        $this->showModal = true; 
    }

    public function deleteApplication($id)
    {
       Application::find($id)->delete();
       session()->flash('success', 'Antrag erfolgreich gelöscht'); 
    }

    public function save()
    {
        $this->validate();

        $application= Application::create([
            'name' => $this->name,
            'bereich' => $this->bereich,
            'user_id' => auth()->user()->id,
            'form' => $this->form,
        ]);
        
        $this->name = '';
        $this->bereich = '';
        $this->form = '';

        $this->showModal = false;
    }

    public function close()
    {
        $this->showModal = false;
    }
}
