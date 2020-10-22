<?php
$category = "page";
$site = "times";

session_start();

include("generic.php");
require dirname(__FILE__) . '/api/database.php';

include("requirelogin.php");

?>

<script>


function createe() {
    if (document.getElementById("create").classList.contains("open")) {
        document.getElementById("create").classList.remove("open");
    } else {
        document.getElementById("create").classList.add("open");
    }
}



</script>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>TimeHub • Times</title>
    <meta name="author" content="name">
    <meta name="description" content="none">
    <meta name="keywords" content="none">
    <link rel="stylesheet" href="<?php echo $category; ?>.css" type="text/css">
    <link rel="stylesheet" href="<?php echo $site; ?>.css" type="text/css">
</head>

<body>
    <div class="popup" id="create">
        <div class="close">
            <i class="far fa-times-circle closeb" onclick="createe()"></i>
        </div>
        <div class="popup-inner">
            <h1 class="header">Create a timezone</h1>
            <form action="/create" method="post">
                <div class="label-cont">
                    <label class="label2">UTC Offset</label>
                    <div class="range-value" class="range-value" id="rangeV"></div>
                </div>
                <div class="range-cont">

                    <input class="range" type="range" id="offset" name="offset" min="-12" max="14" step="1" value="0">
                </div>
                <label class="label">Name</label>
                <input class="oui-textbox oui-textbox-100 input" type="text" id="name" name="name">
                <label class="label">Description</label>
                <input class="oui-textbox oui-textbox-100 input" type="text" id="description" name="description">
                <div class="switchcont">
                    <h1 class="switchlabel">
                        Summer Time
                    </h1>
                    <label class="switch">
                        <input type="checkbox" name="summer">
                        <span class="slider round"></span>
                    </label>
                </div>
                <input class="oui-button" type="submit" value="Submit">
            </form>
        </div>
    </div>
    <?php navbar(); ?>
    <div class="main-content">
        <div class="welcome">
            <div class="left">
                <h1 class="welcomeback">Welcome back to <span class="time">Time</span><span class="hub">Hub</span></h1>
                <h1 class="utctime" id="utctime">It is currently Loading... in UTC.</h1>
            </div>
            <div class="right">
                <i onclick="createe()" class="fas fa-plus-circle add"></i>
            </div>
        </div>
        <div class="times">
            <?php
        $sql = $mysqli_conection->query("SELECT * FROM `times` WHERE owner = " . $_SESSION['id']);

        while ($mp = $sql->fetch_assoc()) { 
            $name = $mp['name'];
            $desc = $mp['description'];
            $offset = $mp['offset'];
            $summer = $mp['summer'];

            if($summer == 1){
                $offset++;
            }
          
            ?>
            <div class="time-panel" id="time">
                <div class="time-panel-inner">
                    <div calss="info">
                        <p class="name large"><?php echo $name; ?></p>
                        <p class="desc small"><?php echo $desc; ?></p>
                    </div>
                    <div class="thetime">
                        <p class="time large paneltime" offset="<?php echo $offset; ?>">Loading...</p>
                        <p class="timezone small">UTC+<?php echo $offset; ?>
                        <?php if($summer == 1){
                            echo " (Summer)";
                        } ?></p>
                    </div>
                </div>
                <div class="edit">
                    <div class="editbut">
                        <i class="fas fa-pen"></i>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>

</body>

<script>
const
    range = document.getElementById('offset'),
    rangeV = document.getElementById('rangeV'),
    setValue = () => {
        const
            newValue = Number((range.value - range.min) * 100 / (range.max - range.min)),
            newPosition = 10 - (newValue * 0.2);
        rangeV.innerHTML = `<span>${range.value}</span>`;
        rangeV.style.left = `calc(${newValue}% + (${newPosition}px))`;
    };
document.addEventListener("DOMContentLoaded", setValue);
range.addEventListener('input', setValue);

function calcTime(offset) {
    // create Date object for current location
    var d = new Date();

    // convert to msec
    // subtract local time zone offset
    // get UTC time in msec
    var utc = d.getTime() + (d.getTimezoneOffset() * 60000);

    // create new Date object for different city
    // using supplied offset
    var nd = new Date(utc + (3600000 * offset));

    // return time as a string
    return nd.toLocaleString([], {
        hour: '2-digit',
        minute: '2-digit'
    });
}

var times = document.getElementsByClassName("paneltime");

function go() {
    document.getElementById("utctime").innerHTML = "It is currently " + calcTime(0) + " in UTC";
    for (i = 0; i < times.length; i++) {
        var offset = times[i].getAttribute('offset');
        times[i].innerHTML = calcTime(offset);
    }
}

go();

setInterval(function() {
    go();
}, 5000);
</script>