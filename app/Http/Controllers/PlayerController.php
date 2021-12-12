<?php

namespace App\Http\Controllers;

use App\Models\Player;
use Illuminate\Http\Request;
use App\Services\PlayerService;

class PlayerController extends Controller
{
    protected $playerService;

    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct(PlayerService $playerService)
    {
        $this->playerService = $playerService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {  
        $team_id = $request->input('team_id');
        $input = $request->all();
        $players = $this->playerService->getAllPlayerDetails($input);

        return view('players.index',compact('players'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $input = $request->all();
        $team_id = $request->input('team_id');
        return view('players.create')->with('team_id',$team_id);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $request->validate([
            'firstName' => 'required',
            'lastName' => 'required',
            'playerImageURL' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'team_id'=> 'required',
        ]);
  
        $playerData =$this->playerService->storePlayerDetails($input);
        $team_id = $request->input('team_id');       
        if(!$playerData){
            throw new \Exception("Player Cannot be Added");
        }
        return redirect()->route('players.index',['team_id'=>$team_id])->with('success', 'Player created successfully.');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Player  $player
     * @return \Illuminate\Http\Response
     */
    public function show(Player $player)
    {
        return view('players.show',compact('player'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Player  $player
     * @return \Illuminate\Http\Response
     */
    public function edit(Player $player)
    {
        return view('players.edit',compact('player'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Player  $player
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Player $player)
    {
        $request->validate([
            'firstName' => 'required',
            'lastName' => 'required'
        ]);
  
        $input = $request->all();
        if($player->team_id != (int)$request->input('team_id')){
            $input = $request->all();
                throw new \Exception("You cannot change Players Team. Please delete player first"); 
        }
        $player = $this->playerService->updatePlayerDetails($player,$input);          
        return redirect()->route('players.index',['team_id'=>$player->team_id])
                        ->with('success','Player updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Player  $player
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Player $player)
    {     
        if(!$player){
            throw new \Exception("Player Does not Exist");
        }
        $this->playerService->DeletePlayerDetails($player);
        $team_id = $request->input('team_id');
        return redirect()->route('players.index',['team_id'=>$player->team_id])->with('success', 'Player deleted successfully');
    }

}
