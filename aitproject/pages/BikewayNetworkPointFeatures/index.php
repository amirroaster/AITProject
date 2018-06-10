<?php
session_start();
$url = "../../user/index.php";
if (isset($_GET['csv'])) {
	$_SESSION['file'] = "BikewayNetworkPointFeatures.csv";
	ob_start();
    header('Location: '.$url);
    ob_end_flush();
    die();
} else if (isset($_GET['json'])) {
	$_SESSION['file'] = "BikewayNetworkPointFeatures.json";
	ob_start();
    header('Location: '.$url);
    ob_end_flush();
    die();
} else if (isset($_GET['kml'])) {
	$_SESSION['file'] = "BikewayNetworkPointFeatures.kml";
	ob_start();
    header('Location: '.$url);
    ob_end_flush();
    die();
} else if (isset($_GET['kmz'])) {
	$_SESSION['file'] = "BikewayNetworkPointFeatures.kmz";
	ob_start();
    header('Location: '.$url);
    ob_end_flush();
    die();
} else if (isset($_GET['geojson'])) {
	$_SESSION['file'] = "BikewayNetworkPointFeatures.geojson";
	ob_start();
    header('Location: '.$url);
    ob_end_flush();
    die();
} else if (isset($_GET['zip'])) {
	$_SESSION['file'] = "BikewayNetworkPointFeatures.zip";
	ob_start();
    header('Location: '.$url);
    ob_end_flush();
    die();
}
?>

<html>
<head>
  <link rel="icon" href="../../files/favicon.png">
  <title>Bikway Network</title>
  <meta http-equiv="content-type" content="text/html; charset=UTF8">
  <!--<link type="text/css" href="../../css/leaflet.css" rel="stylesheet"/>
  <link type="text/css" href="../../css/MarkerCluster.Default.css" rel="stylesheet"/>
  <link type="text/css" href="../../css/MarkerCluster.css" rel="stylesheet"/>
  <link type="text/css" href="../../css/dc.css" rel="stylesheet"/>
  <link type="text/css" href="../../css/leaflet-legend.css" rel="stylesheet"/>
  <link type="text/css" href="../../css/bikewayNetworkPointFeaturesStyle.css" rel="stylesheet"/>
  <link rel="stylesheet" href="../../css/spinner.css" rel="stylesheet">
  <link rel="stylesheet" href="../../css/bootstrap.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Acme|Fira+Sans+Condensed|Fjalla+One" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="../../css/all.css">-->
  
  <link type="text/css" href="../../css/leaflet.css" rel="stylesheet"/>
  <link type="text/css" href="../../css/MarkerCluster.Default.css" rel="stylesheet"/>
  <link type="text/css" href="../../css/MarkerCluster.css" rel="stylesheet"/>
  <link type="text/css" href="../../css/dc.min.css" rel="stylesheet"/>
  <link type="text/css" href="../../css/leaflet-legend.css" rel="stylesheet"/>
  <link type="text/css" href="../../css/bikewayNetworkPointFeaturesStyle.css" rel="stylesheet"/>
  <link rel="stylesheet" href="../../css/spinner.css" rel="stylesheet">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css?family=Acme|Fira+Sans+Condensed|Fjalla+One" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="../../css/all.css">
  
  
