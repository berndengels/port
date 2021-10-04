<?php

namespace Tests\Feature;

use App\Models\AdminUser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LeaveTeamTest extends TestCase
{
    use RefreshDatabase;

    public function test_users_can_leave_teams()
    {
        $user = AdminUser::factory()->withPersonalTeam()->create();

        $user->currentTeam->users()->attach(
            $otherUser = AdminUser::factory()->create(), ['role' => 'admin']
        );

        $this->actingAs($otherUser);

        $response = $this->delete('/teams/'.$user->currentTeam->id.'/members/'.$otherUser->id);

        $this->assertCount(0, $user->currentTeam->fresh()->users);
    }

    public function test_team_owners_cant_leave_their_own_team()
    {
        $this->actingAs($user = AdminUser::factory()->withPersonalTeam()->create());

        $response = $this->delete('/teams/'.$user->currentTeam->id.'/members/'.$user->id);

        $response->assertSessionHasErrorsIn('removeTeamMember', ['team']);

        $this->assertNotNull($user->currentTeam->fresh());
    }
}
