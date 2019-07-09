var s; // private alias to settings
    var entityWidth = 130;
    var entityHeight = 65;
    var sceneWidth = 1000;
    var sceneHeight = 600;
    var dropzoneWidth = 650;
    
    function initD3() {
        
        var drag = d3.behavior.drag()
                    .origin(function (d) { return d; })
                    .on("dragstart", dragstarted)
                    .on("drag", dragged)
                    .on("dragend", dragended);

        //Create the responsive svg
        var svg = d3.select("#svg")
                    .append("div")
                    .classed("svg-container", true) //container class to make it responsive
                    .append("svg")
                    //responsive SVG needs these 2 attributes and no width and height attr
                    .attr("preserveAspectRatio", "xMinYMin meet")
                    .attr("viewBox", "0 0 " + sceneWidth + " " + sceneHeight)
                    //class to make it responsive
                    .classed("svg-content-responsive", true);

        //Create the scene
        var line = svg.selectAll("line")
                     .data([{ x1: dropzoneWidth, y1: 0, x2: dropzoneWidth, y2: sceneHeight }])
                     .enter()
                     .append("line")
                     .attr("x1", function (d) { return d.x1; })
                     .attr("x2", function (d) { return d.x2; })
                     .attr("y1", function (d) { return d.y1; })
                     .attr("y2", function (d) { return d.y2; })
                     .attr("stroke", "grey")
                     .attr("stroke-width", 2)
                     .attr("stroke-dasharray", "5,5");
        
        var rects = svg.selectAll("rect")
                      .data([{ class: "dropzone", x: 0, y: 0, width: dropzoneWidth, height: sceneHeight },
                             { class: "startzone", x: dropzoneWidth, y: 0, width: sceneWidth - dropzoneWidth, height: sceneHeight }])
                     .enter()
                     .append("rect")
                     .attr("x", function (d) { return d.x; })
                     .attr("width", function (d) { return d.width; })
                     .attr("y", function (d) { return d.y; })
                     .attr("height", function (d) { return d.height; })
                     .attr("class", function (d) { return d.class; })
                     .attr("fill", "none")

        entities = svg.selectAll("g")
                      .data([{ x: 750, y: 100 }])
                      .enter()
                      .append("g")
                      .attr("class","entity-group")
                      .attr("transform", function (d) { return "translate(" + d.x + "," + d.y + ")"; })
                      .attr("initial-x", function (d) { return d.x })
                      .attr("initial-y", function (d) { return d.y })
                      .call(drag);

        entities.append("rect")
                .attr("x", function (d) { return 0; })
                .attr("width", function (d) { return entityWidth; })
                .attr("y", function (d) { return 0; })
                .attr("height", function (d) { return entityHeight; })
                .attr("class", "entity" )
                .attr("fill", "white")
                .attr("stroke", "blue")
                .attr("stroke-width", 2)
                .attr("rx", 4)
                .attr("ry", 4)

        
        entities.append("text")
                .attr("x", function (d) { return entityWidth / 2 - 18; })
                .attr("y", function (d) { return entityHeight / 2 + 5; })
                .text(function (d) { return "Test"; })
                .attr("class", "association-label" )
                .attr("font-family", "sans-serif")
                .attr("font-size", "18px")
                .attr("fill", "black");
    }
    
    var inbox = [0,0];
    function dragstarted(d) {
        d3.event.sourceEvent.stopPropagation();
        inBox = d3.mouse(this);
    }

    function dragged(d) {
        var inParent = d3.mouse(this.parentNode);
        d.x = inParent[0] - inBox[0];
        d.y = inParent[1] - inBox[1];

        d3.select(this)
           .attr("transform", function (d) { return "translate(" + d.x + "," + d.y + ")" });
    }

    function dragended(d) {
    		inbox = [0,0];
    
        d3.select(this)
          .classed("dragging", false);
        
        if (d.x > dropzoneWidth) {
            var entity = d3.select(this);
            var x = entity.attr("initial-x");
            var y = entity.attr("initial-y");

            entity.attr("transform", function (d) { return "translate(" + x + "," + y + ")"; });
        }
    }
    initD3()// JavaScript Document