</head>
<body>
  <div class="spinner"></div>
	<div id="holder" style="display: none;">
	<div id="gettingFiles">
		<a href='index.php?csv=true'>Get CSV</a>
		<a href='index.php?json=true'>GET JSON</a>
		<a href='index.php?kml=true'>Get KML</a>
		<a href='index.php?kmz=true'>Get KMZ</a>
		<a href='index.php?geojson=true'>Get GEOJSON</a>
		<a href='index.php?zip=true'>Get ZIP</a>
	</div>
	<header> 
		<div id="menu">
			<a href="../../">Home</a><br />
			<a href="../../user">User</a><br />
			<a href="../">OpenData</a><br />
			<a href="../../search">Search</a>
		</div>
	</header>
    <button id="undoButton" onclick="undoFunction()" title="Undo"></button><br>
    <button id="reloadButton" onclick="reloadFunction()" title="Reload this page">Reload</button><br>
		<h2>Bike-way Network Point Features</h2>
		<div id="demo3">
      <div class="searchHolder">
        <div class="search1"></div>
        <div class="search2"></div>
        <div class="search3"></div>
      </div>
      <div class="searchTable">
        <table class="table dc-data-grid">
          <thead>
            <tr class="header">
              <th>No</th>
              <th>Bikeway Net Name</th>
              <th>Street 1</th>
              <th>Street 2</th>
              <th>Year</th>
            </tr>
          </thead>
        </table>
        <button id="hideTableSearch" onclick="hideTableSearchFunction()">Hide it</button>
      </div>
      <div class="break"></div>
      <div class="map">
        <span class="reset" style="display: none;">Selected: <span class="filter"></span></span>
        <a class="reset" href="javascript:chartReset(map);" style="display: none;">reset</a>
        <div class="clearfix"></div>
      </div>
      <div class="year">
  			<strong>Installation Year:</strong>
  			<span class="reset" style="display: none;">Selected: <span class="filter"></span></span>
  			<a class="reset" href="javascript:chartReset(year);" style="display: none;">reset</a>
			  <div class="clearfix"></div>
			</div>
      <div class="break"></div>
      <div>
      	<div class="dc-data-count">
      		<span class="filter-count"></span> selected out of <span class="total-count"></span> records | <a
      			href="javascript:resetAll();">Reset All</a>
      	</div>
      </div>
      <table class="table table-hover dc-data-table"></table>
	  </div>
	  <footer> 
