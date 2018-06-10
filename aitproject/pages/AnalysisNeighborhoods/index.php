<?php
session_start();
$url = "../../user/index.php";
if (isset($_GET['csv'])) {
	$_SESSION['file'] = "AnalysisNeighborhoods.csv";
	ob_start();
    header('Location: '.$url);
    ob_end_flush();
    die();
} else if (isset($_GET['json'])) {
	$_SESSION['file'] = "AnalysisNeighborhoods.json";
	ob_start();
    header('Location: '.$url);
    ob_end_flush();
    die();
} else if (isset($_GET['kml'])) {
	$_SESSION['file'] = "AnalysisNeighborhoods.kml";
	ob_start();
    header('Location: '.$url);
    ob_end_flush();
    die();
} else if (isset($_GET['kmz'])) {
	$_SESSION['file'] = "AnalysisNeighborhoods.kmz";
	ob_start();
    header('Location: '.$url);
    ob_end_flush();
    die();
} else if (isset($_GET['zip'])) {
	$_SESSION['file'] = "AnalysisNeighborhoods.zip";
	ob_start();
    header('Location: '.$url);
    ob_end_flush();
    die();
}
?>

<html>
<head>
  <link rel="icon" href="../../files/favicon.png">
  <title>Analysis of Neighborhoods</title>
  <meta http-equiv="content-type" content="text/html; charset=UTF8">
  <!--<link type="text/css" href="../../css/leaflet.css" rel="stylesheet"/>
  <link type="text/css" href="../../css/MarkerCluster.Default.css" rel="stylesheet"/>
  <link type="text/css" href="../../css/MarkerCluster.css" rel="stylesheet"/>
  <link type="text/css" href="../../css/dc.css" rel="stylesheet"/>
  <link type="text/css" href="../../css/leaflet-legend.css" rel="stylesheet"/>
  <link type="text/css" href="../../css/analysisNeighborhoodsStyle.css" rel="stylesheet"/>
  <link rel="stylesheet" href="../../css/spinner.css" rel="stylesheet">
  <link rel="stylesheet" href="../../css/bootstrap.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Acme|Fira+Sans+Condensed|Fjalla+One" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="../../css/all.css">-->
  
  <link type="text/css" href="../../css/leaflet.css" rel="stylesheet"/>
  <link type="text/css" href="../../css/MarkerCluster.Default.css" rel="stylesheet"/>
  <link type="text/css" href="../../css/MarkerCluster.css" rel="stylesheet"/>
  <link type="text/css" href="../../css/dc.min.css" rel="stylesheet"/>
  <link type="text/css" href="../../css/leaflet-legend.css" rel="stylesheet"/>
  <link type="text/css" href="../../css/analysisNeighborhoodsStyle.css" rel="stylesheet"/>
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
    <button id="reloadButton" onclick="reloadFunction()" title="Reload this page">Reload</button>

		<h2>Analysis of Neighborhoods</h2>
	  <div id="demo3">
      <div class="search1"></div>
      <div class="searchTable">
        <table class="table dc-data-grid">
          <thead>
            <tr class="header">
              <th>No</th>
              <th>Neighborhood Name</th>
              <th>Area (Square Meter)</th>
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
      <div class="break"></div>
	    <div class="neighborhood">
  			<strong>Neighborhood:</strong>
  			<span class="reset" style="display: none;">Selected: <span class="filter"></span></span>
  			<a class="reset" href="javascript:chartReset(neighborhood);" style="display: none;">reset</a>
			  <div class="clearfix"></div>
			</div>
      <div class="break"></div>
      <div>
      	<div class="dc-data-count">
      		<span class="filter-count"></span> selected out of <span class="total-count"></span> records | <a
      			href="javascript:resetAll()">Reset All</a>
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
		var neighborhoodsCount;
		var wholeArea;
		dataP = [];
    var inputAlert = 0;
    var inputValueTmp1;
		var groupname = "group";
    search1 = dc.textFilterWidget('#demo3 .search1', groupname);
		map = dc_leaflet.choroplethChart("#demo3 .map", groupname);
		neighborhood = dc.pieChart("#demo3 .neighborhood", groupname);
    visCount = dc.dataCount(".dc-data-count", groupname);
    visTable = dc.dataTable(".dc-data-table", groupname);

	  var xhttp = new XMLHttpRequest();
	  xhttp.onreadystatechange = function() {
      if (this.readyState == 0 || this.readyState == 1 || this.readyState == 2 || this.readyState == 3) {
        $('#holder').hide();
        $('.spinner').show();
      }
	    if (this.readyState == 4 && this.status == 200) {
				$('.spinner').hide();
				$('#holder').show();
	      geojsonVariable = JSON.parse(this.responseText);
				neighborhoodsCount = geojsonVariable["features"]["length"];

				for(var i=0; i<neighborhoodsCount; i++) {
					dataP.push({'nhood': geojsonVariable["features"][i]["properties"]["nhood"], 'area':areaFunction(geojsonVariable["features"][i]["geometry"]["coordinates"])});
				}
				var xf = crossfilter(dataP);
				var all = xf.groupAll();
				var allSum = all.reduceSum(function(d) { return d.area; });
				var wholeArea = parseFloat(allSum.value());

        var nhoodDim0 = xf.dimension(function(d) {
					return d['nhood'];
				});

        search1
          .dimension(nhoodDim0)
          .placeHolder('Neighborhood Name');


        var nhoodDim = xf.dimension(function(d) {
					return d['nhood'];
				});
        var nhoodAreaGroup = nhoodDim.group().reduceSum(function(d) { return d['area']; });

				map
					.dimension(nhoodDim)
					.group(nhoodAreaGroup)
					.width(700)
					.height(400)
					.center([37.771179, -122.436955])
					.zoom(12)
					.geojson(geojsonVariable.features)
					.ordinalColors(["#c1bcf9", "#000000", "#ffdb00", "#3b4274", "#44d9e6", "#ff63b1", "#ac8e9a", "#880000", "#ccac00", "#01a1ff", "#7927cb", "#fe9ee9", "#e3c1a4", "#f7f7f7", "#66023c", "#a67c00"])
					// .colors(colorbrewer.YlGnBu[7])
					.colorDomain([
						d3.min(nhoodAreaGroup.all(), dc.pluck('value')),
						d3.max(nhoodAreaGroup.all(), dc.pluck('value'))
					])
					.colorAccessor(function(d,i) {
						return d.value;
					})
					.featureKeyAccessor(function(feature) {
						return feature.properties.nhood;
					})
					.renderPopup(true)
					.popup(function(d, feature) {
						return feature.properties.nhood+" : "+d.area;
					})
					.title(function(d) {
						return d.key;
					})

        map.on('filtered', function(chart, filter) {
			if(undoFlag === false) {
				if(neighborhood.filters().length>0 && map.filters().length == 1){
				  alert("You have some selected neighborhoods on the pie chart.\nIf you are supposed to select some neighborhoods on map, you also should select the previous ones here.");
				}
				else {
					actionFunction(chart, filter, false);
				}  
          }
          });


        var nhoodDim1 = xf.dimension(function(d) {
					return d['nhood'];
				});
        var nhoodAreaGroup1 = nhoodDim1.group().reduceSum(function(d) { return d['area']; });
        var filtered_group = remove_empty_bins(nhoodAreaGroup1);

				neighborhood
					.dimension(nhoodDim1)
					.group(filtered_group)
					.width(1200)
					.height(700)
					.renderLabel(true)
					.renderTitle(true)
					.title(function(d) {
						return d.key;
					})
					.ordinalColors(["#c1bcf9", "#000000", "#ffdb00", "#3b4274", "#44d9e6", "#ff63b1", "#ac8e9a", "#880000", "#ccac00", "#01a1ff", "#7927cb", "#fe9ee9", "#e3c1a4", "#f7f7f7", "#66023c", "#a67c00"])
					.colorDomain([
						d3.min(filtered_group.all(), dc.pluck('value')),
						d3.max(filtered_group.all(), dc.pluck('value'))
					])
					.colorAccessor(function(d,i) {
						return d.value;
					})
					.legend(dc.legend())
          .label(function (d) {
            if(sliceTooSmall(d.value)) {
							return '';
						}
    				if (neighborhood.hasFilter() && !neighborhood.hasFilter(d.key)) {
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

        neighborhood.on('filtered', function(chart, filter) {
          if(undoFlag === false) {
            actionFunction(chart, filter, false);
          }
        });

        var nhoodDim2 = xf.dimension(function(d) {
					return d['nhood'];
				});

        var i = 0;
        dc.dataTable('.dc-data-grid')
          .dimension(nhoodDim2)
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
              return d['nhood'];
            }, function (d) {
              return Math.floor(d['area']);
            }])
            .on('renderlet', function (c) {
              i = 0;
            });


        visCount
    			.dimension(xf)
    			.group(xf.groupAll());

        var nhoodDim3 = xf.dimension(function(d) {
					return d['nhood'];
				});

        visTable
    			.dimension(nhoodDim3)
    			.group(function (d) { return '' })
    			.size(50)
    			.columns([
    				"nhood",
            "area"
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
            dc.renderAll(groupname);
          });
          $(document).on("focus","input",function(e){
            $('.search1 .dc-text-filter-input').val(inputValueTmp1);
            $(".searchTable").show();
          });
	    }
	  };
	  xhttp.open("GET", "connection.php", true);
	  xhttp.send();

    function remove_empty_bins(source_group) {
      return {
          all:function () {
              return source_group.all().filter(function(d) {
                  //return Math.abs(d.value) > 0.00001; // if using floating-point numbers
                  return d.value !== 0; // if integers only
              });
          }
      };
  }

		function areaFunction(data) {
			var arraysN = data["length"];
			var area = 0;
			for(var x=0; x<arraysN; x++)
			{
				var sizeofArray = data[x][0]["length"];
				for(var i=0; i<sizeofArray-1; i++)
				{
					var amount1 = data[x][0][i];
					var amount2 = data[x][0][i+1];
					var tmp0 = converttoRadian(amount2[1]-amount1[1]);
					var tmp1 = (2+Math.sin(converttoRadian(amount1[0]))+Math.sin(converttoRadian(amount2[0])));
					var tmp2 = tmp0*tmp1;
					area += tmp2;
				}
			}
			area = area * 6378137 * 6378137 / 2;
			return Math.abs(area);
		}

		function converttoRadian(value) {
			return value * Math.PI / 180;
		}

		function sliceHasNoData (d) {
      return pie.cappedValueAccessor(d) === 0;
    }

		function sliceTooSmall(d) {
			if(d < 880000) {
				return true;
			}
			return false;
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
      search1.filterAll();
	  map.filterAll();
	  neighborhood.filterAll();
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
