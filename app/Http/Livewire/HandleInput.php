<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;

class HandleInput extends Component
{
    public $handle;
    public $warning;
    public $success;

    public function render()
    {
        if (User::where(['handle'=>$this->handle])->exists()) {
            $this->warning = 'This handle is taken :(';
            $this->success = '';
        } else if (strlen($this->handle) < 4 || strlen($this->handle) > 140) {
            $this->warning = 'must be between 4 and 140 characters';
            $this->success = '';
        } else {
            $this->warning = '';
            $this->success = 'Nice choice :)';
        }
        return view('livewire.handle-input');
    }
}
