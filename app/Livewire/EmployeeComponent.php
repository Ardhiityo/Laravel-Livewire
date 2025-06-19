<?php

namespace App\Livewire;

use App\Models\Employee;
use Livewire\Component;
use Livewire\WithPagination;

class EmployeeComponent extends Component
{
    use WithPagination;

    public $name;
    public $email;
    public $address;
    protected $paginationTheme = 'bootstrap';

    protected $rules = [
        'name' => 'required|min:3',
        'email' => 'required|email',
        'address' => 'required|min:3'
    ];

    public function store()
    {
        $this->validate();

        Employee::create([
            'name' => $this->name,
            'email' => $this->email,
            'address' => $this->address
        ]);

        $this->name = '';
        $this->email = '';
        $this->address = '';


        session()->flash('notes', 'Berhasil dibuat');
    }

    public function render()
    {
        $employees = Employee::orderByDesc('id')->paginate(1);

        return view('livewire.employee-component', compact('employees'));
    }
}
