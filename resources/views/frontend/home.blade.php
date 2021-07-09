@extends('layouts.base-front')

@section('js')
<script>
var sections = [
    @foreach ($sections as $section)
        '{{ $section->name }}',
    @endforeach
];
</script>
@endsection

@section('content')
<home-page></home-page>
@endsection