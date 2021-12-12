@extends('players.layout')
     
@section('content')
    @auth
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Soccer Team</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('teams.index') }}"> Back</a>
                <a class="btn btn-success" href="{{ route('players.create',['team_id'=>request()->query('team_id')])}}"> Create New Player</a>
            </div>
        </div>
    </div>
    <form action="{{ route('players.index') }}" method="GET">
        <div class="row">
            <div class="col-lg-6">
            <input type="search" name="searchPlayer" id="searchPlayer" class="form-control" placeholder="Name">
            <input type="hidden" id="team_id"name="team_id" value="{{request()->query('team_id')}}">
            </div>
            <div class="col-lg-6">
            
            <button type="submit" class="btn btn-primary">Submit</button>
            <!--- a class="btn btn-info" href="{{ route('players.index') }}"> Search</a --->
            </div>
        </div>
    </form>
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
     
    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Player Image</th>
            <th>Player Name</th>
            <th width="280px">Action</th>
        </tr>
        @if (count($players) >= 1)
        @foreach ($players as $player)
        <tr>
            <td>{{ ++$i }}</td>
            <td><img src="/image/{{ $player->playerImageURL }}" width="100px"></td>
            <td>{{ $player->firstName }} {{ $player->lastName }}</td>
            <td>
                <form action="{{ route('players.destroy',$player->id) }}" method="POST">
     
                    <a class="btn btn-info" href="{{ route('players.show',$player->id) }}">Show</a>
      
                    <a class="btn btn-primary" href="{{ route('players.edit',$player->id) }}">Edit</a>
     
                    @csrf
                    @method('DELETE')
                    <input type="hidden" id="team_id" value="{{request()->query('team_id')}}">
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
        @else
        <tr>
            <td colspan="4">No Player found for this team</td>
        </tr>
        @endif
    </table>
    {!! $players->links() !!}
    @endauth
    @guest
        <p>Please Login to access the site</p>
    @endguest
    
    
        
@endsection