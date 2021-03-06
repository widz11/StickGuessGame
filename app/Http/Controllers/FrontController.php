<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use File;
use Storage;

class FrontController extends Controller
{
    /**
     * Show the application front end.
     *
     */
    public function index(Request $request) {
        $request->session()->flush();
        return view('front');
    }

    /**
    * Get random word of country from plain text
    *
    */
    public function getRandomCountry(Request $request) {
      $storagePath  = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix();
      $file = $storagePath . 'country_list/country_list.txt';
      $rand_text = '';
      $rand_index = '';

      if($file) {
        // generate country word from file
        $file_arr = file($file);
        $num_lines = count($file_arr);
        $last_arr_index = $num_lines - 1;
        $rand_index = rand(0, $last_arr_index);
        $rand_text = trim(preg_replace('/\s+/', ' ', $file_arr[$rand_index]));
        $rand_text = explode(" ", strtoupper($rand_text));
        $new_rand_text = '';
        $number_word = sizeof($rand_text);
        $i = 1;
        foreach ($rand_text as $key => $value) {
          $new_rand_text = $new_rand_text . str_shuffle($value);
          if($i < $number_word) {
            $new_rand_text = $new_rand_text . " ";
          }
          $i++;
        }
        // save answer into session
        $request->session()->put('id', $rand_index);
      }

      return response()->json(['random_word' => $new_rand_text]);
    }

    /**
    * check answer from user
    *
    */
    public function checkAnswer(Request $request) {
      $storagePath  = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix();
      $file = $storagePath . 'country_list/country_list.txt';

      if($file && $request->session()->has('id') && $request->input('answer_post')){
        $file_arr = file($file);

        $id_answer = $request->session()->get('id');
        $correct_answer = $file_arr[$id_answer];
        $correct_answer = trim(preg_replace('/\s+/', ' ', strtoupper($correct_answer)));

        $check_answer = $request->input('answer_post');
        $check_answer = trim(preg_replace('/\s+/', ' ', strtoupper($check_answer)));

        if(strcmp($correct_answer, $check_answer) === 0) { // equal
          if($request->session()->has('score')) { // have session score
            $score = $request->session()->get('score') + 10;
          } else { // don't have session score
            $score = 10;
          }
          $equal = true;
          $request->session()->put('score', $score);
        } else { // not equal
          if($request->session()->has('score')) { // have session score
            if($request->session()->get('score') > 0) {
              $score = $request->session()->get('score') - 5;
            } else {
              $score = 0;
            }
          } else { // don't have session score
            $score = 0;
          }
          $equal = false;
        }
        $request->session()->put('score', $score);

        return response()->json(['score' => $score, 'correct_answer' => $correct_answer, 'equal' => $equal]);
      } else {
        return response()->json(['error' => 'An server error occurred']);
      }
    }
}
