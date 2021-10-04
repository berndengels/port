<?php

namespace App\Policies;

use App\Models\Team;
use App\Models\AdminUser;
use Illuminate\Auth\Access\HandlesAuthorization;

class TeamPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param AdminUser $user
     * @return mixed
     */
    public function viewAny(AdminUser $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param AdminUser $user
     * @param Team $team
     * @return mixed
     */
    public function view(AdminUser $user, Team $team)
    {
        return $user->belongsToTeam($team);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param AdminUser $user
     * @return mixed
     */
    public function create(AdminUser $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param AdminUser $user
     * @param Team $team
     * @return mixed
     */
    public function update(AdminUser $user, Team $team)
    {
        return $user->ownsTeam($team);
    }

    /**
     * Determine whether the user can add team members.
     *
     * @param AdminUser $user
     * @param Team $team
     * @return mixed
     */
    public function addTeamMember(AdminUser $user, Team $team)
    {
        return $user->ownsTeam($team);
    }

    /**
     * Determine whether the user can update team member permissions.
     *
     * @param AdminUser $user
     * @param Team $team
     * @return mixed
     */
    public function updateTeamMember(AdminUser $user, Team $team)
    {
        return $user->ownsTeam($team);
    }

    /**
     * Determine whether the user can remove team members.
     *
     * @param AdminUser $user
     * @param Team $team
     * @return mixed
     */
    public function removeTeamMember(AdminUser $user, Team $team)
    {
        return $user->ownsTeam($team);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param AdminUser $user
     * @param Team $team
     * @return mixed
     */
    public function delete(AdminUser $user, Team $team)
    {
        return $user->ownsTeam($team);
    }
}
