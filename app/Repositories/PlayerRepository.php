<?php

namespace App\Repositories;

use App\Models\Player;

class PlayerRepository
{
  
    protected $player;

    public function __construct(Player $player)
    {
        $this->player = $player;
    }

    public function getAllPlayerDetails($input){
        $players =Player::where('team_id', $input['team_id']);
        
        if(isset($input['searchPlayer']) && !empty($input['searchPlayer'])) {
            $players->where('firstName', 'Like', '%' .trim($input['searchPlayer']) . '%')->orWhere('lastName', 'Like', '%' .trim($input['searchPlayer']) . '%');
        }
        $players = $players->paginate(5);
        return $players; 
    }
    public function create($attributes)
    {
        return $this->player->create($attributes);
    }
    public function update($player,array $attributes)
    {
        return $this->player->find($player->id)->update($attributes);
    }
    public function delete($id)
    {
        return $this->player->find($id)->delete();
    }
}