<p>by Amir</p>
</footer>
	</div>


  <!--<script type="text/javascript" src="../../js/d3test.js"></script>
  <script type="text/javascript" src="../../js/crossfiltertest.js"></script>
  <script type="text/javascript" src="../../js/dctest.js"></script>
	<script type="text/javascript" src="../../js/leaflet.js"></script>
	<script type="text/javascript" src="../../js/leaflet.markercluster.js"></script>
	<script type="text/javascript" src="../../js/colorbrewer.js"></script>
	<script type="text/javascript" src="../../js/dc.leaflet.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script type="text/javascript" src="../../js/bootstrap.js"></script>-->
  
  
  <script type="text/javascript" src="../../js/d3.min.js"></script>
  <script type="text/javascript" src="../../js/crossfilter.min.js"></script>
  <script type="text/javascript" src="../../js/dc.min.js"></script>
	<script type="text/javascript" src="../../js/leaflet.js"></script>
	<script type="text/javascript" src="../../js/leaflet.markercluster.js"></script>
	<script type="text/javascript" src="../../js/colorbrewer.js"></script>
	<script type="text/javascript" src="../../js/dc.leaflet.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" ></script>



	<script type="text/javascript">
		var geojsonVariable;
		var bikePointCount;
		dataP = [];
		var groupname = "group";
    var inputAlert = 0;
    var inputValueTmp1;
    var inputValueTmp2;
    var inputValueTmp3;
    search1 = dc.textFilterWidget('#demo3 .search1', groupname);
    search2 = dc.textFilterWidget('#demo3 .search2', groupname);
    search3 = dc.textFilterWidget('#demo3 .search3', groupname);
		map = dc_leaflet.markerChart("#demo3 .map",groupname);
		year = dc.pieChart("#demo3 .year", groupname);
    visCount = dc.dataCount(".dc-data-count", groupname);
    visTable = dc.dataTable(".dc-data-table", groupname);


		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function() {
      if (this.readyState == 0 || this.readyState == 1 || this.readyState == 2 || this.readyState == 3) {
        $('#holder').hide();
        $('.spinner').show();
      }
			if (this.readyState == 4 && this.status == 200) {
        $('#holder').show();
        $('.spinner').hide();
				geojsonVariable = JSON.parse(this.responseText);
				bikePointCount = geojsonVariable["features"]["length"];
        var geo;
        var yearInstallation;
        var desc;
        var street1;
        var street2;
				for(var i=0; i<bikePointCount; i++) {
					geo = geojsonVariable["features"][i]["geometry"]["coordinates"][1] + "," + geojsonVariable["features"][i]["geometry"]["coordinates"][0];// unfortunately latitude and longitude of each coordinates are stored reversely!!
          yearInstallation = geojsonVariable["features"][i]["properties"]["install_yr"];
          desc = geojsonVariable["features"][i]["properties"]["descript"];
          street1 = geojsonVariable["features"][i]["properties"]["street1"];
          street2 = geojsonVariable["features"][i]["properties"]["street2"];
					dataP.push({'geo': geo,
                      'Year': yearInstallation,
                      'Desc': desc,
                      'Street 1': street1,
                      'Street 2': street2
                    });
				}
				var xf = crossfilter(dataP);
        var all = xf.groupAll();

        var descDim = xf.dimension(function(d) {
          if(d['Desc'] !== null) {
            return d['Desc'].toLowerCase();
          }
          else {
            return "No Desc Stored";
          }
        });

        var street1Dim = xf.dimension(function(d) {
          if(d['Street 1'] !== null) {
            return d['Street 1'].toLowerCase();
          }
          else {
            return "No Street 1 Stored";
          }
        });

        var street2Dim = xf.dimension(function(d) {
          if(d['Street 2'] !== null) {
            return d['Street 2'].toLowerCase();
          }
          else {
            return "No Street 2 Stored";
          }
        });

        search1
          .dimension(descDim)
          .placeHolder('Name')


        search2
          .dimension(street1Dim)
          .placeHolder('Street 1');

        search3
          .dimension(street2Dim)
          .placeHolder('Street 2');


				var facilities = xf.dimension(function(d) {
					return d['geo'];
				});
				var facilitiesGroup = facilities.group().reduceCount();

				map
					.dimension(facilities)
					.group(facilitiesGroup)
					.width(600)
					.height(450)
					.center([37.771179, -122.436955])
					.zoom(12)
					.cluster(true)
					.filterByArea(true)
					.renderPopup(true)
					.popup(function(d, map) {
						return dataP[functiontofindIndexByKeyValue(dataP, "geo", d.key)]["Desc"] + " " + d.key;
					});
		var maptmpcount =0;
        map.on('filtered', function(chart, filter) {
          if(maptmpcount == 0) {
			alert("It may be irreversible!");
			maptmpcount++;
		  }
        });

				var yearInstallationDim = xf.dimension(function(d) {
					return d['Year'];
				});
				var yearInstallationGroup = yearInstallationDim.group().reduceCount();

        year
					.dimension(yearInstallationDim)
					.group(yearInstallationGroup)
					.width(600)
					.height(400)
					.renderLabel(true)
					.renderTitle(true)
					.title(function(d) {
						return d.key;
					})
					.ordinalColors(["#c1bcf9", "#000000", "#ffdb00", "#3b4274", "#44d9e6", "#ff63b1", "#ac8e9a", "#880000", "#ccac00", "#01a1ff", "#7927cb", "#fe9ee9", "#e3c1a4", "#f7f7f7", "#66023c", "#a67c00"])
					.colorDomain([
						d3.min(yearInstallationGroup.all(), dc.pluck('value')),
						d3.max(yearInstallationGroup.all(), dc.pluck('value'))
					])
					.colorAccessor(function(d,i) {
						return d.value;
					})
					.legend(dc.legend())
          .label(function (d) {
            if(sliceTooSmall(d.value)) {
							return '';
						}
    				if (year.hasFilter() && !year.hasFilter(d.key)) {
    					return d.key + '(0%)';
    				}
    				var label = d.key;
    				if (all.value()) {
    					label += '(' + Math.floor(d.value / all.value() * 100) + '%)';
    				}
    				return label;
    			})
					.minAngleForLabel(0)
					.innerRadius(10)
					.externalRadiusPadding(60)
					.externalLabels(40);

        year.on('filtered', function(chart, filter) {
			if(undoFlag === false) {
            actionFunction(chart, filter, false);
          }
        });

        var yearInstallationDim1 = xf.dimension(function(d) {
					return d['year'];
				});

        var i = 0;
        dc.dataTable('.dc-data-grid')
          .dimension(yearInstallationDim1)
          .group(function (d) {
            return '';
          })
          .size(20)
          .columns([
            function (d) {
              i = i + 1;
              return i;
            },
            function (d) {
              return d['Desc'];
            }, function (d) {
              return d['Street 1'];
            }, function (d) {
              return d['Street 2'];
            }, function (d) {
              return d['Year'];
            }])
            .on('renderlet', function (c) {
              i = 0;
            });

        visCount
       			.dimension(xf)
       			.group(xf.groupAll());

         var yearInstallationDim2 = xf.dimension(function(d) {
 					     return d['year'];
   				});

         visTable
       			.dimension(yearInstallationDim2)
       			.group(function (d) { return '' })
       			.size(50)
       			.columns([
       				 "Desc",
               "Street 1",
               "Street 2",
               "Year"
       			])
       			.order(d3.ascending)
       			// (_optional_) custom renderlet to post-process chart using [D3](http://d3js.org)
       			.on('renderlet', function (table) {
       				table.selectAll('.dc-data-table').classed('info', true);
       			});

				 dc.renderAll(groupname);

        $("#undoButton").attr("disabled", "disabled");
        $(".searchTable").hide();

        $(document).on("blur","input",function(e){
          if(inputAlert===0) {
            alert("For ignoring this item, you should remove data from the input.\nAlso, undo queue does not take this kind of filtering into account!");
          }
          inputAlert++;
          inputValueTmp1 = $('.search1 .dc-text-filter-input').val();
          inputValueTmp2 = $('.search2 .dc-text-filter-input').val();
          inputValueTmp3 = $('.search3 .dc-text-filter-input').val();
          dc.renderAll(groupname);
        });
        $(document).on("focus","input",function(e){
          $('.search1 .dc-text-filter-input').val(inputValueTmp1);
          $('.search2 .dc-text-filter-input').val(inputValueTmp2);
          $('.search3 .dc-text-filter-input').val(inputValueTmp3);
          $(".searchTable").show();
        });
	    }
	  };
	  xhttp.open("GET", "connection.php", true);
	  xhttp.send();


    function hideTableSearchFunction() {
      $(".searchTable").hide();
    }

    function functiontofindIndexByKeyValue(arraytosearch, key, valuetosearch) {
			for (var i = 0; i < arraytosearch.length; i++) {
				if (arraytosearch[i][key] == valuetosearch) {
					return i;
				}
			}
			return null;
		}


    var action = 0;
    var undoFlag = false;
    var selectedChart = [];
    function actionFunction(chart, slice, resetFlag) {
      selectedChart.push({chart, slice, resetFlag});
      $("#undoButton").removeAttr("disabled");
      action++;
    }

    function reloadFunction() {
      location.reload();
    }

    function undoFunction() {
      selectedChartLength = selectedChart.length;
      if(selectedChartLength>0 || action !=0) {
        var tmpChart = selectedChart[selectedChartLength-1]["chart"];
        var tmpSlice = selectedChart[selectedChartLength-1]["slice"];
        var tmpResetFlag = selectedChart[selectedChartLength-1]["resetFlag"];
        undoFlag = true;
        if(tmpResetFlag == false) {
          tmpChart.filter(tmpSlice);
        }
        else {
          tmpChart.filterAll();
          tmpChart.filter(tmpSlice);
          action--;
        }
        undoFlag = false;
        action--;
        dc.renderAll(groupname);
        selectedChart.pop();
        if(action === 0) {
          $("#undoButton").attr("disabled", "disabled");
        }
      }

    }

    function resetAll() {
      undoFlag = true;
      search1.filterAll();
      search2.filterAll();
      search3.filterAll();
	  map.filterAll();
	  year.filterAll();
      dc.renderAll(groupname);
	  undoFlag = false;
      action = 0;
      selectedChart.length = 0;
    }

    function chartReset(chart) {
      if(chart.filters().length > 1) {
        alert("It seems the number of filters for this chart is more than one. Hence the stack for undo function will be empty.");
        chart.filter(null);
        action = 0;
        dc.renderAll(groupname);
        selectedChart.length = 0;
      }
      else {
        if(undoFlag === false) {
          var sel = chart.filterPrinter()(chart.filters());
          actionFunction(chart, sel, true);
        }
        chart.filterAll();
        selectedChart.pop();
        dc.redrawAll(groupname)
      }
    }
    function sliceTooSmall(d) {
			if(d < 10) {
				return true;
			}
			return false;
		}



	</script>
</body>
</html>
