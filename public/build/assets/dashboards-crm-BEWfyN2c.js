(function(){let a,c,s,i,d,p,h;isDarkStyle?(a=config.colors_dark.cardColor,c=config.colors_dark.textMuted,s=config.colors_dark.headingColor,i=config.colors_dark.borderColor,d=config.colors_dark.bodyColor,p="#3b3e59",h=config.colors_dark.bodyColor):(a=config.colors.cardColor,c=config.colors.textMuted,s=config.colors.headingColor,i=config.colors.borderColor,d=config.colors.bodyColor,p="#f4f4f6",h=config.colors.bodyColor);const l={donut:{series1:config.colors.warning,series2:"#fdb528cc",series3:"#fdb52899",series4:"#fdb52866",series5:config.colors_label.warning}},u=document.querySelector("#totalProfitChart"),S={chart:{type:"bar",height:100,parentHeightOffset:0,stacked:!0,toolbar:{show:!1}},series:[{name:"PRODUCT A",data:[44,21,56,34,47]},{name:"PRODUCT B",data:[-27,-17,-31,-23,-31]}],plotOptions:{bar:{horizontal:!1,columnWidth:"28%",borderRadius:5,startingShape:"rounded",endingShape:"rounded"}},dataLabels:{enabled:!1},tooltip:{enabled:!1},stroke:{curve:"smooth",width:1,lineCap:"round",colors:[a]},legend:{show:!1},colors:[config.colors.headingColor,config.colors.danger],grid:{show:!1,padding:{top:-21,right:0,left:0,bottom:-16}},xaxis:{categories:["Mon","Tue","Wed","Thu","Fri","Sat","Sun"],labels:{show:!1},axisBorder:{show:!1},axisTicks:{show:!1}},yaxis:{show:!1},states:{hover:{filter:{type:"none"}},active:{filter:{type:"none"}}},responsive:[{breakpoint:1440,options:{plotOptions:{bar:{columnWidth:"38%"}}}},{breakpoint:1200,options:{chart:{height:150}}},{breakpoint:992,options:{chart:{height:100},plotOptions:{bar:{columnWidth:"28%"}}}}]};typeof u!==void 0&&u!==null&&new ApexCharts(u,S).render();const g=document.querySelector("#totalGrowthChart"),O={chart:{height:127,parentHeightOffset:0,type:"donut"},labels:[`${new Date().getFullYear()}`,`${new Date().getFullYear()-1}`,`${new Date().getFullYear()-2}`],series:[35,30,23],colors:[config.colors.primary,config.colors.success,config.colors.secondary],stroke:{width:5,colors:a},tooltip:{y:{formatter:function(e,r){return parseInt(e)+"%"}}},dataLabels:{enabled:!1,formatter:function(e,r){return parseInt(e)+"%"}},states:{hover:{filter:{type:"none"}},active:{filter:{type:"none"}}},legend:{show:!1},plotOptions:{pie:{donut:{size:"70%",labels:{show:!0,value:{fontSize:"1rem",fontFamily:"Inter",color:s,fontWeight:500,offsetY:4,formatter:function(e){return parseInt(e)+"%"}},name:{show:!1},total:{label:"",show:!0,fontSize:"1.5rem",fontWeight:500,formatter:function(e){return"12%"}}}}}}};typeof g!==void 0&&g!==null&&new ApexCharts(g,O).render();const m=document.querySelector("#organicSessionsChart"),D={chart:{height:330,type:"donut",parentHeightOffset:0,offsetY:0},labels:["USA","India","Canada","Japan","France"],tooltip:{enabled:!1},dataLabels:{enabled:!1},stroke:{width:3,lineCap:"round",colors:[a]},states:{hover:{filter:{type:"none"}},active:{filter:{type:"none"}}},plotOptions:{pie:{endAngle:130,startAngle:-130,customScale:.9,donut:{size:"83%",labels:{show:!0,name:{offsetY:25,fontSize:"50rem",fontFamily:"Inter",color:d},value:{offsetY:-15,fontWeight:500,fontSize:"1.75rem",fontFamily:"Inter",color:s,formatter:function(e){return parseInt(e)+"K"}},total:{show:!0,label:"2022",fontSize:"0.9375rem",fontFamily:"Inter",color:d,formatter:function(e){return"89K"}}}}}},series:[13,18,18,24,16],tooltip:{enabled:!1},legend:{position:"bottom",fontFamily:"Inter",fontSize:"15px",markers:{offsetX:-3,height:10,width:10},itemMargin:{horizontal:24,vertical:8},offsetY:-10,labels:{colors:s}},colors:[l.donut.series1,l.donut.series2,l.donut.series3,l.donut.series4,l.donut.series5]};typeof m!==void 0&&m!==null&&new ApexCharts(m,D).render();const b=document.querySelector("#projectTimelineChart"),T=["Development Apps","UI Design","IOS Application","Web App Wireframing","Prototyping"],W=["Development","UI Design","Application","App Wireframing","Prototyping"],F={chart:{height:240,type:"rangeBar",parentHeightOffset:0,toolbar:{show:!1}},series:[{data:[{x:"Catherine",y:[new Date(`${new Date().getFullYear()}-01-01`).getTime(),new Date(`${new Date().getFullYear()}-05-02`).getTime()],fillColor:config.colors.primary},{x:"Janelle",y:[new Date(`${new Date().getFullYear()}-02-18`).getTime(),new Date(`${new Date().getFullYear()}-05-30`).getTime()],fillColor:config.colors.success},{x:"Wellington",y:[new Date(`${new Date().getFullYear()}-02-07`).getTime(),new Date(`${new Date().getFullYear()}-05-31`).getTime()],fillColor:config.colors.secondary},{x:"Blake",y:[new Date(`${new Date().getFullYear()}-01-14`).getTime(),new Date(`${new Date().getFullYear()}-06-30`).getTime()],fillColor:config.colors.info},{x:"Quinn",y:[new Date(`${new Date().getFullYear()}-04-01`).getTime(),new Date(`${new Date().getFullYear()}-07-31`).getTime()],fillColor:config.colors.warning}]}],tooltip:{enabled:!1},plotOptions:{bar:{horizontal:!0,borderRadius:15,distributed:!0,endingShape:"rounded",startingShape:"rounded",dataLabels:{hideOverflowingLabels:!1}}},stroke:{width:2,colors:[a]},dataLabels:{enabled:!0,style:{fontWeight:400,fontFamily:"Inter",fontSize:"13px"},formatter:function(e,r){return T[r.dataPointIndex]}},states:{hover:{filter:{type:"none"}},active:{filter:{type:"none"}}},legend:{show:!1},grid:{strokeDashArray:6,borderColor:i,xaxis:{lines:{show:!0}},yaxis:{lines:{show:!1}},padding:{top:-32,left:15,right:18,bottom:4}},xaxis:{type:"datetime",axisTicks:{show:!1},axisBorder:{show:!1},labels:{style:{colors:c,fontFamily:"Inter",fontSize:"13px"},datetimeFormatter:{year:"MMM",month:"MMM"}}},yaxis:{labels:{show:!0,align:"left",style:{fontFamily:"Inter",fontSize:"13px",colors:h}}},responsive:[{breakpoint:446,options:{dataLabels:{formatter:function(e,r){return W[r.dataPointIndex]}}}}]};typeof b!==void 0&&b!==null&&new ApexCharts(b,F).render();const y=document.querySelector("#weeklyOverviewChart"),A={chart:{type:"line",height:180,offsetY:-9,offsetX:-16,parentHeightOffset:0,toolbar:{show:!1}},series:[{name:"Sales",type:"column",data:[83,68,56,65,65,50,39]},{name:"Sales",type:"line",data:[63,38,31,45,46,27,18]}],plotOptions:{bar:{borderRadius:9,columnWidth:"35%",endingShape:"rounded",startingShape:"rounded",colors:{ranges:[{to:50,from:40,color:config.colors.primary}]}}},markers:{size:3.5,strokeWidth:2,fillOpacity:1,strokeOpacity:1,colors:[a],strokeColors:config.colors.primary},stroke:{width:[0,2],colors:[config.colors.primary]},dataLabels:{enabled:!1},legend:{show:!1},colors:[p],grid:{strokeDashArray:10,borderColor:i,padding:{bottom:-10}},xaxis:{categories:["Mon","Tue","Wed","Thu","Fri","Sat","Sun"],tickPlacement:"on",labels:{show:!1},axisBorder:{show:!1},axisTicks:{show:!1}},yaxis:{min:0,max:90,show:!0,tickAmount:3,labels:{formatter:function(e){return parseInt(e)+"K"},style:{fontSize:"13px",fontFamily:"Inter",colors:c}}},states:{hover:{filter:{type:"none"}},active:{filter:{type:"none"}}},responsive:[{breakpoint:1462,options:{plotOptions:{bar:{columnWidth:"40%"}}}},{breakpoint:1388,options:{plotOptions:{bar:{columnWidth:"45%",borderRadius:8}}}},{breakpoint:1030,options:{plotOptions:{bar:{columnWidth:"48%"}}}},{breakpoint:992,options:{plotOptions:{bar:{columnWidth:"28%"}}}},{breakpoint:874,options:{plotOptions:{bar:{columnWidth:"38%"}}}},{breakpoint:768,options:{plotOptions:{bar:{columnWidth:"28%",borderRadius:10}}}},{breakpoint:500,options:{plotOptions:{bar:{borderRadius:7}}}},{breakpoint:393,options:{plotOptions:{bar:{borderRadius:6}}}}]};typeof y!==void 0&&y!==null&&new ApexCharts(y,A).render();const w=document.querySelector("#monthlyBudgetChart"),I={chart:{height:235,type:"area",parentHeightOffset:0,offsetY:-8,toolbar:{show:!1}},tooltip:{enabled:!1},dataLabels:{enabled:!1},stroke:{width:5,curve:"smooth"},series:[{data:[0,85,25,125,90,250,200,350]}],grid:{show:!1,padding:{left:10,top:0,right:12}},fill:{type:"gradient",gradient:{opacityTo:.7,opacityFrom:.5,shadeIntensity:1,stops:[0,90,100],colorStops:[[{offset:0,opacity:.6,color:config.colors.success},{offset:100,opacity:.1,color:a}]]}},theme:{monochrome:{enabled:!0,shadeTo:"light",shadeIntensity:1,color:config.colors.success}},xaxis:{type:"numeric",labels:{show:!1},axisTicks:{show:!1},axisBorder:{show:!1}},yaxis:{show:!1},markers:{size:1,offsetY:1,offsetX:-5,strokeWidth:4,strokeOpacity:1,colors:["transparent"],strokeColors:"transparent",discrete:[{size:7,seriesIndex:0,dataPointIndex:7,strokeColor:config.colors.success,fillColor:a}]},responsive:[{breakpoint:1200,options:{chart:{height:255}}},{breakpoint:992,options:{chart:{height:300}}},{breakpoint:768,options:{chart:{height:240}}}]};typeof w!==void 0&&w!==null&&new ApexCharts(w,I).render();const C=document.querySelector("#externalLinksChart"),Y={chart:{type:"bar",height:330,parentHeightOffset:0,stacked:!0,toolbar:{show:!1}},series:[{name:"Google Analytics",data:[155,135,320,100,150,335,160]},{name:"Facebook Ads",data:[110,235,125,230,215,115,200]}],plotOptions:{bar:{horizontal:!1,columnWidth:"40%",borderRadius:10,startingShape:"rounded",endingShape:"rounded"}},dataLabels:{enabled:!1},tooltip:{enabled:!1},stroke:{curve:"smooth",width:6,lineCap:"round",colors:[a]},legend:{show:!1},colors:[config.colors.primary,config.colors.secondary],grid:{strokeDashArray:10,borderColor:i,padding:{top:-12,left:-4,right:-5,bottom:5}},xaxis:{categories:["Mon","Tue","Wed","Thu","Fri","Sat","Sun"],labels:{show:!1},axisBorder:{show:!1},axisTicks:{show:!1}},yaxis:{show:!1},states:{hover:{filter:{type:"none"}},active:{filter:{type:"none"}}},responsive:[{breakpoint:1441,options:{plotOptions:{bar:{columnWidth:"50%"}}}},{breakpoint:1025,options:{plotOptions:{bar:{columnWidth:"55%"}}}},{breakpoint:992,options:{plotOptions:{bar:{columnWidth:"40%"}}}},{breakpoint:768,options:{plotOptions:{bar:{columnWidth:"28%"}}}},{breakpoint:577,options:{plotOptions:{bar:{columnWidth:"35%"}}}},{breakpoint:426,options:{plotOptions:{bar:{columnWidth:"50%"}}}}]};typeof C!==void 0&&C!==null&&new ApexCharts(C,Y).render();var k=$(".datatables-crm");k.length&&(k=k.DataTable({ajax:assetsPath+"json/table-dashboards.json",dom:"t",columns:[{data:"id"},{data:"name"},{data:"email"},{data:"role"},{data:"status"}],columnDefs:[{targets:0,searchable:!1,visible:!1},{targets:1,render:function(e,r,n,x){var t=n.image,o=n.name,z=n.username,v;if(t)var v='<img src="'+assetsPath+"img/avatars/"+t+'" alt="Avatar" class="rounded-circle">';else{var L=Math.floor(Math.random()*6),P=["success","danger","warning","info","dark","primary","secondary"],M=P[L],o=n.name,f=o.match(/\b\w/g)||[];f=((f.shift()||"")+(f.pop()||"")).toUpperCase(),v='<span class="avatar-initial rounded-circle bg-label-'+M+'">'+f+"</span>"}var B='<div class="d-flex justify-content-start align-items-center user-name"><div class="avatar-wrapper"><div class="avatar avatar-sm me-3">'+v+'</div></div><div class="d-flex flex-column"><span class="name text-truncate h6 mb-0">'+o+'</span><small class="user_name text-truncate">@'+z+"</small></div></div>";return B}},{targets:-2,render:function(e,r,n,x){var t=n.role,o={Admin:{icon:"ri-vip-crown-line",class:"primary"},Editor:{icon:"ri-edit-box-line",class:"warning"},Author:{icon:"ri-computer-line",class:"danger"},Maintainer:{icon:"ri-pie-chart-2-line",class:"info"},Subscriber:{icon:"ri-user-line",class:"success"}};return typeof o[t]>"u"?e:'<span class="d-flex align-items-center gap-2 text-heading"><i class="'+o[t].icon+" ri-22px text-"+o[t].class+'"></i>'+t+"</span>"}},{targets:-1,render:function(e,r,n,x){var t=n.status,o={1:{title:"Pending",class:"bg-label-warning"},2:{title:"Active",class:" bg-label-success"},3:{title:"Inactive",class:" bg-label-secondary"}};return typeof o[t]>"u"?e:'<span class="badge rounded-pill '+o[t].class+'">'+o[t].title+"</span>"}}],order:[[0,"asc"]]}))})();