<?php
    $allProjs = get_posts([
        "post_type" => "project",
        "posts_per_page" => -1,
        "post_status" => "publish"
    ]);
    $allDataForMap = [];

    if($allProjs && is_array($allProjs) && !empty($allProjs)) {
        foreach($allProjs as $proj) {
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
                    'lng' => get_field('project_lan', $proj->ID) ?? null,
                    'lat' => get_field('project_lat', $proj->ID) ?? null,
                    'status' => [
                        'name' => $status_name,
                        'color' => $status_color,
                    ]
                ]
            );
        }
        
    }
?>

<script>
    window.mapPoints = JSON.parse('<?= json_encode($allDataForMap, true); ?>');
</script>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
<div id="map" class="project_map_placeholder w-100"></div>
 
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
 
<style>
    .leaflet-marker-icon {
        background-color: transparent;
        border: none;
    }
</style>

<script>
        const map = L.map('map')
            .setView([31.80468061893756, 35.21094143947052], 12);
 
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        })
        .addTo(map);
 
        const points = window.mapPoints;

        points.forEach((it) => {
            it.icon = L.divIcon({
                html: `
                    <div 
                        style="
                            background: ${it.status.color};
                            border-radius: 50%;
                            width: 24px;
                            height: 24px;
                            border: 2px solid #000;
                        ">
                    </div>
                `,
                iconSize: [24, 24],
                iconAnchor: [12, 12], 
            });
        });

        points.forEach((point) => {
            if (!point.lat || !point.lng) {
                return;
            }
            
            const marker = L.marker([point.lat, point.lng], {icon: point.icon}).addTo(map);

            marker.bindPopup(`
                <div style="
                    direction: rtl;
                    display: flex;
                    flex-flow: column nowrap;
                    align-items: flex-start;
                    background-color: transparent;
                ">
                    <b>${point.name}</b> 
                    
                    <hr/> 
                    
                    <small>${point.address}</small>
                </div>
            `);
        });

        setTimeout(() => {
            map.invalidateSize();
        }, 100);
</script>