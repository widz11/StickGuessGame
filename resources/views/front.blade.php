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
            <label for="player_name" class="col-form-label" required>Player Name : </label><span class="text-danger" id="error_player_name"></span>
            <input type="text" class="form-control" id="player_name">
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" id="start_button" class="btn btn-primary">Start the Game</button>
      </div>
    </div>
  </div>
</div>

<br>
<div class="row">
  <div class="col-sm-8">
    <div class="card">
      <div class="card-body">
        <h2 class="card-title">Scrambled Word of Countries</h2>
        <br>
        <br>
        <h3 class="card-text text-center" id="scrambled_word">DWORD</h3>
        <br>
        <div class="card-text text-center">
          <input type="text" id="input_answer"/>
          <button class="btn btn-primary" id="btn_answer">Check</button>
        </div>
      </div>
    </div>
  </div>
  <div class="col-sm-4">
    <div class="card">
      <div class="card-body text-center">
        <h4 class="card-title"><span style="font-size:100px" class="fas fa-id-card-alt"></span></h4>
        <h3 class="card-text"><span id="player_name_card"></span></h3>
        <br>
        <h4 class="card-text">
          SCORE <br>
          <span class="text-danger" id="player_score_card">0</span>
        </h4>
        <br>
        <div class="card-text"><button class="btn btn-primary btn-success" id="btn_finish">Finish</button></div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  $(document).ready(function() {
    var name_player;

    $('#inputModal').modal({
      show:true,
      keyboard:false,
      backdrop:'static'
    });

    $('#start_button').on('click', function(){
      var modal = $('#inputModal');
      var input_player_name = $('#player_name').val();
      if(input_player_name != '') {
        modal.modal('hide');
        $('#player_name_card').text(input_player_name);
        getRandomWord();
      } else {
        $('#error_player_name').text('Please input player name');
      }
    });

    $('#btn_answer').on('click', function(){
      var answer = $('#input_answer').val();

      if(answer != '') {
        $.ajax({
          type: 'get',
          url: 'check_answer',
          dataType: 'json',
          data: {answer_post:answer},
          success: function(data, status, xhr) {
            if(data.equal) {
              alert("Congratulation!!! Your answer is correct");
            } else {
              alert("Correct answer is: " + data.correct_answer);
            }
            $('#input_answer').val('');
            $('#player_score_card').text(data.score);
            getRandomWord();
          },
          error: function(jqXhr, textStatus, errorMessage) {
            alert(errorMessage);
          }
        });
      } else {
        alert('Please answer the scrambled word');
      }
    });

    $('#btn_finish').on('click', function(){
      var player_name = $('#player_name_card').text();
      var score = $('#player_score_card').text();
      alert("Thank you" + player_name + ", your score is " + score);
      window.location.href = '';
    });

    $(window).on('beforeunload', function(){
      return 'Data will be lost if you leave the page, are you sure?';
    });
  });

  function getRandomWord () {
    $.ajax({
      type: 'get',
      url: 'random_country',
      dataType: 'json',
      success: function(data, status, xhr) {
        $('#scrambled_word').text(data.random_word);
      },
      error: function(jqXhr, textStatus, errorMessage) {
        alert(errorMessage);
      }
    });
  }
</script>
@stop
