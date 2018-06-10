<?php
session_start();
$url = "../../user/index.php";
if (isset($_GET['csv'])) {
	$_SESSION['file'] = "MonthlyUtilityConsumption.csv";
	ob_start();
    header('Location: '.$url);
    ob_end_flush();
    die();
}
?>
<html>
<head>
<link rel="icon" href="../../files/favicon.png">
  <title>Monthly Utility Consumption</title>
  <meta http-equiv="content-type" content="text/html; charset=UTF8">
  <!--<link rel="stylesheet" href="../../css/all.css">
  <link type="text/css" href="../../css/dc.css" rel="stylesheet"/>
  <link type="text/css" href="../../css/monthlyUtilityConsumption.css" rel="stylesheet"/>
  <link rel="stylesheet" href="../../css/spinner.css" rel="stylesheet">
  <link rel="stylesheet" href="../../css/bootstrap.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Acme|Fira+Sans+Condensed|Fjalla+One" rel="stylesheet">-->
  
  <link rel="stylesheet" href="../../css/all.css">
  <link type="text/css" href="../../css/dc.min.css" rel="stylesheet"/>
  <link type="text/css" href="../../css/monthlyUtilityConsumption.css" rel="stylesheet"/>
  <link rel="stylesheet" href="../../css/spinner.css" rel="stylesheet">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css?family=Acme|Fira+Sans+Condensed|Fjalla+One" rel="stylesheet">
  
  
</head>
<body>
  <div class="spinner"></div>
  <div id="holder" style="display: none;">
  <div id="gettingFiles">
		<a href='index.php?csv=true'>Get CSV</a>
	</div>
  <header> 
	<div id="menu">
		<a href="../">Home</a><br />
		<a href="../../user">User</a><br />
		<a href="../">OpenData</a><br />
		<a href="../search">Search</a>
	</div>
