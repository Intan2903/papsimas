<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Pamsimas | Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootswatch@5.3.3/dist/zephyr/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&amp;display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Aclonica&amp;display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Quicksand&amp;display=swap">
    <link rel="stylesheet" href="{{ asset('assets/css/styles.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.5.5/dist/sweetalert2.min.css">
</head>

<body class="min-vh-100">
    <div class="container-fluid d-flex justify-content-center align-items-xl-center w-100 min-vh-100 px-0">
        <div class="row gx-0 d-sm-flex justify-content-sm-center w-100 min-vh-100">
            <div class="col-12 col-lg-7 d-flex justify-content-center align-items-center">
                <div class="px-3"><img class="rounded img-fluid w-100 fit-cover" style="min-height: 250px;"
                        src="{{ asset('assets/img/register.png') }}"></div>
            </div>
            <div class="col-12 col-lg-5 d-flex justify-content-center align-items-center bg-light">
                <div class="px-2 px-sm-3 px-lg-5 p-5 w-100">
                    <div class="">
                        <h1 class="fw-semibold">Login</h1>
                    </div>
                    <p class="text-muted mt-2 mb-3">Please login to continue</p>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="form-group mb-2">
                            <label for="exampleInputEmail1">Telepon</label>
                            <input class="form-control form-control rounded-3" type="text" id="exampleInputEmail1-2"
                                name="telepon">
                        </div>
                        <div class="form-group mb-5">
                            <label for="exampleInputPassword1-1">Password</label>
                            <input class="form-control form-control rounded-3" type="password"
                                id="exampleInputPassword1-1" name="password">
                        </div>
                        <button type="submit" class="btn btn-primary w-100 rounded-3">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/script.min.js"></script>
</body>

</html>
