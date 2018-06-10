<?php
session_start();
$url = "../../user/index.php";
if (isset($_GET['csv'])) {
	$_SESSION['file'] = "SpeedLimits.csv";
	ob_start();
    header('Location: '.$url);
    ob_end_flush();
    die();
} else if (isset($_GET['geojson'])) {
	$_SESSION['file'] = "SpeedLimits.geojson";
	ob_start();
    header('Location: '.$url);
    ob_end_flush();
    die();
} else if (isset($_GET['json'])) {
	$_SESSION['file'] = "SpeedLimits.json";
	ob_start();
    header('Location: '.$url);
    ob_end_flush();
    die();
} else if (isset($_GET['kml'])) {
	$_SESSION['file'] = "SpeedLimits.kml";
	ob_start();
    header('Location: '.$url);
    ob_end_flush();
    die();
} else if (isset($_GET['kmz'])) {
	$_SESSION['file'] = "SpeedLimits.kmz";
	ob_start();
    header('Location: '.$url);
    ob_end_flush();
    die();
} else if (isset($_GET['zip'])) {
	$_SESSION['file'] = "SpeedLimits.zip";
	ob_start();
    header('Location: '.$url);
    ob_end_flush();
    die();
}
?>
<html>
<head>
  <link rel="icon" href="../../files/favicon.png">
  <title>Speed Limits</title>
  <meta http-equiv="content-type" content="text/html; charset=UTF8">
 

  <!--<link rel="stylesheet" href="../../css/all.css">
  <link type="text/css" href="../../css/dc.css" rel="stylesheet"/>
  <link rel="stylesheet" href="../../css/bootstrap.css" rel="stylesheet">
  <link rel="stylesheet" href="../../css/spinner.css" rel="stylesheet">
  <link rel="stylesheet" href="../../css/leaflet.css" rel="stylesheet">
  <link type="text/css" href="../../css/speedLimitsStyle.css" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css?family=Acme|Fira+Sans+Condensed|Fjalla+One" rel="stylesheet">-->
  
  
  <link rel="stylesheet" href="../../css/all.css">
  <link type="text/css" href="../../css/dc.min.css" rel="stylesheet"/>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" >
  <link rel="stylesheet" href="../../css/spinner.css" rel="stylesheet">
  <link rel="stylesheet" href="../../css/leaflet.min.css" rel="stylesheet">
  <link type="text/css" href="../../css/speedLimitsStyle.css" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css?family=Acme|Fira+Sans+Condensed|Fjalla+One" rel="stylesheet">
  
</head>
<body>
  <div class="spinner"></div>
  <div id="holder" style="display: none;">
  <div id="gettingFiles">
		<a href='index.php?csv=true'>Get CSV</a>
		<a href='index.php?geojson=true'>Get GEOJSON</a>
		<a href='index.php?json=true'>GET JSON</a>
		<a href='index.php?kml=true'>Get KML</a>
		<a href='index.php?kmz=true'>Get KMZ</a>
		<a href='index.php?zip=true'>Get ZIP</a>
	</div>
  <header> 
	<div id="menu">
		<a href="../">Home</a><br />
		<a href="../../user">User</a><br />
		<a href="../">OpenData</a><br />
		<a href="../search">Search</a>
	</div>
