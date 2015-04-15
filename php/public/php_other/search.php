<!DOCTYPE html>
<html>
    <?php require('search-json.php'); ?>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Intelllex Search</title>
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css">
        <!-- Latest compiled and minified JavaScript -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="css/styles.css">        
        <script src="js/script.js"></script>
        <script>
            function updoc(docUrl) {
                var vars = [], hash;
                var q = document.URL.split('?')[1];
                if (q != undefined) {
                    q = q.split('&');
                    for (var i = 0; i < q.length; i++) {
                        hash = q[i].split('=');
                        vars.push(hash[1]);
                        vars[hash[0]] = hash[1];
                    }
                }
                var xmlhttp;
                if (window.XMLHttpRequest)
                {// code for IE7+, Firefox, Chrome, Opera, Safari
                    xmlhttp = new XMLHttpRequest();
                    xmlhttp.open("GET", "update-pref.php?url=" + docUrl + "&like-type=1&q=" + vars['q'], true);
                    xmlhttp.send();
//                    document.getElementById(docUrl + '-up').innerHTML = parseInt(document.getElementById(docUrl + '-up').innerHTML) + 1;
                }
                else
                {// code for IE6, IE5
                    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                    xmlhttp.open("GET", "update-pref.php?url=" + docUrl + "&like-type=1&q=" + vars['q'], true);
                    xmlhttp.send();
//                    document.getElementById(docUrl + '-up').innerHTML = parseInt(document.getElementById(docUrl + '-up').innerHTML) + 1;
                }
            }
            function downdoc(docUrl) {
                var vars = [], hash;
                var q = document.URL.split('?')[1];
                if (q != undefined) {
                    q = q.split('&');
                    for (var i = 0; i < q.length; i++) {
                        hash = q[i].split('=');
                        vars.push(hash[1]);
                        vars[hash[0]] = hash[1];
                    }
                }
                var xmlhttp;
                if (window.XMLHttpRequest)
                {// code for IE7+, Firefox, Chrome, Opera, Safari
                    xmlhttp = new XMLHttpRequest();
                    xmlhttp.open("GET", "update-pref.php?url=" + docUrl + "&like-type=0&q=" + vars['q'], true);
                    xmlhttp.send();
//                    document.getElementById(docUrl + '-down').innerHTML = parseInt(document.getElementById(docUrl + '-down').innerHTML) + 1;
                }
                else
                {// code for IE6, IE5
                    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                    xmlhttp.open("GET", "update-pref.php?url=" + docUrl + "&like-type=0&q=" + vars['q'], true);
                    xmlhttp.send();
//                    document.getElementById(docUrl + '-down').innerHTML = parseInt(document.getElementById(docUrl + '-down').innerHTML) + 1;
                }
            }

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
            var vars = [], hash;
            var q = document.URL.split('?')[1];
            if (q != undefined) {
                q = q.split('&');
                for (var i = 0; i < q.length; i++) {
                    hash = q[i].split('=');
                    vars.push(hash[1]);
                    vars[hash[0]] = hash[1];
                }
            }
            mixpanel.track("Searched " + vars['q']);
        </script><!-- end Mixpanel -->
        <script>
            $(document).ready(function () {
                
//                $("form#top-search").submit(function(){
//                    alert("Clicked");
//                    if ($("#newquery").val() === "true") {
//                        $("#top-search-start-secondary").val("0");
//                        $("#top-search-start-cases").val("0");
//                        $("#top-search-start-legislation").val("0");
//                        $("#active-panel").val("secondary");
//                    }
//                    return true;
//                });
                
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

                function updateTopSearchBar() {
                    var query = getQueryVariable("q");
                    if (query)
                        $("#searchQuery").val(query);

                    var JXs = getQueryVariables("jurisdiction%5B%5D");
                    jQuery("input[name='jurisdiction[]']").prop("checked", false);
                    if (JXs.length) {
                        for (var i = 0; i < JXs.length; i++) {
                            jQuery("input[name='jurisdiction[]'][value='" + JXs[i] + "']").prop("checked", true);
                        }
                    }
                }
                updateTopSearchBar();

                var start_cases = <?php echo $startCases; ?>;
                var start_legislation = <?php echo $startLegislation; ?>;
                var start_secondary = <?php echo $startSecondary; ?>;

//                if (start_cases) {
                    start_cases = parseInt(start_cases);
                    $("#page-right-case").prop("disabled", false);
                    if (start_cases > 0) {
                        $("#page-left-case").prop("disabled", false);
                    }
                    start_cases = start_cases - (start_cases % 30);

                    $("#page-left-case").click(function () {
                        var startMinus = start_cases - 30;
                        if (startMinus < 0)
                            startMinus = 0;
                        updateTopSearchBar();
                        $("#top-search-start-cases").val(startMinus);
                        $("#active-panel").val("cases");
                        $("#newquery").val("false");
                        $("form#top-search").submit();
                    });

                    $("#page-right-case").click(function () {
                        $("#top-search-start-cases").val(start_cases + 30);
                        $("#active-panel").val("cases");
                        $("#newquery").val("false");
                        updateTopSearchBar();
                        $("form#top-search").submit();
                    });
//                }

//                if (start_legislation) {
                    start_legislation = parseInt(start_legislation);
                    $("#page-right-legislation").prop("disabled", false);
                    if (start_legislation > 0) {
                        $("#page-left-legislation").prop("disabled", false);
                    }
                    start_legislation = start_legislation - (start_legislation % 30);

                    $("#page-left-legislation").click(function () {
                        var startMinus = start_legislation - 30;
                        if (startMinus < 0)
                            startMinus = 0;
                        $("#active-panel").val("legislation");
                        $("#newquery").val("false");
                        updateTopSearchBar();
                        $("#top-search-start-legislation").val(startMinus);
                        $("form#top-search").submit();
                    });

                    $("#page-right-legislation").click(function () {
                        $("#top-search-start-legislation").val(start_legislation + 30);
                        $("#active-panel").val("legislation");
                        $("#newquery").val("false");
                        updateTopSearchBar();
                        $("form#top-search").submit();
                    });
//                }

//                if (start_secondary) {
                    start_secondary = parseInt(start_secondary);
                    $("#page-right-secondary").prop("disabled", false);
                    if (start_secondary > 0) {
                        $("#page-left-secondary").prop("disabled", false);
                    }
                    start_secondary = start_secondary - (start_secondary % 30);

                    $("#page-left-secondary").click(function () {
                        var startMinus = start_secondary - 30;
                        if (startMinus < 0)
                            startMinus = 0;
                        $("#active-panel").val("secondary");
                        $("#newquery").val("false");
                        updateTopSearchBar();
                        $("#top-search-start-secondary").val(startMinus);
                        $("form#top-search").submit();
                    });

                    $("#page-right-secondary").click(function () {
                        $("#top-search-start-secondary").val(start_secondary + 30);
                        $("#active-panel").val("secondary");
                        $("#newquery").val("false");
                        updateTopSearchBar();
                        $("form#top-search").submit();
                    });
//                }

                
                if (<?php echo(count($search_result_json_secondary['response']['docs'])); ?> < 30) {
                    $("#page-right-secondary").prop("disabled", true);
                } else {
                    $("#page-right-secondary").prop("disabled", false);
                }
                if (<?php echo(count($search_result_json_case['response']['docs'])); ?> < 30) {
                    $("#page-right-case").prop("disabled", true);
                } else {
                    $("#page-right-case").prop("disabled", false);
                }
                if (<?php echo(count($search_result_json_legislation['response']['docs'])); ?> < 30) {
                    $("#page-right-legislation").prop("disabled", true);
                } else {
                    $("#page-right-legislation").prop("disabled", false);
                }
                if (<?php echo($numFound_secondary); ?> <= 30) {
                    $("#page-right-secondary").prop("disabled", true);
                } else {
                    $("#page-right-secondary").prop("disabled", false);
                }
                if (<?php echo($numFound_case); ?> <= 30) {
                    $("#page-right-case").prop("disabled", true);
                } else {
                    $("#page-right-case").prop("disabled", false);
                }
                if (<?php echo($numFound_legislation); ?> <= 30) {
                    $("#page-right-legislation").prop("disabled", true);
                } else {
                    $("#page-right-legislation").prop("disabled", false);
                }
            });
        </script>
    </head>
    <body>
        <div class="bodyHeight" style="width: 100%; background-color: #FFFFFF;">
            <div id="header">
                <div>
                    <form id="top-search" class="form-inline" method="get" action="search.php" style="width: 80%; margin-left: auto; margin-right: auto;">
                        <div class="form-group" style="width: 100%;">
                            <label class="sr-only" for="searchQuery"></label>
                            <div class="input-group" style="width: 100%;">
                                <input type="text" style="width: 80%;" name="q" class="form-control" id="searchQuery" placeholder="Your query here...">
                                <button type="submit" style="width: 10%;" class="btn btn-default">
                                    <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                                </button>
                                <div style="clear:left;"></div>
                            </div>
                        </div>
                        <span style="width: 9%;margin-right:1%;display: inline-block;float: left;text-align: right;">
                            <small><highlight>Jurisdiction</highlight>:</small> 
                        </span>
                        <div class="form-group" style="width:90%;">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" id="jurisdiction-btn-all"> All
                                </label>
                            </div>
                            <div class="checkbox jur-cbx-align">
                                <label>
                                    <input type="checkbox" name="jurisdiction[]" value="SG" class="jurisdiction-btn">
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
                                    <input type="checkbox" name="jurisdiction[]" value="CAN" class="jurisdiction-btn"> 
                                    CAN
                                </label>
                            </div>
                        </div>
                        <input id="top-search-start-secondary" type="hidden" name="start-secondary" value="<?php echo $startSecondary; ?>">
                        <input id="top-search-start-cases" type="hidden" name="start-cases" value="<?php echo $startCases; ?>">
                        <input id="top-search-start-legislation" type="hidden" name="start-legislation" value="<?php echo $startLegislation; ?>">
                        <input id="active-panel" type="hidden" name="active" value="secondary">
                        <input id="newquery" type="hidden" name="newquery" value="true">
                        <input type="hidden" name="rows" value="30">
                    </form>
                </div>
            </div>
            <div class="tab-content" style="width:95%; margin-left: auto; margin-right: auto;">
                <ul class="nav nav-tabs">
                    <li role="presentation" <?php if ($active == "secondary") { ?>class="active"<?php } ?>><a data-toggle="tab" href="#secondary-table">Secondary Sources</a></li>
                    <li role="presentation" <?php if ($active == "cases") { ?>class="active"<?php } ?>><a data-toggle="tab" href="#case-table">Cases</a></li>
                    <li role="presentation" <?php if ($active == "legislation") { ?>class="active"<?php } ?>><a data-toggle="tab" href="#legislation-table">Legislation</a></li>
                </ul>

                <!-- Secondary Results -->
                <div id='secondary-table' class="tab-pane <?php if ($active == "secondary") { ?>fade in active<?php } ?>">
                    <table class="table table-hover" style="width: 100%;">
                        <tr>
                            <?php
                            $min = $startSecondary;
                            $max = $startSecondary + count($search_result_json_secondary['response']['docs']);
                            if ($numFound_secondary == 0) {
                                $min = 0;
                            }
                            if ($numFound_secondary < 30) {
                                $max = $numFound_secondary;
                            }
                            ?>
                            <th>
                        <div style="float: right;right: 3em;">
                            <button class="btn btn-default" id="page-left-secondary" disabled><span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span></button>
                            <button class="btn btn-default" id="page-right-secondary" disabled><span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span></button>
                        </div>
                        (<?php echo ("$min-$max"); ?>) of <?php echo $numFound_secondary; ?> Results</th>
                        <th></th>
                        </tr>
                        <?php if ($numFound_secondary == 0) { ?>
                            <tr><th>No secondary sources results found.</th></tr>
                        <?php } ?>
                        <?php
                        foreach ($docs_secondary as $doc) {
                            $url = $doc['url'];
                            if (isset($highlighting[$doc["id"]]["url"])) {
                                $url = highlight_original($doc['url'], $highlighting[$doc["id"]]["url"][0], "<em>", "</em>");
                            }

                            if (isset($doc["title"])) {
                                if (isset($highlighting[$doc["id"]]["title"])) {
                                    $title = highlight_original($doc["title"], $highlighting[$doc["id"]]["title"][0], "<em>", "</em>");
                                } else {
                                    $title = $doc['title'];
                                }
                            } else {
                                $title = $url;
                            }
                            if (isset($doc['content'])) {
                                if (isset($highlighting[$doc["id"]]["content"])) {
                                    $content = highlight_original($doc["content"], $highlighting[$doc["id"]]["content"][0], "<em>", "</em>");
                                } else {
                                    $content = $doc['content'];
                                }
                            } else {
                                $content = "No content available.";
                            }
                            ?>
                            <tr>
                                <td class="active">
                            <u><a href="<?php echo $doc['url']; ?>" target="_blank">  
                                    <?php echo $title; ?></a>
                            </u>
                            <?php
                            echo "<span class='search-term-url small'>" . $doc['url'] . "</span>";
                            ?>
                            <div>
                                <div style="float:left; width: 40px; padding-top: 10px;">
                                    <button onclick="updoc('<?php echo $doc['url']; ?>')" class="btn btn-default"><span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span></button>
                                    <div class='small' style="font-weight: bold; color: green;">
                                        <center id='<?php echo $doc['url'] . '-up'; ?>'></center>
                                    </div>
                                    <button onclick="downdoc('<?php echo $doc['url']; ?>')" class="btn btn-default"><span class="glyphicon glyphicon-thumbs-down" aria-hidden="true"></span></button>
                                    <div class='small' style="font-weight: bold; color: red;">
                                        <center 
                                            id='<?php echo $doc['url'] . '-down'; ?>'
                                            ></center>
                                    </div>
                                </div>
                                <div style="float: left; width: 93%;">
                                    <blockquote style='font-size: 12px; padding-left: 0px;'>

                                        <?php
                                        $summaryTxt = "";
                                        if (strpos($content, '<em>') !== false) {
                                            if (strpos($content, '<em>') - 100 <= 0) {
                                                $summaryTxt = substr($content, 0, strpos($content, '</em>') + 5);
                                            } else {
                                                $summaryTxt = '...' . substr($content, strpos($content, '</em>') + 5 - 100, 100);
                                            }
                                            $summaryTxt = $summaryTxt . substr($content, strpos($content, '</em>') + 5, 500) . "...";
                                        } else {
                                            $summaryTxt = substr($content, 0, 500);
                                        }
                                        echo $summaryTxt;
                                        ?>
                                        <!--                         <footer>
                                        <?php
                                        $mil = $doc['tstamp'];
                                        $seconds = $mil / 1000;
                                        echo date("d F Y", $seconds);
//                                    $datetime = new DateTime($doc['tstamp']);
//                                    echo str_replace('Z', '', $datetime->format(DateTime::COOKIE));
                                        ?>
                                                                </footer>
                                        -->                    </blockquote>
                                </div>
                            </div>
                            </td>
                            <td class="active">
                            </td>
                            </tr>
                        <?php } ?>
                    </table>
                </div>

                <!-- Case Table -->
                <div id='case-table' class="tab-pane <?php if ($active == "cases") { ?>fade in active<?php } ?>">
                    <table class="table table-hover" style="width: 100%;">
                        <tr>
                            <?php
                            $min = $startCases;
                            $max = $startCases + count($search_result_json_case['response']['docs']);
                            if ($numFound_case < 30) {
                                $max = $numFound_case;
                            }
                            if ($numFound_case == 0) {
                                $min = 0;
                            }
                            ?>
                            <th>
                        <div style="float: right;right: 3em;">
                            <button class="btn btn-default" id="page-left-case" disabled><span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span></button>
                            <button class="btn btn-default" id="page-right-case" disabled><span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span></button>
                        </div>
                        (<?php echo ("$min-$max"); ?>) of <?php echo $numFound_case; ?> Results</th>
                        </tr>
                        <?php if ($numFound_case == 0) { ?>
                            <tr>
                                <th>No cases found.</th>
                            </tr>

                        <?php } ?>
                        <?php
                        foreach ($docs_case as $doc) {
                            $url = $doc['url'];
                            if (isset($highlighting[$doc["id"]]["url"])) {
                                $url = highlight_original($doc['url'], $highlighting[$doc["id"]]["url"][0], "<em>", "</em>");
                            }

                            if (isset($doc["title"])) {
                                if (isset($highlighting[$doc["id"]]["title"])) {
                                    $title = highlight_original($doc["title"], $highlighting[$doc["id"]]["title"][0], "<em>", "</em>");
                                } else {
                                    $title = $doc['title'];
                                }
                            } else {
                                $title = $url;
                            }
                            if (isset($doc['content'])) {
                                if (isset($highlighting[$doc["id"]]["content"])) {
                                    $content = highlight_original($doc["content"], $highlighting[$doc["id"]]["content"][0], "<em>", "</em>");
                                } else {
                                    $content = $doc['content'];
                                }
                            } else {
                                $content = "No content available.";
                            }
                            ?>
                            <tr>
                                <td class="active">
                            <u><a href="<?php echo $doc['url']; ?>" target="_blank">  
                                    <?php echo $title; ?></a>
                            </u>
                            <?php
                            echo "<span class='search-term-url small'>" . $doc['url'] . "</span>";
                            ?>
                            <div>
                                <div style="float:left; width: 40px; padding-top: 10px;">
                                    <button onclick="updoc('<?php echo $doc['url']; ?>')" class="btn btn-default"><span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span></button>
                                    <div class='small' style="font-weight: bold; color: green;">
                                        <center id='<?php echo $doc['url'] . '-up'; ?>'></center>
                                    </div>
                                    <button onclick="downdoc('<?php echo $doc['url']; ?>')" class="btn btn-default"><span class="glyphicon glyphicon-thumbs-down" aria-hidden="true"></span></button>
                                    <div class='small' style="font-weight: bold; color: red;">
                                        <center 
                                            id='<?php echo $doc['url'] . '-down'; ?>'
                                            ></center>
                                    </div>
                                </div>
                                <div style="float: left; width: 93%;">
                                    <blockquote style='font-size: 12px; padding-left: 0px;'>

                                        <?php
                                        $summaryTxt = "";
                                        if (strpos($content, '<em>') !== false) {
                                            if (strpos($content, '<em>') - 100 <= 0) {
                                                $summaryTxt = substr($content, 0, strpos($content, '</em>') + 5);
                                            } else {
                                                $summaryTxt = '...' . substr($content, strpos($content, '</em>') + 5 - 100, 100);
                                            }
                                            $summaryTxt = $summaryTxt . substr($content, strpos($content, '</em>') + 5, 500) . "...";
                                        } else {
                                            $summaryTxt = substr($content, 0, 500);
                                        }
                                        echo $summaryTxt;
                                        ?>
                                        <!--                         <footer>
                                        <?php
                                        $mil = $doc['tstamp'];
                                        $seconds = $mil / 1000;
                                        echo date("d F Y", $seconds);
//                                    $datetime = new DateTime($doc['tstamp']);
//                                    echo str_replace('Z', '', $datetime->format(DateTime::COOKIE));
                                        ?>
                                                                </footer>
                                        -->                    </blockquote>
                                </div>
                            </div>
                            </td>
                            <td class="active">
                            </td>
                            </tr>
                        <?php } ?>
                    </table>
                </div>
                <!-- Legislation Results -->
                <div id='legislation-table' class="tab-pane <?php if ($active == "legislation") { ?>fade in active<?php } ?>">
                    <table class="table table-hover" style="width: 100%;">
                        <tr>
                            <?php
                            $min = $startLegislation;
                            $max = $startLegislation + count($search_result_json_legislation['response']['docs']);
                            if ($numFound_legislation < 30) {
                                $max = $numFound_legislation;
                            }
                            if ($numFound_legislation == 0) {
                                $min = 0;
                            }
                            ?>
                            <th>
                        <div style="float: right;right: 3em;">
                            <button class="btn btn-default" id="page-left-legislation" disabled><span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span></button>
                            <button class="btn btn-default" id="page-right-legislation" disabled><span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span></button>
                        </div>
                        (<?php echo ("$min-$max"); ?>) of <?php echo $numFound_legislation; ?> Results</th>
                        <th></th>
                        </tr>
                        <?php if ($numFound_legislation == 0) { ?>
                            <tr><th>No legislations found.</th></tr>
                        <?php } ?>
                        <?php
                        foreach ($docs_legislation as $doc) {
                            $url = $doc['url'];
                            if (isset($highlighting[$doc["id"]]["url"])) {
                                $url = highlight_original($doc['url'], $highlighting[$doc["id"]]["url"][0], "<em>", "</em>");
                            }

                            if (isset($doc["title"])) {
                                if (isset($highlighting[$doc["id"]]["title"])) {
                                    $title = highlight_original($doc["title"], $highlighting[$doc["id"]]["title"][0], "<em>", "</em>");
                                } else {
                                    $title = $doc['title'];
                                }
                            } else {
                                $title = $url;
                            }
                            if (isset($doc['content'])) {
                                if (isset($highlighting[$doc["id"]]["content"])) {
                                    $content = highlight_original($doc["content"], $highlighting[$doc["id"]]["content"][0], "<em>", "</em>");
                                } else {
                                    $content = $doc['content'];
                                }
                            } else {
                                $content = "No content available.";
                            }
                            ?>
                            <tr>
                                <td class="active">
                            <u><a href="<?php echo $doc['url']; ?>" target="_blank">  
                                    <?php echo $title; ?></a>
                            </u>
                            <?php
                            echo "<span class='search-term-url small'>" . $doc['url'] . "</span>";
                            ?>
                            <div>
                                <div style="float:left; width: 40px; padding-top: 10px;">
                                    <button onclick="updoc('<?php echo $doc['url']; ?>')" class="btn btn-default"><span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span></button>
                                    <div class='small' style="font-weight: bold; color: green;">
                                        <center id='<?php echo $doc['url'] . '-up'; ?>'></center>
                                    </div>
                                    <button onclick="downdoc('<?php echo $doc['url']; ?>')" class="btn btn-default"><span class="glyphicon glyphicon-thumbs-down" aria-hidden="true"></span></button>
                                    <div class='small' style="font-weight: bold; color: red;">
                                        <center 
                                            id='<?php echo $doc['url'] . '-down'; ?>'
                                            ></center>
                                    </div>
                                </div>
                                <div style="float: left; width: 93%;">
                                    <blockquote style='font-size: 12px; padding-left: 0px;'>

                                        <?php
                                        $summaryTxt = "";
                                        if (strpos($content, '<em>') !== false) {
                                            if (strpos($content, '<em>') - 100 <= 0) {
                                                $summaryTxt = substr($content, 0, strpos($content, '</em>') + 5);
                                            } else {
                                                $summaryTxt = '...' . substr($content, strpos($content, '</em>') + 5 - 100, 100);
                                            }
                                            $summaryTxt = $summaryTxt . substr($content, strpos($content, '</em>') + 5, 500) . "...";
                                        } else {
                                            $summaryTxt = substr($content, 0, 500);
                                        }
                                        echo $summaryTxt;
                                        ?>
                                        <!--                         <footer>
                                        <?php
                                        $mil = $doc['tstamp'];
                                        $seconds = $mil / 1000;
                                        echo date("d F Y", $seconds);
//                                    $datetime = new DateTime($doc['tstamp']);
//                                    echo str_replace('Z', '', $datetime->format(DateTime::COOKIE));
                                        ?>
                                                                </footer>
                                        -->                    </blockquote>
                                </div>
                            </div>
                            </td>
                            <td class="active">
                            </td>
                            </tr>
                        <?php } ?>
                    </table>
                </div>

            </div>
        </div>
    </body>
</html>
