<?php
session_start();
if (isset($_SESSION["email"])) {
    header('Location: index2.php');
}
if (isset($_POST['email']) && isset($_POST['pw'])) {
    $num_exists = 0;
    $exists = false;
    $servername = "128.199.220.58";
    $username = "root";
    $password = "Intelll3x";
    // Create connection
    $conn = new mysqli($servername, $username, $password);
    $conn->select_db("intellex");
    $stmt = $conn->prepare('SELECT email, pw, first_name, last_name FROM user');
    $email = "";
    $password = "";
    $fn = "";
    $ln = "";
    $stmt->execute();
    $stmt->bind_result($email, $password, $fn, $ln);
    while ($stmt->fetch()) {
        if ($email == $_POST['email']) {
            if (password_verify($_POST['pw'], $password)) {
                // Verified
                echo("<br/>LOGIN SUCCESSFUL");
                $_SESSION["email"] = $email;
                $_SESSION["user_fn"] = $fn;
                $_SESSION["user_ln"] = $ln;
                break;
            } else {
                break;
            }
        }
    }
    $conn->close();
}
if (isset($_SESSION["email"])) {
    header('Location: index2.php');
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Login - INTELLLEX Search</title>
        <!-- Latest compiled and minified CSS -->
        <link href='http://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css">
        <!-- Latest compiled and minified JavaScript -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
        <script src="js/bootstrap-select.min.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="css/styles.css">
        <link rel="stylesheet" href="css/bootstrap-select.css">
        <!-- start Mixpanel --><script type="text/javascript">(function (f, b) {
                if (!b.__SV) {
                    var a, e, i, g;
                    window.mixpanel = b;
                    b._i = [];
                    b.init = function (a, e, d) {
                        function f(b, h) {
                            var a = h.split(".");
                            2 == a.length && (b = b[a[0]], h = a[1]);
                            b[h] = function () {
                                b.push([h].concat(Array.prototype.slice.call(arguments, 0)))
                            }
                        }
                        var c = b;
                        "undefined" !== typeof d ? c = b[d] = [] : d = "mixpanel";
                        c.people = c.people || [];
                        c.toString = function (b) {
                            var a = "mixpanel";
                            "mixpanel" !== d && (a += "." + d);
                            b || (a += " (stub)");
                            return a
                        };
                        c.people.toString = function () {
                            return c.toString(1) + ".people (stub)"
                        };
                        i = "disable track track_pageview track_links track_forms register register_once alias unregister identify name_tag set_config people.set people.set_once people.increment people.append people.union people.track_charge people.clear_charges people.delete_user".split(" ");
                        for (g = 0; g < i.length; g++)
                            f(c, i[g]);
                        b._i.push([a, e, d])
                    };
                    b.__SV = 1.2;
                    a = f.createElement("script");
                    a.type = "text/javascript";
                    a.async = !0;
                    a.src = "undefined" !== typeof MIXPANEL_CUSTOM_LIB_URL ? MIXPANEL_CUSTOM_LIB_URL : "//cdn.mxpnl.com/libs/mixpanel-2-latest.min.js";
                    e = f.getElementsByTagName("script")[0];
                    e.parentNode.insertBefore(a, e)
                }
            })(document, window.mixpanel || []);
            mixpanel.init("a94c375ed0f1e4e67686b836f1498372");
//            mixpanel.track("Arrived at search page");
        </script>
        <!-- end Mixpanel -->
        <script>
            $(document).ready(function (e) {
                $('.selectpicker').selectpicker({});
            });
        </script>
    </head>
    <body>
        <?php ?>
        <div class="bodyHeight" style="width: 100%; background-color: #FFFFFF;">
            <div style="height: 20vh;">
            </div>
            <div style="height: 60vh;">
                <!--                <div style="height: 80px;">
                                    <div id="logo" style="width: 1000px; margin-left: auto; margin-right: auto;">
                                        <div id="tagline" style="width: 183px; margin-left: auto; margin-right: auto;">
                                            <a>Login</a>
                                        </div>
                                    </div>
                                </div>-->
                <div style="height: 70px;">
                    <div id="logo" style="width: 1000px; margin-left: auto; margin-right: auto;">
                        <div id="tagline" style="margin-left: auto; margin-right: auto; width: 183px;">
                            <a href="http://intelllex.com">INTELLLEX</a>
                        </div>
                        <div style="width: 311px; margin-left: auto; margin-right: auto;">
                            <span style="font-size: 18px; color: #999">Get a Headstart in your Legal Research</span>
                        </div>
                    </div>
                </div>
                <div style="height: 10px;"></div>
                <form class="form-inline" method="post" action="login.php" style="width: 70%; margin-left: auto; margin-right: auto;">
                    <div class="form-group" style="width: 100%;">
                        <label class="sr-only" for="searchQuery"></label>
                        <div class="input-group" style="display:block; width: 1000px; margin-left: auto; margin-right: auto;">
                            <div>
                                <input style="width: 400px;" type="email" name="email" class="form-control" id="searchQuery" placeholder="Email Address">
                                <input type="password" style="float:left; width: 300px; margin-left: 20px;" name="pw" class="form-control" id="searchQuery" placeholder="Password">
                                <button style="margin-left: 20px; float:left; width: 200px;" type="submit" class="btn btn-default" aria-label="Left Align">
                                    <span aria-hidden="true">Login</span>
                                </button>
                            </div>
                            <div style="height: 44px;"></div>
                        </div>
                    </div>
            </div>
        </form>
    </div>
    <div style="height: 20vh;"></div>
</div>
</body>
</html>
