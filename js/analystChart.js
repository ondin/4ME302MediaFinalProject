d3.text('http://ondindavid.dk/FinalProjectBitacora/logs/veh17_EngineWaterTemp.php', function(text){

    var data = d3.csv.parseRows(text);

    draw(data);
});

d3.text('http://ondindavid.dk/FinalProjectBitacora/logs/veh17_Hydrualoljetemp.php', function(text){

    var data = d3.csv.parseRows(text);

    draw2(data);
});

d3.text('http://ondindavid.dk/FinalProjectBitacora/logs/veh17_Transmission_conv_temp.php', function(text){

    var data = d3.csv.parseRows(text);

    draw3(data);
});

d3.text('http://ondindavid.dk/FinalProjectBitacora/logs/veh17_Transmission_sump_temp.php', function(text){

    var data = d3.csv.parseRows(text);

    draw4(data);
});

function draw (data){

    var width = 300;
    var height = data.length;

    var wScale = d3.scale.linear()
        .domain([0, 100])
        .range([0,width]);

    var axis = d3.svg.axis()
        .ticks(10)
        .scale(wScale);

    var canvas = d3.select("#veh17_EngineWaterTemp")
        .attr("width", width)
        .attr("height", height)
        .append("g")
        .attr("transform", "translate(10, 10)");

    var bars = canvas.selectAll("rect")
        .data(data)
        .enter()
            .append("rect")
            .attr("width", function (data){for(var i= 1; i<=data.length; i++){return wScale(data[i][1]*8)}})
            .attr("height", 2)
            .attr("fill", "black")
            .attr("y", function (d, i){return i*3})
            .attr("transform", "translate(0, 50)");

    canvas.append("g")
        .attr("transform", "translate(0, 10)")
        .call(axis);
}

function draw2 (data){

    var width = 300;
    var height = data.length;


    var wScale = d3.scale.linear()
        .domain([0, 100])
        .range([0,width]);

    var axis = d3.svg.axis()
        .ticks(15)
        .scale(wScale);

    var canvas = d3.select("#veh17_Hydrualoljetemp")
        .attr("width", width)
        .attr("height", height)
        .append("g")
        .attr("transform", "translate(10, 10)");

    var bars = canvas.selectAll("rect")
        .data(data)
        .enter()
            .append("rect")
            .attr("width", function (data){for(var i= 1; i<=data.length; i++){return wScale(data[i][1])*8}})
            .attr("height", 2)
            .attr("fill", "red")
            .attr("y", function(d, i){return i*3})
            .attr("transform", "translate(0, 50)");

    canvas.append("g")
        .attr("transform", "translate(0, 10)")
        .call(axis);

}




function draw3 (data){

    var width = 300;
    var height = data.length;

    var wScale = d3.scale.linear()
        .domain([0, 100])
        .range([0,width]);

    var axis = d3.svg.axis()
        .ticks(10)
        .scale(wScale);

    var canvas = d3.select("#veh17_Transmission_conv_temp")
        .attr("width", width)
        .attr("height", height)
        .append("g")
        .attr("transform", "translate(10, 10)");

    var bars = canvas.selectAll("rect")
        .data(data)
        .enter()
        .append("rect")
        .attr("width", function (data){for(var i= 1; i<=data.length; i++){return wScale(data[i][1]*8)}})
        .attr("height", 2)
        .attr("fill", "green")
        .attr("y", function (d, i){return i*3})
        .attr("transform", "translate(0, 50)");

    canvas.append("g")
        .attr("transform", "translate(0, 10)")
        .call(axis);
}

function draw4 (data){

    var width = 300;
    var height = data.length;


    var wScale = d3.scale.linear()
        .domain([0, 100])
        .range([0,width]);

    var axis = d3.svg.axis()
        .ticks(15)
        .scale(wScale);

    var canvas = d3.select("#veh17_Transmission_sump_temp")
        .attr("width", width)
        .attr("height", height)
        .append("g")
        .attr("transform", "translate(10, 10)");

    var bars = canvas.selectAll("rect")
        .data(data)
        .enter()
        .append("rect")
        .attr("width", function (data){for(var i= 1; i<=data.length; i++){return wScale(data[i][1])*8}})
        .attr("height", 2)
        .attr("fill", "blue")
        .attr("y", function(d, i){return i*3})
        .attr("transform", "translate(0, 50)");

    canvas.append("g")
        .attr("transform", "translate(0, 10)")
        .call(axis);

}