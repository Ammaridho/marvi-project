/* ===================================
ALL about analitycs
===================================*/

/*  squad active/inactive */
var options = {
     series: [504, 120, 111],
     chart: {
     height: 300,
     width: "100%",
     type: 'donut',
   },
   colors: ["#00876c", "#459971", "#e97f57"],
   stroke: {
     width: 0,
   },
   plotOptions: {
     pie: {
       donut: {
         labels: {
           show: true,
           total: {
             showAlways: true,
             show: true
           }
         }
       }
     }
   },
   labels: ["Active", "In-active", "Suspend"],
   legend: {
     show: true,
     position: 'bottom',
     horizontalAlign: 'center', 
     floating: false,
     fontSize: '14px',
     labels: {
         colors: ["#00876c", "#459971", "#e97f57"],
         useSeriesColors: false
     },
     markers: {
         width: 12,
         height: 12,
         strokeWidth: 0,
         strokeColor: '#fff',
         radius: 12,
     },
     itemMargin: {
         horizontal: 5,
         vertical: 0
     },
     onItemClick: {
         toggleDataSeries: true
     },
     onItemHover: {
         highlightDataSeries: true
     },
   },
   dataLabels: {
     dropShadow: {
       blur: 3,
       opacity: 0.8
     }
   },
   fill: {
     colors: ["#00876c", "#459971", "#e97f57"],
   },
   states: {
     hover: {
       filter: 'none'
     }
   },
   };
 var chart = new ApexCharts(document.querySelector("#firstVisit"), options);
 chart.render();
 /*  //squad active/inactive */




