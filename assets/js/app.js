/* ScholarX UI. Progressive enhancement only: no API or form submission interception. */
(() => {
'use strict';
const path = location.pathname;
const parts = path.split('/').filter(Boolean);
const viewIndex = parts.indexOf('views');
if (viewIndex < 0) return;
const base = '/' + parts.slice(0, viewIndex).join('/');
const section = parts[viewIndex + 1];
const page = parts.at(-1).toLowerCase();
const role = section === 'research' ? 'supervisor' : section;
const reducedMotion = matchMedia('(prefers-reduced-motion: reduce)');
const icons = {
 dashboard:'M3 3h7v7H3z M14 3h7v7h-7z M3 14h7v7H3z M14 14h7v7h-7z',
 users:'M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2 M17 4a4 4 0 0 1 0 8 M22 21v-2a4 4 0 0 0-3-4 M9 3a4 4 0 1 0 0 8 4 4 0 0 0 0-8',
 research:'M4 19V5a2 2 0 0 1 2-2h14v18H6a2 2 0 0 1 0-4h14 M9 7h6 M9 11h4',
 activity:'M3 12h4l3-8 4 16 3-8h4',
 bell:'M18 8a6 6 0 0 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9 M10 21h4',
 project:'M3 7h7l2-3h9v16H3z',
 document:'M6 3h8l4 4v14H6z M14 3v5h4 M9 12h6 M9 16h6',
 flag:'M5 21V3 M5 3h14l-3 4 3 4H5',
 feedback:'M21 3H3v14h5l4 4v-4h9z M7 8h10 M7 12h6',
 logout:'M9 4H4v16h5 M10 12h11 M17 8l4 4-4 4',
 search:'M10 3a7 7 0 1 0 0 14 7 7 0 0 0 0-14 M15 15l6 6',
 menu:'M4 6h16 M4 12h16 M4 18h16',
 sun:'M12 8a4 4 0 1 0 0 8 4 4 0 0 0 0-8 M12 2v2 M12 20v2 M2 12h2 M20 12h2 M5 5l1 1 M18 18l1 1 M5 19l1-1 M18 6l1-1',
 chevron:'M9 5l7 7-7 7',
 close:'M6 6l12 12 M18 6L6 18'
};
const icon = name => `<svg class="sx-icon" viewBox="0 0 24 24" aria-hidden="true"><path d="${icons[name] || icons.document}"/></svg>`;
const iconFor = label => /dashboard/i.test(label)?'dashboard':/user|team|member/i.test(label)?'users':/opportunit|research/i.test(label)?'research':/activit/i.test(label)?'activity':/announcement|notification/i.test(label)?'bell':/milestone/i.test(label)?'flag':/feedback/i.test(label)?'feedback':/project|department/i.test(label)?'project':/logout/i.test(label)?'logout':'document';
const el = (tag, cls, html) => {const x=document.createElement(tag);if(cls)x.className=cls;if(html)x.innerHTML=html;return x;};
const brand = `<img src="${base}/assets/images/scholarx-mark.svg" alt="" width="37" height="37"><span>Scholar<em>X</em></span>`;
const nav = {
 admin:[
  ["Dashboard","/ScholarX/views/admin/dashboard.php"],
  ["Manage Users","/ScholarX/views/admin/users.php"],
  ["Activities","/ScholarX/views/admin/activities.php"],
  ["Research Opportunities","/ScholarX/views/admin/research.php"],
  ["Announcements","/ScholarX/views/admin/announcements.php"],
  ["Logout","/ScholarX/views/auth/logout.php"]
 ],
 coordinator:[
  ["Dashboard","/ScholarX/views/coordinator/dashboard.php"],
  ["Research Projects","/ScholarX/views/coordinator/projects.php"],
  ["Departments","/ScholarX/views/coordinator/departments.php"],
  ["Announcements","/ScholarX/views/coordinator/announcements.php"],
  ["Logout","/ScholarX/views/auth/logout.php"]
 ],
 supervisor:[
  ["Dashboard","/ScholarX/views/supervisor/dashboard.php"],
  ["Create Opportunity","/ScholarX/views/research/create.php"],
  ["Research Opportunities","/ScholarX/views/research/manage.php"],
  ["Applications","/ScholarX/views/supervisor/applications.php"],
  ["Teams","/ScholarX/views/supervisor/teams.php"],
  ["Projects","/ScholarX/views/supervisor/projects.php"],
  ["Milestones","/ScholarX/views/supervisor/milestones.php"],
  ["Feedback","/ScholarX/views/supervisor/feedback.php"],
  ["Proposals","/ScholarX/views/supervisor/proposals.php"],
  ["Notifications","/ScholarX/views/supervisor/notifications.php"],
  ["Logout","/ScholarX/views/auth/logout.php"]
 ],
 student:[
  ["Dashboard","/ScholarX/views/student/dashboard.php"],
  ["Research Opportunities","/ScholarX/views/student/opportunities.php"],
  ["My Applications","/ScholarX/views/student/my_applications.php"],
  ["My Teams","/ScholarX/views/student/teams.php"],
  ["Milestones","/ScholarX/views/student/milestones.php"],
  ["Feedback","/ScholarX/views/student/feedbacks.php"],
  ["Submit Proposal","/ScholarX/views/student/create_proposal.php"],
  ["Announcements","/ScholarX/views/student/announcements.php"],
  ["Notifications","/ScholarX/views/student/notifications.php"],
  ["Logout","/ScholarX/views/auth/logout.php"]
 ]
};

Object.values(nav).forEach(items => items.forEach(item => item[1] = item[1].replace('/ScholarX',base)));
// Storage can be blocked in private browsing; the UI still works for this page.
try {if(localStorage.getItem('scholarx-theme') === 'dark') document.documentElement.dataset.theme='dark';} catch {}
const main=el('main','sx-main');main.id='sx-main';main.tabIndex=-1;
[...document.body.childNodes].filter(n=>n.nodeName!=='SCRIPT').forEach(n=>main.appendChild(n));
if(role==='auth') {
 document.body.classList.add('sx-auth-page');
 const layout=el('div','sx-auth-layout');
 const story=el('aside','sx-auth-story',`<a class="sx-brand" href="${base}/views/auth/login.php" aria-label="ScholarX home">${brand}</a><div class="sx-auth-story-copy"><span class="sx-eyebrow">THE NEXT CHAPTER STARTS HERE</span><h1>Great minds.<br>Shared purpose.<br><em>New possibilities.</em></h1><p>A space to connect with researchers, discover opportunities, and move ideas forward.</p></div><div class="sx-auth-art" aria-hidden="true"><img src="${base}/assets/images/scholarx-mark.svg" alt=""><span class="sx-art-dot"></span></div><div class="sx-auth-story-footer">ScholarX <span> / </span> University Research Portal</div>`);
 main.className='sx-auth-card';
 const heading=main.querySelector('h2');
 if(heading){heading.textContent=page==='register.php'?'Create your account':'Welcome back';const subtitle=el('p','sx-auth-subtitle');subtitle.textContent=page==='register.php'?'Your next research collaboration starts here.':'Sign in to your research workspace.';heading.after(subtitle);}
 main.querySelectorAll(':scope>p').forEach(p=>{if(!p.textContent.trim())p.remove();else if(!p.classList.contains('sx-auth-subtitle')){p.classList.add('sx-message');p.setAttribute('role','status');}});
 const right=el('div','sx-auth-right');right.append(main);layout.append(story,right);document.body.append(layout);
 const kicker=el('div','sx-auth-kicker','CONNECT. DISCOVER. COLLABORATE.');main.append(kicker);
 enhance(main);return;
}
if(!nav[role]){document.body.append(main);enhance(main);return;}
document.body.classList.add('sx-app',`sx-role-${role}`);
const isDashboard=page==='dashboard.php';if(isDashboard)document.body.classList.add('sx-dashboard');
const title=role[0].toUpperCase()+role.slice(1);
const currentLabel=nav[role].find(([,href])=>href.toLowerCase()===path.toLowerCase())?.[0] || document.title.replace(/\s*-?\s*ScholarX\s*-?\s*/ig,'').trim() || 'Workspace';
const skip=el('a','sx-skip','Skip to content');skip.href='#sx-main';
const sidebar=el('aside','sx-sidebar');sidebar.id='sx-navigation';sidebar.setAttribute('aria-label','Workspace navigation');
sidebar.innerHTML=`<a class="sx-brand" href="${base}/views/${role}/dashboard.php" aria-label="ScholarX dashboard">${brand}</a><div class="sx-workspace"><span class="sx-workspace-badge">${icon('research')}</span><div><strong>${title} workspace</strong><small>University Research Portal</small></div></div><div class="sx-sidebar-title">WORKSPACE</div>`;
const navigation=el('nav','sx-nav');navigation.setAttribute('aria-label','Main');
nav[role].filter(([label])=>label!=='Logout').forEach(([label,href])=>{
 const a=el('a','',`${icon(iconFor(label))}<span>${label}</span>`);a.href=href;
 if(path.toLowerCase()===href.toLowerCase()){a.classList.add('active');a.setAttribute('aria-current','page');}navigation.append(a);
});
sidebar.append(navigation,el('div','sx-sidebar-bottom',`<div class="sx-sidebar-note"><strong>Ideas grow together.</strong>Your research. A shared future.</div><a class="sx-signout" href="${base}/views/auth/logout.php">${icon('logout')}<span>Sign out</span></a>`));
const top=el('header','sx-topbar',`<button type="button" class="sx-icon-button sx-menu-btn" aria-label="Open navigation" aria-expanded="false" aria-controls="sx-navigation">${icon('menu')}</button><div class="sx-breadcrumb"><span>Workspace</span>${icon('chevron')}<strong></strong></div><div class="sx-top-tools"><button type="button" class="sx-search-trigger" aria-label="Find a page">${icon('search')}<span>Find a page</span><kbd>Ctrl K</kbd></button><button type="button" class="sx-icon-button sx-theme" aria-label="Toggle dark theme" aria-pressed="false">${icon('sun')}</button><span class="sx-role">${title}</span><span class="sx-avatar" aria-hidden="true">${title[0]}</span></div>`);
top.querySelector('.sx-breadcrumb strong').textContent=currentLabel;
const overlay=el('button','sx-overlay');overlay.type='button';overlay.tabIndex=-1;overlay.setAttribute('aria-label','Close navigation');
document.body.append(skip,sidebar,overlay,top,main);
const menu=top.querySelector('.sx-menu-btn');
const mobile=matchMedia('(max-width:900px)');
function setMenu(open,restore=true){document.body.classList.toggle('sx-menu-open',open);menu.setAttribute('aria-expanded',String(open));menu.setAttribute('aria-label',open?'Close navigation':'Open navigation');sidebar.inert=mobile.matches&&!open;main.inert=mobile.matches&&open;top.inert=mobile.matches&&open;if(open)sidebar.querySelector('a').focus();else if(restore)menu.focus();}
menu.addEventListener('click',()=>setMenu(true));overlay.addEventListener('click',()=>setMenu(false));
mobile.addEventListener('change',()=>setMenu(false,false));setMenu(false,false);
document.addEventListener('keydown',e=>{
 if(!document.body.classList.contains('sx-menu-open'))return;
 if(e.key==='Escape'){setMenu(false);return;}
 if(e.key==='Tab'){const links=[...sidebar.querySelectorAll('a')];if(e.shiftKey&&document.activeElement===links[0]){e.preventDefault();links.at(-1).focus();}else if(!e.shiftKey&&document.activeElement===links.at(-1)){e.preventDefault();links[0].focus();}}
});
const theme=top.querySelector('.sx-theme');
function themeState(){theme.setAttribute('aria-pressed',String(document.documentElement.dataset.theme==='dark'));}
themeState();theme.addEventListener('click',()=>{const next=document.documentElement.dataset.theme==='dark'?'light':'dark';document.documentElement.dataset.theme=next;try{localStorage.setItem('scholarx-theme',next);}catch{}themeState();});
// Search is explicitly navigation search, not a pretend database search.
const dialog=el('dialog','sx-palette',`<div class="sx-palette-head">${icon('search')}<input type="search" aria-label="Search workspace pages" placeholder="Where would you like to go?"><button type="button" class="sx-icon-button" aria-label="Close page search">${icon('close')}</button></div><nav class="sx-palette-results" aria-label="Matching pages"></nav><p class="sx-palette-hint">Search workspace pages · Tab to select · Esc to close</p>`);
dialog.setAttribute('aria-label','Find a page');document.body.append(dialog);
dialog.addEventListener('keydown',e=>{if(e.key==='Escape'){e.preventDefault();dialog.close();}});
const query=dialog.querySelector('input'),results=dialog.querySelector('nav');
function showResults(){results.replaceChildren();const matches=nav[role].filter(([label])=>label!=='Logout'&&label.toLowerCase().includes(query.value.toLowerCase().trim()));matches.forEach(([label,href])=>{const a=el('a','',icon(iconFor(label)));a.append(document.createTextNode(label));a.href=href;results.append(a);});if(!matches.length)results.append(el('p','','No matching pages. Try “research” or “dashboard”.'));}
function openSearch(){query.value='';showResults();dialog.showModal();query.focus();}
top.querySelector('.sx-search-trigger').addEventListener('click',openSearch);dialog.querySelector('button').addEventListener('click',()=>dialog.close());query.addEventListener('input',showResults);
query.addEventListener('keydown',e=>{if(e.key==='ArrowDown'){e.preventDefault();results.querySelector('a')?.focus();}if(e.key==='Enter'){const a=results.querySelectorAll('a');if(a.length===1)a[0].click();}});
dialog.addEventListener('click',e=>{if(e.target===dialog){const r=dialog.getBoundingClientRect();if(e.clientX<r.left||e.clientX>r.right||e.clientY<r.top||e.clientY>r.bottom)dialog.close();}});
document.addEventListener('keydown',e=>{if((e.ctrlKey||e.metaKey)&&e.key.toLowerCase()==='k'){e.preventDefault();if(dialog.open)dialog.close();else openSearch();}});
if(isDashboard){
 const intro=el('div','sx-page-intro','<h2>Workspace overview</h2>');const date=el('time');date.dateTime=new Date().toISOString().slice(0,10);date.textContent=new Intl.DateTimeFormat(undefined,{weekday:'short',day:'numeric',month:'short',year:'numeric'}).format(new Date());intro.append(date);main.prepend(intro);
 if(!main.querySelector('.sx-dashboard-hero')){
  const heading=main.querySelector('h1');if(heading){const hero=el('section','sx-dashboard-hero');const content=el('div','sx-hero-content',`<span class="sx-eyebrow">${title.toUpperCase()} WORKSPACE</span>`);heading.before(hero);content.append(heading);const p=hero.nextElementSibling;if(p?.tagName==='P')content.append(p);hero.append(content,el('div','sx-hero-decoration','<div class="sx-orb"></div><div class="sx-orb sx-orb-two"></div><div class="sx-grid-pattern"></div>'));}
 }
 main.querySelectorAll(':scope>ul>li>a').forEach(a=>a.insertAdjacentHTML('afterbegin',icon(iconFor(a.textContent))));
}
main.querySelectorAll('.sx-hero-decoration').forEach(x=>x.setAttribute('aria-hidden','true'));
main.append(el('footer','sx-footer','<span>ScholarX · University Research Portal</span><span>A space for ideas to become discoveries.</span>'));
enhance(main);
function enhance(root){
 // Associate the original labels without touching server field names.
 root.querySelectorAll('form').forEach((form,n)=>{
  form.querySelectorAll('label').forEach((label,i)=>{if(label.htmlFor||label.querySelector('input,select,textarea'))return;let next=label.nextElementSibling;while(next&&next.tagName==='BR')next=next.nextElementSibling;if(next?.matches('input,select,textarea')){if(!next.id)next.id=`sx-field-${n}-${i}`;label.htmlFor=next.id;}});
  if(form.querySelector('input[name="search"]')){form.classList.add('sx-search-form');form.querySelector('input[name="search"]').setAttribute('aria-label','Search name or email');}
 });
 root.querySelectorAll('input[type="email"]').forEach(x=>x.autocomplete='email');
 root.querySelectorAll('input[type="password"]').forEach((input,i)=>{
  input.autocomplete=page==='register.php'?'new-password':'current-password';if(!input.id)input.id=`sx-password-${i}`;
  const wrap=el('div','sx-password');input.before(wrap);wrap.append(input);const button=el('button','','Show');button.type='button';button.setAttribute('aria-controls',input.id);button.setAttribute('aria-label','Show password');button.setAttribute('aria-pressed','false');wrap.append(button);
  button.addEventListener('click',()=>{const show=input.type==='password';input.type=show?'text':'password';button.textContent=show?'Hide':'Show';button.setAttribute('aria-label',show?'Hide password':'Show password');button.setAttribute('aria-pressed',String(show));});
 });
 root.querySelectorAll('a').forEach(a=>{const t=a.textContent.trim().toLowerCase();if(t.startsWith('← back')||t.includes('back to dashboard'))a.classList.add('sx-back-link');if(t==='delete'||t==='remove'){a.classList.add('sx-danger');if(!a.hasAttribute('onclick'))a.addEventListener('click',e=>{if(!confirm('Are you sure you want to '+t+' this item?'))e.preventDefault();});}});
 root.querySelectorAll('table').forEach((table,i)=>{const wrap=el('div','sx-table-wrap');wrap.tabIndex=0;wrap.setAttribute('role','region');wrap.setAttribute('aria-label',`Scrollable data table ${i+1}`);table.before(wrap);wrap.append(table);table.querySelectorAll('th').forEach(th=>{if(!th.hasAttribute('scope'))th.scope='col';});table.querySelectorAll('td').forEach(td=>{if(td.querySelectorAll('a').length>1)td.classList.add('sx-cell-actions');});});
 const status={approved:'success',accepted:'success',active:'success',completed:'success',open:'success',read:'neutral',rejected:'danger',inactive:'danger',closed:'neutral',pending:'warning',submitted:'warning','in progress':'info',unread:'info',reviewed:'neutral'};
 root.querySelectorAll('td').forEach(td=>{if(td.children.length)return;const value=td.textContent.trim();if(status[value.toLowerCase()]){const badge=el('span',`sx-status sx-status-${status[value.toLowerCase()]}`);badge.textContent=value;td.replaceChildren(badge);}});
 if(!reducedMotion.matches){root.querySelectorAll('.sx-dashboard-hero,.sx-stat-card,.sx-action-card,.sx-auth-subtitle,form,.sx-table-wrap').forEach((item,i)=>{item.style.setProperty('--delay',`${Math.min(i*45,240)}ms`);item.classList.add('sx-enter');});
 // Animate only explicitly designated metrics, never IDs, dates, or table values.
 root.querySelectorAll('.sx-stat-number').forEach(item=>{const value=item.textContent.trim();if(!/^\d+$/.test(value))return;const end=Number(value);if(!Number.isSafeInteger(end))return;const start=performance.now();function tick(now){const p=Math.min((now-start)/650,1);item.textContent=String(Math.round(end*(1-Math.pow(1-p,3))));if(p<1)requestAnimationFrame(tick);}requestAnimationFrame(tick);});}
}
})();
