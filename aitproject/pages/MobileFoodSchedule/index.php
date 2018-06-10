<?php
session_start();
$url = "../../user/index.php";
if (isset($_GET['pdf'])) {
	$_SESSION['file'] = "MobileFoodSchedule.pdf";
	ob_start();
    header('Location: '.$url);
    ob_end_flush();
    die();
} else if (isset($_GET['csv'])) {
	$_SESSION['file'] = "MobileFoodSchedule.csv";
	ob_start();
    header('Location: '.$url);
    ob_end_flush();
    die();
} 
?>
<html>
<head>
  <link rel="icon" href="../../files/favicon.png">
  <title>Mobile Food Schedule</title>
  <meta http-equiv="content-type" content="text/html; charset=UTF8">
  <!--<link rel="stylesheet" href="../../css/all.css">
  <link type="text/css" href="../../css/leaflet.css" rel="stylesheet"/>
  <link type="text/css" href="../../css/MarkerCluster.Default.css" rel="stylesheet"/>
  <link type="text/css" href="../../css/MarkerCluster.css" rel="stylesheet"/>
  <link type="text/css" href="../../css/dc.css" rel="stylesheet"/>
  <link type="text/css" href="../../css/leaflet-legend.css" rel="stylesheet"/>
  <link type="text/css" href="../../css/mobileFoodSchedule.css" rel="stylesheet"/>
  <link rel="stylesheet" href="../../css/spinner.css" rel="stylesheet">
  <link rel="stylesheet" href="../../css/bootstrap.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Acme|Fira+Sans+Condensed|Fjalla+One" rel="stylesheet">-->
  
  <link rel="stylesheet" href="../../css/all.css">
  <link type="text/css" href="../../css/leaflet.css" rel="stylesheet"/>
  <link type="text/css" href="../../css/MarkerCluster.Default.css" rel="stylesheet"/>
  <link type="text/css" href="../../css/MarkerCluster.css" rel="stylesheet"/>
  <link type="text/css" href="../../css/dc.min.css" rel="stylesheet"/>
  <link type="text/css" href="../../css/leaflet-legend.css" rel="stylesheet"/>
  <link type="text/css" href="../../css/mobileFoodSchedule.css" rel="stylesheet"/>
  <link rel="stylesheet" href="../../css/spinner.css" rel="stylesheet">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css?family=Acme|Fira+Sans+Condensed|Fjalla+One" rel="stylesheet">
  
  
  
