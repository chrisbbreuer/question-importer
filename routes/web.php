<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::post('/', function () {
    $file = request()->file;
    $file_name = $file->getClientOriginalName();
    $file->storeAs('questions', $file_name);

    $content = Storage::get('questions/'.$file_name);

    preg_match_all('/\((.+?)\): (.*)?/i', $content, $array, PREG_PATTERN_ORDER);

    $j=-1;

    foreach ($array[0] as $v) {
        preg_match("/\(([^)]*?)\): \K.*/", $v, $out); // use \K to reduce array bloat
        if ($out[1] === 'Type') { // [1] is the key, [0] is the text
            ++$j;
        }
        $result[$j][$out[1]]=$out[0];
    }

//    dd($result);

    $quiz_name = request()->input('quiz_name');
    $random_answers = request()->input('random_answers') ? 'true' : 'false';
    $random_questions = request()->input('random_questions') ? 'true' : 'false';

    $exportable_file_header = '<?xml version="1.0" encoding="utf-8"?>
<wpProQuiz><header version="0.28" exportVersion="1"/>
    <data>
        <quiz>
            <title titleHidden="false">
                <![CDATA['.$quiz_name.']]>
            </title>
            <text>
                <![CDATA[AAZZAAZZ]]>
            </text>
            <resultText gradeEnabled="false">
                <![CDATA[]]>
            </resultText>
            <btnRestartQuizHidden>false</btnRestartQuizHidden>
            <btnViewQuestionHidden>false</btnViewQuestionHidden>
            <questionRandom>'.$random_questions.'</questionRandom>
            <answerRandom>'.$random_answers.'</answerRandom>
            <timeLimit>0</timeLimit>
            <showPoints>false</showPoints>
            <statistic activated="false" ipLock="0"/>
            <quizRunOnce type="1" cookie="false" time="0">false</quizRunOnce>
            <numberedAnswer>false</numberedAnswer>
            <hideAnswerMessageBox>false</hideAnswerMessageBox>
            <disabledAnswerMark>false</disabledAnswerMark>
            <showMaxQuestion showMaxQuestionValue="1" showMaxQuestionPercent="false">false</showMaxQuestion>
            <toplist activated="false">
                <toplistDataAddPermissions>1</toplistDataAddPermissions>
                <toplistDataSort>1</toplistDataSort>
                <toplistDataAddMultiple>false</toplistDataAddMultiple>
                <toplistDataAddBlock>1</toplistDataAddBlock>
                <toplistDataShowLimit>1</toplistDataShowLimit>
                <toplistDataShowIn>0</toplistDataShowIn>
                <toplistDataCaptcha>false</toplistDataCaptcha>
                <toplistDataAddAutomatic>false</toplistDataAddAutomatic>
            </toplist>
            <showAverageResult>false</showAverageResult>
            <prerequisite>false</prerequisite>
            <showReviewQuestion>false</showReviewQuestion>
            <quizSummaryHide>false</quizSummaryHide>
            <skipQuestionDisabled>false</skipQuestionDisabled>
            <emailNotification>1</emailNotification>
            <userEmailNotification>true</userEmailNotification>
            <showCategoryScore>false</showCategoryScore>
            <hideResultCorrectQuestion>false</hideResultCorrectQuestion>
            <hideResultQuizTime>false</hideResultQuizTime>
            <hideResultPoints>false</hideResultPoints>
            <autostart>false</autostart>
            <forcingQuestionSolve>false</forcingQuestionSolve>
            <hideQuestionPositionOverview>false</hideQuestionPositionOverview>
            <hideQuestionNumbering>false</hideQuestionNumbering>
            <sortCategories>false</sortCategories>
            <showCategory>false</showCategory>
            <quizModus questionsPerPage="0">2</quizModus>
            <startOnlyRegisteredUser>false</startOnlyRegisteredUser>
            <forms activated="false" position="0"/>
            <questions>';

    $exportable_file_footer = '</questions></quiz></data></wpProQuiz>';

    $question_body = '';

    foreach ($result as $question_item) {
        if ($question_item['Type'] == 'multiplechoice' || $question_item['Type'] == 'truefalse') {
            $question = $question_item['Question'];

            $option_a = !empty ($question_item['A']) ? $question_item['A'] : false;
            $option_b = !empty ($question_item['B']) ? $question_item['B'] : false;
            $option_c = !empty ($question_item['C']) ? $question_item['C'] : false;
            $option_d = !empty ($question_item['D']) ? $question_item['D'] : false;
            $option_e = !empty ($question_item['E']) ? $question_item['E'] : false;
            $option_f = !empty ($question_item['F']) ? $question_item['F'] : false;
            $option_g = !empty ($question_item['G']) ? $question_item['G'] : false;
            $option_h = !empty ($question_item['H']) ? $question_item['H'] : false;
            $option_i = !empty ($question_item['I']) ? $question_item['I'] : false;
            $option_j = !empty ($question_item['J']) ? $question_item['J'] : false;
            $option_k = !empty ($question_item['K']) ? $question_item['K'] : false;

            $answers_array = array_filter([$option_a, $option_b, $option_c, $option_d, $option_e, $option_f, $option_g, $option_h, $option_i, $option_j, $option_k]);

            $correct_choice = $question_item['Correct'];
            $points = $question_item['Points'];
            $correct_phrase = $question_item['CF'];
            $wrong_phrase = $question_item['WF'];

            $answers_content = '';
            foreach ($answers_array as $key => $answer) {

                if ($key == 0) {
                    $choice = 'A';
                } elseif  ($key == 1) {
                    $choice = 'B';
                } elseif  ($key == 2) {
                    $choice = 'C';
                } elseif  ($key == 3) {
                    $choice = 'D';
                } elseif  ($key == 4) {
                    $choice = 'E';
                } elseif  ($key == 5) {
                    $choice = 'F';
                } elseif  ($key == 6) {
                    $choice = 'G';
                } elseif  ($key == 7) {
                    $choice = 'H';
                } elseif  ($key == 8) {
                    $choice = 'I';
                } elseif  ($key == 9) {
                    $choice = 'J';
                } elseif  ($key == 10) {
                    $choice = 'K';
                }

                $correct = $correct_choice == $choice ? 'true' : 'false';

                $answer = '<answer points="0" correct="'.$correct.'">
                            <answerText html="false">
                                <![CDATA['.$answer.']]>
                            </answerText>
                            <stortText html="false">
                                <![CDATA[]]>
                            </stortText>
                        </answer>';

                $answers_content = $answers_content . $answer;
            }

            $exported_file_question_body = '<question answerType="single">
                    <title>
                        <![CDATA['.str_limit($question, 190).']]>
                    </title>
                    <points>'.$points.'</points>
                    <questionText>
                        <![CDATA['.$question.']]>
                    </questionText>
                    <correctMsg>
                        <![CDATA['.$correct_phrase.']]>
                    </correctMsg>
                    <incorrectMsg>
                        <![CDATA['.$wrong_phrase.']]>
                    </incorrectMsg>
                    <tipMsg enabled="false">
                        <![CDATA[]]>
                    </tipMsg><category/>
                    <correctSameText>false</correctSameText>
                    <showPointsInBox>false</showPointsInBox>
                    <answerPointsActivated>false</answerPointsActivated>
                    <answerPointsDiffModusActivated>false</answerPointsDiffModusActivated>
                    <disableCorrect>false</disableCorrect>
                    <answers>
                        '.$answers_content.'
                    </answers>
                </question>';

            $question_body = $question_body . $exported_file_question_body;
        }
    }

    $exportable_content =  $exportable_file_header . $question_body . $exportable_file_footer;

    //dd($exportable_content);
    $url = url('questions/'.$file_name.'.xml');
    Storage::put('questions/'.$file_name.'.xml', $exportable_content);

    return view('welcome', compact('url'));
});
