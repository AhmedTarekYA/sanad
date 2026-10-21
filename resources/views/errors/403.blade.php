@extends('errors::minimal')

@section('title', __('Forbidden'))

@section('message', __($exception->getMessage() ?: 'Forbidden'))
@section('firstDigit',4)
@section('secondDigit', 0)
@section('thirdDigit', 3)
