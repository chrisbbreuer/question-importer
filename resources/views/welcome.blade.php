<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Question Importer for LearnDash</title>

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            <div class="content">
                <div class="title m-b-md">
                    Kinesiology Institute
                </div>

                <div class="links">
                    <a href="https://kinesiologyinstitute.com">Classmarker > LearnDash - Question Preparing</a>
                </div>

                <br /><br />

                @if (count($errors) > 0)
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif

                <form action="{{ url('/') }}" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="quiz_name" class="float-left">Quiz Name</label>
                        <input type="text" class="form-control" name="quiz_name" placeholder="Enter the Name of the Quiz" required>
                    </div>
                    <br>
                    <div class="form-group">
                        <input type="file" class="form-control-file" name="file" aria-describedby="fileHelp">
                        <small id="fileHelp" class="form-text text-muted float-left">Please select a Classmarker exported txt file.</small>
                    </div>
                    <br>
                    <div class="form-check float-left">
                        <label class="form-check-label">
                            <input type="checkbox" name="random_answers" class="form-check-input">
                            Random Answers?
                        </label>
                    </div>
                    <br><br>
                    <div class="form-check float-left">
                        <label class="form-check-label">
                            <input type="checkbox" name="random_questions" class="form-check-input" checked>
                            Random Questions?
                        </label>
                    </div>
                    <br><br>
                    <button type="submit" class="btn btn-primary m-b-md">Prepare Questions</button>
                </form>

                @if (!empty($url))
                    <a href="{{ $url }}" class="btn btn-success" download>Download LearnDash Importable File</a>
                @endif
            </div>
        </div>
    </body>
</html>
