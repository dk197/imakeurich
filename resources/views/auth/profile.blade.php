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
$timeago = auth()->user()->created_at;
?>

@section('content')
<div class="container">
    <div class="jumbotron p-4 p-md-5 text-white rounded bg-dark">
      <div class="col-md-6 px-0">
      <h1 class="display-4 font-italic">Hallo {{Auth::user()->username}},</h1>
        <p class="lead my-3">hier kannst du die wichtigsten deiner persönlichen Statistiken:</p>
      </div>
    </div>

    <div class="row mb-2">
      <div class="col-md-6">
        <div class="row no-gutters border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
          <div class="col p-4 d-flex flex-column position-static">
            <strong class="d-inline-block mb-2 text-primary">Warum bin ich nicht so damn rich wie du?</strong>
            <h3 class="mb-0">Du bist rich seit</h3>
            <p class="card-text mb-auto">(erste Anmeldung)</p>
          </div>
          <div class="jumbotron col-auto d-none d-lg-block">
            <h1><?php echo time_elapsed_string($timeago); ?></h1>
          </div>
        </div>
      </div>
    </div>
@endsection