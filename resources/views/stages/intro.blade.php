@if($subArcadeChild == 'while-loop')

    <while-loop-intro></while-loop-intro>

@elseif($subArcadeChild == 'do-while-loop')

    <do-while-loop-intro></do-while-loop-intro>

@elseif($subArcadeChild == 'for-loop')

    <for-loop-intro></for-loop-intro>

@endif
{{--        @include('whileLoop.blade.php', ['questions' => $questions])--}}
{{--<while-loop :questions="{{ json_encode($questions) }}"></while-loop>--}}