/*  squad active/inactive */
var options = {
     series: [504, 120, 111],
     chart: {
     height: 300,
     width: "100%",
     type: 'donut',
   },
   colors: ["#00876c", "#459971", "#e97f57"],
   stroke: {
     width: 0,
   },
   plotOptions: {
     pie: {
       donut: {
         labels: {
           show: true,
           total: {
             showAlways: true,
             show: true
           }
         }
       }
     }
   },
   labels: ["Active", "In-active", "Suspend"],
   legend: {
     show: true,
     position: 'bottom',
     horizontalAlign: 'center', 
     floating: false,
     fontSize: '14px',
     labels: {
         colors: ["#00876c", "#459971", "#e97f57"],
         useSeriesColors: false
     },
     markers: {
         width: 12,
         height: 12,
         strokeWidth: 0,
         strokeColor: '#fff',
         radius: 12,
     },
     itemMargin: {
         horizontal: 5,
         vertical: 0
     },
     onItemClick: {
         toggleDataSeries: true
     },
     onItemHover: {
         highlightDataSeries: true
     },
   },
   dataLabels: {
     dropShadow: {
       blur: 3,
       opacity: 0.8
     }
   },
   fill: {
     colors: ["#00876c", "#459971", "#e97f57"],
   },
   states: {
     hover: {
       filter: 'none'
     }
   },
   };
 var chart = new ApexCharts(document.querySelector("#squad-status"), options);
 chart.render();
 /*  //squad active/inactive */
 
 /*  squad time */
 var options = {
     series: [235, 7649, 3123, 115],
     chart: {
     height: 340,
     width: "100%",
     type: 'donut',
   },
   colors: ["#00876c", "#459971", "#6dab77", "#92bc7f", "#b6cd8a", "#dbde99", "#ffeeaa", "#fad48d", "#f5b975", "#f09c63", "#e97f57", "#e06051", "#d43d51"],
   stroke: {
     width: 0,
   },
   plotOptions: {
     pie: {
       donut: {
         labels: {
           show: true,
           total: {
             showAlways: true,
             show: true
           }
         }
       }
     }
   },
   title: {
     text: "All Squad",
     align: 'center',
     margin: 10,
     offsetX: 0,
     offsetY: 0,
     floating: false,
     style: {
       fontSize:  '14px',
       fontWeight:  'bold',
       color:  '#23315D'
     },
   },
   labels: ["07:00 - 10:00", "11:00 - 13:00", "14:00 - 18:00", "19:00 - 20:00"],
   legend: {
     show: true,
     position: 'bottom',
     horizontalAlign: 'center', 
     floating: false,
     fontSize: '14px',
     labels: {
         colors: ["#00876c", "#459971", "#6dab77", "#92bc7f", "#b6cd8a", "#dbde99", "#ffeeaa", "#fad48d", "#f5b975", "#f09c63", "#e97f57", "#e06051", "#d43d51"],
         useSeriesColors: false
     },
   },
   dataLabels: {
     dropShadow: {
       blur: 3,
       opacity: 0.8
     }
   },
   fill: {
     colors: ["#00876c", "#459971", "#6dab77", "#92bc7f", "#b6cd8a", "#dbde99", "#ffeeaa", "#fad48d", "#f5b975", "#f09c63", "#e97f57", "#e06051", "#d43d51"],
   },
   states: {
     hover: {
       filter: 'none'
     }
   },
   };
 var chart = new ApexCharts(document.querySelector("#squad-order-time"), options);
 chart.render();
 /*  //squad time */
 
 /*  squad active/inactive */
 var options = {
     series: [{
       name: 'Total Order',
       data: [44, 55, 57, 56, 12, 34, 55, 66, 77, 12, 98, 34]
     }, {
       name: 'Success Delivered',
       data: [34, 65, 27, 16, 42, 64, 25, 96, 37, 42, 28, 74]
     },
     {
         name: 'Failed Delivered',
         data: [2, 1, 6, 12, 1, 4, 6, 12, 5, 9, 2, 3]
       }
     ],
     chart: {
       type: 'bar',
       height: 350,
       toolbar: {
         show: false
       },
   },
   title: {
     text: "All Squad",
     align: 'center',
     margin: 10,
     offsetX: 0,
     offsetY: 0,
     floating: false,
     style: {
       fontSize:  '14px',
       fontWeight:  'bold',
       color:  '#23315D'
     },
   },
   colors: ["#00876c", "#459971", "#e97f57"],
   plotOptions: {
     bar: {
       horizontal: false,
       columnWidth: '80%',
       endingShape: 'rounded',
       dataLabels: {
         position: 'top'
       },
     },
   },
   dataLabels: {
     enabled: false
   },
   stroke: {
     show: true,
     width: 2,
     colors: ['transparent']
   },
   xaxis: {
     categories: ['Jan', 'Feb', 'Mar', 'Apr','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
   },
   fill: {
     opacity: 1,
     colors: ["#00876c", "#459971", "#e97f57"],
   },
   tooltip: {
     y: {
       formatter: function (val) {
         return val
       }
     }
   },
   grid: {
     padding: {
       bottom: 20
     }
   },
   legend: {
     show: true,
     position: 'bottom',
     horizontalAlign: 'center', 
     offsetX: 0,
     offsetY: 5,
   },
   dataLabels: {
     enabled: true,
     style: {
       colors: ['#8E8D8D']
     },
     offsetY: -24
   },
 };
 var chart = new ApexCharts(document.querySelector("#squad-order"), options);
 chart.render();
 /*  //squad active/inactive */
 
 /*  squad location */
 var options = {
     chart: {
         height: 350,
         type: "treemap",
       },
       series: [
         {
           data: [
             {
               x: "Menara Kuningan",
               y: 218,
             },
             {
               x: "RS Fatmawati",
               y: 149,
             },
             {
               x: "Menara Rubina",
               y: 184,
             },
             {
               x: "Mall Ambasador",
               y: 55,
             },
             {
               x: "Tower ABC",
               y: 84,
             },
             {
               x: "RS Fatmawati",
               y: 31,
             },
             {
               x: "Gedung ABCDE",
               y: 70,
             }
           ],
         },
     ],
     chart: {
       type: 'treemap',
       height: 350,
       toolbar: {
         show: false
       },
   },
   title: {
     text: "All Squad",
     align: 'center',
     margin: 10,
     offsetX: 0,
     offsetY: 0,
     floating: false,
     style: {
       fontSize:  '14px',
       fontWeight:  'bold',
       color:  '#23315D'
     },
   },
   colors: ["#00876c", "#459971", "#6dab77", "#92bc7f", "#b6cd8a", "#dbde99", "#ffeeaa", "#fad48d", "#f5b975", "#f09c63", "#e97f57", "#e06051", "#d43d51"],
   plotOptions: {
     bar: {
       horizontal: false,
       columnWidth: '80%',
       endingShape: 'rounded',
       dataLabels: {
         position: 'top'
       },
     },
   },
   dataLabels: {
     enabled: false
   },
   stroke: {
     show: true,
     width: 2,
     colors: ['transparent']
   },
   xaxis: {
     categories: ['Jan', 'Feb', 'Mar', 'Apr','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
   },
   fill: {
     opacity: 1,
     colors: ["#00876c", "#459971", "#6dab77", "#92bc7f", "#b6cd8a", "#dbde99", "#ffeeaa", "#fad48d", "#f5b975", "#f09c63", "#e97f57", "#e06051", "#d43d51"],
   },
   tooltip: {
     y: {
       formatter: function (val) {
         return val
       }
     }
   },
   legend: {
     show: true,
     position: 'bottom',
     horizontalAlign: 'center', 
     offsetX: 0,
     offsetY: 5,
   },
   dataLabels: {
     enabled: true,
     style: {
       colors: ['#fff']
     },
     offsetY: -24
   },
 };
 var chart = new ApexCharts(document.querySelector("#squad-location"), options);
 chart.render();
 /*  //squad location*/






/*  
============================================
STAT 4 QR traffic
============================================
*/

/* engagement */
var options = {
     series: [{
       name: 'Engagement',
       data: [24, 11, 31, 56, 1, 34, 25, 16, 7, 0, 18, 34]
     }
     ],
     chart: {
       type: 'bar',
       height: 350,
       toolbar: {
         show: false
       },
   },
   
   colors: ["#00876c", "#459971", "#e97f57"],
   plotOptions: {
     bar: {
       horizontal: false,
       columnWidth: '80%',
       endingShape: 'rounded',
       dataLabels: {
         position: 'top'
       },
     },
   },
   dataLabels: {
     enabled: false
   },
   stroke: {
     show: true,
     width: 2,
     colors: ['transparent']
   },
   xaxis: {
     categories: ['Jan', 'Feb', 'Mar', 'Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
   },
   fill: {
     opacity: 1,
     colors: ["#00876c", "#459971", "#e97f57"],
   },
   tooltip: {
     y: {
       formatter: function (val) {
         return val
       }
     }
   },
   grid: {
     padding: {
       bottom: 20
     }
   },
   legend: {
     show: true,
     position: 'bottom',
     horizontalAlign: 'center', 
     offsetX: 0,
     offsetY: 5,
   },
   dataLabels: {
     enabled: true,
     style: {
       colors: ['#8E8D8D']
     },
     offsetY: -24
   },
 };
 var chart = new ApexCharts(document.querySelector("#qrEngagement"), options);
 chart.render();
 /* end engagement */

/*  Operating System */
var options = {
     series: operatingSystem['user'],
     chart: {
     height: 260,
     width: "100%",
     type: 'donut',
   },
   colors: ["#00876c", "#459971", "#6dab77", "#92bc7f", "#b6cd8a", "#dbde99", "#ffeeaa", "#fad48d", "#f5b975", "#f09c63", "#e97f57", "#e06051", "#d43d51"],
   stroke: {
     width: 0,
   },
   plotOptions: {
     pie: {
       donut: {
         labels: {
           show: true,
           total: {
             showAlways: true,
             show: true
           }
         }
       }
     }
   },
   labels: operatingSystem['operatingSystem'],
   legend: {
     show: true,
     position: 'bottom',
     horizontalAlign: 'center', 
     floating: false,
     fontSize: '14px',
     labels: {
         colors: ["#00876c", "#459971", "#6dab77", "#92bc7f", "#b6cd8a", "#dbde99", "#ffeeaa", "#fad48d", "#f5b975", "#f09c63", "#e97f57", "#e06051", "#d43d51"],
         useSeriesColors: false
     },
     markers: {
         width: 12,
         height: 12,
         strokeWidth: 0,
         strokeColor: '#fff',
         radius: 12,
     },
     itemMargin: {
         horizontal: 5,
         vertical: 0
     },
     onItemClick: {
         toggleDataSeries: true
     },
     onItemHover: {
         highlightDataSeries: true
     },
   },
   dataLabels: {
     dropShadow: {
       blur: 3,
       opacity: 0.8
     }
   },
   fill: {
    colors: ["#00876c", "#459971", "#6dab77", "#92bc7f", "#b6cd8a", "#dbde99", "#ffeeaa", "#fad48d", "#f5b975", "#f09c63", "#e97f57", "#e06051", "#d43d51"],
   },
   states: {
     hover: {
       filter: 'none'
     }
   },
   };
 var chart = new ApexCharts(document.querySelector("#os"), options);
 chart.render();
/*  end Referes */

/*  By Device Category */
var options = {
     series: deviceCategory['user'],
     chart: {
     height: 260,
     width: "100%",
     type: 'donut',
   },
   colors: ["#B1CFBA", "#00876c", "#e97f57"],
   stroke: {
     width: 0,
   },
   plotOptions: {
     pie: {
       donut: {
         labels: {
           show: true,
           total: {
             showAlways: true,
             show: true
           }
         }
       }
     }
   },
   labels: deviceCategory['platform'],
   legend: {
     show: true,
     position: 'bottom',
     horizontalAlign: 'center', 
     floating: false,
     fontSize: '14px',
     labels: {
         colors: ["#B1CFBA", "#00876c", "#e97f57"],
         useSeriesColors: true
     },
     markers: {
         width: 12,
         height: 12,
         strokeWidth: 0,
         strokeColor: '#fff',
         radius: 12,
     },
     itemMargin: {
         horizontal: 5,
         vertical: 0
     },
     onItemClick: {
         toggleDataSeries: true
     },
     onItemHover: {
         highlightDataSeries: true
     },
   },
   dataLabels: {
     dropShadow: {
       blur: 3,
       opacity: 0.8
     }
   },
   fill: {
     colors: ["#B1CFBA", "#00876c", "#e97f57"],
   },
   states: {
     hover: {
       filter: 'none'
     }
   },
   };
 var chart = new ApexCharts(document.querySelector("#device"), options);
 chart.render();
/*  end Location */

/*  claim */
var options = {
  series: [104, 12],
  chart: {
  height: 260,
  width: "100%",
  type: 'donut',
},
colors: ["#00876c", "#e97f57"],
stroke: {
  width: 0,
},
plotOptions: {
  pie: {
    donut: {
      labels: {
        show: true,
        total: {
          showAlways: true,
          show: true,
          label: 'Total Claim',
        }
      }
    }
  }
},
labels: ["Success", "Failed"],
legend: {
  show: true,
  position: 'bottom',
  horizontalAlign: 'center', 
  floating: false,
  fontSize: '14px',
  labels: {
      colors: ["#00876c", "#e97f57"],
      useSeriesColors: false
  },
  markers: {
      width: 12,
      height: 12,
      strokeWidth: 0,
      strokeColor: '#fff',
      radius: 12,
  },
  labels: {
    show: true,
  },
  itemMargin: {
      horizontal: 5,
      vertical: 0
  },
  onItemClick: {
      toggleDataSeries: true
  },
  onItemHover: {
      highlightDataSeries: true
  },
},
dataLabels: {
  dropShadow: {
    blur: 3,
    opacity: 0.8
  }
},
fill: {
  colors: ["#00876c", "#e97f57"],
},
states: {
  hover: {
    filter: 'none'
  }
},
};
var chart = new ApexCharts(document.querySelector("#claimStat"), options);
chart.render();
/*  / claim */

/*  redeem */
var options = {
  series: [2504, 112],
  chart: {
  height: 260,
  width: "100%",
  type: 'donut',
},
colors: ["#00876c", "#e97f57"],
stroke: {
  width: 0,
},
plotOptions: {
  pie: {
    donut: {
      labels: {
        show: true,
        total: {
          showAlways: true,
          show: true,
          label: 'Total Redeem',
        }
      }
    }
  }
},
labels: ["Success", "Failed"],
legend: {
  show: true,
  position: 'bottom',
  horizontalAlign: 'center', 
  floating: false,
  fontSize: '14px',
  labels: {
      colors: ["#00876c", "#e97f57"],
      useSeriesColors: false
  },
  markers: {
      width: 12,
      height: 12,
      strokeWidth: 0,
      strokeColor: '#fff',
      radius: 12,
  },
  labels: {
    show: true,
  },
  itemMargin: {
      horizontal: 5,
      vertical: 0
  },
  onItemClick: {
      toggleDataSeries: true
  },
  onItemHover: {
      highlightDataSeries: true
  },
},
dataLabels: {
  dropShadow: {
    blur: 3,
    opacity: 0.8
  }
},
fill: {
  colors: ["#00876c", "#e97f57"],
},
states: {
  hover: {
    filter: 'none'
  }
},
};
var chart = new ApexCharts(document.querySelector("#redeemStat"), options);
chart.render();
/*  / redeem */

/*  site traffic */
var options = {
  series: [{
    name: 'Page views',
    data: totalAccess['user']
  }
  ],
  chart: {
    type: 'line',
    height: 200,
    toolbar: {
      show: false
    },
},
colors: ["#00876c", "#459971", "#e97f57"],
plotOptions: {
  bar: {
    horizontal: false,
    columnWidth: '80%',
    endingShape: 'rounded',
    dataLabels: {
      position: 'top'
    },
  },
},
dataLabels: {
  enabled: false
},
stroke: {
  show: true,
  width: 2,
  colors: ['transparent']
},
xaxis: {
  categories: totalAccess['date'],
},
fill: {
  opacity: 1,
  colors: ["#459971", "#e97f57"],
},
stroke: {
  curve: 'straight',
  lineCap: 'butt',
  width: 2,
  dashArray: 0,      
},
tooltip: {
  y: {
    formatter: function (val) {
      return val
    }
  }
},
grid: {
  row: {
    colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
    opacity: 0.5
  },
},
legend: {
  show: true,
  position: 'bottom',
  horizontalAlign: 'center', 
  offsetX: 0,
  offsetY: 5,
},
dataLabels: {
  enabled: false,
  style: {
    colors: ['#8E8D8D']
  },
  offsetY: -24
},
};
var chart = new ApexCharts(document.querySelector("#siteTraffic"), options);
chart.render();
/*  / site traffic */