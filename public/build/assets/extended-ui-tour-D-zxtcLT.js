(function(){const n=document.querySelector("#shepherd-example");function c(t){const e="btn btn-sm btn-outline-secondary md-btn-flat waves-effect",a="btn btn-sm btn-primary btn-next waves-effect waves-light";return t.addStep({title:"Navbar",text:"This is your navbar",attachTo:{element:".navbar",on:"bottom"},buttons:[{action:t.cancel,classes:e,text:"Skip"},{text:"Next",classes:a,action:t.next}]}),t.addStep({title:"Card",text:"This is a card",attachTo:{element:".tour-card",on:"top"},buttons:[{text:"Skip",classes:e,action:t.cancel},{text:"Back",classes:e,action:t.back},{text:"Next",classes:a,action:t.next}]}),t.addStep({title:"Footer",text:"This is the Footer",attachTo:{element:".footer",on:"top"},buttons:[{text:"Skip",classes:e,action:t.cancel},{text:"Back",classes:e,action:t.back},{text:"Next",classes:a,action:t.next}]}),t.addStep({title:"Upgrade",text:"Click here to upgrade plan",attachTo:{element:".footer-link",on:"top"},buttons:[{text:"Back",classes:e,action:t.back},{text:"Finish",classes:a,action:t.cancel}]}),t}n&&(n.onclick=function(){const t=new Shepherd.Tour({defaultStepOptions:{scrollTo:!1,cancelIcon:{enabled:!0}},useModalOverlay:!0});c(t).start()});const s=document.querySelector("#shepherd-docs-example");function o(t){const e="btn btn-sm btn-label-secondary md-btn-flat waves-effect",a="btn btn-sm btn-primary btn-next waves-effect waves-light";return t.addStep({title:"Navbar",text:"This is your navbar",attachTo:{element:".navbar",on:"bottom"},buttons:[{action:t.cancel,classes:e,text:"Skip"},{text:"Next",classes:a,action:t.next}]}),t.addStep({title:"Footer",text:"This is the Footer",attachTo:{element:".footer",on:"top"},buttons:[{text:"Skip",classes:e,action:t.cancel},{text:"Back",classes:e,action:t.back},{text:"Next",classes:a,action:t.next}]}),t.addStep({title:"Social Link",text:"Click here share on social media",attachTo:{element:".footer-link",on:"top"},buttons:[{text:"Back",classes:e,action:t.back},{text:"Finish",classes:a,action:t.cancel}]}),t}s&&(s.onclick=function(){const t=new Shepherd.Tour({defaultStepOptions:{scrollTo:!1,cancelIcon:{enabled:!0}},useModalOverlay:!0});o(t).start()})})();