<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cambiar Contraseña - FEDETIRO</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            height: 100vh;
            margin: 0;
            background-color: #f4f7fa;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .container-fluid {
            height: 100%;
            padding: 0;
            display: flex;
            flex-wrap: wrap;
        }

        .image-section {
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 100%;
            flex: 1;
            min-height: 300px;
            position: relative;
            box-shadow: 10px 0 20px rgba(0, 0, 0, 0.5);
            transition: filter 1s ease;
            z-index: 1;
        }

        .image-section:hover {
            filter: grayscale(100%);
        }

        .login-section {
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #ffffff;
            flex: 1;
            min-height: 300px;
            position: relative;
            z-index: 2;
            padding-left: 15px;
        }

        .login-container {
            max-width: 400px;
            width: 100%;
            padding: 30px;
            background: #ffffff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        .login-container img {
            display: block;
            margin: 0 auto 20px;
            max-width: 150px;
        }

        .login-container h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-control {
            border-radius: 5px;
            box-shadow: none;
            border-color: #ddd;
        }

        .btn-primary {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            background-color: #007bff;
            border-color: #007bff;
            box-shadow: none;
            transition: background-color 0.3s, border-color 0.3s;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .text-sm {
            font-size: 0.875rem;
            color: #666;
        }

        .underline {
            text-decoration: underline;
        }

        .text-center {
            text-align: center;
        }

        @media (max-width: 768px) {
            .image-section {
                display: none;
            }

            .login-section {
                flex: 0 0 100%;
                max-width: 100%;
            }
        }
    </style>
</head>

<body>
    <?php $admin_logo_img = Voyager::setting('admin.icon_image', ''); ?>
    <?php $admin_bg_image = Voyager::setting('admin.bg_image', ''); ?>
    <div class="container-fluid">
        <div class="col-lg-6 col-md-6 image-section"
            style="background-image: url('{{ $admin_bg_image ? Voyager::image($admin_bg_image) : voyager_asset('images/fedetiro.png') }}');">
        </div>
        <div class="col-lg-6 col-md-6 login-section">
            <div class="login-container">
                <div class="logo-icon-container">
                    <?php $admin_logo_img = Voyager::setting('admin.icon_image', ''); ?>
                    @if ($admin_logo_img)
                        <a href="{{ url('/') }}">
                            <img src="{{ Voyager::image($admin_logo_img) }}" alt="Logo">
                        </a>
                    @else
                        <a href="{{ url('/') }}">
                            <img src="{{ voyager_asset('images/fedetiro.png') }}" alt="FEDETIRO Logo">
                        </a>
                    @endif
                </div>
                <h2>Cambiar Contraseña</h2>
                <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    <div class="form-group">
                        <label for="password">Nueva Contraseña</label>
                        <input type="password" id="password" name="password" class="form-control" required>
                        @error('password')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation">Confirmar Contraseña</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Actualizar Contraseña</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
