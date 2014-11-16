<script type="text/javascript">

var chart = AmCharts.makeChart("chartfunnel", {
"type": "funnel",
"theme": "none",
"dataProvider": [{"title": "Impressions","value":'210',"number":'74,765,068'},{"title": "Click","value":'200',"number":'771,836'},{"title": "Event","value":'150',"number":'19,260'}],
"balloon": {
"fixedPosition": true
},
"valueField": "value",
"titleField": "title",
"marginRight": 240,
"marginLeft": 50,
"startX": -500,
"depth3D":40,
"angle":40,
"color": ["#D50D00","#D65500","#02B11B"],
"outlineAlpha":1,
"labelText": "[[title]]: [[number]]",
"sequencedAnimation": false, 
"startDuration": 0,
"outlineColor":"#FFFFFF",
"outlineThickness":2,
"labelPosition": "right",
"balloonText": "[[title]]: [[number]]",
"exportConfig":{
"menuItems": [{
"icon": '/lib/3/images/export.png',
"format": 'png'
}]
}
}); 

</script>
