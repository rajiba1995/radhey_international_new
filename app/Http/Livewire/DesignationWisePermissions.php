<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Designation;
use App\Models\Permission;

class DesignationWisePermissions extends Component
{
    public $designation_id;
    public $parent_data;
    public $designation_name;
    public $permissions = [];
    public function mount($id){
        $this->designation_id = $id;
        $designation = Designation::findOrFail($id);
        $this->designation_name = $designation->name;
        $this->permissions = $designation->permissions?$designation->permissions->pluck('id')->toArray():[];
    }   

    public function getPermissionData()
    {
        // Fetch all permissions ordered by parent_name
        $permissions = Permission::orderBy('parent_name', 'ASC')->get();

        // Group by parent_name using Laravel's collection methods
        return $permissions->groupBy('parent_name');
    }
    public function updatePermissions()
    {
        $designation = Designation::findOrFail($this->designation_id);
    
        // Sync permissions
        $designation->permissions()->sync($this->permissions);
    
        // Flash message
        session()->flash('message', 'Permissions updated successfully!');
    }
    
    public function render()
    {
        $allPermissions = $this->getPermissionData();
        return view('livewire.designation-wise-permissions', [
            'allPermissions' => $allPermissions
        ]);
    }
}
