<?php
session_start();
$url = "../../user/index.php";
if (isset($_GET['pdf'])) {
	$_SESSION['file'] = "UtilityExcavationPermits.csv";
	ob_start();
    header('Location: '.$url);
    ob_end_flush();
    die();
} else if (isset($_GET['csv'])) {
	$_SESSION['file'] = "UtilityExcavationPermits.csv";
	ob_start();
    header('Location: '.$url);
    ob_end_flush();
    die();
}
?>
<html>
<head>
  <link rel="icon" href="../../files/favicon.png">
  <title>Utility Excavation Permits</title>
  <meta http-equiv="content-type" content="text/html; charset=UTF8">
  
  
  <!--<link type="text/css" href="../../css/dc.css" rel="stylesheet"/>
  <link rel="stylesheet" href="../../css/bootstrap.css" rel="stylesheet">-->
  
  <link type="text/css" href="../../css/dc.min.css" rel="stylesheet"/>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css">

  
  
  
  
  
  <link type="text/css" href="../../css/utilityExcavationPermitsStyle.css" rel="stylesheet"/>
  <link rel="stylesheet" href="../../css/spinner.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="../../css/all.css">
  <link href="https://fonts.googleapis.com/css?family=Acme|Fira+Sans+Condensed|Fjalla+One" rel="stylesheet">
