$.ajaxSetup({headers:{"X-CSRF-TOKEN":$('meta[name="csrf-token"]').attr("content")}});document.addEventListener("DOMContentLoaded",function(){let c=!1;function r(e){console.log(`Starting Quiz for Section ID: ${e}`);const t=document.getElementById(`section-card-${e}`),o=document.getElementById(`question-card-${e}`);t?t.style.display="none":console.error(`Section card not found for Section ID: ${e}`),o?(o.style.display="block",i(e,"next")):console.error(`Question card not found for Section ID: ${e}`)}function a(e){if(c){console.log("Transition already in progress, skipping...");return}console.log(`showNextSection called for Section ID: ${e}`),c=!0;const t=Array.from(document.querySelectorAll('.card[id^="section-card-"]'));let o=t.findIndex(s=>s.id===`section-card-${e}`);if(o===-1){console.error(`Section with ID ${e} not found!`),c=!1;return}if(console.log(`Hiding current section (ID: ${e})`),t[o].style.display="none",o+1<t.length){const s=t[o+1];console.log(`Displaying next section (ID: ${s.id})`);const n=s.id.split("-").pop();console.log(`Next Section ID: ${n}`),s.style.display="block";const l=document.getElementById(`start-quiz-btn-${n}`);l&&(l.style.display="block",l.onclick=function(){r(n)}),c=!1}else console.log("No more sections. Quiz completed!"),f(),c=!1}function i(e,t){const o=document.querySelector(`#questions-container-${e}`);if(!o){console.error(`Questions container not found for Section ID: ${e}`);return}const s=o.querySelectorAll(".question");if(console.log(`Found questions for Section ID ${e}:`,s),s.length===0){console.error(`No questions found for Section ID: ${e}`);return}let n=Array.from(s).findIndex(l=>l.style.display==="block");n===-1&&(n=0),t==="next"&&n<s.length-1?n++:t==="prev"&&n>0&&n--,s.forEach(l=>l.style.display="none"),n>=0&&(s[n].style.display="block"),u(e,n,s.length)}function u(e,t,o){console.log(`Toggling buttons for Section: ${e}, Current Question Index: ${t}`);const s=document.getElementById(`prev-btn${e}`),n=document.getElementById(`next-btn${e}`);s.style.display=t===0?"none":"inline-block",t===o-1?(n.textContent="Finish Section",n.onclick=function(){d(e)}):(n.textContent="Next",n.onclick=function(){i(e,"next")},n.style.display="inline-block")}function d(e){console.log(`Finishing Section ID: ${e}`);const t=document.getElementById(`section-card-${e}`),o=document.getElementById(`question-card-${e}`);o.style.display="none",t.style.display="block",a(e)}function f(){const e=document.getElementById("completion-card");e&&(console.log("Displaying completion card..."),e.style.display="block")}document.querySelectorAll('input[type="date"]').forEach(e=>{e.addEventListener("change",function(){const t=this.value;console.log(`Date selected for Question: ${this.name} - ${t}`)})}),document.querySelectorAll(".rating .star").forEach(e=>{e.addEventListener("click",function(){const t=this.closest(".rating").dataset.questionId,o=this.dataset.index;document.querySelector(`#selectedRating_${t}`).value=o,m(t,o)})});function y(e,t){document.querySelectorAll(`#rating_${e} .star`).forEach((s,n)=>{n<t?s.style.color="gold":s.style.color="#ccc"})}function g(e){const t=document.querySelectorAll(`#rating_${e} .star`),o=parseInt(document.querySelector(`#selectedRating_${e}`).value);t.forEach((s,n)=>{n<o?s.style.color="gold":s.style.color="#ccc"})}function m(e,t){document.querySelectorAll(`#rating_${e} .star`).forEach((s,n)=>{s.style.color=n<t?"gold":"#ccc"})}document.querySelectorAll(".star").forEach(e=>{const t=e.parentElement.id.split("_")[1];e.addEventListener("mouseover",function(){const o=parseInt(e.getAttribute("data-index"));y(t,o)}),e.addEventListener("mouseout",function(){g(t)})}),window.startQuiz=r,window.showQuestion=i,window.finishSection=d,window.showNextSection=a});