@extends('layouts.app')

@section('content')
    @include('layouts.components.nav')
    @include('layouts.components.main-menu')
    @include('layouts.components.right-slider')

    <style>
        .home-page {
            position: absolute;
            height: calc(100vh - var(--nav-height));
            width: calc(100vw - var(--menu-width));
            margin: var(--nav-height) 0 0 var(--menu-width);
            overflow: auto;
        }

        .home-page .container {
            background-image: repeating-linear-gradient(#282828 0%, #262626 45%, #242424 100%);
            position: relative;
            min-height: 100%;
            width: 100%;
            padding: 8px;
        }

        #svg-path {
            position: relative;
            overflow: hidden;
            height: 250px;
        }

        #card {
            position: absolute;
            background-color: white;
        }

        .card-1,
        .card-2,
        .card-3 {
            height: 250px;
            border-radius: 2px;
            background-color: #424242;
            /* border: 1px solid white; */
            box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;
            padding: 24px;
        }

        .card-1 .title,
        .card-2 .title,
        .card-3 .title {
            height: 10%;
            font-size: 24px;
            color: white;
        }

        .card-1 .icon,
        .card-2 .icon,
        .card-3 .icon {
            font-size: 30px;
            color: white;
            display: flex;
            justify-content: end;
            align-items: center;
        }

        .card-1 .icon i,
        .card-2 .icon i,
        .card-3 .icon i {
            background-color: #646464;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .card-1 .text,
        .card-2 .text,
        .card-3 .text {
            height: 50%;
            font-size: 42px;
            display: flex;
            align-items: flex-end;
            color: white;
        }

        .card-1 .text .category,
        .card-2 .text .category,
        .card-3 .text .category {
            font-size: 24px;
            color: #d1d1d1;
        }

        .card-1 .sub-text,
        .card-2 .sub-text,
        .card-3 .sub-text {
            display: flex;
            align-items: flex-end;
            height: 20%;
            font-size: 20px;
            color: #b3b3b3;
        }

        .card-1 .sub-text .up,
        .card-2 .sub-text .up,
        .card-3 .sub-text .up {
            color: rgb(47, 255, 47);
        }
    </style>
    <div class="home-page">
        <div class="container custome-responsive-container">
            <div class="c-xl-4 c-lg-6 c-md-12 pd-8">
                <div class="card-1 custome-responsive-container">
                    <div class="title c-xs-9">Transition</div>
                    <div class="icon c-xs-3"><i class="fa-solid fa-dollar-sign"></i></div>
                    <div class="text c-xs-12">3,180.00$</div>
                    <div class="sub-text c-xs-12">13%&nbsp<div class="up">Up</div>
                    </div>
                </div>
            </div>
            <div class="c-xl-4 c-lg-6 c-md-12 pd-8">
                <div class="card-2 custome-responsive-container">
                    <div class="title c-xs-9">New Task</div>
                    <div class="icon c-xs-3"><i class="fa-solid fa-dollar-sign"></i></div>
                    <div class="text c-xs-12">24&nbsp<div class="category">Tasks</div>
                    </div>
                    <div class="sub-text c-xs-12">Total task 51&nbsp<div class="up">Up</div>
                    </div>
                </div>

            </div>
            <div class="c-xl-4 c-lg-6 c-md-12 pd-8">
                <div class="card-3 custome-responsive-container">
                    <div class="title c-xs-9">Complete Task</div>
                    <div class="icon c-xs-3"><i class="fa-solid fa-dollar-sign"></i></div>
                    <div class="text c-xs-12">18&nbsp<div class="category">Tasks</div>
                    </div>
                    <div class="sub-text c-xs-12">13% &nbsp <div class="up">Up</div>
                    </div>
                </div>

            </div>
            <div class="c-xl-6 c-lg-6 c-md-12 pd-8">
                <section id="svg-path" class="">
                </section>
            </div>
            <div class="c-xl-6 c-lg-6 c-md-12 pd-8">
                <section id="svg-graph-line" class="">
                </section>
            </div>
        </div>
    </div>
    <script>
        window.addEventListener("load", () => {


            const data_path = [60, 20, 30, 50, 14, 22, 38, 54, 74, 98, 100, 120];
            const data_path_Hori = ["Jen", "Feb", "Mar", "Apr", "May", "Jun", "July", "Aug", "Sep", "Oct", "Nov",
                "Dec"
            ];
            const data_path_tower = [50,85,92,82,120,45,72];
            const data_path_Hori_tower = ["Mon", "Tue", "Wen", "Thu", "Fri", "Sat", "Sun"];

            const svg_graph_line_parent = document.querySelector("#svg-graph-line");
            const svg_path_parent = document.querySelector("#svg-path");

            function dataVisualization(svg_path_parent, arr, arr_h, line_count, title) {
                let init = () => {

                    const svg_elemment = document.createElementNS("http://www.w3.org/2000/svg", "svg");
                    const svg_path = document.createElementNS("http://www.w3.org/2000/svg", "path");
                    const days = arr.length;
                    const data_h_l = arr_h.length;
                    const max_val = Math.max(...arr);
                    svg_path_parent.innerHTML = '';
                    const height_container = svg_path_parent.offsetHeight;
                    const width_container = svg_path_parent.offsetWidth;
                    svg_path_parent.style.overflow = "hidden";
                    const graph_line = max_val / (line_count - 1);
                    const space_left = 80;
                    const space_right = 20;
                    const space_bottom = 30;
                    const space_top = 30;
                    const freq = (svg_path_parent.offsetWidth - space_right - space_left) / (arr.length - 1);
                    const width_svg = days * freq;
                    const Height_svg = max_val + 30 + space_top;
                    let svg_width = width_container < (width_svg + space_left + space_right) ? (width_svg +
                        space_left +
                        space_right) : width_container;
                    svg_elemment.setAttributeNS(null, "width", svg_width);

                    let svg_height = height_container < Height_svg + space_bottom + space_top ? (Height_svg +
                        space_bottom + space_top) : height_container;
                    svg_elemment.setAttributeNS(null, "height", svg_height);
                    // g tag for grouping other tags 

                    const s_card = document.createElement("section");
                    s_card.id = "graph-card";
                    s_card.style = "position:absolute; background-color:white";
                    const g_element_circle = document.createElementNS("http://www.w3.org/2000/svg", "g");
                    g_element_circle.id = "graph-circle";
                    const g_element_line = document.createElementNS("http://www.w3.org/2000/svg", "g");
                    g_element_line.id = "graph-lines";
                    const g_element_text = document.createElementNS("http://www.w3.org/2000/svg", "g");
                    g_element_text.id = "graph-text"
                    const g_horizontal_element_text = document.createElementNS("http://www.w3.org/2000/svg",
                        "g");
                    g_horizontal_element_text.id = "graph-text-horizontal"
                    const g_header_element_text = document.createElementNS("http://www.w3.org/2000/svg", "g");
                    g_header_element_text.id = "graph-text-header"
                    // base line
                    let path_string = "M" + ((days - 1) * freq + space_left) + " " + Height_svg + "L" +
                        space_left +
                        " " + Height_svg;
                    for (let d = 0; d < days; d++) {
                        const y_value = Height_svg - arr[d],
                            x_value = d * freq + space_left;
                        const new_string = " L" + x_value + " " + y_value;
                        path_string += new_string;

                        const element_circle = document.createElementNS("http://www.w3.org/2000/svg", "circle");
                        element_circle.setAttributeNS(null, "cx", x_value);
                        element_circle.setAttributeNS(null, "cy", y_value);
                        element_circle.setAttributeNS(null, "r", "8");
                        element_circle.addEventListener("mouseover", (e) => {
                            s_card.style.top = y_value + "px";
                            s_card.style.left = x_value - 75 + "px";
                            s_card.style.display = "block";
                            const date_ = new Date(Date.now() - ((days - d) * (24 * 60 * 60 * 1000)))
                                .toJSON()
                                .split("T")[0];
                            s_card.innerHTML = `view: ${arr[d]} <br> Date: ${date_}`;
                        });
                        element_circle.setAttributeNS(null, "style",
                            "stroke:rgba(47,165,203); stroke-width:2px; fill:rgba(47,165,203,0.5)");

                        g_element_circle.appendChild(element_circle);
                    }
                    const end = Height_svg - arr[days - 1];
                    path_string += " L" + (((days - 1) * freq) + space_left) + " " + end;
                    path_string += " Z";
                    svg_path.setAttributeNS(null, "d", path_string);
                    svg_path.setAttributeNS(null, "style",
                        "fill:rgba(47,165,203,0.1);stroke-width:2.5;stroke:rgb(47,165,203);");


                    for (let l = 0; l < line_count; l++) {
                        const element_line = document.createElementNS("http://www.w3.org/2000/svg", "line");
                        const element_text = document.createElementNS("http://www.w3.org/2000/svg", "text");
                        const y_position = Height_svg - (l * graph_line)
                        element_line.setAttributeNS(null, "x1", space_left - 10);
                        element_line.setAttributeNS(null, "y1", y_position);
                        element_line.setAttributeNS(null, "x2", (width_svg + space_left));
                        element_line.setAttributeNS(null, "y2", y_position);
                        g_element_line.appendChild(element_line)
                        g_element_line.setAttributeNS(null, "style", "stroke:rgba(47,165,203,0.5);");
                        const txt = parseInt(l * graph_line);
                        // element_text.setAttributeNS(null, "dx", "-30");
                        element_text.setAttributeNS(null, "x", space_left - 15);
                        element_text.setAttributeNS(null, "y", y_position);
                        element_text.setAttributeNS(null, "style", "fill:white");
                        element_text.setAttributeNS(null, "text-anchor", "end");

                        element_text.textContent = txt;

                        g_element_text.appendChild(element_text);
                    }

                    for (let l = 0; l < data_h_l; l++) {
                        const horizontal_element_text = document.createElementNS("http://www.w3.org/2000/svg",
                            "text");
                        const y_position = Height_svg - (l * graph_line)
                        const txt = parseInt(l * graph_line);
                        // element_text.setAttributeNS(null, "dx", "-30");


                        const y_h_value = Height_svg - arr[l],
                            x_h_value = l * freq + space_left;
                        horizontal_element_text.setAttributeNS(null, "x", x_h_value);
                        horizontal_element_text.setAttributeNS(null, "y", Height_svg + space_bottom - 8);
                        horizontal_element_text.setAttributeNS(null, "style", "fill:white;");
                        horizontal_element_text.setAttributeNS(null, "text-anchor", "middle");

                        horizontal_element_text.textContent = arr_h[l];

                        g_horizontal_element_text.appendChild(horizontal_element_text);

                    }

                    const element_text_header = document.createElementNS("http://www.w3.org/2000/svg", "text");
                    element_text_header.setAttributeNS(null, "x", 0);
                    element_text_header.setAttributeNS(null, "y", space_top - 5);
                    element_text_header.setAttributeNS(null, "style", "fill:white;  font-size:20px;");
                    // element_text_header.setAttributeNS(null, "text-anchor", "middle");
                    element_text_header.textContent = title;
                    g_header_element_text.appendChild(element_text_header);

                    svg_elemment.appendChild(svg_path);
                    svg_elemment.appendChild(g_element_line);
                    svg_elemment.appendChild(g_element_text);
                    svg_elemment.appendChild(g_horizontal_element_text);
                    svg_elemment.appendChild(g_header_element_text);
                    svg_elemment.appendChild(g_element_circle);

                    // base parent or graph
                    svg_path_parent.appendChild(s_card);
                    svg_path_parent.appendChild(svg_elemment);
                }
                init();
                let myTimeout = null;
                window.addEventListener("resize", () => {
                    clearTimeout(myTimeout);
                    myTimeout = setTimeout(() => {
                        init();
                    }, 1000);
                });
            }

            function graphLine(svg_path_parent, arr, arr_h, line_count, title) {

                let init = () => {
                    let svg_elemment = document.createElementNS("http://www.w3.org/2000/svg", "svg");
                    let svg_path = document.createElementNS("http://www.w3.org/2000/svg", "path");
                    let days = arr.length;
                    let data_h_l = arr_h.length;
                    let max_val = Math.max(...arr);
                    svg_path_parent.innerHTML = '';
                    svg_path_parent.style.position = "relative";
                    svg_path_parent.style.overflow = "hidden";
                    let height_container = svg_path_parent.offsetHeight;
                    let width_container = svg_path_parent.offsetWidth;
                    let graph_line = max_val / (line_count - 1);
                    let space_left = 80;
                    let space_right = 20;
                    let space_bottom = 30;
                    let space_top = 30;
                    let freq = ((svg_path_parent.offsetWidth - space_right - space_left) >= 0 ? (svg_path_parent
                        .offsetWidth - space_right - space_left) : 0) / (arr.length);
                    let width_svg = days * freq;
                    let Height_svg = max_val + 30 + space_top;
                    let svg_width = width_container < (width_svg + space_left + space_right) ? (width_svg +
                        space_left +
                        space_right) : width_container;
                    svg_elemment.setAttributeNS(null, "width", svg_width);

                    let svg_height = height_container < Height_svg + space_bottom + space_top ? (Height_svg +
                        space_bottom + space_top) : height_container;
                    svg_elemment.setAttributeNS(null, "height", svg_height);
                    // g tag for grouping other tags 

                    let s_card = document.createElement("section");
                    s_card.id = "graph-card";
                    s_card.style = "position:absolute; color:white";
                    let g_element_rectangle = document.createElementNS("http://www.w3.org/2000/svg", "g");
                    g_element_rectangle.id = "graph-circle";
                    let g_element_line = document.createElementNS("http://www.w3.org/2000/svg", "g");
                    g_element_line.id = "graph-lines";
                    let g_element_text = document.createElementNS("http://www.w3.org/2000/svg", "g");
                    g_element_text.id = "graph-text"
                    let g_horizontal_element_text = document.createElementNS("http://www.w3.org/2000/svg", "g");
                    g_horizontal_element_text.id = "graph-text-horizontal"
                    let g_header_element_text = document.createElementNS("http://www.w3.org/2000/svg", "g");
                    g_header_element_text.id = "graph-text-header"
                    // base line
                    // let path_string = "M" + ((days - 1) * freq + space_left) + " " + Height_svg + "L" + space_left +
                    //     " " + Height_svg;
                    let path_string = "";
                    for (let d = 0; d < days; d++) {
                        let y_value = Height_svg - arr[d],
                            x_value = d * freq + space_left;
                        let new_string = " M" + x_value + " " + y_value + " L" + (x_value + parseInt(freq /
                                2)) + " " +
                            y_value + " L" + (x_value + parseInt(freq / 2)) + " " + Height_svg + " L" +
                            x_value + " " +
                            Height_svg + "Z";
                        path_string += new_string;

                        let element_rectangle = document.createElementNS("http://www.w3.org/2000/svg", "rect");
                        element_rectangle.setAttributeNS(null, "x", x_value);
                        element_rectangle.setAttributeNS(null, "y", y_value);
                        element_rectangle.setAttributeNS(null, "width", parseInt(freq / 2));
                        element_rectangle.setAttributeNS(null, "height", Height_svg - y_value);
                        element_rectangle.addEventListener("mouseover", (e) => {
                            s_card.style.top = y_value - 30 + "px";
                            s_card.style.left = x_value + "px";
                            s_card.style.display = "block";
                            s_card.innerHTML = `${arr[d]}`;
                        });
                        element_rectangle.setAttributeNS(null, "style",
                            "stroke:rgba(47,165,203); stroke-width:2px; fill:rgba(47,165,203,0.5);");

                        g_element_rectangle.appendChild(element_rectangle);
                    }
                    let end = Height_svg - arr[days - 1];
                    path_string += " L" + (((days - 1) * freq) + space_left) + " " + end;
                    path_string += " Z";
                    svg_path.setAttributeNS(null, "d", path_string);
                    svg_path.setAttributeNS(null, "style",
                        "fill:rgba(47,165,203);");


                    for (let l = 0; l < line_count; l++) {
                        let element_line = document.createElementNS("http://www.w3.org/2000/svg", "line");
                        let element_text = document.createElementNS("http://www.w3.org/2000/svg", "text");
                        let y_position = Height_svg - (l * graph_line)
                        element_line.setAttributeNS(null, "x1", space_left - 10);
                        element_line.setAttributeNS(null, "y1", y_position);
                        element_line.setAttributeNS(null, "x2", (width_svg + space_left));
                        element_line.setAttributeNS(null, "y2", y_position);
                        g_element_line.appendChild(element_line)
                        g_element_line.setAttributeNS(null, "style", "stroke:rgba(47,165,203,0.5);");
                        let txt = parseInt(l * graph_line);
                        // element_text.setAttributeNS(null, "dx", "-30");
                        element_text.setAttributeNS(null, "x", space_left - 15);
                        element_text.setAttributeNS(null, "y", y_position);
                        element_text.setAttributeNS(null, "style", "fill:white");
                        element_text.setAttributeNS(null, "text-anchor", "end");

                        element_text.textContent = txt;

                        g_element_text.appendChild(element_text);
                    }

                    for (let l = 0; l < data_h_l; l++) {
                        let horizontal_element_text = document.createElementNS("http://www.w3.org/2000/svg",
                            "text");
                        let y_position = Height_svg - (l * graph_line)
                        let txt = parseInt(l * graph_line);
                        // element_text.setAttributeNS(null, "dx", "-30");


                        let y_h_value = Height_svg - arr[l],
                            x_h_value = l * freq + space_left;
                        horizontal_element_text.setAttributeNS(null, "x", x_h_value);
                        horizontal_element_text.setAttributeNS(null, "y", Height_svg + space_bottom - 8);
                        horizontal_element_text.setAttributeNS(null, "style", "fill:white;");
                        // horizontal_element_text.setAttributeNS(null, "text-anchor", "middle");

                        horizontal_element_text.textContent = arr_h[l];

                        g_horizontal_element_text.appendChild(horizontal_element_text);

                    }

                    let element_text_header = document.createElementNS("http://www.w3.org/2000/svg", "text");
                    element_text_header.setAttributeNS(null, "x", 0);
                    element_text_header.setAttributeNS(null, "y", space_top - 5);
                    element_text_header.setAttributeNS(null, "style", "fill:white;  font-size:20px;");
                    // element_text_header.setAttributeNS(null, "text-anchor", "middle");
                    element_text_header.textContent = title;
                    g_header_element_text.appendChild(element_text_header);

                    svg_elemment.appendChild(svg_path);
                    svg_elemment.appendChild(g_element_line);
                    svg_elemment.appendChild(g_element_text);
                    svg_elemment.appendChild(g_horizontal_element_text);
                    svg_elemment.appendChild(g_header_element_text);
                    svg_elemment.appendChild(g_element_rectangle);

                    // base parent or graph
                    svg_path_parent.appendChild(s_card);
                    svg_path_parent.appendChild(svg_elemment);
                }
                init();

                let myTimeout = null;
                window.addEventListener("resize", () => {
                    clearTimeout(myTimeout);
                    myTimeout = setTimeout(() => {
                        init();
                    }, 1000);
                });
            }

            graphLine(svg_graph_line_parent, data_path_tower, data_path_Hori_tower, 4, "Site Vistor");
            dataVisualization(svg_path_parent, data_path, data_path_Hori, 4, "Task Flow");
        })
    </script>
@endsection