</head>
<body>
    <div class="spinner"></div>
	  <div id="holder" style="display: none;">
	  <div id="gettingFiles">
		<a href='index.php?pdf=true'>Get PDF</a>
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
    <button id="reloadButton" onclick="reloadFunction()" title="Reload this page">Reload</button>
		<h2>Utility Excavation Permits</h2>
		<div id="demo1">
      <div class="searchHolder">
        <div class="search1"></div>
        <div class="search2"></div>
        <div class="search3"></div>
        <div class="search4"></div>
      </div>
      <div class="searchTable">
        <table class="table dc-data-grid">
          <thead>
            <tr class="header">
              <th>No</th>
              <th>Street Name</th>
              <th>Permit Reason</th>
              <th>Utility Type</th>
              <th>Utility Contractor</th>
            </tr>
          </thead>
        </table>
        <button id="hideTableSearch" onclick="hideTableSearchFunction()">Hide it</button>
      </div>
      <div class="break"></div>
      <div class="status">
        <strong>Status</strong>
        <span class="reset" style="display: none;">Selected: <span class="filter"></span></span>
        <a class="reset" href="javascript:chartReset(statusChart);" style="display: none;">reset</a>
        <div class="clearfix"></div>
      </div>
      <div class="utilityType">
        <strong>Utility Type</strong>
        <span class="reset" style="display: none;">Selected: <span class="filter"></span></span>
        <a class="reset" href="javascript:chartReset(utilityTypeChart);" style="display: none;">reset</a>
        <div class="clearfix"></div>
      </div>
      <div class="break"></div>
      <div class="utilityContractor">
        <strong>Utility Contractor</strong>
        <span class="reset" style="display: none;">Selected: <span class="filter"></span></span>
        <a class="reset" href="javascript:chartReset(utilityContractorChart);" style="display: none;">reset</a>
        <div class="clearfix"></div>
      </div>
      <div class="break"></div>
      <div class="permitReason">
        <strong>Permit Reason</strong>
        <span class="reset" style="display: none;">Selected: <span class="filter"></span></span>
        <a class="reset" href="javascript:chartReset(permitReasonChart);" style="display: none;">reset</a>
        <div class="clearfix"></div>
      </div>
      <div class="month">
        <strong>Effective Date- Expiratoin Date</strong>
        <div class="reset" style="visibility: hidden;">selected: <span class="filter"></span>
          <a href="javascript:chartReset(monthChart);">reset</a>
        </div>
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
	<script type="text/javascript" src="../../js/lysenko.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script type="text/javascript" src="../../js/bootstrap.js"></script>-->
	
	<script src="../../js/d3.min.js"></script>	
	<script type="text/javascript" src="../../js/crossfilter.min.js"></script>
	<script type="text/javascript" src="../../js/dc.min.js"></script>
	<script type="text/javascript" src="../../js/colorbrewer.js"></script>
	<script type="text/javascript" src="../../js/lysenko.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" ></script>
	
	
	
	
	
	
	
	

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
    search1 = dc.textFilterWidget('#demo1 .search1', groupname);
    search2 = dc.textFilterWidget('#demo1 .search2', groupname);
    search3 = dc.textFilterWidget('#demo1 .search3', groupname);
    search4 = dc.textFilterWidget('#demo1 .search4', groupname);
    statusChart = dc.pieChart("#demo1 .status", groupname);
    utilityTypeChart = dc.barChart("#demo1 .utilityType", groupname);
    utilityContractorChart = dc.barChart("#demo1 .utilityContractor", groupname);
    permitReasonChart = dc.rowChart("#demo1 .permitReason", groupname);
    monthChart = dc.barChart("#demo1 .month", groupname);
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
        alert("For getting a great performance, first choose a range on Effective Date- Expiratoin Date part.");
        jsonVariable = JSON.parse(this.responseText);
				jsonVariableLength = jsonVariable["results"]["length"];
        var crossStreet1;
        var crossStreet2;
        var effectiveDate;
        var date1;
        var effectiveDateValue;
        var expirationDate;
        var date2;
        var expirationDateValue;
        var interval;
        var permitReason;
        var status;
        var streetName;
        var utilityContractor;
        var utilityType;
        var permitNo;
				for(var i=0; i<jsonVariableLength; i++) {
          crossStreet1 = jsonVariable["results"][i]["Cross Street 1"];
          crossStreet2 = jsonVariable["results"][i]["Cross Street 2"]
          effectiveDate = jsonVariable["results"][i]["Effective Date"];
          date1 = new Date(effectiveDate);
          effectiveDateValue = date1.getTime();
          expirationDate = jsonVariable["results"][i]["Expiration Date"];
          date2 = new Date(expirationDate);
          expirationDateValue = date2.getTime();
          if(expirationDateValue < effectiveDateValue) {
            var tmp1 = effectiveDateValue;
            var tmp2 = expirationDateValue;
            effectiveDateValue = tmp2;
            expirationDateValue = tmp1;
            effectiveDate = jsonVariable["results"][i]["Expiration Date"];
            date1 = new Date(effectiveDate);
            expirationDate = jsonVariable["results"][i]["Effective Date"];
            date2 = new Date(expirationDate);
          }
          interval = [effectiveDateValue, expirationDateValue];
          permitReason = jsonVariable["results"][i]["Permit Reason"];
          status = jsonVariable["results"][i]["Status"];
          streetName = jsonVariable["results"][i]["StreetName"];
          utilityContractor = jsonVariable["results"][i]["Utility Contractor"];
          utilityType = jsonVariable["results"][i]["Utility Type"];
          permitNo = jsonVariable["results"][i]["permit_number"];
					dataP.push({
            'Cross Street 1': crossStreet1,
            'Cross Street 2': crossStreet2,
            'Effective Date': effectiveDate,
            'Expiration Date': expirationDate,
            'Effective Date1': date1,
            'Expiration Date1': date2,
            'Interval': interval,
            'Permit Reason': permitReason,
            'Status': status,
            'Street Name': streetName,
            'Utility Contractor': utilityContractor,
            'Utility Type': utilityType,
            'Permit Number': permitNo
				  });
        }

        var startTime = d3.min(dataP, function(d) {
          return d['Effective Date1'];
        });
        var endTime = d3.max(dataP, function(d) {
          return d['Expiration Date1'];
        });

				var xf = crossfilter(dataP);
        var all = xf.groupAll();

        var streetNameDim = xf.dimension(function(d) {
          if(d['Street Name'] !== null) {
            return d['Street Name'].toLowerCase();
          }
          else {
            return "No Street Name Stored";
          }
        });

        var permitReasonDim = xf.dimension(function(d) {
          if(d['Permit Reason'] !== null) {
            return d['Permit Reason'].toLowerCase();
          }
          else {
            return "No Permit Reason Stored";
          }
        });

        var utilityTypeDim = xf.dimension(function(d) {
          if(d['Utility Type'] !== null) {
            return d['Utility Type'].toLowerCase();
          }
          else {
            return "No Utility Type Stored";
          }
        });

        var utilityContractorDim = xf.dimension(function(d) {
          if(d['Utility Contractor'] !== null) {
            return d['Utility Contractor'].toLowerCase();
          }
          else {
            return "No Utility Contractor Stored";
          }
        });



        search1
          .dimension(streetNameDim)
          .placeHolder('Street Name')

        search2
          .dimension(permitReasonDim)
          .placeHolder('Permit Reason');

        search3
          .dimension(utilityTypeDim)
          .placeHolder('Utility Type');

        search4
          .dimension(utilityContractorDim)
          .placeHolder('Utility Contractor');



        var statusDim = xf.dimension(function(d) {
					return d['Status'];
				});
				var statusGroup = statusDim.group().reduceCount();

				statusChart
					.dimension(statusDim)
					.group(statusGroup)
					.width(400)
					.height(300)
					.renderLabel(true)
					.renderTitle(true)
					.legend(dc.legend())
					.innerRadius(7)
          .label(function (d) {
    				if (statusChart.hasFilter() && !statusChart.hasFilter(d.key)) {
    					return d.key + '(0%)';
    				}
    				var label = d.key;
    				if (all.value()) {
    					label += '(' + Math.floor(d.value / all.value() * 100) + '%)';
    				}
    				return label;
          });

          statusChart.on('filtered', function(chart, filter) {
            if(undoFlag === false) {
				actionFunction(chart, filter, false);
			  }
          });

          var utilityTypeDim1 = xf.dimension(function(d) {
            return d['Utility Type'];
          });

          var utilityTypeGroup1 = utilityTypeDim1.group().reduceCount();

          utilityTypeChart
            .width(1000)
            .height(380)
            .x(d3.scaleBand())
            .xUnits(dc.units.ordinal)
            .brushOn(true)
            .xAxisLabel('Utility Type')
            .yAxisLabel('Number')
            .dimension(utilityTypeDim1)
            .barPadding(0.1)
            .outerPadding(0.05)
            .group(utilityTypeGroup1)
            .xAxis().tickValues([]);

          utilityTypeChart.on('filtered', function(chart, filter) {
            if(undoFlag === false) {
				actionFunction(chart, filter, false);
			  }
        });

          var utilityContractorDim1 = xf.dimension(function(d) {
  					return d['Utility Contractor'];
  				});
  				var utilityContractorGroup1 = utilityContractorDim1.group().reduceCount();

  				utilityContractorChart
            .width(968)
            .height(380)
            .x(d3.scaleBand())
            .xUnits(dc.units.ordinal)
            .brushOn(true)
            .xAxisLabel('Utility Type')
            .yAxisLabel('Number')
            .dimension(utilityContractorDim1)
            .barPadding(0.1)
            .outerPadding(0.05)
            .group(utilityContractorGroup1)
            .xAxis().tickValues([]);

          utilityContractorChart.on('filtered', function(chart, filter) {
            if(undoFlag === false) {
				actionFunction(chart, filter, false);
			  }
          });

          var permitReasonDim1 = xf.dimension(function(d) {
  					return d['Permit Reason'];
  				});
  				var permitReasonGroup1 = permitReasonDim1.group().reduceCount();

          permitReasonChart
            .margins({top: 20, left: 10, right: 10, bottom: 20})
            .width(500)
            .height(450)
            .dimension(permitReasonDim1)
            .group(permitReasonGroup1)
            .label(function (d) {
              if(d.value < 400) {
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
            .ticks(4);

          permitReasonChart.rowsCap(10);

          permitReasonChart.on('filtered', function(chart, filter) {
            if(undoFlag === false) {
				actionFunction(chart, filter, false);
			  }
          });

        var intervalDim = xf.dimension(function(d) {
          return d['Interval'];
        });

        var utilitiesPerMonthTree = xf.groupAll().reduce(
          function(v, d) {
            v.insert(d['Interval']);
            return v;
          }, function(v, d) {
              v.remove(d['Interval']);
              return v;
          }, function() {
              return lysenkoIntervalTree(null);
          });

        var utilityPerMonthGroup = intervalTreeGroup(utilitiesPerMonthTree.value(), startTime, endTime);

        var timeFormat = d3.timeFormat("%Y");//%Y-%m-%d


        monthChart
          .width(600)
          .height(500)
          .x(d3.scaleTime())
          .y(d3.scaleLinear().domain([-100,4500]))
          .xUnits(d3.timeMonths)
          .gap(.5)
          .elasticX(true)
          .brushOn(true)
          .barPadding(50)
          .mouseZoomable(false)
          .alwaysUseRounding(false)
          .centerBar(true)
          .yAxisLabel("Number of Utilities")
          .xAxisLabel("Time")
          .dimension(intervalDim)
          .group(utilityPerMonthGroup)
          .controlsUseVisibility(true)
          .xAxis().tickFormat(timeFormat);

        var monthchartselectcount = 0;
        monthChart.filterHandler(function(dim, filters) {
          if(monthchartselectcount == 0) {
            alert("Selecting this range do not save on undo stack.");
            monthchartselectcount++;
          }
          if(undoFlag === false) {
            if(filters && filters.length) {
              if(filters.length !== 1)
                throw new Error('not expecting more than one range filter');
              var range = filters[0];
              dim.filterFunction(function(i) {
                return !(i[1] < range[0].getTime() || i[0] > range[1].getTime());
              })
            }
            else dim.filterAll();
            return filters;
          }
        });

        var statusDim1 = xf.dimension(function(d) {
					return d['Status'];
				});

        var i = 0;
        dc.dataTable('.dc-data-grid')
          .dimension(statusDim1)
          .group(function (d) {
            return '';
          })
          .size(20)
          .columns([
            function (d) {
              i = i + 1;
              return i;
            }, function (d) {
              return d['Street Name'];
            }, function (d) {
              return d['Permit Reason'];
            }, function (d) {
              return d['Utility Type'];
            }, function (d) {
              return d['Utility Contractor'];
            }])
            .on('renderlet', function (c) {
              i = 0;
            });



        var statusDim2 = xf.dimension(function(d) {
					return d['Status'];
				});
				var statusGroup2 = statusDim2.group().reduceCount();

        visCount
    			.dimension(xf)
    			.group(all);

        visTable
    			.dimension(statusDim2)
    			.group(function (d) { return '' })
    			.size(50)
    			.columns([
    				"Permit Number",
            "Utility Contractor",
            "Street Name",
            "Cross Street 1",
            "Cross Street 2",
            "Permit Reason",
            "Status",
            "Utility Type",
            "Effective Date",
            "Expiration Date"
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
        dc.renderAll(groupname);
      });
      $(document).on("focus","input",function(e){
        $('.search1 .dc-text-filter-input').val(inputValueTmp1);
        $('.search2 .dc-text-filter-input').val(inputValueTmp2);
        $('.search3 .dc-text-filter-input').val(inputValueTmp3);
        $('.search4 .dc-text-filter-input').val(inputValueTmp4);
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
		statusChart.filterAll();
		utilityTypeChart.filterAll();
		utilityContractorChart.filterAll();
		permitReasonChart.filterAll();
		monthChart.filterAll();
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

    function intervalTreeGroup(tree, firstDate, lastDate) {
      return {
        all: function() {
          var begin = d3.timeMonth(firstDate), end = d3.timeMonth(lastDate);
          var i = new Date(begin);
          var ret = [], count;
          do {
            next = new Date(i);
            next.setMonth(next.getMonth()+1);
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
