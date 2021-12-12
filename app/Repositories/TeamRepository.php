<?php

namespace App\Repositories;

use App\Models\Team;

class TeamRepository
{
  
    protected $team;

    public function __construct(Team $team)
    {
        $this->team = $team;
    }

    public function getAllTeamDetails(){
        return $this->team::oldest()->paginate(5); 
    }
    public function create($attributes)
    {
        return $this->team->create($attributes);
    }
    public function update($id, array $attributes)
    {
        return $this->team->find($id)->update($attributes);
    }
    public function delete($id)
    {
        return $this->team->find($id)->delete();
    }
}