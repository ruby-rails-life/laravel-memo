<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Students-Courses</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
</head>
<body>
    <form method="post">
        {{ csrf_field() }}
        
        <div class="form-group row">
            <div class="col-sm-2">Courses</div>
            <div class="col-sm-10">
                <div class="form-check">
        @foreach ($courses as $course)
            <input type="checkbox" name="courses[]" value="{{ $course->id }}">{{ $course->name }}
        @endforeach
                </div>
            </div>
        </div>

        <div class="form-group row">
            <label for="studentName" class="col-sm-2 col-form-label">Eメール</label>
            <div class="col-sm-">
                <input name="name" class="form-control" id="studentName" placeholder="名前">
                <span class="alert-danger">
                @if ($errors->has('name'))
                    {{ $errors->first('name') }}
                @endif
                </span>
            </div>
        </div>

        <div class="form-group row">
            <div class="offset-sm-2 col-sm-10">
                <button type="submit" class="btn btn-primary">Choose Course</button>
            </div>
        </div>
    </form>
    @foreach ($students as $student)
        <hr>
        <p>Courses: 
          @foreach ($student->courses as $course) 
          {{ $course->name }} 
          @endforeach 
        </p>
        <p>{{ $student->name }}</p>
    @endforeach

    <script
  src="https://code.jquery.com/jquery-3.3.1.js"
  integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
  crossorigin="anonymous"></script>
  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
</body>
</html>