<?php

namespace Tests\Feature\Auth;

use App\Http\Livewire\HandleForm;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Jetstream\Http\Livewire\UpdateProfileInformationForm;
use Livewire\Livewire;
use Tests\TestCase;

class ProfileInformationTest extends TestCase
{
    use RefreshDatabase;

    public function test_current_profile_information_is_available()
    {
        $this->actingAs($user = User::factory()->create());

        $component = Livewire::test(UpdateProfileInformationForm::class);

        $this->assertEquals($user->name, $component->state['name']);
        $this->assertEquals($user->email, $component->state['email']);
    }

    public function test_profile_information_can_be_updated()
    {
        $this->actingAs($user = User::factory()->create());

        Livewire::test(UpdateProfileInformationForm::class)
                ->set('state', [
                    'name' => 'Test Name', 
                    'bio' => 'Test Test Test', 
                    'email' => 'test@example.com'
                ])
                ->call('updateProfileInformation');

        $this->assertEquals('Test Name', $user->fresh()->name);
        $this->assertEquals('Test Test Test', $user->fresh()->bio);
        $this->assertEquals('test@example.com', $user->fresh()->email);
    }

    public function test_handle_can_be_updated_only_once()
    {
        $this->actingAs($user = User::factory()->create(['handle_set'=>false]));

        Livewire::test(HandleForm::class)
                ->set('handle', 'testhandle')
                ->call('updateHandle');

        $this->assertEquals('testhandle', $user->fresh()->handle);
        
        Livewire::test(HandleForm::class)
                ->set('handle', 'testhandle2')
                ->call('updateHandle');

        $this->assertEquals('testhandle', $user->fresh()->handle); // this should stay the same
    }
}
