<?php
    // $map_placeholder_image = get_field("map_placeholder_image") ?? null;
    $allProjs = get_posts([
        "post_type" => "project",
        "posts_per_page" => -1,
        // "paged" => $projects_page++,
        "post_status" => "publish"
    ]);
    $allDataForMap = [];
    if($allProjs && count($allProjs) > 0){
        foreach($allProjs as $proj){
            $project_status = get_field('project_status', $proj->ID);
            $status_color = null;
            $status_name = null;
            if($project_status){
                $status_color = get_field("project_status_color", $project_status);
                $status_name = $project_status->name;
            }
            array_push(
                $allDataForMap,
                [
                    'name' => $proj->post_title,
                    'address' => get_field('project_address', $proj->ID),
                    'lng' => get_field('project_lan', $proj->ID) ?? 31,
                    'lat' => get_field('project_lat', $proj->ID) ?? 35,
                    'status' => [
                        'name' => $status_name,
                        'color' => $status_color,
                    ]
                ]
            );
        }
        
    }
    // echo '<pre>';
    // print_r($allDataForMap);
    // print_r(get_fields($allProjs[0]));
    // echo '</pre>';
?>

<script>
    window.mapPoints = JSON.parse('<?= json_encode($allDataForMap, true); ?>');
</script>

<!-- <img src="<?= $map_placeholder_image; ?>" class="project_map_placeholder w-100"> -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
<!-- Create a div for the map -->
<div id="map" class="project_map_placeholder w-100"></div>
 
<!-- Include Leaflet.js -->
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
 
<script>
        // Initialize the map centered at a point (e.g., New York)
        var map = L.map('map').setView([31.80468061893756, 35.21094143947052], 12); // Coordinates for New York with zoom 12
 
        // Set the OpenStreetMap tile layer
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);
 
        // Array of multiple points (latitude, longitude, popup content)
        // var points = [
        //     {lat: 31.80468061893756, lng: 35.21094143947052, name: 'קבוצת בית ירושלמי (BY)'},
        //     {lat: 32.08504282072382, lng: 34.80386554418451, name: 'קבוצת בית ירושלמי (BY)'},
        //     // ,
        //     // { lat: 40.7484, lng: -73.9857, name: 'Empire State Building' },  // Empire State Building
        //     // { lat: 40.730610, lng: -73.935242, name: 'Brooklyn Bridge' },   // Brooklyn Bridge
        //     // { lat: 40.712776, lng: -74.005974, name: 'Statue of Liberty' }, // Statue of Liberty
        //     // { lat: 40.7580, lng: -73.9855, name: 'Times Square' }           // Times Square
        // ];
        var points = window.mapPoints;
        points.forEach((it) => {
            it.icon = L.divIcon({
                html: `<div style="background: ${it.status.color}; border-radius: 50%; width: 20px; height: 20px; border: 2px solid #000;"></div>`,
                iconSize: [24, 24], // adjust to your element's size
                iconAnchor: [12, 12], // anchor point at the center
            });
        });
        // console.log(points);
        // Loop through the points array and add a marker for each point
        points.forEach(function(point) {
        var marker = L.marker([point.lat, point.lng], {icon: point.icon}).addTo(map);
        marker.bindPopup("<b>" + point.name + "</b> <hr/> <small>" + point.address + "</small>");
        });
 
</script>