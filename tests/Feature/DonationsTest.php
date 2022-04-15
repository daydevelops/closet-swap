<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DonationsTest extends TestCase
{
    /** @test */
    public function a_user_can_access_the_doations_page() {
        $this->get('/donate')->assertStatus(200);
    }

    /** @test */
    public function a_user_can_submit_a_donation() {
        
    }
    
}
