<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class DataIsolationTest extends TestCase
{
    /**
     * Test that each employer only sees their own job listings
     */
    public function test_each_employer_sees_only_their_own_jobs()
    {
        // Login as John Doe (user ID 1, pemberi kerja ID 1)
        $johnDoe = User::find(1);
        $this->actingAs($johnDoe);
        
        $response = $this->get(route('pemberi-kerja.dashboard'));
        $response->assertStatus(200);
        
        // John Doe should see his own jobs
        $this->assertStringContainsString('Dibutuhkan Tukang Bersih-bersih Rumah', $response->getContent());
        $this->assertStringContainsString('Butuh Tukang Bangunan untuk Renovasi', $response->getContent());
        $this->assertStringContainsString('Front-End Web Dev', $response->getContent());
    }

    /**
     * Test that Ahmad Rizki only sees his own jobs
     */
    public function test_ahmad_rizki_sees_only_his_jobs()
    {
        // Login as Ahmad Rizki (user ID 3, pemberi kerja ID 2)
        $ahmadRizki = User::find(3);
        $this->actingAs($ahmadRizki);
        
        $response = $this->get(route('pemberi-kerja.dashboard'));
        $response->assertStatus(200);
        
        // Ahmad Rizki should see his own jobs
        $this->assertStringContainsString('Asisten Rumah Tangga Part Time', $response->getContent());
        $this->assertStringContainsString('Tukang Kebun Harian', $response->getContent());
        
        // Ahmad Rizki should NOT see John Doe's jobs
        $this->assertStringNotContainsString('Dibutuhkan Tukang Bersih-bersih Rumah', $response->getContent());
        $this->assertStringNotContainsString('Butuh Tukang Bangunan untuk Renovasi', $response->getContent());
    }

    /**
     * Test that lowongan show page shows 403 if not owner
     */
    public function test_lowongan_show_returns_403_if_not_owner()
    {
        // Login as Ahmad Rizki
        $ahmadRizki = User::find(3);
        $this->actingAs($ahmadRizki);
        
        // Try to access John Doe's lowongan (ID 1)
        $response = $this->get(route('pemberi-kerja.lowongan.show', 1));
        $response->assertStatus(403);
    }

    /**
     * Test that Ahmad Rizki can access his own lowongan
     */
    public function test_lowongan_show_returns_200_if_owner()
    {
        // Login as Ahmad Rizki
        $ahmadRizki = User::find(3);
        $this->actingAs($ahmadRizki);
        
        // Access Ahmad's lowongan (ID 3 belongs to pemberi kerja ID 2 which is Ahmad)
        $response = $this->get(route('pemberi-kerja.lowongan.show', 3));
        $response->assertStatus(200);
        $this->assertStringContainsString('Asisten Rumah Tangga Part Time', $response->getContent());
    }
}
