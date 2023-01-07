<?php
  
namespace App\Http\Livewire\User;

use App\Models\Account;
use Livewire\Component;
use App\Models\User;
use App\Models\Address;
use App\Models\Cost;
use App\Models\Education;
use App\Models\Enclosure;
use App\Models\Financing;
use App\Models\Parents;
use App\Models\Sibling;
use App\Models\Country;
use Carbon\Carbon;

class Antrag extends Component
{
    public $currentStep = 1;
    public $successMessage = '';
    public $message = '';
    public $birthday;
    public User $user;
    public Address $address;
    public Address $abweichendeAddress;
    public Education $education;
    public Account $account;
    public Parents $mother;
    public Parents $father;
    public Parents $stepmother;
    public Parents $stepfather;
    public Sibling $sibling;
    public Cost $cost;
    public Financing $financing;
    public Enclosure $enclosure;

    protected $casts = [
        'birthday' => 'date:d.m.Y',
    ];
  
    public function mount() 
    {
        $this->user = auth()->user();
        $this->address = $this->user->address->first();
        $this->abweichendeAddress = Address::firstOrNew([
            'isWochenaufenthalt' => true,
            'user_id' => $this->user->id,
        ]);
        $this->education = Education::firstOrNew([
            'user_id' => $this->user->id,
        ]);
        $this->account = Account::firstOrNew([
            'user_id' => $this->user->id,
        ]);
        $this->mother = Parents::firstOrNew([
            'user_id' => $this->user->id,
            'parent_type' => 'mother',
        ]);
        $this->father = Parents::firstOrNew([
            'user_id' => $this->user->id,
            'parent_type' => 'father',
        ]);
        $this->stepmother = Parents::firstOrNew([
            'user_id' => $this->user->id,
            'parent_type' => 'stepmother',
        ]);
        $this->stepfather = Parents::firstOrNew([
            'user_id' => $this->user->id,
            'parent_type' => 'stepfather',
        ]);
        $this->sibling = Sibling::firstOrNew([
            'user_id' => $this->user->id,
        ]);
        $this->cost = Cost::firstOrNew([
            'user_id' => $this->user->id,
        ]);
        $this->financing = Financing::firstOrNew([
            'user_id' => $this->user->id,
        ]);


        //$this->user->birthday = Carbon::createFromFormat('Y-m-d', (auth()->user()->birthday))->format('d.m.Y');
        //$this->user->birthday = Carbon::parse((auth()->user()->birthday))->format('d.m.Y');
    }
    
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
        'address.street' => 'nullable',
        'address.number' => 'nullable',
        'address.town' => 'nullable',
        'address.plz' => 'nullable',
        'address.country' => 'nullable',
        'abweichendeAddress.street' => 'nullable',
        'abweichendeAddress.number' => 'nullable',
        'abweichendeAddress.town' => 'nullable',
        'abweichendeAddress.plz' => 'nullable',
        'abweichendeAddress.country' => 'nullable',
        'education.education' => 'nullable',
        'education.name' => 'nullable',
        'education.final' => 'nullable',
        'education.grade' => 'nullable',
        'education.ects-points' => 'nullable',
        'education.time' => 'nullable',
        'account.name_bank' => 'nullable',
        'account.city_bank' => 'nullable',
        'account.owner' => 'nullable',
        'account.IBAN' => 'nullable',
        'mother.lastname' => 'nullable',
        'mother.firstname' => 'nullable',
        'mother.birthday' => 'nullable',
        'mother.telefon' => 'nullable',
        'mother.address' => 'nullable',
        'mother.plz_ort' => 'nullable',
        'mother.since' => 'nullable',
        'mother.job_type' => 'nullable',
        'mother.job' => 'nullable',
        'mother.employer' => 'nullable',
        'mother.inCHsince' => 'nullable',
        'mother.marriedSince' => 'nullable',
        'mother.separatedSince' => 'nullable',
        'mother.divorcedSince' => 'nullable',
        'mother.death' => 'nullable',
        'father.lastname' => 'nullable',
        'father.firstname' => 'nullable',
        'father.birthday' => 'nullable',
        'father.telefon' => 'nullable',
        'father.address' => 'nullable',
        'father.plz_ort' => 'nullable',
        'father.since' => 'nullable',
        'father.job_type' => 'nullable',
        'father.job' => 'nullable',
        'father.employer' => 'nullable',
        'father.inCHsince' => 'nullable',
        'father.marriedSince' => 'nullable',
        'father.separatedSince' => 'nullable',
        'father.divorcedSince' => 'nullable',
        'father.death' => 'nullable',
        'stepmother.lastname' => 'nullable',
        'stepmother.firstname' => 'nullable',
        'stepmother.address' => 'nullable',
        'stepmother.plz_ort' => 'nullable',
        'stepmother.employer' => 'nullable',
        'stepfather.lastname' => 'nullable',
        'stepfather.firstname' => 'nullable',
        'stepfather.address' => 'nullable',
        'stepfather.plz_ort' => 'nullable',
        'stepfather.employer' => 'nullable',
        'sibling.birth_year' => 'nullable',
        'sibling.lastname' => 'nullable',
        'sibling.firstname' => 'nullable',
        'sibling.education' => 'nullable',
        'sibling.graduation_year' => 'nullable',
        'sibling.placeOfResidence' => 'nullable',
        'sibling.getAmount' => 'nullable',
        'sibling.supportSite' => 'nullable',
        'cost.semesterFees' => 'nullable',
        'cost.fees' => 'nullable',
        'cost.educationalMaterial' => 'nullable',
        'cost.excursion' => 'nullable',
        'cost.travelExpenses' => 'nullable',
        'cost.costOfLivingWithParents' => 'nullable',
        'cost.costOfLivingAlone' => 'nullable',
        'cost.costOfLivingAlone' => 'nullable',
        'cost.costOfLivingWithPartner' => 'nullable',
        'cost.numberOfChildren' => 'nullable',
        'financing.personalContribution' => 'nullable',
        'financing.otherIncome' => 'nullable',
        'financing.incomeWhere' => 'nullable',
        'financing.incomeWho' => 'nullable',
        'financing.nettoIncome' => 'nullable',
        'financing.assets' => 'nullable',
        'financing.scholarship' => 'nullable',
        'enclosure.hasID',
        'enclosure.hasCV',
        'enclosure.hasApprenticeshipContract',
        'enclosure.hasDiploma',
        'enclosure.hasDivorce',
        'enclosure.hasRentalContract',
        'enclosure.hasCertificateOfStudy',
        'enclosure.hasTaxAssessment',
        'enclosure.hasExpenseReceipts',
        'enclosure.hasPartnerTaxAssessment',
        'enclosure.hasSupplementaryServices',
        'enclosure.hasECTSPoints',
        'enclosure.hasParentsTaxFactors'
    ];
    
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function render()
    {
        $countries = Country::all();
        $user = User::findOrfail(auth()->user()->id);

        return view('livewire.user.antrag', compact('countries', 'user'))
            ->layout(\App\View\Components\Layouts\UserDashboard::class);
    }
  
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function Step1UserSubmit()
    {
        $this->user->save();
        $this->currentStep = 2;
    }
  
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function Step2AddressSubmit()
    {
        $this->address->save();
        $this->currentStep = 3;
    }

    public function Step3AweichendeAddressSubmit()
    {
        $this->abweichendeAddress->user_id = auth()->user()->id;
        $this->abweichendeAddress->isWochenaufenthalt = true;
        $this->abweichendeAddress->save();
        $this->currentStep = 4;
    }


    public function Step4EducationSubmit()
    {
        $this->education->user_id = auth()->user()->id;
        $this->education->save();
        $this->currentStep = 5;
    }

    public function Step5AccountSubmit()
    {
        $this->account->user_id = auth()->user()->id;
        $this->account->save();
        $this->currentStep = 6;
    }

    public function Step6ParentsSubmit()
    {
        $this->father->user_id = auth()->user()->id;
        $this->father->parent_type ='father';
        $this->father->save();
        $this->mother->user_id = auth()->user()->id;
        $this->mother->parent_type ='mother';
        $this->mother->save();
        $this->stepmother->user_id = auth()->user()->id;
        $this->stepmother->parent_type ='stepmother';
        $this->stepmother->save();
        $this->stepfather->user_id = auth()->user()->id;
        $this->stepfather->parent_type ='stepfather';
        $this->stepfather->save();
        $this->currentStep = 7;
    }
    public function Step7SiblingSubmit()
    {
        $this->sibling->user_id = auth()->user()->id;
        $this->sibling->save();
        $this->currentStep = 8;
    }

    public function Step8CostSubmit()
    {
        $this->cost->user_id = auth()->user()->id;
        $this->cost->save();
        $this->currentStep = 9;
    }

    public function Step9FinancingSubmit()
    {
        $this->financing->user_id = auth()->user()->id;
        $this->financing->save();
        $this->currentStep = 10;
    }

    public function SendApplication()
    {
        
    }
  
    public function increaseStep()
    {
        $this->currentStep++;
        $this->emit('moveNext');
    }

    public function decreaseStep()
    {
        $this->currentStep--;
        $this->emit('movePrevious');
    }

}