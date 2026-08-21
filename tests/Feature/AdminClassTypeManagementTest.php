<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminClassTypeManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_manage_class_type_master_data(): void
    {
        $admin = User::factory()->create([
            'name' => 'Admin Test',
            'email' => 'admin@test.com',
            'role' => 'admin',
            'password' => bcrypt('password123'),
        ]);

        $this->actingAs($admin);

        $this->get(route('admin.class-types'))
            ->assertOk();

        $this->post(route('admin.class-types.store'), [
            'code' => 'A',
            'name' => 'Kelas A',
            'description' => 'Tipe kelas utama',
        ])->assertRedirect(route('admin.class-types'))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('practicum_class_types', [
            'code' => 'A',
            'name' => 'Kelas A',
        ]);

        $type = \App\Models\PracticumClassType::first();

        $this->delete(route('admin.class-types.destroy', $type))
            ->assertRedirect(route('admin.class-types'))
            ->assertSessionHas('success');

        $this->assertDatabaseMissing('practicum_class_types', [
            'id' => $type->id,
        ]);
    }
}
