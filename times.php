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
                <!--<div class="switchcont">
                    <h1 class="switchlabel">
                        Summer Time
                    </h1>
                    <label class="switch">
                        <input type="checkbox" name="summer">
                        <span class="slider round"></span>
                    </label>
                </div>-->
                <input class="oui-button submit" type="submit" value="Submit">
            </form>
        </div>
    </div>
    <div class="popup" id="edit">
        <div class="close">
            <i class="far fa-times-circle closeb" onclick="editzone(0,0)"></i>
        </div>
        <div class="popup-inner">
            <h1 class="header" id="title">Edit Loading...</h1>
            <form action="/edit" method="post">
                <input type="hidden" id="id" name="id" value="-1">
                <div class="label-cont">
                    <label class="label2" id="label-edit">UTC Offset</label>
                    <div class="range-value" class="range-value" id="rangeV-edit"></div>
                </div>
                <div class="range-cont">
                    <input class="range" type="range" id="offset-edit" name="offset" min="-12" max="14" step="1"
                        value="0">
                </div>
                <label class="label">Name</label>
                <input class="oui-textbox oui-textbox-100 input" type="text" id="name-edit" name="name" value="Loading">
                <label class="label">Description</label>
                <input class="oui-textbox oui-textbox-100 input" type="text" id="description-edit" name="description"
                    value="Loading">
                <!--<div class="switchcont">
                    <h1 class="switchlabel">
                        Summer Time
                    </h1>
                    <label class="switch">
                        <input type="checkbox" name="summer">
                        <span class="slider round"></span>
                    </label>
                </div>-->
                <input class="oui-button submit" type="submit" value="Update">
            </form>
            <form action="/delete" method="post">
                <input type="hidden" id="id2" name="id" value="-1">
                <input class="oui-button warning delete submit" type="submit" value="Delete">
            </forM>
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
            $id = $mp['id'];
            $name = htmlspecialchars($mp['name']);
            $desc = htmlspecialchars($mp['description']);
            $offset = htmlspecialchars($mp['offset']);
            $summer = htmlspecialchars($mp['summer']);

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

                <div class="edit" onclick="editzone(<?php echo $id; ?>, '<?php echo $_SESSION['wkey']; ?>');">
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
function editzone(id, wkey) {
    if (document.getElementById("edit").classList.contains("open")) {
        document.getElementById("edit").classList.remove("open");
    } else {

        console.log("id:" + id);
        console.log("wkey:" + id);
        console.log("contacting api...");

        var url = "https://timehub.hubza.co.uk/api/get_time?wkey=" + wkey + "&id=" + id;

        var request = new XMLHttpRequest()

        request.open('GET', url, true)

        request.onload = function() {
            var data = JSON.parse(this.response)

            console.log(data.name);

            offset = document.getElementById("offset-edit");
            namee = document.getElementById("name-edit");
            description = document.getElementById("description-edit");
            title = document.getElementById("title");
            ido = document.getElementById("id");
            ido2 = document.getElementById("id2");

            offset.value = parseInt(data.offset); //changes the value
            namee.value = data.name; //changes the value
            description.value = data.description; //changes the value
            ido.value = id;
            ido2.value = id;
            title.innerHTML = "Edit " + data.name;

            document.getElementById("edit").classList.add("open");

            setValuee();
        }

        request.send();
    }
}

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


const
    rangee = document.getElementById('offset-edit'),
    rangeVe = document.getElementById('rangeV-edit'),
    setValuee = () => {
        const
            newValue = Number((rangee.value - rangee.min) * 100 / (rangee.max - rangee.min)),
            newPosition = 10 - (newValue * 0.2);
        rangeVe.innerHTML = `<span>${rangee.value}</span>`;
        rangeVe.style.left = `calc(${newValue}% + (${newPosition}px))`;
    };
document.addEventListener("DOMContentLoaded", setValuee);

rangee.addEventListener('input', setValuee);


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