</head>
<body>
  <div class="spinner"></div>
	<div id="holder" style="display: none;">
	<div id="gettingFiles">
		<a href='index.php?pdf=true'>Get PDF</a>
		<a href='index.php?csv=true'>GET CSV</a>
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
		<h2>Mobile Food Schedule</h2>
		<div id="demo1">
      <div class="searchHolder">
        <div class="search1"></div>
        <div class="search2"></div>
        <div class="search3"></div>
        <div class="search4"></div>
        <div class="search5"></div>
      </div>
      <div class="searchTable">
        <table class="table dc-data-grid">
          <thead>
            <tr class="header">
              <th>No</th>
              <th>Permit Holder</th>
              <th>Food Items</th>
              <th>Address</th>
              <th>Description</th>
              <th>Day</th>
              <th>Start Time</th>
              <th>End Time</th>
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
	    <div class="dayofWeek">
  			<strong>Day of Week: </strong>
  			<span class="reset" style="display: none;">Selected: <span class="filter"></span></span>
  			<a class="reset" href="javascript:chartReset(dayChart);" style="display: none;">reset</a>
  			<div class="clearfix"></div>
			</div>
      <div class="break"></div>
      <div class="time">
  			<strong>Time: </strong>
  			<span class="reset" style="display: none;">Selected: <span class="filter"></span></span>
  			<a class="reset" href="javascript:chartReset(timeChart);" style="display: none;">reset</a>
  			<div class="clearfix"></div>
			</div>
      <div class="break"></div>
      <!-- <div class="time">
        <div class="reset" style="visibility: hidden;">selected: <span class="filter"></span>
          <a href="javascript:chartReset(dayChart);">reset</a>
        </div>
      </div> -->
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
  <script type="text/javascript" src="../../js/bootstrap.js"></script>
  <script type="text/javascript" src="../../js/lysenko-interval-tree.js"></script>-->
  
  <script type="text/javascript" src="../../js/d3.min.js"></script>
  <script type="text/javascript" src="../../js/crossfilter.min.js"></script>
  <script type="text/javascript" src="../../js/dc.min.js"></script>
	<script type="text/javascript" src="../../js/leaflet.js"></script>
	<script type="text/javascript" src="../../js/leaflet.markercluster.js"></script>
	<script type="text/javascript" src="../../js/colorbrewer.js"></script>
	<script type="text/javascript" src="../../js/dc.leaflet.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" ></script>
  <script type="text/javascript" src="../../js/lysenko.min.js"></script>



	<script type="text/javascript">
		var jsonVariable;
		var jsonVariableLength;
		dataP = [];
    var groupname = "group";
    var inputAlert = 0;
    var inputValueTmp1;
    var inputValueTmp2;
    var inputValueTmp3;
    var inputValueTmp4;
    var inputValueTmp5;
    search1 = dc.textFilterWidget('#demo1 .search1', groupname);
    search2 = dc.textFilterWidget('#demo1 .search2', groupname);
    search3 = dc.textFilterWidget('#demo1 .search3', groupname);
    search4 = dc.textFilterWidget('#demo1 .search4', groupname);
    search5 = dc.textFilterWidget('#demo1 .search5', groupname);
		map = dc_leaflet.markerChart("#demo1 .map", groupname);
		timeChart = dc.barChart("#demo1 .time", groupname);
    dayChart = dc.pieChart("#demo1 .dayofWeek", groupname);
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
        var applicanttmp;
        var locationtmp;
        var daytmp;
        var daytmp1;
        var startTimetmp24;
        var endTimetmp24;
        var startTimetmp0;
        var endTimetmp0;
        var startTimetmp;
        var endTimetmp;
        var date1;
        var date2;
        var date1Value;
        var date2Value;

				for(var i=0; i<jsonVariableLength; i++) {
          applicanttmp = jsonVariable[i]["Applicant"];
          locationtmp = jsonVariable[i]["Latitude"] + "," + jsonVariable[i]["Longitude"];
          daytmp = jsonVariable[i]["DayOfWeekStr"].substring(0,3);
          daytmp1 = jsonVariable[i]["DayOfWeekStr"];
          startTimetmp24 = jsonVariable[i]["start24"].substring(0,2);
          endTimetmp24 = jsonVariable[i]["end24"].substring(0,2);
          startTimetmp0 = jsonVariable[i]["start24"];
          endTimetmp0 = jsonVariable[i]["end24"];
          if(daytmp === "Fri") {
            if(endTimetmp24>startTimetmp24) {
              startTimetmp = "Fri Jun 01 2018 " + startTimetmp0 + ":00 GMT+0200 (Romance Daylight Time)";
              endTimetmp = "Fri Jun 01 2018 " + endTimetmp0 + ":00 GMT+0200 (Romance Daylight Time)";
            }
            else {
              startTimetmp = "Fri Jun 01 2018 " + startTimetmp0 + ":00 GMT+0200 (Romance Daylight Time)";
              endTimetmp = "Sat Jun 02 2018 " + endTimetmp0 + ":00 GMT+0200 (Romance Daylight Time)";
            }
          } else if(daytmp === "Sat") {
            if(endTimetmp24>startTimetmp24) {
              startTimetmp = "Sat Jun 02 2018 " + startTimetmp0 + ":00 GMT+0200 (Romance Daylight Time)";
              endTimetmp = "Sat Jun 02 2018 " + endTimetmp0 + ":00 GMT+0200 (Romance Daylight Time)";
            }
            else {
              startTimetmp = "Sat Jun 02 2018 " + startTimetmp0 + ":00 GMT+0200 (Romance Daylight Time)";
              endTimetmp = "Sun Jun 03 2018 " + endTimetmp0 + ":00 GMT+0200 (Romance Daylight Time)";
            }
          } else if(daytmp === "Sun") {
            if(endTimetmp24>startTimetmp24) {
              startTimetmp = "Sun Jun 03 2018 " + startTimetmp0 + ":00 GMT+0200 (Romance Daylight Time)";
              endTimetmp = "Sun Jun 03 2018 " + endTimetmp0 + ":00 GMT+0200 (Romance Daylight Time)";
            }
            else {
              startTimetmp = "Sun Jun 03 2018 " + startTimetmp0 + ":00 GMT+0200 (Romance Daylight Time)";
              endTimetmp = "Mon Jun 04 2018 " + endTimetmp0 + ":00 GMT+0200 (Romance Daylight Time)";
            }
          } else if(daytmp === "Mon") {
            if(endTimetmp24>startTimetmp24) {
              startTimetmp = "Mon Jun 04 2018 " + startTimetmp0 + ":00 GMT+0200 (Romance Daylight Time)";
              endTimetmp = "Mon Jun 04 2018 " + endTimetmp0 + ":00 GMT+0200 (Romance Daylight Time)";
            }
            else {
              startTimetmp = "Mon Jun 04 2018 " + startTimetmp0 + ":00 GMT+0200 (Romance Daylight Time)";
              endTimetmp = "Tue Jun 05 2018 " + endTimetmp0 + ":00 GMT+0200 (Romance Daylight Time)";
            }
          } else if(daytmp === "Tue") {
            if(endTimetmp24>startTimetmp24) {
              startTimetmp = "Tue Jun 05 2018 " + startTimetmp0 + ":00 GMT+0200 (Romance Daylight Time)";
              endTimetmp = "Tue Jun 05 2018 " + endTimetmp0 + ":00 GMT+0200 (Romance Daylight Time)";
            }
            else {
              startTimetmp = "Tue Jun 05 2018 " + startTimetmp0 + ":00 GMT+0200 (Romance Daylight Time)";
              endTimetmp = "Wed Jun 06 2018 " + endTimetmp0 + ":00 GMT+0200 (Romance Daylight Time)";
            }
          } else if(daytmp === "Wed") {
            if(endTimetmp24>startTimetmp24) {
              startTimetmp = "Wed Jun 06 2018 " + startTimetmp0 + ":00 GMT+0200 (Romance Daylight Time)";
              endTimetmp = "Wed Jun 06 2018 " + endTimetmp0 + ":00 GMT+0200 (Romance Daylight Time)";
            }
            else {
              startTimetmp = "Wed Jun 06 2018 " + startTimetmp0 + ":00 GMT+0200 (Romance Daylight Time)";
              endTimetmp = "Thu Jun 07 2018 " + endTimetmp0 + ":00 GMT+0200 (Romance Daylight Time)";
            }
          } else if(daytmp === "Thu") {
            if(endTimetmp24>startTimetmp24) {
              startTimetmp = "Thu Jun 07 2018 " + startTimetmp0 + ":00 GMT+0200 (Romance Daylight Time)";
              endTimetmp = "Thu Jun 07 2018 " + endTimetmp0 + ":00 GMT+0200 (Romance Daylight Time)";
            }
            else {
              startTimetmp = "Thu Jun 07 2018 " + startTimetmp0 + ":00 GMT+0200 (Romance Daylight Time)";
              endTimetmp = "Fri Jun 08 2018 " + endTimetmp0 + ":00 GMT+0200 (Romance Daylight Time)";
            }
          }
          date1 = new Date(startTimetmp);
          date1Value = date1.getTime();
          date2 = new Date(endTimetmp);
          date2Value = date2.getTime();
					dataP.push({
            'Permit Holder': applicanttmp,
            'Day': daytmp1,
            'Start Time': startTimetmp0,
            'End Time': endTimetmp0,
            'Start Time String': startTimetmp,
            'End Time String': endTimetmp,
            'Interval': [date1Value, date2Value],
            'Food Items': jsonVariable[i]['optionaltext'],
            'Block No': jsonVariable[i]['block'],
            'Permit No': jsonVariable[i]['permit'],
            'Address': jsonVariable[i]['PermitLocation'],
            'Description': jsonVariable[i]['locationdesc'],
            'Location': locationtmp});
				}

        var startTime = d3.min(dataP, function(d) {
          return d['Start Time String'];
        });
        var endTime = d3.max(dataP, function(d) {
          return d['End Time String'];
        });

				var xf = crossfilter(dataP);
        var all = xf.groupAll();

        var permitHolderDim = xf.dimension(function(d) {
          if(d['Permit Holder'] !== null) {
            return d['Permit Holder'].toLowerCase();
          }
          else {
            return "No Permit Holder Stored";
          }
        });

        var foodItemsDim = xf.dimension(function(d) {
          if(d['Food Items'] !== null) {
            return d['Food Items'].toLowerCase();
          }
          else {
            return "No Food Item Stored";
          }
        });

        var addressDim = xf.dimension(function(d) {
          if(d['Address'] !== null) {
            return d['Address'].toLowerCase();
          }
          else {
            return "No Address Stored";
          }
        });

        var startTimeDim = xf.dimension(function(d) {
          if(d['Start Time'] !== null) {
            return d['Start Time'].toLowerCase();
          }
          else {
            return "No Start Time Stored";
          }
        });

        var endTimeDim = xf.dimension(function(d) {
          if(d['End Time'] !== null) {
            return d['End Time'].toLowerCase();
          }
          else {
            return "No End Time Stored";
          }
        });

        search1
          .dimension(permitHolderDim)
          .placeHolder('Permit Holder')


        search2
          .dimension(foodItemsDim)
          .placeHolder('Food Items');

        search3
          .dimension(addressDim)
          .placeHolder('Address');

        search4
          .dimension(startTimeDim)
          .placeHolder('Start Time');

        search5
          .dimension(endTimeDim)
          .placeHolder('End Time');

        var facilities = xf.dimension(function(d) {
						return d['Location'];
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
					.popup(function(d, marker) {
						return dataP[functiontofindIndexByKeyValue(dataP, "Location", d.key)]["Applicant"] + " " + d.key;
					});

        var maptmpcount =0;
        map.on('filtered', function(chart, filter) {
          if(maptmpcount == 0) {
  			       alert("It may be irreversible!");
  			       maptmpcount++;
  		    }
        });

        var dayDim = xf.dimension(function(d) {
          return d['Day'];
        });
        var dayGroup = dayDim.group().reduceCount();

        dayChart
          .dimension(dayDim)
          .group(dayGroup)
          .width(400)
          .height(300)
          .renderLabel(true)
          .renderTitle(true)
          .legend(dc.legend())
          .innerRadius(7)
          .label(function (d) {
            if (dayChart.hasFilter() && !dayChart.hasFilter(d.key)) {
              return d.key + '(0%)';
            }
            var label = d.key;
            if (all.value()) {
              label += '(' + Math.floor(d.value / all.value() * 100) + '%)';
            }
            return label;
          });

        dayChart.on('filtered', function(chart, filter) {
    			if(undoFlag === false) {
            actionFunction(chart, filter, false);
          }
        });




        var intervalDim = xf.dimension(function(d) {
          return d['Interval'][0];
        });
        var intervalGroup = intervalDim.group().reduceCount();
        var timeTree = xf.groupAll().reduce(function(v, d) {
          v.insert(d['Interval']);
          return v;
        }, function(v, d) {
            v.remove(d['Interval']);
            return v;
        }, function() {
            return lysenkoIntervalTree(null);
        });
        var timeGroup = intervalTreeGroupFunction(timeTree.value(), startTime, endTime);


        timeChart
          .width(1200)
          .height(300)
          .x(d3.scaleTime().domain(startTime, endTime))
          .y(d3.scaleLinear().domain([0,150]))
          .xUnits(d3.timeDay)
          .gap(1)
          .elasticX(true)
          .brushOn(true)
          .yAxisLabel("Number")
          .xAxisLabel("Time")
          .dimension(intervalDim)
          .group(intervalGroup)
          .controlsUseVisibility(true)
          .xAxis().tickFormat(d3.timeFormat("%A %X"));

          // var monthchartselectcount = 0;
          // timeChart.filterHandler(function(dim, filters) {
          //   if(monthchartselectcount == 0) {
          //     alert("Selecting this range do not save on undo stack.");
          //     monthchartselectcount++;
          //   }
          //   if(undoFlag === false) {
          //     if(filters && filters.length) {
          //       if(filters.length !== 1)
          //         throw new Error('not expecting more than one range filter');
          //       var range = filters[0];
          //       dim.filterFunction(function(i) {
          //         return !(i[1] < range[0].getTime() || i[0] > range[1].getTime());
          //       })
          //     }
          //     else dim.filterAll();
          //     return filters;//.tickFormat(d3.timeFormat("%A %X"));
          //   }
          // });

          var i = 0;
            dc.dataTable('.dc-data-grid')
              .dimension(dayDim)
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
                  return d['Permit Holder'];
                },
                function (d) {
                  return d['Food Items'];
                },
                function (d) {
                  return d['Address'];
                },
                function (d) {
                  return d['Start Time'];
                },
                function (d) {
                  return d['End Time'];
                },
                function (d) {
                  return d['Day'];
                },
                function (d) {
                  return d['Description'];
                }])
                .on('renderlet', function (c) {
                  i = 0;
                });

          var dayDim1 = xf.dimension(function(d) {
            return d['Day'];
          });


          visCount
      			.dimension(xf)
      			.group(all);

          visTable
      			.dimension(dayDim1)
      			.group(function (d) { return '' })
      			.size(50)
      			.columns([
      				"Permit Holder",
              "Day",
              "Start Time",
              "End Time",
              "Food Items",
              "Address",
              "Description",
              "Permit No",
              "Block No"


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
          inputValueTmp4 = $('.search4 .dc-text-filter-input').val();
          inputValueTmp5 = $('.search5 .dc-text-filter-input').val();
          dc.renderAll(groupname);
        });
        $(document).on("focus","input",function(e){
          $('.search1 .dc-text-filter-input').val(inputValueTmp1);
          $('.search2 .dc-text-filter-input').val(inputValueTmp2);
          $('.search3 .dc-text-filter-input').val(inputValueTmp3);
          $('.search4 .dc-text-filter-input').val(inputValueTmp4);
          $('.search5 .dc-text-filter-input').val(inputValueTmp5);
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
      search4.filterAll();
      search5.filterAll();
      map.filterAll();
      timeChart.filterAll();
      dayChart.filterAll();
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



    function intervalTreeGroupFunction(tree, s, e) {
      return {
        all: function() {
          var begin = d3.timeDay(s);
          // var begin = d3.timeMonth(s);
          var end = d3.timeDay(e);
          // var end = d3.timeMonth(e);
          var i = new Date(begin);
          var ret = [], count;
          do {
            next = new Date(i);
            next.setDate(next.getDate()+1);
            count = 0;
            tree.queryInterval(i.getTime(), next.getTime(), function() {
              ++count;
            });
            ret.push({key: i, value: count});
            i = next;
          }
          while(i.getTime() <= end.getTime());
          return ret;
        }
      };
    }


	</script>
</body>
</html>
