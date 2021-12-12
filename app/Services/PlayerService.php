<?php

namespace App\Services;

use Illuminate\Support\Collection;
use Illuminate\Session\SessionManager;
use App\Models\Player;
use App\Repositories\PlayerRepository;

class PlayerService {
    protected $session;
    protected $instance;

    
    public function __construct(PlayerRepository $player)
    {
        $this->player = $player;
    }

    /**
     * Get all Players
     *
     * @return Illuminate\Support\Collection
     */
    public function getAllPlayerDetails($input){  
        return $this->player->getAllPlayerDetails($input);  
    }

    /**
     * Adds a new team to the Soccer app.
     *
     * @param array $input
     * @return player
     */
    public function storePlayerDetails($input){
        if ($image = $input['playerImageURL']) {
            $destinationPath = 'image/';
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $input['playerImageURL'] = "$profileImage";
        }

    
        $player = $this->player->create($input);
        return $player;
    }

    public function updatePlayerDetails($player,$input){
        if(isset($input['playerImageURL']) && !empty($input['playerImageURL'])){   
            if ($image = $input['playerImageURL']) {
                $destinationPath = 'image/';
                $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
                $image->move($destinationPath, $profileImage);
                $input['playerImageURL'] = "$profileImage";
            }else{
                unset($input['playerImageURL']);
            }
        }    
        $playerData = $this->player->update($player,$input);
        return $player;
    }


    public function DeletePlayerDetails($player){
        return  $this->player->delete($player->id);
    }
}