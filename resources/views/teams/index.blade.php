@extends('teams.layout')
     
@section('content')
    @auth
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Soccer Team</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="/dashboard"> Back</a>
                <a class="btn btn-success" href="{{ route('teams.create') }}"> Create New Team</a>
            </div>
        </div>
    </div>
    
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
     

    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Team Name</th>
            <th>Logo URL</th>            
            <th>Player Details</th>
            <th width="280px">Action</th>
        </tr>
        @if (count($teams) >= 1)
        @foreach ($teams as $team)
        <tr>
            <td>{{ ++$i }}</td>
            <td>{{ $team->name }}</td>
            <td><img src="/image/{{ $team->logoURL }}" width="100px"></td>            
            <!--td> <a class="btn btn-info" href="{{ route('players.index',['id' =>request()->has('id')]) }}">Show players</a></td-->
            <td> <a class="btn btn-info" href="{{ route('players.index',['team_id' =>$team->id]) }}">Show players</a></td>
            <td>
                <form action="{{ route('teams.destroy',$team->id) }}" method="POST">
     
                    <a class="btn btn-info" href="{{ route('teams.show',$team->id) }}">Show</a>
      
                    <a class="btn btn-primary" href="{{ route('teams.edit',$team->id) }}">Edit</a>
     
                    @csrf
                    @method('DELETE')
                    <input type="hidden" id="team_id" value="{{$team->id}}">
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
        @else
        <tr>
            <td colspan="4">No Team Added</td>
        </tr>
        @endif
    </table>
    {!! $teams->links() !!}
    @endauth
    @guest
        <p>Please Login to access the site</p>
    @endguest

    
    
        
@endsection