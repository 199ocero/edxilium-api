<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="{{ url('images/favicon.png') }}">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>Reset Password</title>
    <style>
        body {
            background-color: #0E1726 !important;
        }

        .card {
            background-color: #060818 !important;
            border-radius: 15px;
            box-shadow: 0 6px 10px 0 rgb(0 0 0 / 14%), 0 1px 18px 0 rgb(0 0 0 / 12%), 0 3px 5px -1px rgb(0 0 0 / 20%);
        }

        .form-holder {
            margin-top: 20%;
            margin-bottom: 20%;
        }

        .form-control {
            background-color: #1B2E4B !important;
            border: #0E1726 !important;
            color: #009688 !important;
        }

        .text-white {
            color: #bfc9d4 !important;
        }

    </style>
</head>

<body>
    <div class="container">
        <div class="row">

            <div class="col-md-6 offset-md-4">
                <div class="card form-holder">
                    <div class="card-body">
                        <h3 class="text-center text-white">Forgot Password?</h3>
                        <form action="api/password/reset" method="POST">
                            @csrf
                            <div class="form-group text-white">
                                <label>Email</label>
                                <input name="email" class="form-control" placeholder="Enter email"
                                    value="{{ request()->get('email') }}" required>
                            </div>
                            <div class="form-group text-white">
                                <label>Password</label>
                                <input id="password" type="password" name="password" class="form-control"
                                    placeholder="Enter New Password" required />
                            </div>
                            <div class="form-group text-white">
                                <label>Confirm Password</label>
                                <input id="confirm_password" type="password" name="password_confirmation"
                                    class="form-control" placeholder="Enter Confirm Password" required />
                                @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <input hidden name="token" placeholder="token" value="{{ request()->get('token') }}">
                            <div class="text-right">
                                <input type="submit" id="button1" class="btn btn-primary" value=" Submit " />
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
</body>

</html>