</header> 
    <button id="undoButton" onclick="undoFunction()" title="Undo"></button><br>
    <button id="reloadButton" onclick="reloadFunction()" title="Reload this page">Reload</button><br>
  	<h2>Monthly Utility Consumption</h2>
    <div id="demo1">
      <div class="year">
        <strong>Year</strong>
        <span class="reset" style="display: none;">Selected: <span class="filter"></span></span>
        <a class="reset" href="javascript:chartReset(yearChart);" style="display: none;">reset</a>
        <div class="clearfix"></div>
      </div>
      <div class="month">
        <strong>Month</strong>
        <span class="reset" style="display: none;">Selected: <span class="filter"></span></span>
        <a class="reset" href="javascript:chartReset(monthChart);" style="display: none;">reset</a>
        <div class="clearfix"></div>
      </div>
      <div class="utility">
        <strong>Utility</strong>
        <span class="reset" style="display: none;">Selected: <span class="filter"></span></span>
        <a class="reset" href="javascript:chartReset(utilityChart);" style="display: none;">reset</a>
        <div class="clearfix"></div>
      </div>
      <div class="break"></div>
      <div class="owner">
        <strong>Owner</strong>
        <span class="reset" style="display: none;">Selected: <span class="filter"></span></span>
        <a class="reset" href="javascript:chartReset(ownerChart);" style="display: none;">reset</a>
        <div class="clearfix"></div>
      </div>
      <div class="units">
        <strong>Units</strong>
        <span class="reset" style="display: none;">Selected: <span class="filter"></span></span>
        <a class="reset" href="javascript:chartReset(unitsChart);" style="display: none;">reset</a>
        <div class="clearfix"></div>
      </div>
      <div class="break"></div>
      <div class="usage">
        <strong>Whole Usage: </strong>
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
  <script type="text/javascript" src="../../js/colorbrewer.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script type="text/javascript" src="../../js/bootstrap.js"></script>-->
  
  <script type="text/javascript" src="../../js/d3.min.js"></script>
  <script type="text/javascript" src="../../js/crossfilter.min.js"></script>
  <script type="text/javascript" src="../../js/dc.min.js"></script>
  <script type="text/javascript" src="../../js/colorbrewer.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" ></script>



	<script type="text/javascript">
		var jsonVariable;
		var jsonVariableLength;
		dataP = [];
    var groupname = "group";
		yearChart = dc.pieChart("#demo1 .year", groupname);
    monthChart = dc.rowChart("#demo1 .month", groupname);
    utilityChart = dc.barChart("#demo1 .utility", groupname);
    ownerChart = dc.pieChart("#demo1 .owner", groupname);
    unitsChart = dc.barChart("#demo1 .units", groupname);
    usageNumberDisplay = dc.numberDisplay("#demo1 .usage", groupname)
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
				jsonVariable = JSON.parse(this.responseText);
				jsonVariableLength = Object.keys(jsonVariable).length - 2;// (excluding _id, _rev)
				for(var i=0; i<jsonVariableLength; i++) {
					dataP.push(jsonVariable[i]);
				}
				var xf = crossfilter(dataP);
        var all = xf.groupAll();


				var yearDim = xf.dimension(function(d) {
					return d['Year'];
				});
				var yearGroup = yearDim.group().reduceCount();

				yearChart
					.dimension(yearDim)
					.group(yearGroup)
					.width(400)
					.height(350)
					.renderLabel(true)
					.renderTitle(true)
					.legend(dc.legend())
					.innerRadius(7)
          .label(function (d) {
    				if (yearChart.hasFilter() && !yearChart.hasFilter(d.key)) {
    					return d.key + '(0%)';
    				}
    				var label = d.key;
    				if (all.value()) {
    					label += '(' + Math.floor(d.value / all.value() * 100) + '%)';
    				}
    				return label;
    			});

        yearChart.on('filtered', function(chart, filter) {
          if(undoFlag === false) {
            actionFunction(chart, filter, false);
          }
          });

        var monthDim = xf.dimension(function(d) {
					return d['Month'];
				});
				var monthGroup = monthDim.group().reduceCount();

        monthChart
          .margins({top: 20, left: 10, right: 10, bottom: 20})
          .width(400)
          .height(350)
          .dimension(monthDim)
          .group(monthGroup)
          .label(function (d) {
            return d.key;
          })
          .title(function (d) {
            return d.key + ": " + d.value;
          })
          .elasticX(true)
          .xAxis()
          .ticks(4);

        monthChart.on('filtered', function(chart, filter) {
          if(undoFlag === false) {
            actionFunction(chart, filter, false);
          }
          });


        var utilityDim = xf.dimension(function(d) {
					return d['Utility'];
				});
        var utilityGroup = utilityDim.group().reduceCount();
        var nonEmptyUtilitiy = remove_empty_bins(utilityGroup);

        utilityChart
          .margins({top: 20, left: 150, right: 10, bottom: 20})
          .width(550)
          .height(350)
          .x(d3.scaleBand())
          .xUnits(dc.units.ordinal)
          .dimension(utilityDim)
          .group(nonEmptyUtilitiy)
          .brushOn(true)
          //.yAxisLabel('Count')
          .elasticX(true)
          .elasticY(true);

        utilityChart.on('filtered', function(chart, filter) {
          if(undoFlag === false) {
            actionFunction(chart, filter, false);
          }
          });

        var ownerDim = xf.dimension(function(d) {
					return d['Owner'];
				});
				var ownerGroup = ownerDim.group().reduceCount();

				ownerChart
					.dimension(ownerDim)
					.group(ownerGroup)
					.width(400)
					.height(300)
					.renderLabel(true)
					.renderTitle(true)
					.legend(dc.legend())
					.innerRadius(7)
          .label(function (d) {
    				if (ownerChart.hasFilter() && !ownerChart.hasFilter(d.key)) {
    					return d.key + '(0%)';
    				}
    				var label = d.key;
    				if (all.value()) {
    					label += '(' + Math.floor(d.value / all.value() * 100) + '%)';
    				}
    				return label;
    			});

        ownerChart.on('filtered', function(chart, filter) {
          if(undoFlag === false) {
            actionFunction(chart, filter, false);
          }
          });

        var unitsDim = xf.dimension(function(d) {
					return d['Units'];
				});
        var unitsGroup = unitsDim.group().reduceCount();
        var nonEmptyUnits = remove_empty_bins(unitsGroup);

        unitsChart
          .margins({top: 20, left: 150, right: 10, bottom: 20})
          .width(700)
          .height(300)
          .x(d3.scaleBand())
          .xUnits(dc.units.ordinal)
          .dimension(unitsDim)
          .group(nonEmptyUnits)
          .brushOn(true)
          //.yAxisLabel('Count')
          .elasticX(true)
          .elasticY(true);

        unitsChart.on('filtered', function(chart, filter) {
          if(undoFlag === false) {
            actionFunction(chart, filter, false);
          }
          });


        var usageDim = xf.dimension(function(d) {
					return d['Usage'];
				});

        var usageGroup = usageDim.group().reduceSum(function(d) {
          return +d['Usage'];
        });

        usageNumberDisplay
          .valueAccessor(function(d) {
            return +d.key;
          })
          .group(usageGroup)



        visCount
    			.dimension(xf)
    			.group(all);

        var yearDim1 = xf.dimension(function(d) {
					return d['Year'];
				});

        visTable
    			.dimension(yearDim1)
    			.group(function (d) { return '' })
    			.size(50)
    			.columns([
    				"Year",
    				"Month Number",
    				"Month",
    				"Utility",
    				"Owner",
    				"Units",
    				"Usage"
    			])
    			.order(d3.ascending)
    			// (_optional_) custom renderlet to post-process chart using [D3](http://d3js.org)
    			.on('renderlet', function (table) {
    				table.selectAll('.dc-data-table').classed('info', true);
    			});

				dc.renderAll(groupname);

        $("#undoButton").attr("disabled", "disabled");

	    }
	  };
	  xhttp.open("GET", "connection.php", true);
	  xhttp.send();


    function remove_empty_bins(source_group) {
      return {
        all:function () {
          return source_group.all().filter(function(d) {
            return d.value != 0;
          });
        }
      };
    }

    function sel_stack(i) {
      return function(d) {
        return d.value[i];
      };
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
      yearChart.filterAll();
      monthChart.filterAll();
      utilityChart.filterAll();
      ownerChart.filterAll();
      unitsChart.filterAll();
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
