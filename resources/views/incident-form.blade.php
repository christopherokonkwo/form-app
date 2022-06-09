<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Form App</title>

    <!-- Fonts -->
    {{-- <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet"> --}}

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
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

        .tiny-text {
            font-size: 11px;
        }

    </style>
</head>
<body class="antialiased">
    <div class="p-2"></div>
    <div class="p-3 text-center ">
        <img src="{{asset('logo.jpeg')}}" class="img-fluid">
    </div>
    {{-- <div class="p-3 text-center green-bg">
        <h4>INCIDENT REPORT</h4>
    </div> --}}
    <div class="container mt-3 p-3">
        @if(session('msg'))
        <div class="row offset-md-2 col-md-8 mb-3">
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                {{session('msg')}}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
        @endif

        @if($errors->all())
        <div class="row offset-md-2 col-md-8 mb-3">
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                @foreach ($errors->all() as $message)
                {{$message}} </br>
                @endforeach
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
        @endif

        <h4 class="text-center">CLIENT DETAILS</h4>
        <form class="row" method="post" action="{{route('incident-report.store')}}">
            @csrf
            <div class="offset-md-2 col-md-8 mb-3">
                <label for="name" class="form-label">NAME</label>
                <input type="text" class="form-control" id="name" name="name">
            </div>
            <div class="offset-md-2 col-md-8 mb-3">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="machineName" class="form-label">MACHINE NUMBER</label>
                        <input type="text" class="form-control" id="machineName" name="machine_number">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="phone" class="form-label">PHONE NUMBER</label>
                        <input type="text" class="form-control" id="phone" name="phone">
                    </div>
                </div>
            </div>

            <div class="offset-md-2 col-md-8 row mb-3">
                <div class="col-md-3 mb-3">

                    <!-- Force next columns to break to new line -->
                    <div class="w-100"></div>
                    <div class="col-12">
                        <label for="date" class="form-label">DATE</label>
                        <input type="date" class="form-control" id="date" name="date">
                    </div>
                    <div class="w-100"></div>
                    <div class="col-12">
                        <label for="location" class="form-label">LOCATION</label>
                        <input type="text" class="form-control" id="location" name="location">
                    </div>

                    <div class="w-100"></div>

                    <div class="col-12 mb-3">
                        <label for="time" class="form-label">TIME</label>
                        <input type="time" class="form-control" id="time" name="time">
                    </div>

                    <div class="w-100"></div>

                    <div class="col-12">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="police_notified" id="policeNotified" value="1">
                            <label class="form-check-label" for="policeNotified">YES</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="police_notified" id="policeNotified" value="0">
                            <label class="form-check-label" for="policeNotified">NO</label>
                        </div>
                    </div>
                </div>
                <div class="col-md-9 mb-3">
                    <label for="exampleFormControlTextarea1" class="form-label">INCIDENT DETAILS</label>
                    <select onchange="shouldShowOtherField(this);" class="form-select" aria-label="Incident options" name="incident_detail_option">
                        <option selected>Open this select menu</option>
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
                    <div id="others" style="display:none">
                        <textarea class="form-control" rows="7" name="incident_details"></textarea>
                        <p class="tiny-text">How the incident occurred, factors leading to it, what took place. </br>
                            Be as specific as possible</p>
                    </div>
                </div>
            </div>

            <div class="offset-md-2 col-md-8 mb-3">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">INCIDENT CAUSES</label>
                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="2" name="incident_causes"></textarea>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">INCIDENT STATUS</label>
                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="2" name="recommendations"></textarea>
                    </div>
                </div>
            </div>
            <div class="offset-md-2 col-md-8 mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">ADDITIONAL NOTES</label>
                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="additional_notes"></textarea>
            </div>

            <div class=" official-use-inputs">
                <div class="offset-md-2 col-md-8 mt-3 mb-2">
                    <h4 class="text-center">FOR OFFICIAL USE ONLY</h4>
                </div>
                <div class="offset-md-2 col-md-8 mb-3">
                    <div class="row">
                        <div class="col-md-9 mb-3">
                            <label for="recievedBy" class="form-label">REPORT RECIEVED BY</label>
                            <input type="text" class="form-control" id="recievedBy" name="recieved_by">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="recievedDate" class="form-label">DATE</label>
                            <input type="date" class="form-control" id="recievedDate" name="recieved_date">
                        </div>
                    </div>
                </div>
                <div class="offset-md-2 col-md-8 mb-3">
                    <div class="row">
                        <div class="col-md-9 mb-3">
                            <label for="reportedBy" class="form-label">PROBLEMS REPORTED BY</label>
                            <input type="text" class="form-control" id="reportedBy" name="reported_by">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="solvedBy" class="form-label">PROBLEMS SOLVED BY</label>
                            <input type="text" class="form-control" id="solvedBy" name="solved_by">
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-grid gap-2 col-6 mx-auto">
                <button class="btn btn-primary green-bg" type="submit">Submit</button>
                {{-- <button class="btn btn-primary" type="button">Cancel</button> --}}
            </div>
        </form>

    </div>
    <div class="p-3 text-center ">
        <img src="{{asset('logo.jpeg')}}" class="img-fluid">
    </div>
    {{-- <div class="p-3 text-center green-bg">
        <h4>MAXWELL LTD</h4>
        <p>Employee Incident Report</p>
    </div> --}}

    <script>
        function shouldShowOtherField(that) {
            if (that.value == "others") {
                document.getElementById("others").style.display = "block";
            } else {
                document.getElementById("others").style.display = "none";
            }
        }

    </script>
</body>
</html>
