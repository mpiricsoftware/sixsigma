(function(){//!YOUR_MAPBOX_ACCESS_TOKEN_HERE!
mapboxgl.accessToken="";const o={type:"FeatureCollection",features:[{type:"Feature",properties:{iconSize:[20,42],message:"1"},geometry:{type:"Point",coordinates:[-73.999024,40.75249842]}},{type:"Feature",properties:{iconSize:[20,42],message:"2"},geometry:{type:"Point",coordinates:[-74.03,40.75699842]}},{type:"Feature",properties:{iconSize:[20,42],message:"3"},geometry:{type:"Point",coordinates:[-73.967524,40.7599842]}},{type:"Feature",properties:{iconSize:[20,42],message:"4"},geometry:{type:"Point",coordinates:[-74.0325,40.742992]}}]},s=new mapboxgl.Map({container:"map",style:"mapbox://styles/mapbox/light-v9",center:[-73.999024,40.75249842],zoom:12.25});for(const e of o.features){const t=document.createElement("div"),l=e.properties.iconSize[0],p=e.properties.iconSize[1];t.className="marker",t.insertAdjacentHTML("afterbegin",'<img src="'+assetsPath+'img/illustrations/fleet-car.png" alt="Fleet Car" width="20" class="rounded-3" id="carFleet-'+e.properties.message+'">'),t.style.width=`${l}px`,t.style.height=`${p}px`,t.style.cursor="pointer",new mapboxgl.Marker(t).setLngLat(e.geometry.coordinates).addTo(s);const a=document.getElementById("fl-"+e.properties.message),n=document.getElementById("carFleet-"+e.properties.message);a.addEventListener("click",function(){const c=document.querySelector(".marker-focus");Helpers._hasClass("active",a)?(s.flyTo({center:o.features[e.properties.message-1].geometry.coordinates,zoom:16}),c&&Helpers._removeClass("marker-focus",c),Helpers._addClass("marker-focus",n)):Helpers._removeClass("marker-focus",n)})}const i=document.getElementById("carFleet-1");Helpers._addClass("marker-focus",i),document.querySelector(".mapboxgl-control-container").classList.add("d-none");var r=$(".logistics-fleet-sidebar-body");r.length&&new PerfectScrollbar(r[0],{wheelPropagation:!1,suppressScrollX:!0})})();