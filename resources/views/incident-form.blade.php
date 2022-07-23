<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name') }} </title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous">
    </script>
    <style>
        .form-control {
            background-color: #f4f8f7;
            border: 1px solid #fff;
        }

        .official-use-inputs .form-control {
            background-color: #effedb;
        }

        .green-bg {
            background-color: #a4cc6b;
            color: #ffffff;
        }

        .green-bg:hover {
            background-color: #a4cc6b;
            opacity: .8;
        }

        .tiny-text {
            font-size: 11px;
        }
    </style>
</head>

<body class="antialiased">
    <div class="p-2"></div>
    <div class="p-3 text-center">
        <img src="{{ asset('logo.jpeg') }}" class="img-fluid">
    </div>
    @guest
        <div class="container p-3">
            <div class="row offset-md-2 col-md-2 col-4">
                <a href="{{ route('login') }}" target="_balnk" class="btn btn-primary">Login</a>
            </div>
        </div>
    @else
        <div class="container p-3">
            <div class="row offset-md-2">
                <div class="col-md-2 col-4">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <button type="submit" class="btn btn-primary">
                            {{ __('Log Out') }}
                        </button>
                    </form>
                </div>
                <div class="col-md-2 col-4">
                    <a href="{{ route('dashboard') }}" target="_balnk" class="btn btn-primary">Dashboard</a>
                </div>
            </div>
        </div>
    @endguest
    <div class="container mt-3 p-3">
        @if (session('msg'))
            <div class="row offset-md-2 col-md-8 mb-3">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('msg') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endif

        @if ($errors->all())
            <div class="row offset-md-2 col-md-8 mb-3">
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    @foreach ($errors->all() as $message)
                        {{ $message }} </br>
                    @endforeach
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endif

        <h4 class="text-center">CLIENT DETAILS</h4>
        <form class="row" method="post" enctype="multipart/form-data" action="{{ route('incident-report.store') }}">
            @csrf
            <div class="offset-md-2 col-md-8 mb-3">
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="name" class="form-label mt-md-0 mt-3">NAME</label>
                        <input type="text" class="form-control" id="name" name="name">
                    </div>
                    <div class="col-md-4">
                        <label for="phone" class="form-label mt-md-0 mt-3">PHONE NUMBER</label>
                        <input type="number" class="form-control" id="phone" name="phone">
                    </div>
                    <div class="col-md-4">
                        <label for="location" class="form-label mt-md-0 mt-3">LOCATION</label>
                        <input type="text" class="form-control" id="location" name="location">
                    </div>
                </div>
            </div>
            <div id="dynamic_field" class="offset-md-2 col-md-8 rounded-2 bg-light mb-3 p-3">
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="machineType" class="form-label mt-md-0 mt-3">MACHINE TYPE</label>
                        <select name="machine_type[]" class="form-select" aria-label="Machine Type">
                            <option value="hoftun">Hoftun</option>
                            <option value="energy+">Energy+</option>
                            <option value="classic+">Classic+</option>
                            <option value="turbo+">Turbo+</option>
                            <option value="turbo+">Others</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="machineName" class="form-label mt-md-0 mt-3">MACHINE NUMBER</label>
                        <input type="number" class="form-control" id="machineName" name="machine_number[]" required>
                    </div>
                    <div class="col-md-4">
                        <label for="incidentDetails" class="form-label mt-md-0 mt-3">INCIDENT DETAILS</label>
                        <select name="incident_detail_option[]" id="incidentDetails"
                            class="form-select incident-detail-others" aria-label="Incident options">
                            <option value="buttons">BUTTONS</option>
                            <option value="chairs">CHAIRS</option>
                            <option value="door-keys">DOOR KEYS</option>
                            <option value="electronic-keys">ELECTRONIC KEYS</option>
                            <option value="hdd">HDD</option>
                            <option value="hdmi">HDMI</option>
                            <option value="jp-box">JP BOX</option>
                            <option value="jp-power">JP POWER</option>
                            <option value="led-light">LED LIGHT</option>
                            <option value="monitor">MONITOR</option>
                            <option value="motherboard">MOTHERBOARD</option>
                            <option value="network-cable">NETWORK CABLE</option>
                            <option value="nv9">NV9</option>
                            <option value="nv9-wire">NV9 WIRE</option>
                            <option value="power-pack">POWER PACK</option>
                            <option value="router">ROUTER</option>
                            <option value="smio-board">SMIO BOARD/CABLE</option>
                            <option value="speakers">SPEAKERS</option>
                            <option value="switch">SWITCH</option>
                            <option value="table">TABLE</option>
                            <option value="tourch-panel">TOURCH PANEL</option>
                            <option value="tv">TV</option>
                            <option value="ups">UPS</option>
                            <option value="others">OTHERS(PLEASE SPECIFY)</option>
                        </select>

                    </div>
                </div>
            </div>
            <div class="offset-md-2 mb-3">
                <button id="addMore" type="button" class="btn btn-light remove-field">Add more</button>
            </div>

            <div class="offset-md-2 col-md-8 mb-3">
                <label for="exampleFormControlTextarea1" class="form-label mt-md-0 mt-3">ADDITIONAL NOTES</label>
                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="additional_notes"></textarea>
            </div>
            <div class="offset-md-2 col-md-8 mb-3">
                <label for="attachment" class="form-label mt-md-0 mt-3">ATTACHMENT(Optional)</label>
                <div class="input-group mb-3">
                    <input type="file" class="form-control" id="attachment" name="attachments[]" multiple>
                </div>
            </div>

            <div class="d-grid offset-md-2 col-5 col-md-4 mx-auto">
                <button class="btn btn-primary green-bg border" type="submit">Submit</button>
            </div>
        </form>

    </div>
    <div class="p-3 text-center">
        <img src="{{ asset('logo.jpeg') }}" class="img-fluid">
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script>
        function shouldShowOtherField(that) {
            if (that.value == "others") {
                document.getElementById("others").style.display = "block";
            } else {
                document.getElementById("others").style.display = "none";
            }
        }
        $(document).ready(function() {
            var i = 1;
            $('#addMore').on('click', function() {
                $('#dynamic_field').append(`<div class="row mb-3 added-more"><div class="col-md-4">
                        <label for="machineType" class="form-label mt-3 mt-md-0">MACHINE TYPE</label>
                        <select name="machine_type[]" id="machineType" class="form-select" aria-label="Machine Type">
                            <option value="hoftun" selected>Hoftun</option>
                            <option value="energy+">Energy+</option>
                            <option value="classic+">Classic+</option>
                            <option value="turbo+">Turbo+</option>
                            <option value="others">Others</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="machineName" class="form-label mt-3 mt-md-0">MACHINE NUMBER</label>
                        <input type="number" class="form-control" id="machineName" name="machine_number[]" required>
                    </div>
                    <div class="col-md-4 position-relative">
                        <label for="incidentDetails" class="form-label mt-3 mt-md-0">INCIDENT DETAILS</label>
                        <select name="incident_detail_option[]"
                            id="incidentDetails" class="form-select incident-detail-others" style="width:70%" aria-label="Incident options">
                            <option value="buttons">BUTTONS</option>
                            <option value="chairs">CHAIRS</option>
                            <option value="door-keys">DOOR KEYS</option>
                            <option value="electronic-keys">ELECTRONIC KEYS</option>
                            <option value="hdd">HDD</option>
                            <option value="hdmi">HDMI</option>
                            <option value="jp-box">JP BOX</option>
                            <option value="jp-power">JP POWER</option>
                            <option value="led-light">LED LIGHT</option>
                            <option value="monitor">MONITOR</option>
                            <option value="motherboard">MOTHERBOARD</option>
                            <option value="network-cable">NETWORK CABLE</option>
                            <option value="nv9">NV9</option>
                            <option value="nv9-wire">NV9 WIRE</option>
                            <option value="power-pack">POWER PACK</option>
                            <option value="router">ROUTER</option>
                            <option value="smio-board">SMIO BOARD/CABLE</option>
                            <option value="speakers">SPEAKERS</option>
                            <option value="switch">SWITCH</option>
                            <option value="table">TABLE</option>
                            <option value="tourch-panel">TOURCH PANEL</option>
                            <option value="tv">TV</option>
                            <option value="ups">UPS</option>
                            <option value="others">OTHERS(PLEASE SPECIFY)</option>
                        </select><button style="position:absolute; top:30px; right:5%" type="button" class="btn btn-danger remove-field">X</button>


                    </div></div>`);

                $('.remove-field').on('click', function() {
                    $(this).parents('.added-more').remove();
                });
            });
            $('#dynamic_field').on('change', '.incident-detail-others', function(event) {
                if ($(this).val() == "others") {
                    console.log($(this).val());
                    $(this).parent().append(`<div class="others incident-detail-others-textarea">
                            <textarea class="form-control" rows="5" name="incident_detail_option[]"></textarea>
                            <p class="tiny-text">How the incident occurred, factors leading to it, what took place.
                                </br>Be as specific as possible</p>
                                </div>`);
                } else {
                    $(this).parent().find('.others').remove();
                }
            });
            $('#dynamic_field').on('change', '.incident-detail-others-textarea', function(e) {
                $(this).parent().find('.incident-detail-others').val($(this).val());

            });
        });
    </script>
</body>

</html>
