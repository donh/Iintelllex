<?php
session_start();
if (!isset($_SESSION["email"])) {
    header('Location: login.php');
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>INTELLLEX Search</title>
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css">
        <!-- Latest compiled and minified JavaScript -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />

        <link rel="stylesheet" href="css/styles.css">
        <script>
            jQuery(function() {
                jQuery(".dropdown-menu li a").click(function () {
                    jQuery(".btn:first-child").text(jQuery(this).text());
                    jQuery(".btn:first-child").val(jQuery(this).text());
                });
                $(".dropdown-menu li a").click(function () {
                    $(".btn:first-child").text($(this).text());
                    $(".btn:first-child").val($(this).text());
                });

                $("#jurisdiction-btn-all").click(function () {
                    if ($("#jurisdiction-btn-all").is(':checked')) {
                        $(".jurisdiction-btn").prop('checked', true);
                    } else {
                        $(".jurisdiction-btn").prop('checked', false);
                    }
                });
                $(".jurisdiction-btn").click(function () {
                    if ($("#jurisdiction-btn-all").is(':checked')) {
                        $("#jurisdiction-btn-all").prop('checked', false);
                    }
                });
                $("#logoutBtn").click(function () {
                    window.location.replace("logout.php");
                });
            });
        </script>
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
            mixpanel.track("Arrived at search page");
            </script>
            <!-- end Mixpanel -->
    </head>
    <body>
<?php ?>
        <div class="bodyHeight" style="width: 100%; background-color: #FFFFFF;">
            <div style="height: 30vh;">
            <div id="top-bar">
                <div id="logo" style="margin-left: 20px;">
                    <div id="tagline" style="float:left; margin-top: 8px; width: 183px;">
                        <a href="http://intelllex.com">INTELLLEX</a>
                    </div>
                    <div style="margin-top: 12px; margin-right: 20px; float:right;" class="btn-group" role="group" aria-label="...">
                        <button id="logoutBtn" type="button" class="btn btn-default">Logout</button>
                    </div>
                </div>
            </div>
            </div>
            <div style="height: 60vh;">
                <div id="logo" style="margin-left: 20px;">
                    <div id="tagline" style="margin-left:auto; margin-right:auto; width: 183px;">
                        <a href="http://intelllex.com">INTELLLEX</a>
                    </div>
                </div>
<!--                <div style="height: 50px;">
                    <div style="width: 212px; margin-left: auto; margin-right: auto;">
                        <span style="color: #6B4226; font-size: 40px;">INTELLLEX</span>
                    </div>
                </div>-->
                <div style="height: 10px;"></div>
                <form class="form-inline" method="get" action="search.php" style="width: 80%; margin-left: auto; margin-right: auto;">
                    <div class="form-group" style="width: 100%;">
                        <label class="sr-only" for="searchQuery"></label>
                        <div class="input-group" style="width: 100%;">
<!--                            <div class="dropdown" style="width: 10%; float: left;">
                                <button class="btn btn-default dropdown-toggle btnStatus" style="width: 100%;" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">
                                    Litigation
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                                    <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Litigation</a></li>
                                    <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Corporate</a></li>
                                </ul>
                            </div>-->
                            <input type="text" style="width: 90%;" name="q" class="form-control" id="searchQuery" placeholder="Your query here...">
                            <button type="submit" style="width: 10%;" class="btn btn-default">
                                <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                            </button>
                        </div>
                    </div>
                    <div class="form-group">
                        <!--<div><small>Select your <highlight>jurisdiction</highlight>:</small></div>-->
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" id="jurisdiction-btn-all"> All
                            </label>
                        </div>
                        <div class="checkbox jur-cbx-align">
                            <label>
                                <input type="checkbox"  name="jurisdiction[]" value="SG" class="jurisdiction-btn">
                                SG
                            </label>
                        </div>
                        <div class="checkbox jur-cbx-align">
                            <label>
                                <input type="checkbox" name="jurisdiction[]" value="UK" class="jurisdiction-btn"> 
                                UK
                            </label>
                        </div>
                        <div class="checkbox jur-cbx-align">
                            <label>
                                <input type="checkbox" name="jurisdiction[]" value="HK" class="jurisdiction-btn"> 
                                HK
                            </label>
                        </div>
                        <div class="checkbox jur-cbx-align">
                            <label>
                                <input type="checkbox" name="jurisdiction[]" value="MY" class="jurisdiction-btn"> 
                                MY
                            </label>
                        </div>
                        <div class="checkbox jur-cbx-align">
                            <label>
                                <input type="checkbox" name="jurisdiction[]" value="CA" class="jurisdiction-btn"> 
                                CAN
                            </label>
                        </div>
                    </div>
                    <input type="hidden" name="start-secondary" value="0">
                    <input type="hidden" name="start-cases" value="0">
                    <input type="hidden" name="start-legislation" value="0">
                    <input type="hidden" name="active" value="secondary">
                    <input type="hidden" name="newquery" value="true">
                    <input type="hidden" name="rows" value="30">
                </form>
            </div>
            <div style="height: 20vh;"></div>
        </div>
    </body>
</html>
