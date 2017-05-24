@if($subArcadeChild == 'while-loop')

    <while-loop-question
            :question-data="{{ json_encode($questions) }}"
            :answer-data="{{ json_encode($answers) }}">
    </while-loop-question>

@elseif($subArcadeChild == 'do-while-loop')

    <do-while-loop-question :question-data="{{ json_encode($questions) }}"
                            :answer-data="{{ json_encode($answers) }}">
    </do-while-loop-question>

@elseif($subArcadeChild == 'for-loop')

    <for-loop-question :question-data="{{ json_encode($questions) }}"
                       :answer-data="{{ json_encode($answers) }}"
                       :badge-data="{{ json_encode($badges) }}">
    </for-loop-question>

@endif