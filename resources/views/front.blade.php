@extends('layouts.default')
@section('content')
<div class="modal fade" id="inputModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="inputModalLabel">Welcome to Guess Game</h5>
      </div>
      <div class="modal-body">
          <div class="form-group">
            <label for="player_name" class="col-form-label">Player Name :</label>
            <input type="text" class="form-control" id="player_name">
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" id="start_button" class="btn btn-primary">Start the Game</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  $(document).ready(function() {
    $('#inputModal').modal({
      show:true,
      keyboard:false,
      backdrop:'static'
    });
    $('#start_button').on('click', function(){
      $('#inputModal').modal('hide');
    });
  });
</script>
@stop
