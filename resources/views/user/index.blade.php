@extends('layouts.app')

<?php
//Wandelt den created_at Timestamp in eine dynamische Anzeige um, wie lange man schon online ist.
function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'Jahr/e',
        'm' => 'Monat/e',
        'w' => 'Woche/n',
        'd' => 'Tag/en',
        'h' => 'Stunde/n',
        'i' => 'Minute/n',
        's' => 'Sekunde/n',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? '' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . '' : '';
}
$timeago = $user->created_at;
?>

@section('content')
<div class="container">
    <div class="jumbotron p-4 p-md-5 text-white rounded bg-dark">
      <div class="col-md-6 px-0">
      <h1 class="display-4 font-italic">Thats {{$user->username}},</h1>
        <p class="lead my-3">here can you see all his personal statistics:</p>
      </div>
    </div>

    <div class="row mb-2">
      <div class="col-md-6">
        <div class="row no-gutters border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
          <div class="col p-4 d-flex flex-column position-static">
            <strong class="d-inline-block mb-2 text-primary">Why is he so rich?</strong>
            <h3 class="mb-0">He is rich since</h3>
            <p class="card-text mb-auto">(first login)</p>
          </div>
          <div class="jumbotron col-auto d-none d-lg-block">
            <h1><?php echo time_elapsed_string($timeago); ?></h1>
          </div>
        </div>
      </div>
    </div>
@endsection
