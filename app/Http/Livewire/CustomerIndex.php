<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\UsersImport;
use App\Exports\UsersExport;
use App\Exports\UserAddressExport;
use App\Imports\UserAddressImport;
use App\Exports\UsersAndAddressesExport;
use App\Imports\UsersWithAddressesImport;
use App\Exports\SampleUserAndAddressExport;

// use Livewire\WithFileUploads; // Import file upload trait



class CustomerIndex extends Component
{
    use WithPagination, WithFileUploads;

    public $search;
    public $file;

    protected $updatesQueryString = ['search'];
    
    public function confirmDelete($id){
        $this->dispatch('showDeleteConfirm',['itemId' => $id]);
    }

    public function deleteCustomer($id)
    {
        $user = User::find($id);

        if ($user) {
            $user->delete();
            session()->flash('success', 'Customer deleted successfully');
        } else {
            session()->flash('error', 'Customer not found');
        }
    }

    public function toggleStatus($id){
        $user = User::find($id);
        $user->status = !$user->status;
        $user->save();
        session()->flash('success','Customer status updated successfully');
    }
    public function FindCustomer($keywords){
        $this->search = $keywords;
    }
    public function resetForm(){
        $this->reset(['search']);
    }
    // public function import()
    // {
    //     $this->validate([
    //         'file' => 'required|file|mimes:xlsx,csv|max:2048', // Ensure valid file format
    //     ]);
    
    //     try {
    //         Excel::import(new UsersWithAddressesImport(), $this->file->getRealPath()); // Pass file correctly
    //         session()->flash('success', 'Customers and addresses imported successfully!');
    //         $this->file = null; // Reset file input
    //     } catch (\Exception $e) {
    //         session()->flash('error', 'Import failed: ' . $e->getMessage());
    //     }
    // }
    protected $rules = [
        'file' => 'required|mimes:xlsx,csv|max:2048', // Validate file type and size
    ];

    public function import()
    {
        $this->validate(); // Validate the file input

        // Store the uploaded file in storage
        $path = $this->file->store('imports');

        // Perform the import
        Excel::import(new UsersWithAddressesImport, storage_path('app/' . $path));

        // Reset file input
        $this->reset('file');

        // Send success message
        session()->flash('success', 'Users imported successfully!');
    }
    
    // Export Function
    public function export()
    {
        // return Excel::download(new UsersExport, 'users.xlsx');
        return Excel::download(new UsersAndAddressesExport(), 'customers_and_addresses.csv');
    }

    public function sampleExport()
    {
        // return Excel::download(new UsersExport, 'users.xlsx');
        return Excel::download(new SampleUserAndAddressExport(), 'customers_and_addresses.csv');
    }
    public function exportAddresses()
    {
        return Excel::download(new UserAddressExport, 'user_addresses.xlsx');
    }

    public function render()
    {
        $users = User::where('user_type',1)
        ->when($this->search, function ($query) {
            $query->where('name', 'like', '%' . $this->search . '%');
        })->paginate(10);
        
        return view('livewire.customer-index', compact('users'));
    }
}
