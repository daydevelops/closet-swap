<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DonationsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_access_the_donations_page() {
        $this->get('/donate')->assertStatus(200);
    }

    /** @test */
    public function a_user_can_access_the_donation_success_page() {
        $this->get('/donate/success')->assertStatus(200);
    }

    /** @test */
    public function a_guest_can_submit_a_donation() {
        $res = $this->post('/donate',[
            'cost' => 5,
            'id' => 'tok_visa'
        ])->assertRedirect(route('donate.success'));
    }

    /** @test */
    public function a_user_can_submit_a_donation() {
        $this->signIn();
        $res = $this->post('/donate',[
            'cost' => 5,
            'id' => 'tok_visa'
        ])->assertRedirect(route('donate.success'));
    }

    /** @test */
    public function a_users_donation_value_increases_when_they_donate() {
        $me = $this->signIn();
        $this->assertEquals(0,$me->fresh()->donations);
        $res = $this->post('/donate',[
            'cost' => 5,
            'id' => 'tok_visa'
        ])->assertRedirect(route('donate.success'));
        $this->assertEquals(5,$me->fresh()->donations);
    }

    /** @test */
    public function a_users_donation_value_does_not_increase_if_payment_fails() {
        $tokens = [ // bad cards
            'tok_visa_chargeDeclined',
            'tok_visa_chargeDeclinedInsufficientFunds',
            'tok_visa_chargeDeclinedLostCard',
            'tok_visa_chargeDeclinedStolenCard',
            'tok_chargeDeclinedExpiredCard',
            'tok_chargeDeclinedIncorrectCvc',
            'tok_chargeDeclinedProcessingError',
            'tok_chargeCustomerFail',
            'tok_radarBlock',
            'tok_riskLevelHighest',
            'tok_cvcCheckFail',
        ];
        foreach($tokens as $token) {
            $me = $this->signIn();
            $this->assertEquals(0,$me->fresh()->donations);
            $res = $this->post('/donate',[
                'cost' => 5,
                'id' => $token
            ])->assertStatus(200)->original;
            $this->assertFalse($res['status']);
            $this->assertEquals(0,$me->fresh()->donations);
        }
    }

    /** @test */
    public function a_user_can_donate_with_foreign_cards() {
        $tokens = [
            'tok_au',
            'tok_cn',
            'tok_in',
            'tok_jp',
            'tok_jcb',
            'tok_nz',
            'tok_sg',
            'tok_th_credit',
            'tok_th_debit',
            'tok_ae',
            'tok_at',
            'tok_cz',
            'tok_dk',
            'tok_fr',
            'tok_de',
            'tok_ie',
            'tok_nl',
            'tok_no',
            'tok_pt',
            'tok_pt',
            'tok_gb',
            'tok_gb_debit',
            'tok_gb_mastercard',
            'tok_us',
            'tok_br',
            'tok_ca',
            'tok_mx',
        ];
        foreach($tokens as $token) {
            $me = $this->signIn();
            $this->assertEquals(0,$me->fresh()->donations);
            $res = $this->post('/donate',[
                'cost' => 5,
                'id' => $token
            ])->assertRedirect(route('donate.success'));
            $this->assertEquals(5,$me->fresh()->donations);
        }
    }

    /** @test */
    public function a_user_can_donate_with_many_card_types() {
        $tokens = [
            'tok_visa',
            'tok_visa_debit',
            'tok_mastercard',
            'tok_mastercard_debit',
            'tok_mastercard_prepaid',
            'tok_amex',
            'tok_discover',
            'tok_diners',
            'tok_diners',
            'tok_unionpay',
        ];
        foreach($tokens as $token) {
            $me = $this->signIn();
            $this->assertEquals(0,$me->fresh()->donations);
            $res = $this->post('/donate',[
                'cost' => 5,
                'id' => $token
            ])->assertRedirect(route('donate.success'));
            $this->assertEquals(5,$me->fresh()->donations);
        }
    }

    
}