</header> 
    <button id="undoButton" onclick="undoFunction()"></button><br>
    <button id="reloadButton" onclick="reloadFunction()" title="Reload this page">Reload</button><br>
		<h2>Speed Limits</h2>
		<div id="demo1">
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
              <th>Street Name</th>
              <th>Street Type</th>
              <th>Street Length</th>
              <th>Speed Limit</th>
              <th>School Zone</th>
              <th>From Street</th>
              <th>To Street</th>
            </tr>
          </thead>
        </table>
        <button id="hideTableSearch" onclick="hideTableSearchFunction()">Hide it</button>
      </div>
      <div class="break"></div>
      <div id="map"></div>
      <div class="bubble">
        <strong>Length, Speed Limit:</strong>
        <span class="reset" style="display: none;">Selected: <span class="filter"></span></span>
        <a class="reset" href="javascript:chartReset(bubble);" style="display: none;">reset</a>
        <div class="clearfix"></div>
      </div>
      <div class="type">
        <strong>Type:</strong>
        <span class="reset" style="display: none;">Selected: <span class="filter"></span></span>
        <a class="reset" href="javascript:chartReset(type);" style="display: none;">reset</a>
        <div class="clearfix"></div>
      </div>
      <div class="school">
        <strong>School Zone:</strong>
        <span class="reset" style="display: none;">Selected: <span class="filter"></span></span>
        <a class="reset" href="javascript:chartReset(school);" style="display: none;">reset</a>
        <div class="clearfix"></div>
      </div>
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
  <script type="text/javascript" src="../../js/colorbrewer.js"></script>
  <script type="text/javascript" src="../../js/lysenko-interval-tree.js"></script>
  <script src="../../js/leaflet.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script type="text/javascript" src="../../js/bootstrap.js"></script>-->
  
  
  <script type="text/javascript" src="../../js/d3.min.js"></script>
  <script type="text/javascript" src="../../js/crossfilter.min.js"></script>
  <script type="text/javascript" src="../../js/dc.min.js"></script>
  <script type="text/javascript" src="../../js/colorbrewer.js"></script>
  <script type="text/javascript" src="../../js/lysenko-interval-tree.min.js"></script>
  <script src="../../js/leaflet.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" ></script>



	<script type="text/javascript">
		var geojsonVariable;
		var geojsonVariableLength;
		dataP = [];
    // var arrayA = [];
    // var arrayA1 = [];
    // var arrayB = [];
    // var arrayC;
    // var myObject;
    var groupname = "group";
    var inputAlert = 0;
    var showMapAlert = 0;
    var inputValueTmp1;
    var inputValueTmp2;
    var inputValueTmp3;
    search1 = dc.textFilterWidget('#demo1 .search1', groupname);
    search2 = dc.textFilterWidget('#demo1 .search2', groupname);
    search3 = dc.textFilterWidget('#demo1 .search3', groupname);
    bubble = dc.bubbleChart('#demo1 .bubble', groupname);
    type = dc.pieChart('#demo1 .type', groupname);
    school = dc.rowChart('#demo1 .school', groupname);
    visCount = dc.dataCount(".dc-data-count", groupname);
    visTable = dc.dataTable(".dc-data-table", groupname);
    map = L.map('map').setView([37.771179, -122.436955], 12);
    mapLink = '<a href="http://openstreetmap.org">OpenStreetMap</a>';
    L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '&copy; ' + mapLink + ' Contributors',
      maxZoom: 18,
    }).addTo(map);
    // L.Map.include({
    //   'clearLayers': function () {
    //     this.eachLayer(function (layer) {
    //       this.removeLayer(layer);
    //     }, this);
    //   }
    // });

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
				geojsonVariableLength = geojsonVariable["features"]["length"];
        var streetName;
        var streetType;
        var streetLength;
        var speedLimit;
        var schoolZone;
        var fromStreet;
        var toStreet;
				for(var i=0; i<geojsonVariableLength; i++) {
          var line = [];
          streetName = geojsonVariable["features"][i]["properties"]["street"];
          streetType = geojsonVariable["features"][i]["properties"]["st_type"];
          if(streetType === null) {
            streetType = "No Type";
          }
          streetLength = Math.floor(geojsonVariable["features"][i]["properties"]["shape_len"]);
          speedLimit = geojsonVariable["features"][i]["properties"]["speedlimit"];
          schoolZone = geojsonVariable["features"][i]["properties"]["schoolzone"];
          if(schoolZone === null) {
            schoolZone = "No";
          }
          else {
            schoolZone = "Yes";
          }
          fromStreet = geojsonVariable["features"][i]["properties"]["from_st"];
          toStreet = geojsonVariable["features"][i]["properties"]["to_st"];
          var geometryL = geojsonVariable["features"][i]["geometry"]["coordinates"][0]["length"];
          for(var j=0; j<geometryL; j++) {
            line.push(geojsonVariable["features"][i]["geometry"]["coordinates"][0][j]);
          }
          // for(var j=geometryL-1; j>-1; j--) {
          //   polygon.push(geojsonVariable["features"][i]["geometry"]["coordinates"][0][j]);
          // }
					dataP.push({
            'Street Name': streetName,
            'Street Type': streetType,
            'Street Length': streetLength,
            'Speed Limit': speedLimit,
            'School Zone': schoolZone,
            'From Street': fromStreet,
            'To Street': toStreet
				  });
          // arrayA.push({'type': "LineString",'coordinates': line});
          // arrayA1.push({'StreetName': streetName});
        }
        // for(var i=0; i< arrayA.length; i++) {
        //   arrayB.push({
        //     'type': "Feature",
        //     'properties': arrayA1[i],
        //     'geometry': arrayA[i]
        //   });
        // }
        // arrayC = {
        //     'features': arrayB
        // };
				var xf = crossfilter(dataP);
        var all = xf.groupAll();

        var streetDim = xf.dimension(function(d) {
          if(d['Street Name'] !== null) {
            return d['Street Name'].toLowerCase();
          }
          else {
            return "No Name Stored";
          }
        });
        var streetGroup = streetDim.group().reduceCount();

        var fromStreetDim = xf.dimension(function(d) {
          if(d['From Street'] !== null) {
            return d['From Street'].toLowerCase();
          }
          else {
            return "No Name Stored";
          }
        });

        var toStreetDim = xf.dimension(function(d) {
          if(d['To Street'] !== null) {
            return d['To Street'].toLowerCase();
          }
          else {
            return "No Name Stored";
          }
        });

        search1
          .dimension(streetDim)
          .placeHolder('Street Name')


        search2
          .dimension(fromStreetDim)
          .placeHolder('From Street ...');

        search3
          .dimension(toStreetDim)
          .placeHolder('To Street ...');




          // .normalize(function (s) {
          //   return s.toLowerCase();
          // })
          // .placeHolder('type to filter');


        var bubbleDim = xf.dimension(function(d) {
          return [d['School Zone'], d['Street Length']/100, d['Speed Limit']];
        });
        var bubbleGroup = bubbleDim.group().reduceCount();




        bubble
          .width(1000)
          .height(400)
          .margins({top: 10, right: 50, bottom: 30, left: 60})
          .dimension(bubbleDim)
          .group(bubbleGroup)
          // .ordinalColors(["#c1bcf9", "#000000", "#ffdb00", "#3b4274", "#44d9e6", "#ff63b1", "#ac8e9a", "#880000", "#ccac00", "#01a1ff", "#7927cb", "#fe9ee9", "#e3c1a4", "#f7f7f7", "#66023c", "#a67c00"])
					// .colors(colorbrewer.YlGnBu[7])
					// .colorDomain([
					// 	d3.min(bubbleGroup.all(), dc.pluck('value')),
					// 	d3.max(bubbleGroup.all(), dc.pluck('value'))
					// ])
					// .colorAccessor(function(d,i) {
					// 	return d.value;
					// })
          .keyAccessor(function (p) {
            // return p.key[1];
            return (((Math.floor(p.key[2]/10))+1)*10);
          })
          .valueAccessor(function (p) {
            // return p.key[2];
            return (((Math.floor(p.key[1]/10))+1)*10);
          })
          .radiusValueAccessor(function (p) {
            return (Math.floor((p.value / 10)) + 1);
          })
          .x(d3.scaleLinear().domain([-10, 120]))
          .y(d3.scaleLinear().domain([-20, 80]))
          .r(d3.scaleLinear().domain([0, 20]))
          .minRadiusWithLabel(1000)
          .yAxisPadding(100)
          .xAxisPadding(200)
          .maxBubbleRelativeSize(0.07)
          .renderHorizontalGridLines(true)
          .renderVerticalGridLines(true)
          .renderLabel(true)
          .renderTitle(true)
          .title(function (p) {
             return "\n"
             + "School Zone: " + p.key[0] + "\n"
             + "Speed: " + p.key[2] + " \n"
             + "Count: " + p.value;
          })

        bubble.yAxis().tickFormat(function (s) {
          return s + " mile";
        });

        bubble.xAxis().tickFormat(function (s) {
          return s + " mph";
        });

        bubble.on('filtered', function(chart, filter) {
          // var sel = chart.filterPrinter()(chart.filters());
          if(undoFlag === false) {
            actionFunction(chart, filter, false);
          }
        });


        var streetDim1 = xf.dimension(function(d) {
          return d['Street Name'];
        });
        var streetGroup1 = streetDim1.group().reduceSum(function(d) {
          return d['Street Length'];
        });



        var typeDim = xf.dimension(function(d) {
          return d['Street Type'];
        });
        var typeGroup = typeDim.group().reduceCount();

        type
					.dimension(typeDim)
					.group(typeGroup)
					// .width(400)
					// .height(300)
					.renderLabel(true)
					.renderTitle(true)
					.legend(dc.legend())
					.innerRadius(7)
          .label(function (d) {
    				if (type.hasFilter() && !type.hasFilter(d.key)) {
    					return d.key + '(0%)';
    				}
    				var label = d.key;
    				if (all.value()) {
    					label += '(' + Math.floor(d.value / all.value() * 100) + '%)';
    				}
    				return label;
    			})

          type.on('filtered', function(chart, filter) {
            // var sel = chart.filterPrinter()(chart.filters());
            if(undoFlag === false) {
              actionFunction(chart, filter, false);
            }
          });



          var schoolZoneDim = xf.dimension(function(d) {
  					return d['School Zone'];
  				});
  				var schoolZoneGroup = schoolZoneDim.group().reduceCount();

          school
            .margins({top: 20, left: 10, right: 10, bottom: 20})
            // .width(500)
            // .height(200)
            .dimension(schoolZoneDim)
            .group(schoolZoneGroup)
            .label(function (d) {
              if(d.value<400) {
                return '';
              }
              else {
                return d.key;
              }
            })
            .title(function (d) {
              return d.key + ": " + d.value;
            })
            .elasticX(true)
            .xAxis()
            .ticks(4)

          school.on('filtered', function(chart, filter) {
            // var sel = chart.filterPrinter()(chart.filters());
            if(undoFlag === false) {
              actionFunction(chart, filter, false);
            }
          });



          var i = 0;
          dc.dataTable('.dc-data-grid')
            .dimension(streetDim)
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
                return d['Street Name'];
              },
              function (d) {
                return d['Street Type'];
              },
              function (d) {
                return d['Street Length'];
              },
              function (d) {
                return d['Speed Limit'];
              },
              function (d) {
                return d['School Zone'];
              },
              function (d) {
                return d['From Street'];
              },
              function (d) {
                return d['To Street'];
              },
              function (d) {

                return "<a href=\"javascript:showStreet(" +
                  functiontofindIndexByKeyValue(dataP, "Street Name", d["Street Name"]) +
                  ")\">Show on Map</a>";
              }])
              .on('renderlet', function (c) {
                i = 0;
              });


          visCount
      			.dimension(xf)
      			.group(all);

          visTable
      			.dimension(streetDim)
      			.group(function (d) { return '' })
      			.size(50)
      			.columns([
      				"Street Name",
              "Street Type",
              "Street Length",
              "Speed Limit",
              "School Zone",
              "From Street",
              "To Street"
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

    function showStreet(no) {
      if(showMapAlert===0) {
        alert("Remember it won't effect on the other charts. the street will be shown just on the map!");
      }
      showMapAlert++;
      var num = Object.keys(map._layers).length;
      if(num>1) {
          clearStreet();
      }
      var points = [];
      var len = geojsonVariable["features"][no]["geometry"]["coordinates"][0]["length"];
      for(var i=0; i<len; i++) {
        points.push(new L.LatLng(geojsonVariable["features"][no]["geometry"]["coordinates"][0][i][1],
          geojsonVariable["features"][no]["geometry"]["coordinates"][0][i][0]));
      }
      var pointsNo = points.length;
      var polyLine = new L.Polyline(points, {
        color: 'red',
        weight: 9,
        opacity: 0.8,
        smoothFactor: 1
      });
      polyLine.addTo(map);
      var centerLat = (points[0].lat + points[pointsNo-1].lat)/2;
      var centerLon = (points[0].lng + points[pointsNo-1].lng)/2;
      var center = new L.LatLng(centerLat, centerLon);
      centerLeafletMapOnMarker(map, center);
    }

    function clearStreet() {
      var z=0;
      for (i in map._layers) {
        if (z!=0) {
          map.removeLayer(map._layers[i]);
        }
        z++;
      }
    }

    function centerLeafletMapOnMarker(map, marker) {
      var latLngs = [ marker ];
      var markerBounds = L.latLngBounds(latLngs);
      map.fitBounds(markerBounds);
      map.setZoom(15);
    }

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
      school.filterAll();
      type.filterAll();
      bubble.filterAll();
	    search1.filterAll();
      search2.filterAll();
      search3.filterAll();
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



	</script>
</body>
</html>
