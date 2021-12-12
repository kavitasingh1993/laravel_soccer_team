<?php

namespace App\Services;

use Illuminate\Support\Collection;
use Illuminate\Session\SessionManager;
use App\Models\Team;
use App\Repositories\TeamRepository;

class TeamService {
    protected $session;
    protected $instance;

    
    public function __construct(TeamRepository $team)
    {
        $this->team = $team;
    }

    /**
     * Get all Teams
     *
     * @return Illuminate\Support\Collection
     */
    public function getAllTeamDetails(){  
        return $this->team->getAllTeamDetails();  
    }

    /**
     * Adds a new team to the Soccer app.
     *
     * @param array $input
     * @return team
     */
    public function storeTeamDetails($input){
        if ($image = $input['logoURL']) {
            $destinationPath = 'image/';
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $input['logoURL'] = "$profileImage";
        }
        $team = $this->team->create($input);
        return $team;
    }

    public function updateTeamDetails($input,$team){
        if(isset($input['logoURL']) && !empty($input['logoURL'])){
            if ($image = $input['logoURL']) {
                $destinationPath = 'image/';
                $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
                $image->move($destinationPath, $profileImage);
                $input['logoURL'] = "$profileImage";
            }else{
                unset($input['logoURL']);
            }
        }    
        $team = $this->team->update($team->id,$input);
        return $team;
    }


    public function DeleteTeamDetails($team){
        return  $this->team->delete($team->id);
    }
}