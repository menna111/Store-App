@extends('Admin.layouts.Admin-dashboard')
@section('title','products')
@section('main_title','products')
@section('page','product')
@section('content')
    <h1>{{$product->name}}</h1>
    <ul>
@foreach($tags as $tag)

    <li>{{$tag->name}}</li>


@endforeach

    </ul>
@endsection
