@extends('layouts.master')
@section('page_title', 'لوحة التحكم')

@section('content')
    <h2>WELCOME {{ Auth::user()->name }}.لوحة التحكم الخاصة </h2>
    @endsection