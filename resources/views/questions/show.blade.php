<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Quiz</title>
        <link rel="stylesheet" href="/css/bootstrap.min.css">
        <link rel="stylesheet" href="/css/flipclock.css">
        <style>
            .container {
                padding-top: 25px;
            }
            .alternative {
                border-radius: 15px;
                padding: 15px;
                font-size: 20px;
            }
            .alternative-letter{
                border-radius: 15px;
                padding: 15px;
                background-color: #bdbcbc;
            }
            #mainSeparator {
                padding: 55px 70px;
            }
            #questionSeparator {
                padding: 15px 15px;
            }
            .center-block {
                display: block;
                margin-left: auto;
                margin-right: auto;
            }
            .color-correct {
                background-color: #5da93e;
            }
            .color-incorrect {
                background-color: #e45050;
            }
            .color-selected {
                background-color: #f3993c;
            }
            .counters {
                padding: 20px 40px;
            }
            .timer-buttons {
                padding-bottom: 40px;
            }
        </style>
    </head>
    <body style="background-color: #f7f8ff;">
        <div class="container">
            <div class="row timer-buttons">
                <div class="col-md-6">
                    <div class="your-clock"></div>
                </div>
                <div class="col-md-6 check-buttons hidden">
                    <div class="row">
                        <div class="col-md-6 col-md-offset-3">
                            <h2></h2>
                            <a href="#" class="btn btn-default btn-block" id="checkAnswerButton">Revisar respuesta</a>
                            <a href="#" class="btn btn-danger btn-block" id="anotherQuestion" onclick="newQuestion()">Otra pregunta</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <p class="bg-primary alternative text-center">{{ $question->info }}</p>
            </div>
            <div id="questionSeparator"></div>
            <div class="row">
                <div class="col-md-1">
                    <p class="text-center alternative-letter">A</p>
                </div>
                <div class="col-md-5">
                    <p class="bg-primary clickable alternative">{{ $question->a }}</p>
                    <input type="hidden" name="A">
                </div>
                <div class="col-md-1">
                    <p class="text-center alternative-letter">B</p>
                </div>
                <div class="col-md-5">
                    <p class="bg-primary clickable alternative">{{ $question->b }}</p>
                    <input type="hidden" name="B">
                </div>
            </div>
            <div class="row">
                <div class="col-md-1">
                    <p class="text-center alternative-letter">C</p>
                </div>
                <div class="col-md-5">
                    <p class="bg-primary clickable alternative">{{ $question->c }}</p>
                    <input type="hidden" name="C">
                </div>
                <div class="col-md-1">
                    <p class="text-center alternative-letter">D</p>
                </div>
                <div class="col-md-5">
                    <p class="bg-primary clickable alternative">{{ $question->d }}</p>
                    <input type="hidden" name="D">
                </div>
            </div>

            <!-- Contadores -->
            <div class="row counters">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-3">
                            <button type="button" class="btn btn-info decrement-1" style="background-color: #d28321; margin: 25px; font-size: 20px; padding: 15px;">-1</button>
                        </div>
                        <div class="col-md-4">
                            <p class="text-center">Equipo 1</p>
                            <div class="clock-counter-1"></div>
                        </div>
                        <div class="col-md-5">
                            <button type="button" class="btn btn-info increment-1" style="background-color: #d28321; margin: 25px; font-size: 20px; padding: 15px;">+1</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-3">
                        <button type="button" class="btn btn-info decrement-2" style="background-color: #d28321; margin: 25px; font-size: 20px; padding: 15px;">-1</button>
                    </div>
                    <div class="col-md-4">
                        <p class="text-center">Equipo 2</p>
                        <div class="clock-counter-2"></div>
                    </div>
                    <div class="col-md-5">
                        <button type="button" class="btn btn-info increment-2" style="background-color: #d28321; margin: 25px; font-size: 20px; padding: 15px;">+1</button>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <a href="#" onclick="restart()">
                        <img src="/img/logo.jpg" alt="logo-duoc" width="450px" height="200px">
                    </a>
                </div>
                <div class="col-md-6">
                    <a href="#" class="pull-right">
                        <img src="/img/encuentro.png" alt="logo-encuentro" width="450px" height="200px">
                    </a>
                </div>
            </div>
        </div>
        <meta name="_token" content="{!! csrf_token() !!}" />
        <script src="/js/jquery.js"></script>
        <script src="/js/bootstrap.min.js"></script>
        <script src="/js/howler.js"></script>
        <script src="/js/flipclock.js"></script>
        <script src="/js/sweetalert2.all.min.js"></script>
        <script>
            var correctAnswer = "{{$question->correct}}"
            console.log(correctAnswer)

            counterOnePoints = localStorage.getItem("counter1") != undefined ? localStorage.getItem("counter1") : 0;
            counterTwoPoints = localStorage.getItem("counter2") != undefined ? localStorage.getItem("counter2") : 0;

            counter1 = new FlipClock($('.clock-counter-1'), counterOnePoints, {
                clockFace: 'Counter'
            })

            counter2 = new FlipClock($('.clock-counter-2'), counterTwoPoints, {
                clockFace: 'Counter'
            })

            newWarning = "color-selected"
            newSuccess = "color-correct"
            newIncorrect = "color-incorrect"

            var clock = new Howl({
                src: ['/sounds/clock.mp3'],
                loop: true,
            });

            var applause = new Howl({
                src: ['/sounds/applause.mp3']
            })

            var booing = new Howl({
                src: ['/sounds/booing.mp3']
            })

            var ring = new Howl({
                src: ['/sounds/ring.mp3']
            })

            mainClock = new FlipClock($('.your-clock'), 60, {
                clockFace: 'MinuteCounter',
                countdown: true,
                events: true,
                language: "spanish",
                callbacks: {
                    start: function() {
                        clock.play();
                    },
                    stop: function () {
                        if (!$('.' + newWarning).next().attr('name')) {
                            ring.play()
                            swal({
                                title: '¡Se acabo el tiempo!',
                                type: 'warning',
                                confirmButtonText: 'Ok'
                            })
                        }
                        $('.check-buttons').removeClass("hidden");
                        disableClick();
                        clock.stop();
                    }
                }
            })

            $('.clickable').click(function(){
                console.log($(this).next().attr('name'))
                $(this).addClass(newWarning).removeClass("bg-primary")
                mainClock.stop()
                disableClick();
                $('.check-buttons').removeClass("hidden");
            })

            $('#checkAnswerButton').click(function(){
                $("#anotherQuestion").prop('disable', true)
                selectedAlternative = $('.' + newWarning).next().attr('name')
                if (!selectedAlternative) {
                    markCorrectAnswer()
                } else if (correctAnswer == selectedAlternative) {
                    $('.' + newWarning).addClass(newSuccess).removeClass(newWarning)
                    applause.play()
                    swal({
                        title: '¡Respuesta correcta!',
                        type: 'success',
                        confirmButtonText: 'Ok'
                    })
                } else {
                    $('.' + newWarning).addClass(newIncorrect).removeClass("bg-primary").removeClass(newWarning)
                    booing.play()
                    markCorrectAnswer()
                    swal({
                        title: '¡Respuesta incorrecta!',
                        type: 'error',
                        confirmButtonText: 'Ok'
                    })
                }
                sendAjaxRequest()
            })

            $('.increment-1').click(function(){
                counter1.increment();
                localStorage.setItem("counter1", counter1.time.time)
            })
            $('.decrement-1').click(function(){
                counter1.decrement();
                localStorage.setItem("counter1", counter1.time.time)
            })
            $('.increment-2').click(function(){
                counter2.increment();
                localStorage.setItem("counter2", counter2.time.time)
            })
            $('.decrement-2').click(function(){
                counter2.decrement();
                localStorage.setItem("counter2", counter2.time.time)
            })

            function disableClick() {
                $('.clickable').off();
            }

            function markCorrectAnswer() {
                $('input[name="'+correctAnswer+'"]').prev().addClass(newSuccess).removeClass("bg-primary")
            }

            function sendAjaxRequest() {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    type: "PUT",
                    url: "/questions/{{$question->id}}",
                    dataType: 'json',
                    success: function(data) {
                        console.log("Question {{$question->id}} mark as read")
                    },
                    error: function(xhr, status, e) {
                        console.log("error occurred")
                        console.log(status)
                        console.log(e)
                    }
                })
            }

            function setScoreToZero(){
                localStorage.setItem("counter1", 0)
                localStorage.setItem("counter2", 0)
            }

            function restart() {
                clock.pause()
                var answer = confirm('Se reinicirán todas las preguntas. ¿Estás seguro?')
                if (!answer) {
                    clock.play()
                    return
                }
                setScoreToZero()
                window.location.href = "/questions_reset"
            }

            function newQuestion(){
                window.location.reload()
            }
        </script>
    </body>
</html>