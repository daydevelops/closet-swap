<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Illuminate\Validation\Rule;

class HandleForm extends Component
{
    public $handle;
    public $warning;
    public $success;

    public function mount() {
        if (auth()->check()) {
            $this->handle = auth()->user()->handle;
        }
    }

    public function render()
    {
        $handle_exists = User::where(['handle'=>$this->handle])->exists();
        $is_my_handle = auth()->check() && $this->handle == auth()->user()->handle;
        if ($handle_exists && !$is_my_handle ) {
            $this->warning = 'This handle is taken :(';
            $this->success = '';
        } else if (strlen($this->handle) < 4 || strlen($this->handle) > 140) {
            $this->warning = 'must be between 4 and 140 characters';
            $this->success = '';
        } else {
            $this->warning = '';
            $this->success = 'Nice choice :)';
        }
        return view('livewire.handle-form');
    }

    public function updateHandle() {
        $handle = $this->handle;

        Validator::make(['handle'=>$handle], [
            'handle' => ['required', 'string', 'alphanum', 'min:4', 'max:140', Rule::unique('users')->ignore(auth()->id())],
        ])->validate();

        if (auth()->user()->handle_set) {
            return false;
        }

        auth()->user()->update([
            'handle' => $handle,
            'handle_set' => true
        ]);

        return redirect(request()->header('Referer'));
    }

}
