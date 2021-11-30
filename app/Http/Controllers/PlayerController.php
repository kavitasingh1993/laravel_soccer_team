<?php

namespace App\Http\Controllers;

use App\Models\Player;
use Illuminate\Http\Request;

class PlayerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {  
        $team_id = $request->input('team_id');
        $input = $request->all();
        // $players =Player::where('team_id', $team_id)->paginate(5);
        $players =Player::where('team_id', $team_id);
        
        if ($request->has('searchPlayer')) {
            $players->where('firstName', 'Like', '%' .trim($request->input('searchPlayer')) . '%');
        }
        $players = $players->paginate(5);
        
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
  
      
         //  echo "id: ". $request->input('id');
        if ($image = $request->file('playerImageURL')) {
            $destinationPath = 'image/';
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $input['playerImageURL'] = "$profileImage";
        }
        $team_id = $request->input('team_id');
        Player::create($input);
     
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
           // 'logoURL' => 'required'
        ]);
  
        $input = $request->all();
  
        if ($image = $request->file('playerImageURL')) {
            $destinationPath = 'image/';
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $input['playerImageURL'] = "$profileImage";
        }else{
            unset($input['playerImageURL']);
        }
          
        $player->update($input);
    
        return redirect()->route('players.index')
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
        $player->delete();
        $team_id = $request->input('team_id');
        return redirect()->route('players.index',['team_id'=>$team_id])->with('success', 'Player deleted successfully');
    }

}
